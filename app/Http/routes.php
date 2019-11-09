<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

//Route::get('/', ['as' => 'home', 'uses' => 'UserController@index']);
//Route::get('/home', ['uses' => 'UserController@index']);
//Route::get('/who-we-are', ['as' => 'who-we-are', 'uses' => 'UserController@who_we_are']);
//Route::get('/works', ['as' => 'works', 'uses' => 'UserController@works']);
//Route::get('/faq', ['as' => 'faq', 'uses' => 'UserController@faq']);

//Route::get('/404.html', ['as' => '404', 'uses' => 'HomeController@erorr404']);
//Route::get('/503.html', ['as' => '404', 'uses' => 'HomeController@erorr503']);
//Route::get('/checkuser', ['as' => 'checkuser', 'uses' => 'Auth\AuthController@checkuser']);

/*
 * User Register Routes
 */

Route::get('/user-register-step-1', ['uses' => 'UserController@registerStepOne', 'as' => 'user-register-step-one']);
Route::get('/user-register-step-2', ['uses' => 'UserController@registerStepTwo', 'as' => 'user-register-step-two']);
Route::post('/user-register-step-1', ['uses' => 'UserController@registerStepOneSubmit', 'as' => 'user-register-step-one-submit']);
Route::post('/user-register-step-2', ['uses' => 'UserController@registerStepTwoSubmit', 'as' => 'user-register-step-two-submit']);

Route::get('/user-register-step-3', ['uses' => 'UserController@registerStepThree', 'as' => 'user-register-step-three']);
Route::post('/user-register-step-3', ['uses' => 'UserController@registerStepThreeSubmit', 'as' => 'user-register-step-three-submit']);
Route::get('/browse', ['uses' => 'UserController@browse', 'as' => 'user-browse']);
Route::post('/browsefilter', ['uses' => 'UserController@browsefilter', 'as' => 'user-browse-filter']);
Route::get('/browseall', ['uses' => 'UserController@browseall', 'as' => 'browseall']);
Route::get('/restcount', ['uses' => 'UserController@restcount', 'as' => 'restcount']);
Route::get('/user', ['as' => 'user_home', 'uses' => 'UserController@home']);


Route::get('/rest_detail/{uniqueid}', ['as' => 'rest_details', 'uses' => 'UserController@rest_detail']);
Route::get('/user/couponlist', ['uses' => 'UserController@restoffer']);
Route::get('/user/couponhistory', ['uses' => 'UserController@restoffer_used']);
Route::get('/user/user-profile', ['uses' => 'UserController@userProfile', 'as' => 'user-profile']);
Route::post('/user/profile-update', ['uses' => 'UserController@userProfileUpdate', 'as' => 'profile-update']);
Route::get('/user/couponall', ['uses' => 'UserController@couponall']);

Route::post('/user', ['uses' => 'UserController@unsubscribe_post']);
Route::get('/user/unsubscribe', ['as' => 'user_unsubscribe', 'uses' => 'UserController@unsubscribe']);

Route::get('/user/change_pwd', ['as' => 'user_change_pwd', 'uses' => 'UserController@change_pwd']);
Route::post('/user/change_pwd', ['uses' => 'UserController@change_pwdpost']);



Route::get('/chose/offer/{uniqueid}/{restid}', ['uses' => 'UserController@chose_offer']);

Route::get('/ajaxstates', ['uses' => 'UserController@ajaxStates']);


Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::controllers([
    'password' => 'Auth\PasswordController',
]);

Route::get('/user/notifications', ['uses' => 'UserController@notifications_all']);
Route::post('/user/rating/{uniqueid}', ['uses' => 'UserController@user_rating']);

//////////////////////////////////// Admin //////////////////////////////////////

Route::get('/admin', ['as' => 'admin_home', 'uses' => 'AdminController@home']);

