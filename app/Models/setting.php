<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    use HasFactory;
    protected $fillable=[
        'smtp_fromaddress',
        'smtp_fromname',
        'smtp_password',
        'smtp_username',
        'smtp_encryption',
        'smtp_port',
        'smtp_host',
    ];
}
