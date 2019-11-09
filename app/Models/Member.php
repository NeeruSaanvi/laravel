<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Member extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'memberdetails';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['memberid', 'username', 'memberpwd', 'passwordhintid', 'passwordhintans', 'memberemail', 'website', 'mktmessage', 'memberfirstname', 'memberlastname', 'companyname', 'address1', 'address2', 'city', 'stateid', 'countryid', 'zip', 'usphoneno', 'uscell', 'fax', 'referredby', 'frontadv', 'topadv', 'freeproof', 'paymenttype', 'nameoncc', 'ccno', 'expirationdate', 'securitycode', 'billaddress', 'addresspay', 'citystatezip', 'bankname', 'routingnno', 'checkno', 'accno', 'ordernotes', 'promocode', 'membertype', 'folowupdate', 'salespersonid', 'IsEmailVerified', 'CustomerId','devicetoken','FavFeature'];

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
        $response = $this->where('memberid', $id)->update($data);
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
        $response = $this->where('memberid', $id)->delete();
        if ($response) {

            return true;
        } else {
            return false;
        }
    }

    public function get_id($id) {
        return $this->where('memberid', $id)->get()->first();
    }

    public function getMemberByEmail($email) {


        return $this->where('memberemail', $email)->get()->first();
    }

    public function CheckMemberForLogin($email, $password) {

		return $this->where([['memberemail', '=', $email], ['memberpwd', '=', $password]])->get()->first();
    
	} 
    
     public function UpdateMemberDeviceToken($email, $token) {

         if($token!=null && $token!='')
         {
              $data=array("devicetoken"=>$token);
           $this->where('username', $email)->update($data);
         
         }
           
    }
    
    

    public function getAll() {
        return $this->where('status', '1')->get();
    }

    public function getMemberIdBy($memberid) {
        return DB:: select("select mem.*,ct.CityName,st.state as StateName,con.country as CountryName from 
memberdetails as mem 
left join city as ct on ct.Id=mem.city
left join states as st on st.stateid=mem.stateid
left join country as con on con.countryid=mem.countryid where mem.memberid=" . $memberid . "     limit 1");
    }

    public function update_pwd($username, $data) {
        $response = $this->where('username', $username)->update($data);
        if ($response) {
            return true;
        } else {
            return false;
        }
    }

    public function ApplyOffer($refferalId, $memberid) {

        $response = DB::select('call spApplyOffer('
                        . $memberid . ","
                        . $refferalId . ')');
        if ($response) {
            return true;
        } else {
            return false;
        }
    }

    public function SaveCustomerIdAndInfo($memberid, $customerid, $amount, $receiptno, $type) {
       
        
      $response=  DB:: Select ('call spSaveCustomerIdAndInfo  ('.$memberid.",'"
                     .$customerid."','"
                     .date('Y-m-d')."')"
                );
                    

        $arr = array("memberid" => $memberid, "Date" => date('Y-m-d H:i:s'), "CustomerId" => $customerid, "Amount" => $amount, "MethodName" => $type, "GatewayReceiptNo" => $receiptno);
        DB::table('paymentinfo')->insert($arr);


        if ($response) {
            return $memberid;
        } else {
            return false . " " . $memberid;
        }
    }

    public function VerifyMemberEmail($memberid, $data) {
        $response = $this->where('memberid', $memberid)->update($data);
        if ($response) {
            return true;
        } else {
            return false;
        }
    }

    public function GetMyReferralSummary($member) {
        $str = " select (SELECT DATE_FORMAT(ref.JoinDate, '%m/%d/%y')) JoinedDate,  ref.*,mem.memberfirstname,mem.memberlastname,joiner.memberfirstname as JoinerFirstName,
joiner.memberlastname JoinerLastName,ifnull((select 1 from memberrefferal where Id=ref.Id and IsAvailable=1 and Datediff(now(),ref.JoinDate)>31),0) canApply FROM memberrefferal as ref
inner join memberdetails as mem on mem.memberid=ref.MemberId 
left join memberdetails as joiner on joiner.memberid=ref.JoinedMember where  ref.memberid=" . $member;
        return DB::Select($str);
    }

    public function getPaymentHistory($member) {
        $str = "select * from  
(select MemberId,MethodName,TransactionNo,GatewayReceiptNo, Date_Format(date,'%m/%d/%y') As ConvertedDate,Amount , 0 IfReferral from paymentinfo  
where memberid=".$member."
UNION 
select ref.Memberid, Concat( mem.memberfirstname,' ',mem.memberlastname) as MethodName,ref.ReferralCode as TransactionNo, ref.ReferralCode as GatewayReceiptNo,
Date_Format(ref.JoinDate,'%m/%d/%y') As ConvertedDate,BonusAmount as Amount , 1 IfReferral  from memberrefferal as ref 
inner join memberdetails as mem on mem.memberid=ref.JoinedMember where IsAvailable=0
and IsUsed=1 and ref.memberid=".$member." ) as tbl
order by ConvertedDate desc";

        return DB::Select($str);
    }
    
     public function getTotalCreditsAndNextDueDate($memberid)
    {   
        $str="select ifnull(sum(bonusamount),0) as TotalReferralAmount,  
  DATE_FORMAT(    DATE_ADD((select LAST_DAY(now())), INTERVAL day((select JoinDate from memberdetails where MemberId=".$memberid.")) DAY),'%m/%d/%y')  as NextDueDate from memberrefferal where memberid=  ".$memberid;
        return DB::Select($str);
    } 

    public function getUsedInvites($member) {
        $str = "select (SELECT DATE_FORMAT(ref.JoinDate, '%m/%d/%y')) JoinedDate, 
            ref.*,mem.memberfirstname,mem.memberlastname,
            joiner.memberfirstname as JoinerFirstName,
joiner.memberlastname JoinerLastName,
DATE_FORMAT( 
DATE_ADD(ref.JoinDate,INTERVAL 31 DAY ),'%m/%d/%y') as NextMonthDate FROM memberrefferal as ref
inner join memberdetails as mem on mem.memberid=ref.MemberId 
left join memberdetails as joiner on joiner.memberid=ref.JoinedMember where   ref.memberid=" . $member;

        return DB::Select($str);
    }

    public function getUnreadNotificationCount($member) {
        $str = "SELECT count(id) as TtlCount from notification where IsRead=0 and memberid=" . $member;

        return DB::Select($str);
    }

    public function GetMemberByReferralCode($referralCode) {
        $str = "select c.MemberId ,(select devicetoken from memberdetails where memberid= c.memberid limit 1) as devicetoken from memberreferralcodes as c where ReferralCode ='" . $referralCode . "'";

        return DB::Select($str);
    }

    public function GetReferralCodeByMemberId($memberid) {
        $str = "select MemberId,ReferralCode from memberreferralcodes where IsActive=1 and  MemberId =" . $memberid;

        return DB::Select($str);
    }

}
