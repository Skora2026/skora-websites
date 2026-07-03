<!-- resources/views/errors/404.blade.php -->


<?php $__env->startSection('title', 'Page Not Found'); ?>
<?php $__env->startSection('error_code', '404'); ?>
<?php $__env->startSection('description', 'The page you are looking for could not be found.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="error-code">404</div>
    <h2 class="error-title">Page Not Found</h2>
    <p class="error-message">
        Oops! The page you are looking for might have been removed, 
        had its name changed, or is temporarily unavailable.
    </p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('actions'); ?>
    <a href="<?php echo e(url('/')); ?>" class="btn-primary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
    
    <a href="javascript:history.back()" class="btn-secondary">
        <i class="bi bi-arrow-left"></i> Go Back
    </a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('errors.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/errors/404.blade.php ENDPATH**/ ?>