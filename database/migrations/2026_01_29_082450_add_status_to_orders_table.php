<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_add_status_to_orders_table.php
    public function up()
    {
    Schema::table('orders', function (Blueprint $table) {
        $table->string('status')->default('desain')->after('payment_status');
    });
    }

    public function down()
    {
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('status');
    });
    }

};
