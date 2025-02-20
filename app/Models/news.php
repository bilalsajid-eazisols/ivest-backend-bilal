<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;
    protected $fillable = ['title','newscategory_id','thumbnail','content','created_by','updated_by'];
    public function author(){
        return $this->belongsTo(User::class,'created_by','id');
     }
     public function editor(){
         return $this->belongsTo(user::class,'updated_by','id');
     }
     public function category(){
        return $this->belongsTo(category::class,'newscategory_id','id')->where('type',2);
     }
}
