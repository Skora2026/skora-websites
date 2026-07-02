<?php $__env->startSection('title', 'Gallery — ' . (settings('company_name') ?? 'P2GH 24*7 Physiotherapy')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Photo Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Gallery</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:500px;margin:0 auto 48px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Our Clinic</div>
            <h2 class="main-heading">A Glimpse Of Our <span>Healing Space</span></h2>
        </div>

        <?php if($categories && $categories->count()): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-bottom:56px;">
                <h3 style="font-family:var(--font-ui);font-size:18px;font-weight:700;color:var(--text-dark);margin-bottom:24px;display:flex;align-items:center;gap:12px;">
                    <span style="display:inline-block;width:4px;height:24px;background:var(--primary);border-radius:2px;"></span>
                    <?php echo e($category->name); ?>

                </h3>
                <div class="gallery-grid">
                    <?php $__currentLoopData = $category->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/' . $item->image)); ?>" class="gallery-item glightbox" data-gallery="gallery-<?php echo e($category->id); ?>" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 40); ?>">
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
        <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
            <i class="bi bi-images" style="font-size:48px;color:var(--border-mid);display:block;margin-bottom:16px;"></i>
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

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/front/gallery.blade.php ENDPATH**/ ?>