Route::get('/admin/foodtype/{uniqueid?}', ['as' => 'foodtype_add', 'uses' => 'AdminController@foodtype_add']);
Route::post('/admin/foodtype/{uniqueid?}', ['as' => 'foodtype_add_post', 'uses' => 'AdminController@foodtype_add_post']);
Route::get('/admin/foodtype/delete/{uniqueid}', ['as' => 'foodtype_delete', 'uses' => 'AdminController@foodtype_delete']);

Route::get('/admin/offers/{uniqueid?}', ['as' => 'offers_add', 'uses' => 'AdminController@offers_add']);
Route::post('/admin/offers/{uniqueid?}', ['as' => 'offers_add_post', 'uses' => 'AdminController@offers_add_post']);
Route::get('/admin/offers/delete/{uniqueid}', ['as' => 'offers_delete', 'uses' => 'AdminController@offers_delete']);

Route::get('/admin/offercode/{uniqueid?}', ['as' => 'offercode_add', 'uses' => 'AdminController@offercode_add']);
Route::post('/admin/offercode/{uniqueid?}', ['as' => 'offercode_add_post', 'uses' => 'AdminController@offercode_add_post']);
Route::get('/admin/offercode/delete/{uniqueid}', ['as' => 'offercode_delete', 'uses' => 'AdminController@offercode_delete']);

Route::get('/admin/resturant/{uniqueid?}', ['as' => 'resturant_add', 'uses' => 'AdminController@resturant_add']);
Route::post('/admin/resturant/{uniqueid?}', ['as' => 'resturant_add_post', 'uses' => 'AdminController@resturant_add_post']);

Route::get('/admin/users/{uniqueid?}', ['as' => 'users_add', 'uses' => 'AdminController@users_add']);
Route::post('/admin/users/{uniqueid?}', ['as' => 'users_add_post', 'uses' => 'AdminController@users_add_post']);


Route::get('/admin/resturant_images/{uniqueid?}', ['as' => 'resturant_images_add', 'uses' => 'AdminController@resturantimages_add']);
Route::post('/admin/resturant_images/{uniqueid?}', ['as' => 'resturant_images_add_post', 'uses' => 'AdminController@resturantimages_add_post']);
Route::get('/admin/resturant_images/delete/{uniqueid}', ['uses' => 'AdminController@resturantimages_delete']);

Route::get('/admin/resturant_menu/{uniqueid?}', ['as' => 'resturant_menu_add', 'uses' => 'AdminController@resturant_menu_add']);
Route::post('/admin/resturant_menu/{uniqueid?}', ['as' => 'resturant_menu_add_post', 'uses' => 'AdminController@resturant_menu_add_post']);
Route::get('/admin/resturant_menu/delete/{uniqueid}', ['uses' => 'AdminController@resturant_menu_delete']);


Route::get('/admin/ajaxstates', ['as' => 'ajaxstates', 'uses' => 'AdminController@ajaxStates']);

Route::get('/admin/change_pwd', ['as' => 'admin_change_pwd', 'uses' => 'AdminController@change_pwd']);
Route::post('/admin/change_pwd', ['uses' => 'AdminController@change_pwdpost']);
Route::get('/admin/notifications', ['as' => 'admin_notifications_all', 'uses' => 'AdminController@notifications_all']);

Route::get('/admin/useroffer', ['as' => 'admin_useroffers', 'uses' => 'AdminController@useroffers']);
Route::get('/admin/useroffer/delete/{uniqueid?}', ['uses' => 'AdminController@useroffers_delete']);
Route::get('/admin/resturant_unsubscribe', ['uses' => 'AdminController@resturant_unsubscribe']);
Route::get('/admin/unsubscribe_rest/{uniqueid}', ['uses' => 'AdminController@unsubscribe_rest']);

Route::get('/admin/restoffer', ['as' => 'admin_restoffer', 'uses' => 'AdminController@restoffer']);
Route::get('/admin/restoffer/delete/{uniqueid?}', ['uses' => 'AdminController@restoffer_delete']);

