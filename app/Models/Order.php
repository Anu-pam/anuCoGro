<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'orders';
    
    protected $fillable = [
        'id',
        'service_id', 
		'customer_id',
		'customer_name', 
		'email',
		'phone_no',
		'total_amount',
		'order_date'
    ];
	public function Service(){ 
        return $this->belongsTo(Service::class,'service_id','id');
    }
	public function Payment(){
        return $this->belongsTo(Payment::class,'id','order_id');
    }
    public function detail(){
        return $this->hasMany(Orderdetail::class,'order_id','id');
    }
    public function ProfessionalUser(){
        return $this->belongsTo(User::class,'professional_id','id'); 
    }
    public function costomerName(){
        return $this->belongsTo(User::class,'customer_id','id');
    }
    public function professioinlalAddress(){
        return $this->belongsTo(ProfessionDetail::class,'professional_id','user_id');
    }
    public function orderAddress(){
        return $this->belongsTo(OrderAddress::class,'id','order_id');
    }
    public function orderAmount(){
        return $this->hasMany(OrderDetails::class,'order_id','id'); 
    }
    public function ProfessionalImages(){
        return $this->belongsTo(Image::class,'parent_id','professional_id')->where('type','user_profile');
    }
    public function CustomerImages(){
        return $this->belongsTo(Image::class,'parent_id','customer_id')->where('type','user_profile');
    }
    public function customerdetail(){
        return $this->belongsTo(UserDetail::class,'customer_id','user_id');
    }
    
    public function professionaldetail(){
        return $this->belongsTo(ProfessionDetail::class,'professional_id','user_id');
    }
    public function customerLatLong(){
        return $this->belongsTo(OrderAddress::class,'id','order_id');
    }
    public function orderStatus(){
       return $this->hasMany(Orderstatushistory::class,'order_id','id');
    }
    public function ordertax(){
        return $this->hasMany(OrderTax::class,'order_id','id');
    }
    

}
