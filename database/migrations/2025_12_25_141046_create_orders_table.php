<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('invoice_number')->unique();

            $table->date('tanggal_pemesanan');
            $table->date('deadline')->nullable();

            $table->enum('payment_status', [
                'belum_bayar',
                'dp',
                'lunas'
            ])->default('belum_bayar');

            $table->enum('status_produksi', [
                'menunggu',
                'proses',
                'selesai'
            ])->default('menunggu');

            $table->decimal('total_harga', 15, 2)->default(0);

            $table->boolean('antar_barang')->default(false);
            $table->decimal('biaya_pengiriman', 15, 2)->default(0);

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
