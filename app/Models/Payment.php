<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
\Stripe\Stripe::setClientId(getenv('STRIPE_CLIENT_ID'));

class Payment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public function ChargeCard($amount, $customer, $memberid ,$description) {
        try {
            $resp1 = \Stripe\Charge::create([
                        "amount" => round($amount, 2) * 100,
                        "currency" => "usd",
                        "customer" => $customer,
                      "description"=>$description
            ]);
            if ($resp1 != null) {
                $member = new Member;
                $member->SaveCustomerIdAndInfo($memberid, $customer, $amount, $resp1->id, "Credit Card");
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return  false;
        }
    }

}
