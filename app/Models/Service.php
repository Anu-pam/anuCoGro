<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'services';
    protected $attributes = [
            'isChecked' => false,
            'is_checked'=>false 
        ];
    protected $appends = ['isChecked'];
    protected $fillable = [
        'id', 
        'name',
		'slug',
		'image'
    ];
    public function getIsCheckedAttribute()
    {
        return false; 
    }
	public function Service_cat(){
        return $this->belongsTo(ServiceCategory::class,'category_id','id');
    }
	public function serviceImages(){
        return $this->belongsTo(Image::class,'id','parent_id')->where('type','services');
    }
	

}
