<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\emailverify;
use App\Models\kycdocuments;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
// use App\Models\kycdocuments;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, CanResetPassword,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'FirstName',
        'LastName',
        'username',
        'country',
        'city',
        'address',
        'email',
        'password',
        'is_verified',
        'user_type',
        'Financial_knowedge',
        'Pre_ipo_companies',
        'facebook_backers',
        'exclusive_member',
        'email_verified_at'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function kycdocuments(){
        return $this->hasMany(kycdocuments::class);
    }

public function profileImage()
{
    return $this->kycdocuments()->where('type', 'profile')->first()->path ?? asset('defaults/user-profile-icon.png');
}
public function profileNodefault()
{
    return $this->kycdocuments()->where('type', 'profile')->first()->path??null ;
}
public function driver_license_front(){
    return $this->kycdocuments()->where('type', 'driver-license')->where('subtype','front')->first()->path ?? null;


}
public function driver_license_back(){
    return $this->kycdocuments()->where('type', 'driver-license')->where('subtype','back')->first()->path ?? null;


}
public function id_front(){
    return $this->kycdocuments()->where('type', 'id-card')->where('subtype','front')->first()->path ?? null;


}
public function id_back(){
    return $this->kycdocuments()->where('type', 'id-card')->where('subtype','back')->first()->path ?? null;


}
public function passport()
{
    return $this->kycdocuments()->where('type', 'passport')->first()->path ?? null;
}

//blog category


    public function blog_category_created_by(){
       return $this->hasMany(blogcategory::class,'created_by','id');
    }
    public function blog_category_created_byupdated_by(){
        return $this->hasMany(blogcategory::class,'updated_by','id');
    }
//Blogs


public function blog_created_by(){
    return $this->hasMany(blog::class,'created_by','id');
 }
 public function blog_updated_by(){
     return $this->hasMany(blog::class,'updated_by','id');
 }
//news category

public function news_category_created_by(){
    return $this->hasMany(newscategory::class,'created_by','id');
 }
 public function news_category_updated_by(){
     return $this->hasMany(newscategory::class,'updated_by','id');
 }
 public function membershipclubs    ()
 {
     return $this->hasManyThrough(
         membershipclub::class, // The target model you want to get (membershipclub)
         membershipclubuser::class, // The intermediate model
         'user_id', // Foreign key on the membershipclubuser table
         'id', // Foreign key on the membershipclub table
         'id', // Local key on the users table
         'membershipclub_id' // Local key on the membershipclubuser table
     );
 }
 public function getCreatedAtAttribute($value)
     {
         return \Carbon\Carbon::parse($value)->format('Y-m-d');
     }
     public function kycs()
     {
         return $this->hasMany(Kyc::class);
     }

     public function latestKyc()
     {
         return $this->hasOne(Kyc::class)->latestOfMany();
     }


}
