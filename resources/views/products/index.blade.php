@extends('layout.app')

@section('title', 'Daftar Produk - Inventory System')
@section('page-title', 'Manajemen Produk')
@section('title-icon', 'fa-boxes')

@section('content')
<style>
    .products-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Success Alert */
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
        font-size: 0.9rem;
    }

    /* Header Card */
    .header-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--card-border);
        margin-bottom: 1.5rem;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        line-height: 1.4;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .stat-card {
        background: var(--card-bg);
        padding: 1.25rem;
        border-radius: 0.75rem;
        backdrop-filter: blur(10px);
        border: 1px solid var(--card-border);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-blue), var(--accent-cyan));
    }

    .stat-icon {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: var(--text-primary);
        line-height: 1;
        font-family: 'JetBrains Mono', 'Inter', monospace;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Main Content Card */
    .content-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--card-border);
        margin-bottom: 1.5rem;
    }

    /* Search and Filters */
    .search-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .search-box {
        position: relative;
        width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 0.875rem 0.875rem 0.875rem 2.75rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--card-border);
        border-radius: 0.75rem;
        color: var(--text-primary);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.15);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .filter-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        width: 100%;
    }

    .filter-row {
        display: flex;
        gap: 0.75rem;
        width: 100%;
    }

    .filter-select {
        padding: 0.875rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--card-border);
        border-radius: 0.75rem;
        color: var(--text-primary);
        font-size: 0.85rem;
        backdrop-filter: blur(10px);
        flex: 1;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-blue);
    }

    /* Mobile Table Container */
    .mobile-table-container {
        display: none;
    }

    .desktop-table-container {
        display: block;
    }

    /* Desktop Table Styles */
    .desktop-table-container {
        background: rgba(255, 255, 255, 0.04);
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid var(--card-border);
        margin-bottom: 1.5rem;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        min-width: 800px;
    }

    .table th {
        background: rgba(255, 255, 255, 0.06);
        padding: 1rem 1.25rem;
        text-align: left;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--card-border);
    }

    .table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    /* Mobile Card Styles */
    .mobile-product-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--card-border);
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .mobile-product-card:hover {
        background: rgba(255, 255, 255, 0.06);
    }

    .mobile-card-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .mobile-product-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .mobile-product-icon i {
        color: white;
        font-size: 1rem;
    }

    .mobile-product-info {
        flex: 1;
        min-width: 0;
    }

    .mobile-product-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    .mobile-product-sku {
        color: var(--text-secondary);
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }

    .mobile-product-category {
        color: var(--primary-blue);
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .mobile-card-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .mobile-detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .mobile-detail-label {
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-weight: 500;
    }

    .mobile-detail-value {
        color: var(--text-primary);
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.4rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border: 1px solid;
        white-space: nowrap;
    }

    .status-available {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .status-low {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .status-out {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.6rem 1rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        font-family: inherit;
        white-space: nowrap;
        flex: 1;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .btn-sm {
        padding: 0.5rem 0.8rem;
        font-size: 0.75rem;
    }

    .btn-info {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-info:hover {
        background: rgba(59, 130, 246, 0.25);
        transform: translateY(-1px);
    }

    .btn-edit {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-edit:hover {
        background: rgba(59, 130, 246, 0.25);
        transform: translateY(-1px);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.25);
        transform: translateY(-1px);
    }

    .btn-locked {
        background: rgba(100, 116, 139, 0.15);
        color: #64748b;
        border: 1px solid rgba(100, 116, 139, 0.3);
        cursor: not-allowed;
    }

    /* Primary Action Button */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
        color: white;
        padding: 0.875rem 1.25rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
        white-space: nowrap;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 102, 255, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
    }

    .empty-state p {
        margin-bottom: 1.5rem;
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* Table Footer */
    .table-footer {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;
        padding: 1.5rem 0;
        border-top: 1px solid var(--card-border);
    }

    .pagination-info {
        color: var(--text-secondary);
        font-size: 0.85rem;
        text-align: center;
    }

    .pagination-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-btn {
        padding: 0.6rem 0.875rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--card-border);
        border-radius: 0.75rem;
        color: var(--text-primary);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        white-space: nowrap;
        backdrop-filter: blur(10px);
    }

    .pagination-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
        color: white;
        border-color: var(--primary-blue);
    }

    /* RESPONSIVE DESIGN */
    @media (min-width: 768px) {
        .header-card {
            padding: 2rem;
        }

        .header-title {
            font-size: 1.75rem;
        }

        .header-subtitle {
            font-size: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
            text-align: left;
        }

        .stat-icon {
            font-size: 1.75rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        .content-card {
            padding: 2rem;
        }

        .search-container {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }

        .search-box {
            max-width: 400px;
            flex: none;
        }

        .filter-container {
            flex-direction: row;
            width: auto;
            gap: 1rem;
        }

        .filter-row {
            flex-direction: row;
        }

        .filter-select {
            min-width: 150px;
            flex: none;
        }

        .mobile-table-container {
            display: none !important;
        }

        .desktop-table-container {
            display: block;
        }

        .action-buttons {
            flex-direction: row;
            flex-wrap: nowrap;
        }

        .btn {
            flex: none;
        }

        .table-footer {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-info {
            text-align: left;
        }
    }

    @media (min-width: 640px) and (max-width: 767px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-row {
            flex-direction: row;
        }

        .mobile-card-details {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 639px) {
        .mobile-table-container {
            display: block;
        }

        .desktop-table-container {
            display: none;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-row {
            flex-direction: column;
        }

        .mobile-card-details {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .header-card {
            padding: 1.25rem;
        }

        .content-card {
            padding: 1.25rem;
        }

        .header-title {
            font-size: 1.25rem;
            gap: 0.5rem;
        }

        .header-subtitle {
            font-size: 0.85rem;
        }

        .stats-grid {
            gap: 0.5rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-icon {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.2rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        .mobile-product-card {
            padding: 1rem;
        }

        .mobile-card-header {
            gap: 0.75rem;
        }

        .mobile-product-icon {
            width: 40px;
            height: 40px;
        }

        .mobile-product-name {
            font-size: 0.9rem;
        }
    }

    /* Touch improvements for mobile */
    @media (hover: none) {
        .stat-card:hover,
        .btn:hover,
        .pagination-btn:hover,
        .mobile-product-card:hover {
            transform: none;
        }

        .btn:active {
            transform: scale(0.98);
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="products-content">
    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert-success animate-fade-in">
        <div style="display: flex; align-items: center;">
            <i class="fas fa-check-circle" style="margin-right: 0.75rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Header Section -->
    <div class="header-card animate-fade-in">
        <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1rem;">
            <div style="flex: 1;">
                <h1 class="header-title">
                    <i class="fas fa-boxes"></i>
                    Daftar Produk
                </h1>
                <p class="header-subtitle">
                    Kelola dan pantau inventori produk Anda secara real-time. 
                    <strong style="color: var(--primary-blue);">Setiap produk baru otomatis memiliki stok!</strong>
                </p>
            </div>
            
            @if(auth()->user()?->role === 'admin')
            <a href="{{ route('products.create') }}" class="btn-primary animate-fade-in">
                <i class="fas fa-plus-circle"></i>
                Tambah Produk
            </a>
            @endif
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-boxes-stacked"></i></div>
                <div class="stat-value">{{ $products->count() }}</div>
                <div class="stat-label">Total Produk</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                <div class="stat-value">{{ $products->where('stock', '>', 0)->count() }}</div>
                <div class="stat-label">Stok Tersedia</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="stat-value">{{ $products->where('stock', '<', 10)->where('stock', '>', 0)->count() }}</div>
                <div class="stat-label">Stok Menipis</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-times-hexagon"></i></div>
                <div class="stat-value">{{ $products->where('stock', 0)->count() }}</div>
                <div class="stat-label">Stok Habis</div>
            </div>
        </div>
    </div>

    <!-- Products Table Section -->
    <div class="content-card animate-fade-in">
        <!-- Search and Filters -->
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" 
                       id="searchInput"
                       class="search-input" 
                       placeholder="Cari produk...">
            </div>
            
            <div class="filter-container">
                <div class="filter-row">
                    <select class="filter-select" id="categoryFilter">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    
                    <select class="filter-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="available">Stok Tersedia</option>
                        <option value="low">Stok Menipis</option>
                        <option value="out">Stok Habis</option>
                    </select>
                </div>
                <button class="btn" id="resetFilters" style="background: rgba(255, 255, 255, 0.06); border: 1px solid var(--card-border);">
                    <i class="fas fa-refresh"></i>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="desktop-table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr class="animate-fade-in product-row" 
                        data-status="@if($p->stock == 0)out @elseif($p->stock < $p->min_stock)low @else available @endif"
                        data-category="{{ $p->category }}"
                        data-search="{{ strtolower($p->name . ' ' . ($p->sku ?? '') . ' ' . ($p->description ?? '')) }}">
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple)); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-box" style="color: white; font-size: 0.875rem;"></i>
                                </div>
                                <div style="min-width: 0; flex: 1;">
                                    <div style="font-weight: 600; color: var(--text-primary);" class="line-clamp-1">{{ $p->name }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;" class="line-clamp-1">
                                        {{ $p->sku ?? 'No SKU' }}
                                    </div>
                                    <div style="color: var(--primary-blue); font-size: 0.75rem; margin-top: 0.25rem;">
                                        <i class="fas fa-tag"></i> {{ $p->category }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($p->stock == 0)
                                <span class="status-badge status-out">
                                    <i class="fas fa-times-circle"></i>
                                    Habis
                                </span>
                            @elseif($p->stock < $p->min_stock)
                                <span class="status-badge status-low">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $p->stock }} pcs
                                </span>
                            @else
                                <span class="status-badge status-available">
                                    <i class="fas fa-check-circle"></i>
                                    {{ $p->stock }} pcs
                                </span>
                            @endif
                        </td>
                        <td style="font-weight: 700;">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if(auth()->user()?->role === 'admin')
                            <div class="action-buttons">
                                <a href="{{ route('products.show', $p) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $p) }}" class="btn btn-edit btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $p) }}" method="POST" style="display: inline;">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->name }}?')"
                                            class="btn btn-delete btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="action-buttons">
                                <a href="{{ route('products.show', $p) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <span class="btn btn-locked btn-sm">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h3>Belum ada produk</h3>
                                <p>Mulai bangun inventori Anda dengan menambahkan produk pertama</p>
                                @if(auth()->user()?->role === 'admin')
                                <a href="{{ route('products.create') }}" class="btn-primary">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah Produk Pertama
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="mobile-table-container">
            @forelse($products as $p)
            <div class="mobile-product-card animate-fade-in product-row" 
                 data-status="@if($p->stock == 0)out @elseif($p->stock < $p->min_stock)low @else available @endif"
                 data-category="{{ $p->category }}"
                 data-search="{{ strtolower($p->name . ' ' . ($p->sku ?? '') . ' ' . ($p->description ?? '')) }}">
                <div class="mobile-card-header">
                    <div class="mobile-product-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="mobile-product-info">
                        <div class="mobile-product-name line-clamp-2">{{ $p->name }}</div>
                        <div class="mobile-product-sku">{{ $p->sku ?? 'No SKU' }}</div>
                        <div class="mobile-product-category">
                            <i class="fas fa-tag"></i> {{ $p->category }}
                        </div>
                    </div>
                </div>
                
                <div class="mobile-card-details">
                    <div class="mobile-detail-item">
                        <span class="mobile-detail-label">Stok</span>
                        @if($p->stock == 0)
                            <span class="status-badge status-out" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">
                                <i class="fas fa-times-circle"></i>
                                Habis
                            </span>
                        @elseif($p->stock < $p->min_stock)
                            <span class="status-badge status-low" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $p->stock }} pcs
                            </span>
                        @else
                            <span class="status-badge status-available" style="font-size: 0.7rem; padding: 0.3rem 0.6rem;">
                                <i class="fas fa-check-circle"></i>
                                {{ $p->stock }} pcs
                            </span>
                        @endif
                    </div>
                    
                    <div class="mobile-detail-item">
                        <span class="mobile-detail-label">Harga</span>
                        <span class="mobile-detail-value">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('products.show', $p) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                        Detail
                    </a>
                    @if(auth()->user()?->role === 'admin')
                    <a href="{{ route('products.edit', $p) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $p) }}" method="POST" style="display: inline; flex: 1;">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $p->name }}?')"
                                class="btn btn-delete" style="width: 100%;">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                    @else
                    <span class="btn btn-locked">
                        <i class="fas fa-lock"></i>
                        Terkunci
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum ada produk</h3>
                <p>Mulai bangun inventori Anda dengan menambahkan produk pertama</p>
                @if(auth()->user()?->role === 'admin')
                <a href="{{ route('products.create') }}" class="btn-primary">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Produk Pertama
                </a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Table Footer -->
        <div class="table-footer">
            <div class="pagination-info">
                <span style="font-weight: 600; color: var(--text-primary);" id="visibleCount">{{ $products->count() }}</span> produk ditampilkan
            </div>
            <div class="pagination-buttons">
                <a href="#" class="pagination-btn">
                    <i class="fas fa-chevron-left"></i>
                    Sebelumnya
                </a>
                <a href="#" class="pagination-btn active">1</a>
                <a href="#" class="pagination-btn">
                    Selanjutnya
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetFilters = document.getElementById('resetFilters');
        const tableRows = document.querySelectorAll('.product-row');
        const visibleCount = document.getElementById('visibleCount');
        
        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const categoryValue = categoryFilter.value;
            const statusValue = statusFilter.value;
            
            let count = 0;
            
            tableRows.forEach(row => {
                const searchData = row.getAttribute('data-search') || row.textContent.toLowerCase();
                const rowCategory = row.getAttribute('data-category');
                const rowStatus = row.getAttribute('data-status');
                
                const matchesSearch = searchData.includes(searchTerm);
                const matchesCategory = !categoryValue || rowCategory === categoryValue;
                const matchesStatus = !statusValue || rowStatus === statusValue;
                
                if (matchesSearch && matchesCategory && matchesStatus) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            visibleCount.textContent = count;
        }
        
        // Search functionality
        if (searchInput) {
            searchInput.addEventListener('input', filterProducts);
        }
        
        // Category filter functionality
        if (categoryFilter) {
            categoryFilter.addEventListener('change', filterProducts);
        }
        
        // Status filter functionality
        if (statusFilter) {
            statusFilter.addEventListener('change', filterProducts);
        }
        
        // Reset filters
        if (resetFilters) {
            resetFilters.addEventListener('click', function() {
                searchInput.value = '';
                categoryFilter.value = '';
                statusFilter.value = '';
                filterProducts();
            });
        }

        // Add staggered animation to table rows
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
        
        // Initial filter count
        filterProducts();
    });
</script>
@endsection