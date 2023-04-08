<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalService extends Model
{
	protected $table = 'professional_services';
    // protected $attribute = ['srCat','srCatId'];
    protected $fillable =  [
        'service_id',  
		'price', 
		'professional_id' 
    ]; 
    // protected $appends = ['srCat','srCatId'];
	public function icon(){
        return $this->belongsTo(Image::class,'service_id','parent_id')->where('type','services');
    }
    public function serviceIcon(){
       return $this->belongsTo(Image::class,'service_id','parent_id')->where('type','services');
    }
    public function ProfessionalStatus(){
        return $this->belongsTo(User::class,'professional_id','id');
    }
    public function services(){
        return $this->belongsTo(Service::class,'service_id','id');
    }
    // public function getSrCatAttribute(){
    //     return $this->services->service_cat;
    // }
    public function scopeByCatId($query, $catId)
    {
        return $query->leftJoin("services as services","services.id","=","professional_services.service_id")
            ->where("services.category_id","=",$catId);
    }


}
