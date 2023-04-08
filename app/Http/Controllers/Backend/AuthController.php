<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserForgotPasswordRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserInterface;

class AuthController extends Controller
{
    //
    public $clientRepository;
    public $opportunityRepository;
    protected $userInteface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function login(){
		$user = Auth::user();
        
        if(isset($_COOKIE['rememberme']) && $_COOKIE['rememberme'] != ''){
            if (Auth::loginUsingId($_COOKIE['rememberme'])){
                return redirect(route('admin.index'));
            }
            else
            {
                return view('backend.auth.login');
            }
        }
        else
        {
            if(empty($user)){
                return view('backend.auth.login');
            }else{
                return redirect(route('admin.index'));
            }
        }

	
    }
    public function loginPost(UserLoginRequest $request){
        // $user = User::where('email',$request->email)->first();
          
            $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password], $remember_me)){
                if(Auth::user()->role == 2 || Auth::user()->role == 4){
                    Auth::logout();
                    return redirect()->back()->withErrors("Invalid login detail!!");
                }
                else{
                    if(!empty($request->remember == true))
                    {
                        $userid=Auth::user()->id;
                        $days = 7;
                        setcookie ("rememberme",$userid,time()+ ($days * 24 * 60 * 60));
                        setcookie ("rememberchecked","checked",time()+ ($days * 24 * 60 * 60));
                        return redirect(route('admin.dashboard'));
                    }
                    else{
                        $days = 7;
                        setcookie ("rememberme","",time()+ ($days * 24 * 60 * 60));
                        setcookie ("rememberchecked","",time()+ ($days * 24 * 60 * 60));
                        return redirect(route('admin.dashboard'));

                    }
               }
            } else {
                return redirect()->back()->withErrors("Invalid login detail!!");
            }
              
    }
	public function logout(){
        $days = 30;
        setcookie ("rememberme","", time() - ($days * 24 * 60 * 60 * 1000));

        Auth::logout();
        return redirect(route('admin.auth.login'));
    }
	public function forgotPassword(){
		$user = Auth::user();
        // "<pre>";var_dump($user);exit;
		if(empty($user)){
			return view('backend.auth.forgot-password');
		}else{
			return redirect(route('admin.index'));
		}
    }
	public function forgotPasswordPost(UserForgotPasswordRequest $request){
		$getUserDetails = $this->userInterface->requestUserForgotpassword($request);
        if(!empty($getUserDetails) && $getUserDetails['status'] == 200){
            return redirect()->back()->with('success',$getUserDetails['msg']);
        }elseif(!empty($getUserDetails) && $getUserDetails['status'] == 201){
            return redirect()->back()->with('error',$getUserDetails['msg']);
        }else{
            return redirect()->back()->withErrors('Some thing wents wrong!');
        }
       
	}
    public function resetPassword($token){
        $arrData = array();
        $getUserDetails = $this->userInterface->getUserByToken($token);
        if(!empty($getUserDetails) && ($getUserDetails['status'] == 200)){
            if(!empty($getUserDetails['results'])){
                $arrData['verifyUser'] = $getUserDetails['results'];
                return view('backend.auth.reset-password',$arrData);
            }else{
                return redirect(route('admin.auth.login'))->with('error','some thing wents wrong!'); 
            }
        }else{
            return redirect(route('admin.auth.login'))->with('error','some thing wents wrong!'); 
        }
    }
    public function resetPasswordPost(UserResetPasswordRequest $request,$token = NULL){
        $getUserDetails = $this->userInterface->requestUserResetpassword($request,$token);
        if(!empty($getUserDetails) && ($getUserDetails['status'] == 200)){
            return redirect(route('admin.auth.login'))->with('success',$getUserDetails['msg']);
        }else{
            return redirect(route('admin.auth.login'))->with('error','some thing wents wrong!');
        }
    }

}
