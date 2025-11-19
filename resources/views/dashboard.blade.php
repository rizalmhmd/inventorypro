@extends('layout.app')

@section('title', 'Dashboard - InventoryPro')
@section('page-title', 'Dashboard')
@section('title-icon', 'fa-tachometer-alt')

@section('content')
<style>
    .dashboard-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
        padding: 1.75rem;
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .stat-icon {
        font-size: 2.25rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.9;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--light), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .stat-label {
        color: var(--gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Main Content Layout - IMPROVED RESPONSIVE */
    .main-content-area {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }

    .left-column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .right-column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .content-card {
        background: rgba(30, 35, 50, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        padding: 1.75rem;
        border: 1px solid var(--glass-border);
        transition: all 0.3s ease;
    }

    .content-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        color: var(--light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .section-title i {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.1rem;
    }

    /* Quick Actions - IMPROVED MOBILE */
    .quick-actions-container {
        min-height: 200px;
        display: flex;
        flex-direction: column;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        flex: 1;
    }

    .action-btn {
        padding: 1.5rem 1rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        color: var(--light);
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        height: 100%;
        min-height: 90px;
    }

    .action-btn:hover {
        background: rgba(139, 92, 246, 0.15);
        border-color: rgba(139, 92, 246, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.2);
    }

    .action-icon {
        font-size: 1.75rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .action-text {
        font-size: 0.85rem;
        font-weight: 500;
        text-align: center;
        line-height: 1.3;
    }

    /* Recent Products - IMPROVED MOBILE */
    .recent-products-container {
        flex: 1;
    }

    /* Table - IMPROVED MOBILE */
    .table-container {
        background: rgba(255, 255, 255, 0.04);
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
        min-width: 600px;
    }

    .table th {
        background: rgba(255, 255, 255, 0.06);
        padding: 1rem 1.25rem;
        text-align: left;
        color: var(--gray);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--glass-border);
    }

    .table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--light);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    /* Status Badges */
    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        border: 1px solid;
        white-space: nowrap;
    }

    .status-in-stock {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
        border-color: rgba(34, 197, 94, 0.3);
    }

    .status-low-stock {
        background: rgba(245, 158, 11, 0.15);
        color: #fcd34d;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .status-out-of-stock {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* Stock Summary - IMPROVED MOBILE */
    .stock-summary-container {
        min-height: 200px;
        display: flex;
        flex-direction: column;
    }

    .summary-stats {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex: 1;
    }

    .summary-stat {
        background: rgba(255, 255, 255, 0.04);
        padding: 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid var(--glass-border);
        text-align: center;
        transition: all 0.3s ease;
        flex: 1;
    }

    .summary-stat:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: translateY(-1px);
    }

    .summary-value {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--light), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .summary-label {
        color: var(--gray);
        font-size: 0.85rem;
        font-weight: 500;
        line-height: 1.3;
    }

    /* Stock Alerts - IMPROVED MOBILE */
    .stock-alerts-container {
        flex: 1;
    }

    /* Alert Cards */
    .alert-card {
        padding: 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .alert-card:hover {
        transform: translateY(-1px);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.08);
        border-color: rgba(239, 68, 68, 0.25);
    }

    .alert-warning {
        background: rgba(245, 158, 11, 0.08);
        border-color: rgba(245, 158, 11, 0.25);
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.08);
        border-color: rgba(34, 197, 94, 0.25);
    }

    .alert-icon {
        font-size: 1.25rem;
        margin-right: 0.5rem;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .alert-content {
        flex: 1;
        min-width: 0;
    }

    .alert-content strong {
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .alert-content p {
        margin: 0;
        font-size: 0.8rem;
        opacity: 0.9;
        line-height: 1.4;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .empty-state a {
        color: var(--primary-light);
        text-decoration: none;
        font-weight: 500;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }

    /* RESPONSIVE DESIGN - IMPROVED */
    @media (max-width: 1200px) {
        .main-content-area {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        
        .right-column {
            grid-template-columns: repeat(2, 1fr);
            display: grid;
        }
        
        .stock-summary-container,
        .stock-alerts-container {
            min-height: auto;
        }
    }

    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .stat-card {
            padding: 1.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .action-btn {
            padding: 1.25rem 1rem;
            min-height: 80px;
            flex-direction: row;
            justify-content: flex-start;
            text-align: left;
        }
        
        .action-icon {
            font-size: 1.5rem;
            margin-right: 0.75rem;
        }
        
        .action-text {
            font-size: 0.9rem;
        }
        
        .right-column {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .table {
            font-size: 0.8rem;
            min-width: 500px;
        }
        
        .table th, .table td {
            padding: 0.75rem 1rem;
        }
        
        .content-card {
            padding: 1.25rem;
            border-radius: 0.75rem;
        }
        
        .summary-stats {
            flex-direction: row;
            gap: 0.75rem;
        }
        
        .summary-stat {
            padding: 1rem;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .summary-value {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }
        
        .summary-label {
            font-size: 0.8rem;
        }
        
        .section-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
        }
        
        .alert-card {
            padding: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .alert-content strong {
            font-size: 0.85rem;
        }
        
        .alert-content p {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 640px) {
        .summary-stats {
            flex-direction: column;
        }
        
        .summary-stat {
            min-height: 70px;
        }
        
        .table-container {
            border-radius: 0.5rem;
            margin: 0 -1rem;
            width: calc(100% + 2rem);
        }
    }

    @media (max-width: 480px) {
        .content-card {
            padding: 1rem;
            margin: 0 -0.5rem;
            width: calc(100% + 1rem);
            border-radius: 0.75rem;
        }
        
        .stat-card {
            padding: 1.25rem;
            margin: 0;
        }
        
        .stat-value {
            font-size: 1.75rem;
        }
        
        .stat-icon {
            font-size: 2rem;
        }
        
        .action-btn {
            padding: 1rem 0.75rem;
            min-height: 70px;
        }
        
        .action-icon {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }
        
        .action-text {
            font-size: 0.8rem;
        }
        
        .table {
            min-width: 450px;
            font-size: 0.75rem;
        }
        
        .table th, .table td {
            padding: 0.5rem 0.75rem;
        }
        
        .status-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        .empty-state {
            padding: 1.5rem 1rem;
        }
        
        .empty-state i {
            font-size: 2rem;
        }
    }

    @media (max-width: 360px) {
        .quick-actions {
            gap: 0.5rem;
        }
        
        .action-btn {
            padding: 0.875rem 0.5rem;
            min-height: 65px;
        }
        
        .action-icon {
            font-size: 1.1rem;
            margin-right: 0.4rem;
        }
        
        .action-text {
            font-size: 0.75rem;
        }
        
        .content-card {
            padding: 0.875rem;
        }
    }

    /* Mobile First Improvements */
    .mobile-optimized {
        -webkit-overflow-scrolling: touch;
    }

    .table-container {
        -webkit-overflow-scrolling: touch;
    }

    /* Touch improvements for mobile */
    @media (hover: none) {
        .stat-card:hover,
        .action-btn:hover,
        .summary-stat:hover,
        .alert-card:hover {
            transform: none;
        }
        
        .action-btn:active {
            background: rgba(139, 92, 246, 0.15);
            transform: scale(0.98);
        }
    }
</style>

<div class="dashboard-content">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-boxes"></i></div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-label">Total Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-value">{{ $lowStockItems }}</div>
            <div class="stat-label">Low Stock Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-value">Rp{{ number_format($totalValue, 0, ',', '.') }}</div>
            <div class="stat-label">Total Inventory Value</div>
        </div>
    </div>

    <!-- Main Content Area - IMPROVED RESPONSIVE LAYOUT -->
    <div class="main-content-area">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Quick Actions - Mobile Optimized -->
            <div class="content-card quick-actions-container">
                <h2 class="section-title"><i class="fas fa-rocket"></i> Quick Actions</h2>
                <div class="quick-actions">
                    <a href="{{ route('products.create') }}" class="action-btn">
                        <i class="fas fa-plus action-icon"></i>
                        <span class="action-text">Add Product</span>
                    </a>
                    <a href="{{ route('stock.in.form') }}" class="action-btn">
                        <i class="fas fa-arrow-down action-icon"></i>
                        <span class="action-text">Stock In</span>
                    </a>
                    <a href="{{ route('stock.out.form') }}" class="action-btn">
                        <i class="fas fa-arrow-up action-icon"></i>
                        <span class="action-text">Stock Out</span>
                    </a>
                    <a href="{{ route('reports.index') }}" class="action-btn">
                        <i class="fas fa-chart-bar action-icon"></i>
                        <span class="action-text">View Reports</span>
                    </a>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="content-card recent-products-container">
                <h2 class="section-title"><i class="fas fa-clock"></i> Produk Terbaru</h2>
                @if($recentProducts->count() > 0)
                <div class="table-container mobile-optimized">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>SKU</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProducts as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td><code>{{ $product->sku ?? 'T/A' }}</code></td>
                                <td>{{ $product->stock }} pcs</td>
                                <td><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($product->stock == 0)
                                        <span class="status-badge status-out-of-stock">Stok Habis</span>
                                    @elseif($product->stock <= 5)
                                        <span class="status-badge status-low-stock">Stok Menipis</span>
                                    @else
                                        <span class="status-badge status-in-stock">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p>Belum ada produk. <a href="{{ route('products.create') }}">Tambah produk pertama</a></p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Stock Summary - Mobile Optimized -->
            <div class="content-card stock-summary-container">
                <h2 class="section-title"><i class="fas fa-chart-pie"></i> Stock Summary</h2>
                <div class="summary-stats">
                    <div class="summary-stat">
                        <div class="summary-value">{{ $outOfStockItems }}</div>
                        <div class="summary-label">Out of Stock Items</div>
                    </div>
                    <div class="summary-stat">
                        <div class="summary-value">{{ $lowStockItems }}</div>
                        <div class="summary-label">Low Stock Items</div>
                    </div>
                </div>
            </div>

            <!-- Stock Alerts - Mobile Optimized -->
            <div class="content-card stock-alerts-container">
                <h2 class="section-title"><i class="fas fa-bell"></i> Stock Alerts</h2>
                @if($outOfStockItems > 0)
                <div class="alert-card alert-danger">
                    <div style="display: flex; align-items: flex-start;">
                        <i class="fas fa-exclamation-circle alert-icon"></i> 
                        <div class="alert-content">
                            <strong>{{ $outOfStockItems }} products are out of stock</strong>
                            <p>Restock these items immediately</p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($lowStockItems > 0)
                <div class="alert-card alert-warning">
                    <div style="display: flex; align-items: flex-start;">
                        <i class="fas fa-exclamation-triangle alert-icon"></i> 
                        <div class="alert-content">
                            <strong>{{ $lowStockItems }} products are running low</strong>
                            <p>Consider restocking soon</p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($outOfStockItems == 0 && $lowStockItems == 0)
                <div class="alert-card alert-success">
                    <div style="display: flex; align-items: flex-start;">
                        <i class="fas fa-check-circle alert-icon"></i> 
                        <div class="alert-content">
                            <strong>All products are well stocked</strong>
                            <p>Great inventory management!</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection