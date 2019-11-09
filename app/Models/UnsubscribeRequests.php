<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UnsubscribeRequests extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'unsubscribe_request';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'username', 'reason', 'created_at', 'createdby', 'updated_at', 'request_status'];	

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
     public function delete_entry($id){
        $response = $this->where('id', $id)->delete();
        if($response){
            
            return true;
        }else{
            return false;
        }
     }
    public function get_id($username){
        return $this->where('username', $username)->get()->first();
    }

    public function getAll($status=null,$datefrom=null,$dateto=null){
        $str='';
        if($datefrom!=null)
            $str=' and unsubscribe_request.created_at>="'.$datefrom.'"';
        if($datefrom!=null)
            $str.=' and unsubscribe_request.created_at<="'.$dateto.'"';
        if($status!=null)
            $str.=' and unsubscribe_request.request_status="'.$status.'"';
        return DB::Select("select unsubscribe_request.*,users.role,
                        users.email,users.phone,
                     if(users.role='User',concat(name,' ',last_name),
                     (select name from member_resturants where member_resturants.username=unsubscribe_request.username)) as user_name
                    from unsubscribe_request,users where 
                        users.uniqueid=unsubscribe_request.username  
                    and users.status='1' ".$str."
                    ");
    }
    public function getAll_rest($username){
        return DB::Select("select unsubscribe_request.*,
                        (select name from food_types where food_types.id=member_resturants.food_types) as food_name,
                     member_resturants.name as rest_name,  working_hours_to,working_hours_from, food_types, website, contact_no, more_info, notes, star_rating, member_resturants.email as rest_email
                    from unsubscribe_request,member_resturants where 
                        member_resturants.username=unsubscribe_request.username  
                        and member_resturants.username='".$username."'  
                    and member_resturants.status='1'
                    ");
    }

}