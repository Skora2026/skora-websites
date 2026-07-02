<?php $__env->startSection('title', 'Dashboard'); ?>


<?php $__env->startSection('content'); ?>

 <div class="dashboard-header">
      <div class="row align-items-center">
    <div class="col-md-8">
        <h2 class="mb-1">
            Welcome, <?php echo e(auth()->user()->name); ?> 👋
        </h2>
        <p class="welcome-text mb-0 text-muted">
            You’re all set to manage the system efficiently.
        </p>
    </div>

    <div class="col-md-4 text-md-end">
        <span class="badge t px-3 py-2 text-rehab " style="background-color: #ececec87 !important;">
                <?php echo e(now()->format('d M Y, h:i A')); ?>

            </span>
        </div>
    </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stats-card ">
                <div class="card-body p-4 text-center">
                    <a href="<?php echo e(route('admin.manage-blogs')); ?>">
                        <h6 class="mb-3 opacity-75">Total Blogs</h6>
                        <h3><?php echo e(number_format($totalBlogs)); ?></h3>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-lg-3">
            <div class="card stats-card ">
                <div class="card-body p-4 text-center">
                    <a href="<?php echo e(route('admin.appointments')); ?>">
                        <h6 class="mb-3 opacity-75">Total Appointments</h6>
                        <h3><?php echo e(number_format($totalAppointment)); ?></h3>
                    </a>
                </div>
            </div>
        </div>
        
    </div>

  
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>





<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/admin/index.blade.php ENDPATH**/ ?>