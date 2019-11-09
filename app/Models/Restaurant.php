<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Restaurant extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['dbsno', 'fname', 'lname', 'pos', 'contactph', 'cellph', 'corporation', 'mailingaddress', 'city', 'st', 'zip', 'billingct', 'billingst', 'billingzip', 'restname', 'restwebsite', 'email', 'pwd', 'restid', 'mainrestid', 'refby', 'logo', 'doc'];	

    /**
     * Create new address
     * 
     * @param array $data
     * @return boolean 
     */
     public function create_entry($data){
        
        $response = $this->create($data);
        if($response){
            return true;
        }else{
            return false;
        }
     }

     
    /**
     * Update address
     * 
     * @param array $data
     * @return boolean 
     */
     public function update_entry($data,$username){
        $response = $this->where('username', $username)->update($data);
        if($response){
            return true;
        }else{
            return false;
        }
     }

     /**
     * delete address
     * 
     * @param array $data
     * @return boolean 
     */
     public function delete_entry($username){
        $response = $this->where('username', $username)->delete();
        if($response){
            
            return true;
        }else{
            return false;
        }
     }
    public function get_id($resid){
        return $this->where('dbsno', $resid)->get()->first();
    }

    public function GetRestaurantById($restid){
        
         return DB::select('call getRestaurantDetailById ('.$restid. ",'". getenv("ImageBaseURL")."')");
        
    //  $str="select *,IFNULL((select 1 from member_fav_restaurants  where restid=res.restid and MemberId=".$request['memberid']." limit 1 ),0) as Isfav from restaurants as res";
       // return DB::Select($str);
    }
    
    public function GetFilteredRestaurants($request){
        
         return DB::select('call getNearbyRestaurants('
                .($request['state']!=null && $request['state']!=''?$request['state'] :0).","
                .($request['city']!=null && $request['city']!=''?$request['city'] :0).","
                .($request['zip']!=null && $request['zip']!=''?$request['zip'] :0).","
                .($request['lat']!=null && $request['lat']!=''?$request['lat'] :"''").","
                .($request['lng']!=null && $request['lng']!=''?$request['lng'] :"''").","
                 .$request['foodtype'].","
                .$request['IsNear'].","
                .$request['offerid'].","
                .$request['memberid']. ",'"
                . getenv("ImageBaseURL"). "')");
        
    //  $str="select *,IFNULL((select 1 from member_fav_restaurants  where restid=res.restid and MemberId=".$request['memberid']." limit 1 ),0) as Isfav from restaurants as res";
       // return DB::Select($str);
    }
     public function getAll(){
       return $this->get();
    }
    
    
     public function getServersByRestaurant($resid)
    {   
        $str="select sr.* from restaurant_servers as sr inner join restaurants_loc as loc on loc.restid=sr.restid where loc.dbsno='".$resid."'";
        return DB::Select($str);
    }
    
     public function GetAllOffers()
    {   
        $str="select * from offerinfo  ";
        return DB::Select($str);
    }
    public function getOrderinformationByOrderId($orderId)
    {   
        $str=" SELECT distinct mem.memberfirstname,mem.memberlastname, orderid,  om.memberid, orderdatetime,   salepersonid,  OfferId, OfferType, om.restid, orderstatus, NumberInParties, TransactionNumber,ser.servername,
            (select DATE_FORMAT(orderdatetime, '%m/%d/%y')) as OrderDate ,
(select   DATE_FORMAT(orderdatetime,'%h:%i %p')) as OrderTime,TotalAmount, Discount, Tax, NonTaxAmount, DueAmount, SpecialNotes, TaxAmount ,
res.restname, loc.locadd ,loc.zip,loc.cellph,loc.email,loc.contactph  ,loc.city,loc.st,

(SELECT GROUP_CONCAT(TransactionCode )  FROM  order_transactions_detail where orderid=om.orderid group by orderid ) TransactionNo,

concat('". getenv("ImageBaseURL")."',res.logopath,'/', res.logo) as logo , DATE_FORMAT(om.pickupdate,'%m/%d/%y') as pickupdate  , pickuptime  ,
    DAYNAME(om.pickupdate) as Pickupday

FROM ordermaster  as om
inner join memberdetails as mem on mem.memberid=om.memberid
inner join restaurants_loc as loc on loc.dbsno=om.restid
inner join restaurants as res on res.restid=loc.restid

left join restaurant_servers as ser on ser.sno=om.salepersonid where orderid=".$orderId."";
        return DB::Select($str);
    }
    
      public function checkForMembersLastOrderReview($memberid)
    {   
        $str="select offerid,offertype, orderid,(SELECT GROUP_CONCAT(TransactionCode )  FROM  order_transactions_detail where orderid=om.orderid group by orderid ) TransactionNo,
            res.restname from ordermaster as om 
                 inner join restaurants_loc as loc on loc.dbsno=om.restid
                 inner join restaurants as res on res.restid=loc.restid  
                 where  om.memberid=".$memberid." and (om.IsReviewed=0 or om.IsReviewed is null) and om.isActive=1 and offerid in (1,2,3) and  cast(om.orderdatetime as date)< cast(now() as date) order by om.orderdatetime desc  limit 1";
        return DB::Select($str);
    }
    
    
