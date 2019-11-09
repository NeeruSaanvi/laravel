<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'uniqueid', 'name', 'email', 'password', 'role', 'last_name', 'phone', 'building', 'street', 
        'city', 'state', 'country', 'pincode', 'image', 'three_code', 'work_status', 'work_type',
         'dine_out', 'offer_like', 'offer_code', 'newsletter', 'remember_token', 'created_at', 'updated_at', 
         'status', 'last_login', 'logout_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
    public function update_entry($data,$uniqueid){
        $response = $this->where('uniqueid', $uniqueid)->update($data);
        if($response){
            return true;
        }else{
            return false;
        }
     }

     /**
     * Update password
     * 
     * @param array $data
     * @return boolean 
     */
    public function update_pwd($username,$data)
    {
        $response = $this->where('uniqueid', $username)->update($data);
        if($response){
            return true;
        }else{
            return false;
        }
    }
    
    
     public function getcountries()
    {   
        $str="select * from country";
        return DB::Select($str);
    }
    
    //getCityByState
     public function getstates()
    {   
        $str="select * from states";
        return DB::Select($str);
    }
    
     public function getCityByState($state)
    {   
        $str="select * from city where state=".$state;
        return DB::Select($str);
    }
 public function getCity()
    {   
        $str="select * from city";
        return DB::Select($str);
    }
    
    

    


    

}
