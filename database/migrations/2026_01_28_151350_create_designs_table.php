<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // ================= STATUS DESAIN =================
            $table->enum('status', [
                'menunggu',
                'proses',
                'selesai'
            ])->default('menunggu');

            $table->text('catatan')->nullable();

            // ================= FILE =================
            // file dari order (auto copy)
            $table->string('file_awal')->nullable();

            // hasil desain tim
            $table->string('file_hasil')->nullable();

            // optional: siapa desainer
            $table->string('designer')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
