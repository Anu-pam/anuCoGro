<?php

namespace App\Repositories;

use App\Events\statusEvent;
use App\Http\Helpers\Common;
use App\Http\Resources\Service\ServiceCollection;
use App\Interfaces\ServicesInterface;
use App\Jobs\OrderAdminSendEmail;
use App\Jobs\OrderCustomerSendEmail;
use App\Jobs\OrderProfessionalSendEmail;
use App\Models\CardDetail;
use App\Models\DocIdentification;
use App\Models\Identification;
use App\Models\Image;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Orderdetail;
use App\Models\Payment;
use App\Models\ProfessionalService;
use App\Models\Review;
use App\Models\SaveCardResource;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Models\UserAddress;
use App\Traits\ResponseAPI;
use Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe;

class ServicesRepository implements ServicesInterface
{
    use ResponseAPI;
    private $limit_per_page = 10;

    public function getAllSevices()
    {
        $arrReturn = array();
        try {
            $services = Service::all();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Service";
            $arrReturn['results'] = $services;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getAllSevicesCategory()
    {
        $arrReturn = array();
        try {
            $serviceCategory = ServiceCategory::where('status', 1)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Service Category";
            $arrReturn['results'] = $serviceCategory;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getServiceById($id)
    {
        $arrReturn = array();
        try {
            $service = Service::with('serviceImages')->find($id);
            // Check the service
            // if (!$service) return $this->error("No service with ID $id", 404);
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Detail";
            $arrReturn['results'] = $service;
            return $arrReturn;

            //return $this->success("Service Detail", $service);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestServices($request, $id = null)
    {
        $post = $request->post();
        //echo "<pre>";var_dump($post);exit;
        DB::beginTransaction();
        try {
            $arrReturn = array();
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'category' => 'required',
                'min_price' => 'required|numeric|min:1',
                'max_price' => 'required|numeric|gte:min_price',
            ]);
            if ($validator->fails()) {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = $validator->errors()->messages();
                return $arrReturn;
            }

            //echo "<pre>";var_dump($post);exit;
            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $services = $id ? Service::find($id) : new Service;
            $services->category_id = $request->category;
            $services->gender = $request->gender;
            $services->name = $request->name;
            $services->slug = $this->createServiceSlug($request->name);
            $services->min_price = $request->min_price;
            $services->max_price = $request->max_price;
            $services->status = $request->status;
            $services->show_on_header = (($request->show_on_header == 'on') || ($request->show_on_header == 1)) ? 1 : 0;
            // Save the service
            $services->save();

            $getImage = Image::where('parent_id', $id)->first();
            $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
            if (!empty($request->hasFile('image'))) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800',
                ]);
                $image = $request->file('image');
                $timestamp = time();
                $name = $timestamp . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/services');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $imageName = $name;
                $imageNameLink = '/uploads/services/' . $name;
                $Image->parent_id = !empty($id) ? $id : $services->id;
                $Image->type = 'services';
                $Image->image = $imageNameLink;
                $Image->save();
            }
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = $id ? "Service updated"
            : "Service created";
            return $arrReturn;
            // return $this->success(
            //     $id ? "Service updated"
            //         : "Service created",
            //     $service,
            //     $id ? 200 : 201
            // );
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function deleteService($id)
    {
        $arrReturn = array();
        DB::beginTransaction();
        try {
            $service = Service::find($id);
            // Check the user
            //if (!$service) return $this->error("No service with ID $id", 404);

            // Delete the service
            $service->delete();

            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service deleted";
            return $arrReturn; //$this->success("Service deleted", $service);
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }

    public function statusChangeService($request)
    {
        $arrReturn = array();
        try {
            $post = $request->post();
            $id = $post['serviceId'];
            $status = $post['status'];
            $service = Service::find($id);
            $service->status = $status;
            $service->update();
            // Check the service
            //if (!$service) return $this->error("No service category with ID $id", 404);
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Status Change";
            return $arrReturn; //$this->success("Service Status Change", $service);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function showOnHeaderChangeService($request)
    {
        $arrReturn = array();
        try {
            $post = $request->post();
            $id = $post['serviceId'];
            $status = $post['status'];
            $service = Service::find($id);
            $service->show_on_header = $status;
            $service->update();
            // Check the user
            //if (!$service) return $this->error("No service category with ID $id", 404);
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Show On Header Change";
            return $arrReturn; //$this->success("Service Category Show On Header Change", $serviceCategory);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    private function createSlug($title)
    {

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($title));
        $getObjServicesCatSlug = ServiceCategory::where(DB::raw("CONCAT(slug)"), 'like', "%" . $slug . "%")->get();
        $countSlug = $getObjServicesCatSlug->count();
        $finalSlug = ($countSlug > 0) ? ($slug . '-' . $countSlug) : $slug;
        return $finalSlug;
    }
    private function createServiceSlug($title)
    {

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($title));
        $getObjServiceSlug = Service::where(DB::raw("CONCAT(slug)"), 'like', "%" . $slug . "%")->get();
        $countSlug = $getObjServiceSlug->count();
        $finalSlug = ($countSlug > 0) ? ($slug . '-' . $countSlug) : $slug;
        return $finalSlug;
    }

    /**
     * Get all Service with pagination
     *
     * @method  GET api/v1/services/
     * @access  public
     * @response Array/Collection
     * @params [page,query,catId] etc...
     */
    public function getAllSevicesWithPaginate($request)
    {

        $get = $request->input();
        $services = Service::with(["Service_cat", "serviceImages"]); 
        if (!empty($get['query'])) {
            $services->where([[DB::raw("CONCAT(name,slug)"), 'LIKE', "%{$get['query']}%"]]);
        }
        if (!empty($get['catId'])) {
            $services->where('category_id', $get['catId']);
        }
        $services = $services->paginate($this->limit_per_page);
        return new ServiceCollection($services);
    }
    
    public function requestServicesApi($request, $id = null)
    {
        $post = $request->post();
        DB::beginTransaction();
        try {
            $arrReturn = array();
            $validator = Validator::make($request->all(), [
                'name.*' => 'required|max:50',
                'category.*' => 'required',
                'min_price.*' => 'required|numeric|min:1',
                'max_price.*' => 'required|numeric|gt:min_price',
            ]);
            if ($validator->fails()) {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = $validator->errors()->messages();
                return $arrReturn;
            }

            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $services = $id ? Service::find($id) : new Service;
            $services->category_id = $request->category;
            $services->name = $request->name;
            $services->slug = $this->createServiceSlug($request->name);
            $services->min_price = $request->min_price;
            $services->max_price = $request->max_price;
            $services->status = $request->status;
            $services->show_on_header = (($request->show_on_header == 'on') || ($request->show_on_header == 1)) ? 1 : 0;
            // Save the service
            $services->save();

            $getImage = Image::where('parent_id', $id)->first();
            $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
            if (!empty($post['image'])) {
                $imageUpload = $this->createImage($post['image']);
                $Image->parent_id = !empty($id) ? $id : $services->id;
                $Image->type = 'services';
                $Image->image = $imageUpload;
                $Image->save();
            }
            DB::commit();
            $getService = $id ? Service::with('serviceImages')->where('id', $id)->first() : Service::with('serviceImages')->where('id', $services->id)->first();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = $id ? "Service updated"
            : "Service created";
            $arrReturn['results'] = $getService;
            return $arrReturn;
            // return $this->success(
            //     $id ? "Service updated"
            //         : "Service created",
            //     $service,
            //     $id ? 200 : 201
            // );
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function getServicesCat()
    {
        $arrReturn = array();
        try {
            $serviceCategory = DB::table('services')
                ->join('services_category', 'services_category.id', '=', 'services.category_id')
                ->join('tbl_images', 'tbl_images.parent_id', '=', 'services_category.id')
                ->where('tbl_images.type', 'service_cat')
                ->groupBy('services.category_id')
                ->select('services_category.*', 'services.id as sId', 'tbl_images.image')
                ->get();


            foreach ($serviceCategory as $serId) {
                
                $servicesArray = Service::select('id')->where('category_id', $serId->id)->get();
                $arrIds = array();
                foreach ($servicesArray as $ser) {
                    $arrIds[] = $ser->id;
                }

                $profIds = array();
                $getProfessionalService = ProfessionalService::whereIn('service_id', $arrIds)->groupBy('professional_id')->get();
                foreach ($getProfessionalService as $prf) {
                    $profIds[] = $prf->professional_id;
                }
                $professionalID= implode(',',$profIds);
                if(empty($professionalID))
                {
                    $professionalID = 0;
                }
                // $users = User::whereIn('id', $profIds);
                // $users = $users->where('available_status', '=', 1)->where('role', '=', 4);
                // $users = $users->where('available_status1', '=', 1)->orWhere('sch_available', '=', 1)->where('role', '=', 4)->orWhere('sch_available', '=', 1)->get();
                // $allprocount = $users->count();

                 $user = DB::select("select COUNT(id) as professional_count from `users` where ((`available_status` = 1 or `sch_available` = 1) and `role` = 4 or `sch_available` = 1) and `id` in ($professionalID)");
                
                 $list[] = array(
                    'id' => $serId->id,
                    'name' => $serId->name,
                    'slug' => $serId->slug,
                    'status' => $serId->status,
                    'show_on_header' => $serId->show_on_header,
                    'sId' => $serId->sId,
                    'image' => Common::getImageUrl($serId->image, 'service_cat'),
                    'professionalCount' => $user[0]->professional_count,
                );
                
                $profIds = array();
                $arrIds = array();

            }

            //    return $serviceCategory = Service::with(['servicesCategory','professionalservices'])->groupBy('category_id')->get();

            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Service Category";
            $arrReturn['results'] = $list;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }

    }
    public function requestProfessionalServicesApi($request)
    {
        $post = $request->post();
        DB::beginTransaction();
        try {
            $arrReturn = array();
            $user = Auth::user();
            // echo "<pre>";var_dump($post);exit;
            if (!empty($post)) {
                for ($i = 0; $i < count($post); $i++) {
                    $gerServices = Service::where('id', $post[$i]['service_id'])->where('min_price', '<=', $post[$i]['price'])->where('max_price', '>=', $post[$i]['price'])->first();
                    if (!empty($gerServices)) {
                        if (!empty($post[$i]['service_id']) && !empty($post[$i]['price'])) {
                            $getProfessionalService = ProfessionalService::where('professional_id', $user->id)->where('service_id', $post[$i]['service_id'])->first();
                            if (empty($getProfessionalService)) {
                                $newService = new ProfessionalService;
                                $newService->service_id = $post[$i]['service_id'];
                                $newService->service_name = $gerServices->name;
                                $newService->icon = !empty($gerServices->serviceImages->image) ? url('public' . $gerServices->serviceImages->image) : url('public/assets/images/users/2.jpg');
                                $newService->price = $post[$i]['price'];
                                $newService->professional_id = $user->id;
                                $newService->save();
                            } else {
                                $updateService = ProfessionalService::find($getProfessionalService->id);
                                $updateService->service_id = $post[$i]['service_id'];
                                $updateService->service_name = $gerServices->name;
                                $updateService->icon = !empty($gerServices->serviceImages->image) ? url('public' . $gerServices->serviceImages->image) : url('public/assets/images/users/2.jpg');
                                $updateService->price = $post[$i]['price'];
                                $updateService->professional_id = $user->id;
                                $updateService->update();
                            }
                        }
                    }
                }
            }
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Professional Service created";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function requestProfessionalServicesUpdateApi($request, $id)
    {
        $post = $request->post();
        DB::beginTransaction();
        try {
            $arrReturn = array(); 
            $user = Auth::user();
            // echo "<pre>";var_dump($post);exit;
            if (!empty($post)) {
                $gerServices = Service::where('id', $post['service_id'])->where('min_price', '<=', $post['price'])->where('max_price', '>=', $post['price'])->first();
                if (!empty($gerServices)) {
                    $updateService = ProfessionalService::find($id);
                    $updateService->service_id = $post['service_id'];
                    $updateService->service_name = $gerServices->name;
                    $updateService->icon = !empty($gerServices->serviceImages->image) ? url('public' . $gerServices->serviceImages->image) : url('public/assets/images/users/2.jpg');
                    $updateService->price = $post['price'];
                    $updateService->professional_id = $user->id;
                    $updateService->update();
                    DB::commit();
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Professional Service updated";
                    $arrReturn['results'] = $updateService;
                    return $arrReturn;
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Price not match for this service";
                    return $arrReturn;
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "something wents wrong";
                return $arrReturn;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function professionalServicePrice($id){
      
        DB::beginTransaction();
        try {
            $arrReturn = array(); 
            $user = Auth::user();
            // echo "<pre>";var_dump($post);exit;
            if (!empty($user)) {
                $gerServices = Service::where('id', $id)->first();
                if (!empty($gerServices)) {
                    $updateService['service_id']=$gerServices->id;
                    $updateService['min_price']=$gerServices->min_price;
                    $updateService['max_price']=$gerServices->max_price;
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Professional Service Price";
                    $arrReturn['results'] = $updateService;
                    return $arrReturn;
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Service Not Found";
                    return $arrReturn;
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "something wents wrong";
                return $arrReturn;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function professionalServicePriceUpdate($request){
        try{
             $post = $request->post();
             $user = Auth::user();
                if(!empty($post) && !empty($user)){
                   $getService = Service::find($post['service_id']); 
                   if(($post['price'] >= $getService->min_price) && ($post['price'] <= $getService->max_price)){
                   $updateService = ProfessionalService::find($post['id']);
                   $updateService->price = $post['price'];
                   $updateService->update();
                   DB::commit();
                   $arrReturn['status'] = 200;
                   $arrReturn['msg'] = "Professional Service Price updated";
                   $arrReturn['results'] = $updateService;
                   }else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Price not match for this service";
                }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "something wents wrong";   
                }
                return $arrReturn;
            } catch(\Exception $e){
          DB::rollBack();
          $arrReturn['status'] = $e->getCode();
          $arrReturn['msg'] = $e->getMessage();
          return $arrReturn;
        }
    }
    public function getOrders()
    {
        $arrReturn = array();
        try {
            $orders = Order::all();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Orders";
            $arrReturn['results'] = $orders;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function requestOrderApi($request)
    {
        $post = $request->post();
        $user = Auth::user();

        //   echo "<pre>";var_dump($user);exit;
        DB::beginTransaction();
        try {
            $arrReturn = array();
            // $validator = Validator::make($request->all(), [
            //     'service_id' => 'required',
            //     'customer_name' => 'required',
            //     'email' => 'required|email',
            //     'phone_no' => 'required|numeric',
            //     'total_amount' => 'required',
            //     'address' => 'required',
            //     'zip_code' => 'required',
            // ]);
            $validator = Validator::make($request->all(), [
                'services' => 'present|array',
                'address' => 'present|array',
                'customer_detail' => 'present|array',

                'services.*.service_id' => 'required',
                'services.*.price' => 'required',

                'address.address' => 'required',
                'address.zip_code' => 'required',

                'customer_detail.name' => 'required',
                'customer_detail.email' => 'required',

            ]);

            if ($validator->fails()) {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = $validator->errors()->messages();
                return $arrReturn;
            }

            $p_service_id = $request->services;
            $orderFailed = '';
            $allProfessionalId = array();
            $orderServices_id = array();
            $subtotal = 0;
            foreach ($p_service_id as $value) {

                $professional_id = ProfessionalService::where('id', $value['id'])->first();
                if (!empty($professional_id)) {
                    $allProfessionalId[] = $professional_id->professional_id;
                    $ProfessionalId = $professional_id->professional_id;
                } else {
                    $orderFailed = 'orderFaild';
                }
                $orderServices_id[] = $value['service_id'];
                $subtotal += $value['price'];
            }

            if (empty($orderFailed)) {
                // return $subtotal;
                // return $orderdetail= implode(',',$orderServices_id);
                $name = !empty($request->customer_detail['name']) ? $request->customer_detail['name'] : '';
                $email = !empty($request->customer_detail['email']) ? $request->customer_detail['email'] : '';
                $phone = !empty($request->customer_detail['phone']) ? $request->customer_detail['phone'] : '';
                $remark = !empty($request->remark) ? $request->remark : '';
                $bookingType = !empty($request->bookingType) ? $request->bookingType : '';
                $myString = !empty($request->time_slot) ? $request->time_slot : '';
                $TS = explode('__', $myString);
                $time_slot = !empty($TS[0]) ? $TS[0] : '';
                $order_date = !empty($TS[1]) ? $TS[1] : date('Y-m-d');

                $totalTaxWithPrice = Common::TaxWithAmount($subtotal);

                if ($bookingType != 'live' && empty($time_slot)) {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Internal error due to time slot!!";
                    return $arrReturn;
                }
                if ((count(array_unique($allProfessionalId)) === 1)) {
                    $ordernumber = rand(111111, 999999);

                    $order = new Order;
                    $order->service_id = $ProfessionalId;
                    $order->order_id = $ordernumber;
                    $order->professional_id = $ProfessionalId;
                    $order->customer_id = $user->id;
                    $order->customer_name = $name;
                    $order->email = $email;
                    $order->phone_no = $phone;
                    $order->subTotal = $subtotal;
                    $order->total_amount = $totalTaxWithPrice['totalamount'];
                    $order->remark = $remark;
                    $order->bookingType = $bookingType;
                    $order->time_slot = $time_slot;
                    $order->order_date = $order_date;
                    $order->order_otp = rand(111111, 999999);
                    // Save the order
                    $order->save();
                    //profession status change(unavailable)
                    User::where('id', $ProfessionalId)
                        ->update(['available_status' => 0]);

                    $order_id = $order->id;
                    foreach ($p_service_id as $value) {

                        $orderdetail = new Orderdetail;
                        $orderdetail->order_id = $order_id;
                        $orderdetail->pro_service_id = $value['id'];
                        $orderdetail->services_id = $value['service_id'];
                        $orderdetail->price = $value['price'];
                        $orderdetail->professional_id = $value['professional_id'];
                        // save the orderdetails
                        $orderdetail->save();
                    }

                    //Insert orders table in taxs
                    Common::insertOrderTaxs($order_id);

                    $address = !empty($request->address['address']) ? $request->address['address'] : '';
                    $subLocality = !empty($request->address['subLocality']) ? $request->address['subLocality'] : '';
                    $address_line1 = !empty($request->address['address_line1']) ? $request->address['address_line1'] : '';
                    $home_number = !empty($request->address['home_number']) ? $request->address['home_number'] : '';
                    $latitude = !empty($request->address['latitude']) ? $request->address['latitude'] : '';
                    $longitude = !empty($request->address['longitude']) ? $request->address['longitude'] : '';
                    $city = !empty($request->address['city']) ? $request->address['city'] : '';
                    $state = !empty($request->address['state']) ? $request->address['state'] : '';
                    $zip_code = !empty($request->address['zip_code']) ? $request->address['zip_code'] : '';
                    $country = !empty($request->address['country']) ? $request->address['country'] : '';

                    $Uaddress = UserAddress::where('address', $address)
                        ->where('subLocality', $subLocality)
                        ->where('address_line1', $address_line1)
                        ->where('home_number', $home_number)
                        ->where('latitude', $latitude)
                        ->where('longitude', $longitude)
                        ->where('city', $city)
                        ->where('state', $state)
                        ->where('zip_code', $zip_code)
                        ->where('country', $country)->first();

                    $useraddress = new UserAddress;
                    $useraddress->user_id = $user->id;

                    $useraddress->subLocality = $subLocality;
                    $useraddress->address = $address;
                    $useraddress->address_line1 = $address_line1;
                    $useraddress->home_number = $home_number;
                    $useraddress->latitude = $latitude;
                    $useraddress->longitude = $longitude;
                    $useraddress->city = $city;
                    $useraddress->state = $state;
                    $useraddress->zip_code = $zip_code;
                    $useraddress->country = $country;

                    $orderaddress = new OrderAddress;
                    $orderaddress->order_id = $order->id;
                    $orderaddress->subLocality = $subLocality;
                    $orderaddress->address = $address;
                    $orderaddress->address_line1 = $address_line1;
                    $orderaddress->home_number = $home_number;
                    $orderaddress->latitude = $latitude;
                    $orderaddress->longitude = $longitude;
                    $orderaddress->city = $city;
                    $orderaddress->state = $state;
                    $orderaddress->zip_code = $zip_code;
                    $orderaddress->country = $country;

                    if (empty($Uaddress)) {

                        $useraddress->save();
                        $orderaddress->save();
                    } else {

                        $orderaddress->save();
                    }
                    // ====================payment start=======================
                    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $token_id = $request->paymentProccessType === 'direct_card' ? $request->payment['id'] : $request->cardToken;
                    $save_card = !empty($request->save_card) ? true : false;

                    $stripe_customer_id = $user->stripe_customer_id;
                    if (!empty($token_id)) {
                        if ($request->paymentProccessType === 'direct_card') {
                            $data = array(
                                'save_card' => $save_card,
                                'email' => $email,
                                'stripe_customer_id' => $stripe_customer_id,
                                'userID' => $user->id,
                            );
                            $customer_id = Common::stripeCustomerId($data);

                            if (!empty($customer_id)) {
                                $source = Common::stripeCreateSource($customer_id, $token_id);

                                $source_card_id = $source->id;

                                $striperesult = Common::stripeChargeByCard($customer_id, $source_card_id, $totalTaxWithPrice['totalamount']);

                                Common::stripeRetrieveCustomerStore($customer_id, $user->id);
                            } else {
                                $striperesult = Common::StripeChargebyToken($token_id, $totalTaxWithPrice['totalamount']);
                            }
                        } else if ($request->paymentProccessType === 'saved_card') {

                            $striperesult = Common::stripeChargeByCard($stripe_customer_id, $request->cardToken, $totalTaxWithPrice['totalamount']);
                            Common::stripeRetrieveCustomerStore($stripe_customer_id, $user->id);
                        }

                        $card_det = !empty($striperesult->payment_method_details['card']) ? $striperesult->payment_method_details['card'] : '';
                        $card_det->card_token_id = $token_id;
                        $card_details = json_encode($card_det);
                        $carddetail = new CardDetail;
                        $carddetail->card_detail = $card_details;
                        $carddetail->save();
                        $card_id = $carddetail->id;

                        $payment = new Payment;
                        $payment->order_id = $order_id;
                        $payment->card_id = $card_id;
                        $payment->payment_method = !empty($striperesult->payment_method_details['type']) ? $striperesult->payment_method_details['type'] : '';
                        $payment->total_amount = !empty($totalTaxWithPrice['totalamount']) ? $totalTaxWithPrice['totalamount'] : '';
                        $payment->payment_date = date('Y-m-d');
                        $payment->response_message = !empty($striperesult->description) ? $striperesult->description : '';

                        if ($striperesult->status == 'succeeded') {
                            Order::where('id', $order_id)
                                ->update(['payment_status' => 1]);
                            $payment->payment_status = '1';
                            $payment->save();

                            $arrReturn['payment_msg'] = "Payment completed";
                        } else {
                            $data = array('order_id' => $order_id, 'status' => 0);
                            Common::paymentStatus($data);
                            $payment->payment_status = '0';
                            $payment->save();
                            $arrReturn['payment_msg'] = "Payment Not completed";
                        }
                    } else {
                        $arrReturn['payment_msg'] = "Token Not Found";
                    }
                    // ====================payment end=======================

                    // admin  email
                    $adminemail = User::where('type', 'admin')->first();
                    $details['email'] = !empty($adminemail->email) ? $adminemail->email : '';
                    // $details['email'] = 'anupamverma2747@gmail.com';
                    $details['order'] = Order::where('id', $order_id)->first();
                    $details['tax'] = Common::setting('tax');
                    OrderAdminSendEmail::dispatch($details);
                    // user email

                    $customer['order'] = Order::where('id', $order_id)->first();
                    $customer['email'] = !empty($customer['order']->email) ? $customer['order']->email : '';
                    $customer['tax'] = Common::setting('tax');
                    OrderCustomerSendEmail::dispatch($customer);
                    //professionalist email
                    $proemail = Order::with('ProfessionalUser')->where('id', $order_id)->first();
                    $professional['email'] = !empty($proemail->ProfessionalUser->email) ? $proemail->ProfessionalUser->email : '';
                    $professional['order'] = Order::where('id', $order_id)->first();
                    $professional['tax'] = Common::setting('tax');
                    OrderProfessionalSendEmail::dispatch($professional);
                    //professional to send notification

                    $userdata = User::where('id', $ProfessionalId)->first();
                    $professionalname = $userdata->name;
                    $userdata->uidToken;
                    $notification_id = $userdata->uidToken;
                    $title = "Booking Notification";
                    $message = "Hello " . $professionalname . " You Recived A New Order from " . $name . " Order No. #" . $ordernumber;
                    $id = $userdata->id;
                    $type = "prof_order";
                    if ($userdata->notification_status == 1) {
                        $res = Common::send_notification_FCM($notification_id, $title, $message, $order_id, $type);
                        if ($res == 1) {
                            // success code
                            $push_notification = "success";
                        } else {
                            $push_notification = "fail";
                            // fail code
                        }
                        //  notification end
                    } else {
                        $push_notification = "Inactive";
                    }
                    DB::commit();
                    $arrReturn['status'] = 200;
                    $arrReturn['notification'] = $push_notification;
                    $arrReturn['msg'] = "Order created";
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Internal error due to miss match!!";
                }
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "Internal error due to miss match!!";
            }

            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }

    private function OrderUserMail($customer)
    {

        // Mail::send('emails.forgot', ['user' => $user, 'code' => $code], function ($message) use ($user) {
        //     $message->to($user->email);
        //     $message->subject("Forgot Your Password");
        // });

    }

    private function OrderProfessionalistMail()
    {
    }

    private function OrderAdminMail()
    {
    }

    public function getServiceCount()
    {
        $arrReturn = array();
        try {

            $services = Service::count();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Service Count";
            $arrReturn['results'] = $services;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getLatestOrders()
    {
        $arrReturn = array();
        try {

            $orders = Order::latest()->take(10)->get();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Orders Details";
            $arrReturn['results'] = $orders;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function deleteOrder($id)
    {
        $arrReturn = array();
        DB::beginTransaction();
        try {
            $order = Order::find($id);
            // Delete the order
            $order->delete();

            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Order deleted";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getOrderById($id)
    {
        $arrReturn = array();
        try {

            $order = Order::with(['service', 'customerdetail', 'professionaldetail', 'orderStatus'])->find($id);
            //customer latitude and longutude
            $customerLat = !empty($order->customerLatLong->latitude) ? $order->customerLatLong->latitude : '';
            $customerLong = !empty($order->customerLatLong->longitude) ? $order->customerLatLong->longitude : '';
            //professional latitude and longutude
            $professionalLat = !empty($order->professionaldetail->latitude) ? $order->professionaldetail->latitude : '';
            $professionalLong = !empty($order->professionaldetail->longitude) ? $order->professionaldetail->longitude : '';

            $unit = "K";

            if (!empty($customerLat) && !empty($customerLong) && !empty($professionalLat) && !empty($professionalLong)) {
                $distanceData = $this->distance($professionalLat, $professionalLong, $customerLat, $customerLong, $unit);
            } else {
                $distanceData = 0;
            }

            //  return $distanceData;

            // estimated time
            if ($distanceData == 0) {
                $rangeTime = '5';
            } else if ($distanceData > 10) {
                $rangeTime = '';
            } else {
                $RT = $distanceData - 1;
                $range = Common::setting('range');
                $Ran = json_decode($range->value);
                if (!empty($Ran)) {
                    $rangeTime = $Ran[$RT];
                }
            }

            // total amount with tax
            $getTax = Common::setting('tax');

            $taxs = $getTax->value;

            $amount = ($order->total_amount * $taxs / 100 + $order->total_amount);

            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Order Detail";
            $arrReturn['results'] = $order;
            $arrReturn['estimated'] = !empty($rangeTime) ? $rangeTime : 'N/A';
            $arrReturn['amount'] = !empty($amount) ? $amount : '';

            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function statusChangeOrder($request)
    {
        $user = Auth::user();
        $arrReturn = array();
        try {
            $post = $request->post();
            $id = $post['order_id'];
            $status = $post['status_id'];
            $professional_id = $post['professional_id'];
            $order = Order::find($id);
            $order->order_status = $status;
            $order->update();

            $data = array(
                'order_id' => $id,
                'status' => $status,
                'user_id' => $user->id,
            );
            Common::order_status_history($data);
            if ($status == 4 || $status == 5) {

                Common::order_status_history($data);
                event(new statusEvent($professional_id, 1));
            }
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Order Status Change";
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    // private function createImage($img)
    // {
    //    $folderPath = public_path('/uploads/services/');
    //    $image_parts = explode(";base64,", $img);
    //    $image_type_aux = explode("image/", $image_parts[0]);
    //    $image_type = $image_type_aux[1];
    //    $image_base64 = base64_decode($image_parts[1]);
    //    $imageName = uniqid() . '.'.$image_type;
    //    $file = $folderPath . $imageName;
    //    $imageNameLink = '/uploads/services/' . $imageName;
    //    file_put_contents($file, $image_base64);
    //    return $imageNameLink;
    // }
    public function getOrderCount($type = "")
    {
        $arrReturn = array();
        try {
            if ($type == 'today') {
                $orders = Order::where('order_date', date('Y-m-d'))->count();
            } else {
                $orders = Order::count();
            }
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Orders Count";
            $arrReturn['results'] = $orders;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getTotalRevenue($type = "")
    {
        $arrReturn = array();
        try {
            if ($type == 'today') {
                $orders = Order::where('order_date', date('Y-m-d'))->sum('total_amount');
            } else {
                $orders = Order::sum('total_amount');
            }
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Total Revenue";
            $arrReturn['results'] = $orders;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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

    public function OrderCancelByCronJob()
    {
        try {
            $orderStatus = Order::where('order_status', '!=', 4)->where('order_status', '!=', 5)->get();
            if (!empty($orderStatus)) {
                foreach ($orderStatus as $orderData) {
                    $created_at = $orderData->created_at;
                    $professional_id = $orderData->professional_id;
                    $create_Date = strtotime($created_at);
                    $today = strtotime("today");
                    $tomorrow = strtotime("tomorrow");
                    if ($create_Date < $tomorrow) {
                        Order::where('id', $orderData->id)
                            ->update(['order_status' => 5]);

                        User::where('id', $professional_id)
                            ->update(['available_status' => 1]);

                        $arrReturn['status'] = '200';
                        $arrReturn['msg'] = 'All Order Cancel';
                    } else {

                        $arrReturn['status'] = '500';
                        $arrReturn['msg'] = 'Order Not Found';
                    }
                }
            } else {
                $arrReturn['status'] = '500';
                $arrReturn['msg'] = 'Order Not Found';
            }
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function getStripeResource()
    {

        $user = Auth::user();
        try {
            if (!empty($user)) {

                if (!empty($user->stripe_customer_id)) {
                    $retrieve = SaveCardResource::where('user_id', $user->id)->first();
                    if (!empty($retrieve)) {

                        $ret = json_decode($retrieve->card_resource);
                        $sourcedata['sources'] = $ret->sources;
                        $arrReturn['status'] = 200;
                        $arrReturn['resource'] = $sourcedata;
                        $arrReturn['msg'] = "Resource Data Found";
                    } else {
                        $arrReturn['status'] = 500;
                        $arrReturn['msg'] = "Customer Id Not Found";
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Customer Id Not Found";
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

    public function getidentification()
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                $identify = Identification::get();
                if (!empty($identify)) {
                    $arrReturn['status'] = 200;
                    $arrReturn['data'] = $identify;
                    $arrReturn['msg'] = "Identification Data Found";
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Identification Not Found";
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

    public function setidentification($request)
    {
        $user = Auth::user();
        try {
            if (!empty($user)) {
                $post = $request->input();
                if (!empty($post['type'])) {
                    $getType = Identification::where('id', $post['type'])->first();
                    if (!empty($getType)) {
                        if (!empty($post['image'])) {
                            $deleteDocImages = DocIdentification::where('type', $post['type'])->where('user_id', $user->id)->delete();
                            $docImage = new DocIdentification;
                            $imageUpload = $this->createImage($post['image']);
                            $docImage->user_id = $user->id;
                            $docImage->type = $post['type'];
                            $docImage->image = $imageUpload;
                            $docImage->save();
                            $getIdentification = Identification::with('identificationDocImages')->where('id', $post['type'])->first();
                            $getIdentificationImages = DocIdentification::where('type', $post['type'])->where('user_id', $user->id)->first();
                            $arrReturn['status'] = 200;
                            $arrReturn['msg'] = "Identification Data Inserted successfully";
                            $arrReturn['results'] = array('id' => $getIdentification->id,
                                'type' => $getIdentification->type);
                            $arrReturn['results']['identification_doc_images'] = array('id' => $getIdentificationImages->id,
                                'user_id' => $getIdentificationImages->user_id,
                                'type' => $getIdentificationImages->type,
                                'image' => $getIdentificationImages->image,
                                'identification_status' => Common::getIdentificationStatus($getIdentificationImages->status));
                        }
                    } else {
                        $arrReturn['status'] = 500;
                        $arrReturn['msg'] = " Identification Not Found for this type";
                    }
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Type Not Found";
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
    public function getDocuments()
    {
        $user = Auth::user();
        $arrData = array();
        try {
            if (!empty($user)) {
                $documents = DocIdentification::where('user_id', $user->id)->get();
                if (!empty($documents[0])) {
                    foreach ($documents as $document) {
                        $arrData[] = array('id' => $document->id,
                            'type_name' => !empty($document->identification->type) ? $document->identification->type : '-',
                            'image' => Common::getDocumentsImageUrl($document->image),
                            'user_id' => $document->user_id,
                            'type' => $document->type,
                            'user_name' => !empty($document->ProfUser->name) ? $document->ProfUser->name : '-',
                            'identification_status' => Common::getIdentificationStatus($document->status));
                    }

                    $arrReturn['status'] = 200;
                    $arrReturn['data'] = $arrData;
                    $arrReturn['msg'] = "Documents Details";
                } else {
                    $arrReturn['status'] = 200;
                    $arrReturn['data'] = $arrData;
                    $arrReturn['msg'] = "Data not found";
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
    public function getDocumentsRemove($id)
    {
        $arrReturn = array();
        DB::beginTransaction();
        try {
            $documents = DocIdentification::find($id);
            if (!empty($documents)) {
                if ($documents->status == 1) {
                    // Delete the document
                    $documents->delete();
                    DB::commit();
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Document deleted";
                } else {
                    $arrReturn['status'] = 500;
                    $arrReturn['msg'] = "Document could not delete because its approved/rejected";
                }
            } else {
                $arrReturn['status'] = 200;
                $arrReturn['msg'] = "Data not found this id";
            }

            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function getReviews()
    {
        $arrReturn = array();
        try {
            $reviews = Review::all();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Reviews";
            $arrReturn['results'] = $reviews;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function deleteReview($id)
    {
        $arrReturn = array();
        DB::beginTransaction();
        try {
            $review = Review::find($id);
            // Delete the order
            $review->delete();

            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Review deleted";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }
    public function requestGallery($request)
    {
        $user = Auth::user();
        $arrReturn = array();
        try {
            if (!empty($user)) {
                $post = $request->input();
                if (!empty($post[0])) {
                    for ($i = 0; $i < count($post); $i++) {
                        if (!empty($post[$i])) {
                            $imageUpload = $this->createProfGalleryImage($post[$i]);
                            $Image = new Image();
                            $Image->parent_id = $user->id;
                            $Image->type = 'prof_gallery';
                            $Image->image = $imageUpload;
                            $Image->save();
                        }
                    }
                    $arrReturn['status'] = 200;
                    $arrReturn['msg'] = "Gallery Image Inserted successfully";
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

    public function getRequestGallery()
    {
        $user = Auth::user();
        $arrReturn = array();
        try {
            if (!empty($user)) {

                $getImage = Image::where('parent_id', $user->id)->where('type', 'prof_gallery')->get();

                $arrReturn['status'] = 200;
                $arrReturn['images'] = $getImage;
                $arrReturn['msg'] = "Get Gallery Image successfully";

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
    public function galleryDelete($id)
    {
        $arrReturn = array();
        DB::beginTransaction();
        try {
            $galleryImg = Image::find($id);
            // Delete the order
            $galleryImg->delete();

            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Gallery image deleted";
            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
    }

    public function servicesPrice($request)
    {

        $arrReturn = array();
        $user = Auth::user();
        try {
            if (!empty($user)) {
                $p_service_id = $request->services;
                $totalamount = 0;
                foreach ($p_service_id as $value) {

                    $totalamount += $value['price'];
                }

                $arrReturn['status'] = 200;
                $arrReturn['data'] = Common::TaxWithAmount($totalamount);
            } else {
                $arrReturn['status'] = 500;
                $arrReturn['msg'] = "User Id Not Found";
            }

            return $arrReturn;
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }

    }

// ============= ============ =======Private function====== ================  =============  ==========
    private function createImage($img)
    {
        $folderPath = public_path('/uploads/doc_identification/');
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.' . $image_type;
        $file = $folderPath . $imageName;
        $imageNameLink = '/uploads/doc_identification/' . $imageName;
        file_put_contents($file, $image_base64);
        return $imageNameLink;
    }
    private function createProfGalleryImage($img)
    {
        $folderPath = public_path('/uploads/prof_gallery/');
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.' . $image_type;
        $file = $folderPath . $imageName;
        $imageNameLink = '/uploads/prof_gallery/' . $imageName;
        file_put_contents($file, $image_base64);
        return $imageNameLink;
    }

}
