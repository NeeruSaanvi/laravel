<?php
namespace App\Models;
 
use DB;
use Illuminate\Database\Eloquent\Model;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//getMemberForMonthlySubscription


$response=DB:: select ('call getMemberForMonthlySubscription ('.date('Y-m-d').')');

if($response!=null)
{
    for($i=0;$i<count($response);$i++)
    {
        if($response[i]->AmountToNegotiate>39.95)
        {
            // charge nothing
        }
        else{
            // charge amount
            $payment = new Payment;
            
            $payment->ChargeCard((39.95-$response[i]->AmountToNegotiate), $response[i]->CustomerId, $response[i]->MemberId,"Monthly Customer Subscription");
            if($payment)
            {
                //send email
            }
        }
    }
}
//echo json_encode($response);


