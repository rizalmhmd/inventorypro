<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NebulaCore - Enterprise Inventory Management</title>
    
    <!-- Three.js + Effect Composer for realistic effects -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/3.9.1/chart.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0066ff;
            --primary-dark: #0044cc;
            --accent-cyan: #00d4ff;
            --accent-purple: #8b5cf6;
            --security-green: #10b981;
            --dark-bg: #0a0f1c;
            --darker-bg: #050811;
            --card-bg: rgba(16, 23, 41, 0.8);
            --card-border: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
        }
        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--darker-bg);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            line-height: 1.6;
        }
        #universeCanvas {
            position: fixed; top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: -2;
            display: block;
        }
        #particles-js {
            position: fixed; top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: -1;
        }
        .app-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--card-border);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .logo-icon::before {
            content: '';
            position: absolute;
            width: 120%; height: 100%;
            left: -20%; top: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.13), transparent);
            animation: shine 3s infinite linear;
        }
        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        .nav-link:hover { color: var(--text-primary); }
        .nav-link.active { color: var(--accent-cyan); }
        .nav-link.active::after {
            content: '';
            position: absolute; bottom: -8px; left: 0; width: 100%; height: 2px;
            background: var(--accent-cyan);
        }
        .auth-buttons { display: flex; gap: 1rem; }
        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 102, 255, 0.3);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(10px);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* HERO SECTION */
        .hero-section {
            text-align: center;
            padding: 4rem 0 2rem 0;
            position: relative;
        }
        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }
        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .cta-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem; }
        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 3rem 0;
        }
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-cyan));
        }
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.3);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent-cyan);
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 500;
        }
        /* DASHBOARD PREVIEW */
        .dashboard-preview {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 2rem;
            margin: 3rem 0;
            backdrop-filter: blur(15px);
            position: relative;
            overflow: hidden;
        }
        .dashboard-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
        }
        .dashboard-title {
            font-size: 1.5rem; font-weight: 700; color: var(--text-primary);
        }
        /* LIVE BADGE Improved */
        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--card-bg);
            border: 1px solid var(--success);
            color: var(--success);
            font-size: 0.88rem;
            font-weight: 700;
            padding: 0.32rem 1.1rem 0.32rem 0.72rem;
            border-radius: 999px;
            box-shadow: 0 1px 8px 0 rgba(16,185,129,0.07);
            position: relative;
            user-select: none;
            cursor: default;
            letter-spacing: .02em;
            transition: color 0.18s, background 0.18s, border-color 0.24s;
            outline: none;
        }
        .live-dot {
            display: inline-block;
            width: 0.8em; height: 0.8em;
            margin-right: 0.5em;
            border-radius: 999px;
            background: var(--success);
            box-shadow: 0 0 0 0 rgba(16,185,129,.7);
            animation: bubble-live-dot 1.2s infinite cubic-bezier(.55,.09,.68,.53);
            vertical-align: middle;
        }
        @keyframes bubble-live-dot {
            0% { box-shadow: 0 0 0 0 rgba(16,185,129,.7);}
            80% { box-shadow: 0 0 0 0.7em rgba(16,185,129,0);}
            100% { box-shadow: 0 0 0 0 rgba(16,185,129,0);}
        }
        .charts-grid {
            display: grid; grid-template-columns: 2fr 1fr;
            gap: 2rem; height: 300px; }
        .main-chart {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px; padding: 1.5rem; position: relative; }
        .side-stats { display: flex; flex-direction: column; gap: 1rem; }
        .metric-card {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            flex: 1;
        }
        .metric-value {
            font-size: 2rem; font-weight: 700; color: var(--accent-cyan); margin-bottom: 0.5rem;
        }
        .metric-label { color: var(--text-secondary); font-size: 0.9rem; }
        /* FEATURES */
        .features-section { margin: 4rem 0; }
        .section-title {
            font-size: 2.5rem; font-weight: 800; text-align: center; margin-bottom: 3rem;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-cyan));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 15px;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent-cyan);
            box-shadow: 0 15px 40px rgba(0, 212, 255, 0.1);
        }
        .feature-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.5rem; font-size: 1.5rem;
        }
        .feature-card.security .feature-icon {
            background: linear-gradient(135deg, var(--security-green), #059669);
        }
        .feature-title {
            font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-primary);
        }
        .feature-description {
            color: var(--text-secondary); line-height: 1.6; margin-bottom: 1.5rem;
        }
        .feature-stats { display: flex; gap: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--card-border);}
        .feature-stat { text-align: center; }
        .feature-stat-value { font-size: 1.2rem; font-weight: 700; color: var(--accent-cyan);}
        .feature-card.security .feature-stat-value { color: var(--security-green);}
        .feature-stat-label { font-size: 0.8rem; color: var(--text-secondary);}
        .security-badges { display: flex; flex-wrap: wrap; gap: 0.8rem; margin-top: 1.5rem; }
        .security-badge {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.3);
            color: var(--security-green);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex; align-items: center; gap: 0.3rem;
        }
        /* CTA */
        .cta-section {
            background: linear-gradient(135deg, rgba(0,102,255,0.10), rgba(139,92,246,0.10));
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            margin: 4rem 0;
            position: relative;
            overflow: hidden;
        }
        .cta-title {
            font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;
            background: linear-gradient(135deg,var(--text-primary),var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .cta-subtitle {
            color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2.5rem; max-width: 600px; margin: 0 auto 2.5rem auto;
        }
        /* FOOTER */
        .main-footer {
            border-top: 1px solid var(--card-border);
            padding-top: 3rem; margin-top: 4rem;
        }
        .footer-content {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem; margin-bottom: 3rem;
        }
        .footer-column h3 { color: var(--text-primary); margin-bottom:1.5rem; font-size:1.1rem; font-weight:700;}
        .footer-links { display:flex; flex-direction:column; gap:0.8rem;}
        .footer-links a { color:var(--text-secondary); text-decoration:none; transition:color 0.3s;}
        .footer-links a:hover { color:var(--accent-cyan);}
        .footer-bottom {
            border-top: 1px solid var(--card-border);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-secondary); 
            font-size: 0.9rem;
        }
        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .footer-bottom-links {
            display: flex;
            gap: 1.5rem;
        }
        .footer-bottom-links a {
            color: var(--text-secondary); 
            text-decoration: none;
            transition: color 0.3s;
            font-size: 0.85rem;
        }
        .footer-bottom-links a:hover {
            color: var(--accent-cyan);
        }
        .social-links { display: flex; gap: 1rem;}
        .social-links a { 
            color: var(--text-secondary); 
            transition: all 0.3s;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .social-links a:hover { 
            color: var(--accent-cyan);
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.3);
            transform: translateY(-2px);
        }
        /* RESPONSIVE */
        @media (max-width:1024px){
            .hero-title { font-size: 3rem;}
            .footer-content { grid-template-columns: 1fr 1fr; }
            .charts-grid { grid-template-columns: 1fr; height: auto; }
        }
        @media (max-width:768px){
            .app-container { padding: 1rem; }
            .main-nav { flex-direction: column; gap: 1.5rem;}
            .nav-links { gap: 1rem;}
            .hero-title { font-size: 2.5rem;}
            .features-grid { grid-template-columns: 1fr;}
            .footer-content { grid-template-columns: 1fr; }
            .cta-buttons { flex-direction:column; align-items:center;}
            .btn { width:100%; max-width:300px; justify-content: center;}
            .charts-grid { grid-template-columns: 1fr; }
            
            /* FOOTER MOBILE IMPROVEMENT */
            .footer-bottom {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
                padding: 1.5rem 0 0 0;
            }
            .footer-bottom-content {
                flex-direction: column;
                gap: 1.5rem;
            }
            .footer-bottom-links {
                order: -1;
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }
            .footer-bottom-links a {
                padding: 0.5rem 1rem;
                background: rgba(255, 255, 255, 0.05);
                border-radius: 6px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
                font-size: 0.8rem;
            }
            .footer-bottom-links a:hover {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(255, 255, 255, 0.2);
            }
            .footer-copyright {
                font-size: 0.85rem;
                line-height: 1.5;
            }
        }
        @media (max-width:480px){
            .hero-title { font-size:2rem;}
            .stats-grid { grid-template-columns:1fr;}
            .feature-card {padding:2rem 1.5rem;}
            .security-badges { justify-content:center;}
            
            /* FOOTER MOBILE FIX - HORIZONTAL LAYOUT */
            .footer-content {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }
            .footer-column {
                text-align: center;
            }
            .footer-links {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }
            .footer-links a {
                padding: 0.5rem 1rem;
                background: rgba(255, 255, 255, 0.05);
                border-radius: 6px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
                font-size: 0.85rem;
            }
            .footer-links a:hover {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(255, 255, 255, 0.2);
            }
            .social-links {
                justify-content: center;
            }
            
            /* FOOTER BOTTOM MOBILE OPTIMIZATION */
            .footer-bottom-links {
                gap: 0.8rem;
            }
            .footer-bottom-links a {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
<!-- Universe Canvas (Three.js) -->
<canvas id="universeCanvas"></canvas>

<!-- Particles.js -->
<div id="particles-js"></div>

<div class="app-container">
    <!-- NAV -->
    <nav class="main-nav">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-atom"></i>
            </div>
            <span>NebulaCore</span>
        </div>
        <div class="nav-links">
            <a href="#" class="nav-link active">Home</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#solutions" class="nav-link">Solutions</a>
            <a href="#pricing" class="nav-link">Pricing</a>
            <a href="#docs" class="nav-link">Docs</a>
        </div>
        <div class="auth-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        <i class="fas fa-sign-in-alt"></i> Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-section">
        <h1 class="hero-title">Enterprise Inventory Management Reimagined</h1>
        <p class="hero-subtitle">
            Harness the power of real-time analytics, AI-driven insights, and seamless automation 
            to transform your inventory operations across multiple locations.
        </p>
        <div class="cta-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="padding: 1.2rem 2.5rem;">
                        <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1.2rem 2.5rem;">
                        <i class="fas fa-play-circle"></i> Start Free Trial
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="padding: 1.2rem 2.5rem;">
                        <i class="fas fa-calendar"></i> Book Demo
                    </a>
                @endauth
            @endif
        </div>
    </section>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">15.8K</div>
            <div class="stat-label">Products Managed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">99.97%</div>
            <div class="stat-label">System Uptime</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">2.3M</div>
            <div class="stat-label">Daily Transactions</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">47%</div>
            <div class="stat-label">Cost Reduction</div>
        </div>
    </div>

    <!-- DASHBOARD PREVIEW -->
    <div class="dashboard-preview">
        <div class="dashboard-header">
            <h3 class="dashboard-title">Live Operations Dashboard</h3>
            <span class="live-badge" aria-live="polite" aria-label="Live data feed active">
                <span class="live-dot"></span>
                LIVE DATA
            </span>
        </div>
        <div class="charts-grid">
            <div class="main-chart">
                <canvas id="inventoryChart"></canvas>
            </div>
            <div class="side-stats">
                <div class="metric-card"><div class="metric-value" id="stockLevel">87%</div><div class="metric-label">Optimal Stock Level</div></div>
                <div class="metric-card"><div class="metric-value" id="orderVolume">1,247</div><div class="metric-label">Orders Today</div></div>
                <div class="metric-card"><div class="metric-value" id="fulfillmentRate">99.2%</div><div class="metric-label">Fulfillment Rate</div></div>
            </div>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="features-section" id="features">
        <h2 class="section-title">Powerful Features for Modern Business</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-brain"></i></div>
                <h3 class="feature-title">AI-Powered Forecasting</h3>
                <p class="feature-description">Predictive analytics and machine learning algorithms to anticipate demand, optimize stock levels, and prevent overstocking or stockouts.</p>
                <div class="feature-stats">
                    <div class="feature-stat"><div class="feature-stat-value">94%</div><div class="feature-stat-label">Accuracy</div></div>
                    <div class="feature-stat"><div class="feature-stat-value">3.2x</div><div class="feature-stat-label">Faster</div></div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-sync-alt"></i></div>
                <h3 class="feature-title">Real-time Synchronization</h3>
                <p class="feature-description">Instant updates across all platforms and locations with our distributed ledger technology ensuring data consistency and integrity.</p>
                <div class="feature-stats">
                    <div class="feature-stat"><div class="feature-stat-value">50ms</div><div class="feature-stat-label">Sync Speed</div></div>
                    <div class="feature-stat"><div class="feature-stat-value">&#8734;</div><div class="feature-stat-label">Scalability</div></div>
                </div>
            </div>
            <div class="feature-card security">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3 class="feature-title">Military-Grade Security</h3>
                <p class="feature-description">End-to-end encryption, zero-trust architecture, and compliance with global security standards including SOC 2, ISO 27001, and GDPR.</p>
                <div class="feature-stats">
                    <div class="feature-stat"><div class="feature-stat-value">256-bit</div><div class="feature-stat-label">Encryption</div></div>
                    <div class="feature-stat"><div class="feature-stat-value">99.99%</div><div class="feature-stat-label">Uptime SLA</div></div>
                </div>
                <div class="security-badges">
                    <div class="security-badge"><i class="fas fa-check-circle"></i> SOC 2 Type II</div>
                    <div class="security-badge"><i class="fas fa-check-circle"></i> ISO 27001</div>
                    <div class="security-badge"><i class="fas fa-check-circle"></i> GDPR</div>
                    <div class="security-badge"><i class="fas fa-check-circle"></i> HIPAA</div>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-robot"></i></div>
                <h3 class="feature-title">Automated Workflows</h3>
                <p class="feature-description">Streamline operations with customizable automation rules, smart notifications, and AI-driven process optimization.</p>
                <div class="feature-stats">
                    <div class="feature-stat"><div class="feature-stat-value">85%</div><div class="feature-stat-label">Time Saved</div></div>
                    <div class="feature-stat"><div class="feature-stat-value">24/7</div><div class="feature-stat-label">Automation</div></div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <section class="cta-section">
        <h2 class="cta-title">Ready to Transform Your Inventory Management?</h2>
        <p class="cta-subtitle">
            Join 10,000+ enterprises that trust NebulaCore to power their inventory operations. 
            Start your journey today with a 30-day free trial.
        </p>
        <div class="cta-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="padding: 1.2rem 3rem;">
                        <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1.2rem 3rem;">
                        <i class="fas fa-rocket"></i> Start Free Trial
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="padding: 1.2rem 3rem;">
                        <i class="fas fa-comment-dots"></i> Contact Sales
                    </a>
                @endauth
            @endif
        </div>
    </section>
    <!-- FOOTER -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>NebulaCore</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.6;">
                    Advanced inventory management solutions for enterprises seeking efficiency, 
                    scalability, and intelligent automation.
                </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Product</h3>
                <div class="footer-links">
                    <a href="#features">Features</a>
                    <a href="#solutions">Solutions</a>
                    <a href="#pricing">Pricing</a>
                    <a href="#docs">API Docs</a>
                    <a href="#integrations">Integrations</a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Resources</h3>
                <div class="footer-links">
                    <a href="#docs">Documentation</a>
                    <a href="#blog">Blog</a>
                    <a href="#case-studies">Case Studies</a>
                    <a href="#webinars">Webinars</a>
                    <a href="#help">Help Center</a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Company</h3>
                <div class="footer-links">
                    <a href="#about">About Us</a>
                    <a href="#careers">Careers</a>
                    <a href="#contact">Contact</a>
                    <a href="#partners">Partners</a>
                    <a href="#legal">Legal</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-copyright">&copy; 2024 NebulaCore Technologies. All rights reserved.</div>
                <div class="footer-bottom-links">
                    <a href="#privacy">Privacy Policy</a>
                    <a href="#terms">Terms of Service</a>
                    <a href="#cookies">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>
</div>
<script>
    // Three.js Realistic Universe
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({
        canvas: document.getElementById('universeCanvas'),
        antialias: true
    });

    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x050811, 1);

    // Starfield
    const starGeometry = new THREE.BufferGeometry();
    const starCount = 20000;
    const starPositions = new Float32Array(starCount * 3);
    const starColors = new Float32Array(starCount * 3);

    for (let i = 0; i < starCount; i++) {
        const i3 = i * 3;
        // position
        starPositions[i3] = (Math.random() - 0.5) * 2000;
        starPositions[i3 + 1] = (Math.random() - 0.5) * 2000;
        starPositions[i3 + 2] = (Math.random() - 0.5) * 2000;
        // color
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

    // Nebula
    const nebulaGeometry = new THREE.SphereGeometry(50, 32, 32);
    const nebulaMaterial = new THREE.MeshBasicMaterial({ color: 0x0066ff, transparent: true, opacity: 0.03 });
    const nebula = new THREE.Mesh(nebulaGeometry, nebulaMaterial);
    scene.add(nebula);

    camera.position.z = 100;

    function animateUniverse() {
        requestAnimationFrame(animateUniverse);
        stars.rotation.x += 0.00005;
        stars.rotation.y += 0.0001;
        nebula.rotation.x += 0.0002;
        nebula.rotation.y += 0.0003;
        renderer.render(scene, camera);
    }
    animateUniverse();

    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // Particles.js
    particlesJS('particles-js', {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: "#00d4ff" },
            shape: { type: "circle" },
            opacity: { value: 0.3, random: true, anim: { enable: true, speed: 1, opacity_min: 0.1, sync: false } },
            size: { value: 3, random: true, anim: { enable: true, speed: 2, size_min: 0.1, sync: false } },
            line_linked: { enable: true, distance: 150, color: "#0066ff", opacity: 0.2, width: 1 },
            move: { enable: true, speed: 1, direction: "none", random: true, straight: false, out_mode: "out", bounce: false }
        },
        interactivity: {
            detect_on: "canvas",
            events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true }
        },
        retina_detect: true
    });

    // Chart.js
    const ctx = document.getElementById('inventoryChart').getContext('2d');
    const inventoryChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Inventory Turnover',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 60, 75, 82, 78],
                borderColor: '#00d4ff',
                backgroundColor: 'rgba(0, 212, 255, 0.1)',
                borderWidth: 2, fill: true, tension: 0.4
            }, {
                label: 'Stock Level',
                data: [28, 48, 40, 19, 86, 27, 90, 65, 59, 80, 81, 56],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 2, fill: true, tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { labels: { color: '#94a3b8' } } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.1)' }, ticks: { color: '#94a3b8' } },
                x: { grid: { color: 'rgba(255, 255, 255, 0.1)' }, ticks: { color: '#94a3b8' } }
            }
        }
    });

    // Simulate real-time metric updates
    function updateMetrics() {
        const stockLevel = document.getElementById('stockLevel');
        const orderVolume = document.getElementById('orderVolume');
        const fulfillmentRate = document.getElementById('fulfillmentRate');
        setInterval(() => {
            stockLevel.textContent = (85 + Math.random() * 4).toFixed(0) + '%';
            orderVolume.textContent = (1247 + Math.floor(Math.random() * 20)).toLocaleString();
            fulfillmentRate.textContent = (99.0 + Math.random() * 0.4).toFixed(1) + '%';
        }, 3000);
    }
    updateMetrics();

    // GSAP Entrance Animations
    gsap.from('.logo', { duration: 1, y: -50, opacity: 0, ease: 'power3.out' });
    gsap.from('.nav-links a', { duration: 0.8, y: -30, opacity: 0, stagger: 0.1, delay: 0.5, ease: 'power3.out' });
    gsap.from('.hero-title', { duration: 1.2, y: 50, opacity: 0, delay: 0.8, ease: 'power3.out' });
    gsap.from('.stat-card', { duration: 1, y: 30, opacity: 0, stagger: 0.2, delay: 1.2, ease: 'power3.out' });
    gsap.from('.feature-card', {
        duration: 1,
        y: 50,
        opacity: 0,
        stagger: 0.3,
        scrollTrigger: {
            trigger: '.features-section',
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse'
        }
    });
    gsap.from('.security-badge', {
        duration: 0.6,
        scale: 0,
        opacity: 0,
        stagger: 0.2,
        delay: 2,
        ease: 'back.out(1.7)'
    });
</script>
</body>
</html>