<?php
namespace App\Repositories;
use App\Interfaces\CustomerInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;
use App\Models\Image;

Class CustomerRepository implements CustomerInterface{
    use ResponseAPI;

    public function getAllCustomerList()
    {

        $arrReturn = array();
        try {
            $users = User::with('userCustomerDetails')->where('role', '=', 2)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Customer Users";
            $arrReturn['results'] = $users;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
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

    public function requestNewCustomer($request, $id = null)
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
            $user->type = "customer";
            $user->role = 2;
            // Save the user
            $user->save();
            $getCustomerDetails = UserDetail::where('user_id', $user->id)->first();
           
            if (empty($getCustomerDetails)) {
                $newCustomerDetail = new UserDetail();
                $newCustomerDetail->phone_no = $request->phone;
                $newCustomerDetail->location = $request->address;
                $newCustomerDetail->city = $request->city;
                $newCustomerDetail->postcode = $request->postcode;
                $newCustomerDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                $newCustomerDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                $newCustomerDetail->user_id = $user->id;
                $newCustomerDetail->save();
            } else {
                $updateCustomerDetail = UserDetail::find($getCustomerDetails->id);
                $updateCustomerDetail->phone_no = $request->phone;
                $updateCustomerDetail->location = $request->address;
                $updateCustomerDetail->city = $request->city;
                $updateCustomerDetail->postcode = $request->postcode;
                $updateCustomerDetail->latitude = !empty($request->latitude) ? $request->latitude : NULL;
                $updateCustomerDetail->longitude = !empty($request->longitude) ? $request->longitude : NULL;
                $updateCustomerDetail->user_id = $user->id;
                $updateCustomerDetail->update();
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

}

?>