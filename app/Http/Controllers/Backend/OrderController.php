<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
//use App\Http\Controllers\Backend\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ServicesInterface;
use App\Http\Requests\ServicesRequest;

class OrderController extends Controller
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
		// $client = new \GuzzleHttp\Client();
        // $request = $client->get('http://localhost/groom-me/api/v1/orders');
        // $response = json_decode($request->getBody()->getContents());
        // echo '<pre>';
        // var_dump($response);
        // exit;
        // $client = new \GuzzleHttp\Client();
        // $uri = 'http://localhost/groom-me/api/v1/orders';
        // $header = ['headers' => ['X-Auth-Token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiNjZmOWFmMTRmZTNkMDdhN2I3Y2I5MjEyMzRhMjA5NDhhNzhmNGE5YzAzMTQ0ZDlkMzQ0YjE3MzVlMGEzZmZmZGE0ZjNmNGZlMTliZjZjMGUiLCJpYXQiOjE2NDkzMjUxMzIuOTAxNjU1LCJuYmYiOjE2NDkzMjUxMzIuOTAxNjYxLCJleHAiOjE2ODA4NjExMzIuNzA3MDYxLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.tbI4NTcHDUutA9FqHl9BL0h2mYvpCOrB9yIZhwr8GTdQpQvMKVS4AZe0SIh80kMY8OCaIyXjpuKcRO7C7Rh0bZP0Wq3Ef_25JMXURND3ecZwAi8LZ5UURu-kPdd9NSKvs_dFsKrtoNXsJzcXaIHTGI6w-JPXcc1xEgeeCB_5EeSbV8BkvE9Q173DBJY2YauGe164HrH-B55SUuOSzXzL46e4f4DKoXoQucGQPkorxjIYkc_Fr8O3hFOMds1UUyb9LFcsLdsQRxCBD8u8qRNHcKTNlTOJN_peLofeiB6VtlcYeRCGI9fv_AyVt4OgBvySZfXuwDBDbdsarhUZUO41SGc3EgV5wizn5MEQQwSeU0G9nr4PlAqEHpRjJU-AaQvy2Z7O9PL774LIIcbIXYCGihe8XNKaaqpdTkoT3ocN9qnFVROeNpvLJQWdBUps8Lpf95tWV0-4uNJMw9a5hsc8Q2kipCKgUJaAoJwwZylBRxX7ErTzkLmc2n8bIa17aO2O3OP3sK2JDFXw2xMKB1pezePpVtPcGyBuJ2BpaJTS35u_sqmtys9GiyX95eFE1zW6m-tvEhhK7-KU9qT77-K0EasJnBIakb3i-b2sWmSPHqkjUdJThB1HJVaZVXNgUvAdNvuMa9rRzYlBeneALmQB8euwiqvfRoEEQfN0KVL_XiE']];
        // $res = $client->get($uri, $header);
        // $data = json_decode($res->getBody()->getContents(), true);
		//echo "<pre>";var_dump($data);exit;
        //return $data['matches'];
		
	   
		$user = Auth::user();
		$arrData = array();
		if (!empty($user)) {
			$getOrderList = $this->servicesInterface->getOrders();
			$arrData['getObjOrderList'] = $getOrderList['results'];
			return view('backend.order.list', $arrData);
		} else {
			return redirect(route('admin.auth.login'));
		}
	}
	public function delete($id)
	{
		$deleteOrder = $this->servicesInterface->deleteOrder($id);
		if (!empty($deleteOrder) && $deleteOrder['status'] == 200) {
			return redirect(route('admin.orders.list'))->with('success', $deleteOrder['msg']);
		}
	} 
	public function view($id){ 
	    $getOrder['results'] = $this->servicesInterface->getOrderById($id);
		if(!empty($getOrder['results'])){ 
	        //    var_dump($getOrder['results']->detail[0]->orderserviceImages->image);		exit;
		    $arrData['getOrder'] = $getOrder['results'];
		}else{
			return redirect(route('admin.orders.list'))->with('error', 'No order with ID');
		} 
		return view('backend.order.view', $arrData); 
	}
	public function statusChange(Request $request)
	{
		if ($request->ajax()) {
			$post = $request->post();
			$statusChangeOrder = $this->servicesInterface->statusChangeOrder($request);
			return $statusChangeOrder;
		}
	}
	public function reportView($id){
		$getOrder = $this->servicesInterface->getOrderById($id);
		if(!empty($getOrder['results'])){
		    $arrData['getOrder'] = $getOrder['results'];
		}else{
			return redirect(route('admin.orders.list'))->with('error', 'No order with ID');
		}
		return view('backend.order.report', $arrData);
	}
	
}
