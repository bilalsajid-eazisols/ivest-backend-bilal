<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->decimal('token_conversion_rate')->after('symbol'); // Adjust precision as needed
            $table->string('metamask_wallet_address')->after('token_conversion_rate');
            $table->string('metamask_wallet_private_key')->after('metamask_wallet_address');
            $table->string('token_contract_address')->after('metamask_wallet_private_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropColumn([
                'token_conversion_rate',
                'metamask_wallet_address',
                'metamask_wallet_private_key',
                'token_contract_address'
            ]);
        });
    }
};
