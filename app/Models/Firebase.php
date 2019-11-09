<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;
 
use DB;
use Illuminate\Database\Eloquent\Model;
class Firebase {
 
    public function send($registration_ids, $body,$title) {
        
      
         
         
         $msg = array
          (
		'body' 	=> $body,
		'title'	=> $title
          );
	$fields = array
			(
				'to'=> $registration_ids,
				'notification'=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' .getenv("FIREBASE_API_KEY"),
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
#Echo Result Of FireBase Server
return $result;


    }
    
    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent 
    */
    private function sendPushNotification($fields) {
         
        //importing the constant files
        
        
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        //building headers for the request
        $headers = array(
            'Authorization: key=' .getenv("FIREBASE_API_KEY") ,
            'Content-Type: application/json'
        );
 
        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
 
        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        return $result;
    }
}

class Push {
    //notification title
    private $title;

    //notification message 
    private $message;

    //notification image url 
    private $image;

    //initializing values in this constructor
    function __construct($title, $message, $image) {
         $this->title = $title;
         $this->message = $message; 
         $this->image = $image; 
    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        return $res;
    }
 
}