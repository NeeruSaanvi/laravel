<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 use Mail;

class CommonMethods extends Model
{
    public function  SendMail($subject,$body,$to)
    {
          
      
            
            Mail::send([], ['email' => $to,'msg' => $body], function ($message) use ($to,$body,$subject) {
                     $message->from('app.support@epl.in');
                     $message->to($to)
                    ->subject($subject)
                    // here comes what you want
                    ->setBody($body, 'text/html'); // for HTML rich messages
                });
    }
}

