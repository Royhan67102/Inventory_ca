<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acrylic_wastes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('acrylic_stock_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('order_item_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('luas_sisa', 12, 2);
            $table->boolean('terpakai')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acrylic_wastes');
    }
};

