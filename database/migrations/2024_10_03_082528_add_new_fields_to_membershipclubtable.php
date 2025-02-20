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
            $table->string('img')->nullable();
            $table->string('discordwidget')->nullable();
            $table->tinyInteger('status')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membershipclubs', function (Blueprint $table) {
            //
            $table->dropColumn('img');
            $table->dropColumn('discordwidget');
            $table->dropColumn('status');

        });
    }
};
