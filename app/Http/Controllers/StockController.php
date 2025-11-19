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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function() use ($data) {
            $product = Product::findOrFail($data['product_id']);
            
            // Update stock (bukan quantity)
            $product->stock += $data['quantity'];
            $product->save();

            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'in',
                'quantity' => $data['quantity'],
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
        });

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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function() use ($data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);
            
            // Validasi stok (bukan quantity)
            if ($product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok tidak cukup. Stok tersedia: ' . $product->stock . ' pcs'
                ]);
            }
            
            // Update stock (bukan quantity)
            $product->stock -= $data['quantity'];
            $product->save();

            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'out',
                'quantity' => $data['quantity'],
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
        });

        return back()->with('success','Stok keluar berhasil dicatat.');
    }
}