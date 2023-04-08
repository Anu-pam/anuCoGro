<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ServicesInterface;
use App\Http\Requests\ServicesRequest;
use App\Http\Helpers\Common;

class ReviewController extends Controller
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
		//$getImageUrl = Common::getImageUrl('/uploads/users/1658228009.jpg','user_profile');
		//echo "<pre>";var_dump($getImageUrl);exit;
		$user = Auth::user();
		$arrData = array();
		if (!empty($user)) {
			$getReviewList = $this->servicesInterface->getReviews();
			$arrData['getObjReviewList'] = $getReviewList['results'];
			return view('backend.review.list', $arrData);
		} else {
			return redirect(route('admin.auth.login'));
		}
	}
	public function delete($id)
	{
		$deleteReview = $this->servicesInterface->deleteReview($id);
		if (!empty($deleteReview) && $deleteReview['status'] == 200) {
			return redirect(route('admin.review.list'))->with('success', $deleteReview['msg']);
		}
	} 
	
	
}
