<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'user_details';
    
    protected $fillable = [
        'gender',
		'phone_no',
		'location',
		'city',
		'postcode',
		'latitude',
		'longitude',
        'user_id'
    ];

}
