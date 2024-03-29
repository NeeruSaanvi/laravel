<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Models\OfferCodes;
use Mail;
use Auth;
use App\Models\Resturant;
use DB;
use App\Models\FoodType;
use App\Models\Offers;
use App\Models\ResturantImages;
use App\Models\UserOffers;
use Config;
use App\Models\UnsubscribeRequests;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public $user,$restimages,$userOffers,$unsubscribeRequests;
    public function __construct()
    {
        $this->user=new User;
        $this->restimages=new ResturantImages;
     	$this->userOffers=new UserOffers;
	    $this->unsubscribeRequests=new UnsubscribeRequests;
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	 
	/**
     * User Home Page View.
     *
     */ 
    public function faq()
    {	
        return view('user.faq');
    }
	/**
     * User Home Page View.
     *
     */ 
    public function works()
    {	
        return view('user.works');
    }
	/**
     * User Home Page View.
     *
     */ 
    public function who_we_are()
    {	
        return view('user.who_we_are');
    }


	/**
     * User Register Step One View.
     *
     */ 
    public function registerStepOne()
    {
		$allOffer = OfferCodes::where('status','1')->get()->toArray();	
		$setting = DB::table('settings')->select('subscription_price')->where('createdby','admin')->get();
		
        return view('user.registerStepOne')->with('allOffer', $allOffer)->with('setting', $setting);
    }
	
	/**
     * User Register Step Two View.
     *
     */
	public function registerStepTwo(Request $request)
    {
		$allOffer = Offers::where('status','1')->get()->toArray();	
		if($request->session()->has('register-step-one')){
			$setting = DB::table('settings')->select('subscription_price')->where('createdby','admin')->get();
			return view('user.registerStepTwo')->with('setting', $setting)->with('allOffer', $allOffer);
		}
		else{
			return redirect('user-register-step-1');
		}	
    }
	
	/**
     * User Register Step One Submit Process Validation.
     *
     */
	public function registerStepOneSubmitValidator($data)
    {
		return Validator::make($data, [
				'offer_code' => 'required|max:255',
				'name' => 'required|max:255',
				'last_name' => 'required|max:255',
				'email' => 'required|email|max:255|unique:users',
				'password' => 'required|min:6|confirmed',
				'password_confirmation' => 'required|min:6',
				'phone' => 'required|digits:10'
				
			],[
			'offer_code.required'=>'Referral Code is required',
			'name.required'=>'First Name is required',
			'last_name.required'=>'Last Name is required',
			'email.required'=>'Email is required',
			'email.email'=>'Email invalid format',
			'email.max'=>'Email is max 255 character',
			'email.unique'=>'Email is already register',
			'password.required'=>'Password is required',
			'password.min'=>'Password should be more than 6 character.',
			'phone.required'=>'Phone is required'
			]);
	}	
		
	/**
     * User Register Step One Submit Process.
     *
     */
	public function registerStepOneSubmit(Request $request)
    {
		$data = $request->all();
		
		$validator = $this->registerStepOneSubmitValidator($data);
		
		if($validator->fails()){
			$eror = $validator->errors()->toArray();	
			return redirect('user-register-step-1')
                        ->withErrors($eror)
                        ->withInput();
		}
		else{
			
			$uid=sha1($request->name.date("c"));//create unique id
            $unique=(strlen($uid) > 20) ? substr($uid, 0, 20) : ($uid);
				
			$user = new User;
			
			$user->name = $request->name;
			$user->uniqueid = $unique;
			$user->last_name = $request->last_name;
			$user->offer_code = $request->offer_code;
			$user->three_code = $request->three_code;
			if($request->has('newsletter')){
				$user->newsletter = $request->newsletter;
			}
			else{
				$user->newsletter = 0;
			}
			$user->phone = $request->phone;
			$user->email = $request->email;
			$user->role = 'User';
			$user->password = bcrypt($request->password);
			$user->save();
			
			$request->session()->put('register-step-one',$user->id);
			$request->session()->put('user-pass',$request->password);
			
			$msg="Congratulations! Your account has been successfully created <br> Your details are below:<br>
                <br>
                Email : <b>".$request->email."</b><br>
				Password : <b>".$request->password."</b>
                <br>";
			
			$email = $request->email;			
			Mail::send([], ['email' => $request->email,'msg' => $msg], function ($message) use ($email,$msg) {
               $message->from('info@sellinship.com', 'Club Sip &amp; Savour');
               $message->to($email)
              ->subject("Successfully Joined Website")
              // here comes what you want
              ->setBody($msg, 'text/html'); // for HTML rich messages
          });
		  
			return redirect('user-register-step-2');
			
		}
    }
	
	/**
     * User Register Step Two Submit Process.
     *
     */
	public function registerStepTwoSubmit(Request $request)
    {
		if($request->session()->has('register-step-one')){
			$data = $request->all();
			
			$user = User::find($request->session()->get('register-step-one'));
			
			$user->work_status = $request->work_status;
			$user->work_type = $request->work_type;
			$user->dine_out = $request->dine_out;
			$user->offer_like = $request->offer_like;
			$user->save();
			
			return redirect('user-register-step-3');
		}
		else{
			return redirect('user-register-step-1');
		}
		
    }
	
	/**
     * User Register Step Three View.
     *
     */ 
    public function registerStepThree()
    {	
		$countries = DB::table('countries')->select('id','name')->get();
		$state = DB::table('states')->select('id','name')->get();
        return view('user.registerStepThree')->with('countries',$countries)->with('statess',$state);
    }
	
	/**
     * User Register Step Three Submit Process Validation.
     *
     */
	public function registerStepThreeSubmitValidator($data)
    {
		return Validator::make($data, [
				'street_address' => 'required|max:255',
				'city' => 'required|max:255',
				'country' => 'required|max:255',
				'state' => 'required|max:255',
				'zip_code' => 'required|min:6',
				'card_number' => 'required|numeric',
				'exp_date' => 'required|date_format:m/Y',
				'name_of_card' => 'required',
				'cvv' => 'required|numeric'
				
			],[
			'street_address.required'=>'Street Address is required',
			'city.required'=>'City is required',
			'country.required'=>'Country is required',
			'state.required'=>'State is required',
			'zip_code.required'=>'Zip code is required',
			'zip_code.min'=>'Zip code should be more than 6 character.',
			'card_number.required'=>'Card number is required',
			'card_number.numeric'=>'Card number must be numeric',
			'exp_date.required'=>'Exp date is required',
			'exp_date.date_format'=>'Exp date is invalid',
			'name_of_card.required'=>'Name of card is required',
			'cvv.required'=>'Name of card is required',
			'cvv.numeric'=>'CVV must be numeric'
			]);
	}
	
	/**
     * User Register Step Three Submit Process.
     *
     */
	public function registerStepThreeSubmit(Request $request)
    {
		if($request->session()->has('register-step-one')){
			$data = $request->all();
			
			$validator = $this->registerStepThreeSubmitValidator($data);
		
			if($validator->fails()){
				$eror = $validator->errors()->toArray();	
				return redirect('user-register-step-3')
							->withErrors($eror)
							->withInput();
			}
			else{
				$data = $request->all();
				
				$user = User::find($request->session()->get('register-step-one'));
				
				$user->street = $request->apt_suite;
				$user->city = $request->city;
				$user->country = $request->country;
				$user->state = $request->state ;
				$user->pincode = $request->zip_code;
				$user->building = $request->street_address;
				$user->status = 1;
				$user->save();
				
				$credentials = ['email' => $user->email, 'password' => $request->session()->get('user-pass'),'status'=>'1'];
				
				if (Auth::attempt($credentials, $request->has('remember')))
				{
					$request->session()->put('role',Auth::user()->role);
					Auth::user()->last_login = date('Y-m-d H:i');
					Auth::user()->save();
				 
					$request->session()->forget('register-step-one');
					$request->session()->forget('user-pass');
					return redirect('/browse');
					
				}
				//$request->session()->put('success', 'User has been successfully created.');
			}
		}
		else{
			return redirect('user-register-step-1');
		}
		
    }
	
	/**
     * User Home Page View.
     *
     */ 
    public function index()
    {	
        return view('user.index');
    }

    //****************** function to show dashboard data **************// 

    public function home()
    {
        $analytic=$this->user->get_counts_user(Auth::user()->uniqueid);
        $offersall=$this->user->get_restoffer_month(Auth::user()->uniqueid);
        $offer_all=$this->userOffers->getAll_users(Auth::user()->uniqueid,'Pending'
            ,date('Y-m-1'),date('Y-m-d')); 
        return view('user.home')->with('analytic',$analytic)
        ->with('offersall',$offersall)
        ->with('offer_all',$offer_all);
    }


	
	/**
     * User browse restaurant view.
     *
     */ 
    public function browse()
    {	
    	if(Auth::check())
    	{
		$allRestaurant =$this->user->getAll_resturants();
		foreach ($allRestaurant as $rest) {
			$rest->images=$this->restimages->getAll_rest($rest->username);
		}
		$allFoodType = FoodType::where('status','1')->get()->toArray();
        return view('user.browse')->with('allResturant',$allResturant)->with('allFoodType',$allFoodType);
    	}
    	else{
    		return redirect('user-register-step-1');
		}

    }
	
	public function rest_detail($uniqueid)
    {	
		if(Auth::check())
    	{
		$allOffer = Offers::where('status','1')->get()->toArray();	
		$allRestaurant =$this->user->get_resturant($uniqueid);
	    $allimages=$this->restimages->getAll_rest($uniqueid);
      	return view('user.rest_detail')->with('allResturant',$allResturant)->with('allimages',$allimages)
      	->with('allOffer',$allOffer);
    	}
    	else{
    		return redirect('user-register-step-1');
		}
	}

    public function browseall()
    {	
		$allRestaurant =$this->user->getAll_resturants();
		foreach($allRestaurant as $resturant){
			$resturant->images=$this->restimages->getAll_rest($resturant->username);
			$str.='<div class="one-resto">
				<div class="col-md-4 col-sm-12">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<img src="'.Config::get('images.user_images').$resturant->image.'" alt="restourant" class="img-responsive">
						</div>
						<div class="col-md-8 col-sm-8">
							<h3><a href="/rest_detail/'.$resturant->username.'">'.$resturant->rest_name.' </a></h3>
							<h5>'.$resturant->building.', '.$resturant->street.'</br>  '.$resturant->city.' - '.$resturant->pincode.',
							</h5>
					
							<span class="stars">'. $resturant->star_rating .'</span>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-md-offset-1">
					<div class="row">
						<div class="responsive">';
						if(isset($resturant->images) && count($resturant->images)>0)
						{	
						 	$i=0; 
							foreach($resturant->images as $image){
								if($image->image_type=='gallery')
								{
								$i=$i+1;
							$str.='<div class="col-md-3 col-sm-3">
								<img src="'. Config::get('images.user_images').$image->image_path .'" alt="slide" class="img-responsive">';
								if($i==4)
									$str.='<a href="/rest_detail/'.$resturant->username.'" class="more">View More</a>';
								
							$str.='</div>';
							}
							if($i==4)
								break;
							}
						}
						$str.='</div>
					</div>
				</div>
			</div>';
			}
		echo $str;
    
	}
	 public function restcount()
    {	
		$allRestaurant =$this->user->getAll_resturants();
		echo "Showing all ".count($allResturant) ." restaurants";
    }

	/**
     * User browse restaurant view.
     *
     */ 
    public function browsefilter(Request $request)
    {	
		$data = $request->all();
		
		$allRestaurant =$this->user->getAll_resturants();
		$allResturant=json_decode(json_encode($allResturant), true);
		if($data['type'] == 'foodtype'){
			if($data['foodFilter']!="")
			$allRestaurant =array_filter($allResturant, function($v) use($data) { return $v['food_types'] == $data['foodFilter']; });
		}
		if($data['type'] == 'zipCode'){
			if($data['zipCode']!="")
				$allRestaurant =array_filter($allResturant, function($v) use($data) { return $v['pincode'] == $data['zipCode']; });
		}
		$str="";
		$allResturant=json_decode(json_encode($allResturant));
		if(count($allResturant)>0)
		{
			 $irest=0; 
		foreach($allRestaurant as $resturant){
			 $irest++; 
			if($irest>10)
			 break; 
			$resturant->images=$this->restimages->getAll_rest($resturant->username);
			$str.='<div class="one-resto">
				<div class="col-md-4 col-sm-12">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<img src="'.Config::get('images.user_images').$resturant->image.'" alt="restourant" class="img-responsive">
						</div>
						<div class="col-md-8 col-sm-8">
							<h3><a href="/rest_detail/'.$resturant->username.'">'.$resturant->rest_name.' </a></h3>
							<h5>'.$resturant->building.', '.$resturant->street.'</br>  '.$resturant->city.' - '.$resturant->pincode.',
							</h5>
					
							<span class="stars">'. $resturant->star_rating .'</span>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-12 col-md-offset-1">
					<div class="row">
						<div class="responsive">';
						if(isset($resturant->images) && count($resturant->images)>0)
						{	
						 	$i=0; 
							foreach($resturant->images as $image){
								if($image->image_type=='gallery')
								{
								$i=$i+1;
							$str.='<div class="col-md-3 col-sm-3">
								<img src="'. Config::get('images.user_images').$image->image_path .'" alt="slide" class="img-responsive">';
								if($i==4)
									$str.='<a href="/rest_detail/'.$resturant->username.'" class="more">View More</a>';
								
							$str.='</div>';
							}
							if($i==4)
								break;
							}
						}
						$str.='</div>
					</div>
				</div>
			</div>';
			}
		}
		echo $str;
    }
	
	
	/**
     * User profile Section.
     *
     */
	
	/**
     * User user profile view.
     *
     */
	public function userProfile()
    {	
		$allOffer = Offers::where('status','1')->get()->toArray();	
		$userDetail = User::where('id',Auth::user()->id)->get()->toArray();
		$countries = DB::table('countries')->select('id','name')->get();
		$state = DB::table('states')->where('country_id',$userDetail[0]['country'])->select('id','name')->get();
        return view('user.profile')->with('userDetail',$userDetail)->with('countries',$countries)->with('statess',$state)
        ->with('allOffer',$allOffer);
    }
	
	
	/**
     * User Profile Update Validation Wihout Password.
     *
     */
	public function userProfileWithoutPasswordValidator($data)
    {
		return Validator::make($data, [
				'name' => 'required|max:255',
				'last_name' => 'required|max:255',
				'phone' => 'required|digits:10',
				'street_address' => 'required|max:255',
				'city' => 'required|max:255',
				'country' => 'required|max:255',
				'state' => 'required|max:255',
				'zip_code' => 'required|min:6'
				
			],[
			'name.required'=>'First Name is required',
			'last_name.required'=>'Last Name is required',
			'phone.required'=>'Phone is required',
			'street_address.required'=>'Street Address is required',
			'city.required'=>'City is required',
			'country.required'=>'Country is required',
			'state.required'=>'State is required',
			'zip_code.required'=>'Zip code is required',
			'zip_code.min'=>'Zip code should be more than 6 character.'
			]);
			
	}
	
	/**
     * User Profile Update Validation Wihout Password.
     *
     */
	public function userProfileWithPasswordValidator($data)
    {
			return Validator::make($data, [
				'name' => 'required|max:255',
				'last_name' => 'required|max:255',
				'password' => 'required|min:6|confirmed',
				'password_confirmation' => 'required|min:6',
				'phone' => 'required|digits:10',
				'street_address' => 'required|max:255',
				'city' => 'required|max:255',
				'country' => 'required|max:255',
				'state' => 'required|max:255',
				'zip_code' => 'required|min:6'
				
			],[
			'name.required'=>'First Name is required',
			'last_name.required'=>'Last Name is required',
			'password.required'=>'Password is required',
			'password.min'=>'Password should be more than 6 character.',
			'phone.required'=>'Phone is required',
			'street_address.required'=>'Street Address is required',
			'city.required'=>'City is required',
			'country.required'=>'Country is required',
			'state.required'=>'State is required',
			'zip_code.required'=>'Zip code is required',
			'zip_code.min'=>'Zip code should be more than 6 character.'
			]);
	}
	
	/**
     * User user profile update.
     *
     */
	public function userProfileUpdate(Request $request)
    {	
		$data = $request->all();
		$userId = Auth::user()->id;
		
		if($request->password == ""){
			$validator = $this->userProfileWithoutPasswordValidator($data);
		}
		else{
			$validator = $this->userProfileWithPasswordValidator($data);
		}
		
		if($validator->fails()){
			$eror = $validator->errors()->toArray();	
			return redirect('user-profile')
						->withErrors($eror)
						->withInput();
		}
			
		if($request->password == ""){
			$user = User::find($userId);
			$user->name = $request->name;
			$user->last_name = $request->last_name;
			if($request->has('newsletter')){
				$user->newsletter = $request->newsletter;
			}
			else{
				$user->newsletter = 0;
			}
			$user->phone = $request->phone;
				
			$user->work_status = $request->work_status;
			$user->work_type = $request->work_type;
			$user->dine_out = $request->dine_out;
			$user->offer_like = $request->offer_like;
			$user->street = $request->apt_suite;
			$user->city = $request->city;
			$user->country = $request->country;
			$user->state = $request->state ;
			$user->pincode = $request->zip_code;
			$user->building = $request->street_address;
			$user->save();
		}
		else{
			$user = User::find($userId);
			$user->name = $request->name;
			$user->password = bcrypt($request->password);	
			$user->last_name = $request->last_name;
			if($request->has('newsletter')){
				$user->newsletter = $request->newsletter;
			}
			else{
				$user->newsletter = 0;
			}
			$user->phone = $request->phone;
				
			$user->work_status = $request->work_status;
			$user->work_type = $request->work_type;
			$user->dine_out = $request->dine_out;
			$user->offer_like = $request->offer_like;
			$user->street = $request->apt_suite;
			$user->city = $request->city;
			$user->country = $request->country;
			$user->state = $request->state ;
			$user->pincode = $request->zip_code;
			$user->building = $request->street_address;
			$user->save();
			
		}
		
		$request->session()->put('success', 'User Profile has been successfully updated.');
		
		return redirect('user-profile');
    }
	
	
   //****************** Show States list **************// 
    public function ajaxStates(Request $request)
    {
       $statesall="";
       $statesall.='<option value="">Select</option>';
       $states = DB::table('states')->where('country_id',$request['country'])->select('id','name')->get();
          
        foreach($states as $state)
        {
            $statesall.='<option value="'.$state->name.'">'.$state->name.'</option>';
        }
        echo $statesall;
    }

    public function chose_offer($uniqueid,$restid)
    {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < 8; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	   	$newData=[];
    	$newData['username']=Auth::user()->uniqueid;
    	$newData['offer_id']=$uniqueid;
    	$newData['resturant']=$restid;
  		$newData['purchase_at']=date('Y-m-d H:i:s');
    	$newData['offer_code']=$randomString;
	  $newData['createdby']=Auth::user()->uniqueid;
      $newData['created_at']=date('Y-m-d H:i:s');
      $newData['status']=1;
      $this->userOffers->create_entry($newData);
	    return redirect()->route('rest_details',[$restid])->with('message','Coupon saved in your list')
	    ->with('coupon',$randomString)->with('offerid',$uniqueid);
                
    }
	
	public function restoffer()
    {
          $offer_all=$this->userOffers->getAll_users(Auth::user()->uniqueid,'Active');
         return view('user.coupon_list')->with('offer_all',$offer_all);
   
    }

	public function restoffer_used()
    {
          $offer_all=$this->userOffers->getAll_users(Auth::user()->uniqueid,'Used');
         return view('user.coupon_history')->with('offer_all',$offer_all);
   
    }

  
  	//open view for change password
    public function change_pwd()
    {
          return view('user.change_pwd');
    }

    public function credential_rules(array $data)
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
        $validator = $this->credential_rules(Input::all());
        if($validator->fails())
        {
          return redirect()->route('user_change_pwd')->withInput()->withErrors($validator);
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
             return redirect()->route('user_home')->with('message','Password has been reset successfully.');
          }
          else
          {           
            return redirect()->route('user_change_pwd')->with('error','Your old password is not correct.');
          }
        }        
      }
      else
      {
        return redirect()->to('/user');
      }   
    }
	
	 //****************** function to show Unsubscribe data **************// 
    public function unsubscribe()
    {
       $user_all=$this->unsubscribeRequests->get_id(Auth::user()->uniqueid);     
        return view('user.unsubscribe')->with('user_all',$user_all);
    }
    
    public function unsubscribe_post()
    {
        $this->newData['request_status']='Pending';
        $this->newData['username']=Auth::user()->uniqueid;
        $this->newData['reason']=Input::get('reason');
        $this->newData['created_at']=date('Y-m-d H:i');
        $this->newData['createdby']=Auth::user()->uniqueid;
        $this->newData['updated_at']=date('Y-m-d');
        $response=$this->unsubscribeRequests->create_entry($this->newData);
       
        return redirect()->route('user_unsubscribe')->with('message','Request for unsubscribe is sent.');
    }
 
	//****************** function to show user's purchased offers **************// 
    
    public function couponall(Request $request)
    {
        if(count($request->all())>0)
        {
          $offer_all=$this->userOffers->getAll_users(Auth::user()->uniqueid,$request['status']
            ,$request['date_from'],$request['date_to']);
         return view('user.userofferhistory')->with('status',$request['status'])->with('date_from',$request['date_from'])->with('date_to',$request['date_to'])->with('offer_all',$offer_all);
   
        }
        $offer_all=$this->userOffers->getAll_users(Auth::user()->uniqueid,null,date('Y-m-1'),date('Y-m-t'));
        return view('user.userofferhistory')->with('status','')->with('date_from',date('1-m-Y'))->with('date_to',date('t-m-Y'))->with('offer_all',$offer_all);
    }

 	
}
