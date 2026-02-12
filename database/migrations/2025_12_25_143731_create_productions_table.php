<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // ================= TIM =================
            $table->string('tim_produksi')->nullable();

            // ================= STATUS PRODUKSI =================
            $table->enum('status', [
                'menunggu',
                'proses',
                'selesai'
            ])->default('menunggu');

            // ================= WAKTU =================
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();

            // ================= BUKTI =================
            $table->string('bukti')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};

