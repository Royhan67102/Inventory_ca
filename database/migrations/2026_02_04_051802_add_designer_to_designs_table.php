<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'status')) {
            $table->string('status')->default('desain')->after('payment_status');
        }
    });
    }

    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('designer');
        });
    }
};
