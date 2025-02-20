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
        Schema::table('membershipclubs', function (Blueprint $table) {
            //
            $table->tinyText('publicYTembed')->nullable();
            $table->string('VideoTitle')->nullable();
            $table->tinyText('privateYTembed')->nullable();
            $table->mediumText('features')->nullable();
            $table->mediumText('goals')->nullable();
            $table->float('price')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membershipclubs', function (Blueprint $table) {
            //
            $table->dropColumn('publicYTembed');
            $table->dropColumn('VideoTitle');

            $table->dropColumn('privateYTembed');

            $table->dropColumn('features');

            $table->dropColumn('goals');
            $table->dropColumn(columns: 'price');


        });
    }
};
