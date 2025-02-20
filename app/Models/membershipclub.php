<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membershipclub extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
    public function author(){
        return $this->belongsTo(User::class,'created_by','id');
     }
     public function users()
     {
         return $this->hasMany(membershipclubuser::class, 'membershipclub_id', 'id');
     }
}
