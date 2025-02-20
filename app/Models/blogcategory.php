<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogcategory extends Model
{
    use HasFactory;
    protected $fillable= ['name','display','is_active','created_by','edited_by'];
    public function created_by(){
       return $this->belongsTo(User::class,'created_by','id');
    }
    public function updated_by(){
        return $this->belongsTo(user::class,'updated_by','id');
    }
    public function blogs(){
        return $this->hasMany(blog::class,'blogcategory_id',"id");
    }
}
