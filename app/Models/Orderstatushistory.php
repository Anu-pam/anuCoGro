<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderstatushistory extends Model
{
    use HasFactory;
    protected $table = 'order_status_history';
    
    public function userdetails(){
        return $this->belongsTo(User::class,'changed_by','id');
    }
}
