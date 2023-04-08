<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'reviews';
    
    protected $fillable = [
        'id',
        'order_id',
		'professional_id',
		'user_id',
		'user_name',
		'user_email_id',
		'user_mobile_no',
		'rating',
		'review_text',
		'review_time',
		'status'
    ];
	public function ReviewProfUser(){
        return $this->belongsTo(User::class,'professional_id','id');
    }
	public function ReviewOrder(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
	public function ReviewUser(){
        return $this->belongsTo(User::class,'user_id','id');
    }
	

}
