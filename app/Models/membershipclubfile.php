<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membershipclubfile extends Model
{
    protected $fillable=['membershipclub_id','file','user_id','size','extension','name'];
    use HasFactory;
}
