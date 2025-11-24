<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;   // driver MongoDB

class StockTransaction extends Model
{
    use HasFactory;

    /* nama collection di MongoDB Atlas */
    protected $collection = 'stock_transactions';

    /* field yang boleh mass-assignment */
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'reference',
        'notes',
    ];

    /* relasi ke Product (MongoDB) */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', '_id');
    }

    /* relasi ke User (MongoDB) */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}