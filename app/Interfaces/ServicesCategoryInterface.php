<?php

namespace App\Interfaces;
use App\Http\Requests\ServicesCategoryRequest;
use Symfony\Component\HttpFoundation\Request;

interface ServicesCategoryInterface
{
    /**
     * Get all Service Category
     * 
     * @method  GET api/v1/services/category
     * @access  public
     */
    public function getAllSevicesCategory();

   
    /**
     * Create | Update Service Category
     * 
     * @param   \App\Http\Requests\ServicesCategoryRequest    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/v1/services/category/store       For Create
     * @method  PUT     api/v1/services/category/update/{id}  For Update     
     * @access  public
     */
    public function requestServicesCategory(Request $request, $id = null);

     /**
     * Get Service Category By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/v1/services/category/edit/{id}
     * @access  public
     */
    public function getServiceCategoryById($id);

    /**
     * Delete Services Category
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/v1/services/category/delete/{id}
     * @access  public
     */
    public function deleteServiceCategory($id);
    /**
     * Status Change Service Category
     * 
     * @param   \App\Http\Requests\ServicesCategoryRequest    $request
     * 
     * @method  POST    api/v1/services/category/status/change       For Status Change
     * @access  public
     */
    public function statusChangeServiceCategory(Request $request);
    /**
     * Show On Header Change Service Category
     * 
     * @param   \App\Http\Requests\ServicesCategoryRequest    $request
     * 
     * @method  POST    api/v1/services/category/showonheader/change       For Status Change
     * @access  public
     */
    public function showOnHeaderChangeServiceCategory(Request $request);
	 /**
     * Service Category Count
     * 
     * @access  public
     */
	
	public function getProfessionalTypeCount();
}
