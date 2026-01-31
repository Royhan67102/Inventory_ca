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

            // ================= RELASI =================
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // ================= DRIVER =================
            $table->string('nama_pengirim')->nullable(); // sesuai model DeliveryNote
            $table->string('driver')->nullable();

            // ================= WAKTU =================
            $table->date('tanggal_kirim')->nullable();
            $table->time('jam_berangkat')->nullable();
            $table->time('jam_sampai_tujuan')->nullable();
            $table->time('jam_kembali')->nullable();

            // ================= BUKTI =================
            $table->string('ttd_admin')->nullable();
            $table->string('ttd_penerima')->nullable();
            $table->string('bukti_foto')->nullable();

            // ================= STATUS =================
            $table->enum('status', [
                'menunggu',
                'berangkat',
                'sampai',
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
