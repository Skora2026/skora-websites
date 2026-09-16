<!-- resources/views/errors/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'P2GH & Reality Service'); ?> - <?php echo $__env->yieldContent('error_code', 'Error'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'P2GH & Reality Service'); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
   <link rel="icon" type="image/png" href="<?php echo e(settings('favicon') ? asset('storage/' . settings('favicon')) 
                            : asset('assets-front/img-main.png')); ?>">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f7f7f7 0%, #e0e0e0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(2px 2px at 20px 30px, #4b446f, transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(75, 68, 111, 0.8), transparent),
                radial-gradient(1px 1px at 90px 40px, #0a9c4e, transparent),
                radial-gradient(1px 1px at 130px 80px, rgba(10, 156, 78, 0.6), transparent),
                radial-gradient(2px 2px at 160px 30px, #4b446f, transparent),
                radial-gradient(1px 1px at 200px 90px, rgba(75, 68, 111, 0.7), transparent),
                radial-gradient(3px 3px at 250px 50px, #0a9c4e, transparent),
                radial-gradient(1px 1px at 300px 120px, rgba(10, 156, 78, 0.5), transparent),
                radial-gradient(2px 2px at 350px 60px, #f7f7f7, transparent);
            background-repeat: repeat;
            background-size: 400px 200px;
            animation: stars-continuous-move 30s linear infinite;
            z-index: -1;
            pointer-events: none;
        }

        @keyframes stars-continuous-move {
            0% {
                transform: translateX(0) translateY(0) rotate(0deg);
            }
            100% {
                transform: translateX(-400px) translateY(-200px) rotate(360deg);
            }
        }

        .error-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(75, 68, 111, 0.1);
            box-shadow: 0 20px 50px rgba(75, 68, 111, 0.15);
            border-radius: 20px;
            padding: 40px 35px;
            width: 100%;
            max-width: 600px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #4b446f 0%, #0a9c4e 50%, #4b446f 100%);
            border-radius: 20px 20px 0 0;
        }

        .error-header {
            margin-bottom: 30px;
        }

        .error-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-weight: 800;
            background: linear-gradient(135deg, #4b446f 0%, #0a9c4e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .error-logo img {
            height: 55px;
            width: auto;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 900;
            background: linear-gradient(135deg, #4b446f 0%, #0a9c4e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin: 10px 0;
        }

        .error-title {
            color: #4b446f;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 15px 0;
        }

        .error-message {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-secondary {
            padding: 12px 30px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4b446f 0%, #0a9c4e 100%);
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(75, 68, 111, 0.4);
            color: #fff;
            text-decoration: none;
        }

        .btn-secondary {
            background: #fff;
            color: #4b446f;
            border: 2px solid #4b446f;
        }

        .btn-secondary:hover {
            background: #4b446f;
            color: #fff;
            transform: translateY(-3px);
            text-decoration: none;
        }

        .error-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .error-container {
                padding: 35px 30px;
                max-width: 500px;
            }
            
            .error-logo {
                font-size: 2.2rem;
                gap: 12px;
            }
            
            .error-logo img {
                height: 50px;
            }
            
            .logo-text {
                font-size: 1.7rem;
            }
            
            .error-code {
                font-size: 5rem;
            }
            
            .error-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 15px;
            }
            
            .error-container {
                padding: 30px 25px;
                border-radius: 18px;
                max-width: 100%;
            }
            
            .error-logo {
                font-size: 2rem;
                flex-direction: column;
                gap: 10px;
            }
            
            .error-logo img {
                height: 45px;
            }
            
            .logo-text {
                font-size: 1.7rem;
            }
            
            .error-code {
                font-size: 4rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-message {
                font-size: 1rem;
            }
            
            .error-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-primary, .btn-secondary {
                width: 100%;
                padding: 14px;
            }
        }

        @media (max-width: 400px) {
            .error-container {
                padding: 25px 20px;
            }
            
            .error-logo {
                font-size: 1.8rem;
            }
            
            .error-logo img {
                height: 40px;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .error-code {
                font-size: 3.5rem;
            }
            
            .error-title {
                font-size: 1.4rem;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="error-container">
        <div class="error-header">
            <h3 class="error-logo">
                <img src="<?php echo e(settings('light_logo') ? asset('storage/' . settings('light_logo')) 
                            : asset('assets-front/img-main.png')); ?>" alt="<?php echo e(settings('company_short_name') ?? 'P2GH'); ?>">
                <span class="logo-text"><?php echo e(settings('company_short_name') ?? 'P2GH & Reality Service'); ?></span>
            </h3>
        </div>
        
        <?php echo $__env->yieldContent('content'); ?>
        
        <div class="error-actions">
            <?php echo $__env->yieldContent('actions'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Responsive logo adjustment
            function adjustLogo() {
                const logoImg = document.querySelector('.error-logo img');
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
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/errors/layout.blade.php ENDPATH**/ ?>