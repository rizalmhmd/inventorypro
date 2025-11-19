<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - InventoryPro</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        :root {
            --primary-color: #8b5cf6;
            --primary-dark: #7c3aed;
            --secondary-color: #10b981;
            --background-dark: #1a1f36;
            --background-medium: #2d3748;
            --background-light: #4a5568;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(255, 255, 255, 0.15);
            --error-color: #f87171;
            --success-color: #86efac;
            --warning-color: #fcd34d;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, var(--background-dark) 0%, var(--background-medium) 50%, var(--background-light) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            background-size: 100% 100%;
            animation: float 30s infinite linear;
            z-index: -1;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-100px, -50px) rotate(360deg); }
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
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
            color: var(--text-muted);
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .back-button:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .profile-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 50%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .profile-subtitle {
            color: var(--text-muted);
            font-size: 1.2rem;
        }

        /* Profile Grid */
        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }

        /* Sidebar */
        .profile-sidebar {
            background: rgba(30, 35, 50, 0.7);
            backdrop-filter: blur(25px);
            border-radius: 2rem;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            height: fit-content;
        }

        .user-card {
            text-align: center;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.1);
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .user-role {
            color: var(--text-muted);
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
            border-radius: 1rem;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        /* Main Content */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .profile-section {
            background: rgba(30, 35, 50, 0.7);
            backdrop-filter: blur(25px);
            border-radius: 2rem;
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .profile-section:hover {
            transform: translateY(-5px);
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
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-description {
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.2rem;
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid var(--border-color);
            border-radius: 1rem;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-family: 'Instrument Sans', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Buttons */
        .btn {
            padding: 1rem 2rem;
            border-radius: 1rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.4s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            font-family: 'Instrument Sans', sans-serif;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(139, 92, 246, 0.6);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(239, 68, 68, 0.6);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: var(--success-color);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: var(--error-color);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
            color: var(--warning-color);
        }

        /* Danger Zone */
        .danger-zone {
            border-left: 4px solid #ef4444;
            background: rgba(239, 68, 68, 0.05);
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
                font-size: 2.5rem;
            }
            
            .profile-section {
                padding: 2rem 1.5rem;
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
                font-size: 2rem;
            }
            
            .profile-section {
                padding: 1.5rem 1rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animation */
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

        .profile-section {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .profile-section:nth-child(1) { animation-delay: 0.1s; }
        .profile-section:nth-child(2) { animation-delay: 0.2s; }
        .profile-section:nth-child(3) { animation-delay: 0.3s; }
        .profile-sidebar { animation-delay: 0.4s; }
    </style>
</head>
<body>

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
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                        <i class="fas fa-envelope mr-2"></i>{{ Auth::user()->email }}
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
                            <i class="fas fa-check-circle mr-2"></i>Profile updated successfully!
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
                                <div style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.5rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="form-input" required autocomplete="email">
                            @error('email')
                                <div style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.5rem;">
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
                            <i class="fas fa-check-circle mr-2"></i>Password updated successfully!
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
                                <div style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.5rem;">
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
                                <div style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.5rem;">
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

                    <div style="background: rgba(239, 68, 68, 0.1); padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem;">
                        <p style="color: var(--error-color); margin-bottom: 1rem;">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Once your account is deleted, all of its resources and data will be permanently erased.
                        </p>
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('confirm-delete').showModal()">
                            <i class="fas fa-trash mr-2"></i> Delete Account
                        </button>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <dialog id="confirm-delete" style="
                        background: rgba(30, 35, 50, 0.95);
                        backdrop-filter: blur(25px);
                        border: 1px solid var(--border-color);
                        border-radius: 2rem;
                        padding: 2rem;
                        color: var(--text-primary);
                        max-width: 500px;
                        width: 90%;
                    ">
                        <div style="text-align: center; margin-bottom: 2rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 2rem;"></i>
                            </div>
                            <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Delete Account</h3>
                            <p style="color: var(--text-muted);">Are you sure you want to delete your account? This action cannot be undone.</p>
                        </div>
                        
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Enter your password to confirm</label>
                                <input type="password" id="delete_password" name="password" 
                                       class="form-input" placeholder="Your password" required>
                                @error('password')
                                    <div style="color: var(--error-color); font-size: 0.875rem; margin-top: 0.5rem;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                                <button type="button" class="btn btn-outline" onclick="document.getElementById('confirm-delete').close()">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash mr-2"></i> Delete Account
                                </button>
                            </div>
                        </form>
                    </dialog>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>