@extends('layout.app')

@section('title', 'Edit Produk - InventoryPro')
@section('page-title', 'Edit Produk')
@section('title-icon', 'fa-edit')

@section('content')
<style>
    .edit-product-content {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Form Card */
    .form-card {
        background: rgba(30, 35, 50, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        padding: 2.5rem;
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        max-width: 800px;
        margin: 0 auto;
    }

    /* Form Header */
    .form-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .form-subtitle {
        color: var(--gray);
        font-size: 1.1rem;
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
        color: var(--light);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label .required {
        color: #f87171;
        font-size: 0.8rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.2rem;
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        color: var(--light);
        font-size: 0.95rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        font-family: 'Instrument Sans', sans-serif;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
        transform: translateY(-2px);
    }

    .form-input::placeholder {
        color: var(--gray);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 120px;
    }

    /* Error Messages */
    .error-message {
        color: #fca5a5;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
        line-height: 1.4;
    }

    .input-error {
        border-color: #f87171 !important;
        box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15) !important;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--glass-border);
        flex-wrap: wrap;
    }

    @media (max-width: 480px) {
        .form-actions {
            flex-direction: column;
        }
    }

    /* Buttons */
    .btn {
        padding: 1rem 2rem;
        border-radius: 1rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-family: inherit;
        min-width: 120px;
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

    /* Helper Text */
    .helper-text {
        color: var(--gray);
        font-size: 0.8rem;
        margin-top: 0.5rem;
        line-height: 1.4;
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
        color: var(--gray);
        font-weight: 600;
    }

    .price-input {
        padding-left: 3rem !important;
    }

    /* Success Alert */
    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #86efac;
        padding: 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        gap: 1rem;
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
</style>

<div class="edit-product-content">
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
                <i class="fas fa-edit"></i>
                Edit Produk
            </h1>
            <p class="form-subtitle">
                Perbarui informasi produk yang sudah ada
            </p>
        </div>

        <form method="POST" action="{{ route('products.update', $product) }}" id="productForm">
            @csrf 
            @method('PUT')

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
                           value="{{ old('sku', $product->sku) }}"
                           placeholder="Masukkan kode SKU produk">
                    @error('sku')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Kode unik untuk identifikasi produk
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
                           value="{{ old('name', $product->name) }}"
                           placeholder="Masukkan nama produk"
                           required>
                    @error('name')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="form-group">
                    <label for="stock" class="form-label">
                        <i class="fas fa-boxes"></i>
                        Jumlah Stok
                        <span class="required">*</span>
                    </label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           class="form-input @error('stock') input-error @enderror" 
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           placeholder="0"
                           required>
                    @error('stock')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Jumlah stok yang tersedia
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
                               value="{{ old('price', $product->price) }}"
                               min="0"
                               step="0.01"
                               placeholder="0"
                               required>
                    </div>
                    @error('price')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
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
                           value="{{ old('category', $product->category) }}"
                           placeholder="Masukkan kategori produk">
                    @error('category')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Kategori produk
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
                           value="{{ old('min_stock', $product->min_stock) }}"
                           min="0"
                           placeholder="5">
                    @error('min_stock')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Batas minimum stok sebelum sistem memberi peringatan
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
                        placeholder="Masukkan deskripsi produk"
                        rows="4">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
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
                    Perbarui Produk
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

        // Format price input on blur
        priceInput?.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        });

        // Add loading state to form submission
        form?.addEventListener('submit', function(e) {
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memperbarui...';
            submitBtn.disabled = true;
            
            // Revert after 5 seconds if form doesn't submit (fallback)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 5000);
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
                    counter.style.color = '#f87171';
                } else {
                    counter.style.color = 'var(--gray)';
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