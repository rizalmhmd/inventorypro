<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // Middleware auth sudah diterapkan di routes, jadi tidak perlu di sini
    }

    public function index()
    {
        $products = Product::orderBy('name')->get();
        
        // Get unique categories from products
        $categories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'sku' => 'nullable|string|unique:products,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        // Set default values jika tidak diisi
        $data['stock'] = $data['stock'] ?? 0;
        $data['category'] = $data['category'] ?? 'Uncategorized';
        $data['min_stock'] = $data['min_stock'] ?? 5;

        Product::create($data);
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan dengan stok otomatis.');
    }

    public function edit(Product $product)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        // Set default values
        $data['category'] = $data['category'] ?? 'Uncategorized';
        $data['min_stock'] = $data['min_stock'] ?? 5;

        $product->update($data);
        
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}