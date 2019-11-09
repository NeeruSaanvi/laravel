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


$response=DB:: select ("select distinct mem.memberid, mem.devicetoken,
                 res.restname from ordermaster as om 
                 inner join memberdetails as mem on mem.memberid=om.memberid
                 inner join restaurants_loc as loc on loc.dbsno=om.restid
                 inner join restaurants as res on res.restid=loc.restid  
                 where mem.devicetoken is not null and mem.devicetoken!='' and om.orderid in (select orderid from ordermaster where  (IsReviewed=0 or IsReviewed is null) and isActive=1 and offerid in (1,2,3) and  cast(orderdatetime as date)< cast(now() as date)) order by om.orderdatetime desc ");

if($response!=null)
{
    for($i=0;$i<count($response);$i++)
    {
         $feedback=new Firebase;
         $body="Want to rate your last order with".$response[$i]->restname." ?";
         $title="Survey";
         $feedback->send($response[$i]->devicetoken, $body, $title);
    }
}
//echo json_encode($response);


