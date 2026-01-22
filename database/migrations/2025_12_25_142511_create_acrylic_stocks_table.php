<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acrylic_stocks', function (Blueprint $table) {
            $table->id();

            $table->string('kode_stok')->unique();
            $table->string('merk');
            $table->string('warna')->nullable();

            $table->enum('jenis', ['lembar', 'habis'])->default('lembar');

            $table->decimal('panjang', 10, 2);
            $table->decimal('lebar', 10, 2);
            $table->decimal('ketebalan', 5, 2);

            $table->decimal('luas_total', 12, 2);
            $table->decimal('luas_tersedia', 12, 2);

            $table->integer('jumlah_lembar')->default(1);

            $table->decimal('harga_lembar', 15, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acrylic_stocks');
    }
};
