<?php

namespace App\Repositories;

use App\Http\Requests\UserRegisterRequest;
use App\Interfaces\UserInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use App\Models\Image;
use App\Models\Otp;
use App\Models\ProfessionDetail;
use App\Models\UserDetail;
use App\Models\ProfessionalService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\LoginHistory;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\UserAddress;
use App\Models\OrderAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Event;
use App\Events\SendMail;
use App\Http\Helpers\Common;
use App\Models\UserFavoriteProfessionalist;
use App\Models\DocIdentification;
use App\Models\Identification;
use App\Models\Review;

class UserRepository implements UserInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllUsers()
    {
        $arrReturn = array();
        try {
            $users = User::all();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Users";
            $arrReturn['results'] = $users;
            return $arrReturn; //$this->success("All Users", $users);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getUserById($id)
    {
        $arrReturn = array();
        try {
            $user = User::find($id);
            // Check the user
            if (!$user) {
                $arrReturn['status'] = 201;
                $arrReturn['msg'] = "No user with ID $id";
            } else {
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "User Detail";
                $arrReturn['results'] = $user;
            }
            return $arrReturn; //$this->success("User Detail", $user);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestUser($request, $id = null)
    {
        $post = $request->post();
        //echo "<pre>";var_dump($post);exit;
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => request()->route('user')
                    ? 'required|email|max:255|unique:users,email,' . request()->route('user')
                    : 'required|email|max:255|unique:users,email',
                'password' => request()->route('user') ? 'nullable' : 'required|max:50',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }
            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $user = $id ? User::find($id) : new User;

            // Check the user 
            if ($id && !$user) return $this->error("No user with ID $id", 404);
            if (!empty($request->type) && ($request->type == 'professionalist')) {
                $user->name = $request->name;
                // Remove a whitespace and make to lowercase
                $user->email = preg_replace('/\s+/', '', strtolower($request->email));

                // I dont wanna to update the password, 
                // Password must be fill only when creating a new user.
                if (!$id) $user->password = Hash::make($request->password);
                $user->type = "professionalist";
                $user->role = 4;
                $user->token = $user->createToken('MyApp')->accessToken;
                $user->uidToken = $request->udid;
                // Save the user
                $user->save();

                $getProfessionDetails = ProfessionDetail::where('user_id', $user->id)->first();
                if (empty($getProfessionDetails)) {
                    $newProfessionDetail = new ProfessionDetail();
                    $newProfessionDetail->udid = $request->udid;
                    $newProfessionDetail->prof_cat_id = $request->prof_type;
                    $newProfessionDetail->phone_no = $request->phone;
                    $newProfessionDetail->location = $request->location;
                    $newProfessionDetail->latitude = $request->latitude;
                    $newProfessionDetail->longitude = $request->longitude;
                    $newProfessionDetail->user_id = $user->id;
                    $newProfessionDetail->save();
                }
                $this->sendConfirmEmail($user, $user->token);
                DB::commit();
                return $this->success(
                    $id ? "User Professional updated"
                        : "User Professional created",
                    $user,
                    $id ? 200 : 201
                );
            } else {

                $user->name = $request->name;
                // Remove a whitespace and make to lowercase
                $user->email = preg_replace('/\s+/', '', strtolower($request->email));

                // I dont wanna to update the password, 
                // Password must be fill only when creating a new user.
                if (!$id) $user->password = Hash::make($request->password);
                $user->type = "customer";
                $user->role = 2;
                $user->token = $user->createToken('MyApp')->accessToken;
                $user->uidToken = $request->udid;
                // Save the user

                $user->save();
                $getUserDetails = UserDetail::where('user_id', $user->id)->first();
                if (empty($getProfessionDetails)) {
                    $newUserDetail = new UserDetail();
                    $newUserDetail->udid = $request->udid;
                    $newUserDetail->phone_no = $request->phone;
                    $newUserDetail->location = $request->location;
                    $newUserDetail->latitude = $request->latitude;
                    $newUserDetail->longitude = $request->longitude;
                    $newUserDetail->user_id = $user->id;
                    $newUserDetail->save();
                }
                $this->sendConfirmEmail($user, $user->token);
                DB::commit();
                return $this->success(
                    $id ? "User updated"
                        : "User created",
                    $user,
                    $id ? 200 : 201
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteUser($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            // Check the user
            if (!$user) return $this->error("No user with ID $id", 404);

            // Delete the user
            $user->delete();

            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "User deleted";
            return $arrReturn; //$this->success("User deleted", $user);
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function loginUser($request)
    {

        try { 
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|max:50'
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                 $user = Auth::user();
                if (($user->role == 2) || ($user->role == 4)) {
                    $this->removePreviousTokenHistory();
                    $success['token'] =  $user->createToken('GroomMe Personal Access Client')->accessToken;
                 
                    $arrLoginHistory = array(
                        'user_id' => $user->id,
                        'token_id' => (!empty($user->tokens[0])) ? $user->tokens[0]->id : '',
                        'type' => 'login',
                        'location' => 'India',
                        'latitude' => !empty($request->latitude) ? $request->latitude : '',
                        'longitude' => !empty($request->longitude) ? $request->longitude : '',
                    );
                    $this->saveLoginHistory($arrLoginHistory, 'login');
                    $uidToken = !empty($request->uidToken) ? $request->uidToken : '';

                    // uitoken update
                    User::where('id', $user->id)
                        ->update(['uidToken' => $uidToken]);

                    $success['name'] =  $user->name;
                    $success['email'] =  $user->email;
                    $success['type'] =  $user->role;
                    $success['photo'] =  Common::userPhoto($user->photo);

                    if ($user->role == 4) {
                        $success["location"] = (!empty($user->userProfessionalDetails->location)) ? $user->userProfessionalDetails->location : '';
                        $success["phone"] = (!empty($user->userProfessionalDetails->phone_no)) ? $user->userProfessionalDetails->phone_no : '';
                        $success["gender"] = (!empty($user->userProfessionalDetails->gender)) ? $user->userProfessionalDetails->gender : '';
                    } else {
                        $success["location"] = (!empty($user->userDetails->location)) ? $user->userDetails->location : '';
                        $success["phone"] = (!empty($user->userDetails->phone_no)) ? $user->userDetails->phone_no : '';
                        $success["gender"] = (!empty($user->userDetails->gender)) ? $user->userDetails->gender : '';
                    }

                    return $this->success('User login successfully.', $success, 200);
                } else {
                    return $this->error('Unauthorised.', ['error' => 'Unauthorised'], 500);
                }
            } else {
                return $this->error('Invalid Username Or Password.', ['error' => 'Invalid Username Or Password'], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), '', $e->getCode());
        }
    }
    public function requestUserProfile($request, $id = null)
    {
        DB::beginTransaction();
        try {
            $arrReturn  = array();

            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $users = User::find($id);
            $users->name = $request->name;
            $getImage = Image::where('parent_id', $id)->first();
            //echo "<pre>";var_dump($getImage);exit;
            $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
            // Check the user 
            //if ($id && !$serviceCategory) return $this->error("No service category with ID $id", 404);
            if (!empty($request->hasFile('image'))) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800'
                ]);
                $image = $request->file('image');
                $timestamp = time();
                $name = $timestamp . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $imageName = $name;
                $imageNameLink = '/uploads/users/' . $name;
                $Image->parent_id = $id;
                $Image->type = 'user_profile';
                $Image->image = $imageNameLink;
                $Image->save();
            }
            $users->update();
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "User Profile updated";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function requestUserChangePassword($request, $id = null)
    {
        DB::beginTransaction();
        try {
            $arrReturn  = array();

            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $users = User::find($id);
            $users->password = Hash::make($request->password);
            $users->update();
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "User Password updated";
            $arrReturn['results'] = $users;
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function requestUserForgotpassword($request)
    {
        DB::beginTransaction();
        $arrReturn  = array();
        try {
            $post = $request->post();
            if (!empty($post['email'])) {
                $getUser = User::where('email', $post['email'])->first();
                //echo "<pre>";var_dump($getUser);exit;
                if (!empty($getUser)) {
                    $token = ($getUser->token != NULL) ? $getUser->token : Str::random(40);
                    $user = User::find($getUser->id);
                    $user->token = $token;
                    $user->update();
                    $resetUrl = url('admin/auth/reset/password/' . $token);
                    //$resetLink = 'Reset link has been sent to your email! Your link is, <a href="'. $resetUrl . '" target="_blank"> click here  </a>';
                    $resetLink = 'Reset link has been sent to your email!';
                    DB::commit();
                    $this->sendEmail($getUser, $getUser->token);
                    $arrReturn['status'] = 200;
                    //$arrReturn['msg'] = 'Reset link has been sent to your email! Your link is, <a href="'. $resetUrl . '" target="_blank"> click here  </a>';
                    $arrReturn['msg'] = "Reset link has been sent to your email!";
                    return $arrReturn;
                } else {
                    $arrReturn['status'] = 201;
                    $arrReturn['msg'] = "Email id not exist!";
                    //$arrReturn['msg'] = "Reset link has been sent to your email!";
                    //return back()->with('error', 'Email id not exist!');
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function getUserByToken($token)
    {
        DB::beginTransaction();
        $arrReturn  = array();
        try {
            $user = User::where('token', $token)->first();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "User details!";
            $arrReturn['results'] = $user;
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function requestUserResetpassword($request, $token = null)
    {
        DB::beginTransaction();
        $arrReturn  = array();
        try {
            $getUser = User::where('token', $token)->first();
            if (!empty($getUser)) {
                $users = User::find($getUser->id);
                $users->password = Hash::make($request->password);
                $users->update();
                DB::commit();
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Reset Password Successfully!Login your new password";
                $arrReturn['results'] = $getUser;
            } else {
                $arrReturn['status'] = 201;
                $arrReturn['msg'] = "user not found";
                $arrReturn['token'] = $token;
            }
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function requestNewUser($request, $id = null)
    {
        DB::beginTransaction();
        $arrReturn = array();
        try {

            $user = $id ? User::find($id) : new User;

            $user->name = $request->name;
            // Remove a whitespace and make to lowercase
            if (!$id) $user->email  = preg_replace('/\s+/', '', strtolower($request->email));

            // I dont wanna to update the password, 
            // Password must be fill only when creating a new user.
            if (!$id) $user->password = Hash::make($request->password);
            $user->role = $request->role;

            // Save the user
            $user->save();
            $getImage = Image::where('parent_id', $id)->first();
            //echo "<pre>";var_dump($getImage);exit;
            $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
            // Check the user 
            //if ($id && !$serviceCategory) return $this->error("No service category with ID $id", 404);
            if (!empty($request->hasFile('image'))) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800'
                ]);
                $image = $request->file('image');
                $timestamp = time();
                $name = $timestamp . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $imageName = $name;
                $imageNameLink = '/uploads/users/' . $name;
                $Image->parent_id = !empty($id) ? $id : $user->id;
                $Image->type = 'user_profile';
                $Image->image = $imageNameLink;
                $Image->save();
            }
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = $id ? "User updated" : "User created";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function requestNewProfessional($request, $id = null)
    {
        // return $request->input();
        DB::beginTransaction();
        $arrReturn = array();
        try {

            $user = $id ? User::find($id) : new User;

            $user->name = $request->name;
            // Remove a whitespace and make to lowercase
            if (!$id) $user->email  = preg_replace('/\s+/', '', strtolower($request->email));

            // I dont wanna to update the password, 
            // Password must be fill only when creating a new user.
            if (!$id) $user->password = Hash::make($request->password);
            //$user->role = $request->role;
            $user->type = "professionalist";
            $user->role = 4;
            // Save the user
            $user->save();
            $getProfessionDetails = ProfessionDetail::where('user_id', $user->id)->first();
            $code = random_int(100000, 999999);
            if (empty($getProfessionDetails)) {
                $newProfessionDetail = new ProfessionDetail();
                $newProfessionDetail->udid = 'Ud-' . $code;
                $newProfessionDetail->business = $request->business;
                $newProfessionDetail->phone_no = $request->phone;
                $newProfessionDetail->location = $request->address;
                $newProfessionDetail->city = $request->city;
                $newProfessionDetail->postcode = $request->postcode;
                $newProfessionDetail->message = !empty($request->message) ? $request->message : NULL;
                $newProfessionDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                $newProfessionDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                $newProfessionDetail->user_id = $user->id;
                $newProfessionDetail->save();
            } else {
                $updateProfessionDetail = ProfessionDetail::find($getProfessionDetails->id);
                $updateProfessionDetail->business = $request->business;
                $updateProfessionDetail->phone_no = $request->phone;
                $updateProfessionDetail->location = $request->address;
                $updateProfessionDetail->city = $request->city;
                $updateProfessionDetail->postcode = $request->postcode;
                $updateProfessionDetail->message = !empty($request->message) ? $request->message : NULL;
                $updateProfessionDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                $updateProfessionDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                $updateProfessionDetail->user_id = $user->id;
                $updateProfessionDetail->update();
            }

            $getImage = Image::where('parent_id', $id)->first();
            //echo "<pre>";var_dump($getImage);exit;
            $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
            // Check the user 
            //if ($id && !$serviceCategory) return $this->error("No service category with ID $id", 404);
            if (!empty($request->hasFile('image'))) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800'
                ]);
                $image = $request->file('image');
                $timestamp = time();
                $name = $timestamp . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $imageName = $name;
                $imageNameLink = '/uploads/users/' . $name;
                $Image->parent_id = !empty($id) ? $id : $user->id;
                $Image->type = 'user_profile';
                $Image->image = $imageNameLink;
                $Image->save();
            }
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = $id ? "User updated" : "User created";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getAllUsersList()
    {
        $arrReturn = array();
        try {
            $users = User::where('role', '!=', 0)->where('role', '!=', 4)->where('role', '!=', 2)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Users";
            $arrReturn['results'] = $users;
            return $arrReturn; //$this->success("All Users", $users);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }
    public function requestProfessionalUser($request, $id = null)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => request()->route('user')
                    ? 'required|email|max:255|unique:users,email,' . request()->route('user')
                    : 'required|email|max:255|unique:users,email',
                'password' => request()->route('user') ? 'nullable' : 'required|max:50',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }
            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $user = $id ? User::find($id) : new User;

            // Check the user 
            if ($id && !$user) return $this->error("No user with ID $id", 404);

            $user->name = $request->name;
            // Remove a whitespace and make to lowercase
            $user->email = preg_replace('/\s+/', '', strtolower($request->email));

            // I dont wanna to update the password, 
            // Password must be fill only when creating a new user.
            if (!$id) $user->password = Hash::make($request->password);
            $user->type = "professionalist";
            $user->role = 4;
            //$user->token = $user->createToken('MyApp')->accessToken;
            // Save the user
            $user->save();

            $getProfessionDetails = ProfessionDetail::where('user_id', $user->id)->first();
            if (empty($getProfessionDetails)) {
                $newProfessionDetail = new ProfessionDetail();
                $newProfessionDetail->udid = $request->udid;
                $newProfessionDetail->phone_no = $request->phone_no;
                $newProfessionDetail->location = $request->location;
                $newProfessionDetail->user_id = $user->id;
                $newProfessionDetail->save();
            }
            DB::commit();
            return $this->success(
                $id ? "User Professional updated"
                    : "User Professional created",
                $user,
                $id ? 200 : 201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
    public function forgotPasswordUser($request)
    {


        // DB::beginTransaction();
        $arrReturn  = array();
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }
            $post = $request->post();
            if (!empty($post['email'])) {
                // $code = random_int(100000, 999999);
                $getUser = User::where('email', $post['email'])->first();
                //echo "<pre>";var_dump($code);exit;
                if (!empty($getUser)) {
                    // $userOtp = Otp::where('user_id', $getUser->id)->where('is_for', 'forgot')->first();
                    // $otp = $code;
                    // if (!empty($userOtp)) { 
                    //     $updateOtpUser = Otp::find($userOtp->id);
                    //     $updateOtpUser->user_id = $getUser->id;
                    //     $updateOtpUser->is_otp = $otp;
                    //     $updateOtpUser->is_for = 'forgot';
                    //     $updateOtpUser->update();
                    // } else {
                    //     $newOtpUser = new Otp();
                    //     $newOtpUser->user_id = $getUser->id;
                    //     $newOtpUser->is_otp = $otp;
                    //     $newOtpUser->is_for = 'forgot';
                    //     $newOtpUser->save();
                    // }
                    // DB::commit();
                    //Event::fire(new SendMail(16));

                    $token = $token = Str::random(32);

                    User::where('email', $post['email'])
                        ->update(['token' => $token]);


                    event(new SendMail($getUser->id));


                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Your link is send your email id";
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Email id not exist!";
                }
                return $arrReturn;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
    public function resetPasswordUser($request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
                'password' => 'required|max:50',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }
            $post = $request->post();
            $userOtp = Otp::where('is_otp', $post['otp'])->get();
            if (!empty($userOtp[0])) {
                $user = User::find($userOtp[0]->user_id);
                $user->password = Hash::make($request->password);
                $user->update();
                $otpUser = Otp::find($userOtp[0]->id);
                $otpUser->is_otp = NULL;
                $otpUser->update();
                DB::commit();
                return $this->success("password changed successfully", $user, 200);
            } else {
                return $this->error("Otp is not match!", '', 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
    public function statusChangeUser($request)
    {
        $arrReturn = array();
        try {
            $post = $request->post();
            $id = $post['userId'];
            $status = $post['status'];
            $user = User::find($id);
            $user->status = $status;
            $user->update();
            // Check the user
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "User Status Change";
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getAllUsersProfessionalList()
    {

        $arrReturn = array();
        try {
            $users = User::with('userProfessionalDetails', 'services')->where('role', '=', 4)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Professional Users";
            $arrReturn['results'] = $users;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getAllUsersProfessionalListApi($request)
    {
        $logUser = Auth::user();
        $arrReturn = array();
        $result = array();
        $arrService = array();
        $get = $request->input();
        $profIds=[];
       
        // return User::byCatId($get['cat'])->where('available_status', '=', 1)->orWhere('users.sch_available', '=', 1)->where('users.role', '=', 4)->orWhere('users.sch_available', '=', 1)->groupBy('professional_services.professional_id')->get();exit;
        if(!empty($get['cat'])){
            $servicesArray = Service::select('id')->where('category_id', $get['cat'])->get();
            
            $arrIds = [];
            foreach($servicesArray as $ser){
                $arrIds[]=$ser->id;
            }
            $getProfessionalService = ProfessionalService::whereIn('service_id', $arrIds)->groupBy('professional_id')->get();
            foreach($getProfessionalService as $prf){
                $profIds[]=$prf->professional_id;
            }
        }
        try {

            //  $users = User::with('userProfessionalDetails', 'services', 'isFav');
            //  $users = $users->whereIn('id',$profIds);
            //  $users = $users->where('available_status1', '=', 1)->orWhere('sch_available', '=', 1)->where('role', '=', 4)->orWhere('sch_available', '=', 1);
            //  return $users = $users->get();
           
             $users = User::with('userProfessionalDetails', 'services', 'isFav')->whereIn('id',$profIds)
             ->where(function ($query) use ($request) {
                 $query->where('available_status', '=', 1);
                 $query->where('role', '=', 4);
                 $query->orWhere('sch_available', '=', 1);
             })->get();  

           
            if (!empty($users[0])) {
                foreach ($users as $user) { 
                 
                    $checkstatus = User::where('id', $user->id)->first();
                 
                    if ($checkstatus) {
                      
                        $user_professional_details = Common::userProfessionalDetails($user);
                       
                        //services 
                        $getProfessionalService = ProfessionalService::where('professional_id', $user->id)->limit(4)->get();
                       
                        $arrService = Common::getProfessionalService($getProfessionalService);
                    
                        $distanceData = Common::distanceData($get,$user);
                       
                        $data = array(
                            'user' => $user,
                            'user_professional_details' => $user_professional_details,
                            'arrService' => $arrService,
                            'distanceData' => $distanceData,
                            'logUser' => $logUser,
                        );
                       if(!empty($arrService)){
                        $result[] = Common::professionalList($data);
                       }
                    }
                }
            }
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Professional Users";
            $arrReturn['results'] = $result;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }


    public function getFavProf($request)
    {
        $user = Auth::user();
        $get = $request->input();
        try {
            if (!empty($user)) {
               
                $favProfessional = UserFavoriteProfessionalist::where('user_id', $user->id)->get();
                if (!empty($favProfessional[0])) {
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "All favorite Professionalist";
                    $arrResult = array();
                    foreach ($favProfessional as $fav) {
                        $getUser = User::where('id', $fav->prof_id)->first();

                        $getObjProfessionalDetails = ProfessionDetail::with('userProfessionalDetails')->where('user_id', $fav->prof_id)->first();
                        $users = User::with('isFav')->where('id', $fav->prof_id)->get();
                
                        $user_professional_details = Common::userProfessionalDetails($getObjProfessionalDetails);

                        //service
                        $getProfessionalService = ProfessionalService::where('professional_id', $fav->prof_id)->limit(4)->get();
                         $arrService = Common::getProfessionalService($getProfessionalService);
                      
                        $distanceData = Common::distanceData($get,$getObjProfessionalDetails);

                        $data = array(
                            'user' => $getUser,
                            'user_professional_details' => $user_professional_details,
                            'arrService' => $arrService,
                            'distanceData' => $distanceData,
                            'logUser' => $user,
                        );

                       if(!empty($arrService)){
                        $result[] = Common::professionalList($data);
                       }

                    }
                    $arrReturn['results'] = $result;
                } else {
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "favorite Professionalist not found this user";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function getUserCount($type = "")
    {
        $arrReturn = array();
        try {
            if (!empty($type) && ($type == 'staff')) {
                $users = User::where('role', '!=', 0)->where('role', '!=', 4)->count();
            } else if (!empty($type) && ($type == 'professional')) {
                $users = User::where('role', 4)->count();
            } else {
                $users = User::count();
            }
            $arrReturn['status'] = 200;
            if (!empty($type) && ($type == 'staff')) {
                $arrReturn['msg'] = "All Staff Count";
            } else if (!empty($type) && ($type == 'professional')) {
                $arrReturn['msg'] = "All Professionalist Count";
            } else {
                $arrReturn['msg'] = "All Users Count";
            }
            $arrReturn['results'] = $users;
            return $arrReturn; //$this->success("All Users", $users);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getLatestStaff()
    {
        $arrReturn = array();
        try {

            $users = User::where('role', '!=', 0)->where('role', '!=', 4)->latest()->take(10)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Users Details";
            $arrReturn['results'] = $users;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function emailConfirmationUser($token)
    {
        $arrReturn = array();
        try {
            $users = User::where('token', $token)->first();
            if (!empty($users)) {
                $userUpdate = User::find($users->id);
                $userUpdate->is_email_verified = 1;
                $userUpdate->update();
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Email Verification successfully";
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "something wents wrong!";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getProfessionalDetails($id)
    {
    
        $arrReturn = array();
        try {
            $arrServices = [];
            $arrCategory = [];
            $users = User::with('userProfessionalDetails')->where('id', $id)->first();
            $getProfessionalDetails = ProfessionalService::join('services', 'services.id', '=', 'professional_services.service_id')->where('professional_services.professional_id', $id)->groupBy('services.category_id')->get();
            $limitperPage = 20;
            $getReviews = Review::with('ReviewUser')->where('professional_id', $id)->paginate($limitperPage);
            $arrGallery = Image::where('parent_id', $id)->where('type', 'prof_gallery')->get();
            if (!empty($users)) {
                $arrResult['users'] = $users;
                $arrResult['avg_rating'] = intval($users->reviews()->avg('rating'));
                $arrResult['total_rating'] = $users->reviews()->count('rating');
                if (!empty($getProfessionalDetails[0])) {
                    foreach ($getProfessionalDetails as $professional) {
                        $category = Service::join('services_category', 'services_category.id', '=', 'services.category_id')
                            ->where('services.id', $professional->service_id)->first(['services_category.*']);
                        $objProfessionservices = ProfessionalService::select('*', 'professional_services.id as id')->join('services', 'services.id', '=', 'professional_services.service_id')->where('professional_services.professional_id', $professional->professional_id)->where('services.category_id', $professional->category_id)->get();
                        $objProfessionservicesSum = ProfessionalService::select('*', 'professional_services.id as id')->join('services', 'services.id', '=', 'professional_services.service_id')->where('professional_services.professional_id', $professional->professional_id)->where('services.category_id', $professional->category_id)->count('services.id');

                        if (!empty($objProfessionservices[0])) {
                            foreach ($objProfessionservices as $service) {
                                $arrServices[] = array(
                                    'id' => $service->id,
                                    'service_id' => $service->service_id,
                                    'service_name' => $service->service_name,
                                    'icon' => !empty($service->serviceIcon->image) ? $service->serviceIcon->image : Common::getImageUrl(null, null),
                                    'price' => $service->price,
                                    'professional_id' => $service->professional_id
                                );
                            }
                        } else { 
                            $arrServices = [];
                        }
                         
                        $arrResult['categories'][] = array(
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'services' => $arrServices,
                            'services_count' => $objProfessionservicesSum,
                        );
                        unset($arrServices);
                    }
                    $arrResult['reviews'] = $getReviews;
                    $arrResult['gallery'] = $arrGallery;
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Professional details";
                    $arrReturn['results'] = $arrResult;
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "something wents wrong!";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "Professionalist not found this id!";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function getProfessionalServicesDetails()
    {
        $arrReturn = array();
        $user = Auth::user();
        try { 
            if (!empty($user)) { 
                $professionalServices = ProfessionalService::where('professional_id', $user->id)->get();
                if (!empty($professionalServices[0])) {
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "All Professional services";
                    $arrReturn['results'] = $professionalServices;
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Services not found this user";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function professionalServicesDelete($id)
    {
        $arrReturn = array();
        $user = Auth::user();
        try {
            if (!empty($user)) {
                if (!empty($id)) {
                    $professionalServices = ProfessionalService::where('id', $id)->where('professional_id', $user->id)->first();
                    if (!empty($professionalServices)) {
                        $deleteProfessionaServices = ProfessionalService::where('id', $id)->delete();
                        $arrReturn['status'] = 200;
                        $arrReturn['msg'] = "Professional services delete successfully";
                    } else {
                        $arrReturn['status'] = 500;
                        $arrReturn['msg'] = "No Services match with this user";
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "No Services with ID";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function professionalUserUpdate($request)
    {
        $arrReturn = array();
        $user = Auth::user();
        try {
            if (!empty($user) && ($user->role == 4)) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:50',
                    'location' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->error('Validation Error.', $validator->errors()->messages(), 500);
                }
                $updateProfessional = User::find($user->id);
                $updateProfessional->name = $request->name;
                $getProfessionDetails = ProfessionDetail::where('user_id', $user->id)->first();
                if (!empty($getProfessionDetails)) {
                    $updateProfessionDetail = ProfessionDetail::find($getProfessionDetails->id);
                    $updateProfessionDetail->business = NULL;
                    $updateProfessionDetail->gender = !empty($request->gender) ? $request->gender : NULL;
                    $updateProfessionDetail->phone_no = !empty($request->phone) ? $request->phone : NULL;
                    $updateProfessionDetail->location = $request->location;
                    $updateProfessionDetail->city = NULL;
                    $updateProfessionDetail->postcode = NULL;
                    $updateProfessionDetail->message = !empty($request->message) ? $request->message : NULL;
                    $updateProfessionDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                    $updateProfessionDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                    $updateProfessionDetail->user_id = $user->id;
                    $updateProfessionDetail->update();
                } else {
                    $newProfessionDetail = new ProfessionDetail();
                    $newProfessionDetail->business = NULL;
                    $newProfessionDetail->gender = !empty($request->gender) ? $request->gender : NULL;
                    $newProfessionDetail->phone_no = !empty($request->phone) ? $request->phone : NULL;
                    $newProfessionDetail->location = $request->location;
                    $newProfessionDetail->city = NULL;
                    $newProfessionDetail->postcode = NULL;
                    $newProfessionDetail->message = !empty($request->message) ? $request->message : NULL;
                    $newProfessionDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                    $newProfessionDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                    $newProfessionDetail->user_id = $user->id;
                    $newProfessionDetail->update();
                }

                if (strpos($request->image, 'data:image') === 0) {
                    $getImage = Image::where('parent_id', $user->id)->first();
                    $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
                    if (!empty($request->image)) {
                        $imageUpload = $this->createImage($request->image);
                        $Image->parent_id = $user->id;
                        $Image->type = 'user_profile';
                        $Image->image = $imageUpload;
                        $Image->save();
                    }
                    $updateProfessional->photo = !empty($request->image) ? url('public') . $this->createImage($request->image) : NULL;
                }

                $updateProfessional->update();
                $getUser =  User::with('userProfessionalDetails')->where('id', $user->id)->first();
                $getUser->phone = $getUser->userProfessionalDetails->phone_no;
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Professional user updated successfully";
                $arrReturn['results'] = $getUser;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "Professional User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function userUpdate($request)
    {
        $arrReturn = array();
        $user = Auth::user();
        try {
            if (!empty($user) && ($user->role == 2)) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:50',
                    'location' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->error('Validation Error.', $validator->errors()->messages(), 500);
                }
                $updateUser = User::find($user->id);
                $updateUser->name = $request->name;
                $getUserDetails = UserDetail::where('user_id', $user->id)->first();
                if (!empty($getUserDetails)) {
                    $updateUserDetail = UserDetail::find($getUserDetails->id);
                    $updateUserDetail->gender = !empty($request->gender) ? $request->gender : NULL;
                    $updateUserDetail->phone_no = !empty($request->phone) ? $request->phone : NULL;
                    $updateUserDetail->location = $request->location;
                    $updateUserDetail->city = NULL;
                    $updateUserDetail->postcode = NULL;
                    $updateUserDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                    $updateUserDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                    $updateUserDetail->user_id = $user->id;
                    $updateUserDetail->update();
                } else {
                    $newUserDetails = new UserDetail();
                    $newUserDetails->gender = !empty($request->gender) ? $request->gender : NULL;
                    $newUserDetails->phone_no = !empty($request->phone) ? $request->phone : NULL;
                    $newUserDetails->location = $request->location;
                    $newUserDetails->city = NULL;
                    $newUserDetails->postcode = NULL;
                    $newUserDetails->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                    $newUserDetails->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                    $newUserDetails->user_id = $user->id;
                    $newUserDetails->save();
                }
                if (strpos($request->image, 'data:image') == 0) {
                    $getImage = Image::where('parent_id', $user->id)->first();
                    $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
                    if (!empty($request->image)) {
                        $imageUpload = $this->createImage($request->image);
                        $Image->parent_id = $user->id;
                        $Image->type = 'user_profile';
                        $Image->image = $imageUpload;
                        $Image->save();
                    }
                    $updateUser->photo = !empty($request->image) ? url('public') . $this->createImage($request->image) : NULL;
                }
                $updateUser->update();
                $getUser =  User::with('userDetails')->where('id', $user->id)->first();
                $getUser->userDetails->phone = $getUser->userDetails->phone_no;
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "User updated successfully";
                $arrReturn['results'] = $getUser;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    private function sendEmail($user, $code)
    {
        Mail::send('emails.forgot', ['user' => $user, 'code' => $code], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject("Forgot Your Password");
        });
    }
    private function sendConfirmEmail($user, $code)
    {
        Mail::send('emails.confirmation', ['user' => $user, 'code' => $code], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject("Confirmation Email");
        });
    }
    private function saveLoginHistory($arrHistory, $type)
    {
        if (!empty($type) && $type == 'login') {
            $newLoginHistory = new LoginHistory();
            $newLoginHistory->loged_in_token_id = $arrHistory['token_id'];
            $newLoginHistory->type = 'login';
            if (!empty($arrHistory['location'])) {
                $newLoginHistory->location = $arrHistory['location'];
            }
            $newLoginHistory->user_id = $arrHistory['user_id'];
            $newLoginHistory->latitude = $arrHistory['latitude'];
            $newLoginHistory->longitude = $arrHistory['longitude'];
            $newLoginHistory->save();
        }
    }
    private function removePreviousTokenHistory()
    {
        $user = Auth::user();
        $userTokens = $user->tokens;
        foreach ($userTokens as $token) {
            $token->revoke();
        }
    }
    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return round($miles * 1.609344);
        } else if ($unit == "N") {
            return round($miles * 0.8684);
        } else {
            return round($miles);
        }
    }
    private function createImage($img)
    {
        $folderPath = public_path('/uploads/users/');
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.' . $image_type;
        $file = $folderPath . $imageName;
        $imageNameLink = '/uploads/users/' . $imageName;
        file_put_contents($file, $image_base64);
        return $imageNameLink;
    }
    public function saveUserFavProf($request)
    {


        $user = Auth::user();
        $post = $request->post();

        if (!empty($post['id']) && !empty($post['isFav'])) {

            UserFavoriteProfessionalist::where('user_id', $user->id)->where('prof_id', $post['id'])->delete();
            UserFavoriteProfessionalist::insert(array(
                'user_id' => $user->id,
                'prof_id' => $post['id']
            ));
        } else if (!empty($post['id']) && empty($post['isFav'])) {

            UserFavoriteProfessionalist::where('user_id', $user->id)->where('prof_id', $post['id'])->delete();
        }
        $arrReturn['status'] = 500;
        $arrReturn['msg'] = "Your favorite list updated!!";
        return $arrReturn;
    }



    public function getLatestProfessional()
    {
        $arrReturn = array();
        try {

            $users = User::where('role', 4)->latest()->take(10)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Latest Professional List";
            $arrReturn['results'] = $users;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    //user in all list available
    public function getUserBookingDetails()
    {
        $arrReturn = array();
        $user = Auth::user();
        try {
            $arrServices = [];
            $archived = [];
            $upcoming = [];
            if (!empty($user) && ($user->role == 2)) {

                $getMybooking = Order::where('customer_id', $user->id)->orderBy('id', 'DESC')->get();
                if (!empty($getMybooking)) {
                    foreach ($getMybooking as $getdata) {

                        $order_status = $getdata->order_status;
                        $created_at = $getdata->created_at;
                        $today = strtotime("today");
                        $create_Date = strtotime($created_at);

                        if ($create_Date < $today || $order_status == 4) {
                            //archived............
                            $archived[] = array(
                                'order_id' => $getdata->id,
                                'booking_time_status' => $getdata->booking_time_status,
                                'remark' => $getdata->remark,
                                'bookingType' => $getdata->bookingType,
                                'order_status' => Common::getOrderStatus($getdata->order_status),
                                'date' => date('M d,Y H:i a', strtotime($getdata->created_at)),
                                'name' => $getdata->ProfessionalUser->name,
                                'place' => $getdata->orderAddress->address,
                                'amount' => '$' . $getdata->total_amount,
                                'image' => Common::getProfileImageUrl($getdata->ProfessionalImages),
                            );
                        }
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Order not found";
                }

                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "My Booking Details";
                $arrReturn['result'] = $archived;
                return $arrReturn;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    //user in all list upcoming
    public function getUserUpcomingBookingDetails()
    {
        $arrReturn = array();
        $user = Auth::user();
        try {
            $arrServices = [];
            $archived = [];
            $upcoming = [];
            if (!empty($user) && ($user->role == 2)) {

                $getMybooking = Order::where('customer_id', $user->id)->orderBy('id', 'DESC')->get();
                if (!empty($getMybooking)) {
                    foreach ($getMybooking as $getdata) {

                        $order_status = $getdata->order_status;
                        $created_at = $getdata->created_at;
                        $today = strtotime("today");
                        $create_Date = strtotime($created_at);

                        if ($create_Date > $today  && $order_status != 4) {
                            //upcoming.........
                            $upcoming[] = array(
                                'order_id' => $getdata->id,
                                'remark' => $getdata->remark,
                                'bookingType' => $getdata->bookingType,
                                'order_status' => Common::getOrderStatus($getdata->order_status),
                                'date' => date('M d,Y H:i a', strtotime($getdata->created_at)),
                                'name' => $getdata->ProfessionalUser->name,
                                'place' => $getdata->orderAddress->address,
                                'amount' => '$' . $getdata->total_amount,
                                'image' => Common::getProfileImageUrl($getdata->ProfessionalImages),
                            );
                        }
                    } 
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Order not found";
                }

                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "My Booking Details";
                $arrReturn['result'] = $upcoming;
                return $arrReturn;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    //user in all details
    public function getUserBookingAllDetail($id)
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                if (!empty($id)) {
                    $getdata = Order::where('id', $id)->first();
                    if (!empty($getdata)) {

                        $address = $getdata->orderAddress->address;
                        $customer_name = $getdata->customer_name;
                        $phone_no = $getdata->phone_no;
                        $bookingSlot = date('M d,Y H:i a', strtotime($getdata->created_at));
                        $totalPrice = $getdata->total_amount;
                        $subTotal = $getdata->subTotal;
                        $professionalName = $getdata->ProfessionalUser->name;
                        $professionalId = $getdata->professional_id;
                        $professionalAddress = !empty($getdata->professioinlalAddress->location) ? $getdata->professioinlalAddress->location : '';


                        foreach ($getdata->detail as $index => $item) {

                            $services[] = array(
                                'service' => !empty($item->services->name) ? $item->services->name : '',
                                'price' => Common::showTotalAmount($item->price)
                            );
                            $allservices = $index + 1;
                        }
                        //check booking type
                        $today = strtotime("today");
                        $create_Date = strtotime($getdata->created_at);

                        if ($create_Date > $today  && $getdata->order_status != 4) {
                            // upcoming....
                            $arrReturn['isArchived'] = false;
                        } else {
                            $arrReturn['isArchived'] = true;
                        }

                        $data = Common::bookingDetailsTaxWithAmount($getdata, $subTotal);

                        $reviews = Review::where('user_id', $user->id)->where('order_id', $id)->get();
                        $arrReturn['status'] = 200;
                        $arrReturn['msg'] = "My Booking Details";
                        $arrReturn['order_id'] = $getdata->id;
                        $arrReturn['order_otp'] = $getdata->order_otp;
                        $arrReturn['remark'] = $getdata->remark;
                        $arrReturn['bookingType'] = $getdata->bookingType;
                        $arrReturn['order_status'] = Common::getOrderStatus($getdata->order_status);
                        $arrReturn['address'] = $address;
                        $arrReturn['customer_name'] = $customer_name;
                        $arrReturn['phone_no'] = $phone_no;
                        $arrReturn['services'] = $services;
                        $arrReturn['bookingSlot'] = $bookingSlot;
                        $arrReturn['totalPrice'] = $totalPrice;
                        $arrReturn['totalservice'] = $allservices;
                        $arrReturn['professional_id'] = $professionalId;
                        $arrReturn['isReview'] = !empty($reviews[0]) ? true : false;
                        $arrReturn['professionalName'] = $professionalName;
                        $arrReturn['professionalAddress'] = $professionalAddress;
                        $arrReturn['avg_rating'] = intval($user->reviewUsers()->avg('rating'));
                        $arrReturn['total_rating'] = $user->reviewUsers()->count('rating');
                        $arrReturn['reviews'] = $reviews;
                        $arrReturn['data'] = $data;

                        return $arrReturn;
                    } else {
                        $arrReturn['status'] = 500;
                        $arrReturn['msg'] = "Order ID Not Found";
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Details ID Not Found";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    //professional all list
    public function getProfessionalBookingDetails()
    {

        $arrReturn = array();
        $user = Auth::user();
        try {
            $arrServices = [];
            $archived = [];
            $upcoming = [];
            if (!empty($user) && ($user->role == 4)) {

                $getMybooking = Order::where('professional_id', $user->id)->orderBy('id', 'DESC')->get();
                if (!empty($getMybooking)) {
                    foreach ($getMybooking as $getdata) {

                        $order_status = $getdata->order_status;
                        $created_at = $getdata->created_at;
                        $today = strtotime("today");
                        $create_Date = strtotime($created_at);

                        if ($create_Date < $today || $order_status == 4) {
                            //archived............
                            $archived[] = array(
                                'order_id' => $getdata->id,
                                'remark' => $getdata->remark,
                                'bookingType' => $getdata->bookingType,
                                'order_status' => Common::getOrderStatus($getdata->order_status),
                                'date' => date('M d,Y H:i a', strtotime($getdata->created_at)),
                                'name' => $getdata->costomerName->name,
                                'place' => $getdata->orderAddress->address,
                                'amount' => '$' . $getdata->total_amount,
                                'image' => Common::getProfileImageUrl($getdata->CustomerImages),
                            );
                        }
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Order not found";
                }
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "My Booking Details";
                $arrReturn['result'] = $archived;
                return $arrReturn;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    //professional in alll list upcoming
    public function getProfessionalUpcomingBookingDetails()
    {
        $arrReturn = array();
        $user = Auth::user();
        try {
            $arrServices = [];
            $archived = [];
            $upcoming = [];
            if (!empty($user) && ($user->role == 4)) {

                $getMybooking = Order::where('professional_id', $user->id)->orderBy('id', 'DESC')->get();
                if (!empty($getMybooking)) {
                    foreach ($getMybooking as $getdata) {

                        $order_status = $getdata->order_status;
                        $created_at = $getdata->created_at;
                        $today = strtotime("today");
                        $create_Date = strtotime($created_at);

                        if ($create_Date > $today  && $order_status != 4) {
                            // upcoming.......
                            $upcoming[] = array(
                                'order_id' => $getdata->id,
                                'remark' => $getdata->remark,
                                'bookingType' => $getdata->bookingType,
                                'order_status' => Common::getOrderStatus($getdata->order_status),
                                'date' => date('M d,Y H:i a', strtotime($getdata->created_at)),
                                'name' => $getdata->costomerName->name,
                                'place' => $getdata->orderAddress->address,
                                'amount' => '$' . $getdata->total_amount,
                                'image' => Common::getProfileImageUrl($getdata->CustomerImages),
                            );
                        }
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Order not found";
                }
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "My Booking Details";
                $arrReturn['result'] = $upcoming;
                return $arrReturn;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User not found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    // professional booking all detail
    public function getProfessionalBookingAllDetail($id)
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                if (!empty($id)) {
                    $getdata = Order::where('id', $id)->first();
                    if (!empty($getdata)) {

                        $address = $getdata->orderAddress->address;
                        $customer_name = $getdata->customer_name;
                        $phone_no = $getdata->phone_no;
                        $bookingSlot = date('M d,Y H:i a', strtotime($getdata->created_at));
                        $totalPrice = $getdata->total_amount;
                        $subTotal = $getdata->subTotal;
                        $professionalName = $getdata->ProfessionalUser->name;
                        $professionalAddress = !empty($getdata->professioinlalAddress->location) ? $getdata->professioinlalAddress->location : '';


                        foreach ($getdata->detail as $index => $item) {

                            $services[] = array(
                                'service' => !empty($item->services->name) ? $item->services->name : '',
                                'price' => Common::showTotalAmount($item->price)
                            );
                            $allservices = $index + 1;
                        }
                        //  check booking type
                        $today = strtotime("today");
                        $create_Date = strtotime($getdata->created_at);
                        if ($create_Date > $today  && $getdata->order_status != 4) {
                            // upcoming....
                            $arrReturn['isArchived'] = false;
                        } else {
                            $arrReturn['isArchived'] = true;
                        }
                        $data = Common::bookingDetailsTaxWithAmount($getdata, $subTotal);

                        $limitperPage = 20;
                        $reviews = Review::where('professional_id', $user->id)->where('order_id', $id)->get();
                        $arrReturn['status'] = 200;
                        $arrReturn['msg'] = "My Booking Details";
                        $arrReturn['order_id'] = $getdata->id;
                        $arrReturn['remark'] = $getdata->remark;
                        $arrReturn['bookingType'] = $getdata->bookingType;
                        $arrReturn['order_status'] = Common::getOrderStatus($getdata->order_status);
                        $arrReturn['address'] = $address;
                        $arrReturn['customer_name'] = $customer_name;
                        $arrReturn['phone_no'] = $phone_no;
                        $arrReturn['services'] = $services;
                        $arrReturn['bookingSlot'] = $bookingSlot;
                        $arrReturn['totalPrice'] = $totalPrice;
                        $arrReturn['totalservice'] = $allservices;
                        $arrReturn['professionalName'] = $professionalName;
                        $arrReturn['professionalAddress'] = $professionalAddress;
                        $arrReturn['reviews'] = $reviews;
                        $arrReturn['data'] = $data;

                        return $arrReturn;
                    } else {
                        $arrReturn['status'] = 500;
                        $arrReturn['msg'] = "Order ID Not Found";
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Details ID Not Found";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function availableStatus($request)
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {

                if ($request->status === true || $request->status === false) {

                    User::where('id', $user->id)
                        ->update(['available_status' => $request->status]);

                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Your status updated!!";
                    return $arrReturn;
                }


                if ($request->sch_status === true || $request->sch_status === false) {

                    User::where('id', $user->id)
                        ->update(['sch_available' => $request->sch_status]);

                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Your sch status updated!!";
                    return $arrReturn;
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Status Not Found";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function notificationStatus($request)
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                $status = User::where('id', $user->id)->first();
                if ($request->status == 0 || $request->status == 1) {

                    User::where('id', $user->id)
                        ->update(['notification_status' => $request->status]);

                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Your status updated!!";
                    $arrReturn['notification_status'] = $status->notification_status == 1 ? 'true' : 'false';
                    $arrReturn['available_status'] = $status->available_status == 1 ? 'true' : 'false';
                    return $arrReturn;
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Status Not Found";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getUserSetting()
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                // =================================

                $storeTime = array();
                $StopTime = array();
                $time = Common::setting('timing');
                $data = json_decode($time->value);

                $startTime = $data[0];
                $endTime = $data[1];
                $start = range($startTime, 11);
                $stop = range(12, $endTime);
                foreach ($start as $ss) {
                    foreach (config('variable.start_time') as $index => $vv) {
                        if ($ss == $index) {
                            $StartTime[$index] = $vv;
                        }
                    }
                }
                foreach ($stop as $ss) {
                    foreach (config('variable.stop_time') as $index => $vv) {
                        if ($ss == $index) {
                            $StopTime[$index] = $vv;
                        }
                    }
                }
                $slot = array(
                    'startTime' => $StartTime,
                    'stopTime' => $StopTime,
                );

                // =================================
                $status = User::where('id', $user->id)->first();
                $getslottime = ProfessionDetail::where('user_id', $user->id)->first();

                $getStartTime = $getslottime->start_time;
                $getStopTime = $getslottime->stop_time;

                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Status Found!!";
                if ($user->role == 4) {
                    $arrReturn['workingSlot'] = $slot;
                }
                if (!empty($getStartTime) && !empty($getStopTime)) {
                    $arrReturn['getStartStopTime'] = array('startTime' => $getStartTime, 'stopTime' => $getStopTime);
                }
                $arrReturn['notification_status'] = $status->notification_status == 1 ? true : false;
                $arrReturn['available_status'] = $status->available_status == 1 ? true : false;
                $arrReturn['sch_available'] = $status->sch_available == 1 ? true : false;
                return $arrReturn;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function checkUserOtp($request)
    {

        $user = Auth::user();
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
                'order_otp' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }

            if (!empty($user)) {
                $order_id = $request->order_id;
                $order_otp = $request->order_otp;
                $checkOtp = Order::where('id', $order_id)->where('order_otp', $order_otp)->first();

                if (!empty($checkOtp)) {
                    //  wallet data save
                    $wt = new Wallet;
                    $wt->user_id = $user->id;
                    $wt->order_id = $request->order_id;
                    $wt->user_type = $user->type;
                    $wt->payment = $checkOtp->total_amount;
                    $wt->clause = config('variable.order_complete');
                    $wt->save();
                    //   professional available
                    User::where('id', $checkOtp->professional_id)->update(['available_status' => 1]);
                    //   order status update
                    Order::where('id', $order_id)->update(['order_status' => 4, 'order_otp' => null]);

                    //notification customer
                    $notification_id = !empty($checkOtp->costomerName->uidToken) ? $checkOtp->costomerName->uidToken : '';
                    $title = "Booking Notification";
                    $message = "Hello " . $checkOtp->costomerName->name . " Your Booking No. #" . $checkOtp->order_id . " has been Completed";
                    $type = "user_order";

                    if ($checkOtp->costomerName->notification_status == 1) {
                        $res = Common::send_notification_FCM($notification_id, $title, $message, $request->order_id, $type);
                        if ($res == 1) {
                            // success code
                            $push_notification = "success";
                        } else {
                            $push_notification = "fail";
                            // fail code
                        }
                    } else {
                        $push_notification = "Inactive";
                    }

                    $arrReturn['status'] = 200;
                    $arrReturn['push_notification'] = $push_notification;
                    $arrReturn['msg'] = "Booking completed successfully !!";
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "User Id or Otp not match!!";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function getUserSettingupdate($request)
    {
        try {
            $user = Auth::user();
            if (!empty($user)) {

                if ($request->type === 'startTime') {
                    ProfessionDetail::where('user_id', $user->id)
                        ->update(['start_time' => $request->time]);
                } elseif ($request->type === 'stopTime') {
                    ProfessionDetail::where('user_id', $user->id)
                        ->update(['stop_time' => $request->time]);
                }

                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Slot Updated successfully !!";
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function professionalDocumentStatusChange($request)
    {
        $arrReturn = array();
        try {
            $user = Auth::user();
            $post = $request->post();
            // echo "<pre>";var_dump($post);exit;
            $id = $post['varId'];
            $type = $post['varType'];
            $userId = $post['userId'];
            $document = DocIdentification::find($id);
            $document->status = (!empty($post['varType']) && ($post['varType'] == 'aproove')) ? 2 : 3;
            $document->update();
            //Count aproove documents
            $countAprooveDocuments = DocIdentification::where('user_id', $userId)->where('status', 2)->count();
            $countGetDocuments = Identification::count();
            if ($countGetDocuments == $countAprooveDocuments) {
                $updateUser = User::find($userId);
                $updateUser->document_status = 1;
                $updateUser->update();
                //notification customer
                $notification_id = !empty($updateUser->uidToken) ? $updateUser->uidToken : '';
                $title = "Document Verification";
                $message = "Hello " . $updateUser->name . " Your Ducuments has been approved";
                $type = "Prof_profile";

                if ($updateUser->notification_status == 1) {
                    $res = Common::send_notification_FCM($notification_id, $title, $message, "", $type);
                    if ($res == 1) {
                        // success code
                        $push_notification = "success";
                    } else {
                        $push_notification = "fail";
                        // fail code
                    }
                } else {
                    $push_notification = "Inactive";
                }
            } else {
                $updateUser = User::find($userId);
                $updateUser->document_status = 0;
                $updateUser->update();
            }
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Document Status Change";
            $arrReturn['result'] = $post['varType'];
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function requestUserBookingReview($request, $id)
    {
        $arrReturn = array();
        try {
            $user = Auth::user();
            $post = $request->post();
            $validator = Validator::make($request->all(), [
                'rating' => 'required|numeric',
                'review_text' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }
            $orderId = $id;
            $rating = $post['rating'];
            $reviewText = $post['review_text'];
            $userId = $user->id;
            $professionalId = $post['professional_id'];
            $getProfessional = User::where('id', $professionalId)->first();
            $getReview = Review::where('order_id', $orderId)->where('user_id', $userId)->first();
            if (empty($getReview)) {
                //New review created
                $newUserReview = new Review();
                $newUserReview->order_id = $orderId;
                $newUserReview->professional_id = $professionalId;
                $newUserReview->user_id = $userId;
                $newUserReview->user_name = !empty($user->name) ? $user->name : NULL;
                $newUserReview->user_email_id = !empty($user->email) ? $user->email : NULL;
                $newUserReview->rating = $rating;
                $newUserReview->review_text = $reviewText;
                $newUserReview->review_time = date('Y-m-d H:i:s');
                $newUserReview->status = 1;
                $newUserReview->save();

                //notification review for professional
                $notification_id = !empty($getProfessional->uidToken) ? $getProfessional->uidToken : '';
                $title = "Review";
                $message = "Hello " . $getProfessional->name . " You got review";
                $type = "cust_review";

                if ($getProfessional->notification_status == 1) {
                    $res = Common::send_notification_FCM($notification_id, $title, $message, $orderId, $type);
                    if ($res == 1) {
                        // success code
                        $push_notification = "success";
                    } else {
                        // fail code
                        $push_notification = "fail";
                    }
                } else {
                    $push_notification = "Inactive";
                }
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Review Created";
                $arrReturn['results'] = array(
                    'id' => $newUserReview->id,
                    'order_id' => $newUserReview->order_id,
                    'professional_id' => $newUserReview->professional_id,
                    'isReview' => false,
                    'user_name' => $newUserReview->user_name,
                    'user_email_id' => $newUserReview->user_email_id,
                    'rating' => $newUserReview->rating,
                    'review_text' => $newUserReview->review_text,
                    'review_time' => $newUserReview->review_time,
                    'status' => $newUserReview->status
                );
            } else {
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Review allready exist this user";
                $arrReturn['results'] = array(
                    'id' => $getReview->id,
                    'order_id' => $getReview->order_id,
                    'professional_id' => $getReview->professional_id,
                    'isReview' => true,
                    'user_name' => $getReview->user_name,
                    'user_email_id' => $getReview->user_email_id,
                    'rating' => $getReview->rating,
                    'review_text' => $getReview->review_text,
                    'review_time' => $getReview->review_time,
                    'status' => $getReview->status
                );
            }

            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getReviews()
    {
        $user = Auth::user();
        $arrReturn = array();
        try {
            $reviews = Review::where('professional_id', $user->id)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Reviews";
            $arrReturn['results'] = array(
                'user' => $user,
                'reviews' => $reviews
            );
            return $arrReturn; //$this->success("All Users", $users);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function userAddress()
    {
        $user = Auth::user();
        $arrReturn = array();
        try {
            if (!empty($user)) {
                $userAddress = UserAddress::where('user_id', $user->id)->get();
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "All User Address";
                $arrReturn['results'] = $userAddress;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Id Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function addAddress($request)
    {
        $user = Auth::user();
        $arrReturn = array();

        try {
            if (!empty($user)) {
                $uAddress = new UserAddress;
                $uAddress->user_id = $user->id;
                $uAddress->place = $request->name;
                $uAddress->subLocality = '';
                $uAddress->address = $request->formated_address;
                $uAddress->phone = $request->phone;
                $uAddress->address_line1 = $request->addressComp['city'];
                $uAddress->home_number = $request->building;
                $uAddress->latitude = $request->addressComp['latitude'];
                $uAddress->longitude = $request->addressComp['longitude'];
                $uAddress->city = $request->addressComp['city'];
                $uAddress->state = $request->addressComp['state'];
                $uAddress->zip_code = $request->addressComp['zip_code'];
                $uAddress->country = $request->addressComp['country'];
                $uAddress->save();

                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "User Address Added Successfully";
                return $arrReturn;
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Id Not Found";
            }
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function deleteAddress($id)
    {
        $user = Auth::user();
        $arrReturn = array();

        try {
            if (!empty($user)) {
                $address = UserAddress::find($id);
                if (!empty($address)) {
                    $address->delete();
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "User Address Deleted";
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Data not found this id";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Id Not Found";
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
}
