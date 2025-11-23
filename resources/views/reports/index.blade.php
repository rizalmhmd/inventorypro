@extends('layout.app')

@section('title', 'Laporan Stok - Inventory System')
@section('page-title', 'Laporan Stok')
@section('title-icon', 'fa-chart-line')

@section('content')
<style>
    .reports-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Header Card */
    .header-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        padding: 2rem;
        border: 1px solid var(--card-border);
        margin-bottom: 1.5rem;
    }

    .header-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    /* Filter Card */
    .filter-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--card-border);
        margin-bottom: 1.5rem;
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
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--card-border);
        border-radius: 0.75rem;
        color: var(--text-primary);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    /* PERBAIKAN: Styling khusus untuk select dropdown */
    .form-select {
        background: rgba(255, 255, 255, 0.06) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 1rem center;
        background-size: 16px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 3rem;
    }

    /* PERBAIKAN: Styling untuk options */
    .form-select option {
        background: #1f2937;
        color: #f3f4f6;
        padding: 0.75rem;
        border: none;
    }

    .form-select option:checked {
        background: #3b82f6;
        color: white;
    }

    .form-select option:hover {
        background: #4b5563;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.15);
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
        backdrop-filter: blur(10px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
        color: white;
        box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 102, 255, 0.4);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-primary);
        border: 1px solid var(--card-border);
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
        border: 1px solid var(--card-border);
        margin-bottom: 1.5rem;
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
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--card-border);
    }

    .table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
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
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .status-out {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .status-adjust {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
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
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.75rem;
        text-decoration: none;
        backdrop-filter: blur(10px);
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
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
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
        padding: 3rem 2rem;
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
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    /* Table Footer */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-top: 1px solid var(--card-border);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .pagination-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-btn {
        padding: 0.5rem 0.75rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--card-border);
        border-radius: 0.5rem;
        color: var(--text-primary);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        backdrop-filter: blur(10px);
    }

    .pagination-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
        color: white;
        border-color: var(--primary-blue);
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
        color: #f59e0b;
    }

    .stock-out {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    .stock-good {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }

    /* PERBAIKAN: CSS Variables fallback */
    :root {
        --card-bg: rgba(255, 255, 255, 0.05);
        --card-border: rgba(255, 255, 255, 0.1);
        --text-primary: #f3f4f6;
        --text-secondary: #9ca3af;
        --primary-blue: #3b82f6;
        --primary-dark: #1d4ed8;
        --accent-purple: #8b5cf6;
    }

    /* PERBAIKAN: Background body untuk kontras */
    body {
        background: #111827;
        color: #f3f4f6;
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

    /* Responsive */
    @media (max-width: 768px) {
        .header-card {
            padding: 1.5rem;
        }
        
        .filter-card {
            padding: 1.25rem;
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

    @media (max-width: 480px) {
        .header-card {
            padding: 1.25rem;
        }
        
        .filter-card {
            padding: 1rem;
        }
        
        .header-title {
            font-size: 1.5rem;
            gap: 0.75rem;
        }
        
        .header-subtitle {
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
        }
    }

    /* Touch improvements for mobile */
    @media (hover: none) {
        .btn:hover,
        .action-btn:hover,
        .pagination-btn:hover {
            transform: none;
        }
        
        .btn:active,
        .action-btn:active,
        .pagination-btn:active {
            transform: scale(0.98);
        }
    }
</style>

<div class="reports-content">
    <!-- Header Section -->
    <div class="header-card animate-fade-in">
        <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1rem;">
            <div style="flex: 1;">
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
                           value="{{ request('from') }}"
                           style="color: #f3f4f6;">
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
                           value="{{ request('to') }}"
                           style="color: #f3f4f6;">
                </div>

                <div class="form-group">
                    <label for="product_id" class="form-label">
                        <i class="fas fa-box"></i>
                        Produk
                    </label>
                    <select id="product_id" name="product_id" class="form-select" style="color: #f3f4f6;">
                        <option value="" style="color: #9ca3af;">Semua Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }} style="color: #f3f4f6; background: #1f2937;">
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
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="product-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $transaction->product->name }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.75rem;">
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
                        <td style="font-weight: 700; {{ $transaction->type === 'in' ? 'color: #10b981;' : 'color: #ef4444;' }}">
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
                            <div style="color: var(--text-primary); font-weight: 600;">{{ $transaction->user->name }}</div>
                            <div style="color: var(--text-secondary); font-size: 0.75rem;">{{ $transaction->user->role }}</div>
                        </td>
                        <td style="color: var(--text-secondary); font-size: 0.85rem;">
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
                Menampilkan <span style="font-weight: 600; color: var(--text-primary);">{{ $transactions->count() }}</span> dari <span style="font-weight: 600; color: var(--text-primary);">{{ $transactions->total() }}</span> transaksi
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

        // PERBAIKAN: Force styling untuk select dropdown
        function styleSelectDropdown() {
            const select = document.getElementById('product_id');
            if (select) {
                select.style.color = '#f3f4f6';
                select.style.backgroundColor = 'rgba(255, 255, 255, 0.06)';
            }
        }

        // Inisialisasi styling
        styleSelectDropdown();
        
        // Jalankan lagi setelah 100ms untuk memastikan
        setTimeout(styleSelectDropdown, 100);

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
                        Inventory System - ${new Date().getFullYear()}
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