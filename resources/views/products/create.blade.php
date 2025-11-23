@extends('layout.app')

@section('title', 'Tambah Produk - Inventory System')
@section('page-title', 'Tambah Produk')
@section('title-icon', 'fa-plus-circle')

@section('content')
<style>
    .create-product-content {
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

    .form-input {
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

    .form-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.15);
    }

    .form-input::placeholder {
        color: var(--text-secondary);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 120px;
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

    /* Helper Text */
    .helper-text {
        color: var(--text-secondary);
        font-size: 0.75rem;
        margin-top: 0.5rem;
        line-height: 1.4;
    }

    .helper-text.info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #3b82f6;
        padding: 0.75rem;
        border-radius: 0.75rem;
        margin-top: 1rem;
    }

    /* Price Input Container */
    .price-container {
        position: relative;
    }

    .price-prefix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-weight: 600;
    }

    .price-input {
        padding-left: 3rem !important;
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
    .form-group:nth-child(5) { animation-delay: 0.5s; }
    .form-group:nth-child(6) { animation-delay: 0.6s; }
    .form-actions { animation-delay: 0.7s; }

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
        
        .form-input {
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

<div class="create-product-content">
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
                <i class="fas fa-plus-circle"></i>
                Tambah Produk Baru
            </h1>
            <p class="form-subtitle">
                Isi informasi produk untuk menambahkan item baru ke inventori
            </p>
        </div>

        <form method="POST" action="{{ route('products.store') }}" id="productForm">
            @csrf

            <div class="form-grid">
                <!-- SKU -->
                <div class="form-group">
                    <label for="sku" class="form-label">
                        <i class="fas fa-barcode"></i>
                        SKU Produk
                    </label>
                    <input type="text" 
                           id="sku" 
                           name="sku" 
                           class="form-input @error('sku') input-error @enderror" 
                           value="{{ old('sku') }}"
                           placeholder="Masukkan kode SKU produk">
                    @error('sku')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Kode unik untuk identifikasi produk (opsional)
                    </div>
                </div>

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag"></i>
                        Nama Produk
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-input @error('name') input-error @enderror" 
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama produk"
                           required>
                    @error('name')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="form-group">
                    <label for="stock" class="form-label">
                        <i class="fas fa-boxes"></i>
                        Jumlah Stok Awal
                    </label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           class="form-input @error('stock') input-error @enderror" 
                           value="{{ old('stock', 0) }}"
                           min="0"
                           placeholder="0">
                    @error('stock')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Jumlah stok awal yang tersedia (opsional)
                    </div>
                    <div class="helper-text info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Fitur Otomatis:</strong> Jika dikosongkan, sistem akan otomatis set stok = 0
                    </div>
                </div>

                <!-- Price -->
                <div class="form-group">
                    <label for="price" class="form-label">
                        <i class="fas fa-money-bill-wave"></i>
                        Harga Satuan
                        <span class="required">*</span>
                    </label>
                    <div class="price-container">
                        <span class="price-prefix">Rp</span>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               class="form-input price-input @error('price') input-error @enderror" 
                               value="{{ old('price', 0) }}"
                               min="0"
                               step="0.01"
                               placeholder="0"
                               required>
                    </div>
                    @error('price')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Harga per unit produk
                    </div>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category" class="form-label">
                        <i class="fas fa-folder"></i>
                        Kategori
                    </label>
                    <input type="text" 
                           id="category" 
                           name="category" 
                           class="form-input @error('category') input-error @enderror" 
                           value="{{ old('category', 'Uncategorized') }}"
                           placeholder="Masukkan kategori produk">
                    @error('category')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Kategori produk (default: Uncategorized)
                    </div>
                </div>

                <!-- Min Stock -->
                <div class="form-group">
                    <label for="min_stock" class="form-label">
                        <i class="fas fa-exclamation-triangle"></i>
                        Stok Minimum
                    </label>
                    <input type="number" 
                           id="min_stock" 
                           name="min_stock" 
                           class="form-input @error('min_stock') input-error @enderror" 
                           value="{{ old('min_stock', 5) }}"
                           min="0"
                           placeholder="5">
                    @error('min_stock')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Batas minimum stok sebelum sistem memberi peringatan (default: 5)
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left"></i>
                        Deskripsi Produk
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-input @error('description') input-error @enderror" 
                        placeholder="Masukkan deskripsi produk (opsional)"
                        rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.25rem;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Deskripsi detail tentang produk (maksimal 500 karakter)
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions animate-fade-in">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('productForm');
        const submitBtn = document.getElementById('submitBtn');
        const priceInput = document.getElementById('price');
        const stockInput = document.getElementById('stock');

        // Auto-set stock to 0 if empty on form submission
        form?.addEventListener('submit', function(e) {
            if (!stockInput.value.trim()) {
                stockInput.value = 0;
            }

            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
            
            // Revert after 5 seconds if form doesn't submit (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 5000);
        });

        // Format price input on blur
        priceInput?.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        });

        // Stock input helper
        stockInput?.addEventListener('input', function() {
            if (this.value === '') {
                this.style.borderColor = 'var(--card-border)';
            } else {
                this.style.borderColor = 'var(--primary-blue)';
            }
        });

        // Auto-focus first input field
        const firstInput = document.querySelector('.form-input');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 400);
        }

        // Character counter for description
        const descriptionTextarea = document.getElementById('description');
        if (descriptionTextarea) {
            // Create character counter
            const counter = document.createElement('div');
            counter.className = 'helper-text';
            counter.style.textAlign = 'right';
            counter.innerHTML = '<span id="charCount">0</span>/500 karakter';
            descriptionTextarea.parentNode.insertBefore(counter, descriptionTextarea.nextSibling);

            descriptionTextarea.addEventListener('input', function() {
                const charCount = this.value.length;
                document.getElementById('charCount').textContent = charCount;
                
                if (charCount > 500) {
                    counter.style.color = '#ef4444';
                } else {
                    counter.style.color = 'var(--text-secondary)';
                }
            });

            // Initialize counter
            const initialCount = descriptionTextarea.value.length;
            document.getElementById('charCount').textContent = initialCount;
        }

        // Real-time validation
        const inputs = document.querySelectorAll('.form-input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('input-error');
                } else {
                    this.classList.remove('input-error');
                }
            });
        });
    });
</script>
@endsection