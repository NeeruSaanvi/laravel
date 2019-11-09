<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Notifications extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'username','notification', 'notifyurl', 'created_at', 'createdby', 'updated_at', 'status','view'];	

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
     * Update notification as read
     * 
     * @param array $data
     * @return boolean 
     */
     public function update_notification($data,$username,$createdby){
        $response = $this->where('username', $username)->where('createdby', $createdby)->update($data);
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
   
    public function getAll($uniqueid=null){
        if($uniqueid==null)
             return $this->where('status',1)->orderBy('id','desc')->get();
        else
            return $this->where('username',$uniqueid)->where('status',1)->orderBy('id','desc')->get();
    }

  
  
}