<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2GH || Login</title>
    <meta name="description" content="Secure login to your P2GH account." />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front_assets/css/login-register.css') }}" />
   <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) 
                            : asset('assets-front/img-main.png') }}">

   
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-logo">
                <a href="{{url('/')}}">
                <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) 
                            : asset('assets-front/img-main.png') }}" alt="{{ settings('company_short_name') ?? 'P2GH' }}" alt="P2GH Logo">
                </a>
                <span class="menu-text">{{ settings('company_short_name') ?? 'P2GH ' }}</span>
            </h1>
            <h2 class="register-title">Welcome Back</h2>
            <p class="register-subtitle">Sign in to continue your journey</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       required autofocus autocomplete="username" 
                       placeholder="Enter your email address">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required 
                           autocomplete="current-password" 
                           placeholder="Enter your password">
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                        <i class="bi bi-eye-slash"></i>
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
           
            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">
                        <i class="bi bi-key me-1"></i>Forgot your password?
                    </a>
                </div>
            @endif

            <button type="submit" class="login-btn">
                <i class="bi bi-box-arrow-in-right me-2"></i>Log In
            </button>
        </form>

        @if (Route::has('register'))
            <div class="login-link">
                <p>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');
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
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function(event) {
                    const email = document.getElementById('email').value.trim();
                    const password = document.getElementById('password').value.trim();
                    
                    // Basic validation
                    if (!email || !password) {
                        event.preventDefault();
                        if (!email) {
                            alert('Please enter your email address.');
                            document.getElementById('email').focus();
                        } else {
                            alert('Please enter your password.');
                            document.getElementById('password').focus();
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
                    
                    if (password.length < 6) {
                        event.preventDefault();
                        alert('Password must be at least 6 characters long.');
                        document.getElementById('password').focus();
                        return;
                    }
                });
            }
            
            const emailError = document.querySelector('#email.is-invalid');
            if (emailError) {
                document.getElementById('email').focus();
            }
            
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
        });
    </script>
</body>
</html>