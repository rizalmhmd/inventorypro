<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function inForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.in', compact('products'));
    }

    public function storeIn(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,_id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Use atomic increment to avoid race conditions with MongoDB
        $product = Product::findOrFail($data['product_id']);
        Product::where($product->getKeyName(), $product->getKey())->increment('stock', $data['quantity']);

        StockTransaction::create([
            'product_id' => $product->getKey(),
                'user_id' => auth()->id(),
                'type' => 'in',
                'quantity' => $data['quantity'],
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
        

        return back()->with('success','Stok masuk berhasil dicatat.');
    }

    public function outForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.out', compact('products'));
    }

    public function storeOut(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,_id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Use atomic decrement with conditional to avoid race conditions
        $product = Product::findOrFail($data['product_id']);
        $decremented = Product::where($product->getKeyName(), $product->getKey())
            ->where('stock', '>=', $data['quantity'])
            ->decrement('stock', $data['quantity']);

        if (!$decremented) {
            throw ValidationException::withMessages([
                'quantity' => 'Stok tidak cukup. Stok tersedia: ' . $product->stock . ' pcs'
            ]);
        }

        StockTransaction::create([
            'product_id' => $product->getKey(),
                'user_id' => auth()->id(),
                'type' => 'out',
                'quantity' => $data['quantity'],
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
        

        return back()->with('success','Stok keluar berhasil dicatat.');
    }
}