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
use Illuminate\Supprort\Facades\Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\User;
use App\Models\Member;
use View;
use Hash;

//********************* Start Class ****************//
class APIController extends Controller
{
	//****************** declare all common varible for all referenced models**************// 
	  protected $newData = [];
    protected  $member;
  
  //****************** declare contructor for admin controller **************// 

    public function __construct(\Illuminate\Routing\Redirector $redirecor)
    {
   	   //****************** define all common varible for all referenced models**************// 

        $this->user = new User;
        
    }

    protected $rules = [
    ];

    protected $messages = [
       
    ];
 
 

   //****************** Show country list **************// 
    public function ajaxCountry()
    {
       $countries=$this->user->getcountries();
       echo json_encode($countries);
    }
  
   
   //****************** Show States list **************// 
    public function ajaxStates()
    {
       $states=$this->user->getstates();
       echo json_encode($states);
       
    }
      
   //****************** Show city  list by state **************// 
    public function getCityByState(Request $request)
    {
       $cities=$this->user->getCityByState($request['state']);
       echo json_encode($cities);
       
    }
    
      
 

  
}
