@extends('layout.app')

@section('title', 'Stok Keluar - Inventory System')
@section('page-title', 'Stok Keluar')
@section('title-icon', 'fa-arrow-up')

@section('content')
<style>
    .stock-out-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Form Card */
    .form-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-radius: 1rem;
        padding: 2rem;
        border: 1px solid var(--card-border);
        max-width: 800px;
        margin: 0 auto;
    }

    /* Form Header */
    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .form-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    /* Form Elements */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label .required {
        color: #ef4444;
        font-size: 0.8rem;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--card-border);
        border-radius: 0.75rem;
        color: var(--text-primary);
        font-size: 0.9rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        font-family: 'Inter', sans-serif;
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

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--primary-blue);
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.15);
    }

    .form-input::placeholder, .form-textarea::placeholder {
        color: var(--text-secondary);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Error Messages */
    .error-message {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        display: block;
        line-height: 1.4;
    }

    .input-error {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--card-border);
        flex-wrap: wrap;
    }

    @media (max-width: 480px) {
        .form-actions {
            flex-direction: column;
        }
    }

    /* Buttons */
    .btn {
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-family: inherit;
        min-width: 120px;
        backdrop-filter: blur(10px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
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

    /* Helper Text */
    .helper-text {
        color: var(--text-secondary);
        font-size: 0.75rem;
        margin-top: 0.5rem;
        line-height: 1.4;
    }

    .helper-text.warning {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b;
        padding: 0.75rem;
        border-radius: 0.75rem;
        margin-top: 1rem;
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
        display: flex;
        align-items: center;
        gap: 0.75rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Stock Warning */
    .stock-warning {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-top: 0.5rem;
        display: none;
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

    .form-group {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    /* Staggered animations */
    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }
    .form-actions { animation-delay: 0.5s; }

    /* PERBAIKAN: CSS Variables fallback */
    :root {
        --card-bg: rgba(255, 255, 255, 0.05);
        --card-border: rgba(255, 255, 255, 0.1);
        --text-primary: #f3f4f6;
        --text-secondary: #9ca3af;
        --primary-blue: #3b82f6;
    }

    /* PERBAIKAN: Background body untuk kontras */
    body {
        background: #111827;
        color: #f3f4f6;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .form-card {
            padding: 1.5rem;
        }
        
        .form-title {
            font-size: 1.5rem;
            gap: 0.75rem;
        }
        
        .form-subtitle {
            font-size: 0.9rem;
        }
        
        .form-grid {
            gap: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-input, .form-select, .form-textarea {
            padding: 0.875rem;
        }
        
        .btn {
            padding: 0.875rem 1.25rem;
            min-width: auto;
            width: 100%;
        }
    }

    /* Touch improvements for mobile */
    @media (hover: none) {
        .btn:hover {
            transform: none;
        }
        
        .btn:active {
            transform: scale(0.98);
        }
    }
</style>

<div class="stock-out-content">
    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert-success animate-fade-in">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="form-card">
        <!-- Form Header -->
        <div class="form-header animate-fade-in">
            <h1 class="form-title">
                <i class="fas fa-arrow-up"></i>
                Stok Keluar
            </h1>
            <p class="form-subtitle">
                Kurangi stok dari inventori
            </p>
        </div>

        <form method="POST" action="{{ route('stock.out') }}" id="stockForm">
            @csrf

            <div class="form-grid">
                <!-- Produk -->
                <div class="form-group full-width">
                    <label for="product_id" class="form-label">
                        <i class="fas fa-box"></i>
                        Pilih Produk
                        <span class="required">*</span>
                    </label>
                    <select id="product_id" name="product_id" class="form-select @error('product_id') input-error @enderror" required style="color: #f3f4f6;">
                        <option value="" style="color: #9ca3af;">-- Pilih Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" 
                                    data-stock="{{ $p->stock }}"
                                    {{ old('product_id') == $p->id ? 'selected' : '' }}
                                    style="color: #f3f4f6; background: #1f2937;">
                                {{ $p->name }} ({{ $p->sku ?? 'No SKU' }}) - Stok: {{ $p->stock }} pcs
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Pilih produk yang akan dikurangi stoknya
                    </div>
                    <div class="stock-warning" id="stockWarning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span id="warningText"></span>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="form-group">
                    <label for="quantity" class="form-label">
                        <i class="fas fa-boxes"></i>
                        Jumlah Stok Keluar
                        <span class="required">*</span>
                    </label>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           class="form-input @error('quantity') input-error @enderror" 
                           value="{{ old('quantity', 1) }}"
                           min="1"
                           placeholder="1"
                           required
                           style="color: #f3f4f6;">
                    @error('quantity')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Jumlah stok yang akan dikeluarkan
                    </div>
                </div>

                <!-- Reference -->
                <div class="form-group">
                    <label for="reference" class="form-label">
                        <i class="fas fa-hashtag"></i>
                        Referensi
                    </label>
                    <input type="text" 
                           id="reference" 
                           name="reference" 
                           class="form-input @error('reference') input-error @enderror" 
                           value="{{ old('reference') }}"
                           placeholder="Masukkan nomor referensi"
                           style="color: #f3f4f6;">
                    @error('reference')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Nomor SO, delivery, atau referensi lainnya (opsional)
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group full-width">
                    <label for="notes" class="form-label">
                        <i class="fas fa-sticky-note"></i>
                        Keterangan
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        class="form-textarea @error('notes') input-error @enderror" 
                        placeholder="Masukkan keterangan tambahan"
                        rows="3"
                        style="color: #f3f4f6;">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Keterangan tentang stok keluar (opsional)
                    </div>
                </div>
            </div>

            <!-- Warning Info -->
            <div class="helper-text warning animate-fade-in">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Perhatian:</strong> Pastikan jumlah stok keluar tidak melebihi stok yang tersedia.
                Sistem akan memvalidasi ketersediaan stok sebelum proses disimpan.
            </div>

            <!-- Form Actions -->
            <div class="form-actions animate-fade-in">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    Simpan Stok Keluar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('stockForm');
        const submitBtn = document.getElementById('submitBtn');
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const stockWarning = document.getElementById('stockWarning');
        const warningText = document.getElementById('warningText');

        // PERBAIKAN: Force styling untuk select dropdown
        function styleSelectDropdown() {
            const select = document.getElementById('product_id');
            if (select) {
                select.style.color = '#f3f4f6';
                select.style.backgroundColor = 'rgba(255, 255, 255, 0.06)';
            }
        }

        // Stock validation
        function validateStock() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const currentStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            if (selectedOption.value && quantity > 0) {
                if (quantity > currentStock) {
                    stockWarning.style.display = 'block';
                    warningText.textContent = `Stok tidak mencukupi! Stok tersedia: ${currentStock} pcs, permintaan: ${quantity} pcs`;
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                    submitBtn.style.cursor = 'not-allowed';
                } else if (quantity === currentStock) {
                    stockWarning.style.display = 'block';
                    warningText.textContent = `Perhatian! Stok akan habis setelah transaksi ini`;
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                } else if (currentStock - quantity <= 5) {
                    stockWarning.style.display = 'block';
                    warningText.textContent = `Stok akan menipis! Sisa stok: ${currentStock - quantity} pcs`;
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                } else {
                    stockWarning.style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                }
            } else {
                stockWarning.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
        }

        // Event listeners for stock validation
        productSelect?.addEventListener('change', function() {
            validateStock();
            // Update styling saat select berubah
            styleSelectDropdown();
        });
        
        quantityInput?.addEventListener('input', validateStock);

        // Add loading state to form submission
        form?.addEventListener('submit', function(e) {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const currentStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            // Final validation
            if (quantity > currentStock) {
                e.preventDefault();
                alert('Stok tidak mencukupi! Silahkan periksa jumlah stok yang diminta.');
                return;
            }

            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
            
            // Revert after 5 seconds if form doesn't submit (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    validateStock(); // Re-validate setelah timeout
                }
            }, 5000);
        });

        // Auto-focus first input field
        const firstInput = document.querySelector('.form-input, .form-select');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 400);
        }

        // Real-time validation
        const inputs = document.querySelectorAll('.form-input[required], .form-select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('input-error');
                } else {
                    this.classList.remove('input-error');
                }
            });
        });

        // PERBAIKAN: Inisialisasi styling dan validation
        styleSelectDropdown();
        validateStock();
        
        // Jalankan lagi setelah 100ms untuk memastikan
        setTimeout(() => {
            styleSelectDropdown();
            validateStock();
        }, 100);
    });
</script>
@endsection