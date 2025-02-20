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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membershipclub_id');
            $table->string('name');
            $table->foreign('membershipclub_id')->references(  'id')->on('membershipclubs')->onDelete('cascade');
            $table->string('logo');
            $table->string('symbol');
            $table->float('initialsupply')->default(999999);
            $table->float('circulation')->default(0);
            $table->float('totalsupply')->default(999999);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
