<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use App\Models\CardDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\StripeInterface;
use App\Http\Helpers\Common;
class StripeController extends Controller
{
    public function stripePost(Request $request){
        $user = Auth::user();
        try {
        if(!empty($user)){ 
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $token_id=$request->payment['id'];
        $card_detail=$request->payment['card'];
        $save_card=$request->payment['card']['save_card'];
       
        $card_details=json_encode($card_detail + ['card_token_id'=>$token_id]);
        $stripe_customer_id = $user->stripe_customer_id;
        if(!empty($token_id)){

            $email = 'anupamverma@gmail.com';
            $data = array(
                'save_card'=>$save_card,
                'email'=>$email,
                'stripe_customer_id'=>$stripe_customer_id,
                'userID'=>$user->id,
            );
           $customer_id = Common::stripeCustomerId($data);
        
             if(!empty($customer_id))
             {
              $source = Common::stripeCreateSource($customer_id,$token_id);
             
              $source_card_id = $source->id;
              $amount = '100';
              $striperesult = Common::stripeChargeByCard($customer_id,$source_card_id,$amount);
            
             } 
             else{
                $striperesult = Common::StripeChargebyToken($token_id);
             }
         
         $carddetail = new CardDetail;
         $carddetail->card_detail = $card_details;
         $carddetail->save();
         
         $payment = new Payment;
         $payment->order_id = '1';
         $payment->payment_method = $striperesult->payment_method_details['type'];
         $payment->total_amount = $striperesult->amount;
         $payment->payment_date = date('d-m-Y');
         $payment->payment_status = $striperesult->status;
         $payment->response_message = $striperesult->description;
         $payment->save();

         if($striperesult->status == 'succeeded') 
         {
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Payment completed";
         }
         else
         {
            $arrReturn['status'] = 500;
            $arrReturn['msg'] = "Payment Not completed";
         }
        }
        else
        {
            $arrReturn['status'] = 500;
            $arrReturn['msg'] = "Token Not Found";
        }
        }
        else {
            $arrReturn['status'] = 500;
            $arrReturn['msg'] = "User Not Found";
        }
    } catch(\Exception $e){
        $arrReturn['status'] =$e->getCode();
        $arrReturn['msg'] = $e->getMessage();
        return $arrReturn; 
    }

    }
}
