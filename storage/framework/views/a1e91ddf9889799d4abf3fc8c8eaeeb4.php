<?php $__env->startSection('title', ($blog->title ?? 'Blog Details') . ' - ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('<?php echo e($blog && $blog->image ? asset($blog->image) : asset('front_assets/images/hero-blog.jpg')); ?>');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down" style="font-size:1.6rem;"><?php echo e(Str::limit($blog->title ?? 'Blog Post', 60)); ?></div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo e(url('/blogs')); ?>">Blogs</a>
            <span class="sep">/</span>
            <span>Article</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <article class="reveal">
                <?php if($blog->image): ?>
                <div class="blog-detail-img">
                    <img src="<?php echo e(asset($blog->image)); ?>" alt="<?php echo e($blog->title); ?>">
                </div>
                <?php endif; ?>

                <div style="display:flex;align-items:center;gap:20px;margin-bottom:22px;flex-wrap:wrap;">
                    <span style="display:flex;align-items:center;gap:7px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-person-fill" style="color:var(--accent);"></i>
                        <?php echo e(settings('company_short_name') ?? 'P2GH Team'); ?>

                    </span>
                    <span style="display:flex;align-items:center;gap:7px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-calendar3" style="color:var(--accent);"></i>
                        <?php echo e($blog->publish_date->format('d M, Y')); ?>

                    </span>
                </div>

                <h1 style="font-family:var(--font-display);font-size:clamp(1.7rem,3.2vw,2.4rem);font-weight:700;color:var(--text-dark);margin-bottom:26px;line-height:1.25;">
                    <?php echo e($blog->title); ?>

                </h1>

                <div class="content-editor">
                    <?php echo $blog->long_description; ?>

                </div>
            </article>

            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>Recent Posts</h5>
                    <?php $__empty_1 = true; $__currentLoopData = $recentBlogs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(url('/blog-details/' . $rb->slug)); ?>" class="sidebar-post-item">
                        <img src="<?php echo e(asset($rb->image)); ?>" alt="<?php echo e($rb->title); ?>" loading="lazy">
                        <div>
                            <p><?php echo e($rb->title); ?></p>
                            <span><?php echo e($rb->publish_date->format('d M, Y')); ?></span>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="font-size:14px;color:var(--text-muted);">No recent posts.</p>
                    <?php endif; ?>
                </div>

                <div class="sidebar-card sidebar-accent">
                    <h5>Book Appointment</h5>
                    <p>Experiencing pain or discomfort? Our experts are ready to help.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;">
                        <span>Book Now</span>
                    </button>
                </div>
            </aside>

        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/front/blog-detail.blade.php ENDPATH**/ ?>