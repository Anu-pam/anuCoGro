<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
//use App\Http\Controllers\Backend\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ServicesRequest;
use App\Models\ContactusEnquiry;

class ContactusController extends Controller
{

	public function index()
	{
		$user = Auth::user();
		$arrData = array();
		if (!empty($user)) {
			$getServiceList = ContactusEnquiry::orderBy('id','desc')->get();
			$arrData['getObjContactusList'] = $getServiceList;
			return view('backend.contactus.list', $arrData);
		} else {
			return redirect(route('admin.auth.login'));
		}
	}
	
	public function delete($id)
	{
		$deleteService = ContactusEnquiry::where('id',$id)->delete();
		return redirect(route('admin.contactus.list'))->with('success','Deleted successfully');
	}
	public function view($id){
		$arrData = array();
        $getContact = ContactusEnquiry::where('id',$id)->first();
		if(!empty($getContact)){
		  $arrData['getContact'] = $getContact;
		}else{
			return redirect(route('admin.contactus.list'))->with('error', 'No contact enquiry with ID');
		}
		return view('backend.contactus.view', $arrData);
	}
	
}
