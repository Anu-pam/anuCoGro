<?php



namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Interfaces\ServicesCategoryInterface;
use App\Interfaces\ServicesInterface;
use App\Http\Requests\ServicesRequest;

class ServicesController extends BaseController
{
    protected $serviceCategoryInterface;
    protected $servicesInterface;
    /**
     * Create a new constructor for this controller
     */
    public function __construct(ServicesCategoryInterface $serviceCategoryInterface,ServicesInterface $servicesInterface)
    {
        $this->serviceCategoryInterface = $serviceCategoryInterface;
        $this->servicesInterface = $servicesInterface;
    }

    /**
     * Get all active services category
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceCategory(Request $request)
    {
        $data =  $this->serviceCategoryInterface->getAllSevicesCategory($request);
		return $this->sendResponse($data,'data');
    }

    /**
     * Get all active services
     *
     * @return \Illuminate\Http\Response 
     */
    public function services(Request $request)
    {
        $data =  $this->servicesInterface->getAllSevicesWithPaginate($request);
        return $this->sendResponse($data,'data');
    }
     /** 
     * create service api
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceStore(Request $request)
    {
        return $this->servicesInterface->requestServicesApi($request);
    }
    /**
     * UpdatE service api
     *  @param   integer                           $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function serviceUpdate(Request $request,$id)
    {
        return $this->servicesInterface->requestServicesApi($request,$id);
    }
     /**
     * Get services with id
     * @param   integer                           $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
	{
		return $this->servicesInterface->getServiceById($id);
    }
    /**
     * Get all active services category
     *
     * @return \Illuminate\Http\Response
     */
    public function servicesCat(){
        return $this->servicesInterface->getServicesCat();
    }
    /**
     * create professional service api
     *
     * @return \Illuminate\Http\Response
     */
    public function professionalServiceStore(Request $request){
        return $this->servicesInterface->requestProfessionalServicesApi($request);
    }
     /**
     * Update professional service api
     *  @param   integer                           $id
     *
     * @return \Illuminate\Http\Response
     */
    public function professionalServiceUpdate(Request $request,$id){
        return $this->servicesInterface->requestProfessionalServicesUpdateApi($request,$id);
    }

    public function professionalServicePrice($id){
        return $this->servicesInterface->professionalServicePrice($id);
    }

    public function professionalServicePriceUpdate(Request $request){
        return $this->servicesInterface->professionalServicePriceUpdate($request);
    }

    /**
     * Get all active orders
     *
     * @return \Illuminate\Http\Response
     */
    public function orders(Request $request)
    {
        $data =  $this->servicesInterface->getOrders($request);
        return $this->sendResponse($data,'data');
    }
	 /**
     * Create Order api
     
     * @return \Illuminate\Http\Response
     */
	public function orderStore(Request $request){
		return $this->servicesInterface->requestOrderApi($request);
	}

    public function OrderCancelByCronJob(){
       return $this->servicesInterface->OrderCancelByCronJob();
    }
    
    public function getStripeResource(){
        return $this->servicesInterface->getStripeResource();
    }

    public function getidentification(){
        return $this->servicesInterface->getidentification();
    }

    public function setidentification(Request $request){
        return $this->servicesInterface->setidentification($request);
    }
	public function getDocuments(){
		return $this->servicesInterface->getDocuments();
	}
	public function getDocumentsRemove($id){
		return $this->servicesInterface->getDocumentsRemove($id);
	}
	public function requestGallery(Request $request){
		return $this->servicesInterface->requestGallery($request);
	}
    
    public function getRequestGallery(){
		return $this->servicesInterface->getRequestGallery();
	}
	public function galleryDelete($id){
		return $this->servicesInterface->galleryDelete($id);
	}
    public function servicesPrice(Request $request)
    {
        return $this->servicesInterface->servicesPrice($request);
    }
 

}
 