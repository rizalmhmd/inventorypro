<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller // PASTIKAN EXTEND Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $productId = $request->input('product_id');

        $query = StockTransaction::with('product','user')->orderBy('created_at','desc');
        
        // Filter by date
        if ($from) $query->whereDate('created_at','>=',$from);
        if ($to) $query->whereDate('created_at','<=',$to);
        
        // Filter by product
        if ($productId) {
            $query->where('product_id', $productId);
        }

        $transactions = $query->paginate(30);
        $products = Product::orderBy('name')->get();

        return view('reports.index', compact('transactions','products'));
    }
}