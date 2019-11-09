<?php

/*
  |--------------------------------------------------------------------------
  | Restaurant Panel Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling all resturant functions like
  | masters, all other resturant activities
  |
 */

namespace App\Http\Controllers;

//************* All Included References*****************//
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\User;
use App\Models\FoodType;
use Intervention\Image\ImageManager;
use App\Models\Offers;
use App\Models\OfferCodes;
use App\Models\Restaurant;
use App\Models\RestaurantImages;
use App\Models\RestaurantMenu;
use App\Models\UserOffers;
use App\Models\UnsubscribeRequests;
use App\Models\Notifications;
use View;
use Hash;

//********************* Start Class ****************//
class RestaurantController extends Controller {

    //****************** declare all common varible for all referenced models**************// 
    protected $newData = [];
    protected $userdata, $foodType, $offers, $offerCodes, $rest, $restimages, $restmenu, $notifications,
            $userOffers, $unsubscribeRequests;

    //****************** declare contructor for admin controller **************// 

    public function __construct(\Illuminate\Routing\Redirector $redirecor) {
        //****************** define all common varible for all referenced models**************// 

        $this->user = new User;
        $this->foodType = new FoodType;
        $this->offers = new Offers;
        $this->offerCodes = new OfferCodes;
        $this->rest = new Restaurant;
        $this->restimages = new RestaurantImages;
        $this->restmenu = new RestaurantMenu;
        $this->userOffers = new UserOffers;
        $this->unsubscribeRequests = new UnsubscribeRequests;
        $this->notifications = new Notifications;

        $allOffer = Offers::where('status', '1')->get()->toArray();
        foreach ($allOffer as $offer) {
            $data = [];
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['status'] = 0;
            $this->userOffers->update_expired($data, $offer['time_limit']);
        }

        //****************** check if user is logged in as resturant or not  **************// 

        if (Auth::check() && Auth::user()->role == 'Restaurant') {
            $analytic = $this->user->get_counts_resturants(Auth::user()->uniqueid);
            view()->composer('layouts.resturant_layout', function($view) use ($analytic) {
                $view->with('analytic', $analytic);
            });
        } else {
            $redirecor->route('home')->send();
            die();
        }
    }

    protected $rules = [
    ];
    protected $messages = [
    ];

    //****************** function to show dashboard data **************// 

    public function home() {
        $analytic = $this->user->get_counts_resturants(Auth::user()->uniqueid);
        $offersall = $this->user->get_useroffer_month(Auth::user()->uniqueid);
        $offer_all = $this->userOffers->getAll_resturants(Auth::user()->uniqueid, 'Pending'
                , date('Y-m-1'), date('Y-m-d'));
        return view('resturant.home')->with('analytic', $analytic)
                        ->with('offersall', $offersall)
                        ->with('offer_all', $offer_all);
    }

    //****************** function to show Unsubscribe data **************// 
    public function unsubscribe() {
        $resturant_all = $this->unsubscribeRequests->getAll_rest(Auth::user()->uniqueid);
        return view('resturant.unsubscribe')->with('resturant_all', $resturant_all);
    }

    public function unsubscribe_post() {
        $this->newData['request_status'] = 'Pending';
        $this->newData['username'] = Auth::user()->uniqueid;
        $this->newData['reason'] = Input::get('reason');
        $this->newData['created_at'] = date('Y-m-d H:i');
        $this->newData['createdby'] = Auth::user()->uniqueid;
        $this->newData['updated_at'] = date('Y-m-d');
        $response = $this->unsubscribeRequests->create_entry($this->newData);

        $notify = [];
        $notify['username'] = 'admin';
        $notify['notification'] = Auth::user()->name . ' ' . Auth::user()->last_name . ' post request for unsubscribe ';
        $notify['notifyurl'] = "/admin/resturant/" . Auth::user()->uniqueid;
        $notify['createdby'] = Auth::user()->uniqueid;
        $notify['updated_at'] = date('Y-m-d H:i:s');
        $notify['created_at'] = date('Y-m-d H:i:s');
        $notify['status'] = 1;

        $this->notifications->create_entry($notify);

        return redirect()->route('rest_unsubscribe')->with('message', 'Request for unsubscribe is sent.');
    }

    //open view for change password
    public function change_pwd() {
        return view('resturant.change_pwd');
    }

