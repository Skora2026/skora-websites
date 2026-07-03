<?php $__env->startSection('title', 'Health Blogs — P2GH 24*7 Physiotherapy'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Health Blogs</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Blogs</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">News and Insights</div>
            <h2 class="main-heading">Expert <span>Health Tips</span> And Guides</h2>
            <p class="section-desc">Stay informed with the latest physiotherapy insights, recovery tips, and health advice from our expert team.</p>
        </div>

        <div class="blog-grid">
            <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="blog-card" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 80); ?>">
                <a href="<?php echo e(url('/blog-details/' . $blog->slug)); ?>">
                    <div class="blog-card-img">
                        <img src="<?php echo e(asset($blog->image)); ?>" alt="<?php echo e($blog->title); ?>">
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-meta">
                            <span><i class="bi bi-person-fill"></i> <?php echo e(settings('company_short_name') ?? 'P2GH'); ?></span>
                            <span><i class="bi bi-calendar3"></i> <?php echo e($blog->publish_date->format('d M, Y')); ?></span>
                        </div>
                        <h5><?php echo e($blog->title); ?></h5>
                        <div class="blog-read-more">Read More <i class="bi bi-arrow-right"></i></div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted);">
                <i class="bi bi-journal-text" style="font-size:48px;color:var(--border-mid);display:block;margin-bottom:16px;"></i>
                <p>No blog posts found. Check back soon for health tips and updates!</p>
            </div>
            <?php endif; ?>
        </div>

        <?php if(method_exists($blogs, 'links')): ?>
        <div style="margin-top:48px;display:flex;justify-content:center;">
            <?php echo e($blogs->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/front/blogs.blade.php ENDPATH**/ ?>