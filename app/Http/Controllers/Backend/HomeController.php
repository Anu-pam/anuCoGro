<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Interfaces\UserInterface;
use App\Interfaces\ServicesCategoryInterface;
use App\Interfaces\ServicesInterface;

class HomeController extends Controller
{
    //
    public $clientRepository;
    public $opportunityRepository;
    protected $userInteface;
	protected $servicesInterface;
	protected $servicesCategoryInterface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(UserInterface $userInterface,ServicesCategoryInterface $servicesCategoryInterface,ServicesInterface $servicesInterface)
    {
        $this->userInterface = $userInterface;
		$this->servicesCategoryInterface = $servicesCategoryInterface;
		$this->servicesInterface = $servicesInterface;
    }

    public function index(){
      $user = Auth::user();
      if(!empty($user)){
		    $arrData = array();
			$getStaffCount = $this->userInterface->getUserCount('staff');
			$getProfessionalistCount = $this->userInterface->getUserCount('professional');
			$getProfessionalTypeCount = $this->servicesCategoryInterface->getProfessionalTypeCount();
			$getServiceCount = $this->servicesInterface->getServiceCount();
			$getOrderCount = $this->servicesInterface->getOrderCount();
			$getOrderTodayCount = $this->servicesInterface->getOrderCount('today');
			$getTotalRevenue = $this->servicesInterface->getTotalRevenue();
			$getTodayTotalRevenue = $this->servicesInterface->getTotalRevenue('today');
			//echo "<pre>";var_dump($getServiceCount);exit;
			$arrData['staffCount'] = (!empty($getStaffCount) && ($getStaffCount['status'] == 200)) ? $getStaffCount['results'] : 0;
			$arrData['professionalistCount'] = (!empty($getProfessionalistCount) && ($getProfessionalistCount['status'] == 200)) ? $getProfessionalistCount['results'] : 0;
			$arrData['professionalTypeCount'] = (!empty($getProfessionalTypeCount) && ($getProfessionalTypeCount['status'] == 200)) ? $getProfessionalTypeCount['results'] : 0;
			$arrData['serviceCount'] = (!empty($getServiceCount) && ($getServiceCount['status'] == 200)) ? $getServiceCount['results'] : 0;
		    $arrData['orderCount'] = (!empty($getOrderCount) && ($getOrderCount['status'] == 200)) ? $getOrderCount['results'] : 0;
			$arrData['orderTodayCount'] = (!empty($getOrderTodayCount) && ($getOrderTodayCount['status'] == 200)) ? $getOrderTodayCount['results'] : 0;
			$arrData['totalRevenue'] = (!empty($getTotalRevenue) && ($getTotalRevenue['status'] == 200)) ? $getTotalRevenue['results'] : 0;
			$arrData['todayTotalRevenue'] = (!empty($getTodayTotalRevenue) && ($getTodayTotalRevenue['status'] == 200)) ? $getTodayTotalRevenue['results'] : 0;
			$getLatestStaff = $this->userInterface->getLatestStaff();
			$arrData['getLatestStaff'] = $getLatestStaff['results'];
			$getLatestOrders = $this->servicesInterface->getLatestOrders();
            $arrData['getLatestOrders'] = $getLatestOrders['results'];
			$getLatestProfessional = $this->userInterface->getLatestProfessional();
			$arrData['getLatestProfessional'] = $getLatestProfessional['results'];
			return view('backend.home',$arrData);
      }else{
        return redirect(route('admin.auth.login'));
      }
    }
    public function profileEdit($id){
		$user = Auth::user();
		  if(!empty($user)){
			$getProfiles = $this->userInterface->getUserById($id);
			if(!empty($getProfiles) && ($getProfiles['status'] == 200)){
			  $getProfile = $getProfiles['results'];
			}else{
			  return redirect(route('login'))->with('error', $getProfiles['msg']);
			}
			$arrData['getProfile'] = $getProfile;
			return view('backend.profile',$arrData);
		  }else{
			  return redirect(route('admin.auth.login'));
		  }
    }
    public function profileUpdate(UserProfileRequest $request,$id){
      $userProfile = $this->userInterface->requestUserProfile($request,$id);
      if (!empty($userProfile) && $userProfile['status'] == 200) {
        return redirect(route('admin.edit.profile',['id'=>$id]))->with('success', $userProfile['msg']);
      } 
    }
    public function changePassword($id){
      $getProfiles = $this->userInterface->getUserById($id);
      if(!empty($getProfiles) && ($getProfiles['status'] == 200)){
			  $getProfile = $getProfiles['results'];
			}else{
			  return redirect(route('login'))->with('error', $getProfiles['msg']);
			}
      $arrData['getProfile'] = $getProfile;
      return view('backend.change-password',$arrData);
  }
  public function changePasswordUpdate(UserChangePasswordRequest $request,$id){
    $userProfile = $this->userInterface->requestUserChangePassword($request,$id);
    if (!empty($userProfile) && $userProfile['status'] == 200) {
      return redirect(route('admin.change.password',['id'=>$id]))->with('success', $userProfile['msg']);
    } 
  }
}