Route::get('/admin/newsletter', ['uses' => 'AdminController@newsletter_list']);


Route::get('/activate/{uniqueid}', ['uses' => 'UserController@verify_mail']);

Route::get('/resend/{uniqueid}', ['uses' => 'UserController@resend_mail']);
Route::get('/notificationsview/{id}', ['as' => 'adview', 'uses' => 'UserController@notificationsview_update']);


Route::get('/username', ['as' => 'ajaxusername', 'uses' => 'UserController@ajaxusername']);

Route::get('/timer', ['uses' => 'UserController@timer']);

/* * ************************ Restaurant ********************************** */




Route::get('/resturant', ['as' => 'rest_home', 'uses' => 'RestaurantController@home']);
Route::get('/resturant/resturant/{uniqueid?}', ['as' => 'rest_add', 'uses' => 'RestaurantController@resturant_add']);
Route::post('/resturant/resturant/{uniqueid?}', ['as' => 'rest_add_post', 'uses' => 'RestaurantController@resturant_add_post']);

Route::get('/resturant/resturant_images/{uniqueid?}', ['as' => 'rest_images_add', 'uses' => 'RestaurantController@resturantimages_add']);
Route::post('/resturant/resturant_images/{uniqueid?}', ['as' => 'rest_images_add_post', 'uses' => 'RestaurantController@resturantimages_add_post']);
Route::get('/resturant/resturant_images/delete/{uniqueid}', ['uses' => 'RestaurantController@resturantimages_delete']);

Route::get('/resturant/resturant_menu/{uniqueid?}', ['as' => 'rest_menu_add', 'uses' => 'RestaurantController@resturant_menu_add']);
Route::post('/resturant/resturant_menu/{uniqueid?}', ['as' => 'rest_menu_add_post', 'uses' => 'RestaurantController@resturant_menu_add_post']);
Route::get('/resturant/resturant_menu/delete/{uniqueid}', ['uses' => 'RestaurantController@resturant_menu_delete']);

Route::get('/resturant/change_pwd', ['as' => 'resturant_change_pwd', 'uses' => 'RestaurantController@change_pwd']);
Route::post('/resturant/change_pwd', ['uses' => 'RestaurantController@change_pwdpost']);

Route::get('/resturant/useroffer/{view?}', ['as' => 'rest_useroffers', 'uses' => 'RestaurantController@useroffers']);
Route::get('/resturant/useroffer/redeem/{uniqueid?}', ['uses' => 'RestaurantController@useroffers_redeem']);

Route::post('/resturant', ['uses' => 'RestaurantController@unsubscribe_post']);
Route::get('/resturant/unsubscribe', ['as' => 'rest_unsubscribe', 'uses' => 'RestaurantController@unsubscribe']);

Route::get('/resturant/ajaxstates', ['uses' => 'RestaurantController@ajaxStates']);
Route::get('/resturant/notifications', ['uses' => 'RestaurantController@notifications_all']);

/* * *************************************API ********************************* */

Route::post('/api/checklogin', ['uses' => 'APIController@checklogin']);
Route::post('/api/register', ['uses' => 'APIController@register']);



//memberChecklogin

Route::post('/api/register2', ['uses' => 'APIController@register2']);
Route::get('/api/countries', ['uses' => 'APIController@ajaxCountry']);
Route::get('/api/usercouponlist', ['uses' => 'APIController@restoffer']);
Route::get('/api/restcouponlist', ['uses' => 'APIController@useroffers']);
Route::post('/api/redeem_offer', ['uses' => 'APIController@redeem_offer']);
Route::get('/api/resturant_menulist/{uniqueid?}', ['uses' => 'APIController@resturant_menulist']);
Route::get('/api/resturantimageslist/{uniqueid?}', ['uses' => 'APIController@resturantimageslist']);
Route::get('/api/resturantlist/{uniqueid?}', ['uses' => 'APIController@resturantlist']);
Route::get('/api/offercodelist', ['uses' => 'APIController@offercodelist']);
Route::get('/api/offerslist/{uniqueid?}', ['uses' => 'APIController@offerslist']);
Route::get('/api/foodtypelist', ['uses' => 'APIController@foodtypelist']);
Route::get('/api/profile/{email}', ['uses' => 'APIController@userProfile']);
Route::post('/api/profile', ['uses' => 'APIController@users_add_post']);

