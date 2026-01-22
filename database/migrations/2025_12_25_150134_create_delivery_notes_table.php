<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('driver')->nullable();

            $table->date('tanggal')->nullable();
            $table->time('jam_berangkat')->nullable();
            $table->time('jam_sampai_tujuan')->nullable();
            $table->time('jam_kembali')->nullable();

            $table->string('bukti_foto')->nullable();

            $table->enum('status', [
                'menunggu',
                'dikirim',
                'selesai'
            ])->default('menunggu');

            $table->boolean('status_lock')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_notes');
    }
};
