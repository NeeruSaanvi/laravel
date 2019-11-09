<?php

/*
  |--------------------------------------------------------------------------
  | Admin Panel Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling all admin functions like
  | masters, all other admin activities
  |
 */

namespace App\Http\Controllers;

//************* All Included References*****************//
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Supprort\Facades\Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\FoodType;
use App\Models\UserRating;
use App\Models\CommonMethods;
use App\Models\Payment;
use View;
use Hash;
use DB;

//********************* Start Class ****************//
class RestaurantAPIController extends Controller {

    //****************** declare all common varible for all referenced models**************// 
    protected $newData = [];
    protected $userdata, $restaurant, $usrrating, $common;

    //****************** declare contructor for admin controller **************// 

    public function __construct(\Illuminate\Routing\Redirector $redirecor) {
        //****************** define all common varible for all referenced models**************// 
        $this->restaurant = new Restaurant;
        $this->usrrating = new UserRating;
        $this->common = new CommonMethods;
        $this->payment = new Payment;
    }

    protected $rules = [
    ];
    protected $messages = [
    ];

    function console_log($data) {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    public function SaveFavouriteRestaurant(Request $Request) {

        $restaurant = new Restaurant;

        $result = $restaurant->SaveFavouriteRestaurant($Request);
        return $result;
    }

    public function getRestaurantById(Request $Request) {

        $restaurant = new Restaurant;

        $result = $restaurant->GetRestaurantById($Request['restid']);
        if ($result != null) {
            echo json_encode($result);
        } else {
            $array['message'] = 'unable to load restaurant';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getAllRestaurants(Request $request, $uniqueid = null) {

        $restaurant = new Restaurant;
        if ($uniqueid > 0 && $uniqueid != null) {
            $result = $restaurant->get_id($uniqueid);
            if ($result != null) {
                echo json_encode($result);
            } else {
                $array['message'] = 'unable to load restaurant';
                $array['status'] = 'error';
                echo json_encode($array);
            }
        } else {
            $result = $restaurant->getAll();
            if ($result != null) {

                if ($request->has('page')) {
                    if (count($result) / 2000 >= $request['page'])
                        $result = new Paginator($result, 2000, $request['page']);
                    else
                        $result = null;
                }

                echo json_encode($result);
            }
            else {
                $array['message'] = 'unable to load restaurants';
                $array['status'] = 'error';
                echo json_encode($array);
            }
        }
    }

    public function GetFilteredRestaurants(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->GetFilteredRestaurants($request);
        if ($result != null) {

            if ($request->has('page')) {
                if (count($result) / 2000 >= $request['page'])
                    $result = new Paginator($result, 2000, $request['page']);
                else
                    $result = null;
            }

            echo json_encode($result);
        }
        else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getMenuTypes() {

        $restaurant = new Restaurant;
        $result = $restaurant->getMenuTypes();
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'success!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {

            $array['message'] = 'error!';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function checkForMemberLastOrderReview(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->checkForMembersLastOrderReview($request['memberid']);
        if ($result != null) {
            $array['data'] = $result[0];
            $array['message'] = 'success!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {

            $array['message'] = 'error!';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getOrderInformationByOrderId(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getOrderinformationByOrderId($request['orderid']);
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'orders loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getMembersUnreadNotification(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getMembersUnreadNotifications($request['memberid']);

        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'notifications loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load notifications';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function UpdateNotificationsStatus(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->UpdateNotificationsStatus($request['memberid']);
        if ($result) {

            $array['message'] = 'notifications updated successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to update notifications';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getMemberOrderHistory(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getMemberOrderHistory($request['memberid']);
        if ($result != null) {
            $array['data'] = $result;

            $array['message'] = 'orders loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getFavouriteRestaurants(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getFavouriteRestaurants($request['memberid']);
        if ($result != null) {
            $array['data'] = $result;

            $array['message'] = 'rest loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getMemberOrderHistoryByOfferId(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getMemberOrderHistoryByOffer($request['memberid'], $request['OfferId']);
        if ($result != null) {
            $array['data'] = $result;

            $array['message'] = 'orders loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function setOrderReviewFlag(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->setOrderReviewFlag($request['orderid']);
        if ($result) {

            $array['message'] = 'updated successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to update ' . $request['orderid'];
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getFeedbackTypesByOffer(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getFeedbackByOfferId($request['offerid']);
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'feedback loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load feedback';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function SaveMemberFeedback(Request $request) {


        $usrrating = new UserRating;
        //'MemberId', 'Remarks', 'CreatedDate', 'TransactionNo', 'OrderNo'
        $usrrating->MemberId = $request['MemberId'];
        $usrrating->Remarks = $request['Remarks'];
        $usrrating->TransactionNo = $request['TransactionNo'];
        $usrrating->OrderNo = $request['OrderNo'];
        $usrrating->OfferId = $request['OfferId'];
        $usrrating->OfferType = $request['OfferType'];
        $usrrating->CreatedDate = date("Y-m-d H:i:s");


        $usrrating->save();

        $restaurant = new Restaurant;
        $result = $restaurant->SaveMemberFeedback($request, $usrrating->id);
        if ($result != null) {
            $array['data'] = $usrrating->id;
            $array['message'] = 'feedback added successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to add feedback';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getServersByRestaurant(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getServersByRestaurant($request['restid']);
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'Restaurants loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    //SendOrderMail
    public function SendOrderMail(Request $request) {


        $common = new CommonMethods;
        $body = $request['body'];
        $result = $common->SendMail('Order Confirmation Mail', $body, $request['email']);
        if ($result != null) {
            // send confirmation email as well

            $array['data'] = $result;
            $array['message'] = 'Order Saved Successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to save order';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function SaveOrderWithoutMenu(Request $request) {


        $restaurant = new Restaurant;

        $result = $restaurant->SaveOrderWithoutMenu($request);
        if ($result != null) {
            // send confirmation email as well
            
             $array['message'] = 'order saved successfully!';
             $array['status'] = 'success';
            $array['data'] = $result;
            $chargeAmount = 0;
            if ($request['offeridParam'] == 4) {
                $chargeAmount = 30;
            } else if ($request['offeridParam'] == 5) {
                $chargeAmount = 25;
            }
            /*if ($request['offeridParam'] == 4 || $request['offeridParam'] == 5) {
                $payment = new Payment;
                 
                    $response = $payment->ChargeCard($chargeAmount, $request["CustomerId"], $request['memberidParam'],"Customer Order Payment");
                    if ($response == true) {
                       
                    } else {
                        DB::table('ordermaster')
                                ->where('orderid', $result[0]->orderno)
                                ->update(['IsActive' => 0]);
                        $array['message'] = $response;
                        $array['status'] = 'failed';
                    }
                 
            }*/

            echo json_encode($array);
        } else {
            $array['message'] = 'unable to save order';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function GetFoodTypes() {

        $foodtypes = new FoodType;
        $result = $foodtypes->getAll();
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'food types loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load food types';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getRestaurantMenuByOffer(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getRestaurantMenuByOffer($request['restid'], $request['offerid']);
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'Restaurants loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getRestaurantMenuByMenuType(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getRestaurantMenuByMenuType($request['restid'], $request['menutype'], $request['offerid']);
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'menus loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load menus';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function Getalloffer() {

        $restaurant = new Restaurant;
        $result = $restaurant->GetAllOffers();
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'offers loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load restaurants';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function SaveOrderForNonBOGOOffers(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->SaveOrderForNonBOGOOffers($request);
        if ($result != null) {
            $array['data'] = $result;
            if ($result[0] != null) {
               /* $payment = new Payment;
                $response = $payment->ChargeCard($request['dueAmountParam'], $result[0]->CustomerId, $request['memberidParam'],"Customer Order Payment");
                if ($response == true) {
                    $array['message'] = 'order saved successfully!';
                    $array['status'] = 'success';
                } else {
                    DB::table('ordermaster')
                            ->where('orderid', $result[0]->orderno)
                            ->update(['IsActive' => 0]);
                    $array['message'] = 'Order Failed due to payment!';
                    $array['status'] = 'failed';
                }*/
                     $array['message'] = 'order saved successfully!';
                    $array['status'] = 'success';
            }


            echo json_encode($array);
        } else {
            $array['message'] = 'unable to save order';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

    public function getOrderItemsByOrderId(Request $request) {

        $restaurant = new Restaurant;
        $result = $restaurant->getOrderItemsByOrderId($request['orderid']);
        if ($result != null) {
            $array['data'] = $result;
            $array['message'] = 'order items loaded successfully!';
            $array['status'] = 'success';
            echo json_encode($array);
        } else {
            $array['message'] = 'unable to load order items';
            $array['status'] = 'error';
            echo json_encode($array);
        }
    }

}
