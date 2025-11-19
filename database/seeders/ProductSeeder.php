<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['sku' => 'P001','name'=>'Buku Tulis','description'=>'Buku tulis A5','quantity'=>100,'unit_price'=>15000],
            ['sku' => 'P002','name'=>'Pulpen','description'=>'Pulpen biru','quantity'=>200,'unit_price'=>2000],
            ['sku' => 'P003','name'=>'Penghapus','description'=>'Penghapus karet','quantity'=>150,'unit_price'=>1000],
        ];

        foreach ($items as $it) {
            Product::create($it);
        }
    }
}
