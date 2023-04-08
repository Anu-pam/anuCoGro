<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'payments';
    
    protected $fillable = [
        'id',
        'order_id',
		'payment_method',
		'total_amount',
		'payment_date',
    ];
	

}
