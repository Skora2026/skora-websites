<?php $__env->startSection('title', 'Access Denied'); ?>
<?php $__env->startSection('error_code', '403'); ?>
<?php $__env->startSection('description', 'You do not have permission to access this page.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="error-code">403</div>
    <h2 class="error-title">Access Denied</h2>
    <p class="error-message">
        You don't have permission to access this page. 
        Please check your credentials or contact the administrator if you believe this is an error.
    </p>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('actions'); ?>
    <a href="<?php echo e(url('/')); ?>" class="btn-primary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
    <?php if(auth()->check()): ?>
        <a href="<?php echo e(route('dashboard')); ?>" class="btn-secondary">
            <i class="bi bi-speedometer2"></i> Go to Dashboard
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('login')); ?>" class="btn-secondary">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('errors.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/errors/403.blade.php ENDPATH**/ ?>