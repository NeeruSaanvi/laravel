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

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\CommonMethods;
use App\Models\Firebase;


require getcwd() . '/vendor/autoload.php';

use DB;

//********************* Start Class ****************//
class MemberAPIController extends Controller {

    //****************** declare all common varible for all referenced models**************// 
    protected $newData = [];
    protected $userdata, $member, $common;

    //****************** declare contructor for admin controller **************// 

    public function __construct(\Illuminate\Routing\Redirector $redirecor) {
        //****************** define all common varible for all referenced models**************// 
        $this->member = new Member;
        $this->common = new CommonMethods;
        $this->firebase=new Firebase;
    }

    protected $rules = [
    ];
    protected $messages = [
    ];

    function console_log($data) {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    public function registerMember(Request $request) {

        $member = new Member();
        $existedMember = $this->member->getMemberByEmail($request['email']);

        if ($existedMember == null) {
            $member->username = $request['email'];
            $member->memberpwd = $request['password'];
            $member->memberemail = $request['email'];
            $member->stateid = $request['state'];
            $member->city = $request['city'];
            $member->countryid = 1; //
            $member->usphoneno = $request['phone'];
            $member->memberfirstname = $request['name'];
            $member->memberlastname = $request['lastname'];
            $member->DOB = date('Y-m-d', strtotime(str_replace('-', '/', $request['DOB'])));
            $member->gender = $request['gender'];
            $member->IsNewsLetter = $request['newsletter'];
            $member->IsEmailVerified = 0;
            if ($request['condition']) {
                $member->IsConditionCheck = 1;
            } else {
                $member->IsConditionCheck = 0;
            }
            $member->IsReferal = $request['referral'];
            $member->ReferalCode = $request['referralCode'];
            $member->FavFeature = "'" . $request['FavFeature'] . "'";
            $response = $member->save();



            if ($response) {

                if ($request['referral'] != 1) {

                    $memberctrl = $member->GetMemberByReferralCode($request['referralCode']);
                    if ($memberctrl != null) {
                        $memId = $memberctrl[0]->MemberId;


                        $arr = array("IsAvailable" => 1, "JoinDate" => date('Y-m-d H:i:s'), "JoinedMember" => $member->id, "MemberId" => $memId, "ReferralCode" => $request['referralCode'],"createddate"=>date('Y-m-d H:i:s'));
                        DB::table('memberrefferal')->insert($arr);

                        $textmsg = $request['name'] . " " . $request['lastname'] . " Joined VRP BOGO APP with Your Referal Code";
                        $arr = array("Message" => $textmsg, "Memberid" => $memId,"CreatedDate"=>date('Y-m-d H:i:s'));
                        DB::table('notification')->insert($arr);
                        
                         
                       if($memberctrl[0]->devicetoken!=null && $memberctrl[0]->devicetoken!='')
                            
                        {   
                             $firebase=new Firebase;
                            $firebase->send($memberctrl[0]->devicetoken, $textmsg,"Referral Applied");

                            $firebase=new Firebase;
                        }
                    } else {
                        $memId = 0;
                    }
                }
 
                DB::select('call  saveReferralCode('
                        . $member->id . ","
                        . $request['state'] . ","
                        . $request['city'] . ")");

                //success 
                $array['memberid'] = $member->id;
                $array['message'] = 'user created';
                $array['status'] = 'success';
                // generating otp for mail verification

                $registerOTP = mt_rand(1000, 9999);

                $common = new CommonMethods;
                $body = "Congratulations! Your account has been successfully created <br> Your details:<br>
                
                Email : <b>" . $request['email'] . "</b><br>
                Password : <b>" . $request['password'] . "</b>
                <br> 
                Your OTP for email verification is: " . $registerOTP;
                $common->SendMail('Confirmation for your VRP BOGO APP.', $body, $request['email']);
                $array['otp'] = $registerOTP;
            } else {
                //failed to save user
                $array['memberid'] = 0;
                $array['message'] = 'unable to create user!';
                $array['status'] = 'failed';
            }
        } else {
            $array['memberid'] = -1;
            $array['message'] = 'User with this email id already exists!';
            $array['status'] = 'error';
        }


        echo json_encode($array);
    }

    public function SendOTP(Request $request) {



        $member = new Member();
        $existedMember = $this->member->getMemberByEmail($request['email']);

        if ($existedMember != null) {

            // call code for mail

            $array['otp'] = $existedMember->memberid;
            $array['otp'] = mt_rand(1000,9999);
            ;
            $common = new CommonMethods;
            $common->SendMail($request["subject"], 'Your OTP is :' . $array['otp'], $request['email']);
            $array['message'] = 'success';
            $array['status'] = 'success';
        } else {
            $array['otp'] = '';
            $array['message'] = 'User with this email id does not exist!';
            $array['status'] = 'error';
        }


        echo json_encode($array);
    }

    public function ApplyOffer(Request $request) {
        // call to the model
        $member = new Member;

        $member->ApplyOffer($request['ReferralId'], $request['memberid']);
        $array['message'] = 'Applied SuccessFully';
        $array['status'] = 'success';
        echo json_encode($array);
    }

    public function SaveCustomerIdAndInfo(Request $request) {
        // call to the model
        $member = new Member;

        $rest = $member->SaveCustomerIdAndInfo($request['memberid'], $request['customerid'], $request['amount'], $request['receiptno'], $request['paymentType']);
        $array['message'] = 'saved successfully';
        $array['status'] = 'success';
        $array['res'] = $rest;
        $array['customerid'] = $request['customerid'];
        $array['memberid'] = $request['memberid'];

        echo json_encode($array);
    }

    public function changeMemberPassword(Request $request) {

        $this->newData['memberpwd'] = $request['password'];
        $email = $request['email'];
        // call to the model
        $member = new Member;

        $member->update_pwd($email, $this->newData);
        $array['message'] = 'changed successfully';
        $array['status'] = 'success';
        echo json_encode($array);
    }
	public function TestNotification() {

	 $firebase=new Firebase;
		 $array=   $firebase->send("eSgXGJ8YH4g:APA91bGx5sZOL_fchFvYidXyozbPOey0St1nHHtaREsN6h-TboNf87QUyTTrqgnGJIuuvUUhA5HqGzXohu0e8g2C5n1Z6cCck07m9d28w0_wU-FYum9TPz1eKR8ZvRy4J4STPo55Dm_x", "Demo","Notification");
		
		echo json_encode($array);
	}
	
	// ********** Login Api ************ //
    public function memberChecklogin(Request $request) {
        \Auth::logout();
		 
        $member = new Member;
		
        $mem = $member->CheckMemberForLogin($request['email'], $request['password']);
		 
        if ($mem != null) {	
            
            $member->UpdateMemberDeviceToken($request['email'], $request['devicetoken']);
            
            $array['memberinfo'] = $mem;
            $array['message'] = 'User exists';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'Login not exists';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    //GetReferralCodeByMemberId

    public function GetReferralCodeByMemberId(Request $request) {

        $member = new Member;
        $mem = $member->GetReferralCodeByMemberId($request['memberid']);
        if ($mem != null) {
            $array['data'] = $mem;
            $array['message'] = 'Referral code loaded successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
		
    }
	 
    public function getMemberbyId(Request $request) {

        $member = new Member;
        $mem = $member->getMemberIdBy($request['memberid']);
        if ($mem != null) {
            $array['data'] = $mem[0];
            $array['message'] = 'memberloaded successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    public function verifyMemberEmail(Request $request) {
        $this->newData['IsEmailVerified'] = 1;

        $member = new Member;
        $mem = $member->VerifyMemberEmail($request['memberid'], $this->newData);
        if ($mem) {
            $array['memberinfo'] = $mem;
            $array['message'] = 'email verified successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to verify memeber';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    public function UpdateMemberProfile(Request $request) {
        $this->newData['memberfirstname'] = $request['memberfirstname'];
        $this->newData['memberlastname'] = $request['memberlastname'];
        $this->newData['usphoneno'] = $request['usphoneno'];
        $this->newData['memberpwd'] = $request['memberpwd'];




        $member = new Member;
        $mem = $member->update_entry($this->newData, $request['memberid']);
        if ($mem) {
            $array['data'] = $member->get_id($request['memberid']);

            $array['message'] = 'updated successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to update memeber';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    public function GetMyReferralSummary(Request $request) {


        $member = new Member;
        $mem = $member->GetMyReferralSummary($request['memberid']);
        if ($mem) {
            $array['data'] = $mem;
            $array['message'] = 'data loaded successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load data';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    public function getPaymentHistory(Request $request) {


        $member = new Member;
        $mem = $member->getPaymentHistory($request['memberid']);
         $duedate=$member->getTotalCreditsAndNextDueDate($request['memberid']);
            if($duedate!=null)
            {
                  $array['nextDueDate']=$duedate[0]->NextDueDate;
                  $array['TotalReferralAmount']=$duedate[0]->TotalReferralAmount;

            }
        if ($mem) {
            $array['data'] = $mem;
            $array['message'] = 'data loaded successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load data';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    public function GetmemberUsedInvites(Request $request) {


        $member = new Member;
        $mem = $member->getUsedInvites($request['memberid']);
        if ($mem) {
            $array['data'] = $mem;
            $array['message'] = 'data loaded successfully';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load data';
            $array['status'] = 'ERROR';
            echo json_encode($array);
        }
    }

    public function MakeANotification() {
        $serviceAccount = ServiceAccount::fromJsonFile(getcwd() . '/google-services.json');

        $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                // The following line is optional if the project id in your credentials file
                // is identical to the subdomain of your Firebase project. If you need it,
                // make sure to replace the URL with the URL of your project.
                ->withDatabaseUri('https://my-project.firebaseio.com')
                ->create();

        $database = $firebase->getDatabase();

        $newPost = $database
                ->getReference('blog/posts')
                ->push([
            'title' => 'Post title',
            'body' => 'This should probably be longer.'
        ]);

        $newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
        $newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-

        $newPost->getChild('title')->set('Changed post title');
        $newPost->getValue(); // Fetches the data from the realtime database
        $newPost->remove();

        echo 'success';
    }


    public function getMemberTotalUnreadNotification(Request $request) {
        $member = new Member;
        $mem = $member->getUnreadNotificationCount($request['memberid']);
        if($mem!=null)
        {
          $array['data'] = $mem[0]->TtlCount;

        }
        else{
             $array['data'] = 0;
        }
        $array['message'] = 'data loaded successfully';
        $array['status'] = 'success';
        echo json_encode($array);
    }

} 

   
