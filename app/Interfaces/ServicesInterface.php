<?php

namespace App\Interfaces;
use App\Http\Requests\ServicesRequest;
use Symfony\Component\HttpFoundation\Request;

interface ServicesInterface
{
    /**
     * Get all Service
     * 
     * @method  GET api/v1/services/
     * @access  public
     */
    public function getAllSevices();

    /**
     * Get all Service
     * 
     * @method  GET api/v1/category
     * @access  public
     */
    public function getAllSevicesCategory();

   
    /**
     * Create | Update Service
     * 
     * @param   \App\Http\Requests\ServicesRequest    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/v1/services/store       For Create
     * @method  PUT     api/v1/services/update/{id}  For Update     
     * @access  public
     */
    public function requestServices(Request $request, $id = null);

     /**
     * Get Service By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/v1/services/edit/{id}
     * @access  public
     */
    public function getServiceById($id);

    /**
     * Delete Services
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/v1/services/category/delete/{id}
     * @access  public
     */
    public function deleteService($id);
    /**
     * Status Change Service
     * 
     * @param   \App\Http\Requests\ServicesRequest    $request
     * 
     * @method  POST    api/v1/services/status/change       For Status Change
     * @access  public
     */
    public function statusChangeService(Request $request);
    /**
     * Show On Header Change Service
     * 
     * @param   \App\Http\Requests\ServicesRequest    $request
     * 
     * @method  POST    api/v1/services/showonheader/change       For Status Change
     * @access  public
     */
    public function showOnHeaderChangeService(Request $request);

    /**
     * Get all Service with pagination
     * 
     * @method  GET api/v1/services/
     * @access  public
     */
    public function getAllSevicesWithPaginate($request);
	
	
	 /**
     * Create | Update Service
     * 
     * @param   \App\Http\Requests\ServicesRequest    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/v1/services/store       For Create
     * @method  POST     api/v1/services/update/{id}  For Update     
     * @access  public
     */
    public function requestServicesApi(Request $request, $id = null);
    /**
     * Get all Service
     * 
     * @method  GET api/v1/services/category
     * @access  public
     */
    public function getServicesCat();

    /**
     * Create Professional Service
     * 
     * @method  POST    api/v1/professional/services/store       For Create
     * @access  public
     */
    
     public function requestProfessionalServicesApi(Request $request);
     /**
     * Update Professional Service
     * * @param   integer                           $id
     * 
     * @method  POST    api/v1/professional/services/update/{id}       For Update
     * @access  public
     */

     public function requestProfessionalServicesUpdateApi(Request $request,$id);
	 

     public function professionalServicePrice($id);


     public function professionalServicePriceUpdate(Request $request);

	 /**
     * Get all Orders
     * 
     * @method  GET api/v1/orders
     * @access  public
     */
    public function getOrders();
	 
	 /**
     * Create Order
     * 
     * @method  POST    api/v1/order/update       For Update
     * @access  public
     */

     public function requestOrderApi(Request $request);
	 
	 /**
     * Service Count
     * 
     * @access  public
     */
	
	public function getServiceCount();
	/**
     * Get latest Orders
     * 
     * @access  public
     */
	
	public function getLatestOrders();
	/**
     * Delete Services
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/v1/orders/delete/{id}
     * @access  public
     */
    public function deleteOrder($id);

    
     /**
     * Get Order By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/v1/orders/edit/{id}
     * @access  public
     */
    public function getOrderById($id);

    /**
     * Status Change Order
     * 
     * @method  POST    api/v1/orders/status/change       For Status Change
     * @access  public
     */
    public function statusChangeOrder(Request $request);

     /**
     * Order Count
     * 
     * @access  public
     */
	public function getOrderCount($type="");
     /**
     * Total Revenue
     * 
     * @access  public
     */
     public function getTotalRevenue($type="");

     public function OrderCancelByCronJob();
    
     public function getStripeResource();

     public function getidentification();

     public function setidentification(Request $request);
	 
	 public function getDocuments();
	 
	 public function getDocumentsRemove($id);
	 
	 public function getReviews();
	 
	 public function deleteReview($id);
	 
	 public function requestGallery(Request $request);

     public function getRequestGallery();
	 
	public function galleryDelete($id);

     public function servicesPrice($request);
}
