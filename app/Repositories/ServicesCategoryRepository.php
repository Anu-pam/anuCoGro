<?php

namespace App\Repositories;

use App\Http\Requests\ServicesCategoryRequest;
use App\Interfaces\ServicesCategoryInterface;
use App\Traits\ResponseAPI;
use App\Models\ServiceCategory;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServicesCategoryRepository implements ServicesCategoryInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllSevicesCategory()
    {
        $arrReturn  = array();
        try {
            $serviceCategory = ServiceCategory::all();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "All Service Category";
            $arrReturn['results'] = $serviceCategory;
            return $arrReturn;
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function getServiceCategoryById($id)
    {
        $arrReturn = array();
        try {
            $serviceCategory = ServiceCategory::find($id);
            // Check the user
           // if (!$serviceCategory) return $this->error("No service category with ID $id", 404);
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Category Detail";
            $arrReturn['results'] = $serviceCategory;
            return $arrReturn;

            //return $this->success("Service Category Detail", $serviceCategory);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
            //return $this->error($e->getMessage(), $e->getCode());
        }
    }


    public function requestServicesCategory($request, $id = null)
    {
        DB::beginTransaction();
        try {
            $arrReturn  = array();
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                //return $this->error('Validation Error.', $validator->errors()->messages(), 500);
            }

            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $serviceCategory = $id ? ServiceCategory::find($id) : new ServiceCategory;
			$serviceCategory->name = $request->name;
            $serviceCategory->slug =  $this->createSlug($request->name);
            $serviceCategory->status = $request->status;
            $serviceCategory->show_on_header = ($request->show_on_header == 'on') ? 1 : 0;
            // Save the user
            $serviceCategory->save();

            $getImage = Image::where('parent_id',$id)->first();
            //echo "<pre>";var_dump($getImage);exit;
            $Image = !empty($getImage) ? Image::find($getImage->id) : new Image;
            // Check the user 
            //if ($id && !$serviceCategory) return $this->error("No service category with ID $id", 404);
            if (!empty($request->hasFile('image'))) {
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:204800'
                ]);
                $image = $request->file('image');
                $timestamp = time();
                $name = $timestamp . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/services/category');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $imageName = $name;
                $imageNameLink = '/uploads/services/category/' . $name;
                $Image->parent_id = !empty($id) ? $id : $serviceCategory->id;
                $Image->type = 'service_cat';
                $Image->image = $imageNameLink;
                $Image->save();
            }

            
            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = $id ? "Service Category updated"
            : "Service Category created";
            return $arrReturn;
            // return $this->success(
            //     $id ? "Service Category updated"
            //         : "Service Category created",
            //     $serviceCategory,
            //     $id ? 200 : 201
            // );
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;//$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function deleteServiceCategory($id)
    {
        $arrReturn  = array();
        DB::beginTransaction();
        try {
            $serviceCategory = ServiceCategory::find($id);
            // Check the user
            //if (!$serviceCategory) return $this->error("No service category with ID $id", 404);

            // Delete the user
            $serviceCategory->delete();

            DB::commit();
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Category deleted";
            return $arrReturn;//$this->success("Service Category deleted", $serviceCategory);
        } catch (\Exception $e) {
            DB::rollBack();
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;//$this->error($e->getMessage(), $e->getCode());
        }
    }

    public function statusChangeServiceCategory($request)
    {
        $arrReturn = array();
        try {
            $post = $request->post();
            $id = $post['catId'];
            $status = $post['status'];
            $serviceCategory = ServiceCategory::find($id);
            $serviceCategory->status = $status;
            $serviceCategory->update();
            // Check the user
            //if (!$serviceCategory) return $this->error("No service category with ID $id", 404);
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Category Status Change";
            return $arrReturn;//$this->success("Service Category Status Change", $serviceCategory);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn; //$this->error($e->getMessage(), $e->getCode());
        }
    }
    public function showOnHeaderChangeServiceCategory($request)
    {
        $arrReturn = array();
        try {
            $post = $request->post();
            $id = $post['catId'];
            $status = $post['status'];
            $serviceCategory = ServiceCategory::find($id);
            $serviceCategory->show_on_header = $status;
            $serviceCategory->update();
            // Check the user
            //if (!$serviceCategory) return $this->error("No service category with ID $id", 404);
            $arrReturn['status'] = 200;
            $arrReturn['msg'] = "Service Category Show On Header Change";
            return $arrReturn;//$this->success("Service Category Show On Header Change", $serviceCategory);
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;//$this->error($e->getMessage(), $e->getCode());
        }
    }
	public function getProfessionalTypeCount(){
		$arrReturn = array();
        try {
			
            $serviceCat = ServiceCategory::count();
            $arrReturn['status'] = 200;
			$arrReturn['msg'] = "All Service Category Count";
            $arrReturn['results'] = $serviceCat;
            return $arrReturn; 
        } catch (\Exception $e) {
            $arrReturn['status'] = $e->getCode();
            $arrReturn['msg'] = $e->getMessage();
            return $arrReturn;
        }
	}


    /** 

     * Write code on Method

     *

     * @return response()

     */

    private function createSlug($title)
    {

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($title));
        $getObjServicesCatSlug = ServiceCategory::where(DB::raw("CONCAT(slug)"), 'like', "%" . $slug . "%")->get();
        $countSlug = $getObjServicesCatSlug->count();
        $finalSlug = ($countSlug > 0) ? ($slug . '-' . $countSlug) : $slug;
        return $finalSlug;
    }
}