    public function resturant_credential_rules(array $data) {
        $messages = [
            'oldpassword.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
            'password.same' => "Password doesn't match.",
            'password_confirmation.same' => "Password doesn't match.",
        ];

        $validator = Validator::make($data, [
                    'oldpassword' => 'required',
                    'password' => 'required|same:password',
                    'password_confirmation' => 'required|same:password',
                        ], $messages);

        return $validator;
    }

    //post request for change password and update in db
    public function change_pwdpost() {
        if (Auth::Check()) {
            $validator = $this->resturant_credential_rules(Input::all());
            if ($validator->fails()) {
                return redirect()->route('resturant_change_pwd')->withInput()->withErrors($validator);
            } else {
                $current_password = Auth::User()->password;
                if (Hash::check(Input::get('oldpassword'), $current_password)) {
                    $password = bcrypt(Input::get('password'));
                    $this->newData['password'] = $password;
                    $email = Auth::user()->uniqueid;

                    // call to the model
                    $users = new User;

                    $users->update_pwd($email, $this->newData);
                    return redirect()->route('resturant_home')->with('message', 'Password has been reset successfully.');
                } else {
                    return redirect()->route('resturant_change_pwd')->with('error', 'Your old password is not correct.');
                }
            }
        } else {
            return redirect()->to('/resturant');
        }
    }

    //****************** function to show Restaurant and option to add/edit **************// 

    public function resturant_add($uniqueid = null) {
        $foodtype_all = $this->foodType->getAll();
        $resturant = $this->user;
        $countries = $this->user->getcountries();
        $states = $this->user->getstates($countries[0]->id);
        $action = 'create';
        $resturant_all = $this->user->get_resturant(Auth::user()->uniqueid);
        if ($uniqueid != null) {
            $resturant = $this->user->get_resturant(Auth::user()->uniqueid)[0];
            $states = $this->user->getstates($resturant->country);
            $action = 'edit';
        }
        return view('resturant.resturant')->with('foodtypes_all', $foodtype_all)->with('resturant', $resturant)
                        ->with('action', $action)->with('countries', $countries)->with('states', $states)
                        ->with('resturant_all', $resturant_all);
    }

    //****************** Validator for Offer Codes Data **************// 

    protected $messages_resturant = [
        'email.unique' => 'User already exists',
        'email.required' => 'E-Mail is required'
    ];

    //****************** Add/edit resturants Data **************// 
    public function resturant_add_post($uniqueid = null) {
        $uniqueid = Auth::user()->uniqueid;
        if ($uniqueid != null) {
            $this->rules_resturant = [
                'email' => 'required|unique:users,email,null,null,id,:id'
            ];
        }
        $validator = Validator::make(Input::all(), $this->rules_resturant, $this->messages_resturant);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect()->route('rest_add')->withInput()->withErrors($validator);
        } else {
            $food_types = "";
            foreach (Input::get('food_types') as $key => $value) {
                $food_types .= Input::get('food_types')[$key] . ',';
            }
            if ($food_types == "")
                return redirect()->route('rest_add')->withInput()->with('error', 'Food Types is required');

            $this->newData['name'] = Input::get('rest_name');
            $this->newData['working_hours_from'] = Input::get('working_hours_from');
            $this->newData['working_hours_to'] = Input::get('working_hours_to');

            $this->newData['food_types'] = $food_types;
            $this->newData['website'] = Input::get('website');
            $this->newData['contact_no'] = Input::get('contact_no');
            $this->newData['more_info'] = Input::get('more_info');
            $this->newData['notes'] = Input::get('notes');
            $this->newData['star_rating'] = Input::get('star_rating');
            $this->newData['email'] = Input::get('rest_email');
            $this->newData['updated_at'] = date('Y-m-d');


            $userData = [];

            $userData['name'] = Input::get('name');
            $userData['last_name'] = Input::get('last_name');
            $userData['phone'] = Input::get('phone');
            $userData['building'] = Input::get('building');
            $userData['street'] = Input::get('street');
            $userData['state'] = Input::get('state');
            $userData['country'] = Input::get('country');
            $userData['pincode'] = Input::get('pincode');
            $userData['city'] = Input::get('city');
            $userData['updated_at'] = date('Y-m-d');

            $filename = "";

            $uid = sha1(Input::get('rest_name') . date("c")); //create unique id
            $unique = (strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
            if ($uniqueid != null) {
                $unique = $uniqueid;
            }

            if (Input::hasFile('image')) {
                $manager = new ImageManager();
                $filename = $unique . ".jpg";
                $image = $manager->make(Input::file('image'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename));
                $userData['image'] = $filename;
            }
            $filename = "";
            if (Input::hasFile('coverimage')) {
                $manager = new ImageManager();
                $filename = $unique . "_cover.jpg";
                $image = $manager->make(Input::file('coverimage'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename));
                $this->newData['coverimage'] = $filename;
            }
            $response = $this->rest->update_entry($this->newData, $uniqueid);
            $response = $this->user->update_entry($userData, $uniqueid);

            // send back to the page with success message
            return redirect()->route('rest_add')->with('message', 'Restaurant information Updated successfully.');
        }
    }

