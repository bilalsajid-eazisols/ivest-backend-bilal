<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    public function blogs(){
        return $this->hasMany(blog::class,'blogcategory_id',"id");
    }
    public function news(){
        return $this->hasMany(news::class,'newscategory_id',"id");
    }

}
