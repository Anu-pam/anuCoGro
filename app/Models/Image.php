<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\Common;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'tbl_images';
     
    protected $fillable = [
    'parent_id',
		'type',
		'image' 
    ];

      public function getImageAttribute($value)
    {
        return Common::getImageUrl($value,null);
    }

}