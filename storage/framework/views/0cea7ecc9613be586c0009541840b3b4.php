<?php $__env->startSection('title', 'Gallery - ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('<?php echo e(asset('front_assets/images/hero-gallery.jpg')); ?>');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Photo Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span>Gallery</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up" style="max-width:1000px;">
            <div class="section-label">Our Gallery</div>
            <h2 class="main-heading">Inside <span>Navodayan Neuroclinic &amp; Neurorehab</span></h2>
        </div>

        <?php if($categories && $categories->count()): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-bottom:clamp(44px,5vw,64px);">
                <h3 class="gallery-cat-title" data-aos="fade-up"><?php echo e($category->name); ?></h3>
                <div class="gallery-grid">
                    <?php $__currentLoopData = $category->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/' . $item->image)); ?>" class="gallery-item glightbox" data-gallery="gallery-<?php echo e($category->id); ?>" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 6) * 40); ?>">
                        <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->title ?? $category->name); ?>" loading="lazy">
                        <div class="gallery-overlay">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-images"></i>
            <p>Gallery coming soon. Please check back later.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/front/gallery.blade.php ENDPATH**/ ?>