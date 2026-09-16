<?php $__env->startSection('title', 'Our Services - ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('<?php echo e(asset('front_assets/images/hero-services.jpg')); ?>');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Our Services</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span>Services</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up">
            <div class="section-label">Our Services</div>
            <h2 class="main-heading">Comprehensive <span>Neurology &amp; Rehabilitation</span> Services</h2>
            <p class="section-desc">
                We provide expert neurological consultation, advanced diagnostics, and personalized rehabilitation programs to help patients regain independence and improve their quality of life.
            </p>
        </div>

        <?php if(isset($categories) && $categories->count()): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="service-category-block">
                <h3 class="service-category-title"><?php echo e($category->name); ?></h3>
                <div class="services-list-grid">
                    <?php $__currentLoopData = $category->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 3) * 80); ?>">
                        <a href="<?php echo e(url('/service-details/' . $service->slug)); ?>">
                            <div class="service-card-img">
                                <span class="service-card-num"><?php echo e(str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                                <?php if($service->image): ?>
                                <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->name); ?>" loading="lazy">
                                <?php else: ?>
                                <img src="<?php echo e(asset('front_assets/images/serv1.webp')); ?>" alt="<?php echo e($service->name); ?>" loading="lazy">
                                <?php endif; ?>
                            </div>
                            <div class="service-card-body">
                                <h4><?php echo e($service->name); ?></h4>
                                <p><?php echo e(Str::limit(strip_tags($service->short_description), 90)); ?></p>
                                <div class="service-card-arrow">↗</div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <div class="services-list-grid">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 3) * 80); ?>">
                <a href="<?php echo e(url('/service-details/' . $service->slug)); ?>">
                    <div class="service-card-img">
                        <span class="service-card-num"><?php echo e(str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                        <?php if($service->image): ?>
                        <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->name); ?>" loading="lazy">
                        <?php else: ?>
                        <img src="<?php echo e(asset('front_assets/images/serv1.webp')); ?>" alt="<?php echo e($service->name); ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <div class="service-card-body">
                        <h4><?php echo e($service->name); ?></h4>
                        <p><?php echo e(Str::limit(strip_tags($service->short_description), 90)); ?></p>
                        <div class="service-card-arrow">↗</div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <i class="bi bi-activity"></i>
                <p>No services found. Please add services from the admin panel.</p>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="cta-banner" data-aos="fade-up">
            <div>
                <h3>Need Help Choosing The Right Treatment?</h3>
                <p>Our experts will assess your condition and recommend the best therapy plan for you.</p>
            </div>
            <button class="btn-p2gh btn-p2gh-white openForm">
                <span>Book Consultation</span>
                <span class="btn-icon">↗</span>
            </button>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/front/services.blade.php ENDPATH**/ ?>