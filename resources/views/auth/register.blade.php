<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2GH || Register</title>
    <meta name="description" content="Create your P2GH account and join our community." />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front_assets/css/login-register.css') }}" />
   <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) 
                            : asset('assets-front/img-main.png') }}">
  
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1 class="register-logo">
                 <a href="{{url('/')}}">
                <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) 
                            : asset('assets-front/img-main.png') }}" alt="{{ settings('company_short_name') ?? 'P2GH' }}" height="55" alt="{{ settings('company_short_name') ?? 'P2GH' }}">
               {{ settings('company_short_name') ?? 'P2GH ' }}
                </a>
            </h1>
            <h2 class="register-title">Create Account</h2>
            <p class="register-subtitle">Join us and start your educational journey</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row p-3 m-auto">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group password-field">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="Create a password">
                        <button type="button" class="password-toggle hide" id="togglePassword">
                            <i class="bi bi-eye"></i>
                            <i class="bi bi-eye-slash"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group password-field">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                        <button type="button" class="password-toggle hide" id="togglePasswordConfirmation">
                            <i class="bi bi-eye"></i>
                            <i class="bi bi-eye-slash"></i>
                        </button>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="register-btn">
                        <i class="bi bi-person-plus me-2"></i>Register Now
                    </button>
                </div>
                
                <div class="col-md-12">
                    <div class="login-link">
                        <a href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-left me-1"></i>Already registered? Log in
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Optional: Social login section -->
        <!--
        <div class="divider">
            <span>Or sign up with</span>
        </div>
        
        <div class="social-login">
            <a href="#" class="social-btn google">
                <i class="bi bi-google"></i> Google
            </a>
            <a href="#" class="social-btn apple">
                <i class="bi bi-apple"></i> Apple
            </a>
        </div>
        -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            function setupPasswordToggle(passwordFieldId, toggleButtonId) {
                const passwordField = document.getElementById(passwordFieldId);
                const toggleButton = document.getElementById(toggleButtonId);
                
                if (passwordField && toggleButton) {
                    toggleButton.addEventListener('click', function() {
                        // Toggle password field type
                        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordField.setAttribute('type', type);
                        
                        // Toggle button class for icon change
                        if (type === 'password') {
                            toggleButton.classList.remove('show');
                            toggleButton.classList.add('hide');
                        } else {
                            toggleButton.classList.remove('hide');
                            toggleButton.classList.add('show');
                        }
                    });
                }
            }
            
            // Setup toggles for both password fields
            setupPasswordToggle('password', 'togglePassword');
            setupPasswordToggle('password_confirmation', 'togglePasswordConfirmation');
            
            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;
                    const termsChecked = document.getElementById('terms').checked;
                    
                    // Check if passwords match
                    if (password !== confirmPassword) {
                        event.preventDefault();
                        alert('Passwords do not match. Please make sure both passwords are identical.');
                        return;
                    }
                    
                    // Check if terms are accepted
                    if (!termsChecked) {
                        event.preventDefault();
                        alert('Please accept the Terms of Service and Privacy Policy to continue.');
                        return;
                    }
                    
                    // Optional: Password strength validation
                    if (password.length < 8) {
                        event.preventDefault();
                        alert('Password must be at least 8 characters long.');
                        return;
                    }
                });
            }
            
            // Responsive adjustments on window resize
            window.addEventListener('resize', function() {
                const logoImg = document.querySelector('.register-logo img');
                if (window.innerWidth < 576) {
                    if (logoImg) logoImg.style.height = '45px';
                } else {
                    if (logoImg) logoImg.style.height = '55px';
                }
            });
        });
    </script>
</body>
</html>