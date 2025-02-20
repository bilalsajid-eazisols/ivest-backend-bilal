<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogcomment extends Model
{
    use HasFactory;
    protected $fillable=['comment','created_by','rating','blog_id'];
}