Route::post('/api/chose_offer', ['uses' => 'APIController@chose_offer']);
Route::get('/api/check_coupon', ['uses' => 'APIController@check_coupon']);
Route::post('/api/changepwd', ['uses' => 'APIController@change_pwdpost']);



Route::post('/api/fileupload', ['uses' => 'APIController@upload']);

Route::post('/api/resturant_edit', ['uses' => 'APIController@resturant_add_post']);
Route::get('/api/notifications/{uniqueid}', ['uses' => 'APIController@notifications_all']);
Route::post('/api/notificationsview', ['uses' => 'APIController@notificationsview_update']);
Route::post('/api/resturant_menu', ['uses' => 'APIController@resturant_menu_add_post']);
Route::get('/api/resturant_menu/{uniqueid?}', ['uses' => 'APIController@resturant_menu_add']);
Route::get('/api/resturant_menu/delete/{uniqueid}', ['uses' => 'APIController@resturant_menu_delete']);
Route::post('/api/resturant_images', ['uses' => 'APIController@resturantimages_add_post']);
Route::get('/api/resturant_images/delete/{uniqueid}', ['uses' => 'APIController@resturantimages_delete']);

// apis created by EPL

Route::post('/api/SendOTP', ['uses' => 'MemberAPIController@SendOTP']);
Route::post('/api/changeMemberPassword', ['uses' => 'MemberAPIController@changeMemberPassword']);
Route::post('/api/registerMember', ['uses' => 'MemberAPIController@registerMember']);
Route::post('/api/memberChecklogin', ['uses' => 'MemberAPIController@memberChecklogin']);
Route::get('/api/states', ['uses' => 'APIController@ajaxStates']);
Route::get('/api/citiesByState', ['uses' => 'APIController@getCityByState']);

Route::get('/api/GetAllRestaurants', ['uses' => 'RestaurantAPIController@getAllRestaurants']);
Route::get('/api/getServersByRestaurant', ['uses' => 'RestaurantAPIController@getServersByRestaurant']);

Route::post('/api/GetFilteredRestaurants', ['uses' => 'RestaurantAPIController@getFilteredRestaurants']);
Route::get('/api/GetFoodTypes', ['uses' => 'RestaurantAPIController@GetFoodTypes']);

