<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;   // driver MongoDB

class Product extends Model
{
    use HasFactory;

    /* nama collection di MongoDB Atlas */
    protected $collection = 'products';

    /* field yang boleh mass-assignment */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'price',
        'stock',
        'min_stock',
    ];

    /* cast tipe data */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
    ];

    /* accessor & mutator (tetap pakai $this->stock) */
    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->min_stock && $this->stock > 0;
    }

    public function getIsOutOfStockAttribute(): bool
    {
        return $this->stock <= 0;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->is_out_of_stock) return 'Out of Stock';
        if ($this->is_low_stock) return 'Low Stock';
        return 'In Stock';
    }

    public function getStockStatusClassAttribute(): string
    {
        if ($this->is_out_of_stock) {
            return 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
        }
        if ($this->is_low_stock) {
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
        }
        return 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
    }
}