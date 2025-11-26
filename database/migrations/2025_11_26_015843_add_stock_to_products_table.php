<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        // Cek kolom yang ada, atau tambah di akhir
        if (Schema::hasColumn('products', 'description')) {
            $table->integer('stock')->default(0)->after('description');
        } else {
            $table->integer('stock')->default(0);
        }
    });
}

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};