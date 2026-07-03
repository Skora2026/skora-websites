<?php $__env->startSection('title', 'P2GH - 24*7 Physiotherapy | Expert Care, Always Available'); ?>
<?php $__env->startSection('navbar_class', 'transparent'); ?>

<?php $__env->startSection('content'); ?>


<section class="p2gh-hero">
    <div class="hero-bg" style="background-image: url('<?php echo e($hero && $hero->image ? asset('storage/'.$hero->image) : asset('front_assets/images/home-banner.jpg')); ?>');"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <div data-aos="fade-up">
            <div class="hero-badge">
                <span class="dot"></span>
                <?php echo e($hero?->badge_text ?? ((settings('company_short_name') ?? 'P2GH') . ' — 24×7 Physiotherapy')); ?>

            </div>

            <h1 class="hero-title">
                <?php echo e($hero && $hero->heading ? $hero->heading : 'Move Without Pain.'); ?>

                <span class="line2"><?php echo e($hero && $hero->subheading ? $hero->subheading : 'Live Without Limits.'); ?></span>
            </h1>

            <p class="hero-desc" data-aos="fade-up" data-aos-delay="100">
                <?php echo e($hero && $hero->description ? $hero->description : 'Expert physiotherapy care available round the clock. Our certified therapists help you recover faster, move better, and live pain-free — every single day.'); ?>

            </p>

            <div class="hero-actions" data-aos="fade-up" data-aos-delay="200">
                <button class="btn-p2gh btn-p2gh-accent openForm" style="font-size:15px;padding:15px 36px;">
                    <span><?php echo e($hero?->btn_text ?? 'Book Appointment'); ?></span>
                    <span class="btn-icon">↗</span>
                </button>
                <a href="<?php echo e(url('/services')); ?>" class="btn-p2gh-outline" style="color:#fff;border-color:rgba(255,255,255,0.5);font-size:15px;padding:14px 32px;">
                    <?php echo e($hero?->btn2_text ?? 'Explore Services'); ?>

                </a>
            </div>
        </div>

        
        <?php if($progressCounters && $progressCounters->count()): ?>
        <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
            <?php $__currentLoopData = $progressCounters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="hero-stat-item">
                <div class="hero-stat-num">
                    <span data-target="<?php echo e($counter->number); ?>" data-suffix="<?php echo e($counter->suffix ?? '+'); ?>">
                        <?php echo e($counter->number); ?><?php echo e($counter->suffix ?? '+'); ?>

                    </span>
                </div>
                <div class="hero-stat-label"><?php echo e($counter->title); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="hero-float-card" data-aos="fade-left" data-aos-delay="500">
        <div class="hero-float-icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <div class="hero-float-text">
            <strong><?php echo e($hero?->floating_title ?? 'Expert Therapists'); ?></strong>
            <span><?php echo e($hero?->floating_subtitle ?? 'BPT · MPT · COMT certified'); ?></span>
        </div>
    </div>
</section>



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



<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Vision To Victory</div>
            <h2 class="main-heading">A <span>Recognized Leader</span> In Quality Rehabilitation</h2>
        </div>

        <div class="mv-grid">
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
        </div>
    </div>
</section>



<?php if($indexservices && $indexservices->count()): ?>
<section class="p2gh-section bg-light">
    <div class="container-p2gh">
        <div class="section-header-flex">
            <div class="section-header-left">
                <div class="section-label" data-aos="fade-up">Our Services</div>
                <h2 class="main-heading" data-aos="fade-up" data-aos-delay="80">
                    Comprehensive <span>Physiotherapy</span> Services
                </h2>
                <p class="section-desc" data-aos="fade-up" data-aos-delay="120">
                    We offer a full spectrum of physiotherapy treatments designed to relieve pain, restore mobility, and improve your overall quality of life.
                </p>
            </div>
            <a href="<?php echo e(url('/services')); ?>" class="btn-p2gh" data-aos="fade-left">
                <span>All Services</span><span class="btn-icon">↗</span>
            </a>
        </div>

        <div class="services-grid">
            <?php $__currentLoopData = $indexservices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 80); ?>">
                <a href="<?php echo e(route('service.detail', $service->slug)); ?>">
                    <div class="service-card-img">
                        <?php if($service->image): ?>
                            <img src="<?php echo e(asset('storage/'.$service->image)); ?>" alt="<?php echo e($service->name); ?>">
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
</section>
<?php endif; ?>



