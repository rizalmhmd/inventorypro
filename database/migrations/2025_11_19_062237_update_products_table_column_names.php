<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Ubah nama kolom jika diperlukan
            $table->renameColumn('price', 'unit_price');
            $table->renameColumn('stock', 'quantity');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('unit_price', 'price');
            $table->renameColumn('quantity', 'stock');
        });
    }
};