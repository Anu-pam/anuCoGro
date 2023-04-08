<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'profession_details';
    
    protected $fillable = [
        'udid',
		'phone_no',
		'location',
        'user_id'
    ];

    public function userProfessionalDetails(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
