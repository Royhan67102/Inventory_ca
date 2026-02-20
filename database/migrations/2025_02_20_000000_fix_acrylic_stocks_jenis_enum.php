<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the jenis column to use 'sisa' instead of 'habis'
        Schema::table('acrylic_stocks', function (Blueprint $table) {
            // For MySQL, drop and recreate the enum column
            DB::statement("ALTER TABLE acrylic_stocks MODIFY jenis ENUM('lembar', 'sisa') DEFAULT 'lembar'");
        });
    }

    public function down(): void
    {
        Schema::table('acrylic_stocks', function (Blueprint $table) {
            // Revert back to original enum values if needed
            DB::statement("ALTER TABLE acrylic_stocks MODIFY jenis ENUM('lembar', 'habis') DEFAULT 'lembar'");
        });
    }
};
