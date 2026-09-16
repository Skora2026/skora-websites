<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', settings('company_name') ?? 'Navodayan Neuroclinic & Neurorehab'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_desc', 'Navodayan Neuroclinic & Neurorehab. Expert neuro consultation, physiotherapy, and rehabilitation care. Book your appointment today.'); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(settings('favicon') ? asset('storage/' . settings('favicon')) : asset('front_assets/images/logo.png')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('front_assets/css/theme.css')); ?>">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700;800&family=Jost:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->make('layouts.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>


<div class="p2gh-topbar d-none d-lg-block">
    <div class="topbar-inner">
        <div class="topbar-info">
            <?php if(!empty(settings('company_address1'))): ?>
            <a href="#" class="topbar-item">
                <i class="bi bi-geo-alt-fill"></i>
                <span><?php echo e(settings('company_address1')); ?></span>
            </a>
            <?php endif; ?>
            <?php if(!empty(settings('company_mobile1'))): ?>
            <a href="tel:<?php echo e(settings('company_mobile1')); ?>" class="topbar-item">
                <i class="bi bi-telephone-fill"></i>
                <span><?php echo e(settings('company_mobile1')); ?></span>
            </a>
            <?php endif; ?>
            <?php if(!empty(settings('company_email1'))): ?>
            <a href="mailto:<?php echo e(settings('company_email1')); ?>" class="topbar-item">
                <i class="bi bi-envelope-fill"></i>
                <span><?php echo e(settings('company_email1')); ?></span>
            </a>
            <?php endif; ?>
            <div class="topbar-item">
                <i class="bi bi-clock-fill"></i>
                <span><?php echo e(settings('working_hours') ?? 'Physiotherapy: 9:30 AM to 7:00 PM'); ?></span>
            </div>
        </div>
        <div class="topbar-socials">
            <?php if(!empty(settings('instagram'))): ?>
            <a href="<?php echo e(settings('instagram')); ?>" class="topbar-social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <?php endif; ?>
            <?php if(!empty(settings('facebook'))): ?>
            <a href="<?php echo e(settings('facebook')); ?>" class="topbar-social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <?php endif; ?>
            <?php if(!empty(settings('company_whatsapp1'))): ?>
            <?php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); ?>
            <a href="https://wa.me/<?php echo e($wp); ?>" class="topbar-social-link" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <?php endif; ?>
            <?php if(!empty(settings('pintrest'))): ?>
            <a href="<?php echo e(settings('pintrest')); ?>" class="topbar-social-link" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php $navbarClass = trim($__env->yieldContent('navbar_class', '')); ?>
<script>
// Runs immediately as this point in the body is parsed — before CSS/JS
// libraries load — so a scroll-restored page (e.g. after refresh mid-page)
// never paints the wrong navbar state and then flickers to the correct one.
(function () {
    if (window.scrollY > 60) {
        document.documentElement.classList.add('nav-prescroll');
    }
})();
</script>
<nav class="p2gh-navbar <?php echo e($navbarClass); ?>" id="mainNav" data-hero="<?php echo e($navbarClass === 'transparent' ? '1' : '0'); ?>">
    <div class="nav-inner">

        
        <a href="<?php echo e(url('/')); ?>" class="nav-logo">
            <img src="<?php echo e(settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('front_assets/images/logo.png')); ?>"
                 alt="<?php echo e(settings('company_short_name') ?? 'P2GH'); ?>">
        </a>

        
        <ul class="nav-menu" id="navMenu">
            <li class="nav-item">
                <a href="<?php echo e(url('/')); ?>" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('/about-us')); ?>" class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" aria-haspopup="true">
                    Services <i class="bi bi-chevron-down" style="font-size:10px;"></i>
                </a>
                <div class="nav-dropdown">
                    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(url('/service-details/' . $service->slug)); ?>">
                        <i class="bi bi-activity"></i>
                        <?php echo e($service->name); ?>

                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <a href="#">No services found</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo e(url('/services')); ?>" style="font-weight:700;color:var(--primary);">
                        <i class="bi bi-grid-3x3-gap"></i>
                        View All Services
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('/blogs')); ?>" class="nav-link">Blogs</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" aria-haspopup="true">
                    Gallery <i class="bi bi-chevron-down" style="font-size:10px;"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="<?php echo e(url('/gallery')); ?>"><i class="bi bi-images"></i> Photo Gallery</a>
                    <a href="<?php echo e(url('/video')); ?>"><i class="bi bi-camera-video"></i> Video Gallery</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('/contact-us')); ?>" class="nav-link">Contact</a>
            </li>
            <li class="nav-item nav-cta-mobile">
                <button class="btn-p2gh openForm">
                    <span>Book Appointment</span>
                    <span class="btn-icon">↗</span>
                </button>
            </li>
        </ul>

        
        <div class="nav-cta">
            <button class="btn-p2gh openForm">
                <span>Book Appointment</span>
                <span class="btn-icon">↗</span>
            </button>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(url('/admin-dashboard')); ?>" class="btn-p2gh btn-p2gh-outline">Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

    </div>
