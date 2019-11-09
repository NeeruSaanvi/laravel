<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RestaurantImages extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resturant_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'username', 'image_type', 'image_path', 'display_order', 'created_at', 'createdby', 'updated_at'];	

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
        return DB::Select("select resturant_images.*,
                        (select name from food_types where food_types.id=member_resturants.food_types) as food_name,
                     member_resturants.name as rest_name,  working_hours_to,working_hours_from, food_types, website, contact_no, more_info, notes, star_rating, member_resturants.email as rest_email
                    from resturant_images,member_resturants where 
                        member_resturants.username=resturant_images.username  
                    and member_resturants.status='1' 
                    ");
    }
    public function getAll_rest($username){
        return DB::Select("select resturant_images.*,
                        (select name from food_types where food_types.id=member_resturants.food_types) as food_name,
                     member_resturants.name as rest_name,  working_hours_to,working_hours_from, food_types, website, contact_no, more_info, notes, star_rating, member_resturants.email as rest_email
                    from resturant_images,member_resturants where 
                        member_resturants.username=resturant_images.username  
                    and member_resturants.status='1' and member_resturants.username='".$username."' 
                    ");
    }

}