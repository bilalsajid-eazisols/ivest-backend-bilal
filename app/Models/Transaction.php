<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions'; // Define the table name explicitly

    protected $fillable = [
        'user_id',
        'username',
        'email',
        'transaction_id',
        'user_wallet_address',
        'tx_hash',
        'status',
        'amount_usdt',
        'amount_ivt',
    ];

    protected $casts = [
        'amount_usdt' => 'decimal:8',
        'amount_ivt' => 'decimal:8',
    ];
}
