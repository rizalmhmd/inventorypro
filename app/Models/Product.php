<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku', 
        'description',
        'category',
        'price',    // Sesuai dengan database: price
        'stock',    // Sesuai dengan database: stock
        'min_stock'
    ];

    protected $casts = [
        'price' => 'decimal:2', // Sesuai dengan database: price
    ];

    /**
     * Check if product is low stock
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->min_stock && $this->stock > 0; // Gunakan $this->stock
    }

    /**
     * Check if product is out of stock
     */
    public function getIsOutOfStockAttribute(): bool
    {
        return $this->stock <= 0; // Gunakan $this->stock
    }

    /**
     * Get stock status
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->is_out_of_stock) {
            return 'Out of Stock';
        }

        if ($this->is_low_stock) {
            return 'Low Stock';
        }

        return 'In Stock';
    }

    /**
     * Get stock status class for UI
     */
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