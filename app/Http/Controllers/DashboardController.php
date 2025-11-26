<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with inventory statistics.
     */
    public function index(): View
    {
        // Get real data from database
        $totalProducts = Product::count();
        $totalUsers = User::count(); // Add this line
        $lowStockItems = Product::where('stock', '<=', 5)->where('stock', '>', 0)->count();
        $outOfStockItems = Product::where('stock', '<=', 0)->count();
        
        // Calculate total inventory value
        $totalValue = Product::sum(DB::raw('price * stock'));
        
        // Get recent products
        $recentProducts = Product::latest()->take(5)->get();
        
        // Get stock alerts (low stock items)
        $stockAlerts = Product::where('stock', '<=', 5)->get();

        // Prepare stock summary
        $stockSummary = [
            'total_value' => $totalValue,
            'out_of_stock' => $outOfStockItems,
            'low_stock' => $lowStockItems,
        ];

        return view('dashboard', compact(
            'totalProducts',
            'totalUsers', // Add this
            'lowStockItems', 
            'outOfStockItems',
            'totalValue',
            'recentProducts',
            'stockAlerts',
            'stockSummary' // Add this
        ));
    }
}