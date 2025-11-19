<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InventoryPro - Enterprise Inventory Management</title>
    
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
            --accent-dark: #d97706;
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

        /* Animated background */
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

        /* Main Container */
        .container {
            max-width: 1200px;
            width: 100%;
            background: rgba(30, 35, 50, 0.7);
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

        /* Header */
        .auth-header {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: 1rem;
            z-index: 10;
        }

        /* Main Content */
        .content {
            padding: 4rem 3rem;
            text-align: center;
            position: relative;
        }

        .content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        /* Logo & Typography */
        .logo {
            font-size: 4rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--light) 0%, var(--primary) 50%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
            position: relative;
            display: inline-block;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            border-radius: 2px;
        }

        .tagline {
            color: var(--gray);
            font-size: 1.3rem;
            margin-bottom: 1rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .description {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            line-height: 1.7;
            font-size: 1.2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Buttons */
        .btn {
            padding: 1rem 2.5rem;
            border-radius: 1rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-outline {
            background: var(--glass);
            color: white;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        /* Auth Buttons */
        .btn-auth {
            padding: 0.8rem 1.5rem;
            font-size: 0.9rem;
            border-radius: 0.8rem;
        }

        .btn-login {
            background: var(--glass);
            color: white;
            border: 1px solid var(--glass-border);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-register {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            color: white;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, var(--secondary-dark), #047857);
        }

        .btn-dashboard {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
        }

        .btn-dashboard:hover {
            background: linear-gradient(135deg, var(--accent-dark), #b45309);
        }

        /* CTA Section */
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin: 2.5rem 0;
        }

        /* Stats */
        .stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 2.5rem 0;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            line-height: 1;
        }

        .stat-label {
            color: var(--gray);
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
            padding: 0 1rem;
        }

        .feature-card {
            background: var(--glass);
            padding: 2rem 1.5rem;
            border-radius: 1.2rem;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: white;
        }

        .feature-desc {
            color: var(--gray);
            line-height: 1.6;
            font-size: 1rem;
        }

        /* Footer */
        .footer {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--glass-border);
            color: var(--gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: white;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content {
                padding: 3rem 2rem;
            }
            
            .logo {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 2.5rem 1.5rem;
            }
            
            .auth-header {
                position: static;
                justify-content: center;
                margin-bottom: 2rem;
            }
            
            .logo {
                font-size: 3rem;
            }
            
            .tagline {
                font-size: 1.2rem;
            }
            
            .description {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 280px;
            }
            
            .features {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .stats {
                gap: 1rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .footer {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-links {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 2rem 1rem;
            }
            
            .logo {
                font-size: 2.5rem;
            }
            
            .feature-card {
                padding: 1.5rem 1rem;
            }
            
            .stats {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation"></div>

    <div class="container">
        <!-- Auth Header -->
        <div class="auth-header animate-fade-in">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-auth btn-dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-auth btn-login">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-auth btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-auth btn-register">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Hero Section -->
            <div class="logo animate-fade-in" style="animation-delay: 0.1s;">InventoryPro</div>
            <div class="tagline animate-fade-in" style="animation-delay: 0.2s;">Enterprise Inventory Management System</div>
            <p class="description animate-fade-in" style="animation-delay: 0.3s;">
                Streamline your inventory management with our powerful, intuitive system. 
                Track products, manage stock levels, and generate insightful reports - all in one place.
            </p>
            
            <!-- Stats -->
            <div class="stats animate-fade-in" style="animation-delay: 0.4s;">
                <div class="stat-item">
                    <span class="stat-number">10K+</span>
                    <div class="stat-label">Products Managed</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <div class="stat-label">Businesses Trust Us</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">99.9%</span>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
            
            <!-- Features -->
            <div class="features animate-fade-in" style="animation-delay: 0.5s;">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                    <h3 class="feature-title">Stock Management</h3>
                    <p class="feature-desc">Track inventory levels, set reorder points, and manage stock across multiple locations</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h3 class="feature-title">Analytics & Reports</h3>
                    <p class="feature-desc">Gain insights with detailed reports on sales, stock movement, and profitability</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-barcode"></i></div>
                    <h3 class="feature-title">Barcode Integration</h3>
                    <p class="feature-desc">Easily scan and track items with barcode support for efficient inventory management</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users-cog"></i></div>
                    <h3 class="feature-title">Multi-User Access</h3>
                    <p class="feature-desc">Collaborate with your team with role-based permissions and access controls</p>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            @guest
            <div class="cta-buttons animate-fade-in" style="animation-delay: 0.6s;">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-rocket"></i> Get Started Free
                </a>
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </a>
            </div>
            @endguest
            
            <!-- Footer -->
            <div class="footer animate-fade-in" style="animation-delay: 0.7s;">
                <div class="copyright">
                    &copy; 2024 InventoryPro. All rights reserved.
                </div>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Support</a>
                    <a href="#">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>