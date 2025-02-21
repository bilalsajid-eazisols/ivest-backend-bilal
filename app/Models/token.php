<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class token extends Model
{
    use HasFactory;
    protected $table = 'tokens'; // Define the table name explicitly

    protected $fillable = [
        'name',
        'membershipclub_id',
        'logo',
        'symbol',
        'token_conversion_rate',
        'transaction_fee',
        'metamask_wallet_address',
        'metamask_wallet_private_key',
        'token_contract_address',
        'initialsupply',
        'circulation',
        'totalsupply',
    ];
}
