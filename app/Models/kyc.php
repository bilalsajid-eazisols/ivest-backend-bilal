<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kyc extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(user::class,'user_id','id');
    }
    public function approval(){
        return $this->belongsTo(user::class,'updated_by','id');
    }
    public function status(){
        return $this->belongsTo(status::class,'status_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
