<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OfferCodes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offer_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
	protected $fillable = ['id', 'name', 'offer_code', 'created_at', 'updated_at', 'createdby', 'status'];	

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

    

}