</nav>


<?php echo $__env->yieldContent('content'); ?>


<div class="p2gh-ticker" aria-hidden="true">
    <div class="ticker-wrapper">
        <?php $tickerItems = hero_ticker_items(); ?>
        <?php $__currentLoopData = $tickerItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="ticker-item"><span class="t-dot"></span><?php echo e($item); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php $__currentLoopData = $tickerItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="ticker-item"><span class="t-dot"></span><?php echo e($item); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<footer class="p2gh-footer">
    <div class="container-p2gh">
        <div class="footer-grid">

            
            <div class="footer-brand">
                <img src="<?php echo e(settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('front_assets/images/logo.png')); ?>"
                     alt="<?php echo e(settings('company_short_name')); ?>" class="brand-logo">
                <p class="brand-desc"><?php echo e(settings('company_description') ?? 'Expert neuro consultation, physiotherapy, and rehabilitation care. We help you recover faster and live pain-free.'); ?></p>
                <div class="footer-socials">
                    <?php if(!empty(settings('instagram'))): ?>
                    <a href="<?php echo e(settings('instagram')); ?>" class="footer-social" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(!empty(settings('facebook'))): ?>
                    <a href="<?php echo e(settings('facebook')); ?>" class="footer-social" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if(!empty(settings('company_whatsapp1'))): ?>
                    <?php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); ?>
                    <a href="https://wa.me/<?php echo e($wp); ?>" class="footer-social" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <?php endif; ?>
                    <?php if(!empty(settings('pintrest'))): ?>
                    <a href="<?php echo e(settings('pintrest')); ?>" class="footer-social" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="footer-col">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo e(url('/about-us')); ?>">About Us</a></li>
                    <li><a href="<?php echo e(url('/services')); ?>">Services</a></li>
                    <li><a href="<?php echo e(url('/blogs')); ?>">Blogs</a></li>
                    <li><a href="<?php echo e(url('/gallery')); ?>">Gallery</a></li>
                    <li><a href="<?php echo e(url('/contact-us')); ?>">Contact</a></li>
                </ul>
            </div>

            
            <div class="footer-col">
                <h5>Our Services</h5>
                <ul class="footer-links">
                    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li><a href="<?php echo e(url('/service-details/' . $service->slug)); ?>"><?php echo e($service->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li><span style="color:rgba(255,255,255,0.3);font-size:14px;">No services found</span></li>
                    <?php endif; ?>
                </ul>
            </div>

            
            <div class="footer-col">
                <h5>Contact Us</h5>

                <?php if(!empty(settings('company_address2'))): ?>
                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div class="fci-text">
                        <h6>Address</h6>
                        <p><?php echo e(settings('company_address2')); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty(settings('company_email1'))): ?>
                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div class="fci-text">
                        <h6>Email</h6>
                        <a href="mailto:<?php echo e(settings('company_email1')); ?>"><?php echo e(settings('company_email1')); ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!empty(settings('company_mobile1'))): ?>
                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div class="fci-text">
                        <h6>Phone</h6>
                        <a href="tel:<?php echo e(settings('company_mobile1')); ?>"><?php echo e(settings('company_mobile1')); ?></a>
                        <?php if(!empty(settings('company_mobile2'))): ?><br>
                        <a href="tel:<?php echo e(settings('company_mobile2')); ?>"><?php echo e(settings('company_mobile2')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-clock-fill"></i></div>
                    <div class="fci-text">
                        <h6>Office Timings</h6>
                        <?php $officeTimings = settings('office_timings'); ?>
                        <?php if(!empty($officeTimings)): ?>
                            <?php $__currentLoopData = $officeTimings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p style="margin-bottom:2px;"><strong><?php echo e($timing['title'] ?? ''); ?>:</strong> <?php echo e($timing['time'] ?? ''); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p><?php echo e(settings('working_hours') ?? 'Physiotherapy: 9:30 AM to 7:00 PM'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© <?php echo e(date('Y')); ?> <?php echo e(settings('company_name') ?? 'P2GH - 24*7 Physiotherapy'); ?>. All rights reserved.</p>
            <p>Designed &amp; Developed by <a href="https://www.skorasoft.com/" target="_blank" rel="noopener">SkoraSoft</a></p>
        </div>
    </div>
</footer>


<div class="p2gh-popup" id="popupForm" role="dialog" aria-modal="true" aria-label="Book Appointment">
    <div class="popup-box">
        <div class="popup-header">
            <div>
                <h3>Book Appointment</h3>
                <p>We'll confirm your slot within 2 hours</p>
            </div>
            <button class="popup-close" id="closeForm" aria-label="Close">✕</button>
        </div>
        <div class="popup-body">
            <form action="<?php echo e(route('admin.appointments.save')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control-p2gh" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control-p2gh" placeholder="your@email.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone" class="form-control-p2gh" placeholder="10-digit mobile number" minlength="10" maxlength="10" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Select Service *</label>
                    <select name="service" class="form-control-p2gh" required>
                        <option value="">Choose a service</option>
                        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <option value="<?php echo e($service->name); ?>"><?php echo e($service->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <option disabled>No services available</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Message (Optional)</label>
                    <textarea name="message" class="form-control-p2gh" placeholder="Describe your symptoms or any specific concerns..."></textarea>
                </div>
                <button type="submit" class="btn-p2gh btn-p2gh-accent" style="width:100%;margin-top:8px;">
                    <span>Submit Appointment Request</span>
                    <span class="btn-icon">→</span>
                </button>
            </form>
        </div>
    </div>
</div>


<div class="float-actions">
    <?php if(!empty(settings('company_whatsapp1'))): ?>
    <?php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); ?>
    <a href="https://wa.me/<?php echo e($wp); ?>?text=Hello, I would like to book a physiotherapy appointment." class="float-btn whatsapp" target="_blank" rel="noopener" title="WhatsApp Us">
        <i class="bi bi-whatsapp"></i>
    </a>
    <?php endif; ?>
    <?php if(!empty(settings('company_mobile1'))): ?>
    <a href="tel:<?php echo e(settings('company_mobile1')); ?>" class="float-btn phone" title="Call Us">
        <i class="bi bi-telephone-fill"></i>
    </a>
    <?php endif; ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ── Topbar height → CSS variable (fixed navbar offset) ────────
    function syncTopbarHeight() {
        var topbar = document.querySelector('.p2gh-topbar');
        if (!topbar) return;
        var isVisible = window.getComputedStyle(topbar).display !== 'none';
        document.documentElement.style.setProperty(
            '--topbar-height',
            isVisible ? topbar.offsetHeight + 'px' : '0px'
        );
    }
    syncTopbarHeight();
    window.addEventListener('resize', syncTopbarHeight);

    // ── AOS init ──────────────────────────────────────────────────
    if (window.AOS) {
        AOS.init({ duration: 750, once: true, offset: 60, easing: 'ease-out-cubic' });
    }

    // ── Navbar scroll state ───────────────────────────────────────
    var nav = document.getElementById('mainNav');

    function updateNavbarOnScroll() {
        if (window.scrollY > 60) {
            nav.classList.remove('transparent');
            nav.classList.add('scrolled');
        } else if (nav.dataset.hero === '1') {
            nav.classList.add('transparent');
            nav.classList.remove('scrolled');
        } else {
            nav.classList.remove('transparent');
            nav.classList.remove('scrolled');
        }
    }
    updateNavbarOnScroll();
    window.addEventListener('scroll', updateNavbarOnScroll, { passive: true });
    document.documentElement.classList.remove('nav-prescroll');

    // ── Mobile nav drawer ─────────────────────────────────────────
    var navToggle = document.getElementById('navToggle');

    function closeMobileNav() {
        nav.classList.remove('mobile-open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        document.querySelectorAll('.nav-menu .nav-item.dropdown-open').forEach(function (item) {
            item.classList.remove('dropdown-open');
        });
    }

    navToggle.addEventListener('click', function () {
        var isOpen = nav.classList.toggle('mobile-open');
        navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        document.body.style.overflow = isOpen ? 'hidden' : '';
        if (!isOpen) {
            document.querySelectorAll('.nav-menu .nav-item.dropdown-open').forEach(function (item) {
                item.classList.remove('dropdown-open');
            });
        }
    });

    // Close drawer with Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && nav.classList.contains('mobile-open')) closeMobileNav();
    });

    // Mobile dropdown tap-toggle (desktop uses hover)
    document.querySelectorAll('.nav-menu .nav-item').forEach(function (item) {
        var dropdown = item.querySelector('.nav-dropdown');
        if (!dropdown) return;

        var trigger = item.querySelector('.nav-link');
        trigger.addEventListener('click', function (e) {
            if (!nav.classList.contains('mobile-open')) return; // desktop = hover
            e.preventDefault();
            var wasOpen = item.classList.contains('dropdown-open');
            document.querySelectorAll('.nav-menu .nav-item.dropdown-open').forEach(function (openItem) {
                if (openItem !== item) openItem.classList.remove('dropdown-open');
            });
            item.classList.toggle('dropdown-open', !wasOpen);
        });
    });

    // ── Popup appointment form ────────────────────────────────────
    var popup = document.getElementById('popupForm');
    var closeBtn = document.getElementById('closeForm');

    document.querySelectorAll('.openForm').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (nav.classList.contains('mobile-open')) closeMobileNav();
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
            var firstField = popup.querySelector('input[name="name"]');
            if (firstField) setTimeout(function () { firstField.focus(); }, 250);
        });
    });

    function closePopup() {
        popup.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', function (e) {
        if (e.target === popup) closePopup();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && popup.classList.contains('active')) closePopup();
    });

    // ── FAQ accordion (smooth grid-rows animation) ────────────────
    document.querySelectorAll('.faq-trigger').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var item = trigger.closest('.faq-item');
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(function (i) { i.classList.remove('open'); });
            if (!isOpen) item.classList.add('open');
        });
    });

    // ── Testimonial Swiper ────────────────────────────────────────
    if (window.Swiper && document.querySelector('.testimonial-slider')) {
        new Swiper('.testimonial-slider', {
            loop: document.querySelectorAll('.testimonial-slider .swiper-slide').length > 3,
            speed: reduceMotion ? 0 : 850,
            autoplay: reduceMotion ? false : { delay: 4200, disableOnInteraction: false, pauseOnMouseEnter: true },
            spaceBetween: 24,
            grabCursor: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1200: { slidesPerView: 3 }
            }
        });
    }

    // ── Counter animation (fixed-timing rAF version) ──────────────
    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-target'), 10) || 0;
        var suffix = el.getAttribute('data-suffix') || '';
        if (reduceMotion) { el.textContent = target + suffix; return; }
        var duration = 1600;
        var start = null;
        function tick(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(target * eased) + suffix;
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    var counterEls = document.querySelectorAll('[data-target]');
    if (counterEls.length) {
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counterEls.forEach(function (el) { counterObserver.observe(el); });
    }

    // ── Scroll reveal system (classes: reveal / reveal-left / reveal-right / reveal-zoom / reveal-img) ──
    var revealEls = document.querySelectorAll('.reveal, .reveal-img');
    if (revealEls.length) {
        if (reduceMotion || !('IntersectionObserver' in window)) {
            revealEls.forEach(function (el) { el.classList.add('is-visible'); });
        } else {
            var revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
            revealEls.forEach(function (el) { revealObserver.observe(el); });
        }
    }

    // ── Subtle hero parallax (transform-only, rAF-throttled) ──────
    var heroBg = document.querySelector('.hero-bg');
    if (heroBg && !reduceMotion) {
        var ticking = false;
        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(function () {
                var y = window.scrollY;
                if (y < window.innerHeight * 1.2) {
                    heroBg.style.transform = 'translate3d(0,' + (y * 0.22) + 'px,0)';
                }
                ticking = false;
            });
        }, { passive: true });
    }
})();
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Navodaya\navodaya-extract\public_html\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>