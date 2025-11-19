@extends('layout.app')

@section('title', 'Laporan Stok - InventoryPro')
@section('page-title', 'Laporan Stok')
@section('title-icon', 'fa-chart-line')

@section('content')
<style>
    .reports-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Header Card */
    .header-card {
        background: rgba(30, 35, 50, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        padding: 2.5rem;
        border: 1px solid var(--glass-border);
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .header-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-subtitle {
        color: var(--gray);
        font-size: 1.1rem;
    }

    /* Filter Card */
    .filter-card {
        background: rgba(30, 35, 50, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        padding: 2rem;
        border: 1px solid var(--glass-border);
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    /* Form Elements */
    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--light);
        font-size: 0.9rem;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        color: var(--light);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-family: inherit;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
    }

    .btn-secondary {
        background: var(--glass);
        color: var(--light);
        border: 1px solid var(--glass-border);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
    }

    /* Table Styles */
    .table-container {
        background: rgba(255, 255, 255, 0.04);
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid var(--glass-border);
        margin-bottom: 2rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    .table th {
        background: rgba(255, 255, 255, 0.06);
        padding: 1.25rem 1.5rem;
        text-align: left;
        color: var(--gray);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--glass-border);
    }

    .table td {
        padding: 1.25rem 1.5rem;
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
        padding: 0.4rem 0.8rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border: 1px solid;
    }

    .status-in {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
        border-color: rgba(34, 197, 94, 0.3);
    }

    .status-out {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .status-adjust {
        background: rgba(245, 158, 11, 0.15);
        color: #fcd34d;
        border-color: rgba(245, 158, 11, 0.3);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 0.4rem 0.75rem;
        border-radius: 0.5rem;
        border: none;
        background: var(--glass);
        color: var(--light);
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.75rem;
        text-decoration: none;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    .action-btn.print {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
    }

    .action-btn.qr {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    /* Product Icon */
    .product-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .product-icon i {
        color: white;
        font-size: 0.8rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--light);
    }

    /* Table Footer */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-top: 1px solid var(--glass-border);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: var(--gray);
        font-size: 0.9rem;
    }

    .pagination-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-btn {
        padding: 0.5rem 0.75rem;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 0.5rem;
        color: var(--light);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
    }

    .pagination-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border-color: var(--primary);
    }

    /* Stock Status */
    .stock-status {
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.8rem;
    }

    .stock-low {
        background: rgba(245, 158, 11, 0.15);
        color: #fcd34d;
    }

    .stock-out {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
    }

    .stock-good {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
    }

    /* Print Styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .action-buttons {
            display: none !important;
        }
        
        .table-container {
            box-shadow: none;
            border: 1px solid #000;
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

    @media (max-width: 768px) {
        .header-card {
            padding: 1.5rem;
        }
        
        .filter-card {
            padding: 1.5rem;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            font-size: 0.8rem;
            min-width: 800px;
        }
        
        .table th, .table td {
            padding: 1rem;
        }
        
        .table-footer {
            flex-direction: column;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .action-btn {
            justify-content: center;
            width: 100%;
        }
    }
</style>

<div class="reports-content">
    <!-- Header Section -->
    <div class="header-card animate-fade-in">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex-1">
                <h1 class="header-title">
                    <i class="fas fa-chart-line"></i>
                    Laporan Transaksi Stok
                </h1>
                <p class="header-subtitle">
                    Pantau semua aktivitas transaksi stok produk dalam inventori
                </p>
            </div>
            <div class="action-buttons no-print">
                <button onclick="printReport()" class="btn btn-info">
                    <i class="fas fa-print"></i>
                    Cetak Laporan
                </button>
                <button onclick="exportToPDF()" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i>
                    Export PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card animate-fade-in no-print">
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="filter-grid">
                <div class="form-group">
                    <label for="from" class="form-label">
                        <i class="fas fa-calendar-alt"></i>
                        Dari Tanggal
                    </label>
                    <input type="date" 
                           id="from" 
                           name="from" 
                           class="form-input" 
                           value="{{ request('from') }}">
                </div>

                <div class="form-group">
                    <label for="to" class="form-label">
                        <i class="fas fa-calendar-alt"></i>
                        Sampai Tanggal
                    </label>
                    <input type="date" 
                           id="to" 
                           name="to" 
                           class="form-input" 
                           value="{{ request('to') }}">
                </div>

                <div class="form-group">
                    <label for="product_id" class="form-label">
                        <i class="fas fa-box"></i>
                        Produk
                    </label>
                    <select id="product_id" name="product_id" class="form-select">
                        <option value="">Semua Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div class="filter-card animate-fade-in">
        <!-- Table Container -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Stok Akhir</th>
                        <th>User</th>
                        <th>Keterangan</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="animate-fade-in">
                        <td>
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="product-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--light);">{{ $transaction->product->name }}</div>
                                    <div style="color: var(--gray); font-size: 0.75rem;">
                                        {{ $transaction->product->sku ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($transaction->type === 'in')
                                <span class="status-badge status-in">
                                    <i class="fas fa-arrow-down"></i>
                                    Masuk
                                </span>
                            @elseif($transaction->type === 'out')
                                <span class="status-badge status-out">
                                    <i class="fas fa-arrow-up"></i>
                                    Keluar
                                </span>
                            @else
                                <span class="status-badge status-adjust">
                                    <i class="fas fa-adjust"></i>
                                    Penyesuaian
                                </span>
                            @endif
                        </td>
                        <td style="font-weight: 700; {{ $transaction->type === 'in' ? 'color: #86efac;' : 'color: #fca5a5;' }}">
                            {{ $transaction->type === 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                        </td>
                        <td style="font-weight: 600;">
                            @php
                                // Gunakan ending_stock jika ada, jika tidak gunakan stok produk saat ini
                                $currentStock = $transaction->ending_stock ?? $transaction->product->stock;
                            @endphp
                            <span class="stock-status {{ $currentStock == 0 ? 'stock-out' : ($currentStock <= $transaction->product->min_stock ? 'stock-low' : 'stock-good') }}">
                                {{ $currentStock }} pcs
                            </span>
                        </td>
                        <td>
                            <div style="color: var(--light); font-weight: 600;">{{ $transaction->user->name }}</div>
                            <div style="color: var(--gray); font-size: 0.75rem;">{{ $transaction->user->role }}</div>
                        </td>
                        <td style="color: var(--gray); font-size: 0.85rem;">
                            {{ $transaction->notes ?? '-' }}
                        </td>
                        <td class="no-print">
                            <div class="action-buttons">
                                <button onclick="printTransactionLabel('{{ $transaction->id }}', '{{ $transaction->product->name }}', '{{ $transaction->product->sku }}', '{{ $transaction->type }}', '{{ $transaction->quantity }}', '{{ $transaction->created_at->format('d M Y H:i') }}', '{{ $transaction->user->name }}')" 
                                        class="action-btn print"
                                        title="Cetak Label Transaksi">
                                    <i class="fas fa-print"></i>
                                    Label
                                </button>
                                <button onclick="downloadProductQR('{{ $transaction->product->id }}', '{{ $transaction->product->name }}', '{{ $transaction->product->sku }}')" 
                                        class="action-btn qr"
                                        title="Download QR Code">
                                    <i class="fas fa-qrcode"></i>
                                    QR
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-chart-bar"></i>
                                <h3>Tidak ada transaksi</h3>
                                <p>Belum ada transaksi stok yang tercatat dalam periode yang dipilih</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="table-footer no-print">
            <div class="pagination-info">
                Menampilkan <span style="font-weight: 600; color: var(--light);">{{ $transactions->count() }}</span> dari <span style="font-weight: 600; color: var(--light);">{{ $transactions->total() }}</span> transaksi
            </div>
            <div class="pagination-buttons">
                @if($transactions->onFirstPage())
                    <span class="pagination-btn" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-chevron-left"></i>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}" class="pagination-btn">
                        <i class="fas fa-chevron-left"></i>
                        Sebelumnya
                    </a>
                @endif

                @foreach(range(1, $transactions->lastPage()) as $page)
                    @if($page == $transactions->currentPage())
                        <span class="pagination-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $transactions->url($page) }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}" class="pagination-btn">
                        Selanjutnya
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-btn" style="opacity: 0.5; cursor: not-allowed;">
                        Selanjutnya
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Include QRCode.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default dates if not set
        const fromInput = document.getElementById('from');
        const toInput = document.getElementById('to');
        
        if (!fromInput.value) {
            const oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
            fromInput.value = oneWeekAgo.toISOString().split('T')[0];
        }
        
        if (!toInput.value) {
            toInput.value = new Date().toISOString().split('T')[0];
        }

        // Add animation to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
    });

    // Print transaction label (menampilkan jumlah keluar/masuk)
    function printTransactionLabel(transactionId, productName, productSku, type, quantity, date, userName) {
        // Bersihkan karakter khusus dari string
        const cleanProductName = productName.replace(/[^\w\s]/gi, '');
        const cleanProductSku = (productSku || 'N/A').replace(/[^\w\s]/gi, '');
        const cleanUserName = userName.replace(/[^\w\s]/gi, '');
        
        const transactionType = type === 'in' ? 'MASUK' : 'KELUAR';
        const quantityText = type === 'in' ? `+${quantity}` : `-${quantity}`;
        const typeColor = type === 'in' ? '#10b981' : '#ef4444';
        
        // Buat data QR code yang sederhana dan mudah di-scan
        const qrData = `TRX:${transactionId}|PROD:${cleanProductSku}|TYPE:${transactionType}|QTY:${quantity}|DATE:${date}`;
        
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Label Transaksi - ${cleanProductName}</title>
                <style>
                    body { 
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
                        background: white;
                        -webkit-print-color-adjust: exact;
                        print-color-adjust: exact;
                    }
                    .label-container {
                        width: 80mm;
                        height: 60mm;
                        padding: 4mm;
                        border: 2px solid #000;
                        box-sizing: border-box;
                        margin: 0 auto;
                    }
                    .label-header {
                        text-align: center;
                        margin-bottom: 3mm;
                        border-bottom: 1px solid #000;
                        padding-bottom: 2mm;
                        font-weight: bold;
                        font-size: 14px;
                    }
                    .transaction-type {
                        text-align: center;
                        font-size: 16px;
                        font-weight: bold;
                        margin: 3mm 0;
                        padding: 2mm;
                        border-radius: 4px;
                        color: white;
                    }
                    .label-content {
                        display: flex;
                        flex-direction: column;
                        gap: 2mm;
                    }
                    .label-row {
                        display: flex;
                        justify-content: space-between;
                        font-size: 11px;
                    }
                    .label-label {
                        font-weight: bold;
                        color: #666;
                    }
                    .label-value {
                        font-weight: 600;
                    }
                    .quantity-display {
                        text-align: center;
                        font-size: 20px;
                        font-weight: bold;
                        margin: 2mm 0;
                        padding: 3mm;
                        border: 2px solid ${typeColor};
                        border-radius: 8px;
                        background: ${type === 'in' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)'};
                        color: ${typeColor};
                    }
                    .qr-section {
                        text-align: center;
                        margin-top: 2mm;
                        padding-top: 2mm;
                        border-top: 1px dashed #ccc;
                    }
                    .qr-container {
                        background: white;
                        padding: 2mm;
                        display: inline-block;
                        border: 1px solid #ddd;
                    }
                    .company-name {
                        text-align: center;
                        font-size: 8px;
                        color: #999;
                        margin-top: 2mm;
                    }
                    @media print {
                        body {
                            margin: 0;
                            padding: 0;
                        }
                        .label-container {
                            border: 2px solid #000;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="label-container">
                    <div class="label-header">
                        LABEL TRANSAKSI STOK
                    </div>
                    
                    <div class="transaction-type" style="background: ${typeColor};">
                        STOK ${transactionType}
                    </div>
                    
                    <div class="quantity-display">
                        ${quantityText} pcs
                    </div>
                    
                    <div class="label-content">
                        <div class="label-row">
                            <span class="label-label">Produk:</span>
                            <span class="label-value">${cleanProductName}</span>
                        </div>
                        <div class="label-row">
                            <span class="label-label">SKU:</span>
                            <span class="label-value">${cleanProductSku}</span>
                        </div>
                        <div class="label-row">
                            <span class="label-label">Tanggal:</span>
                            <span class="label-value">${date}</span>
                        </div>
                        <div class="label-row">
                            <span class="label-label">User:</span>
                            <span class="label-value">${cleanUserName}</span>
                        </div>
                        <div class="label-row">
                            <span class="label-label">ID Transaksi:</span>
                            <span class="label-value">#${transactionId}</span>
                        </div>
                    </div>
                    
                    <div class="qr-section">
                        <div class="qr-container">
                            <div id="printQrCode"></div>
                        </div>
                        <div style="font-size: 8px; margin-top: 1mm;">Scan untuk verifikasi</div>
                    </div>
                    
                    <div class="company-name">
                        InventoryPro System - ${new Date().getFullYear()}
                    </div>
                </div>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"><\/script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Pastikan QR code digenerate dengan benar
                        const qrElement = document.getElementById('printQrCode');
                        if (qrElement) {
                            // Hapus konten sebelumnya jika ada
                            qrElement.innerHTML = '';
                            
                            // Generate QR code dengan pengaturan yang optimal
                            new QRCode(qrElement, {
                                text: '${qrData}',
                                width: 60,
                                height: 60,
                                colorDark: '#000000',
                                colorLight: '#ffffff',
                                correctLevel: QRCode.CorrectLevel.M
                            });
                            
                            console.log('QR Code generated with data:', '${qrData}');
                        }
                        
                        // Auto print setelah QR code selesai digenerate
                        setTimeout(() => {
                            window.print();
                        }, 800);
                    });
                <\/script>
            </body>
            </html>
        `;
        
        const printWindow = window.open('', '_blank', 'width=400,height=400');
        printWindow.document.write(printContent);
        printWindow.document.close();
    }

    // Download product QR code
    function downloadProductQR(productId, productName, productSku) {
        // Bersihkan karakter khusus
        const cleanProductName = productName.replace(/[^\w\s]/gi, '');
        const cleanProductSku = (productSku || productId.toString()).replace(/[^\w\s]/gi, '');
        
        const qrData = `PROD:${cleanProductSku}`;
        const qrContainer = document.createElement('div');
        
        new QRCode(qrContainer, {
            text: qrData,
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        
        setTimeout(() => {
            const canvas = qrContainer.querySelector('canvas');
            if (canvas) {
                try {
                    const link = document.createElement('a');
                    link.download = `QRCode-${cleanProductSku}-${cleanProductName}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                } catch (error) {
                    alert('Error downloading QR code: ' + error.message);
                }
            }
        }, 500);
    }

    // Print report
    function printReport() {
        window.print();
    }

    // Export to PDF (simplified version)
    function exportToPDF() {
        alert('Fitur export PDF akan segera tersedia!');
        // In a real implementation, you would use a PDF generation library
        // like jsPDF or make an API call to generate PDF on the server
    }

    // Helper function to format numbers
    function formatNumber(num) {
        return parseInt(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endsection