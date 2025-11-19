<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - InventoryPro</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-light: #a78bfa;
            --secondary: #10b981;
            --secondary-dark: #059669;
            --accent: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            --dark: #1a1f36;
            --darker: #0f1322;
            --dark-light: #2d3748;
            --light: #f8fafc;
            --gray: #94a3b8;
            --glass: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, var(--darker) 0%, var(--dark) 50%, var(--dark-light) 100%);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Background Animation */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            animation: float 30s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-100px, -50px) rotate(360deg); }
        }

        /* Back Home Link - IN BACKGROUND */
        .back-home {
            position: fixed;
            top: 2rem;
            left: 2rem;
            color: var(--gray);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
            border-radius: 0.8rem;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            font-weight: 500;
            z-index: 10;
        }

        .back-home:hover {
            color: var(--light);
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Main Container */
        .container {
            max-width: 440px;
            width: 100%;
            background: rgba(30, 35, 50, 0.85);
            backdrop-filter: blur(25px);
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            position: relative;
            z-index: 1;
        }

        /* Content - FIXED MOBILE PADDING */
        .content {
            padding: 3rem 2.5rem;
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-text {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--light) 0%, var(--primary) 50%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            line-height: 1.2;
        }

        .logo-subtitle {
            color: var(--gray);
            font-size: 0.95rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* Form Header */
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--light);
            line-height: 1.3;
        }

        .form-subtitle {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 500;
            color: var(--light);
            font-size: 0.9rem;
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

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            cursor: pointer;
            transition: color 0.3s ease;
            background: none;
            border: none;
            font-size: 1rem;
        }

        .input-icon:hover {
            color: var(--light);
        }

        /* Remember & Forgot */
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.8rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--gray);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .remember-me input {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 1rem;
            border-radius: 1rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-family: 'Instrument Sans', sans-serif;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--glass-border);
        }

        .divider span {
            background: rgba(30, 35, 50, 0.85);
            padding: 0 1.2rem;
            position: relative;
            z-index: 1;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 0.3rem;
        }

        .register-link a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        /* Alerts & Messages */
        .alert {
            padding: 1rem 1.2rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .error-message {
            color: #fca5a5;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
            line-height: 1.4;
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

        /* Responsive Design - FIXED MOBILE SPACING */
        @media (max-width: 768px) {
            body {
                padding: 0.5rem;
                align-items: flex-start;
                min-height: 100vh;
                display: flex;
            }
            
            .back-home {
                top: 1rem;
                left: 1rem;
                font-size: 0.85rem;
                padding: 0.5rem 0.9rem;
            }
            
            .container {
                max-width: 100%;
                margin: 0;
                border-radius: 1.5rem;
                height: fit-content;
                min-height: auto;
            }
            
            .content {
                padding: 2rem 1.5rem;
            }
            
            .logo {
                margin-bottom: 2rem;
            }
            
            .logo-text {
                font-size: 2rem;
            }
            
            .form-header {
                margin-bottom: 1.5rem;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
            
            .form-subtitle {
                font-size: 0.9rem;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-input {
                padding: 0.9rem 1.1rem;
                font-size: 0.9rem;
            }
            
            .btn {
                padding: 0.9rem;
                font-size: 0.9rem;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
                margin-bottom: 1.25rem;
            }
            
            .divider {
                margin: 1.5rem 0;
            }
            
            .register-link {
                margin-top: 1.5rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
                align-items: center;
            }
            
            .content {
                padding: 1.5rem 1.25rem;
            }
            
            .back-home {
                top: 0.8rem;
                left: 0.8rem;
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
            
            .logo {
                margin-bottom: 1.5rem;
            }
            
            .logo-text {
                font-size: 1.8rem;
            }
            
            .logo-subtitle {
                font-size: 0.9rem;
            }
            
            .form-header {
                margin-bottom: 1.25rem;
            }
            
            .form-title {
                font-size: 1.4rem;
            }
            
            .form-subtitle {
                font-size: 0.85rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .form-input {
                padding: 0.8rem 1rem;
            }
            
            .btn {
                padding: 0.85rem;
            }
            
            .remember-forgot {
                margin-bottom: 1rem;
            }
            
            .divider {
                margin: 1.25rem 0;
            }
            
            .register-link {
                margin-top: 1.25rem;
            }
        }

        @media (max-width: 360px) {
            .content {
                padding: 1.25rem 1rem;
            }
            
            .back-home {
                top: 0.5rem;
                left: 0.5rem;
            }
            
            .logo-text {
                font-size: 1.6rem;
            }
            
            .form-title {
                font-size: 1.3rem;
            }
        }

        /* Focus styles for accessibility */
        .btn:focus-visible,
        .form-input:focus-visible,
        .back-home:focus-visible,
        .forgot-password:focus-visible,
        .input-icon:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation"></div>

    <!-- Back to Home - IN BACKGROUND -->
    <a href="{{ url('/') }}" class="back-home animate-fade-in">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <div class="container">
        <div class="content">
            <div class="logo animate-fade-in" style="animation-delay: 0.1s;">
                <div class="logo-text">InventoryPro</div>
                <div class="logo-subtitle">Enterprise Inventory Management</div>
            </div>

            <div class="form-header animate-fade-in" style="animation-delay: 0.2s;">
                <h1 class="form-title">Welcome Back</h1>
                <p class="form-subtitle">Sign in to your account to continue</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success animate-fade-in" style="animation-delay: 0.3s;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group animate-fade-in" style="animation-delay: 0.3s;">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="form-input" placeholder="Enter your email">
                    @error('email')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group animate-fade-in" style="animation-delay: 0.4s;">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-with-icon">
                        <input id="password" type="password" name="password" required 
                               class="form-input" placeholder="Enter your password">
                        <button type="button" class="input-icon" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="remember-forgot animate-fade-in" style="animation-delay: 0.5s;">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary animate-fade-in" style="animation-delay: 0.6s;">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="register-link animate-fade-in" style="animation-delay: 0.7s;">
                Don't have an account? <a href="{{ route('register') }}">Create one here</a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            
            // Update aria-label for accessibility
            const isVisible = type === 'text';
            this.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');
        });

        // Add loading state to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
            submitButton.disabled = true;
            
            // Revert after 3 seconds if form doesn't submit (fallback)
            setTimeout(() => {
                if (submitButton.disabled) {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            }, 3000);
        });

        // Auto-focus email field on page load
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                setTimeout(() => emailField.focus(), 400);
            }
        });

        // Add input validation styles
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>
</body>
</html>