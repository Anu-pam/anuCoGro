<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\SettingInterface;
use App\Models\Order;
use App\Http\Helpers\Common;
use App\Models\Tax;
class SettingController extends Controller
{
    protected $settingInterface;

    public function __construct(SettingInterface $settingInterface)
    {
       $this->settingInterface=$settingInterface;      
    }
    public function create(){
          $arrData=array(); 
         $arrData['data']=$this->settingInterface->create();
        return view('backend.setting.create',$arrData);
    }
    public function store(Request $request){

         $getRequest = $this->settingInterface->store($request);
        if (!empty($getRequest) && $getRequest['status'] == 200) {
			return redirect()->back()->with('success', $getRequest['msg']);
		}else{
			return redirect()->back()->with('error', 'something wents wrong!');
        }
   
    }

    public function sendemail(){
        $details['email'] = 'anupamverma2747@gmail.com'; 
        $details['order'] =  Order::where('id',16)->first(); 
        $details['tax'] = Tax::first();
        return view('emails.orderAdminback',$details);

    }

}
