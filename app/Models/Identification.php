<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    use HasFactory;
    protected $table='identification';
	public function identificationDocImages(){
        return $this->belongsTo(DocIdentification::class,'id','type');
    }
}
