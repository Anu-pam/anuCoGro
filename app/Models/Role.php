<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'roles';
    
    protected $fillable = [
        'name',
		'guard_name'
    ];
	
	public function users()
{
	return $this->hasMany('App\Models\User');
}
	
}
