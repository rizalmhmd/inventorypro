@extends('layout.app')

@section('title', $product->name . ' - InventoryPro')
@section('page-title', 'Detail Produk')
@section('title-icon', 'fa-box')

@section('content')
<style>
    .product-detail-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Main Card */
    .detail-card {
        background: rgba(30, 35, 50, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        padding: 2.5rem;
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        margin-bottom: 2rem;
    }

    /* Header Section */
    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .product-header {
            flex-direction: column;
        }
    }

    .product-info {
        flex: 1;
    }

    .product-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .product-sku {
        color: var(--gray);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .product-category {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(139, 92, 246, 0.1);
        color: #a78bfa;
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        border: 1px solid rgba(139, 92, 246, 0.3);
        font-size: 0.9rem;
    }

    /* QR Code Section */
    .qr-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--glass-border);
        text-align: center;
        min-width: 200px;
    }

    .qr-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--light);
    }

    .qr-code-container {
        background: white;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        display: inline-block;
        min-height: 150px;
        min-width: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qr-loading {
        color: #666;
        font-size: 0.9rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.04);
        padding: 1.5rem;
        border-radius: 1rem;
        border: 1px solid var(--glass-border);
        text-align: center;
    }

    .stat-label {
        color: var(--gray);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--light);
    }

    .stat-value.price {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid;
    }

    .status-available {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
        border-color: rgba(34, 197, 94, 0.3);
    }

    .status-low {
        background: rgba(245, 158, 11, 0.15);
        color: #fcd34d;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .status-out {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* Description Section */
    .description-section {
        background: rgba(255, 255, 255, 0.04);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--glass-border);
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .description-content {
        color: var(--gray);
        line-height: 1.6;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 1rem 1.5rem;
        border-radius: 1rem;
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

    /* Print Styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .detail-card {
            box-shadow: none;
            border: 1px solid #000;
        }
        
        .qr-code-container {
            border: 1px solid #000;
        }

        /* Print Label Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        .label-container {
            width: 100mm;
            height: 50mm;
            padding: 5mm;
            border: 1px solid #000;
            box-sizing: border-box;
        }
        
        .label-header {
            text-align: center;
            margin-bottom: 3mm;
        }
        
        .label-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .label-info {
            flex: 1;
        }
        
        .label-qr {
            flex-shrink: 0;
        }
        
        .product-name-label {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2mm;
        }
        
        .product-sku-label {
            font-size: 10px;
            margin-bottom: 1mm;
        }
        
        .product-price-label {
            font-size: 11px;
            font-weight: bold;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-card {
            padding: 1.5rem;
        }
        
        .product-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
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
</style>

<div class="product-detail-content">
    <div class="detail-card animate-fade-in">
        <!-- Product Header -->
        <div class="product-header">
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-sku">
                    <strong>SKU:</strong> {{ $product->sku ?? 'Tidak ada SKU' }}
                </div>
                <div class="product-category">
                    <i class="fas fa-tag"></i>
                    {{ $product->category }}
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-title">Kode QR</div>
                <div class="qr-code-container">
                    <div id="qrCode" class="qr-loading">
                        <i class="fas fa-spinner fa-spin"></i> Generating QR Code...
                    </div>
                </div>
                <button onclick="downloadQRCode()" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i>
                    Download QR
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-label">Stok Saat Ini</div>
                <div class="stat-value">{{ $product->stock }} pcs</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-label">Stok Minimum</div>
                <div class="stat-value">{{ $product->min_stock }} pcs</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-label">Harga Satuan</div>
                <div class="stat-value price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-label">Status Stok</div>
                <div class="stat-value">
                    @if($product->stock == 0)
                        <span class="status-badge status-out">
                            <i class="fas fa-times-circle"></i>
                            Habis
                        </span>
                    @elseif($product->stock < $product->min_stock)
                        <span class="status-badge status-low">
                            <i class="fas fa-exclamation-triangle"></i>
                            Menipis
                        </span>
                    @else
                        <span class="status-badge status-available">
                            <i class="fas fa-check-circle"></i>
                            Tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Description Section -->
        @if($product->description)
        <div class="description-section">
            <h3 class="section-title">
                <i class="fas fa-align-left"></i>
                Deskripsi Produk
            </h3>
            <div class="description-content">
                {{ $product->description }}
            </div>
        </div>
        @endif

        <!-- Product Info -->
        <div class="description-section">
            <h3 class="section-title">
                <i class="fas fa-info-circle"></i>
                Informasi Produk
            </h3>
            <div class="description-content">
                <div style="display: grid; grid-template-columns: auto 1fr; gap: 1rem; align-items: center;">
                    <strong>ID Produk:</strong>
                    <span>#{{ $product->id }}</span>
                    
                    <strong>Dibuat:</strong>
                    <span>{{ $product->created_at->format('d M Y H:i') }}</span>
                    
                    <strong>Diupdate:</strong>
                    <span>{{ $product->updated_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons no-print">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
            </a>
            
            @if(auth()->user()?->role === 'admin')
            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Produk
            </a>
            @endif
            
            <button onclick="printLabel()" class="btn btn-info">
                <i class="fas fa-print"></i>
                Cetak Label
            </button>
            
            <button onclick="downloadProductInfo()" class="btn btn-success">
                <i class="fas fa-file-pdf"></i>
                Download Info
            </button>
        </div>
    </div>
</div>

<!-- Include QRCode.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR Code untuk halaman detail
        const qrCodeElement = document.getElementById('qrCode');
        const productData = `{{ $product->sku ?? $product->id }}`;
        
        // Clear loading message
        qrCodeElement.innerHTML = '';
        
        // Generate QR Code dengan kode SKU
        new QRCode(qrCodeElement, {
            text: productData,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    });

    // Download QR Code as PNG
    function downloadQRCode() {
        const canvas = document.querySelector('#qrCode canvas');
        if (canvas) {
            try {
                const link = document.createElement('a');
                link.download = 'QRCode-{{ $product->sku ?? $product->id }}-{{ $product->name }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            } catch (error) {
                alert('Error downloading QR code: ' + error.message);
            }
        } else {
            alert('QR Code belum siap. Tunggu sebentar...');
        }
    }

    // Print Label dengan QR Code berisi SKU
    function printLabel() {
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Label Produk - {{ $product->name }}</title>
                <style>
                    body { 
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
                        background: white;
                    }
                    .label-container {
                        width: 100mm;
                        height: 50mm;
                        padding: 5mm;
                        border: 1px solid #000;
                        box-sizing: border-box;
                        margin: 0 auto;
                    }
                    .label-header {
                        text-align: center;
                        margin-bottom: 3mm;
                        border-bottom: 1px solid #000;
                        padding-bottom: 2mm;
                    }
                    .label-content {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        height: calc(100% - 20px);
                    }
                    .label-info {
                        flex: 1;
                        padding-right: 3mm;
                    }
                    .label-qr {
                        flex-shrink: 0;
                        background: white;
                        padding: 2mm;
                        border: 1px solid #ddd;
                    }
                    .product-name-label {
                        font-size: 12px;
                        font-weight: bold;
                        margin-bottom: 2mm;
                        line-height: 1.2;
                    }
                    .product-sku-label {
                        font-size: 10px;
                        margin-bottom: 1mm;
                        color: #666;
                    }
                    .product-price-label {
                        font-size: 11px;
                        font-weight: bold;
                        color: #000;
                    }
                    .company-name {
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
                            border: 1px solid #000;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="label-container">
                    <div class="label-header">
                        <strong>LABEL PRODUK</strong>
                    </div>
                    <div class="label-content">
                        <div class="label-info">
                            <div class="product-name-label">{{ Str::limit($product->name, 30) }}</div>
                            <div class="product-sku-label">SKU: {{ $product->sku ?? 'N/A' }}</div>
                            <div class="product-price-label">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div style="font-size: 9px; margin-top: 1mm;">Stok: {{ $product->stock }} pcs</div>
                            <div class="company-name">InventoryPro System</div>
                        </div>
                        <div class="label-qr" id="printQrCode"></div>
                    </div>
                </div>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"><\/script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // QR Code berisi kode SKU saja
                        const qrData = '{{ $product->sku ?? $product->id }}';
                        new QRCode(document.getElementById('printQrCode'), {
                            text: qrData,
                            width: 60,
                            height: 60,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    });
                <\/script>
            </body>
            </html>
        `;
        
        const printWindow = window.open('', '_blank', 'width=400,height=300');
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        printWindow.onload = function() {
            setTimeout(() => {
                printWindow.print();
                // Optional: close window after printing
                // printWindow.close();
            }, 500);
        };
    }

    // Download Product Info as PDF (simplified version)
    function downloadProductInfo() {
        const productInfo = `
INFORMASI PRODUK
================

Nama Produk: {{ $product->name }}
SKU: {{ $product->sku ?? 'Tidak ada SKU' }}
Kategori: {{ $product->category }}
Stok: {{ $product->stock }} pcs
Stok Minimum: {{ $product->min_stock }} pcs
Harga: Rp {{ number_format($product->price, 0, ',', '.') }}
Status: @if($product->stock == 0)Habis
@elseif($product->stock < $product->min_stock)Menipis
@elseTersedia
@endif

Deskripsi:
{{ $product->description ?? 'Tidak ada deskripsi' }}

Informasi Sistem:
ID: #{{ $product->id }}
Dibuat: {{ $product->created_at->format('d M Y H:i') }}
Diupdate: {{ $product->updated_at->format('d M Y H:i') }}

-- InventoryPro --
        `;
        
        const blob = new Blob([productInfo], { type: 'text/plain' });
        const link = document.createElement('a');
        link.download = 'Info-Produk-{{ $product->name }}-{{ $product->sku ?? $product->id }}.txt';
        link.href = URL.createObjectURL(blob);
        link.click();
        URL.revokeObjectURL(link.href);
    }
</script>
@endsection