<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('stock_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        // Pastikan tipe data sama dengan products.id
        $table->integer('quantity');
        $table->string('type'); // in/out
        $table->text('notes')->nullable();
        $table->timestamps();
        
        // Pastikan menggunakan InnoDB
        $table->engine = 'InnoDB';
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
