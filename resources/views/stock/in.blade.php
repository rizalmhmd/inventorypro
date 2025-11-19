@extends('layout.app')

@section('title', 'Stok Masuk - InventoryPro')
@section('page-title', 'Stok Masuk')
@section('title-icon', 'fa-arrow-down')

@section('content')
<style>
    .stock-in-content {
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

    .form-input, .form-select, .form-textarea {
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

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
        transform: translateY(-2px);
    }

    .form-input::placeholder, .form-textarea::placeholder {
        color: var(--gray);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
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
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
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

    /* Product Info */
    .product-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #93c5fd;
        padding: 1rem;
        border-radius: 0.75rem;
        margin-top: 0.5rem;
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
</style>

<div class="stock-in-content">
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
                <i class="fas fa-arrow-down"></i>
                Stok Masuk
            </h1>
            <p class="form-subtitle">
                Tambahkan stok baru ke dalam inventori
            </p>
        </div>

        <form method="POST" action="{{ route('stock.in') }}" id="stockForm">
            @csrf

            <div class="form-grid">
                <!-- Produk -->
                <div class="form-group full-width">
                    <label for="product_id" class="form-label">
                        <i class="fas fa-box"></i>
                        Pilih Produk
                        <span class="required">*</span>
                    </label>
                    <select id="product_id" name="product_id" class="form-select @error('product_id') input-error @enderror" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} ({{ $p->sku ?? 'No SKU' }}) - Stok: {{ $p->stock }} pcs
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Pilih produk yang akan ditambahkan stoknya
                    </div>
                </div>

                <!-- Quantity -->
                <div class="form-group">
                    <label for="quantity" class="form-label">
                        <i class="fas fa-boxes"></i>
                        Jumlah Stok Masuk
                        <span class="required">*</span>
                    </label>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           class="form-input @error('quantity') input-error @enderror" 
                           value="{{ old('quantity', 1) }}"
                           min="1"
                           placeholder="1"
                           required>
                    @error('quantity')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Jumlah stok yang akan ditambahkan
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
                           placeholder="Masukkan nomor referensi">
                    @error('reference')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Nomor PO, invoice, atau referensi lainnya (opsional)
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
                        rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="helper-text">
                        Keterangan tentang stok masuk (opsional)
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
                    Simpan Stok Masuk
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

        // Add loading state to form submission
        form?.addEventListener('submit', function(e) {
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

        // Product selection helper
        productSelect?.addEventListener('change', function() {
            if (this.value) {
                this.style.borderColor = 'var(--primary)';
            } else {
                this.style.borderColor = 'var(--glass-border)';
            }
        });
    });
</script>
@endsection