<?php $why = $whyChooseUsSections->first(); ?>
<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="why-grid">

            <div class="why-img-wrap" data-aos="fade-right">
                <div class="why-img-main">
                    <?php if($why && $why->right_image): ?>
                        <img src="<?php echo e(asset('storage/'.$why->right_image)); ?>" alt="Why Choose <?php echo e(settings('company_short_name') ?? 'P2GH'); ?>">
                    <?php else: ?>
                        <img src="<?php echo e(asset('front_assets/images/doctor.png')); ?>" alt="Why Choose P2GH">
                    <?php endif; ?>
                </div>
                <?php $satisfactionCounter = $progressCounters->where('title', 'Success Rate')->first() ?? $progressCounters->last(); ?>
                <div class="why-accent-card" data-aos="zoom-in" data-aos-delay="300">
                    <span class="big-num"><?php echo e($satisfactionCounter ? $satisfactionCounter->number.$satisfactionCounter->suffix : '98%'); ?></span>
                    <span class="label">Patient<br>Satisfaction</span>
                </div>
            </div>

            <div data-aos="fade-left">
                <div class="section-label"><?php echo e($why->sub_title ?? 'Why Choose Us'); ?></div>
                <h2 class="main-heading">
                    <?php if($why && $why->main_title): ?>
                        <?php echo $why->main_title; ?>

                    <?php else: ?>
                        Excellence In <span>Care</span> And Rehabilitation
                    <?php endif; ?>
                </h2>
                <p class="section-desc" style="margin-bottom:8px;">
                    We combine expert physiotherapy with personalized treatment plans so you get lasting recovery, not just temporary relief.
                </p>

                <div class="why-list">
                    <?php if($whyChooseUsSections && $whyChooseUsSections->count()): ?>
                        <?php if($why && $why->features && count($why->features)): ?>
                            <?php $__currentLoopData = array_slice($why->features, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="why-item" data-aos="fade-up" data-aos-delay="<?php echo e($index * 80); ?>">
                                <div class="why-item-icon <?php echo e($index % 2 !== 0 ? 'accent' : ''); ?>">
                                    <i class="bi bi-<?php echo e($feature['icon'] ?? 'check-circle'); ?>"></i>
                                </div>
                                <div class="why-item-body">
                                    <h5><?php echo e($feature['title'] ?? ''); ?></h5>
                                    <p><?php echo e($feature['description'] ?? ''); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        
                        <div class="why-item" data-aos="fade-up">
                            <div class="why-item-icon"><i class="bi bi-people"></i></div>
                            <div class="why-item-body"><h5>Experienced Team</h5><p>Certified physiotherapists committed to quality care and your complete recovery.</p></div>
                        </div>
                        <div class="why-item" data-aos="fade-up" data-aos-delay="80">
                            <div class="why-item-icon accent"><i class="bi bi-heart-pulse"></i></div>
                            <div class="why-item-body"><h5>Patient-Centered Approach</h5><p>Every treatment plan is customized around your unique condition and recovery goals.</p></div>
                        </div>
                        <div class="why-item" data-aos="fade-up" data-aos-delay="160">
                            <div class="why-item-icon"><i class="bi bi-cpu"></i></div>
                            <div class="why-item-body"><h5>Advanced Technology</h5><p>Modern diagnostic tools and treatment equipment for precise, effective therapy.</p></div>
                        </div>
                        <div class="why-item" data-aos="fade-up" data-aos-delay="240">
                            <div class="why-item-icon accent"><i class="bi bi-clock"></i></div>
                            <div class="why-item-body"><h5>24×7 Availability</h5><p>We're here whenever you need us — day or night, on call for your recovery.</p></div>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                    <div class="why-item" data-aos="fade-up">
                        <div class="why-item-icon"><i class="bi bi-people"></i></div>
                        <div class="why-item-body"><h5>Experienced Team</h5><p>Certified physiotherapists committed to quality care and your complete recovery.</p></div>
                    </div>
                    <div class="why-item" data-aos="fade-up" data-aos-delay="80">
                        <div class="why-item-icon accent"><i class="bi bi-heart-pulse"></i></div>
                        <div class="why-item-body"><h5>Patient-Centered Approach</h5><p>Every treatment plan is customized around your unique condition and recovery goals.</p></div>
                    </div>
                    <div class="why-item" data-aos="fade-up" data-aos-delay="160">
                        <div class="why-item-icon"><i class="bi bi-cpu"></i></div>
                        <div class="why-item-body"><h5>Advanced Technology</h5><p>Modern diagnostic tools and treatment equipment for precise, effective therapy.</p></div>
                    </div>
                    <div class="why-item" data-aos="fade-up" data-aos-delay="240">
                        <div class="why-item-icon accent"><i class="bi bi-clock"></i></div>
                        <div class="why-item-body"><h5>24×7 Availability</h5><p>We're here whenever you need us — day or night, on call for your recovery.</p></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>



<?php if($processSteps && $processSteps->count()): ?>
<section class="p2gh-section bg-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:600px;margin:0 auto 64px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">How It Works</div>
            <h2 class="main-heading">
                <?php echo e($processSteps->count()); ?> Simple Steps To <span>Begin Your Recovery</span>
            </h2>
            <p class="section-desc">Getting physiotherapy care at <?php echo e(settings('company_short_name') ?? 'P2GH'); ?> is straightforward. Book, assess, and recover — we handle everything else.</p>
        </div>

        <?php $psCols = min($processSteps->count(), 3); ?>
        <div class="process-steps" data-steps="<?php echo e($psCols); ?>" style="grid-template-columns: repeat(<?php echo e($psCols); ?>, 1fr); --ps-cols: <?php echo e($psCols); ?>;">
            <?php $__currentLoopData = $processSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="process-step" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 150); ?>">
                <div class="step-num-wrap">
                    <div class="step-circle-outer">
                        <div class="step-inner-circle"><?php echo e($step->step_number); ?></div>
                    </div>
                    <div class="step-badge"><?php echo e($loop->last ? '✓' : '→'); ?></div>
                </div>
                <h4><?php echo e($step->title); ?></h4>
                <p><?php echo e($step->description); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>



