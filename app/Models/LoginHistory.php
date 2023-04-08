<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'login_history';
    
    protected $fillable = [
        'loged_out',
		'loged_in_token_id',
		'type',
        'location',
        'user_id'
    ];

}
