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
        Schema::create('membershipclubfiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membershipclub_id');
            $table->unsignedBigInteger('user_id');
            $table->string('file');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('membershipclub_id')->references('id')->on('membershipclubs')->onDelete('cascade');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membershipclubfiles');
    }
};
