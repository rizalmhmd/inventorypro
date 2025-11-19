<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('category')->default('Uncategorized');
            $table->decimal('unit_price', 10, 2)->default(0); // Ubah dari 'price' menjadi 'unit_price'
            $table->integer('quantity')->default(0); // Ubah dari 'stock' menjadi 'quantity'
            $table->integer('min_stock')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};