<?php $__env->startSection('title', 'Our Services — Website'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Our Services</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Services</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:600px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">What We Offer</div>
            <h2 class="main-heading">Comprehensive <span>Physiotherapy</span> Services</h2>
            <p class="section-desc">
                From sports injuries to post-surgical recovery, we provide evidence-based physiotherapy treatments tailored to your specific needs.
            </p>
        </div>

        <?php if(isset($categories) && $categories->count()): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="service-category-block">
                <h3 class="service-category-title">
                    <?php echo e($category->name); ?>

                </h3>
                <div class="services-list-grid">
                    <?php $__currentLoopData = $category->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="service-card" data-aos="fade-up">
                        <a href="<?php echo e(url('/service-details/' . $service->slug)); ?>">
                            <div class="service-card-img">
                                <?php if($service->image): ?>
                                <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->name); ?>">
                                <?php else: ?>
                                <img src="<?php echo e(asset('front_assets/images/serv1.webp')); ?>" alt="<?php echo e($service->name); ?>">
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
            <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 60); ?>">
                <a href="<?php echo e(url('/service-details/' . $service->slug)); ?>">
                    <div class="service-card-img">
                        <?php if($service->image): ?>
                        <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->name); ?>">
                        <?php else: ?>
                        <img src="<?php echo e(asset('front_assets/images/serv1.webp')); ?>" alt="<?php echo e($service->name); ?>">
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
            <p style="color:var(--text-muted);">No services found. Please add services from the admin panel.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="cta-banner" data-aos="zoom-in" style="margin-top:56px;">
            <div>
                <h3>Need Help Choosing The Right Treatment?</h3>
                <p>Our experts will assess your condition and recommend the best therapy plan for you.</p>
            </div>
            <button class="btn-p2gh btn-p2gh-white openForm" style="flex-shrink:0;">
                <span>Book Consultation</span>
                <span class="btn-icon" style="color:var(--primary);">↗</span>
            </button>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/front/services.blade.php ENDPATH**/ ?>