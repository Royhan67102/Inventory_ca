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

            // ================= PEMBAYARAN =================
            $table->enum('payment_status', [
                'belum_bayar',
                'dp',
                'lunas'
            ])->default('belum_bayar');

            // ================= STATUS ORDER =================
            $table->enum('status', [
                'desain',
                'produksi',
                'delivery',
                'pickup',
                'selesai'
            ])->default('desain');

            // ================= TOTAL =================
            $table->decimal('total_harga', 15, 2)->default(0);

            // ================= JASA TAMBAHAN =================
            $table->boolean('antar_barang')->default(false);
            $table->decimal('biaya_pengiriman', 15, 2)->default(0);

            $table->boolean('jasa_pemasangan')->default(false);
            $table->decimal('biaya_pemasangan', 15, 2)->default(0);

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
