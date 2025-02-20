<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->decimal('transaction_fee')->default(0.00)->after('token_conversion_rate'); // Replace 'column_name' with an existing column name
        });
    }

    public function down()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropColumn('transaction_fee');
        });
    }
};

