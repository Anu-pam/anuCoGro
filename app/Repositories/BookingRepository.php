<?php
namespace App\Repositories;

use App\Interfaces\BookingInterface;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Common;
use App\Models\Order;
use App\Models\Remark;
use App\Models\Tax;
use App\Models\Wallet;
use App\Models\ProfessionalWorkingTime;
use Event;
use App\Events\statusEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request as Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Otp;
use App\Jobs\OrderAdminSendEmail;
use App\Models\ProfessionDetail;

Class BookingRepository implements BookingInterface{
   use ResponseAPI;

public function Adminemail(){

  $details['email'] = 'anupamverma2747@gmail.com';
  $details['order'] =  Order::where('id',25)->first();
  $details['tax'] =  Tax::first();
  OrderAdminSendEmail::dispatch($details);
  // dispatch(new App\Jobs\OrderAdminSendEmail($details));
 
  
  // Mail::to($details)->send(new OrderAdminSendEmail($data));
  dd('done');

  // event(new statusEvent(23,5));

  
} 

public function AcceptCancelStatus($request){
  $arrReturn = array(); 
  $user=Auth::user();
  try{
    if(!empty($user)){
      if($request->status == 2 || $request->status == 5)
      {
    
      Order::where('id',$request->id)
      ->update(['order_status'=>$request->status]);

      $arrReturn['status'] = 200;
        $data=array(
          'order_id'=>$request->id,
          'status'=>$request->status,
          'user_id'=>$user->id
        );
        // notification
        $pro=Order::with('costomerName')->where('id',$request->id)->first(); 
        $notification_id = !empty($pro['costomerName']->uidToken) ? $pro['costomerName']->uidToken : '';
        $title = "Booking Notification";
        $id = $pro->customer_id;
        $type = "user_order";
      

      if($request->status == 2){

        $message = "Hello ".$pro->customer_name." You Booking No. #".$pro->order_id." has been Confirmed";
        // insert order status history
        Common::order_status_history($data);
        Common::UserAvailableStatus($user->id,0);
        $amount=Order::where('id',$request->id)->first();
        $wallet = new Wallet;
        $wallet->order_id = $request->id;
        $wallet->payment = $amount->total_amount;
        $wallet->save();

         //professional to send notification
         $res = Common::send_notification_FCM($notification_id, $title, $message, $request->id,$type);
         if($res == 1){ 
              // success code
          $push_notification = "success";
          }else{
          $push_notification = "fail";
            // fail code
          }
         //  notification end

         $arrReturn['status'] = 200;
         $arrReturn['push_notification'] = $push_notification;
        $arrReturn['msg'] = "Booking Accepted Successfully";
      }
      elseif($request->status == 5){

       $message = "Hello ".$pro->customer_name." You Booking No. #".$pro->order_id." has been Rejected";
        Common::UserAvailableStatus($user->id,1);
        Common::order_status_history($data);
        $remark = new Remark;
        $remark->remark = config('variable.cancel_order_remark');
        $remark->save();
        
         //professional to send notification
         $res = Common::send_notification_FCM($notification_id, $title, $message, $id,$type);
         if($res == 1){ 
            // success code
         $push_notification = "success";
         }else{
         $push_notification = "fail";
           // fail code
         }
         //  notification end

        $arrReturn['status'] = 200;
        $arrReturn['push_notification'] = $push_notification;
        $arrReturn['msg'] = "Booking Rejected Successfully";
      }
    }
     else
    {
      $arrReturn['status'] = 500;
      $arrReturn['msg'] = "Status Not Found";
    }
    }
    else
    {
      $arrReturn['status'] = 500;
      $arrReturn['msg'] = "User Id Not Found";
    }
    return $arrReturn;
    }
    catch(\Exception $e)
    {
      $arrReturn['status'] = $e->getCode();
      $arrReturn['msg'] = $e->getMessage();
      return $arrReturn;
    }

}

public function wallet(){
 
  $user=Auth::user();
  try{
    if(!empty($user)){
     
      $walletdata=Wallet::where('user_id',$user->id)->get();
      $totalamount=$walletdata->sum('payment');
      $arrData=array();
      $arrReturn=array();
      foreach($walletdata as $data)
      {
        
         $arrData[]=array(
          'user_id'=>$user->id,
          'order_id'=>$data->order_id,
          'payment_id'=>$data->payment_id,
          'user_type'=>$data->user_type,
          'payment'=>Common::showTotalAmount($data->payment),
          'clause'=>$data->clause,
          'msg'=>$data->msg,
          'date'=>Common::dateFormatChange($data->created_at)
         );
         
      }

      $arrReturn['status'] = 200;
      $arrReturn['msg'] = "Wallet data found";
      $arrReturn['totalamount'] = Common::showTotalAmount($totalamount);
      $arrReturn['result'] = $arrData;
   
    }
    else
    {
      $arrReturn['status'] = 500;
      $arrReturn['msg'] = "User Id Not Found";
    }
    return $arrReturn;
  } catch(\Exception $e)
  {
    $arrReturn['status'] = $e->getCode();
    $arrReturn['msg'] = $e->getMessage();
    return $arrReturn;
  }
}

public function bookingSlot($request){

try{
if(!empty($request->userId))
{
    
   $startDate = date('Y-m-d',strtotime("today"));
   $endDate = date('Y-m-d', strtotime($startDate. ' + 7 days')); 
   $allOrder = Order::where('professional_id',22)->where('order_date','>=',$startDate)->get();
     
    $dates = $this->getBetweenDates($startDate,$endDate,$request->userId);
     
    return $dates;
}
else
{
  $arrReturn['status'] = 500;
  $arrReturn['msg'] = "User Id Not Found";
}
  } catch(\Exception $e)
  {
    $arrReturn['status'] = $e->getCode();
    $arrReturn['msg'] = $e->getMessage();
    return $arrReturn;
  }
}

private function getBetweenDates($startDate, $endDate,$userId)
{

    $rangArray = [];
        
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    $proStartStopTime = ProfessionDetail::where('user_id',$userId)->first();
    $ProStartTime = $proStartStopTime->start_time;
    $ProStopTime = $proStartStopTime->stop_time;
    if(!empty($ProStartTime) && !empty($ProStopTime)){

    for ($currentDate = $startDate; $currentDate <= $endDate; 
                                    $currentDate += (86400)) {
                                            
        $date = date('Y-m-d', $currentDate);
        // $rangArray[] = $date;
    
        $proStartStopRange=range($ProStartTime,$ProStopTime);
        $SlotTime=array();
        $allOrder = Order::where('professional_id',$userId)->where('bookingType','schedule')->where('order_date','=',$date)->get();
        if(!empty($allOrder[0])){
          foreach($allOrder as $slotTime)
          {
                $slot = $slotTime->time_slot;
                foreach(config('variable.slot_time') as $index=>$vv)
                {
                  foreach($proStartStopRange as $ss)
                  {
                      if($ss == $index)
                      {
                        if($slot != $index)
                        {
                          $SlotTime[$index]=$vv;
                        }
                        
                      }
                  }
                }
          }
        }
        else
        {
          
          foreach(config('variable.slot_time') as $index=>$vv)
          {
            foreach($proStartStopRange as $ss)
            {
                if($ss == $index)
                {
                    $SlotTime[$index]=$vv;
                }
            }
          }
        }
        
        $DateWithTime[]=array(
          'slot_date' => $date,
          'slot_time' => $SlotTime,
        );
        
    }
    
    $arrReturn['status'] = 200;
    $arrReturn['DateWithTime'] = $DateWithTime;
    $arrReturn['msg'] = "Slot found";
  
}
else{
  $arrReturn['status'] = 500;
  $arrReturn['msg'] = "This Professional Not Choose Working Time";

}
return $arrReturn;
}



}

?>