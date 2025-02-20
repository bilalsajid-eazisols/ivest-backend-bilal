<?php

namespace App\Models;
use app\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kycdocuments extends Model
{
    use HasFactory;
protected $fillable=[
    'user_id',
    'path',
    'type',
    'subtype'
];
public function user()  {
    return $this->belongsTo(User::class);
}
}

