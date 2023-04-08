<?php

namespace App\Http\Helpers;

use App\Events\statusEvent;
use App\Models\Orderstatushistory;
use PhpParser\Node\Expr\FuncCall;
use App\Models\AdminSetting;
use App\Models\Order;
use Stripe;
use App\Models\User;
use App\Models\SaveCardResource;
use App\Models\OrderTax;
/**
 * Class Common
 * @package App\Helpers
 */
class Common
{

  /**
   * @param $data
   * @return string
   */
  public static function getOrderStatus($val)
  {

    $arrReturn = array();
    if ($val == 1) {
      $arrReturn['status'] = 'pending';
      $arrReturn['status_id'] = 1;
      $arrReturn['color'] = 'warning';
      $arrReturn['iconcolor'] = '#fec107';
    } else if ($val == 2) {
      $arrReturn['status'] = 'Processing';
      $arrReturn['status_id'] = 2;
      $arrReturn['color'] = 'info';
      $arrReturn['iconcolor'] = '#03a9f3';
    } else if ($val == 3) {
      $arrReturn['status'] = 'Shipped';
      $arrReturn['status_id'] = 3;
      $arrReturn['color'] = 'primary';
      $arrReturn['iconcolor'] = '#fb9678';
    } else if ($val == 4) {
      $arrReturn['status'] = 'Complete';
      $arrReturn['status_id'] = 4;
      $arrReturn['color'] = 'success';
      $arrReturn['iconcolor'] = '#00c292';
    } else if ($val == 5) {
      $arrReturn['status'] = 'Cancel';
      $arrReturn['status_id'] = 5;
      $arrReturn['color'] = 'danger';
      $arrReturn['iconcolor'] = '#e46a76';
    } else {
      $arrReturn['status'] = 'pending';
      $arrReturn['status_id'] = 6;
      $arrReturn['color'] = 'warning';
      $arrReturn['iconcolor'] = '#fec107';
    }
    return $arrReturn;
  }
  public static function getPaymentStatus($val)
  {
    $status = "";
    if ($val == 1) {
      $status = 'Pending';
    } else if ($val == 2) {
      $status = 'Complete';
    } else if ($val == 3) {
      $status = 'Refunded';
    } else if ($val == 4) {
      $status = 'Failed';
    } else if ($val == 5) {
      $status = 'Abandoned';
    } else if ($val == 6) {
      $status = 'Revoked';
    } else if ($val == 7) {
      $status = 'Preapproved';
    } else {
      $status = 'Cancelled';
    }
    return $status;
  }
  public static function dateFormatChange($varDate)
  {
    if (!empty($varDate)) {
      $returnDate = date('d M Y', strtotime($varDate));
      return $returnDate;
    }
  }
  public static function timeFormat($varDate)
  {
    if (!empty($varDate)) {
      $returnDate = date('h:i a', strtotime($varDate));
      return $returnDate;
    }
  }
  public static function dayWithDateFormat($varDate)
  {
    if (!empty($varDate)) {
      return date('D d M', strtotime($varDate));
    }
  }
  public static function getServiceImageUrl($url)
  {
    if (!empty($url['image'])) {
      return url('public' . $url['image']);
    } else {
      return 'https://groommetech.com/public/uploads/default/default.jpg';
    }
  }
  public static function getProfileImageUrl($url)
  {
    if (!empty($url['image'])) {
      return url('public' . $url['image']);
    } else {
      return 'https://groommetech.com/public/uploads/default/default.jpg';
    }
  }
  public static function showTotalAmount($amount)
  {
    if (!empty($amount)) {
      return '$' . $amount;
    } else {
      return '';
    }
  }

  public static function userPhoto($userPhoto)
  {
    if (!empty($userPhoto)) {

      return $userPhoto;
    } else {
      return 'https://groommetech.com/public/uploads/default/default.jpg';
    }
  }

  public static function checkbooking($item)
  {
    if (!empty($item)) {
      if ($item == 'live') {
        return 'Live Booking';
      } else {
        return 'Scheduling';
      }
    } else {
      return '';
    }
  }

