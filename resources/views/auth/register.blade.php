<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - NebulaCore</title>
    
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
            --card-bg: rgba(16, 23, 41, 0.6);
            --card-border: rgba(255, 255, 255, 0.15);
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
            background: rgba(16, 23, 41, 0.5);
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
            max-width: 500px;
            width: 100%;
            background: rgba(16, 23, 41, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
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
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-cyan);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.15);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: var(--text-secondary);
        }

        /* Password Requirements - More Transparent */
        .password-requirements {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.25rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .password-requirements h4 {
            margin-bottom: 0.8rem;
            color: var(--text-primary);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .requirements-list {
            list-style: none;
            color: var(--text-secondary);
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .requirements-list li {
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }

        .requirements-list li.valid {
            color: var(--success);
        }

        .requirements-list li::before {
            content: '•';
            color: var(--accent-cyan);
            font-weight: bold;
        }

        .requirements-list li.valid::before {
            content: '✓';
            color: var(--success);
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

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .login-link a {
            color: var(--accent-cyan);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 0.3rem;
        }

        .login-link a:hover {
            color: var(--primary-blue);
            text-decoration: underline;
        }

        /* Alerts & Messages - More Transparent */
        .alert {
            padding: 1rem 1.2rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            font-size: 0.9rem;
            line-height: 1.5;
            backdrop-filter: blur(5px);
        }

        .alert ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert li {
            margin-bottom: 0.3rem;
        }

        .alert li:last-child {
            margin-bottom: 0;
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
                background: rgba(16, 23, 41, 0.35);
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
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-input {
                padding: 0.9rem 1.1rem;
                font-size: 0.9rem;
            }
            
            .password-requirements {
                padding: 1rem;
                margin-bottom: 1.25rem;
            }
            
            .btn {
                padding: 0.9rem;
                font-size: 0.9rem;
            }
            
            .login-link {
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
            
            .password-requirements {
                margin-bottom: 1rem;
            }
            
            .login-link {
                margin-top: 1.25rem;
            }
        }

        /* Focus styles for accessibility */
        .btn:focus-visible,
        .form-input:focus-visible,
        .back-home:focus-visible,
        .login-link a:focus-visible {
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
                <h1 class="form-title">Create Account</h1>
                <p class="form-subtitle">Join us to manage your inventory efficiently</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert animate-fade-in" style="animation-delay: 0.3s;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group animate-fade-in" style="animation-delay: 0.3s;">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                               class="form-input" placeholder="Enter your full name">
                        @error('name')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group animate-fade-in" style="animation-delay: 0.4s;">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                               class="form-input" placeholder="Enter your email">
                        @error('email')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="password-requirements animate-fade-in" style="animation-delay: 0.5s;">
                    <h4>Password Requirements:</h4>
                    <ul class="requirements-list">
                        <li id="req-length">Minimum 8 characters</li>
                        <li id="req-uppercase">At least one uppercase letter</li>
                        <li id="req-number">At least one number</li>
                        <li id="req-special">At least one special character</li>
                    </ul>
                </div>

                <div class="form-row">
                    <div class="form-group animate-fade-in" style="animation-delay: 0.6s;">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" required 
                               class="form-input" placeholder="Create a password">
                        @error('password')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group animate-fade-in" style="animation-delay: 0.7s;">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                               class="form-input" placeholder="Confirm your password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary animate-fade-in" style="animation-delay: 0.8s;">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <div class="login-link animate-fade-in" style="animation-delay: 0.9s;">
                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
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

        // Particles.js
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

        // Add loading state to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
            submitButton.disabled = true;
            
            // Revert after 3 seconds if form doesn't submit (fallback)
            setTimeout(() => {
                if (submitButton.disabled) {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            }, 3000);
        });

        // Auto-focus name field on page load
        document.addEventListener('DOMContentLoaded', function() {
            const nameField = document.getElementById('name');
            if (nameField && !nameField.value) {
                setTimeout(() => nameField.focus(), 400);
            }
        });

        // Password strength indicator
        document.getElementById('password')?.addEventListener('input', function() {
            const password = this.value;
            const requirements = {
                length: document.getElementById('req-length'),
                uppercase: document.getElementById('req-uppercase'),
                number: document.getElementById('req-number'),
                special: document.getElementById('req-special')
            };
            
            // Validation checks
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Update visual feedback
            updateRequirement(requirements.length, hasMinLength);
            updateRequirement(requirements.uppercase, hasUppercase);
            updateRequirement(requirements.number, hasNumber);
            updateRequirement(requirements.special, hasSpecial);
        });

        function updateRequirement(element, isValid) {
            if (isValid) {
                element.classList.add('valid');
            } else {
                element.classList.remove('valid');
            }
        }

        // GSAP Entrance Animations
        gsap.from('.logo', { duration: 1, y: -30, opacity: 0, ease: 'power3.out', delay: 0.2 });
        gsap.from('.form-header', { duration: 1, y: 20, opacity: 0, ease: 'power3.out', delay: 0.4 });
        gsap.from('.form-group', { duration: 0.8, y: 20, opacity: 0, stagger: 0.1, delay: 0.6, ease: 'power3.out' });
        gsap.from('.password-requirements', { duration: 0.8, y: 20, opacity: 0, delay: 0.8, ease: 'power3.out' });
        gsap.from('.btn', { duration: 0.8, y: 20, opacity: 0, delay: 1, ease: 'power3.out' });
        gsap.from('.login-link', { duration: 0.8, y: 20, opacity: 0, delay: 1.2, ease: 'power3.out' });
    </script>
</body>
</html>