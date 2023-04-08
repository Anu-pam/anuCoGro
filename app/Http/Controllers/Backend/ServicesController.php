<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
//use App\Http\Controllers\Backend\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ServicesInterface;
use App\Http\Requests\ServicesRequest;

class ServicesController extends Controller
{
	protected $servicesInterface;
	/**
	 * Create a new constructor for this controller
	 */
	public function __construct(ServicesInterface $servicesInterface)
	{
		$this->servicesInterface = $servicesInterface;
	}

	public function index()
	{
		$user = Auth::user();
		$arrData = array();
		if (!empty($user)) {
			$getServiceList = $this->servicesInterface->getAllSevices();
			$arrData['getObjServiceList'] = $getServiceList['results'];
			return view('backend.services.list', $arrData);
		} else {
			return redirect(route('admin.auth.login'));
		}
	}
	public function create()
	{
		$arrData = array();
        $getServicesCategoryList = $this->servicesInterface->getAllSevicesCategory();
        $arrData['getServicesCategories'] = $getServicesCategoryList['results'];
		return view('backend.services.add', $arrData);
	}
	public function store(ServicesRequest $request)
	{
		$getServiceRequest = $this->servicesInterface->requestServices($request);

		if (!empty($getServiceRequest) && $getServiceRequest['status'] == 200) {
			return redirect(route('admin.services.list'))->with('success', $getServiceRequest['msg']);
		} else
			return redirect()->back()->with('error', $getServiceRequest['msg']);
	}
	public function edit($id)
	{
		$arrData = array();
        $getServicesCategoryList = $this->servicesInterface->getAllSevicesCategory();
        $arrData['getServicesCategories'] = $getServicesCategoryList['results'];
		$getServices = $this->servicesInterface->getServiceById($id);
		if(!empty($getServices['results'])){
		  $arrData['getService'] = $getServices['results'];
		}else{
			return redirect(route('admin.services.list'))->with('error', 'No service with ID');
		}
		return view('backend.services.edit', $arrData);
	}
	public function update(ServicesRequest $request, $id)
	{
		$getServiceRequest = $this->servicesInterface->requestServices($request, $id);
		if (!empty($getServiceRequest) && $getServiceRequest['status'] == 200) {
			return redirect(route('admin.services.list'))->with('success', $getServiceRequest['msg']);
		} 
	}
	public function delete($id)
	{
		$deleteService = $this->servicesInterface->deleteService($id);
		if (!empty($deleteService) && $deleteService['status'] == 200) {
			return redirect(route('admin.services.list'))->with('success', $deleteService['msg']);
		}
	}
	public function statusChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeService = $this->servicesInterface->statusChangeService($request);
			return $statusChangeService;
		}
	}
	public function showOnHeaderChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeService = $this->servicesInterface->showOnHeaderChangeService($request);
			return $statusChangeService;
		}
	}
	public function view($id){
		$arrData = array();
        $getServices = $this->servicesInterface->getServiceById($id);
		if(!empty($getServices['results'])){
		  $arrData['getService'] = $getServices['results'];
		}else{
			return redirect(route('admin.services.list'))->with('error', 'No service with ID');
		}
		return view('backend.services.view', $arrData);
	}
}
