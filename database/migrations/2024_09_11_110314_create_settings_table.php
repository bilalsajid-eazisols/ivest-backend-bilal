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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('smtp_host');
            $table->string('smtp_port');
            $table->string('smtp_encryption');
            $table->string('smtp_username');
            $table->string('smtp_password');
            $table->string('smtp_fromname')->nullable();
            $table->string('smtp_fromaddress')->nullable();





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
