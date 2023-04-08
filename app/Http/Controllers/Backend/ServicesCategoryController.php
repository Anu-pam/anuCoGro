<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
//use App\Http\Controllers\Backend\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ServicesCategoryInterface;
use App\Http\Requests\ServicesCategoryRequest;

class ServicesCategoryController extends Controller
{
	protected $servicesCategoryInterface;
	/**
	 * Create a new constructor for this controller
	 */
	public function __construct(ServicesCategoryInterface $servicesCategoryInterface)
	{
		$this->servicesCategoryInterface = $servicesCategoryInterface;
	}

	public function index()
	{
		$user = Auth::user();
		$arrData = array();
		if (!empty($user)) {
			$getServiceCategoryList = $this->servicesCategoryInterface->getAllSevicesCategory();
			$arrData['getArrServiceCategoryList'] = $getServiceCategoryList['results'];
			return view('backend.services.category.list', $arrData);
		} else {
			return redirect(route('admin.auth.login'));
		}
	}
	public function create()
	{
		$arrData = array();
		return view('backend.services.category.add', $arrData);
	}
	public function store(ServicesCategoryRequest $request)
	{
		$getServiceCategoryRequest = $this->servicesCategoryInterface->requestServicesCategory($request);

		if (!empty($getServiceCategoryRequest) && $getServiceCategoryRequest['status'] == 200) {
			return redirect(route('admin.services.category.list'))->with('success', $getServiceCategoryRequest['msg']);
		} else
			return redirect()->back()->with('error', $getServiceCategoryRequest['msg']);
	}
	public function edit($id)
	{
		$arrData = array();
		$getServiceCategory = $this->servicesCategoryInterface->getServiceCategoryById($id);
		if(!empty($getServiceCategory['results'])){
			$arrData['getServiceCat'] = $getServiceCategory['results'];
		}else{
			return redirect(route('admin.services.category.list'))->with('error', 'No service category with ID');
		}
		
		return view('backend.services.category.edit', $arrData);
	}
	public function update(ServicesCategoryRequest $request, $id)
	{
		$getServiceCategoryRequest = $this->servicesCategoryInterface->requestServicesCategory($request, $id);
		if (!empty($getServiceCategoryRequest) && $getServiceCategoryRequest['status'] == 200) {
			return redirect(route('admin.services.category.list'))->with('success', $getServiceCategoryRequest['msg']);
		} 
	}
	public function delete($id)
	{
		$deleteServiceCategory = $this->servicesCategoryInterface->deleteServiceCategory($id);
		if (!empty($deleteServiceCategory) && $deleteServiceCategory['status'] == 200) {
			return redirect(route('admin.services.category.list'))->with('success', $deleteServiceCategory['msg']);
		}
	}
	public function statusChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeServiceCat = $this->servicesCategoryInterface->statusChangeServiceCategory($request);
			return $statusChangeServiceCat;
		}
	}
	public function showOnHeaderChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeServiceCat = $this->servicesCategoryInterface->showOnHeaderChangeServiceCategory($request);
			return $statusChangeServiceCat;
		}
	}
	public function view($id){
		$arrData = array();
		$getServiceCategory = $this->servicesCategoryInterface->getServiceCategoryById($id);
		if(!empty($getServiceCategory['results'])){
			$arrData['getServiceCat'] = $getServiceCategory['results'];
		}else{
			return redirect(route('admin.services.category.list'))->with('error', 'No service category with ID');
		}
		
		return view('backend.services.category.view', $arrData);
	}
}
