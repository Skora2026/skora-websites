
<?php $__env->startSection('title', 'Contact Us - ' . (settings('company_name') ?? 'Website')); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('<?php echo e(asset('front_assets/images/hero-contact.jpg')); ?>');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Contact Us</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="sep">/</span>
            <span>Contact Us</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="contact-grid">

            <div class="contact-info-card" data-aos="fade-up">
                <h3>Get In Touch</h3>
                <p>We're here for you around the clock - reach out via call, WhatsApp, or drop by anytime.</p>

                <?php if(!empty(settings('company_address2'))): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6>Our Location</h6>
                        <p><?php echo e(settings('company_address2')); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty(settings('company_mobile1'))): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <h6>Phone Number</h6>
                        <a href="tel:<?php echo e(settings('company_mobile1')); ?>"><?php echo e(settings('company_mobile1')); ?></a><?php if(!empty(settings('company_mobile2'))): ?><br>
                        <a href="tel:<?php echo e(settings('company_mobile2')); ?>"><?php echo e(settings('company_mobile2')); ?></a><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty(settings('company_email1'))): ?>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <h6>Email Address</h6>
                        <a href="mailto:<?php echo e(settings('company_email1')); ?>"><?php echo e(settings('company_email1')); ?></a><?php if(!empty(settings('company_email2'))): ?><br>
                        <a href="mailto:<?php echo e(settings('company_email2')); ?>"><?php echo e(settings('company_email2')); ?></a><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <h6>Working Hours</h6>
                        <?php $officeTimings = settings('office_timings'); ?>
                        <?php if(!empty($officeTimings)): ?>
                            <?php $__currentLoopData = $officeTimings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p style="margin-bottom:2px;"><strong><?php echo e($timing['title'] ?? ''); ?>:</strong> <?php echo e($timing['time'] ?? ''); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p>Physiotherapy: 9:30 AM to 7:00 PM &middot; Neuro Consultant: 7:00 PM to 8:00 PM</p>
                        <?php endif; ?>
                        <span style="color:rgba(255,255,255,0.5);font-size:13px;">For appointments &amp; enquiries, call or WhatsApp us anytime.</span>
                    </div>
                </div>
            </div>

            <div class="contact-form-card" data-aos="fade-up" data-aos-delay="120">
                <div class="section-label">Send Us A Message</div>
                <h2 class="main-heading" style="font-size:1.9rem;">We Would Love <span>To Hear From You</span></h2>
                <p class="section-desc">Fill in the form below and we will get back to you within a few hours.</p>

                <?php if(session('success')): ?>
                <div class="contact-success-note">
                    <?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>

                <form action="<?php echo e(route('contact.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control-p2gh" placeholder="Your full name" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" name="phone" class="form-control-p2gh" placeholder="10-digit number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control-p2gh" placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control-p2gh" placeholder="How can we help you?">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Your Message *</label>
                        <textarea name="message" class="form-control-p2gh" placeholder="Describe your condition or inquiry in detail..." required></textarea>
                    </div>
                    <button type="submit" class="btn-p2gh btn-p2gh-accent" style="width:100%;">
                        <span>Send Message</span>
                        <span class="btn-icon">→</span>
                    </button>
                </form>
            </div>

        </div>

        <?php if(!empty(settings('map'))): ?>
        <div class="contact-map-wrap" data-aos="fade-up">
            <?php
                $mapValue = trim(settings('map'));
            ?>
            <?php if(stripos($mapValue, '<iframe') !== false): ?>
                
                <?php echo $mapValue; ?>

            <?php else: ?>
                
                <iframe
                    src="<?php echo e($mapValue); ?>"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/front/contact.blade.php ENDPATH**/ ?>