    //****************** function to show Restaurant images and option to add/edit **************// 

    public function resturantimages_add($uniqueid = null) {
        $resturant = $this->restimages;
        $action = 'create';
        $resturant_all = $this->restimages->getAll_rest(Auth::user()->uniqueid);
        if ($uniqueid != null) {
            $resturant = $this->restimages->get_id($uniqueid);
            $action = 'edit';
        }
        return view('resturant.resturantimages')->with('resturant', $resturant)
                        ->with('action', $action)
                        ->with('resturant_all', $resturant_all);
    }

    //****************** Add/edit resturants images Data **************// 
    public function resturantimages_add_post($uniqueid = null) {
        if (Input::hasFile('image_path')) {
            $filename = "";
            $uid = sha1(Auth::user()->uniqueid . date("c")); //create unique id
            $filename = (strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
            $filename = $filename . ".jpg";

            $this->newData['username'] = Auth::user()->uniqueid;
            $this->newData['image_type'] = Input::get('image_type');
            $this->newData['image_path'] = $filename;
            $this->newData['display_order'] = Input::get('display_order');
            $this->newData['updated_at'] = date('Y-m-d');

            $manager = new ImageManager();
            $image = $manager->make(Input::file('image_path'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename));
            if ($uniqueid == null) {

                $this->newData['createdby'] = Auth::user()->uniqueid;
                $this->newData['created_at'] = date('Y-m-d');
                $response = $this->restimages->create_entry($this->newData);
            } else {
                $response = $this->restimages->update_entry($this->newData, $uniqueid);
            }
        }
        // send back to the page with success message
        return redirect()->route('rest_images_add')->with('message', 'Restaurant information saved successfully.');
    }

    //****************** function to delete Images **************// 

    public function resturantimages_delete($uniqueid) {
        $response = $this->restimages->delete_entry($uniqueid);

        return redirect()->route('rest_images_add')->with('message', 'Image Deleted.');
    }

    //****************** function to show Restaurant Menu and option to add/edit **************// 

    public function resturant_menu_add($uniqueid = null) {
        $resturant = $this->restmenu;
        $action = 'create';
        $resturant_all = $this->restmenu->getAll_rest(Auth::user()->uniqueid);
        $offers_all = $this->offers->getAll();
        if ($uniqueid != null) {
            $resturant = $this->restmenu->get_id($uniqueid);
            $action = 'edit';
        }
        return view('resturant.resturantmenu')->with('resturant', $resturant)
                        ->with('action', $action)->with('offers_all', $offers_all)
                        ->with('resturant_all', $resturant_all);
    }

    //****************** Add/edit resturants menu Data **************// 
    public function resturant_menu_add_post($uniqueid = null) {

        $this->newData['username'] = Auth::user()->uniqueid;
        $this->newData['item_name'] = Input::get('item_name');
        $this->newData['price'] = Input::get('price');
        $this->newData['description'] = Input::get('description');
        $this->newData['offer_id'] = Input::get('offer_id');
        if (Input::get('popular_item'))
            $this->newData['popular_item'] = 1;
        else
            $this->newData['popular_item'] = 0;
        $this->newData['display_order'] = Input::get('display_order');
        $this->newData['updated_at'] = date('Y-m-d');
        if (Input::hasFile('image')) {
            $filename = "";
            $uid = sha1(Auth::user()->uniqueid . date("c")); //create unique id
            $filename = (strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
            $filename = $filename . ".jpg";

            $manager = new ImageManager();
            $image = $manager->make(Input::file('image'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename));
            $this->newData['image'] = $filename;
        }
        if ($uniqueid == null) {
            if ($this->restmenu->check_menuitem(trim($request['item_name']), $request['username']) == 0) {
                $this->newData['createdby'] = Auth::user()->uniqueid;
                $this->newData['created_at'] = date('Y-m-d');
                $this->newData['status'] = 1;
                $response = $this->restmenu->create_entry($this->newData);
            } else
                return redirect()->route('rest_menu_add')->with('message', 'Menu Item already exists.')->withInput();
        }
        else {
            $response = $this->restmenu->update_entry($this->newData, $uniqueid);
        }

        // send back to the page with success message
        return redirect()->route('rest_menu_add')->with('message', 'Restaurant Menu information saved successfully.');
    }

    //****************** function to delete Images **************// 

    public function resturant_menu_delete($uniqueid) {

        $this->newData['status'] = 0;
        $this->newData['updated_at'] = date('Y-m-d');
        $response = $this->restmenu->update_entry($this->newData, $uniqueid);

        return redirect()->route('rest_menu_add')->with('message', 'Menu Item Deleted.');
    }

    //****************** function to show Restaurant's purchased offers **************// 

    public function useroffers($view = null, Request $request) {
        if ($view == 'trans')
            $view = 'resturant.offerhistory';
        else
            $view = 'resturant.offerlist';

        if (count($request->all()) > 0) {
            $offer_all = $this->userOffers->getAll_resturants(Auth::user()->uniqueid, $request['status']
                    , $request['date_from'], $request['date_to']);
            return view($view)->with('status', $request['status'])
                            ->with('date_from', $request['date_from'])->with('date_to', $request['date_to'])->with('offer_all', $offer_all);
        }
        $offer_all = $this->userOffers->getAll_resturants(Auth::user()->uniqueid, null, date('Y-m-1'), date('Y-m-t'));
        return view($view)->with('status', '')
                        ->with('date_from', date('1-m-Y'))->with('date_to', date('t-m-Y'))->with('offer_all', $offer_all);
    }

    //****************** function to Redeem Offer **************// 

    public function useroffers_redeem($uniqueid) {
        $time_left = $this->userOffers->check_offerredeem($uniqueid);
        if ($time_left <= 0) {
            $this->newData['redeem_by'] = Auth::user()->uniqueid;
            $this->newData['updated_at'] = date('Y-m-d H:i:s');
            $this->newData['redeem_at'] = date('Y-m-d H:i:s');
            $response = $this->userOffers->update_entry($this->newData, $uniqueid);

            $offersdetails = $this->userOffers->get_id($uniqueid);

            $userdata = $this->user->getUserData_uniqueid($offersdetails->username);

            $restdata = $this->rest->get_id(Auth::user()->uniqueid);


            $notify = [];
            $notify['username'] = $offersdetails->username;
            $notify['notification'] = 'Coupon with code "' . $offersdetails['offer_code'] . '" Redeemed Successfully in ' . $restdata->name;
            $notify['notifyurl'] = "#";
            $notify['createdby'] = Auth::user()->uniqueid;
            $notify['updated_at'] = date('Y-m-d H:i:s');
            $notify['created_at'] = date('Y-m-d H:i:s');
            $notify['status'] = 1;

            $this->notifications->create_entry($notify);

            $notify = [];
            $notify['username'] = 'admin';
            $notify['notification'] = 'Coupon with code "' . $offersdetails['offer_code'] . '" Redeemed by ' . $userdata->name . ' ' . $userdata->last_name . ' for '
                    . $restdata->name;
            $notify['notifyurl'] = "/admin/useroffer?username=" . Auth::user()->uniqueid;
            $notify['createdby'] = Auth::user()->uniqueid;
            $notify['updated_at'] = date('Y-m-d H:i:s');
            $notify['created_at'] = date('Y-m-d H:i:s');
            $notify['status'] = 1;

            $this->notifications->create_entry($notify);
            return redirect()->route('rest_useroffers', ['list'])->with('message', 'Offer marked as redeemed.');
        } else
            return redirect()->route('rest_useroffers', ['list'])->with('message', "Offer can be redeemed after " . intval($time_left / 60) . 'H:' . $time_left % 60 . "M .");
    }

    //function to show list of notifications
    public function notifications_all() {
        $notification = $this->notifications->getAll(Auth::user()->uniqueid);
        return view('resturant.notifications')->with('notifications', $notification);
    }

    //****************** Show States list **************// 
    public function ajaxStates(Request $request) {
        $statesall = "";
        $statesall .= '<option value="">Select</option>';
        $states = $this->user->getstates($request['country']);

        foreach ($states as $state) {
            $statesall .= '<option value="' . $state->name . '">' . $state->name . '</option>';
        }
        echo $statesall;
    }

}
