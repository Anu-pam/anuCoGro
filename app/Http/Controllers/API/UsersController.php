<?php



namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends BaseController
{
    protected $userInteface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Register User api 
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        return $this->userInterface->requestUser($request);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    { 
        return $this->userInterface->loginUser($request);
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)){
            
            User::where('id',$user->id)->update(['uidToken'=>null]);
            $user->token()->revoke();

        }
        return $this->sendResponse(['message'=>'logout','status'=>200],'data');
    }
	 /**
     * ForgotPassword api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        return $this->userInterface->forgotPasswordUser($request); 
    }
	/** 
     * ResetPassword api
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    { 
        return $this->userInterface->resetPasswordUser($request);
    }
	public function getAllProfessionalList(Request $request){
		return $this->userInterface->getAllUsersProfessionalListApi($request);
	}
	public function emailConfirmation(Request $request,$token)
    { 
		return $this->userInterface->emailConfirmationUser($token);
    }
	public function getProfessionalDetails($id){
		return $this->userInterface->getProfessionalDetails($id);
	}
	public function getProfessionalServices(){ 
        return $this->userInterface->getProfessionalServicesDetails();
    }
    public function professionalServicesDelete($id){
        return $this->userInterface->professionalServicesDelete($id);
    }
    public function professionalUserUpdate(Request $request){
        return $this->userInterface->professionalUserUpdate($request);
    }
    public function UserUpdate(Request $request){
        return $this->userInterface->userUpdate($request);
    }
    public function getProfessionalBooking(){
        return $this->userInterface->getProfessionalBookingDetails();
    }
    public function getProfessionalUpcomingBooking(){
        return $this->userInterface->getProfessionalUpcomingBookingDetails();
    }
    public function getUserBooking(){
        return $this->userInterface->getUserBookingDetails();
    }
    public function getUserUpcomingBooking(){
        return $this->userInterface->getUserUpcomingBookingDetails();
    }
    public function getUserBookingAllDetail($id){
        return $this->userInterface->getUserBookingAllDetail($id);
    }
    public function getProfessionalBookingAllDetail($id){
        return $this->userInterface->getProfessionalBookingAllDetail($id);
    }
    public function saveUserFavProf(Request $request){
        return $this->userInterface->saveUserFavProf($request);
    }
    public function getFavProf(Request $request){
        return $this->userInterface->getFavProf($request);
    }
    public function availableStatus(Request $request){
        return $this->userInterface->availableStatus($request);
    }
    public function notificationStatus(Request $request){
        return $this->userInterface->notificationStatus($request);
    }
    public function getUserSetting(){
        return $this->userInterface->getUserSetting();
    }

    public function checkUserOtp(Request $request){
        return $this->userInterface->checkUserOtp($request);
    }

    public function getUserSettingupdate(Request $request){
        return $this->userInterface->getUserSettingupdate($request);
    }
    public function requestUserBookingReview(Request $request ,$id){
        return $this->userInterface->requestUserBookingReview($request,$id);
    }
	public function getReviews(){
		 return $this->userInterface->getReviews();
	}
    public function userAddress(){
        return $this->userInterface->userAddress();
    }
    public function addAddress(Request $request){
        return $this->userInterface->addAddress($request);
    } 
    public function deleteAddress($id){
        return $this->userInterface->deleteAddress($id);
    }
}
