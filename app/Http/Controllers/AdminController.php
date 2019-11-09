<?php
    /*
    |--------------------------------------------------------------------------
    | Admin Panel Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling all admin functions like
    | masters, all other admin activities
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
class AdminController extends Controller
{
	//****************** declare all common varible for all referenced models**************// 
	  protected $newData = [];
    protected $userdata,$foodType,$offers,$offerCodes,$rest,$restimages,$restmenu,$notifications,
    $userOffers,$unsubscribeRequests;
  
  //****************** declare contructor for admin controller **************// 

    public function __construct(\Illuminate\Routing\Redirector $redirecor)
    {
   	   //****************** define all common varible for all referenced models**************// 

        $this->user = new User;
        $this->foodType = new FoodType;
        $this->offers = new Offers;
        $this->offerCodes = new OfferCodes;
        $this->rest = new Restaurant;
        $this->restimages=new RestaurantImages;
        $this->restmenu=new RestaurantMenu;
        $this->userOffers=new UserOffers;
        $this->unsubscribeRequests=new UnsubscribeRequests;
        $this->notifications = new Notifications;
    
        $allOffer = Offers::where('status','1')->get()->toArray();  
    
        foreach ($allOffer as $offer) {
          $data=[];
          $data['status']=0;
          $data['updated_at']=date('Y-m-d H:i:s');
          $this->userOffers->update_expired($data,$offer['time_limit']);
        }
        //****************** check if user is logged in as admin/staff or not  **************// 

        if(Auth::check() && Auth::user()->role!='Restaurant' && Auth::user()->role!='User')
        {
        }
        else{
         	$redirecor->route('home')->send() ;
        	die();
        }
        $rightsall="all";
         $analytic=$this->user->get_counts_admin();
         view()->composer('layouts.admin_layout', function($view) use ($rightsall,$analytic)
         {
             $view->with('rightsall', $rightsall)->with('analytic', $analytic);
         });
        
    }

    protected $rules = [
    ];

    protected $messages = [
       
    ];


    //****************** function to show dashboard data **************// 

    public function home()
    {
         $analytic=$this->user->get_counts_admin();
        $userrest=$this->user->get_userrest_month();
        $resturantsub_all=$this->unsubscribeRequests->getAll('Pending');     
        $resturant_all=$this->user->getAll_resturants('1');     
        $users_all=$this->user->getAll_user_list();     
        return view('admin.home')->with('resturantsub_all',$resturantsub_all)->with('analytic',$analytic)
        ->with('userrest',$userrest)->with('resturant_all',$resturant_all)->with('users_all',$users_all);
    }
   
    public function unsubscribe_rest($uniqueid)
    {
        $this->newData['request_status']='Approved';
        $this->newData['username']=$uniqueid;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->unsubscribeRequests->update_entry($this->newData,$uniqueid);
        
        $this->newData['status']=1;
        $this->newData['uniqueid']=$uniqueid;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->user->update_entry($this->newData,$uniqueid);

        $userdata=$this->user->getUserData_uniqueid($uniqueid);
        $email=$userdata->email;
        if($userdata->role=='User')
         $msg='Your request for unsubscribe is approved by Club Sip &amp; Savour admin. Now you are no longer to use website services.';
       
        else
        $msg='Your request for unsubscribe is approved by Club Sip &amp; Savour admin. Now your resturnat is removed from listing on website.';
        $subject="Account unsubscribe";
        Mail::send([], ['email' => $email,'msg' => $msg,'subject'=>$subject], function ($message) use ($email,$msg,$subject) {
             $message->from('alpha@sellnship.com', 'Club Sip &amp; Savour');
             $message->to($email)
            ->subject($subject)
            // here comes what you want
            ->setBody($msg, 'text/html'); // for HTML rich messages
          });
       
        return redirect()->route('admin_home')->with('message','Request for unsubscribe is approved.');
    }

   //****************** function to delete Food Type **************// 

    public function foodtype_delete($uniqueid)
    {
        $this->newData['status']=false;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->foodType->update_entry($this->newData,$uniqueid);
       
        return redirect()->route('foodtype_add')->with('message','Food Type Deleted.');
    }

    //****************** function to show Food Type and option to add/edit **************// 
    
    public function foodtype_add($uniqueid=null)
    {
        $foodtype_all=$this->foodType->getAll();     
        $foodtype=$this->foodType;     
        $action='create';
        if($uniqueid!=null)
        {  
          $foodtype=$this->foodType->get_id($uniqueid);
          $action='edit';
        }
        return view('admin.foodtype')->with('foodtype_all',$foodtype_all)->with('foodtype',$foodtype)
          ->with('action',$action);
    }
  
 
     //****************** Validator for Food Type Data **************// 

     protected $rules_foodtype = [
          'name'=> 'required|max:50|unique:food_types,name,null,null,status,1'
     ];

    protected $messages_foodtype = [
         'name.unique' => 'Name already exists',
         'name.max' => 'Name should be less than 50 characters',
         'name.required' => 'Name is required'
    ];

  
    //****************** Add/edit Food Type Data **************// 
    public function foodtype_add_post($uniqueid=null)
    {
        if($uniqueid!=null)
        {
            $this->rules_foodtype = [
            'name'=> 'required|max:50|unique:food_types,name,null,null,id,:id'
            ];

        }
        $validator = Validator::make(Input::all(), $this->rules_foodtype, $this->messages_foodtype);
          if ($validator->fails())
          {
            // send back to the page with the input data and errors
              return redirect()->route('foodtype_add')->withInput()->withErrors($validator);
          }
          else
          {
                $this->newData['name']=Input::get('name');
                if($uniqueid==null)
                {
                  $this->newData['createdby']=Auth::user()->email;
                  $this->newData['created_at']=date('Y-m-d');
                  $this->newData['status']=1;
                }
                $this->newData['updated_at']=date('Y-m-d');
                if($uniqueid==null)
                {
                  $response=$this->foodType->create_entry($this->newData);
                }
                else{
                   $response=$this->foodType->update_entry($this->newData,$uniqueid);
                }
                if($response)
                {
                    // send back to the page with success message
                    return redirect()->route('foodtype_add')->with('message','Food Type information saved successfully.');
                        
                }
               
          }
    }

   //****************** function to delete Offers **************// 

    public function offers_delete($uniqueid)
    {
        $this->newData['status']=false;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->offers->update_entry($this->newData,$uniqueid);
       
        return redirect()->route('offers_add')->with('message','Offer Deleted.');
    }

    //****************** function to show Offer and option to add/edit **************// 
    
    public function offers_add($uniqueid=null)
    {
        $offers_all=$this->offers->getAll();     
        $offerss=$this->offers;     
        $action='create';
        if($uniqueid!=null)
        {  
          $offerss=$this->offers->get_id($uniqueid);
          $action='edit';
        }
        return view('admin.offers')->with('offers_all',$offers_all)->with('offerss',$offerss)
          ->with('action',$action);
    }
  
 
     //****************** Validator for Offer Data **************// 

     protected $rules_offers = [
          'name'=> 'required|max:50|unique:offers,name,null,null,status,1'
     ];

    protected $messages_offers = [
         'name.unique' => 'Name already exists',
         'name.max' => 'Name should be less than 50 characters',
         'name.required' => 'Name is required'
    ];

  
    //****************** Add/edit Offer Data **************// 
    public function offers_add_post($uniqueid=null)
    {
        if($uniqueid!=null)
        {
            $this->rules_offers = [
            'name'=> 'required|max:50|unique:offers,name,null,null,id,:id'
            ];

        }
        $validator = Validator::make(Input::all(), $this->rules_offers, $this->messages_offers);
          if ($validator->fails())
          {
            // send back to the page with the input data and errors
              return redirect()->route('offers_add')->withInput()->withErrors($validator);
          }
          else
          {
                $this->newData['name']=Input::get('name');
                $this->newData['description']=Input::get('description');
                $this->newData['time_limit']=Input::get('time_limit');
                $this->newData['perday']=Input::get('perday');
                if(Input::get('repurchase'))
                $this->newData['repurchase']=1;
                else
                $this->newData['repurchase']=0;
                  
                $this->newData['price']=Input::get('price');
                if($uniqueid==null)
                {
                  $this->newData['createdby']=Auth::user()->email;
                  $this->newData['created_at']=date('Y-m-d');
                  $this->newData['status']=1;
                }
                $this->newData['updated_at']=date('Y-m-d');
                if($uniqueid==null)
                {
                  $response=$this->offers->create_entry($this->newData);
                }
                else{
                   $response=$this->offers->update_entry($this->newData,$uniqueid);
                }
                if($response)
                {
                    // send back to the page with success message
                    return redirect()->route('offers_add')->with('message','Offer information saved successfully.');
                        
                }
               
          }
    }

    //open view for change password
    public function change_pwd()
    {
          return view('admin.change_pwd');
    }

    public function admin_credential_rules(array $data)
    {
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
    public function change_pwdpost()
    {
      if(Auth::Check())
      {
        $validator = $this->admin_credential_rules(Input::all());
        if($validator->fails())
        {
          return redirect()->route('admin_change_pwd')->withInput()->withErrors($validator);
        }
        else
        {  
          $current_password = Auth::User()->password;           
          if(Hash::check(Input::get('oldpassword'), $current_password))
          {           
            $password = bcrypt(Input::get('password'));
            $this->newData['password']=$password;
            $email = Auth::user()->uniqueid;

              // call to the model
              $users = new User;

              $users->update_pwd($email,$this->newData);
             return redirect()->route('admin_home')->with('message','Password has been reset successfully.');
          }
          else
          {           
            return redirect()->route('admin_change_pwd')->with('error','Your old password is not correct.');
          }
        }        
      }
      else
      {
        return redirect()->to('/admin');
      }   
    }
 
    //****************** function to delete Offer Codes **************// 

    public function offercode_delete($uniqueid)
    {
        $this->newData['status']=false;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->offerCodes->update_entry($this->newData,$uniqueid);
       
        return redirect()->route('offercode_add')->with('message','Offer Codes Deleted.');
    }

    //****************** function to show Offer Codes and option to add/edit **************// 
    
    public function offercode_add($uniqueid=null)
    {
        $offercode_all=$this->offerCodes->getAll();     
        $offercode=$this->offerCodes;     
        $action='create';
        if($uniqueid!=null)
        {  
          $offercode=$this->offerCodes->get_id($uniqueid);
          $action='edit';
        }
        return view('admin.offer_code')->with('offercode_all',$offercode_all)->with('offercode',$offercode)
          ->with('action',$action);
    }
  
 
     //****************** Validator for Offer Codes Data **************// 

     protected $rules_offercode = [
          'name'=> 'required|max:50|unique:offer_code,name,null,null,status,1'
     ];

     protected $messages_offercode = [
         'name.unique' => 'Name already exists',
         'name.max' => 'Name should be less than 50 characters',
         'name.required' => 'Name is required'
    ];

  
    //****************** Add/edit Offer Codes Data **************// 
    public function offercode_add_post($uniqueid=null)
    {
        if($uniqueid!=null)
        {
            $this->rules_offercode = [
            'name'=> 'required|max:50|unique:offer_code,name,null,null,id,:id'
            ];

        }
        $validator = Validator::make(Input::all(), $this->rules_offercode, $this->messages_offercode);
          if ($validator->fails())
          {
            // send back to the page with the input data and errors
              return redirect()->route('offercode_add')->withInput()->withErrors($validator);
          }
          else
          {
                $this->newData['name']=Input::get('name');
                $this->newData['offer_code']=Input::get('offer_code');
                if($uniqueid==null)
                {
                  $this->newData['createdby']=Auth::user()->email;
                  $this->newData['created_at']=date('Y-m-d');
                  $this->newData['status']=1;
                }
                $this->newData['updated_at']=date('Y-m-d');
                if($uniqueid==null)
                {
                  $response=$this->offerCodes->create_entry($this->newData);
                }
                else{
                   $response=$this->offerCodes->update_entry($this->newData,$uniqueid);
                }
                if($response)
                {
                    // send back to the page with success message
                    return redirect()->route('offercode_add')->with('message','Offer Codes information saved successfully.');
                        
                }
               
          }
    }

    //****************** function to show Restaurant and option to add/edit **************// 
    
    public function resturant_add($uniqueid=null)
    {
        $foodtype_all=$this->foodType->getAll();     
        $resturant=$this->user;     
        $countries=$this->user->getcountries();
        $states=$this->user->getstates($countries[0]->id);
        $action='none';
        $resturant_all=$this->user->getAll_resturants();     
        if($uniqueid!=null)
        {  
          if($uniqueid=='add')
          {
            $action='create';
          }
          else{
            $resturant=$this->user->get_resturant($uniqueid)[0];
            $states=$this->user->getstates($resturant->country);
            $action='edit';
          }
        }

        return view('admin.resturant')->with('foodtypes_all',$foodtype_all)->with('resturant',$resturant)
          ->with('action',$action)->with('countries',$countries)->with('states',$states)
          ->with('resturant_all',$resturant_all);
    }
  
    
    //****************** Add/edit resturants Data **************// 
    public function resturant_add_post($uniqueid=null)
    {
           $validator = Validator::make(Input::all(), $this->rules, $this->messages);
          if ($validator->fails())
          {
            // send back to the page with the input data and errors
              return redirect()->route('resturant_add')->withInput()->withErrors($validator);
          }
          else
          {
               $food_types="";
                foreach (Input::get('food_types') as $key => $value) {
                  $food_types.=Input::get('food_types')[$key].',';
                }
                if($food_types=="")
                    return redirect()->route('resturant_add')->withInput()->with('error','Food Types is required');
                
                $this->newData['name']=Input::get('rest_name');
                $this->newData['working_hours_from']=Input::get('working_hours_from');
                $this->newData['working_hours_to']=Input::get('working_hours_to');
                $this->newData['food_types']=$food_types;
                $this->newData['website']=Input::get('website');
                $this->newData['contact_no']=Input::get('contact_no');
                $this->newData['more_info']=Input::get('more_info');
                $this->newData['notes']=Input::get('notes');
                $this->newData['star_rating']=Input::get('star_rating');
                $this->newData['email']=Input::get('rest_email');
                $this->newData['updated_at']=date('Y-m-d');
                

                $userData=[];

                $userData['name']=Input::get('name');
                $userData['last_name']=Input::get('last_name');
                $userData['phone']=Input::get('phone');
                $userData['building']=Input::get('building');
                $userData['street']=Input::get('street');
                $userData['state']=Input::get('state');
                $userData['country']=Input::get('country');
                $userData['pincode']=Input::get('pincode');
                $userData['city']=Input::get('city');
                $userData['updated_at']=date('Y-m-d');

                $filename="";
                
                $uid=sha1(Input::get('rest_name').date("c"));//create unique id
                $unique=(strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
                if($uniqueid!=null)
                {
                  $unique=$uniqueid;
                }

                if(Input::hasFile('image'))
                {
                    $manager = new ImageManager();
                    $filename=$unique.".jpg";
                    $image = $manager->make(Input::file('image'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename ));
                    $userData['image']=$filename;
                }
                $filename="";
                if(Input::hasFile('coverimage'))
                {
                    $manager = new ImageManager();
                    $filename=$unique."_cover.jpg";
                    $image = $manager->make(Input::file('coverimage'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename ));
                   $this->newData['coverimage']=$filename;
                }
                
                if($uniqueid==null)
                {
                      
                  $this->newData['username']=$unique;
                  $this->newData['createdby']=Auth::user()->uniqueid;
                  $this->newData['created_at']=date('Y-m-d');
                  $this->newData['status']=1;
                  $response=$this->rest->create_entry($this->newData);
                  

  	              $userData['email']=Input::get('email');
  	              $userData['password']=bcrypt('123456');
  	              $userData['role']='Restaurant';
  	              $userData['last_login']=date('Y-m-d H:i:s');
                  $userData['uniqueid']=$unique;
                  $userData['createdby']=Auth::user()->uniqueid;
                  $userData['created_at']=date('Y-m-d H:i:s');
                  $userData['status']=1;
                  
                  $response=$this->user->create_entry($userData);

                  $email=Input::get('email');
                  $msg='Congratulations! Your account as a "Restaurant" with Club Sip &amp; Savour is created. Now your resturnat is listed on website.
                    <br> Your details are below:<br>
                        <br>
                        Email : <b>'.Input::get('email').'</b><br>
                Password : <b>123456</b>
                        <br>';
                    $subject="Account approved";
                    Mail::send([], ['email' => $email,'msg' => $msg,'subject'=>$subject], function ($message) use ($email,$msg,$subject) {
                         $message->from('alpha@sellnship.com', 'Club Sip &amp; Savour');
                         $message->to($email)
                        ->subject($subject)
                        // here comes what you want
                        ->setBody($msg, 'text/html'); // for HTML rich messages
                      });
     
                  
                }
                else{
                     if(Input::has('status')){
                        $userData['status'] = 1;
                      }
                      else{
                        $userData['status'] = 0;
                      }
                    
                   $response=$this->rest->update_entry($this->newData,$uniqueid);
                    $response=$this->user->update_entry($userData,$uniqueid);
                 }
                    // send back to the page with success message
                    return redirect()->route('resturant_add')->with('message','Restaurant information saved successfully.');
                
          }
    }

   //****************** function to show Restaurant images and option to add/edit **************// 
    
    public function resturantimages_add($uniqueid=null)
    {
        $resturant=$this->restimages;     
        $action='create';
        $users_all=$this->user->getAll_resturants('1');     
        $resturant_all=$this->restimages->getAll();
        if($uniqueid!=null)
        {  
          $resturant=$this->restimages->get_id($uniqueid);
          $action='edit';
        }
        return view('admin.resturantimages')->with('users_all',$users_all)->with('resturant',$resturant)
          ->with('action',$action)
          ->with('resturant_all',$resturant_all);
    }
  
 
    //****************** Add/edit resturants images Data **************// 
    public function resturantimages_add_post($uniqueid=null)
    {
                if(Input::hasFile('image_path'))
                {
                    $filename="";
                    $uid=sha1(Input::get('username').date("c"));//create unique id
                    $filename=(strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
                    $filename=$filename.".jpg";
                    
                    $this->newData['username']=Input::get('username');
                    $this->newData['image_type']=Input::get('image_type');
                    $this->newData['image_path']=$filename;
                    $this->newData['display_order']=Input::get('display_order');
                    $this->newData['updated_at']=date('Y-m-d');
                    
                    $manager = new ImageManager();
                    $image = $manager->make(Input::file('image_path'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename ));
                if($uniqueid==null)
                {
                      
                  $this->newData['createdby']=Auth::user()->uniqueid;
                  $this->newData['created_at']=date('Y-m-d');
                  $response=$this->restimages->create_entry($this->newData);
                  
                }
                else{
                   $response=$this->restimages->update_entry($this->newData,$uniqueid);
                 }
               }
                    // send back to the page with success message
                    return redirect()->route('resturant_images_add')->with('message','Restaurant information saved successfully.');
                
    }

    //****************** function to delete Images **************// 

    public function resturantimages_delete($uniqueid)
    {
        $response=$this->restimages->delete_entry($uniqueid);
       
        return redirect()->route('resturant_images_add')->with('message','Image Deleted.');
    }


   //****************** function to show Restaurant Menu and option to add/edit **************// 
    
    public function resturant_menu_add($uniqueid=null)
    {
        $resturant=$this->restmenu;     
        $action='create';
        $users_all=$this->user->getAll_resturants('1');     
        $resturant_all=$this->restmenu->getAll();
        $offers_all=$this->offers->getAll();     
        if($uniqueid!=null)
        {  
          $resturant=$this->restmenu->get_id($uniqueid);
          $action='edit';
        }
        return view('admin.resturantmenu')->with('users_all',$users_all)->with('resturant',$resturant)
          ->with('action',$action)->with('offers_all',$offers_all)
          ->with('resturant_all',$resturant_all);
    }
  
 
    //****************** Add/edit resturants menu Data **************// 
    public function resturant_menu_add_post($uniqueid=null)
    {
           
        $this->newData['username']=Input::get('username');
        $this->newData['item_name']=Input::get('item_name');
        $this->newData['price']=Input::get('price');
        $this->newData['description']=Input::get('description');
        $this->newData['offer_id']=Input::get('offer_id');
        if(Input::get('popular_item'))
        $this->newData['popular_item']=1;
        else
        $this->newData['popular_item']=0;
        $this->newData['display_order']=Input::get('display_order');
        $this->newData['updated_at']=date('Y-m-d');
        if(Input::hasFile('image'))
        {
            $filename="";
            $uid=sha1(Input::get('username').date("c"));//create unique id
            $filename=(strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
            $filename=$filename.".jpg";
            
            $manager = new ImageManager();
            $image = $manager->make(Input::file('image'))->encode('jpg')->save(base_path(Config::get('images.user_images') . $filename ));
            $this->newData['image']=$filename;
        }
        if($uniqueid==null)
        {
              
          $this->newData['createdby']=Auth::user()->uniqueid;
          $this->newData['created_at']=date('Y-m-d');
          $this->newData['status']=1;
          $response=$this->restmenu->create_entry($this->newData);
          
        }
        else{
           $response=$this->restmenu->update_entry($this->newData,$uniqueid);
         }
       
        // send back to the page with success message
        return redirect()->route('resturant_menu_add')->with('message','Restaurant Menu information saved successfully.');
                
    }

    //****************** function to delete Images **************// 

    public function resturant_menu_delete($uniqueid)
    {
     
        $this->newData['status']=0;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->restmenu->update_entry($this->newData,$uniqueid);
       
        return redirect()->route('resturant_menu_add')->with('message','Menu Item Deleted.');
    }

  //****************** function to show Restaurant's purchased offers **************// 
    
    public function useroffers(Request $request)
    {
      
        $user_all=$this->user->getAll_resturants('1');     
        if(count($request->all())>0)
        {
          $offer_all=$this->userOffers->getAll_resturants($request['username'],$request['status']
            ,$request['date_from'],$request['date_to']);
         return view('admin.offerhistory')->with('status',$request['status'])
         ->with('user_all',$user_all)->with('username',$request['username'])
          ->with('date_from',$request['date_from'])->with('date_to',$request['date_to'])->with('offer_all',$offer_all);
   
        }
        $offer_all=$this->userOffers->getAll_resturants(null,null,date('Y-m-1'),date('Y-m-t'));
        return view('admin.offerhistory')->with('status','')->with('username','')->with('user_all',$user_all)
          ->with('date_from',date('1-m-Y'))->with('date_to',date('t-m-Y'))->with('offer_all',$offer_all);
    }

  
  //****************** function to Redeem Offer **************// 
    
    public function useroffers_delete($uniqueid)
    {
        
        $this->delete_offer($uniqueid);
       
        return redirect()->route('admin_useroffers')->with('message','Offer code removed.');
    }

    public function delete_offer($uniqueid)
    {
        $this->newData['status']=0;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->userOffers->update_entry($this->newData,$uniqueid);
 
    }

 //****************** function to show Restaurant's purchased offers **************// 
    
    public function restoffer(Request $request)
    {
        $user_all=$this->user->getAll_user_list();     
        if(count($request->all())>0)
        {
          $offer_all=$this->userOffers->getAll_users($request['username'],$request['status']
            ,$request['date_from'],$request['date_to']);
         return view('admin.userofferhistory')->with('status',$request['status'])->with('username',$request['username'])
          ->with('user_all',$user_all)->with('date_from',$request['date_from'])->with('date_to',$request['date_to'])->with('offer_all',$offer_all);
   
        }
        $offer_all=$this->userOffers->getAll_users(null,null,date('Y-m-1'),date('Y-m-t'));
        return view('admin.userofferhistory')->with('status','')->with('username','')
          ->with('user_all',$user_all)->with('date_from',date('1-m-Y'))->with('date_to',date('t-m-Y'))->with('offer_all',$offer_all);
    }

  
  //****************** function to Redeem Offer **************// 
    
    public function restoffer_delete($uniqueid)
    {
     
        $this->delete_offer($uniqueid);
       
        return redirect()->route('admin_restoffer')->with('message','Offer code removed.');
    }


   //****************** function to show Restaurant's unsubsrcibe requests **************// 
    
    public function resturant_unsubscribe(Request $request)
    {
        if(count($request->all())>0)
        {
          $request_all=$this->unsubscribeRequests->getAll($request['status']
            ,$request['date_from'],$request['date_to']);
         return view('admin.rest_unsub')->with('status',$request['status'])
          ->with('date_from',$request['date_from'])->with('date_to',$request['date_to'])->with('request_all',$request_all);
   
        }
        $request_all=$this->unsubscribeRequests->getAll(null,date('Y-m-1'),date('Y-m-t'));
        return view('admin.rest_unsub')->with('status','')
          ->with('date_from',date('1-m-Y'))->with('date_to',date('t-m-Y'))->with('request_all',$request_all);
    }

    //****************** function to show newsletter subscribers list **************// 
    public function newsletter_list(Request $request)
    {  
       $usersall=$this->user->getAll_newsletter();     
        return view('admin.newsletter_list')->with('usersall',$usersall)->with('type','')
          ->with('regdate_from','')->with('regdate_to','');
      
    }

    //function to show list of notifications
    public function notifications_all()
    {
       $notification=$this->notifications->getAll(Auth::user()->uniqueid);
       return view('admin.notifications')->with('notifications',$notification);
    }

   //****************** Show States list **************// 
    public function ajaxStates(Request $request)
    {
       $statesall="";
       $statesall.='<option value="">Select</option>';
       $states=$this->user->getstates($request['country']);
       
        foreach($states as $state)
        {
            $statesall.='<option value="'.$state->name.'">'.$state->name.'</option>';
        }
        echo $statesall;
    }
  
 //****************** function to show Restaurant and option to add/edit **************// 
    
    public function users_add($uniqueid=null)
    {
        $offers_all=$this->offers->getAll();     
        $users=$this->user;     
        $countries=$this->user->getcountries();
        $states=$this->user->getstates($countries[0]->id);
        $action='none';
        $users_all=$this->user->getAll_user_list();     
        if($uniqueid!=null)
        { 
          if($uniqueid=='add')
          {
            $action='create';
          }
          else{
            $users=$this->user->getUserData_uniqueid($uniqueid);
            $states=$this->user->getstates($users->country);
            $action='edit';
          }
        }
        return view('admin.users')->with('allOffer',$offers_all)->with('users',$users)
          ->with('action',$action)->with('countries',$countries)->with('states',$states)
          ->with('users_all',$users_all);
    }
  
     //****************** Validator for Offer Codes Data **************// 

     protected $rules_users = [
          'email'=> 'required|unique:users,email,null,null,status,1'
     ];

     protected $messages_users = [
         'email.unique' => 'User already exists',
         'email.required' => 'E-Mail is required'
    ];

    //****************** Add/edit resturants Data **************// 
    public function users_add_post($uniqueid=null)
    {
        if($uniqueid!=null)
        {
            $this->rules_users = [
                'email'=> 'required|unique:users,email,null,null,id,:id'
            ];

        }
        $validator = Validator::make(Input::all(), $this->rules_users, $this->messages_users);
          if ($validator->fails())
          {
            // send back to the page with the input data and errors
              return redirect()->route('users_add')->withInput()->withErrors($validator);
          }
          else
          {
                $userData=[];

                $userData['name']=Input::get('name');
                $userData['last_name']=Input::get('last_name');
                $userData['phone']=Input::get('phone');
                $userData['building']=Input::get('building');
                $userData['street']=Input::get('street');
                $userData['state']=Input::get('state');
                $userData['country']=Input::get('country');
                $userData['pincode']=Input::get('pincode');
                $userData['city']=Input::get('city');
                $userData['updated_at']=date('Y-m-d');
                if(Input::has('newsletter')){
                  $userData['newsletter'] = 1;
                }
                else{
                  $userData['newsletter'] = 0;
                }
                $userData['work_status'] = Input::get('work_status');
                $userData['work_type'] = Input::get('work_type');
                $userData['dine_out'] = Input::get('dine_out');
                $userData['offer_like'] = Input::get('offer_like');
                $uid=sha1(Input::get('name').date("c"));//create unique id
                $unique=(strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
                if($uniqueid!=null)
                {
                  $unique=$uniqueid;
                }

                if($uniqueid==null)
                {
              
                  $userData['email']=Input::get('email');
                  $userData['password']=bcrypt('123456');
                  $userData['role']='User';
                  $userData['last_login']=date('Y-m-d H:i:s');
                  $userData['uniqueid']=$unique;
                  $userData['createdby']=Auth::user()->uniqueid;
                  $userData['created_at']=date('Y-m-d H:i:s');
                  $userData['status']=1;
                  

                  $response=$this->user->create_entry($userData);

                  $email=Input::get('email');
                  $msg='Congratulations! Your account as a "User" with Club Sip &amp; Savour is created. Now you can enjoy services.';
                    $subject="Account approved";
                    Mail::send([], ['email' => $email,'msg' => $msg,'subject'=>$subject], function ($message) use ($email,$msg,$subject) {
                         $message->from('alpha@sellnship.com', 'Club Sip &amp; Savour');
                         $message->to($email)
                        ->subject($subject)
                        // here comes what you want
                        ->setBody($msg, 'text/html'); // for HTML rich messages
                      });
     
                  
                }
                else{
                    if(Input::has('status')){
                        $userData['status'] = 1;
                      }
                      else{
                        $userData['status'] = 0;
                      }
                    $response=$this->user->update_entry($userData,$uniqueid);
                 }
                if($response)
                {
                    // send back to the page with success message
                    return redirect()->route('users_add')->with('message','User information saved successfully.');
                        
                }
               
          }
    }

}
