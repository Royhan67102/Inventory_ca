<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // INFO PRODUK (SESUAI FORM)
            $table->string('merk')->nullable();
            $table->string('ketebalan')->nullable();
            $table->string('warna')->nullable();

            // UKURAN
            $table->decimal('panjang_cm', 8, 2)->nullable();
            $table->decimal('lebar_cm', 8, 2)->nullable();
            $table->decimal('luas_cm2', 12, 2)->nullable();

            // TRANSAKSI
            $table->integer('qty')->default(1);
            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
