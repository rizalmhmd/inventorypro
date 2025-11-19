<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'InventoryPro')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📦</text></svg>">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-light: #a78bfa;
            --secondary: #06b6d4;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
            --dark: #1a1f36;
            --darker: #0f1322;
            --light: #f8fafc;
            --gray: #94a3b8;
            --glass: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.12);
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, var(--darker) 0%, var(--dark) 50%, #2d3748 100%);
            color: var(--light);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            z-index: 9999;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .page-loader.loaded {
            transform: scaleX(1);
        }

        /* Main Layout */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar - TOGGLEABLE */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(15, 19, 34, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            padding: 1.5rem 1rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar.collapsed .nav-title {
            display: none;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.875rem;
        }

        .sidebar.collapsed .nav-link i {
            margin: 0;
            font-size: 1.2rem;
        }

        .sidebar-header {
            margin-bottom: 2rem;
            padding: 0 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--light) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .logo-icon {
            font-size: 1.75rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* TOGGLE BUTTON - POSISI DIKOREKSI */
        .toggle-sidebar {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            color: var(--light);
            padding: 0.6rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: -12px; /* Digeser lebih ke kanan */
            top: 50%;
            transform: translateY(-50%);
            z-index: 101;
            width: 24px;
            height: 24px;
        }

        .toggle-sidebar:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-50%) scale(1.1);
        }

        .sidebar.collapsed .toggle-sidebar {
            right: -12px; /* Tetap di posisi yang sama saat collapsed */
            transform: translateY(-50%) rotate(180deg);
        }

        .sidebar.collapsed .toggle-sidebar:hover {
            transform: translateY(-50%) rotate(180deg) scale(1.1);
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
            margin-bottom: 1rem;
            padding: 0 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            color: var(--gray);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
            border: 1px solid transparent;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--glass);
            color: var(--light);
            border-color: var(--glass-border);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--light);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
            border-color: var(--primary-light);
        }

        .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* Top Bar */
        .top-bar {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 0;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-shrink: 0;
        }

        .mobile-menu-toggle {
            display: none;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            color: var(--light);
            padding: 0.75rem;
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .mobile-menu-toggle:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--light), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 0;
        }

        .page-title i {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .page-title-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: var(--light);
            font-size: 0.95rem;
        }

        .user-role {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            border: 2px solid var(--glass-border);
            flex-shrink: 0;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.4);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.75rem;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.25);
            transform: translateY(-1px);
        }

        .btn-logout .logout-text {
            display: none;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
                width: var(--sidebar-width);
            }

            .sidebar.mobile-open.collapsed {
                width: var(--sidebar-width);
            }

            .sidebar.mobile-open .logo-text {
                display: block;
            }

            .sidebar.mobile-open .nav-title {
                display: block;
            }

            .sidebar.mobile-open .nav-link span {
                display: block;
            }

            .sidebar.mobile-open .nav-link {
                justify-content: flex-start;
                padding: 0.875rem 1rem;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .main-content.expanded {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .toggle-sidebar {
                display: none; /* Sembunyikan di mobile */
            }
        }

        @media (max-width: 768px) {
            .top-bar {
                flex-direction: row;
                gap: 0.75rem;
                padding: 1rem;
            }

            .top-bar-left {
                flex: 1;
                min-width: 0;
            }

            .top-bar-right {
                flex-shrink: 0;
            }

            .page-title {
                font-size: 1.25rem;
                flex: 1;
                min-width: 0;
            }

            .page-title i {
                font-size: 1.1rem;
            }

            .user-menu {
                gap: 0.5rem;
            }

            .user-info {
                display: none;
            }

            .btn-logout {
                width: 42px;
                height: 42px;
                padding: 0;
            }

            .btn-logout .logout-text {
                display: none;
            }

            .btn-logout i {
                margin: 0;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .top-bar {
                padding: 0.875rem;
                border-radius: 0.75rem;
            }

            .page-title {
                font-size: 1.1rem;
            }

            .page-title i {
                font-size: 1rem;
            }

            .mobile-menu-toggle {
                padding: 0.625rem;
                font-size: 1rem;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }

            .btn-logout {
                width: 36px;
                height: 36px;
                padding: 0;
            }
        }

        @media (max-width: 360px) {
            .top-bar {
                flex-wrap: nowrap;
            }

            .page-title {
                font-size: 1rem;
            }

            .page-title i {
                display: none;
            }
        }

        /* Animation */
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

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in-left {
            animation: slideInLeft 0.4s ease-out;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Loading Bar -->
    <div class="page-loader" id="pageLoader"></div>

    <div class="app-layout">
        <!-- Sidebar - NOW TOGGLEABLE -->
        <aside class="sidebar slide-in-left" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-boxes logo-icon"></i>
                    <span class="logo-text">InventoryPro</span>
                </div>
                <!-- TOGGLE BUTTON - NOW POSITIONED TO THE RIGHT -->
                <div class="toggle-sidebar" id="toggleSidebar" title="Toggle Sidebar">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-title">Main Menu</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span>Products</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-title">Inventory</div>
                    <a href="{{ route('stock.in.form') }}" class="nav-link {{ request()->routeIs('stock.in.*') ? 'active' : '' }}">
                        <i class="fas fa-arrow-down"></i>
                        <span>Stock In</span>
                    </a>
                    <a href="{{ route('stock.out.form') }}" class="nav-link {{ request()->routeIs('stock.out.*') ? 'active' : '' }}">
                        <i class="fas fa-arrow-up"></i>
                        <span>Stock Out</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-title">Reports & Settings</div>
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Top Bar -->
            <div class="top-bar fade-in-up">
                <div class="top-bar-left">
                    <div class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </div>
                    
                    <h1 class="page-title">
                        <i class="fas @yield('title-icon', 'fa-tachometer-alt')"></i>
                        <span class="page-title-text">@yield('page-title', 'Dashboard')</span>
                    </h1>
                </div>
                
                <div class="top-bar-right">
                    <div class="user-menu">
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">Administrator</div>
                        </div>
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-logout" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="logout-text">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content fade-in-up">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('pageLoader');
            loader.classList.add('loaded');
            
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 300);
            }, 800);
        });

        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });

        // Desktop sidebar toggle
        const toggleSidebar = document.getElementById('toggleSidebar');
        
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });

        // Load sidebar state from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth > 1024) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !mobileToggle.contains(event.target)) {
                    sidebar.classList.remove('mobile-open');
                    mobileToggle.querySelector('i').classList.add('fa-bars');
                    mobileToggle.querySelector('i').classList.remove('fa-times');
                }
            }
        });

        // Active menu highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.startsWith(href.replace(route('dashboard'), ''))) {
                    link.classList.add('active');
                }
            });
        });

        // Resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('mobile-open');
                mobileToggle.querySelector('i').classList.add('fa-bars');
                mobileToggle.querySelector('i').classList.remove('fa-times');
            } else {
                // On mobile, ensure sidebar is not collapsed
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>