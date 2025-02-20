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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('Financial_knowedge')->nullable();
            $table->boolean('Pre_ipo_companies')->nullable();

            $table->boolean('facebook_backers')->nullable();

            $table->boolean('exclusive_member')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('Financial_knowedge');
            $table->dropColumn('Pre_ipo_companies');
            $table->dropColumn('facebook_backers');
            $table->dropColumn('exclusive_member');
        });
    }
};