  public static function order_status_history($data = array())
  {
    $Ohistory = new Orderstatushistory;
    $Ohistory->order_id = $data['order_id'];
    $Ohistory->order_status = $data['status'];
    $Ohistory->changed_by = $data['user_id'];
    $Ohistory->save();
  }

  public static function UserAvailableStatus($userId,$status){
    User::where('id',$userId)
    ->update(['available_status' => $status]);
  }

  public static function send_notification_FCM($notification_id, $title, $message, $id="", $type)
  {

    $accesstoken = env('FCM_KEY');

    $URL = 'https://fcm.googleapis.com/fcm/send';

   if(!empty($id)){
		$post_data = '{
			  "to" : "' . $notification_id . '",
			  "data" : {
				"body" : "",
				"title" : "' . $title . '",
				"type" : "' . $type . '",
				"order_id" : "' . $id . '",
				"message" : "' . $message . '",
			  },
			  "notification" : {
				   "body" : "' . $message . '",
				   "title" : "' . $title . '",
				   "type" : "' . $type . '", 
				   "order_id" : "' . $id . '",
				   "message" : "' . $message . '",
				   "icon" : "new",
				   "sound" : "default"
				  },

			}';
   }else{
		 $post_data = '{
			  "to" : "' . $notification_id . '",
			  "data" : {
				"body" : "",
				"title" : "' . $title . '",
				"type" : "' . $type . '",
				"message" : "' . $message . '",
			  },
			  "notification" : {
				   "body" : "' . $message . '",
				   "title" : "' . $title . '",
				   "type" : "' . $type . '", 
				   "message" : "' . $message . '",
				  "icon" : "new",
				  "sound" : "default"
				  },

			}';  
   }


    $crl = curl_init();

    $headr = array();
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: key=' . $accesstoken;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $rest = curl_exec($crl);

    if ($rest === false) {
      // throw new Exception('Curl error: ' . curl_error($crl));
      //print_r('Curl error: ' . curl_error($crl));
      $result_noti = 0;
    } else {

      $result_noti = 1;
    }

    //curl_close($crl);
    //print_r($result_noti);die;
    return $result_noti;
  }

  public static function showImages($url)
  {
    if (!empty($url)) {
      return url('public/' . $url);
    } else {
      return 'https://groommetech.com/public/uploads/default/default.jpg';
    }
  }

  public static function setting($key)
  {
    if (!empty($key)) {
      return AdminSetting::where('key', $key)->first();
    }
  }
  public static function Taxsetting($key){
    if (!empty($key)) {
    return AdminSetting::where('key', 'tax')->where('value','!=',0)->get();
    }
  }

  public static function paymentStatus($data = array())
  {
    Order::where('id', $data['order_id'])
      ->update(['payment_status' => $data['status']]);
  }

  public static function stripeCustomerId($data = array())
  {
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    if ($data['save_card'] == true) {
      if (!empty($data['stripe_customer_id'])) {
        $customer = Stripe\Customer::retrieve(
          $data['stripe_customer_id'],
          []
        );
        return $customer->id;
      } else {
        $customer = Stripe\Customer::create(
          ['description' => 'Customer with new email id ' . $data['email']]
        );

        User::where('id', $data['userID'])
          ->update(['stripe_customer_id' => $customer->id]);
        
        return $customer->id;
      }
    } else {
      return false;
    }
  }

  public static function stripeRetrieveCustomerStore($stripe_customer_id,$user_id)
  {
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      if (!empty($stripe_customer_id)) {
        $customer = Stripe\Customer::retrieve(
          $stripe_customer_id,
          []
        );
        $checkuser = SaveCardResource::where('user_id',$user_id)->first();
           if(!empty($checkuser))
           {
             SaveCardResource::where('user_id',$user_id)
             ->update(['card_resource'=>json_encode($customer)]);
           }
           else
           {
            $store = new SaveCardResource;
            $store->user_id = $user_id;
            $store->card_resource = json_encode($customer); 
            $store->save();
           }
      

      } 
     
  }


  public static function stripeCreateSource($customer_id, $token_id)
  {
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $source = Stripe\Customer::createSource(
      $customer_id,
      ['source' => $token_id]
    );
    return $source;
  }

  public static function StripeChargebyToken($token_id,$totalamount)
  {

    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $striperesult = Stripe\Charge::create([
      "amount" => $totalamount * 100,
      "currency" => "usd",
      "source" => $token_id,
      "description" => "Test payment from codeyiizen"

    ]);

    return $striperesult;
  }
  public static function stripeChargeByCard($customer_id,$source_card_id,$amount){
    $striperesult=Stripe\Charge::create ([
      "amount" => $amount * 100,
      "currency" => "usd",
      "customer"=>$customer_id,
      "source" => $source_card_id,
      "description" => "Test payment from codeyiizen" 
  
    ]);
    return $striperesult;
  }
  public static function getIdentificationStatus($val)
  {
    $arrReturn = array();
    if ($val == 1) {
      $arrReturn['status'] = 'Pending';
      $arrReturn['status_id'] = 1;
      $arrReturn['color'] = 'warning';
      $arrReturn['iconcolor'] = '#fec107';
    } else if ($val == 2) {
      $arrReturn['status'] = 'Approved';
      $arrReturn['status_id'] = 2;
      $arrReturn['color'] = 'success';
      $arrReturn['iconcolor'] = '#00c292';
    } else if ($val == 3) {
      $arrReturn['status'] = 'Rejected';
      $arrReturn['status_id'] = 3;
      $arrReturn['color'] = 'danger';
      $arrReturn['iconcolor'] = '#e46a76';
    }
    return $arrReturn;
  }
  public static function getDocumentsImageUrl($url)
  {
    if (!empty($url)) {
      return url('public' . $url);
    } else {
      return 'https://groommetech.com/public/uploads/default/default.jpg';
    }
  }
  public static function getImageUrl($url,$type){ 
	  $default_image_path = env('DEFAULT_IMAGE_PATH');
	  if(!empty($url)){
	    if(!empty($type) && $type=='user_profile'){
			return env('APP_URL').'/public'.$url; 
		}else if(!empty($type) && $type=='services'){
			return env('APP_URL').'/public'.$url;
		}else if(!empty($type) && $type=='service_cat'){
			return env('APP_URL').'/public'.$url;
		}else if(!empty($type) && $type=='pro_gallery'){
			return env('APP_URL').'/public'.$url;
		}else{
      return env('APP_URL').'/public'.$url;
		}
	  }else{
		  return $default_image_path;
	  }
  }

  public static function TaxWithAmount($totalPrice)
  {
     $tax=Common::Taxsetting('tax');
     $totaltax=0;
     foreach($tax as $alltax)
     {
      
      $taxprice = ($totalPrice * $alltax->value) / 100;
      $taxWithPrice = Common::showTotalAmount(round($taxprice,2));
      $totaltax +=$taxprice;
    
      $taxvalue = $alltax->value.'%';
      $taxname = $alltax->taxName;
      $taxtype = $alltax->type;
      $data['tax'][] = ["tax"=>$taxvalue,"price"=>$taxWithPrice,"name"=>$taxname,"type"=>$taxtype];
     }
      $total = $totalPrice+$totaltax;
      $data['subtotal'] = Common::showTotalAmount(round($totalPrice,2));
      $data['total'] = Common::showTotalAmount(round($total,2));
      $data['totalamount'] = round($total,2);
   return $data;
  }

  public static function insertOrderTaxs($order_id){
  
     $getTax = Common::Taxsetting('tax');
     foreach($getTax as $taxs){
      $OTax= new OrderTax;
      $OTax->order_id = $order_id;
      $OTax->tax_id = $taxs->id;
      $OTax->value = $taxs->value;
      $OTax->type = $taxs->type;
      $OTax->taxName = $taxs->taxName;
      $OTax->save();
     }
   
  }

  public static function bookingDetailsTaxWithAmount($getdata,$subTotal)
  {
    $totaltax=0;
    foreach($getdata->ordertax as $alltax)
     {
      
      $taxprice = ($subTotal * $alltax->value) / 100;
      $taxWithPrice = Common::showTotalAmount(round($taxprice,2));
      $totaltax +=$taxprice;
    
      $taxvalue = $alltax->value.'%';
      $taxname = $alltax->taxName;
      $taxtype = $alltax->type;
      $data['tax'][] = ["tax"=>$taxvalue,"price"=>$taxWithPrice,"name"=>$taxname,"type"=>$taxtype];
      
     }
     $total = $subTotal+$totaltax;
     $data['subtotal'] = Common::showTotalAmount(round($subTotal,2));
     $data['total'] = Common::showTotalAmount(round($total,2));
     $data['totalamount'] = round($total,2);
  return $data;
  }

  public static function professionalList($data = array())
  {

     $result = array(
                        'id' => $data['user']->id,
                        'name' => $data['user']->name,
                        'email' => $data['user']->email,
                        'email_verified_at' => $data['user']->email_verified_at,
                        'is_phone_verified' => $data['user']->is_phone_verified,
                        'is_email_verified' => $data['user']->is_email_verified,
                        'photo' => $data['user']->photo,
                        'token' => $data['user']->token,
                        'type' => $data['user']->type,
                        'role' => $data['user']->role,
                        'status' => $data['user']->status,
                        'profavgrating'=>$data['user']->profavgrating,
                        'proftotalrating'=>$data['user']->proftotalrating,
                        'live'=>$data['user']->available_status == 1 ? true : false,
                        'schedule'=>$data['user']->sch_available == 1 ? true : false,
                        'user_professional_details' => $data['user_professional_details'],
                        'services' => $data['arrService'],
                        'distance' => $data['distanceData'],
                        'isFav'=>(!empty($data['user']->isFav->where('user_id',$data['logUser']->id)->first()))?true:false
                    );
   return $result;
  }
  public static function userProfessionalDetails($user){
     
    if (!empty($user->userProfessionalDetails)) {
      $user_professional_details = array(
          'id' => $user->userProfessionalDetails->id,
          'udid' => $user->userProfessionalDetails->udid,
          'business' => $user->userProfessionalDetails->business,
          'phone_no' => $user->userProfessionalDetails->phone_no,
          'location' => $user->userProfessionalDetails->location,
          'city' => $user->userProfessionalDetails->city,
          'postcode' => $user->userProfessionalDetails->postcode,
          'latitude' => !empty($user->userProfessionalDetails->latitude) ? (float)$user->userProfessionalDetails->latitude : NULL,
          'longitude' => !empty($user->userProfessionalDetails->longitude) ? (float)$user->userProfessionalDetails->longitude : NULL,
          'message' => $user->userProfessionalDetails->message,
          'user_id' => $user->userProfessionalDetails->user_id
      );
    } else {
        $user_professional_details = array();
    }
    return $user_professional_details;
  }

  public static function getProfessionalService($getProfessionalService)
  {
    if (!empty($getProfessionalService[0])) {
      foreach ($getProfessionalService as $service) {
          // var_dump($service->serviceIcon);

          $arrService[] = array(
              'id' => $service->id,
              'service_id' => $service->service_id,
              'service_name' => $service->service_name,
              'icon' => !empty($service->serviceIcon->image) ? $service->serviceIcon->image : Common::getImageUrl(null, null),
              'price' => $service->price,
              'professional_id' => $service->professional_id
          );
      }
  } else {
      $arrService = [];
  }
  return $arrService;
  }
  public static function distanceData($get,$user)
  {
    if (!empty($get['latitude']) && ($get['longitude'])) {
      $lat1 = $get['latitude'];
      $long1 = $get['longitude'];
      $lat2 = !empty($user->userProfessionalDetails->latitude) ? $user->userProfessionalDetails->latitude : NULL;
      $long2 = !empty($user->userProfessionalDetails->longitude) ? $user->userProfessionalDetails->longitude : NULL;
      $unit = "K";
      if (!empty($lat2) && ($long2)) {
          $distanceData = Common::distance($lat1, $long1, $lat2, $long2, $unit);
      } else {
          $distanceData = "N/A";
      }
  } else {
      $distanceData = "N/A";
  }
  }

  public static function distance($lat1, $lon1, $lat2, $lon2, $unit)
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

}
