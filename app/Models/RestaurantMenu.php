<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RestaurantMenu extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resturant_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'username', 'item_name', 'price', 'description', 'image', 'offer_id', 'popular_item', 'display_order', 'created_at', 'createdby', 'updated_at', 'status'];

    /**
     * Create new address
     * 
     * @param array $data
     * @return boolean 
     */
    public function create_entry($data) {

        $response = $this->create($data);
        if ($response) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update address
     * 
     * @param array $data
     * @return boolean 
     */
    public function update_entry($data, $id) {
        $response = $this->where('id', $id)->update($data);
        if ($response) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * delete address
     * 
     * @param array $data
     * @return boolean 
     */
    public function delete_entry($id) {
        $response = $this->where('id', $id)->delete();
        if ($response) {

            return true;
        } else {
            return false;
        }
    }

    public function get_id($id) {
        return $this->where('id', $id)->get()->first();
    }

    public function check_menuitem($name, $username) {
        return $this->where('item_name', $name)->where('username', $username)->count();
    }

    public function getAll() {
        return DB::Select("select resturant_menu.*,
                        (select name from food_types where food_types.id=member_resturants.food_types) as food_name,
                     member_resturants.name as rest_name,  working_hours_to,working_hours_from, food_types, website, contact_no, more_info, notes, star_rating, member_resturants.email as rest_email
                    from resturant_menu,member_resturants where 
                        member_resturants.username=resturant_menu.username  
                    and member_resturants.status='1' and resturant_menu.status='1' 
                    ");
    }

    public function getAll_rest($username) {
        return DB::Select("select resturant_menu.*,
                        (select name from food_types where food_types.id=member_resturants.food_types) as food_name,
                     member_resturants.name as rest_name,  working_hours_to,working_hours_from, food_types, website, contact_no, more_info, notes, star_rating, member_resturants.email as rest_email
                    from resturant_menu,member_resturants where 
                        member_resturants.username=resturant_menu.username  
                        and member_resturants.username='" . $username . "'  
                    and member_resturants.status='1' and resturant_menu.status='1' 
                    ");
    }

}
