<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserRating extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'memberfeedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['Id', 'MemberId', 'Remarks', 'CreatedDate', 'TransactionNo', 'OrderNo','OfferId','OfferType'];	
    public $timestamps = false;

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
     
         public function SaveFeedbackDetail($data){
        
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
     public function update_entry($data,$uniqueid){
        $response = $this->where('uniqueid', $uniqueid)->update($data);
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
     public function delete_entry($uniqueid){
        $response = $this->where('uniqueid', $uniqueid)->delete();
        if($response){
            
            return true;
        }else{
            return false;
        }
     }
    public function get_id($uniqueid){
        return DB::Select("select *,(select CONCAT(name,' ',last_name) from users where users.uniqueid=user_rating.username)
             as full_name
                    from user_rating where
                    and user_rating.uniqueid='".$uniqueid."'
                     ");
    }

    public function getAll(){
        return DB::Select("select *,(select CONCAT(name,' ',last_name) from users where users.uniqueid=user_rating.username) as full_name
                    from user_rating where status='1'
                   order by created_at desc
                  ");
    }
    public function getAll_user($uniqueid){
           return DB::Select("select *,(select name from member_resturants where member_resturants.username=user_rating.rating_to) as full_name
                    from user_rating where user_rating.username='".$uniqueid."'
                    order by created_at desc
                 ");
    }
    public function getAll_user_rest($uniqueid){
           return DB::Select("select *,(select CONCAT(name,' ',last_name) from users where users.uniqueid=user_rating.username) as full_name
                    from user_rating where user_rating.rating_to='".$uniqueid."'
                        order by created_at desc
                                   ");
    }
   
}