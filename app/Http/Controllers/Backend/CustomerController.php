<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Interfaces\CustomerInterface;
use App\Models\Role;
class CustomerController extends Controller
{
    protected $customerInterface;
    public function __construct(CustomerInterface $customerInterface)
    {
         $this->customerInterface = $customerInterface;
    }

    public function customerlist(Request $request)
    {
       $arrData = array();
	   $users = $this->customerInterface->getAllCustomerList();
	   $arrData['users'] = $users['results'];
       return view('backend.customer.list',$arrData);
    }

    public function customerView(Request $request,$id){
        $arrData = array();
        $arrData['roles'] = Role::where('id',4)->get();
        $getusers = $this->customerInterface->getUserById($id);
        if(!empty($getusers['results'])){
            $arrData['getUser'] = $getusers['results'];
        }else{
            return redirect(route('admin.customerlist.list'))->with('error', 'No user with this id');
        }
		
        return view('backend.customer.view',$arrData);
    }

    public function customerEdit(Request $request,$id){
        $arrData = array();
        $arrData['roles'] = Role::where('id',4)->get(); 
        $getusers = $this->customerInterface->getUserById($id);
        if(!empty($getusers['results'])){
            $arrData['getUser'] = $getusers['results'];
        }else{
            return redirect(route('admin.customerlist.list'))->with('error', 'No user with this id');
        }
		
        return view('backend.customer.edit',$arrData);

    }
    public function customerUpdate(Request $request,$id){
          $getUserRequest = $this->customerInterface->requestNewCustomer($request,$id);
        if (!empty($getUserRequest) && $getUserRequest['status'] == 200) {
             return redirect(route('admin.customerlist.list'))->with('success', $getUserRequest['msg']);
         }else{
             return redirect()->back()->with('error', 'something wents wrong!');
         }
    }

}
