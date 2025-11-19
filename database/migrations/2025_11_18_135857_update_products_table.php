<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek jika kolom belum ada, lalu tambahkan
        if (!Schema::hasColumn('products', 'min_stock')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('min_stock')->default(5)->after('stock');
            });
        }

        // Tambahkan kolom lain yang mungkin belum ada
        if (!Schema::hasColumn('products', 'sku')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('sku')->unique()->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        // Rollback changes jika diperlukan
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_stock', 'sku']);
        });
    }
};