<style>
    .notification-sidebar {
        position: fixed;
        top: 20px;
        right: -350px;
        z-index: 99999999999;
        width: 350px;
        transition: right 0.45s ease-in-out, opacity 0.45s ease;
    }
    .notification-sidebar.show {
        right: 20px;
    }

    .notify-box {
        background: #fff;
        border-radius: 12px;
        border-left: 4px solid;
        padding: 15px 18px;
        display: flex;
        gap: 12px;
        position: relative;
        box-shadow: 0 6px 18px rgba(0,0,0,0.13);
        animation: fadeIn .3s ease-in-out;
    }

    .notify-success { border-color: #28a745; }
    .notify-success .notify-text { color: #28a745; }
    .notify-warning { border-color: #ffc107; }
    .notify-warning .notify-text { color: #ffc107; }
    .notify-error { border-color: #dc3545; }
    .notify-error .notify-text { color: #dc3545; }
    .notify-icon { font-size: 24px; }
    .notify-text { font-size: 15px; font-weight: 600; }
    .close-btn {
        position: absolute;
        right: 10px;
        top: 0px;
        padding: 6px;
        border: none;
        background: #ffffff;
        font-size: 26px;
        cursor: pointer;
        font-weight: bold;
        color: #b3ad5b;
    }
    .timer-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 100%;
        background: rgba(0,0,0,0.1);
        transition: width linear 6s;
    }

    @keyframes fadeIn {
        from { transform: translateX(40px); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }
</style>

<?php if(session('success') || session('warning') || session('error') || $errors->any()): ?>
<div id="notify" class="notification-sidebar show">
    <div class="notify-box 
        <?php if(session('success')): ?> notify-success <?php endif; ?>
        <?php if(session('warning')): ?> notify-warning <?php endif; ?>
        <?php if(session('error') || $errors->any()): ?> notify-error <?php endif; ?>">

        <?php if(session('success') && session('message')): ?>
            <i class="fas fa-check-circle text-success notify-icon"></i>
            <span class="notify-text"><?php echo e(session('message')); ?></span>
        <?php endif; ?>
        
        <?php if(session('success') && !session('message')): ?>
            <i class="fas fa-check-circle text-success notify-icon"></i>
            <span class="notify-text"><?php echo e(session('success')); ?></span>
        <?php endif; ?>

        <?php if(session('success_message')): ?>
            <i class="fas fa-check-circle text-success notify-icon"></i>
            <span class="notify-text"><?php echo e(session('success_message')); ?></span>
        <?php endif; ?>

        <?php if(session('warning')): ?>
            <i class="fas fa-exclamation-triangle text-warning notify-icon"></i>
            <span class="notify-text"><?php echo e(session('warning')); ?></span>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <i class="fas fa-times-circle text-danger notify-icon"></i>
            <span class="notify-text"><?php echo e(session('error')); ?></span>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <i class="fas fa-times-circle text-danger notify-icon"></i>
            <span class="notify-text"><?php echo e($errors->first()); ?></span>
        <?php endif; ?>

        <button class="close-btn" onclick="hideNotify()">&times;</button>
        <div class="timer-bar"></div>
    </div>
</div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        let notify = document.getElementById("notify");
        if (notify) {
            // Start timer bar
            setTimeout(() => {
                notify.querySelector(".timer-bar").style.width = "0%";
            }, 50);

            // Auto hide after time
            setTimeout(() => hideNotify(), 6000);
        }
    });

    function hideNotify() {
        let notify = document.getElementById("notify");
        if (notify) {
            notify.style.opacity = "0";
            notify.style.right = "-350px";
            setTimeout(() => notify.remove(), 400);
        }
    }
    
    function showAlert(msg, type = "success") {
        let iconClass = "";
        let boxClass = "";
        if (type === "success") {
            iconClass = "text-success fas fa-check-circle";
            boxClass = "notify-success";
        } 
        else if (type === "warning") {
            iconClass = "text-warning fas fa-exclamation-triangle";
            boxClass = "notify-warning";
        }
        else if (type === "error" || type === "delete") {
            iconClass = "text-danger fas fa-times-circle";
            boxClass = "notify-error";
        }

        let box = document.createElement("div");
        box.className = "notification-sidebar show";

        box.innerHTML = `
            <div class="notify-box ${boxClass}">
                <i class="${iconClass} notify-icon"></i>
                <span class="notify-text">${msg}</span>
                <button class="close-btn" onclick="this.parentElement.parentElement.remove()">&times;</button>

                <div class="timer-bar"></div>
            </div>
        `;

        document.body.appendChild(box);
        setTimeout(() => {
            box.querySelector(".timer-bar").style.width = "0%";
        }, 50);
        setTimeout(() => box.remove(), 6000);
    }
</script>
<style>
    .thank-you-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ff99001e; /* Matching overlay from coming soon */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100000000000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        backdrop-filter: blur(8px); /* Enhanced blur for professional feel */
    }
    
    .thank-you-modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }
    
    .thank-you-modal {
        background: rgba(255, 255, 255, 0.15); /* Transparent glassmorphic background */
        backdrop-filter: blur(20px); /* Strong blur for transparency effect */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border for card */
        width: 90%;
        max-width: 450px;
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        position: relative;
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.35),
            inset 0 2px 4px rgba(255, 255, 255, 0.4); /* Inner glow for professionalism */
        transform: translateY(60px) scale(0.85);
        opacity: 0;
        transition: all 0.9s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        overflow: hidden;
    }
    
    .thank-you-modal-overlay.show .thank-you-modal {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    
    .thank-you-modal::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #ff993383, #ffb2475c, #ff6a00a1, #ff993362); /* Matching orange gradients */
        background-size: 300% 100%;
        animation: shimmer 2.5s infinite linear;
    }
    
    .thank-you-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #ff9933ac, #ffb347, #ff6a00c9); /* Orange theme */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        position: relative;
        animation: float 2.5s ease-in-out infinite;
        box-shadow: 
            0 12px 35px rgba(255, 153, 51, 0.267), /* Orange shadow */
            0 0 0 10px rgba(255, 153, 51, 0.15);
        overflow: hidden;
    }
    
    .thank-you-icon::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: iconShine 1.5s ease-in-out infinite;
        transform: rotate(45deg);
    }
    
    .thank-you-icon i {
        font-size: 48px;
        color: #fff; /* White for contrast */
        position: relative;
        z-index: 1;
        animation: iconBounce 0.9s ease 0.4s both;
    }
    
    .thank-you-title {
        font-size: 32px;
        font-weight: 900;
        color: #ff9933; /* Main orange */
        margin-bottom: 18px;
        background: linear-gradient(45deg, #ff9933ac, #ffb2479f, #ff6a0071);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: textReveal 0.9s ease 0.3s both;
        opacity: 0;
        transform: translateY(25px);
    }
    
    .thank-you-message {
        font-size: 17px;
        color: #ffd9b3; /* Light orange from tagline */
        line-height: 1.7;
        margin-bottom: 30px;
        padding: 0 20px;
        animation: fadeUp 0.9s ease 0.6s both;
        opacity: 0;
        transform: translateY(25px);
    }
    
    .modal-close-btn {
        background: linear-gradient(135deg, #ff6a00, #ffb347); /* Button gradient from coming soon */
        color: #111; /* Dark text */
        border: none;
        padding: 14px 35px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        overflow: hidden;
        animation: buttonReveal 0.9s ease 0.9s both;
        opacity: 0;
        transform: translateY(25px);
        box-shadow: 0 6px 25px rgba(255, 153, 51, 0.35); /* Orange shadow */
    }
    
    .modal-close-btn:hover {
        background: #fff; /* Hover from coming soon */
        color: #ff6a00;
        transform: translateY(-4px) scale(1.08);
        box-shadow: 0 12px 30px rgba(255, 153, 51, 0.45);
        letter-spacing: 1.2px;
    }
    
    .modal-close-btn:active {
        transform: translateY(-2px);
    }
    
    .modal-close-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -120%;
        width: 120%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
        transition: 0.6s;
    }
    
    .modal-close-btn:hover::before {
        left: 100%;
    }
    
    .confetti {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #ff9933; /* Orange confetti */
        border-radius: 20%;
        opacity: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    /* Keyframe Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
    }
    
    @keyframes iconShine {
        0% { transform: translateX(-200%) rotate(45deg); }
        100% { transform: translateX(200%) rotate(45deg); }
    }
    
    @keyframes iconBounce {
        0% { transform: scale(0.5); opacity: 0; }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes shimmer {
        0% { background-position: -300% 0; }
        100% { background-position: 300% 0; }
    }
    
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes textReveal {
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes buttonReveal {
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes confettiFall {
        0% { transform: translateY(-150px) rotate(0deg); opacity: 1; }
        100% { transform: translateY(600px) rotate(720deg); opacity: 0; }
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35), 0 0 0 0 rgba(255, 153, 51, 0.8); }
        70% { box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35), 0 0 0 25px rgba(255, 153, 51, 0); }
        100% { box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35), 0 0 0 0 rgba(255, 153, 51, 0); }
    }
    
    .thank-you-modal {
        animation: pulse 2.5s ease 1s 3;
    }
</style>

<?php if(session('thankssuccess')): ?>
<div id="thankYouModal" class="thank-you-modal-overlay">
    <div class="thank-you-modal">
        <div class="thank-you-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h2 class="thank-you-title">Thank You!</h2>
        <p class="thank-you-message"><?php echo e(session('thankssuccess')); ?></p>
        
        <button class="modal-close-btn" onclick="hideThankYouModal()">
            Continue
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function createConfetti() {
            const modal = document.getElementById('thankYouModal');
            const colors = ['#ff9933', '#ffb347', '#ff6a00', '#ffd9b3', '#ffe6c7']; /* Orange theme colors */
            
            for(let i = 0; i < 80; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 18 + 6 + 'px';
                confetti.style.height = confetti.style.width;
                confetti.style.animation = `confettiFall ${Math.random() * 2.5 + 2.5}s ease-in-out ${Math.random() * 1.5}s forwards`;
                confetti.style.zIndex = '100000000001';
                confetti.style.position = 'fixed';
                modal.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 6000);
            }
        }
        
        // Show modal with animation
        setTimeout(() => {
            const modal = document.getElementById('thankYouModal');
            if(modal) {
                modal.classList.add('show');
                createConfetti();
            }
        }, 100);
        
        // Function to hide thank you modal
        function hideThankYouModal() {
            const modal = document.getElementById('thankYouModal');
            if (modal) {
                modal.style.transition = 'all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                modal.style.opacity = '0';
                modal.style.transform = 'translateY(-60px) scale(0.85)';
                
                setTimeout(() => {
                    modal.remove();
                }, 600);
            }
        }
        setTimeout(() => {
            hideThankYouModal();
        }, 6000);
        const modal = document.getElementById('thankYouModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideThankYouModal();
                }
            });
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideThankYouModal();
            }
        });
        window.hideThankYouModal = hideThankYouModal;
    });
</script>
<?php endif; ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/layouts/notification.blade.php ENDPATH**/ ?>