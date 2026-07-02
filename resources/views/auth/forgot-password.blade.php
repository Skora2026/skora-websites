<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2GH || Forgot Password</title>
    <meta name="description" content="Reset your P2GH account password." />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('front_assets/css/login-register.css') }}" />
    <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) 
                            : asset('assets-front/img-main.png') }}">
    <style>
        .forgot-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(75, 68, 111, 0.1);
            box-shadow: 0 20px 50px rgba(75, 68, 111, 0.15);
            border-radius: 20px;
            padding: 40px 35px;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .forgot-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #4b446f 0%, #019443 50%, #4b446f 100%);
            border-radius: 20px 20px 0 0;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .forgot-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4b446f 0%, #019443 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .forgot-logo img {
            height: 55px;
            width: auto;
        }

        .logo-text {
            font-size: 1.3rem;
            font-weight: 800;
        }

        .forgot-title {
            color: #4b446f;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 15px 0;
        }

        .forgot-subtitle {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #4b446f;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f7f7f7;
            color: #333;
        }

        .form-control:focus {
            outline: none;
            border-color: #019443;
            box-shadow: 0 0 0 4px rgba(10, 156, 78, 0.1);
            background: #fff;
        }

        .form-control::placeholder {
            color: #999;
            font-size: 0.95rem;
        }

        .reset-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4b446f 0%, #019443 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .reset-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(75, 68, 111, 0.4);
        }

        .reset-btn:active {
            transform: translateY(-1px);
        }

        .reset-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .back-to-login {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .back-to-login a {
            color: #019443;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-to-login a:hover {
            color: #4b446f;
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert-success {
            background: rgba(10, 156, 78, 0.1);
            border: 1px solid #019443;
            color: #019443;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 0.95rem;
            text-align: center;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert-danger li {
            margin-bottom: 5px;
        }

        .alert-info {
            background: rgba(13, 110, 253, 0.1);
            border: 1px solid #0d6efd;
            color: #0d6efd;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 0.95rem;
            text-align: center;
        }

        /* Validation Errors */
        .validation-errors {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        .validation-errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .validation-errors li {
            margin-bottom: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .forgot-container {
                padding: 35px 30px;
                max-width: 450px;
            }
            
            .forgot-logo {
                font-size: 2.2rem;
                gap: 12px;
            }
            
            .forgot-logo img {
                height: 50px;
            }
            
            .logo-text {
                font-size: 2.2rem;
            }
            
            .forgot-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 15px;
            }
            
            .forgot-container {
                padding: 30px 25px;
                border-radius: 18px;
                max-width: 100%;
            }
            
            .forgot-logo {
                font-size: 2rem;
                flex-direction: column;
                gap: 10px;
            }
            
            .forgot-logo img {
                height: 45px;
            }
            
            .logo-text {
                font-size: 2rem;
            }
            
            .forgot-title {
                font-size: 1.5rem;
            }
            
            .forgot-subtitle {
                font-size: 0.95rem;
            }
            
            .form-control {
                padding: 12px;
                font-size: 0.95rem;
            }
            
            .reset-btn {
                padding: 14px;
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .forgot-container {
                padding: 25px 20px;
            }
            
            .forgot-logo {
                font-size: 1.8rem;
            }
            
            .forgot-logo img {
                height: 40px;
            }
            
            .logo-text {
                font-size: 1.8rem;
            }
            
            .forgot-title {
                font-size: 1.4rem;
            }
            
            .forgot-subtitle {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-header">
            <h1 class="forgot-logo">
                <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) 
                            : asset('assets-front/img-main.png') }}" alt="{{ settings('company_short_name') ?? 'P2GH' }}" alt="P2GH Logo">
                <span class="logo-text">{{ settings('company_short_name') ?? 'P2GH & Reality Service' }}</span>
            </h1>
            <h2 class="forgot-title">Reset Your Password</h2>
            <p class="forgot-subtitle">
Forgot your password? Enter your email and we’ll send you a reset link to create a new one            </p>
        </div>

        <!-- Status Message -->
        @if (session('status'))
            <div class="alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="validation-errors">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Reset Form -->
        <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
            @csrf

            <div class="form-group">
                <label for="email">
                    <i class="bi bi-envelope me-1"></i>Email Address
                </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       required autofocus autocomplete="email" 
                       placeholder="Enter your registered email address">
                @error('email')
                    <div class="invalid-feedback" style="display: block;">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="reset-btn" id="submitBtn">
                <i class="bi bi-envelope-paper me-2"></i>
                <span id="btnText">Email Password Reset Link</span>
                <span id="loadingSpinner" style="display: none;">
                    <i class="bi bi-arrow-repeat spin"></i> Sending...
                </span>
            </button>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="bi bi-arrow-left me-1"></i>Back to Login
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add spinning animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                .spin {
                    animation: spin 1s linear infinite;
                    display: inline-block;
                }
            `;
            document.head.appendChild(style);

            // Form submission handler
            const form = document.getElementById('forgotPasswordForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const email = document.getElementById('email').value.trim();
                    
                    // Basic validation
                    if (!email) {
                        e.preventDefault();
                        alert('Please enter your email address.');
                        document.getElementById('email').focus();
                        return;
                    }
                    
                    // Email format validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        e.preventDefault();
                        alert('Please enter a valid email address.');
                        document.getElementById('email').focus();
                        return;
                    }
                    
                    // Show loading state
                    if (submitBtn && btnText && loadingSpinner) {
                        submitBtn.disabled = true;
                        btnText.style.display = 'none';
                        loadingSpinner.style.display = 'inline';
                    }
                });
            }
            
            // Auto-focus on email field if there's an error
            const emailError = document.querySelector('#email.is-invalid');
            if (emailError) {
                document.getElementById('email').focus();
            }
            
            // Check if there's a success message
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                // Clear form after successful submission
                form.reset();
                
                // Re-enable button if it was disabled
                if (submitBtn && btnText && loadingSpinner) {
                    submitBtn.disabled = false;
                    btnText.style.display = 'inline';
                    loadingSpinner.style.display = 'none';
                }
            }
            
            // Responsive logo adjustment
            function adjustLogo() {
                const logoImg = document.querySelector('.forgot-logo img');
                const logoText = document.querySelector('.logo-text');
                const screenWidth = window.innerWidth;
                
                if (screenWidth < 576) {
                    if (logoImg) logoImg.style.height = '45px';
                    if (logoText) logoText.style.fontSize = '2rem';
                } else if (screenWidth < 768) {
                    if (logoImg) logoImg.style.height = '50px';
                    if (logoText) logoText.style.fontSize = '2.2rem';
                } else {
                    if (logoImg) logoImg.style.height = '55px';
                    if (logoText) logoText.style.fontSize = '2.5rem';
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