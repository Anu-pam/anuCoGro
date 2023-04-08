<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use App\Http\Helpers\Common;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable. 
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
		'role',
		
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
    
    //protected $appends = ['userimg'];
	protected $appends = ['profavgrating','proftotalrating','live','schedule'];
	//protected $append = ['proftotalrating'];
	public function userProfileImages(){
        return $this->belongsTo(Image::class,'id','parent_id')->where('type','user_profile');
    }
	public function userRole(){
        return $this->belongsTo(Role::class,'role','id');
    }
	public function userProfessionalDetails(){
        return $this->belongsTo(ProfessionDetail::class,'id','user_id');
    }
    public function userCustomerDetails(){
        return $this->belongsTo(UserDetail::class,'id','user_id');
    }
	public function services(){
        return $this->hasMany(ProfessionalService::class,'professional_id')->limit(5);
    }
	public function userDetails(){
        return $this->belongsTo(UserDetail::class,'id','user_id');
    }
    public function image(){
        return $this->belongsTo(Image::class,'id','parent_id');
    }
    public function isFav(){
        $user = Auth::user();
        return $this->hasMany(UserFavoriteProfessionalist::class,'prof_id');
    }
    public function getPhotoAttribute($value)
    {
        return Common::getImageUrl($value,'user_profile');
    }
	public function reviews()
	{
		return $this->hasMany(Review::class,'professional_id');
	}
	public function reviewUsers()
	{
		return $this->hasMany(Review::class,'user_id');
	}
    // public function getUserimgAttribute()
    // {
        // return (!empty($this->image))?$this->image->where('parent_id',$this->id)->where('type','user_profile')->first():'';
    // }
    public function getProfAvgRatingAttribute()
    {
        return intval($this->reviews()->avg('rating'));
    }
	public function getProfTotalRatingAttribute()
    {
        return $this->reviews()->count('rating');
    }

    public function getLiveAttribute(){
         return $this->available_status == 1 ? true : false;
    }

    public function getScheduleAttribute(){
        return $this->sch_available == 1 ? true : false;
    }
    public function scopeByCatId($query, $catId)
    {
        return 
            $query->leftJoin("professional_services as professional_services","users.id","=","professional_services.professional_id")
            ->leftJoin("services as services","services.id","=","professional_services.service_id")
            ->where("services.category_ids","=",$catId);
    }
   
}
