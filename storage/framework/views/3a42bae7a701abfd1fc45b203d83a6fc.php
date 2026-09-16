<!-- resources/views/errors/419.blade.php -->


<?php $__env->startSection('title', 'Page Expired'); ?>
<?php $__env->startSection('error_code', '419'); ?>
<?php $__env->startSection('description', 'Your session has expired. Please refresh the page.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="error-icon">
        <i class="bi bi-clock-history"></i>
    </div>
    
    <div class="error-code">419</div>
    
    <h2 class="error-title">Page Expired</h2>
    
    <p class="error-message">
        Your session has expired due to inactivity. 
        Please refresh the page and try again.
    </p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('actions'); ?>
    <button onclick="window.location.reload()" class="btn-primary">
        <i class="bi bi-arrow-clockwise"></i> Refresh Page
    </button>
    
    <a href="<?php echo e(url('/')); ?>" class="btn-secondary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-refresh after 10 seconds
    setTimeout(function() {
        window.location.reload();
    }, 10000);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('errors.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/errors/419.blade.php ENDPATH**/ ?>