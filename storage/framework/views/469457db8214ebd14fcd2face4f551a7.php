<?php $__env->startSection('title', 'About Us — ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">About Us</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">About Us</span>
        </nav>
    </div>
</div>


<section class="p2gh-section ddp-about-stats">
    <div class="container-p2gh">
        <div class="ddp-panel">

            <div class="ddp-panel-content" data-aos="fade-right">
                <div class="section-label"><?php echo e($aboutsection->sub_title ?? 'About ' . (settings('company_short_name') ?? 'P2GH')); ?></div>
                <h2 class="main-heading">
                    <?php if($aboutsection && $aboutsection->title_line1): ?>
                        <?php echo e($aboutsection->title_line1); ?> <span><?php echo e($aboutsection->title_line2); ?></span>
                    <?php else: ?>
                        Passionate About <span>Providing Expert Care</span> And Support
                    <?php endif; ?>
                </h2>
                <p class="section-desc" style="margin-bottom:20px;">
                    <?php echo $aboutsection && $aboutsection->description ? nl2br(e($aboutsection->description)) : 'At <strong>'.( settings('company_name') ?? 'P2GH - 24*7 Physiotherapy').'</strong>, our dedicated physiotherapists combine compassionate care, continuous support, and clinical expertise to relieve pain and help patients regain a better quality of life.'; ?>

                </p>
                <blockquote style="border-left:4px solid var(--primary);padding:14px 20px;background:var(--bg-section);border-radius:0 var(--radius-sm) var(--radius-sm) 0;font-style:italic;color:var(--text-body);margin-bottom:28px;font-size:15px;">
                    "<?php echo e($aboutsection->quote_text ?? 'True healing comes from more than treatments — it is built on trust, patience, and compassion, reflected in each small victory.'); ?>"
                </blockquote>
                <div class="doctor-signature">
                    <?php if($aboutsection && $aboutsection->logo_image): ?>
                        <img src="<?php echo e(asset('storage/'.$aboutsection->logo_image)); ?>" alt="<?php echo e(settings('company_short_name') ?? 'P2GH'); ?>">
                    <?php else: ?>
                        <img src="<?php echo e(asset('front_assets/images/doc-icon.jpg')); ?>" alt="Doctor">
                    <?php endif; ?>
                    <div>
                        <div class="doc-name"><?php echo e($aboutsection->doctor_name ?? (settings('company_short_name') ?? 'Dr. Ankit Agrawal PT')); ?></div>
                        <div class="doc-deg"><?php echo e($aboutsection->doctor_qualification ?? 'BPT · MPT · COMT · CKT'); ?></div>
                    </div>
                    <?php if($aboutsection && $aboutsection->button_link): ?>
                    <a href="<?php echo e($aboutsection->button_link); ?>" class="btn-p2gh" style="margin-left:auto;padding:10px 20px;font-size:12px;">
                        <?php echo e($aboutsection->button_text ?? 'Know More'); ?> <span class="btn-icon">↗</span>
                    </a>
                    <?php endif; ?>
                </div>

                <?php if($progressCounters && $progressCounters->count()): ?>
                <div class="stats-grid">
                    <?php $__currentLoopData = $progressCounters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                        <div class="stat-icon"><i class="bi <?php echo e($counter->icon ?? 'bi-graph-up'); ?>"></i></div>
                        <div class="stat-num">
                            <span data-target="<?php echo e($counter->number); ?>" data-suffix="<?php echo e($counter->suffix ?? '+'); ?>">
                                <?php echo e($counter->number); ?><?php echo e($counter->suffix ?? '+'); ?>

                            </span>
                        </div>
                        <div class="stat-label"><?php echo e($counter->title); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="about-images-wrap" data-aos="fade-left">
                <div class="about-img-main">
                    <?php if($aboutsection && $aboutsection->center_image): ?>
                        <img src="<?php echo e(asset('storage/'.$aboutsection->center_image)); ?>" alt="<?php echo e(settings('company_short_name') ?? 'P2GH'); ?> Physiotherapy">
                    <?php else: ?>
                        <img src="<?php echo e(asset('front_assets/images/aa.jpeg')); ?>" alt="P2GH Physiotherapy">
                    <?php endif; ?>
                </div>
                <div class="about-img-small">
                    <?php if($aboutsection && $aboutsection->small_image): ?>
                        <img src="<?php echo e(asset('storage/'.$aboutsection->small_image)); ?>" alt="Therapy">
                    <?php else: ?>
                        <img src="<?php echo e(asset('front_assets/images/aaa.jpeg')); ?>" alt="Therapy">
                    <?php endif; ?>
                </div>
                <div class="about-exp-badge">
                    <?php
                        $expCounter = $progressCounters->firstWhere('title', 'Years Experience') ?? $progressCounters->first();
                    ?>
                    <span class="num"><?php echo e($expCounter ? $expCounter->number.$expCounter->suffix : '20+'); ?></span>
                    <span class="label">Years of<br>Expertise</span>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="p2gh-section bg-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Our Values</div>
            <h2 class="main-heading">Guided By <span>Purpose and Passion</span></h2>
        </div>

        <?php
            $aboutValues = collect($aboutsection->values ?? [])->filter(fn($v) => !empty($v['title']));
        ?>

        <div class="mv-grid">
            <?php if($aboutValues->count()): ?>
                <?php $__currentLoopData = $aboutValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mv-card" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 120); ?>">
                    <div class="mv-icon"><i class="bi bi-<?php echo e($value['icon'] ?? 'bullseye'); ?>"></i></div>
                    <h4><?php echo e($value['title']); ?></h4>
                    <p><?php echo e($value['description'] ?? ''); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="mv-card" data-aos="fade-up">
                <div class="mv-icon"><i class="bi bi-bullseye"></i></div>
                <h4>Our Mission</h4>
                <p>To deliver compassionate, expert physiotherapy care that relieves pain, restores mobility, and enhances quality of life for every patient — 24 hours a day, 7 days a week.</p>
            </div>
            <div class="mv-card" data-aos="fade-up" data-aos-delay="120">
                <div class="mv-icon"><i class="bi bi-lightbulb"></i></div>
                <h4>Our Vision</h4>
                <p>To be the most trusted physiotherapy provider — helping patients regain mobility and confidence through modern, evidence-based care that is always accessible.</p>
            </div>
            <div class="mv-card" data-aos="fade-up" data-aos-delay="240">
                <div class="mv-icon"><i class="bi bi-compass"></i></div>
                <h4>Our Approach</h4>
                <p>Personalized treatment plans focused on long-term healing, strength, and flexibility — addressing the root cause, not just the symptoms.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php if($faqs && $faqs->count()): ?>
<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 48px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;"><?php echo e($faqSection->sub_title ?? 'Got Questions?'); ?></div>
            <h2 class="main-heading"><?php echo e($faqSection->main_title ?? 'Frequently Asked Questions'); ?></h2>
        </div>
        <div class="faq-list" style="max-width:760px;margin:0 auto;" data-aos="fade-up">
            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="faq-item <?php echo e($loop->first ? 'open' : ''); ?>">
                <button class="faq-trigger">
                    <?php echo e($faq->question); ?>

                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-body"><?php echo e($faq->answer); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/front/about.blade.php ENDPATH**/ ?>