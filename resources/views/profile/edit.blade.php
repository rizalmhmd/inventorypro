<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - Inventory System</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
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

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }

        /* Header */
        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 0.75rem;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .back-button:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .profile-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .profile-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Profile Grid */
        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 1.5rem;
        }

        /* Sidebar */
        .profile-sidebar {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid var(--card-border);
            height: fit-content;
            position: relative;
            overflow: hidden;
        }

        .profile-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-cyan));
        }

        .user-card {
            text-align: center;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            border: 4px solid var(--card-border);
            position: relative;
            overflow: hidden;
        }

        .user-avatar::before {
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

        .user-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .user-role {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .user-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 212, 255, 0.3);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.3rem;
        }

        /* Main Content */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .profile-section {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .profile-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-cyan));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-section:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 212, 255, 0.3);
            box-shadow: 0 15px 40px rgba(0, 212, 255, 0.1);
        }

        .profile-section:hover::before {
            opacity: 1;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .section-description {
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
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

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .input-icon:hover {
            color: var(--text-primary);
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
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
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

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-primary);
            border: 1px solid var(--card-border);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-blue);
        }

        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
            color: #10b981;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
            color: #f59e0b;
        }

        /* Danger Zone */
        .danger-zone {
            border-left: 4px solid #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        .danger-zone::before {
            background: linear-gradient(90deg, #ef4444, #dc2626) !important;
            opacity: 1 !important;
        }

        .danger-title {
            color: #ef4444;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-sidebar {
                order: 2;
            }
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem;
            }
            
            .profile-title {
                font-size: 2rem;
            }
            
            .profile-section {
                padding: 1.5rem;
            }
            
            .section-header {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
            }
            
            .user-stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .profile-title {
                font-size: 1.75rem;
            }
            
            .profile-section {
                padding: 1.25rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .user-avatar {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }
        }

        /* Touch improvements for mobile */
        @media (hover: none) {
            .btn:hover,
            .back-button:hover,
            .profile-section:hover,
            .stat-item:hover {
                transform: none;
            }
            
            .btn:active,
            .back-button:active {
                transform: scale(0.98);
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

        .profile-section {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .profile-section:nth-child(1) { animation-delay: 0.1s; }
        .profile-section:nth-child(2) { animation-delay: 0.2s; }
        .profile-section:nth-child(3) { animation-delay: 0.3s; }
        .profile-sidebar { animation-delay: 0.4s; }

        /* Modal Styles */
        dialog {
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            padding: 2rem;
            color: var(--text-primary);
            max-width: 500px;
            width: 90%;
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>

    <!-- Background Effects - SAMA PERSIS dengan welcome page -->
    <canvas id="universeCanvas"></canvas>
    <div id="particles-js"></div>

    <div class="profile-container">
        <!-- Header -->
        <div class="profile-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="profile-title">Profile Settings</h1>
            <p class="profile-subtitle">Manage your account settings and preferences</p>
        </div>

        <div class="profile-grid">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="user-card">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h2 class="user-name">{{ Auth::user()->name }}</h2>
                    <p class="user-role">Inventory Manager</p>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">
                        <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>{{ Auth::user()->email }}
                    </p>
                    
                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Products Added</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">5</div>
                            <div class="stat-label">This Month</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="profile-content">
                <!-- Profile Information -->
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Profile Information</h2>
                            <p class="section-description">Update your account's profile information and email address</p>
                        </div>
                    </div>

                    <!-- Session Status -->
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>Profile updated successfully!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   class="form-input" required autofocus autocomplete="name">
                            @error('name')
                                <div style="color: var(--error); font-size: 0.8rem; margin-top: 0.5rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="form-input" required autocomplete="email">
                            @error('email')
                                <div style="color: var(--error); font-size: 0.8rem; margin-top: 0.5rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="profile-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h2 class="section-title">Update Password</h2>
                            <p class="section-description">Ensure your account is using a long, random password to stay secure</p>
                        </div>
                    </div>

                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>Password updated successfully!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="current_password" name="current_password" 
                                       class="form-input" autocomplete="current-password">
                                <i class="fas fa-eye input-icon" id="toggleCurrentPassword"></i>
                            </div>
                            @error('current_password')
                                <div style="color: var(--error); font-size: 0.8rem; margin-top: 0.5rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="password" name="password" 
                                       class="form-input" autocomplete="new-password">
                                <i class="fas fa-eye input-icon" id="togglePassword"></i>
                            </div>
                            @error('password')
                                <div style="color: var(--error); font-size: 0.8rem; margin-top: 0.5rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-with-icon">
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-input" autocomplete="new-password">
                                <i class="fas fa-eye input-icon" id="togglePasswordConfirmation"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i> Update Password
                        </button>
                    </form>
                </div>

                <!-- Delete Account -->
                <div class="profile-section danger-zone">
                    <div class="section-header">
                        <div class="section-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h2 class="section-title danger-title">Delete Account</h2>
                            <p class="section-description">Permanently delete your account and all of its resources</p>
                        </div>
                    </div>

                    <div style="background: rgba(239, 68, 68, 0.1); padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                        <p style="color: var(--error); margin-bottom: 1rem;">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                            Once your account is deleted, all of its resources and data will be permanently erased.
                        </p>
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('confirm-delete').showModal()">
                            <i class="fas fa-trash" style="margin-right: 0.5rem;"></i> Delete Account
                        </button>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <dialog id="confirm-delete">
                        <div style="text-align: center; margin-bottom: 2rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 2rem;"></i>
                            </div>
                            <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Delete Account</h3>
                            <p style="color: var(--text-secondary);">Are you sure you want to delete your account? This action cannot be undone.</p>
                        </div>
                        
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')
                            
                            <div class="form-group">
                                <label for="delete_password" class="form-label">Enter your password to confirm</label>
                                <input type="password" id="delete_password" name="password" 
                                       class="form-input" placeholder="Your password" required>
                                @error('password')
                                    <div style="color: var(--error); font-size: 0.8rem; margin-top: 0.5rem;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                                <button type="button" class="btn btn-outline" onclick="document.getElementById('confirm-delete').close()">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash" style="margin-right: 0.5rem;"></i> Delete Account
                                </button>
                            </div>
                        </form>
                    </dialog>
                </div>
            </div>
        </div>
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

        // Toggle password visibility
        function setupPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            
            if (toggle && input) {
                toggle.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        }

        // Setup all password toggles
        setupPasswordToggle('toggleCurrentPassword', 'current_password');
        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');

        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('confirm-delete');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.close();
                    }
                });
            }
        });

        // Resize handler - SAMA dengan welcome page
        window.addEventListener('resize', function() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>