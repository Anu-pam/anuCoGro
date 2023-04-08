<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'services_category';
    
    protected $fillable = [
        'name',
		'slug',
		'image' 
    ];
	public function catImages(){
        return $this->belongsTo(Image::class,'id','parent_id')->where('type','service_cat');
    }

}
