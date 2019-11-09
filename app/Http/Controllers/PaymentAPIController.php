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

\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
\Stripe\Stripe::setClientId(getenv('STRIPE_CLIENT_ID'));

use DB;

//********************* Start Class ****************//
class PaymentAPIController extends Controller {

    //****************** declare all common varible for all referenced models**************// 
    protected $newData = [];
    protected $userdata, $member, $common;

    //****************** declare contructor for admin controller **************// 

    public function __construct(\Illuminate\Routing\Redirector $redirecor) {
        //****************** define all common varible for all referenced models**************// 
        $this->member = new Member;
        $this->common = new CommonMethods;
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

// apis

    private function SaveCustomerAndTransction($memid, $custid, $amount, $transno) {

        $member = new Member;
        $response = $member->SaveCustomerIdAndInfo($memid, $custid, $amount, $transno, "Credit Card");
        if ($response != null) {
            return true;
        }
        return false;
    }

    public function CreateUserWithPayment(Request $request) {
        $token1 = $request['stripeToken'];
        $email1 = $request['stripeEmail'];
        $amount1 = $request['amount'];
        $memberid = $request['memberid'];


        $array["message"] = "";
        $array["success"] = "";
        $array["status"] = "";


        if ($token1 != null) {

            $arry = array("email" => $email1, "source" => $token1);
            try {
                $customer = \Stripe\Customer::create($arry);
                if ($customer != null) {
                    $resp1 = \Stripe\Charge::create([
                                "amount" => $amount1*100,
                                "currency" => "usd",
                                "customer" => $customer->id,
                                 "description"=>"new user subscription"
                    ]);
                    if ($resp1 != null) {
                        $result = $this->SaveCustomerAndTransction($memberid, $customer->id, $amount1, $resp1->id);
                        if ($result) {
                            $array["message"] = 'successfull payment done';
                            $array["success"] = "success";
                            $array["status"] = "1";
                            $array["CustomerId"] = $customer->id;
                        } else {
                            $array["message"] = 'successfull payment done';
                            $array["success"] = "success";
                            $array["status"] = "1";
                            $array["CustomerId"] = $customer->id;
                        }
                    } else {
                        $array["message"] = 'unable to make payment.';
                        $array["success"] = "failed";
                        $array["status"] = "0";
                        $array["CustomerId"] = $customer->id;
                    }
                } else {
                    $array["message"] = 'unable to make payment.';
                    $array["success"] = "failed";
                    $array["status"] = "-1";
                    $array["CustomerId"] = null;
                }
            } catch (Exception $e) {

                $array["message"] = $e->getMessage();
                $array["success"] = "failed";
                $array["status"] = "0";
                $array["CustomerId"] = null;
            }
        } else {
            $array["message"] = "Token not available. Please retry!";
            $array["success"] = "failed";
            $array["status"] = "0";
            $array["CustomerId"] = null;
        }

        echo json_encode($array);
    }

    public function GetMember() {
        echo \Stripe\Customer::retrieve("cus_Ci2ImsRbNJ8VbN");
    }

}
