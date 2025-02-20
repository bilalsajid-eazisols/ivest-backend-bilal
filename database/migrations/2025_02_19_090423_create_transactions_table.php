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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('username');
            $table->string('email');
            $table->string('transaction_id')->unique();
            $table->string('user_wallet_address');
            $table->string('tx_hash')->nullable(); // Nullable because it will be updated later
            $table->enum('status', ['created', 'payment-received', 'completed'])->default('created');
            $table->decimal('amount_usdt', 18, 8); // Storing up to 8 decimal places
            $table->decimal('amount_ivt', 18, 8);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
