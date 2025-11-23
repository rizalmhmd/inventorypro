<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - NebulaCore</title>
    
    <!-- Three.js + Effect Composer for realistic effects -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #0066ff;
            --primary-dark: #0044cc;
            --accent-cyan: #00d4ff;
            --accent-purple: #8b5cf6;
            --security-green: #10b981;
            --dark-bg: #0a0f1c;
            --darker-bg: #050811;
            --card-bg: rgba(16, 23, 41, 0.6); /* More transparent */
            --card-border: rgba(255, 255, 255, 0.15); /* Slightly more visible */
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--darker-bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Universe Canvas */
        #universeCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            display: block;
        }

        /* Particles.js */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
        }

        /* Back Home Link */
        .back-home {
            position: fixed;
            top: 2rem;
            left: 2rem;
            color: var(--text-secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
            border-radius: 0.8rem;
            background: rgba(16, 23, 41, 0.5); /* More transparent */
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            font-weight: 500;
            z-index: 10;
        }

        .back-home:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Main Container - More Transparent */
        .container {
            max-width: 440px;
            width: 100%;
            background: rgba(16, 23, 41, 0.4); /* More transparent */
            backdrop-filter: blur(20px); /* Slightly less blur for more transparency */
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.2), /* Softer shadow */
                inset 0 1px 0 rgba(255, 255, 255, 0.08); /* Softer inner shadow */
            border: 1px solid rgba(255, 255, 255, 0.12); /* More transparent border */
            position: relative;
            z-index: 1;
        }

        /* Content */
        .content {
            padding: 3rem 2.5rem;
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 100%;
            left: -20%;
            top: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.13), transparent);
            animation: shine 3s infinite linear;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .logo-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            line-height: 1.2;
        }

        .logo-subtitle {
            color: var(--text-secondary);
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
            color: var(--text-primary);
            line-height: 1.3;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Form Elements - More Transparent */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.2rem;
            background: rgba(255, 255, 255, 0.05); /* More transparent */
            border: 1px solid rgba(255, 255, 255, 0.1); /* More transparent */
            border-radius: 1rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px); /* Less blur */
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-cyan);
            background: rgba(255, 255, 255, 0.08); /* Slightly less transparent on focus */
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.15);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: var(--text-secondary);
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease;
            background: none;
            border: none;
            font-size: 1rem;
        }

        .input-icon:hover {
            color: var(--text-primary);
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
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .remember-me input {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: var(--accent-cyan);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--accent-cyan);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: var(--primary-blue);
            text-decoration: underline;
        }

        /* Buttons - Keep solid for better UX */
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            font-family: 'Inter', sans-serif;
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
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 102, 255, 0.4);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.1); /* More transparent */
        }

        .divider span {
            background: rgba(16, 23, 41, 0.4); /* Match container background */
            padding: 0 1.2rem;
            position: relative;
            z-index: 1;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .register-link a {
            color: var(--accent-cyan);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 0.3rem;
        }

        .register-link a:hover {
            color: var(--primary-blue);
            text-decoration: underline;
        }

        /* Alerts & Messages - More Transparent */
        .alert {
            padding: 1rem 1.2rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            background: rgba(239, 68, 68, 0.08); /* More transparent */
            border: 1px solid rgba(239, 68, 68, 0.2); /* More transparent */
            color: #fca5a5;
            font-size: 0.9rem;
            line-height: 1.5;
            backdrop-filter: blur(5px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.08); /* More transparent */
            border: 1px solid rgba(16, 185, 129, 0.2); /* More transparent */
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

        /* Responsive Design */
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
                background: rgba(16, 23, 41, 0.35); /* Slightly more transparent on mobile */
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

        /* Focus styles for accessibility */
        .btn:focus-visible,
        .form-input:focus-visible,
        .back-home:focus-visible,
        .forgot-password:focus-visible,
        .input-icon:focus-visible {
            outline: 2px solid var(--accent-cyan);
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
    <!-- Universe Canvas (Three.js) -->
    <canvas id="universeCanvas"></canvas>

    <!-- Particles.js -->
    <div id="particles-js"></div>

    <!-- Back to Home -->
    <a href="{{ url('/') }}" class="back-home animate-fade-in">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <div class="container">
        <div class="content">
            <div class="logo animate-fade-in" style="animation-delay: 0.1s;">
                <div class="logo-icon">
                    <i class="fas fa-atom"></i>
                </div>
                <div class="logo-text">NebulaCore</div>
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
        const starCount = 15000;
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

        // Particles.js - Increase particles for better visibility
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#00d4ff" },
                shape: { type: "circle" },
                opacity: { value: 0.4, random: true, anim: { enable: true, speed: 1, opacity_min: 0.2, sync: false } },
                size: { value: 3, random: true, anim: { enable: true, speed: 2, size_min: 0.1, sync: false } },
                line_linked: { enable: true, distance: 150, color: "#0066ff", opacity: 0.3, width: 1 },
                move: { enable: true, speed: 1, direction: "none", random: true, straight: false, out_mode: "out", bounce: false }
            },
            interactivity: {
                detect_on: "canvas",
                events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true }
            },
            retina_detect: true
        });

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

        // GSAP Entrance Animations
        gsap.from('.logo', { duration: 1, y: -30, opacity: 0, ease: 'power3.out', delay: 0.2 });
        gsap.from('.form-header', { duration: 1, y: 20, opacity: 0, ease: 'power3.out', delay: 0.4 });
        gsap.from('.form-group', { duration: 0.8, y: 20, opacity: 0, stagger: 0.1, delay: 0.6, ease: 'power3.out' });
        gsap.from('.btn', { duration: 0.8, y: 20, opacity: 0, delay: 1, ease: 'power3.out' });
        gsap.from('.register-link', { duration: 0.8, y: 20, opacity: 0, delay: 1.2, ease: 'power3.out' });
    </script>
</body>
</html>