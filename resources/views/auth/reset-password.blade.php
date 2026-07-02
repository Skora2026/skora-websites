<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2GH || Reset Password</title>
    <meta name="description" content="Reset your P2GH account password securely." />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front_assets/css/login-register.css') }}" />
    <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) : asset('assets-front/img-main.png') }}">
    <style>
        .login-container { max-width: 470px; margin: 2rem auto; padding: 2rem; }
        .password-wrapper { position: relative; }
        .password-toggle { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6c757d; }
        .password-toggle:hover { color: #495057; }
        .password-toggle .bi-eye { display: none; }
        .password-toggle.show-password .bi-eye { display: inline; }
        .password-toggle.show-password .bi-eye-slash { display: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-logo">
                <a href="{{url('/')}}">
                <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) 
                            : asset('assets-front/img-main.png') }}" 
                     alt="{{ settings('company_short_name') ?? 'P2GH' }}"
                     width="55"
                     height="55"
                     loading="lazy"
                     onerror="this.src='{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('assets-front/img-main.png') }}'">
                </a>
                <span class="menu-text">{{ settings('company_short_name') ?? 'P2GH ' }}</span>
            </h1>
            <h2 class="register-title">Reset Password</h2>
            <p class="register-subtitle">Create a new password for your account</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ htmlspecialchars(session('status')) }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ htmlspecialchars($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $request->email) }}" 
                       required autofocus autocomplete="username" 
                       placeholder="Enter your email address"
                       inputmode="email"
                       spellcheck="false">
                @error('email')
                    <div class="invalid-feedback">{{ htmlspecialchars($message) }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required 
                           autocomplete="new-password" 
                           placeholder="Enter your new password"
                           minlength="8">
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                        <i class="bi bi-eye-slash"></i>
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <small class="form-text text-muted">Password must be at least 8 characters long</small>
                @error('password')
                    <div class="invalid-feedback">{{ htmlspecialchars($message) }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control" 
                           id="password_confirmation" name="password_confirmation" required 
                           autocomplete="new-password" 
                           placeholder="Confirm your new password"
                           minlength="8">
                    <button type="button" class="password-toggle" id="togglePasswordConfirm" aria-label="Show password">
                        <i class="bi bi-eye-slash"></i>
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-btn" id="submitBtn">
                <i class="bi bi-key me-2"></i>Reset Password
            </button>
        </form>

        <div class="login-link">
            <p>Remember your password? <a href="{{ route('login') }}">Sign in here</a></p>
            @if (Route::has('register'))
                <p class="mt-2">Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            function setupPasswordToggle(toggleId, passwordId) {
                const togglePassword = document.getElementById(toggleId);
                const passwordField = document.getElementById(passwordId);
                if (togglePassword && passwordField) {
                    togglePassword.addEventListener('click', function() {
                        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordField.setAttribute('type', type);
                        this.classList.toggle('show-password');
                        const label = type === 'password' ? 'Show password' : 'Hide password';
                        this.setAttribute('aria-label', label);
                    });
                    
                    togglePassword.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    });
                }
            }

            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('togglePasswordConfirm', 'password_confirmation');

            // Form validation
            const resetForm = document.getElementById('resetForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (resetForm) {
                resetForm.addEventListener('submit', function(event) {
                    const email = document.getElementById('email').value.trim();
                    const password = document.getElementById('password').value.trim();
                    const passwordConfirm = document.getElementById('password_confirmation').value.trim();
                    
                    // Basic validation
                    if (!email || !password || !passwordConfirm) {
                        event.preventDefault();
                        if (!email) {
                            alert('Please enter your email address.');
                            document.getElementById('email').focus();
                        } else if (!password) {
                            alert('Please enter your new password.');
                            document.getElementById('password').focus();
                        } else {
                            alert('Please confirm your new password.');
                            document.getElementById('password_confirmation').focus();
                        }
                        return;
                    }
                    
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        event.preventDefault();
                        alert('Please enter a valid email address.');
                        document.getElementById('email').focus();
                        return;
                    }
                    
                    if (password.length < 8) {
                        event.preventDefault();
                        alert('Password must be at least 8 characters long.');
                        document.getElementById('password').focus();
                        return;
                    }
                    
                    if (password !== passwordConfirm) {
                        event.preventDefault();
                        alert('Passwords do not match. Please try again.');
                        document.getElementById('password_confirmation').focus();
                        return;
                    }
                    
                    // Add loading state
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Resetting Password...';
                    }
                });
            }
            
            // Focus on error field if exists
            const emailError = document.querySelector('#email.is-invalid');
            const passwordError = document.querySelector('#password.is-invalid');
            if (emailError) {
                document.getElementById('email').focus();
            } else if (passwordError) {
                document.getElementById('password').focus();
            }
            
            // Logo responsive adjustment
            function adjustLogo() {
                const logoImg = document.querySelector('.login-logo img');
                const menuText = document.querySelector('.menu-text');
                const screenWidth = window.innerWidth;
                
                if (screenWidth < 576) {
                    if (logoImg) logoImg.style.height = '45px';
                    if (menuText) menuText.style.fontSize = '2rem';
                } else if (screenWidth < 768) {
                    if (logoImg) logoImg.style.height = '50px';
                    if (menuText) menuText.style.fontSize = '2.2rem';
                } else {
                    if (logoImg) logoImg.style.height = '55px';
                    if (menuText) menuText.style.fontSize = '2.5rem';
                }
            }
            
            // Initial adjustment
            adjustLogo();
            
            // Adjust on window resize
            window.addEventListener('resize', adjustLogo);
            
            // Real-time password match validation
            const passwordField = document.getElementById('password');
            const confirmField = document.getElementById('password_confirmation');
            
            function checkPasswordMatch() {
                if (passwordField.value && confirmField.value) {
                    if (passwordField.value !== confirmField.value) {
                        confirmField.classList.add('is-invalid');
                        confirmField.classList.remove('is-valid');
                    } else {
                        confirmField.classList.remove('is-invalid');
                        confirmField.classList.add('is-valid');
                    }
                } else {
                    confirmField.classList.remove('is-invalid', 'is-valid');
                }
            }
            
            if (passwordField && confirmField) {
                passwordField.addEventListener('input', checkPasswordMatch);
                confirmField.addEventListener('input', checkPasswordMatch);
            }
        });
    </script>
</body>
</html>