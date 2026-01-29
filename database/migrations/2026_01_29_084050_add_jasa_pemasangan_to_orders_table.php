<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->boolean('jasa_pemasangan')->default(false)->after('antar_barang');
        $table->decimal('biaya_pemasangan', 15, 2)->default(0)->after('jasa_pemasangan');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['jasa_pemasangan', 'biaya_pemasangan']);
    });
}
};