public function UpdateNotificationsStatus($memberid)
    {   
    
     $response=  DB::table('notification')
            ->where('memberid', $memberid)
            ->update(['IsRead' => 1]);
     
    
     if($response)
     {
         return true;
     }
     else{
         return false;
     }
    } 

public function getMembersUnreadNotifications($memberid)
    {   
        $str="  select *,DATE_FORMAT(CreatedDate,'%m-%d-%y %H:%i') as convertedDate from notification where IsRead=0 and memberid=".$memberid."";
        return DB::Select($str);
    }

public function getMenuTypes()
    {   
        $str="select * from menutypes";  
        return DB::Select($str);
    }    
    
   
    public function getMemberOrderHistory($member)
    {   
        $str="select distinct offr.offername,offr.offershortcode,offr.offerdescription,  om.orderid,
            om.memberid, orderdatetime,   salepersonid,  offr.OfferId, offr.OfferType, om.restid, orderstatus, NumberInParties, 
            
(SELECT GROUP_CONCAT(TransactionCode )  FROM  order_transactions_detail where orderid=om.orderid group by orderid )  
             TransactionNumber,
            ( select  servername  from restaurant_servers where sno=om.salepersonid limit 1) as servername ,
            (select DATE_FORMAT(orderdatetime, '%m/%d/%y')) as OrderDate,
(select DATE_FORMAT(orderdatetime, '%H:%i')) as  OrderTime ,
res.restname,loc.locadd ,loc.zip,loc.cellph ,loc.city,loc.st,

concat('". getenv("ImageBaseURL")."',res.logopath,'/', res.logo) as logo
FROM ordermaster  as om
 
inner join offerinfo as offr on offr.offerid=om.offerid
inner join restaurants_loc as loc on loc.dbsno=om.restid

inner join restaurants as res on res.restid=loc.restid  where om.memberid=".$member." order by om.orderdatetime desc";
       
       
        return DB::Select($str);
    }
    
    public function getMemberOrderHistoryByOffer($member,$offerid)
    {   
        $str="select distinct offr.offername,offr.offershortcode,offr.offerdescription,  om.orderid,
            om.memberid, orderdatetime,   salepersonid,  offr.OfferId, offr.OfferType, om.restid, orderstatus, NumberInParties, (SELECT GROUP_CONCAT(TransactionCode )  FROM  order_transactions_detail where orderid=om.orderid group by orderid )  
             TransactionNumber,
            ( select  servername  from restaurant_servers where sno=om.salepersonid limit 1) as servername ,
            (select DATE_FORMAT(orderdatetime, '%m/%d/%y')) as OrderDate,
(select DATE_FORMAT(orderdatetime, '%H:%i')) as  OrderTime ,
res.restname,loc.locadd ,loc.zip,loc.cellph,loc.st,loc.city,

concat('". getenv("ImageBaseURL")."',res.logopath,'/', res.logo) as logo FROM ordermaster  as om
 
inner join offerinfo as offr on offr.offerid=om.offerid
inner join restaurants_loc as loc on loc.dbsno=om.restid

inner join restaurants as res on res.restid=loc.restid  where om.memberid=".$member;
       
        if($offerid!=0)
        {
            $str.="  and om.offerid=".$offerid;
        }
        $str.=" order by om.orderdatetime desc";
        return DB::Select($str);
    }
    
     public function getFeedbackByOfferId($offerid)
    {   
         
        $str="SELECT TypeId FeedbackType, TypeName, Description,  OfferId,off.OfferName,off.offerDescription,off.offershortcode,(case when IsQuestion=1 then '1' else '5' end) as Rating ,IsQuestion FROM feedbacktypes as feed 
inner join offerinfo as off on off.OfferId=OfferCode WHERE feed.IsActive=1 and offercode=".$offerid."";
        return DB::Select($str);
    }
    
      public function setOrderReviewFlag($orderid)
    {   
          $array=array("IsReviewed"=>2);
       $result= DB::table('ordermaster')
            ->where('orderid', $orderid)
            ->update($array);
                if($result!=null)
                {
                    return true;
                }
                else{
                    return false;
                }
        
    }
    
     public function getFavouriteRestaurants($memberid)
    {   
         
        $str="SELECT distinct res.restname,loc.*, concat('". getenv("ImageBaseURL")."',res.logopath,'/', res.logo) as logo ,loc.avgrating  FROM member_fav_restaurants as fav
            inner join restaurants_loc as loc on loc.dbsno=fav.restid
inner join restaurants as res on res.restid=loc.restid
where fav.MemberId=".$memberid;
        return DB::Select($str);
    }
       public function SaveFavouriteRestaurant($request)
    {   
          
          $str="SELECT  1 from member_fav_restaurants where memberid=". $request['memberid']." and restid=". $request['restid'];
           $rest= DB::Select($str);
           if($rest!=null)
           {
               return -1;
           }
           else{
                 $id = DB::table('member_fav_restaurants')->insertGetId(
                        ['MemberId' => $request['memberid'],
                         'restid' => $request['restid'],
                         'CreatedDate'=>date("Y-m-d H:i:s") 
                          
                       ]);
             
             
                  return $id;
             
           }
 
               
      
    }
    
     public function SaveMemberFeedback($feedback,$SerialNo)
    {   
           $count=0;
       
          
           foreach ($feedback['ratinglist'] as $value) {
                 $id = DB::table('memberfeedbackdetail')->insertGetId(
                        ['SerialNo' => $SerialNo,
                         'Rating' => $value['Rating'],
                         'FeedbackType' => $value['FeedbackType'],
                          'createddate'=>date("Y-m-d H:i:s")
                       ]);
                 $count++;
            }
            if($count>0){
                 
                 
                DB::select("call spSaveRestaurantRatings (".$feedback["OrderNo"].")");
            return ($count);
            
            }
            else {return null;}
      
    }

   
      public function SaveOrderWithoutMenu( $request)
    {   
          $limit=1;
       
          if($request['offeridParam']==4)
          {
             $limit=2;
          }
          else if($request['offeridParam']==5)
          {
             $limit=5;
          }
          
          
           $result=DB::select('call spSaveOrderWithoutMenu('
                .$request['memberidParam'].","
                .$request['restaurantid'].","
                .($request['serverid']!=null && $request['serverid']!=''?$request['serverid'] :0).","
                .$request['offeridParam'].","
                .$request['offertype'].","
                .($request['totalnoofparty']!=null && $request['totalnoofparty']!=''?$request['totalnoofparty']:0).","
                .$limit.")");
           
          
        return  $result;
      }
    
    
    public function getRestaurantMenuByOffer($resid,$offerid)
    {   
        $qry='SELECT  menu.menusno as MenuId, menu.itemname as MenuName,menu.regprice as Amount ,res.restname,
            
            res.restname,loc.locadd ,loc.zip,loc.cellph,loc.contactph ,loc.email,loc.city,loc.st,
           ifnull(  ( case   when '.$offerid.'=3 then  menu.regprice *25/100
      when '.$offerid.'=6 then  menu.regprice *50/100
      when '.$offerid.'=7 then  menu.regprice *25/100 end ),0) as Discount ,0 as qty
          
              FROM restaurant_menu as menu
inner join restaurants as res on menu.restid=res.restid
inner join restaurants_loc  as loc on loc.restid=menu.restid
WHERE loc.dbsno= '.$resid.' and menu.offertype='.$offerid;
        
        //`isbogo`, `ishalfprice`, `istogo`, `is20dollargc`, `iscatering`, `isrestswag`, `is10dollargc`,
       /* if($offerid==1)
        {
            $qry.= '  and isbogo=1';
        }
        else if($offerid==2)
        {
                        $qry.= '  and ishalfprice=1';

        }
         else if($offerid==3)
        {
                        $qry.= '  and istogo=1';

        }
         else if($offerid==4)
        {
                        $qry.= '  and is20dollargc=1';

        }
         else if($offerid==5)
        {
                        $qry.= '  and is10dollargc=1';

        }
         else if($offerid==6)
        {
                        $qry.= '  and isrestswag=1';

        }
         else if($offerid==7)
        {
                        $qry.= '  and iscatering=1';

        }*/
         
          return DB::select($qry );
    }
    public function getRestaurantMenuByMenuType($resid,$menutype,$offerid)
    {   
        $qry='SELECT  menu.menusno as MenuId, menu.itemname as MenuName,menu.regprice as Amount ,res.restname,
            res.restname,loc.locadd ,loc.zip,loc.cellph,loc.contactph ,loc.email,loc.city,loc.st,
           ifnull(  ( case   when '.$offerid.'=3 then  menu.regprice *25/100
      when '.$offerid.'=6 then  menu.regprice *50/100
      when '.$offerid.'=7 then  menu.regprice *25/100 end ),0) as Discount ,0 as qty
              FROM restaurant_menu as menu
inner join restaurants as res on menu.restid=res.restid
inner join restaurants_loc  as loc on loc.restid=menu.restid
WHERE loc.dbsno= '.$resid.' and menu.offertype='.$offerid;
        if($menutype!=0)
        {
           $qry=$qry. "    and  menu.menutype=".$menutype ; 
        }
            
        
       
         
          return DB::select($qry );
    }
     public function getOrderItemsByOrderId($orderid)
    {   
        $str="SELECT ord.*, 
            (SELECT  itemname from restaurant_menu as mnu inner join restaurants_loc as loc on loc.restid=mnu.restid    WHERE menusno=ord.itemid and loc.dbsno=om.restid limit 1) as ItemName FROM orders as ord 
inner join ordermaster as om on om.orderid=ord.orderid
where  om.orderid= ".$orderid;
        return DB::Select($str);
    }
    
     public function SaveOrderForNonBOGOOffers( $request)
    {   
       
           $limit=1;
          if($request['offeridParam']==4)
          {
             $limit=2;
          }
          else if($request['offeridParam']==5)
          {
             $limit=5;
          }
          $result= DB::select('call spSaveOrderForNonBOGOOffer('
                .$request['memberidParam'].","
                .$request['restaurantid'].","
                .$request['totalAmountParam'].","
                .$request['totalTaxParam'].","
                .$request['nonTaxamountParam'].","
                .$request['discountParam'].","
                .$request['dueAmountParam'].","
                .$request['offerIdParam'].","
                .$request['OfferTypeParam'].","
                ."'".$request['specialnotesparam']."',"
                .$request['TaxamountParam'].","
                  .$limit. ",'"
                  .$request['pickupdateParam'] ."','"
                  .$request['pickuptimeParam']. "')"); 
          
            if($result!=null )
                {
                 if($result[0]!=null)
                     {
                          foreach ($request['cart'] as $value) {
                              DB::table('orders')->insert(
                                  ['orderid' => $result[0]->orderno, 
                                    'itemid' => $value['MenuId'],
                                    'qty' => $value['qty'],
                                    'Amount' => $value['Amount'],
                                    'itemdata'=>$value['ItemName'],
                                      'orderdate'=>date("Y-m-d H:i:s")
                                   ]);
                              }
                     }
               }
  

            return $result;
              
    }
  

}