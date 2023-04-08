<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactusEnquiry extends Model
{
	protected $table = 'contactus_enquiries';
    protected $fillable =  [
        'name', 'email', 'phone', 'message'
    ];

}
