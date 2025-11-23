<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventory System')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📦</text></svg>">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        :root {
            --primary-blue: #0066ff;
            --primary-dark: #0044cc;
            --accent-cyan: #00d4ff;
            --accent-purple: #8b5cf6;
            --security-green: #10b981;
            --dark-bg: #0a0f1c;
            --darker-bg: #050811;
            --card-bg: rgba(16, 23, 41, 0.6);
            --card-border: rgba(255, 255, 255, 0.12);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--darker-bg);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Effects - SAMA PERSIS dengan welcome page */
        #universeCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            display: block;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
        }

        /* Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-cyan));
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
            position: relative;
        }

        /* Sidebar - Clean Theme */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(10, 15, 28, 0.9);
            backdrop-filter: blur(25px);
            border-right: 1px solid var(--card-border);
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
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 100%;
            left: -20%;
            top: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shine 3s infinite linear;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Toggle Button */
        .toggle-sidebar {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-primary);
            padding: 0.6rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: -12px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 101;
            width: 24px;
            height: 24px;
            backdrop-filter: blur(10px);
        }

        .toggle-sidebar:hover {
            background: rgba(0, 212, 255, 0.15);
            border-color: rgba(0, 212, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .sidebar.collapsed .toggle-sidebar {
            right: -12px;
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
            border: 1px solid transparent;
            font-weight: 500;
            backdrop-filter: blur(5px);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-primary);
            border-color: rgba(0, 212, 255, 0.2);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: var(--text-primary);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
            border-color: rgba(0, 212, 255, 0.4);
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
            position: relative;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* Top Bar */
        .top-bar {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--card-border);
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
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-primary);
            padding: 0.75rem;
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            flex-shrink: 0;
            backdrop-filter: blur(10px);
        }

        .mobile-menu-toggle:hover {
            background: rgba(0, 212, 255, 0.15);
            border-color: rgba(0, 212, 255, 0.3);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 0;
        }

        .page-title i {
            font-size: 1.25rem;
            flex-shrink: 0;
            color: var(--accent-cyan);
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
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .user-role {
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-cyan));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            border: 2px solid var(--card-border);
            flex-shrink: 0;
            backdrop-filter: blur(10px);
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
            backdrop-filter: blur(10px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: white;
            box-shadow: 0 2px 8px rgba(0, 102, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 102, 255, 0.4);
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

        /* Page Content */
        .page-content {
            animation: fadeInUp 0.6s ease-out;
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
                display: none;
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
    <!-- Background Effects - SAMA PERSIS dengan welcome page -->
    <canvas id="universeCanvas"></canvas>
    <div id="particles-js"></div>

    <!-- Loading Bar -->
    <div class="page-loader" id="pageLoader"></div>

    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar slide-in-left" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-atom"></i>
                    </div>
                    <span class="logo-text">NebulaCore</span>
                </div>
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

    <!-- Three.js and Particles.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <script>
        // Three.js Universe Background - SAMA PERSIS dengan welcome page
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            canvas: document.getElementById('universeCanvas'),
            antialias: true
        });

        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setClearColor(0x050811, 1);

        // Starfield - SAMA dengan welcome page: 20,000 bintang
        const starGeometry = new THREE.BufferGeometry();
        const starCount = 20000;
        const starPositions = new Float32Array(starCount * 3);
        const starColors = new Float32Array(starCount * 3);

        for (let i = 0; i < starCount; i++) {
            const i3 = i * 3;
            // position - SAMA dengan welcome page
            starPositions[i3] = (Math.random() - 0.5) * 2000;
            starPositions[i3 + 1] = (Math.random() - 0.5) * 2000;
            starPositions[i3 + 2] = (Math.random() - 0.5) * 2000;
            // color - SAMA dengan welcome page
            if (Math.random() > 0.9) {
                starColors[i3] = 0.7 + Math.random() * 0.3;
                starColors[i3 + 1] = 0.8 + Math.random() * 0.2;
                starColors[i3 + 2] = 1.0;
            } else {
                const brightness = 0.5 + Math.random() * 0.5;
                starColors[i3] = brightness;
                starColors[i3 + 1] = brightness;
                starColors[i3 + 2] = brightness;
            }
        }
        starGeometry.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
        starGeometry.setAttribute('color', new THREE.BufferAttribute(starColors, 3));
        const starMaterial = new THREE.PointsMaterial({
            size: 1,
            vertexColors: true,
            sizeAttenuation: true,
            transparent: true
        });
        const stars = new THREE.Points(starGeometry, starMaterial);
        scene.add(stars);

        // Nebula - SAMA dengan welcome page
        const nebulaGeometry = new THREE.SphereGeometry(50, 32, 32);
        const nebulaMaterial = new THREE.MeshBasicMaterial({ 
            color: 0x0066ff, 
            transparent: true, 
            opacity: 0.03 
        });
        const nebula = new THREE.Mesh(nebulaGeometry, nebulaMaterial);
        scene.add(nebula);

        camera.position.z = 100;

        function animateUniverse() {
            requestAnimationFrame(animateUniverse);
            // Kecepatan rotasi SAMA dengan welcome page
            stars.rotation.x += 0.00005;
            stars.rotation.y += 0.0001;
            nebula.rotation.x += 0.0002;
            nebula.rotation.y += 0.0003;
            renderer.render(scene, camera);
        }
        animateUniverse();

        // Particles.js - SAMA PERSIS dengan welcome page
        particlesJS('particles-js', {
            particles: {
                number: { 
                    value: 80,  // SAMA: 80 partikel
                    density: { 
                        enable: true, 
                        value_area: 800  // SAMA
                    } 
                },
                color: { 
                    value: "#00d4ff"  // SAMA
                },
                shape: { 
                    type: "circle"  // SAMA
                },
                opacity: { 
                    value: 0.3,  // SAMA
                    random: true,  // SAMA
                    anim: { 
                        enable: true, 
                        speed: 1,  // SAMA
                        opacity_min: 0.1,  // SAMA
                        sync: false  // SAMA
                    } 
                },
                size: { 
                    value: 3,  // SAMA
                    random: true,  // SAMA
                    anim: { 
                        enable: true, 
                        speed: 2,  // SAMA
                        size_min: 0.1,  // SAMA
                        sync: false  // SAMA
                    } 
                },
                line_linked: { 
                    enable: true,  // SAMA
                    distance: 150,  // SAMA
                    color: "#0066ff",  // SAMA
                    opacity: 0.2,  // SAMA
                    width: 1  // SAMA
                },
                move: { 
                    enable: true,  // SAMA
                    speed: 1,  // SAMA
                    direction: "none",  // SAMA
                    random: true,  // SAMA
                    straight: false,  // SAMA
                    out_mode: "out",  // SAMA
                    bounce: false  // SAMA
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: { 
                    onhover: { 
                        enable: true, 
                        mode: "repulse"  // SAMA
                    }, 
                    onclick: { 
                        enable: true, 
                        mode: "push"  // SAMA
                    }, 
                    resize: true 
                }
            },
            retina_detect: true
        });

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

        // Resize handler - SAMA dengan welcome page
        window.addEventListener('resize', function() {
            // Update Three.js dan Particles
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);

            if (window.innerWidth > 1024) {
                sidebar.classList.remove('mobile-open');
                mobileToggle.querySelector('i').classList.add('fa-bars');
                mobileToggle.querySelector('i').classList.remove('fa-times');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        });

        // Active menu highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.startsWith(href)) {
                    link.classList.add('active');
                }
            });
        });

        // Fallback untuk icon boxes
        document.addEventListener('DOMContentLoaded', function() {
            const boxIcon = document.querySelector('.logo-icon i');
            // Jika icon boxes tidak terlihat, coba icon lain
            if (boxIcon && getComputedStyle(boxIcon).display === 'none') {
                // Coba icon warehouse
                boxIcon.className = 'fas fa-warehouse';
                setTimeout(() => {
                    if (getComputedStyle(boxIcon).display === 'none') {
                        // Jika warehouse juga tidak muncul, gunakan icon cube
                        boxIcon.className = 'fas fa-cube';
                    }
                }, 100);
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>