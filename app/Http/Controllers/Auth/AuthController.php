<?php

namespace App\Http\Controllers\Auth;

use Session;
use Mail;
use DB;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    private $redirectTo = '/expoter';
    protected $loginPath = '/login'; 
    protected $redirectAfterLogout = '/login';
   
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
                 
        $this->middleware($this->guestMiddleware(), ['except' =>  ['logout', 'getLogout']]);
        if(Auth::check())
        { 
            if(Auth::user()->role=='Restaurant')
               $this->redirectTo = '/resturant';
            else if(Auth::user()->role=='User')
               $this->redirectTo = '/';
            else
               $this->redirectTo = '/admin';
        }
    }

    

    
     /**
     * Authenticate user on post login request
     *
     * if user did not complete his/her registeration then he/she will resume from last step
     */

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            // valid address
           $credentials = ['email' => $request->email, 'password' => $request->password,'status'=>'1'];
        }
        else
        {
              return response()->json(['error'=>'Please fill a vaild E-Mail.'],404); 
        }
        if (Auth::attempt($credentials, $request->has('remember')))
        {
            Session::put('role',Auth::user()->role);
            Auth::user()->last_login = date('Y-m-d H:i');
            Auth::user()->save();
         
            if(Auth::user()->role=='Restaurant')
            {
              if(Auth::user()->approval_status=='Pending')
              {
                  $link="  <a href='".url('/')."/resend/".Auth::user()->uniqueid."'>Send again</a>";
                  \Auth::logout(); 
                   return response()->json(['error'=>'Please activate your account first using link mailed on your registered email. '.$link],404);
              }
              else
                return response()->json(['link' => '/resturant'], 200);
            }
            else if(Auth::user()->role=='Importer'){
              if(Auth::user()->approval_status=='Pending')
                {
                    $link="  <a href='".url('/')."/resend/".Auth::user()->uniqueid."'>Send again</a>";
                    \Auth::logout(); 
                    return response()->json(['error'=>'Please activate your account first using link mailed on your registered email. '.$link],404);
                }
                else
                  return response()->json(['link' => '/'], 200);
            }
            else
              return response()->json(['link' => '/admin'], 200);
        }
        return response()->json(['errors' => $this->getFailedLoginMessage()], 404);
    }
 
    
    /**
     * Check user already exists in database or not before register
     *
     */

    public function checkuser(Request $request)
    {
        $user=new User();
        if(count($user->checkuser($request['email']))>0)
        {
            return 1;
        }
        return 0;
    }

     /**
     * Logout User from Account
     *
     */
    public function getLogout(){
    if(Auth::check()){
        if(Auth::user()->role==Session::get('role')){
                Auth::user()->logout_time = date('Y-m-d H:i');
                Auth::user()->save();
          }
        }
        \Auth::logout();
        \Session::flush();
        return redirect()->route('login');
    }

    

}
