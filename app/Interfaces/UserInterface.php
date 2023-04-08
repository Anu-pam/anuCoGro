<?php

namespace App\Interfaces;

use App\Http\Requests\UserRegisterRequest;
use Symfony\Component\HttpFoundation\Request;

interface UserInterface
{
     /**
      * Get all users
      * 
      * @method  GET api/v1/users
      * @access  public
      */
     public function getAllUsers();

     /**
      * Get User By ID
      * 
      * @param   integer     $id
      * 
      * @method  GET api/v1/users/{id}
      * @access  public
      */
     public function getUserById($id);

     /**
      * Delete user
      * 
      * @param   integer     $id
      * 
      * @method  POST  api/v1/login
      * @access  public
      */
     public function loginUser($request);

     /**
      * Create | Update user
      * 
      * @param   \App\Http\Requests\UserRequest    $request
      * @param   integer                           $id
      * 
      * @method  POST    api/v1/register       For Create
      * @method  PUT     api/v1/users/{id}  For Update     
      * @access  public
      */
     public function requestUser(Request $request, $id = null);

     /**
      * Delete user
      * 
      * @param   integer     $id
      * 
      * @method  DELETE  api/v1/users/{id}
      * @access  public
      */
     public function deleteUser($id);


     /**
      * Update user Profile
      * 
      * @param   \App\Http\Requests\UserProfileRequest    $request
      * @param   integer                           $id
      * 
      * @method  PUT     api/v1/users/profile/update/{id}  For Update     
      * @access  public
      */
     public function requestUserProfile(Request $request, $id = null);

     /**
      * Update user Password
      * 
      * @param   \App\Http\Requests\UserChangePasswordRequest    $request
      * @param   integer                           $id
      * 
      * @method  PUT     api/v1/users/change/password/update/{id}  For Update     
      * @access  public
      */
     public function requestUserChangePassword(Request $request, $id = null);

     /**
      * Update user forgot password
      * 
      * @param   \App\Http\Requests\UserForgotPasswordRequest    $request
     
      */
     public function requestUserForgotpassword(Request $request);

     /**
      * Get User By ID
      * 
      * @param   integer     $id
      * 
      * @method  GET api/v1/users/{id}
      * @access  public
      */
     public function getUserByToken($token);

     /**
      * Update user forgot password
      * 
      * @param   \App\Http\Requests\UserResetPasswordRequest    $request
     
      */
     public function requestUserResetpassword(Request $request, $token = null);

     /**
      * Create | Update user
      * 
      * @param   \App\Http\Requests\UserNewRequest    $request
      * @param   integer                           $id
      * 
      * @method  POST    api/v1/register       For Create
      * @method  PUT     api/v1/users/{id}  For Update     
      * @access  public
      */
     public function requestNewUser(Request $request, $id = null);

     /**
      * Create | Update Professional
      * 
      * @param   \App\Http\Requests\ProfessionalRequest    $request
      * @param   integer                           $id
      * 
      * @method  POST    api/v1/register       For Create
      * @method  PUT     api/v1/users/{id}  For Update     
      * @access  public
      */
     public function requestNewProfessional(Request $request, $id = null);

     /**
      * Get all users
      * 
      * @method  GET api/v1/users
      * @access  public
      */
     public function getAllUsersList();



     /**
      * Update user forgot password
      * 
      * @param   \App\Http\Requests\UserForgotPasswordRequest    $request
     
      */
     public function forgotPasswordUser(Request $request);

     /**
      * Update user forgot password
      * 
      * @param   \App\Http\Requests\UserForgotPasswordRequest    $request
     
      */
     public function resetPasswordUser(Request $request);

     /**
      * Status Change User
      * 
      * @param   \App\Http\Requests\UserRequest    $request
      * 
      * @method  POST    api/v1/user/status/change       For Status Change
      * @access  public
      */
     public function statusChangeUser(Request $request);

     /**
      * Get all users Professional
      * 
      * @method  GET 
      * @access  public
      */
     public function getAllUsersProfessionalList();

     /**
      * Get all users Professional
      * 
      * @method  GET api/v1/professional/list
      * @access  public 
      */
     public function getAllUsersProfessionalListApi(Request $request);

     /**
      * Get all users Count
      * 
      * 
      * @access  public
      */
     public function getUserCount($type = "");

     /**
      * Get all users latest
      * 
      * 
      * @access  public
      */
     public function getLatestStaff();

     /**
      * Get email confirmation
      * 
      * 
      * @access  public
      */

     public function emailConfirmationUser($token);
     /**
      * Get Professional details
      * @param   integer              $id
      * 
      * @access  public
      */

     public function  getProfessionalDetails($id);
     /**
      * Get Professional services with login user
      * 
      * 
      * @access  public
      */

     public function getProfessionalServicesDetails();
     /**
      * Get Professional services delete
      * @param   integer              $id
      * 
      * @access  public
      */
     public function professionalServicesDelete($id);
     /**
      * Post Professional user update
      * 
      * 
      * @access  public
      */
     public function professionalUserUpdate(Request $request);
     /**
      * Post user update
      * 
      * 
      * @access  public
      */
     public function userUpdate(Request $request);

     /**
      * Get Professional Booking details
      * 
      * @access  public
      */
     public function getProfessionalBookingDetails();
     /**
      * Get User Booking details
      * 
      * @access  public
      */
     public function getUserBookingDetails();

     /**
      * save favorite Professional lists
      * 
      * @access  public
      */
      public function getUserBookingAllDetail($id);
      /**
      * Professional all details lists
      * 
      * @access  public
      */
      public function getProfessionalBookingAllDetail($id);
      /**
       * save favorite Professional lists
       * 
       * @access  public
       */

     public function saveUserFavProf(Request $request);
     
     /**
      * Get favorite Professional lists
      * 
      * @access  public
      */
     public function getFavProf(Request $request);

      /**
      * Get all Professional latest
      * 
      * 
      * @access  public
      */
      public function getLatestProfessional();

      /**
      * change available status
      * 
      * 
      * @access  public
      */
      public function availableStatus($request);
      /**
      * change notification status
      * 
      * 
      * @access  public
      */
      public function notificationStatus($request);
 /**
      * get user setting status
      * 
      * 
      * @access  public
      */
      public function getUserSetting();
      /**
      * Otp match by user
      * 
      * 
      * @access  public
      */
      public function checkUserOtp($request);

      public function getUserSettingupdate($request);
	  
      public function professionalDocumentStatusChange(Request $request);
	  
	  public function requestUserBookingReview(Request $request, $id);
	  
	  public function getReviews();

       public function userAddress();

       public function addAddress($id);

       public function deleteAddress($id);
       

}
