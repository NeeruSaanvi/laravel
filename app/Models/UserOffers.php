<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class UserOffers extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_offers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'username', 'offer_id', 'purchase_at', 'resturant', 'offer_code', 'redeem_at', 'created_at', 'createdby', 'updated_at', 'status', 'redeem_by','expired_at'];	

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
     public function update_entry($data,$id){
        $response = $this->where('id', $id)->update($data);
        if($response){
            return true;
        }else{
            return false;
        }
     }
     // public function update_expired($data,$time){
     //  $offers=$this->where(DB::raw("TIMESTAMPDIFF(MINUTE, created_at, '".date('Y-m-d H:i:s')."')"),'>',$time)->whereNull('redeem_by')->where('status','1')->update($data);
     //    return true;
     // }
    public function update_expired($data,$time){
      $offers=$this->where('expired_at', '<=',date('Y-m-d H:i:s'))->whereNull('redeem_by')->where('status','1')->update($data);
        return true;
     }


     /**
     * delete address
     * 
     * @param array $data
     * @return boolean 
     */
     public function delete_entry($id){
        $response = $this->where('id', $id)->delete();
        if($response){
            
            return true;
        }else{
            return false;
        }
     }
    public function get_id($id){
        return $this->where('id', $id)->get()->first();
    }

    public function get_code($code,$user,$offer_id){
        return $this->where('offer_id', $offer_id)->where('offer_code', $code)->where('username', $user)->get()->first();
    }

    public function getAll_users($username=null,$status=null,$datefrom=null,$dateto=null){

        $str='';
        if($datefrom!=null)
            $str=' and user_offers.created_at>="'.$datefrom.'"';
        if($datefrom!=null)
            $str.=' and user_offers.created_at<="'.$dateto.'"';
        if($status!=null)
        {
            if($status=='Used')
            {
                 $str.=' and (redeem_by is not null or user_offers.status=0)';
            }
            else{
                 $str.=' and redeem_by is null and user_offers.status=1';
            }
        }
        else{
            $str.=' and user_offers.status=1';
        }
            
        if($username!=null)
            $str.=' and user_offers.username="'.$username.'"';

            return DB::Select("select user_offers.*,
                    ((Select time_limit*60 from offers where offers.id=user_offers.offer_id)-TIMESTAMPDIFF(SECOND, user_offers.created_at, '".date('Y-m-d H:i:s')."')) as exipred_in,
                    (select name from food_types where food_types.id=member_resturants.food_types) as food_name,
                    (select name from offers where offers.id=user_offers.offer_id) as offer_name,
                    (select email from users where users.uniqueid=user_offers.username) as user_email,
                    (select concat(name,' ',last_name) from users where users.uniqueid=user_offers.username) as user_name,
                 member_resturants.name as rest_name,  working_hours_to,working_hours_from, food_types, website, contact_no, more_info, notes, star_rating, member_resturants.email as rest_email,
                    building,street,city,pincode,state
                from user_offers,member_resturants,users where 
                    member_resturants.username=user_offers.resturant 
                    and users.uniqueid=user_offers.resturant
                    ".$str."
                 
                order by created_at desc
                    ");
      
    }

    public function getAll_resturants($username=null,$status=null,$datefrom=null,$dateto=null){
        $str='';
        if($datefrom!=null)
            $str=' and user_offers.created_at>="'.$datefrom.'"';
        if($datefrom!=null)
            $str.=' and user_offers.created_at<="'.$dateto.'"';
        if($username!=null)
            $str.=' and user_offers.resturant="'.$username.'"';

        if($status!=null)
        {
            if($status=='Used')
            {
                 $str.=' and (redeem_by is not null or user_offers.status=0)';
            }
            else{
                 $str.=' and redeem_by is null and user_offers.status=1';
            }
        }
        else{
            $str.=' and user_offers.status=1';
        }
        
            return DB::Select("select user_offers.*, ((Select time_limit*60 from offers where offers.id=user_offers.offer_id)-TIMESTAMPDIFF(SECOND, user_offers.created_at, '".date('Y-m-d H:i:s')."')) as exipred_in,
                    (select name from member_resturants where member_resturants.username=user_offers.resturant) as rest_name,
                    (select name from offers where offers.id=user_offers.offer_id) as offer_name,
                 users.name,users.last_name,email, phone, building, street,city, state, country,
                 pincode, image,offer_like
                from user_offers,users where 
                    users.uniqueid=user_offers.username 
                     ".$str."
                order by created_at desc
                    ");
        
    }

    public function getAll(){
       return $this->where('status', '1')->get();
    }

    public function check_offercode($uniqueid){
      
       $offer= DB::Select("select user_offers.*,
            (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase
        from user_offers where 
            user_offers.id='".$uniqueid."'
        and user_offers.status='1' and redeem_by is null
            ");
       if(count($offer)>0)
       {
            if($offer[0]->repurchase==1)
            {
                $offers= DB::Select("select user_offers.*,
                    (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase,
                    (select time_limit from offers where offers.id=user_offers.offer_id) as time_limit
                    from user_offers where 
                        user_offers.offer_id='".$offer[0]->offer_id."' and resturant='".$offer[0]->resturant."'
                    and user_offers.status='1' and redeem_by is not null and
                    user_offers.username= '".$offer[0]->username."' and
                    TIMESTAMPDIFF(MINUTE, redeem_at, '".date('Y-m-d H:i:s')."')<=(select time_limit from offers where id='".$offer[0]->offer_id."')
                ");
            }
            else
                $offers= DB::Select("select user_offers.*,
                    (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase,
                    (select time_limit from offers where offers.id=user_offers.offer_id) as time_limit
                    from user_offers where 
                        user_offers.offer_id='".$offer[0]->offer_id."'
                    and user_offers.status='1' and redeem_by is not null and 
                    user_offers.username= '".$offer[0]->username."' and
                    TIMESTAMPDIFF(MINUTE, redeem_at, '".date('Y-m-d H:i:s')."')<=(select time_limit from offers where id='".$offer[0]->offer_id."')
                ");
            if(count($offers)>0)
                return 0;
            else
                return 1;
        }
        else
            return 0;
    }

    public function check_offer($offerid,$resturantid,$username){
      
       $offer= DB::Select("select * from offers where id='".$offerid."'");
       if(count($offer)>0)
       {
            if($offer[0]->repurchase==1)
            {
                $offers= DB::Select("select user_offers.*,TIMESTAMPDIFF(MINUTE,created_at,'".date('Y-m-d H:i:s')."') as time_left,
                    (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase,
                    (select time_limit from offers where offers.id=user_offers.offer_id) as time_limit
                    from user_offers where 
                        user_offers.offer_id='".$offerid."' and resturant='".$resturantid."'
                    and user_offers.status='1' and 
                    user_offers.username= '".$username."' order by created_at desc limit 1
                ");
                // and redeem_by is not null and
                //     TIMESTAMPDIFF(MINUTE, redeem_at, '".date('Y-m-d H:i:s')."')<=(select time_limit from offers where id='".$offerid."')
            }
            else
                $offers= DB::Select("select user_offers.*, TIMESTAMPDIFF(MINUTE,created_at,  '".date('Y-m-d H:i:s')."') as time_left,
                    (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase,
                    (select time_limit from offers where offers.id=user_offers.offer_id) as time_limit
                    from user_offers where 
                        user_offers.offer_id='".$offerid."'
                    and user_offers.status='1' and 
                    user_offers.username= '".$username."' order by created_at desc limit 1
                 ");
             // and redeem_by is not null and
             //        TIMESTAMPDIFF(MINUTE, redeem_at, '".date('Y-m-d H:i:s')."')<=(select time_limit from offers where id='".$offerid."')
            if(count($offers)>0)
                return ($offers[0]->time_limit - $offers[0]->time_left);
            else
                return 0;
        }
        else
            return 0;
    }

    public function check_offerredeem($uniqueid){
      
       $offer= DB::Select("select user_offers.*,
            (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase
        from user_offers where 
            user_offers.id='".$uniqueid."'
        and user_offers.status='1' and redeem_by is null
            ");
       if(count($offer)>0)
       {
            if($offer[0]->repurchase==1)
            {
                $offers= DB::Select("select user_offers.*,TIMESTAMPDIFF(MINUTE,redeem_at,'".date('Y-m-d H:i:s')."') as time_left,
                    (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase,
                    (select time_limit from offers where offers.id=user_offers.offer_id) as time_limit
                    from user_offers where 
                        user_offers.offer_id='".$offer[0]->offer_id."' and resturant='".$offer[0]->resturant."'
                    and user_offers.status='1' and redeem_by is not null and
                    user_offers.username= '".$offer[0]->username."' and
                    TIMESTAMPDIFF(MINUTE, redeem_at, '".date('Y-m-d H:i:s')."')<=(select time_limit from offers where id='".$offer[0]->offer_id."')
                ");
            }
            else
                $offers= DB::Select("select user_offers.*,TIMESTAMPDIFF(MINUTE,redeem_at,'".date('Y-m-d H:i:s')."') as time_left,
                    (select repurchase from offers where offers.id=user_offers.offer_id) as repurchase,
                    (select time_limit from offers where offers.id=user_offers.offer_id) as time_limit
                    from user_offers where 
                        user_offers.offer_id='".$offer[0]->offer_id."'
                    and user_offers.status='1' and redeem_by is not null and 
                    user_offers.username= '".$offer[0]->username."' and
                    TIMESTAMPDIFF(MINUTE, redeem_at, '".date('Y-m-d H:i:s')."')<=(select time_limit from offers where id='".$offer[0]->offer_id."')
                ");
            if(count($offers)>0)
                return ($offers[0]->time_limit - $offers[0]->time_left);
            else
                return 0;
        }
        else
            return 0;
    }


}