<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocIdentification extends Model
{
    use HasFactory;
	protected $table='doc_identifications';
	public function identification(){
        return $this->belongsTo(Identification::class,'type','id');
    }
	public function ProfUser(){
        return $this->belongsTo(user::class,'user_id','id');
    }
}
