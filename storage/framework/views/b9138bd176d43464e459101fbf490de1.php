<?php $__env->startSection('title', 'Video Gallery - ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('<?php echo e(asset('front_assets/images/hero-video.jpg')); ?>');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Video Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span>Video</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up" style="max-width:1000px;">
            <div class="section-label">Video Gallery</div>
            <h2 class="main-heading">Watch <span>Navodayan Neuroclinic &amp; Neurorehab</span> In Action</h2>
        </div>

        <?php if($categories && $categories->count()): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-bottom:clamp(44px,5vw,64px);">
                <h3 class="gallery-cat-title" data-aos="fade-up"><?php echo e($category->name); ?></h3>
                <div class="gallery-grid">
                    <?php $__currentLoopData = $category->videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-item video-item" data-aos="fade-up" data-aos-delay="<?php echo e(($loop->index % 6) * 40); ?>"
                         data-video-type="<?php echo e($video->video_type); ?>"
                         data-video-src="<?php echo e($video->video_type === 'youtube' ? $video->embed_url : asset('storage/'.$video->video_file)); ?>">
                        <?php if($video->thumbnail): ?>
                            <img src="<?php echo e(asset('storage/' . $video->thumbnail)); ?>" alt="<?php echo e($video->title); ?>" loading="lazy">
                        <?php else: ?>
                            <img src="<?php echo e(asset('front_assets/images/v.png')); ?>" alt="<?php echo e($video->title); ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="gallery-overlay video-play-overlay">
                            <i class="bi bi-play-circle-fill"></i>
                        </div>
                        <div class="video-title-bar"><?php echo e($video->title); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-camera-video"></i>
            <p>No videos yet. Please check back soon.</p>
        </div>
        <?php endif; ?>
    </div>
</section>


<div class="video-modal" id="videoModal">
    <div class="video-modal-inner">
        <button class="video-modal-close" id="videoModalClose" aria-label="Close">✕</button>
        <div class="video-modal-frame" id="videoModalFrame"></div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const videoModal = document.getElementById('videoModal');
const videoModalFrame = document.getElementById('videoModalFrame');
const videoModalClose = document.getElementById('videoModalClose');

document.querySelectorAll('.video-item').forEach(item => {
    item.addEventListener('click', () => {
        const type = item.dataset.videoType;
        const src = item.dataset.videoSrc;
        if (!src) return;

        videoModalFrame.innerHTML = type === 'youtube'
            ? `<iframe src="${src}?autoplay=1" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>`
            : `<video src="${src}" controls autoplay></video>`;

        videoModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});

function closeVideoModal() {
    videoModal.classList.remove('active');
    videoModalFrame.innerHTML = '';
    document.body.style.overflow = '';
}

videoModalClose?.addEventListener('click', closeVideoModal);
videoModal?.addEventListener('click', (e) => {
    if (e.target === videoModal) closeVideoModal();
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && videoModal.classList.contains('active')) closeVideoModal();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/front/video.blade.php ENDPATH**/ ?>