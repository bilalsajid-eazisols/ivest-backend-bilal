<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membershipclubuser extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
     }

     public function membershipclubs(){
        return $this->hasMany(membershipclub::class,'membershipclub_id','id');
     }
     public function getCreatedAtAttribute($value)
     {
         return \Carbon\Carbon::parse($value)->format('Y-m-d');
     }
}
