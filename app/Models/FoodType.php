<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FoodType extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'food_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'name', 'created_at', 'createdby', 'updated_at', 'status'];	

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

    public function getAll_foods($foodtypes){
       return $this->select('name')->where('status', '1')->wherein('id', $foodtypes)->get();
    }
    

}