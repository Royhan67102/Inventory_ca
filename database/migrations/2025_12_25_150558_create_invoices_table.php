<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('invoice_number')->unique();
            $table->date('tanggal_invoice');

            $table->enum('status_pembayaran', [
                'belum_bayar',
                'dp',
                'lunas'
            ])->default('belum_bayar');

            $table->decimal('total_harga', 15, 2);
            $table->decimal('dp', 15, 2)->default(0);
            $table->decimal('sisa_pembayaran', 15, 2);

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