Route::post('/api/verifyMemberEmail', ['uses' => 'MemberAPIController@verifyMemberEmail']);
Route::post('/api/SaveOrderWithoutMenu', ['uses' => 'RestaurantAPIController@SaveOrderWithoutMenu']);
Route::get('/api/getMemberOrderHistory', ['uses' => 'RestaurantAPIController@getMemberOrderHistory']);
Route::get('/api/getOrderInformationByOrderId', ['uses' => 'RestaurantAPIController@getOrderInformationByOrderId']);
Route::get('/api/getRestaurantById', ['uses' => 'RestaurantAPIController@getRestaurantById']);
Route::get('/api/getFeedbackTypesByOffer', ['uses' => 'RestaurantAPIController@getFeedbackTypesByOffer']);
Route::post('/api/SaveMemberFeedback', ['uses' => 'RestaurantAPIController@SaveMemberFeedback']);
Route::get('/api/GetMyReferralSummary', ['uses' => 'MemberAPIController@GetMyReferralSummary']);
Route::get('/api/getRestaurantMenuByOffer', ['uses' => 'RestaurantAPIController@getRestaurantMenuByOffer']);
Route::post('/api/SaveOrderForNonBOGOOffers', ['uses' => 'RestaurantAPIController@SaveOrderForNonBOGOOffers']);
Route::get('/api/getOrderItemsByOrderId', ['uses' => 'RestaurantAPIController@getOrderItemsByOrderId']);
Route::post('/api/UpdateMemberProfile', ['uses' => 'MemberAPIController@UpdateMemberProfile']);
Route::get('/api/GetmemberUsedInvites', ['uses' => 'MemberAPIController@GetmemberUsedInvites']);
Route::get('/api/GetReferralCodeByMemberId', ['uses' => 'MemberAPIController@GetReferralCodeByMemberId']);
//SendOrderMail
Route::post('/api/SendOrderMail', ['uses' => 'RestaurantAPIController@SendOrderMail']);
//Getalloffer
Route::get('/api/Getalloffer', ['uses' => 'RestaurantAPIController@Getalloffer']);
//getFavouriteRestaurants
Route::get('/api/getFavouriteRestaurants', ['uses' => 'RestaurantAPIController@getFavouriteRestaurants']);

Route::get('/api/getMemberOrderHistoryByOfferId', ['uses' => 'RestaurantAPIController@getMemberOrderHistoryByOfferId']);

Route::get('/api/GetFilteredRestaurants', ['uses' => 'RestaurantAPIController@GetFilteredRestaurants']);

Route::post('/api/SaveFavouriteRestaurant', ['uses' => 'RestaurantAPIController@SaveFavouriteRestaurant']);
//getPaymentHistory
Route::get('/api/getPaymentHistory', ['uses' => 'MemberAPIController@getPaymentHistory']);
//getMemberbyId
Route::get('/api/getMemberbyId', ['uses' => 'MemberAPIController@getMemberbyId']);
//ApplyOffer
Route::post('/api/ApplyOffer', ['uses' => 'MemberAPIController@ApplyOffer']);
//SaveCustomerId
Route::post('/api/SaveCustomerIdAndInfo', ['uses' => 'MemberAPIController@SaveCustomerIdAndInfo']);
//

Route::post('/api/CreateUserWithPayment', ['uses' => 'PaymentAPIController@CreateUserWithPayment']);
//CreateUserWithPayment

Route::get('/api/demoApi', ['uses' => 'PaymentAPIController@demoApi']);
Route::get('/api/GetMember', ['uses' => 'PaymentAPIController@GetMember']);
//MakeANotification

Route::get('/api/MakeANotification', ['uses' => 'MemberAPIController@MakeANotification']);
//getMembersUnreadNotification
Route::get('/api/getMembersUnreadNotification', ['uses' => 'RestaurantAPIController@getMembersUnreadNotification']);

//UpdateNotificationsStatus

Route::post('/api/UpdateNotificationsStatus', ['uses' => 'RestaurantAPIController@UpdateNotificationsStatus']);
//getMemberTotalUnreadNotification
Route::get('/api/getMemberTotalUnreadNotification', ['uses' => 'MemberAPIController@getMemberTotalUnreadNotification']);
//checkForMemberLastOrderReview
Route::get('/api/checkForMemberLastOrderReview', ['uses' => 'RestaurantAPIController@checkForMemberLastOrderReview']);
//setOrderReviewFlag
Route::get('/api/setOrderReviewFlag', ['uses' => 'RestaurantAPIController@setOrderReviewFlag']);
//getMenuTypes
Route::get('/api/getMenuTypes', ['uses' => 'RestaurantAPIController@getMenuTypes']);
//getRestaurantMenuByMenuType

Route::get('/api/getRestaurantMenuByMenuType', ['uses' => 'RestaurantAPIController@getRestaurantMenuByMenuType']);
Route::get('/api/TestNotification', ['uses' => 'MemberAPIController@TestNotification']);