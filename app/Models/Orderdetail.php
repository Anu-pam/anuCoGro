<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $table = 'order_details';
    
    protected $fillable = [
        'id',
        'services_id',
		'order_id',
    ];
    public function services(){ 
        return $this->belongsTo(Service::class,'services_id','id');
    }
    public function orderserviceImages(){
        return $this->belongsTo(Image::class,'services_id','parent_id')->where('type','services');
    }
	
}
