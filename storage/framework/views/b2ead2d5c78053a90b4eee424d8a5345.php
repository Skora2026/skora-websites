<?php $__env->startSection('title', ($blog->title ?? 'Blog') . ' — P2GH 24*7 Physiotherapy'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down" style="font-size:1.6rem;"><?php echo e(Str::limit($blog->title ?? 'Blog Post', 60)); ?></div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo e(url('/blogs')); ?>" style="color:rgba(255,255,255,0.6);">Blogs</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Article</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <article data-aos="fade-up">
                <?php if($blog->image): ?>
                <div class="blog-detail-img">
                    <img src="<?php echo e(asset($blog->image)); ?>" alt="<?php echo e($blog->title); ?>">
                </div>
                <?php endif; ?>

                <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;flex-wrap:wrap;">
                    <span style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-person-fill" style="color:var(--primary);"></i>
                        <?php echo e(settings('company_short_name') ?? 'P2GH Team'); ?>

                    </span>
                    <span style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-calendar3" style="color:var(--primary);"></i>
                        <?php echo e($blog->publish_date->format('d M, Y')); ?>

                    </span>
                </div>

                <h1 style="font-family:var(--font-display);font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;color:var(--text-dark);margin-bottom:24px;line-height:1.3;">
                    <?php echo e($blog->title); ?>

                </h1>

                <div class="content-editor" style="color:var(--text-body);line-height:1.9;font-size:16px;">
                    <?php echo $blog->long_description; ?>

                </div>
            </article>

            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>Recent Posts</h5>
                    <?php $__empty_1 = true; $__currentLoopData = $recentBlogs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(url('/blog-details/' . $rb->slug)); ?>" style="display:flex;gap:12px;align-items:flex-start;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--border-light);">
                        <img src="<?php echo e(asset($rb->image)); ?>" alt="<?php echo e($rb->title); ?>" style="width:68px;height:52px;object-fit:cover;border-radius:var(--radius-sm);flex-shrink:0;">
                        <div>
                            <p style="font-size:13px;font-weight:600;color:var(--text-dark);line-height:1.4;margin-bottom:4px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?php echo e($rb->title); ?></p>
                            <span style="font-size:11px;color:var(--text-muted);font-family:var(--font-ui);"><?php echo e($rb->publish_date->format('d M, Y')); ?></span>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="font-size:14px;color:var(--text-muted);">No recent posts.</p>
                    <?php endif; ?>
                </div>

                <div class="sidebar-card" style="background:var(--primary);border-color:var(--primary);">
                    <h5 style="color:#fff;border-bottom-color:rgba(255,255,255,0.3);">Book Appointment</h5>
                    <p style="font-size:14px;color:rgba(255,255,255,0.8);margin-bottom:16px;">Experiencing pain or discomfort? Our experts are ready to help — 24x7.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;justify-content:center;">
                        <span>Book Now</span>
                    </button>
                </div>
            </aside>

        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/front/blog-detail.blade.php ENDPATH**/ ?>