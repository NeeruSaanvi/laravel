<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Offers extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'name', 'description', 'time_limit', 'perday', 'repurchase', 'price', 'created_at', 'createdby', 'updated_at', 'status'];	

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

    public function getAll(){
       return $this->where('status', '1')->get();
    }

    public function getAll_api($uniqueid){
      return DB::Select("select offers.*,
          '0' as last_redeemed_time,
           '' as last_redeemed_on,
            '' as last_redeemed_at
        from offers where 
            status=1
            ");
      
    }

       // (select TIMESTAMPDIFF(SECOND, redeem_at, '".date('Y-m-d H:i:s')."') from user_offers where user_offers.offer_id=offers.id and username='".$uniqueid."' order by redeem_at desc limit 1) as last_redeemed_time,
       //      (select redeem_at from user_offers where user_offers.offer_id=offers.id and username='".$uniqueid."' order by redeem_at desc limit 1) as last_redeemed_on,
       //      (select resturant from user_offers where user_offers.offer_id=offers.id and username='".$uniqueid."' order by redeem_at desc limit 1) as last_redeemed_at
    

}