<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'otp';
    
    protected $fillable = [
        'user_id ',
		'type',
		'is_user',
		'is_for',
		'is_otp'
    ];

}
