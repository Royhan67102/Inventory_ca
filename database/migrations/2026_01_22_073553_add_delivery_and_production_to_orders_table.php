<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // STATUS PRODUKSI (RINGKAS DI ORDER)
            $table->enum('status_produksi', [
                'menunggu',
                'proses',
                'selesai'
            ])->default('menunggu')
              ->after('payment_status');

            // DELIVERY
            $table->boolean('antar_barang')
                  ->default(false)
                  ->after('status_produksi');

            $table->decimal('biaya_pengiriman', 15, 2)
                  ->default(0)
                  ->after('antar_barang');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'status_produksi',
                'antar_barang',
                'biaya_pengiriman'
            ]);
        });
    }
};
