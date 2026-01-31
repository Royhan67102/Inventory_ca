<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();

            // RELASI ORDER
            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // STATUS PICKUP
            $table->enum('status', ['menunggu', 'siap', 'diambil'])
                  ->default('menunggu');

            // FOTO / BUKTI PICKUP
            $table->string('bukti')->nullable();

            // CATATAN TAMBAHAN
            $table->text('catatan')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickups');
    }
};