<?php if($testimonials && $testimonials->count()): ?>
<section class="p2gh-section bg-light">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:580px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Patient Reviews</div>
            <h2 class="main-heading">What Our <span>Patients</span> Say</h2>
            <p class="section-desc">Real recovery stories from real patients. Hear how <?php echo e(settings('company_short_name') ?? 'P2GH'); ?> has helped people get back to living fully.</p>
        </div>

        <div class="swiper testimonial-slider">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-stars"><?php echo e(str_repeat('★', (int)$t->rating)); ?></div>
                        <p class="testimonial-text">"<?php echo e($t->message); ?>"</p>
                        <div class="testimonial-client">
                            <img src="<?php echo e($t->client_image ? asset('storage/'.$t->client_image) : asset('front_assets/images/avtar-2.jpg')); ?>" alt="<?php echo e($t->client_name); ?>">
                            <div>
                                <div class="client-name"><?php echo e($t->client_name); ?></div>
                                <div class="client-role">Verified Patient</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="swiper-pagination" style="margin-top:32px;position:relative;"></div>
        </div>
    </div>
</section>
<?php endif; ?>



<?php if($blogs && $blogs->count()): ?>
<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-flex">
            <div class="section-header-left">
                <div class="section-label" data-aos="fade-up">News & Insights</div>
                <h2 class="main-heading" data-aos="fade-up" data-aos-delay="80">
                    Our Latest <span>Health Tips</span> And Updates
                </h2>
                <p class="section-desc" data-aos="fade-up" data-aos-delay="120">
                    Expert insights, recovery tips, and the latest updates to help you stay pain-free and active.
                </p>
            </div>
            <a href="<?php echo e(url('/blogs')); ?>" class="btn-p2gh" data-aos="fade-left">
                <span>All Blogs</span><span class="btn-icon">↗</span>
            </a>
        </div>

        <div class="blog-grid">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="blog-card" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                <a href="<?php echo e(url('/blog-details/'.$blog->slug)); ?>">
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
         <?php if($cta): ?>
        <div class="cta-banner" data-aos="zoom-in" style="margin-top:40px;<?php echo e($cta->background_image ? 'background-image:url(\''.asset('storage/'.$cta->background_image).'\');background-size:cover;background-position:center;' : ''); ?>">
            <div>
                <h3><?php echo e($cta->heading ?? 'Ready To Start Your Recovery Journey?'); ?></h3>
                <p><?php echo e($cta->description ?? 'Book your consultation today — 24×7 appointments available.'); ?></p>
            </div>
            <?php if(!empty($cta->button_link)): ?>
            <a href="<?php echo e($cta->button_link); ?>" class="btn-p2gh btn-p2gh-white" style="flex-shrink:0;">
                <span><?php echo e($cta->button_text ?? 'Book Now'); ?></span>
                <span class="btn-icon" style="color:var(--primary);">↗</span>
            </a>
            <?php else: ?>
            <button class="btn-p2gh btn-p2gh-white openForm" style="flex-shrink:0;">
                <span><?php echo e($cta->button_text ?? 'Book Now'); ?></span>
                <span class="btn-icon" style="color:var(--primary);">↗</span>
            </button>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="cta-banner" data-aos="zoom-in" style="margin-top:40px;">
            <div>
                <h3>Ready To Start Your Recovery Journey?</h3>
                <p>Book your initial consultation today — 24×7 appointments available.</p>
            </div>
            <button class="btn-p2gh btn-p2gh-white openForm" style="flex-shrink:0;">
                <span>Book Now</span>
                <span class="btn-icon" style="color:var(--primary);">↗</span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dr_deepak_pal\resources\views/front/index.blade.php ENDPATH**/ ?>