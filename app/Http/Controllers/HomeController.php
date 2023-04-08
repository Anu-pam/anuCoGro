<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\User;
use App\Models\ProfessionDetail;
use App\Models\ContactusEnquiry;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseAPI;

class HomeController extends Controller
{
  use ResponseAPI;

    public function index(){
        $arrData = array();
        $arrData['content'] = array(
          'meta_title' => "Home | Groom Me",
          'meta_description' => "Home | Groom Me",
          'meta_keyword' => "Home | Groom Me",
      );
      return view('home',$arrData);
    }
	public function aboutUs(){
        $arrData = array();
        $arrData['content'] = array(
          'meta_title' => "About Us | Groom Me",
          'meta_description' => "About Us | Groom Me",
          'meta_keyword' => "About Us | Groom Me",
      );
      return view('about_us',$arrData);
    }
	public function becomeAPartner(){
      $arrData = array();
      $arrData['content'] = array(
        'meta_title' => "Become A Partner | Groom Me",
        'meta_description' => "Become A Partner | Groom Me",
        'meta_keyword' => "Become A Partner | Groom Me",
    );
    return view('become_a_partner',$arrData);
    }
	public function faq(){
      $arrData = array();
      $arrData['content'] = array(
        'meta_title' => "Faq | Groom Me",
        'meta_description' => "Faq | Groom Me",
        'meta_keyword' => "Faq | Groom Me",
    );
      return view('faq',$arrData);
    }
	public function contactUs(){
      $arrData = array();
      $arrData['content'] = array(
        'meta_title' => "Contact Us | Groom Me",
        'meta_description' => "Contact Us | Groom Me",
        'meta_keyword' => "Contact Us | Groom Me",
    );
      return view('contact_us',$arrData);
    }
	public function partnerPost(PartnerRequest $request){
		$post = $request->post();
    $user = new User;
    $user->name = $request->name;
    // Remove a whitespace and make to lowercase
    $user->email = preg_replace('/\s+/', '', strtolower($request->email));
    $user->password = '';
    $user->type = "professionalist";
    $user->role = 4;
    // Save the user
    $user->save();
    
    $getProfessionDetails = ProfessionDetail::where('user_id',$user->id)->first();
    $code = random_int(100000, 999999);
    if(empty($getProfessionDetails)){
        $newProfessionDetail = new ProfessionDetail();
        $newProfessionDetail->udid = 'Ud-'.$code;
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
    }
    return redirect(route('become-a-partner'))->with('success', 'successfully submit your request');
	}
  public function contactPost(ContactRequest $request){
    $post = $request->post();
    $newContact = new ContactusEnquiry();
    $newContact->name = $request->name;
    $newContact->email = $request->email;
    $newContact->phone = $request->phone;
    $newContact->message = !empty($request->message) ? $request->message : NULL;
    $newContact->save();
    $this->sendEmail($newContact);
    return redirect(route('contact-us'))->with('success', 'successfully submit your query');
  }
  public function emailConfirmation($token){
    $arrData = array();
    $arrData['content'] = array(
        'meta_title' => "Email Confirmation | Groom Me",
        'meta_description' => "Email Confirmation | Groom Me",
        'meta_keyword' => "Email Confirmation | Groom Me",
    );
      $users = User::where('token',$token)->first();
			if(!empty($users)){
				$userUpdate = User::find($users->id);
				$userUpdate->is_email_verified = 1;
				$userUpdate->update();
        return view('emails.emailConfirm',$arrData);
			}else{
        return view('emails.emailConfirm',$arrData);
			}
		
  }
  public function successConfirmation(){
	  $arrData = array();
        $arrData['content'] = array(
          'meta_title' => "Email Confirmation | Groom Me",
          'meta_description' => "Email Confirmation | Groom Me",
          'meta_keyword' => "Email Confirmation | Groom Me",
      );
      return view('emails.emailConfirm',$arrData);
  }
  public function reloadCaptcha(){
        return response()->json(['captcha'=> captcha_img()]);
    }
  private function sendEmail($contact)
    {
        Mail::send('emails.contactMail', ['contact' => $contact], function ($message) use ($contact) {
            $toEmail = "contactus@groommetech.com";
            $message->to($toEmail);
            $message->subject("Contact us query");
        });
    }

    public function forgotPassword($token){
       $arrData = array('token'=>$token);
     
     return view('forget_password',$arrData);
    }
    public function resetPassword(Request $request){
      
      DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'password' => 'required|max:50',
                'c_password' => 'required|same:password',
                'gettoken' => 'required',
            ]);
            if ($validator->fails()) {
                // $this->error('Validation Error.', $validator->errors()->messages(), 500);
                // return $validator->errors();
                return back()->withInput()->withErrors($validator);
                }
                
                $user = User::where('token',$request->gettoken)->first();
                if(!empty($user)){
                $user->password = Hash::make($request->password);
                $user->token = '';
                $user->update();
                
                DB::commit();
                return redirect(route('forget.password',['id'=>$request->gettoken]))->with('success', 'Password Changed Successfully');
                }
                else{
                  return redirect(route('forget.password',['id'=>$request->gettoken]))->with('error', 'Password Not Changed Successfully');
                }

              
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
} 
