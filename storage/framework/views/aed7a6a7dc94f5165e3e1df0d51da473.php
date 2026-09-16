<?php $__env->startSection('title', ($service->name ?? 'Service Detail') . ' - ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('<?php echo e($service && $service->image ? asset('storage/' . $service->image) : asset('front_assets/images/hero-service.jpg')); ?>');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down"><?php echo e($service->name ?? 'Service Detail'); ?></div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo e(url('/services')); ?>">Services</a>
            <span class="sep">/</span>
            <span><?php echo e($service->name ?? ''); ?></span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <div>
                <?php if($service->image): ?>
                <div class="blog-detail-img reveal-img">
                    <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->name); ?>">
                </div>
                <?php endif; ?>

                <div class="reveal" style="--reveal-delay:120ms;">
                    <div class="section-label">Physiotherapy Service</div>
                    <h1 class="main-heading"><?php echo e($service->name); ?></h1>
                    <div class="content-editor">
                        <?php echo $service->description; ?>

                    </div>
                </div>

                <div class="cta-banner" data-aos="fade-up">
                    <div>
                        <h3>Ready For This Treatment?</h3>
                        <p>Book your appointment and start your recovery journey today.</p>
                    </div>
                    <button class="btn-p2gh btn-p2gh-white openForm">
                        <span>Book Now</span>
                        <span class="btn-icon">↗</span>
                    </button>
                </div>
            </div>

            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>All Services</h5>
                    <ul class="sidebar-card-list">
                        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <a href="<?php echo e(url('/service-details/' . $s->slug)); ?>"
                               class="<?php echo e($s->slug === $service->slug ? 'active-link' : ''); ?>">
                                <i class="bi bi-activity"></i>
                                <span><?php echo e($s->name); ?></span>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li style="color:var(--text-muted);font-size:14px;">No services found.</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="sidebar-card sidebar-accent">
                    <h5>Book Appointment</h5>
                    <p>Book your slot now and start recovering.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;">
                        <span>Book Now</span>
                    </button>
                    <?php if(!empty(settings('company_mobile1'))): ?>
                    <a href="tel:<?php echo e(settings('company_mobile1')); ?>" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:14px;color:rgba(255,255,255,0.8);font-size:14px;">
                        <i class="bi bi-telephone-fill"></i> <?php echo e(settings('company_mobile1')); ?>

                    </a>
                    <?php endif; ?>
                </div>
            </aside>

        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/front/service-detail.blade.php ENDPATH**/ ?>