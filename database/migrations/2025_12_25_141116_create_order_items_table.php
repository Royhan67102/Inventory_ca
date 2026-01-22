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

            $table->string('product_name');

            // TIPE ITEM
            $table->enum('tipe_item', [
                'custom',
                'lembaran'
            ]);

            $table->integer('qty')->default(1);

            // CUSTOM
            $table->decimal('panjang_cm', 8, 2)->nullable();
            $table->decimal('lebar_cm', 8, 2)->nullable();
            $table->decimal('luas_cm2', 12, 2)->nullable();
            $table->decimal('harga_per_cm', 12, 2)->nullable();

            // LEMBARAN
            $table->decimal('harga_satuan', 15, 2)->nullable();

            $table->decimal('subtotal', 15, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
