<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', settings('company_name') ?? 'Navodayan Neuroclinic & Neurorehab')</title>
    <meta name="description" content="@yield('meta_desc', 'Navodayan Neuroclinic & Neurorehab. Expert neuro consultation, physiotherapy, and rehabilitation care. Book your appointment today.')">
    <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) : asset('front_assets/images/logo.png') }}">

    {{-- Master CSS - Single file for entire website --}}
    <link rel="stylesheet" href="{{ asset('front_assets/css/theme.css') }}">

    {{-- External Libraries --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700;800&family=Jost:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @stack('styles')
    @include('layouts.notification')
</head>
<body>

{{-- ===== TOP BAR ===== --}}
<div class="p2gh-topbar d-none d-lg-block">
    <div class="topbar-inner">
        <div class="topbar-info">
            @if(!empty(settings('company_address1')))
            <a href="#" class="topbar-item">
                <i class="bi bi-geo-alt-fill"></i>
                <span>{{ settings('company_address1') }}</span>
            </a>
            @endif
            @if(!empty(settings('company_mobile1')))
            <a href="tel:{{ settings('company_mobile1') }}" class="topbar-item">
                <i class="bi bi-telephone-fill"></i>
                <span>{{ settings('company_mobile1') }}</span>
            </a>
            @endif
            @if(!empty(settings('company_email1')))
            <a href="mailto:{{ settings('company_email1') }}" class="topbar-item">
                <i class="bi bi-envelope-fill"></i>
                <span>{{ settings('company_email1') }}</span>
            </a>
            @endif
            <div class="topbar-item">
                <i class="bi bi-clock-fill"></i>
                <span>{{ settings('working_hours') ?? 'Physiotherapy: 9:30 AM to 7:00 PM' }}</span>
            </div>
        </div>
        <div class="topbar-socials">
            @if(!empty(settings('instagram')))
            <a href="{{ settings('instagram') }}" class="topbar-social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            @endif
            @if(!empty(settings('facebook')))
            <a href="{{ settings('facebook') }}" class="topbar-social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            @endif
            @if(!empty(settings('company_whatsapp1')))
            @php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); @endphp
            <a href="https://wa.me/{{ $wp }}" class="topbar-social-link" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            @endif
            @if(!empty(settings('pintrest')))
            <a href="{{ settings('pintrest') }}" class="topbar-social-link" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            @endif
        </div>
    </div>
</div>

{{-- ===== NAVBAR ===== --}}
@php $navbarClass = trim($__env->yieldContent('navbar_class', '')); @endphp
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
<nav class="p2gh-navbar {{ $navbarClass }}" id="mainNav" data-hero="{{ $navbarClass === 'transparent' ? '1' : '0' }}">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="nav-logo">
            <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('front_assets/images/logo.png') }}"
                 alt="{{ settings('company_short_name') ?? 'Navodayan' }}">
        </a>

        {{-- Menu --}}
        <ul class="nav-menu" id="navMenu">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/about-us') }}" class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" aria-haspopup="true">
                    Services <i class="bi bi-chevron-down" style="font-size:10px;"></i>
                </a>
                <div class="nav-dropdown">
                    @forelse($services as $service)
                    <a href="{{ url('/service-details/' . $service->slug) }}">
                        <i class="bi bi-activity"></i>
                        {{ $service->name }}
                    </a>
                    @empty
                    <a href="#">No services found</a>
                    @endforelse
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('/services') }}" style="font-weight:700;color:var(--primary);">
                        <i class="bi bi-grid-3x3-gap"></i>
                        View All Services
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ url('/blogs') }}" class="nav-link">Blogs</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" aria-haspopup="true">
                    Gallery <i class="bi bi-chevron-down" style="font-size:10px;"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="{{ url('/gallery') }}"><i class="bi bi-images"></i> Photo Gallery</a>
                    <a href="{{ url('/video') }}"><i class="bi bi-camera-video"></i> Video Gallery</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ url('/camps') }}" class="nav-link">Camps</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/contact-us') }}" class="nav-link">Contact</a>
            </li>
            <li class="nav-item nav-cta-mobile">
                <button class="btn-p2gh openForm">
                    <span>Book Appointment</span>
                    <span class="btn-icon">↗</span>
                </button>
                <a href="{{ url('/camps') }}" class="btn-p2gh btn-p2gh-outline" style="width:100%;margin-top:10px;">
                    <span>Camps</span>
                    <span class="btn-icon">↗</span>
                </a>
            </li>
        </ul>

        {{-- CTA --}}
        <div class="nav-cta">
            <button class="btn-p2gh openForm">
                <span>Book Appointment</span>
                <span class="btn-icon">↗</span>
            </button>
            <a href="{{ url('/camps') }}" class="btn-p2gh btn-camps">
                <span>Camps</span>
                <span class="btn-icon">↗</span>
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

    </div>
</nav>

{{-- ===== PAGE CONTENT ===== --}}
@yield('content')

{{-- ===== TICKER (Dynamic — from HeroBanner.move_text, split by "||") ===== --}}
<div class="p2gh-ticker" aria-hidden="true">
    <div class="ticker-wrapper">
        @php $tickerItems = hero_ticker_items(); @endphp
        @foreach($tickerItems as $item)
        <span class="ticker-item"><span class="t-dot"></span>{{ $item }}</span>
        @endforeach
        {{-- Duplicate for seamless loop --}}
        @foreach($tickerItems as $item)
        <span class="ticker-item"><span class="t-dot"></span>{{ $item }}</span>
        @endforeach
    </div>
</div>

{{-- ===== FOOTER ===== --}}
<footer class="p2gh-footer">
    <div class="container-p2gh">
        <div class="footer-grid">

            {{-- Brand --}}
            <div class="footer-brand">
                <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) : asset('front_assets/images/logo.png') }}"
                     alt="{{ settings('company_short_name') }}" class="brand-logo">
                <p class="brand-desc">{{ settings('company_description') ?? 'Expert neuro consultation, physiotherapy, and rehabilitation care. We help you recover faster and live pain-free.' }}</p>
                <div class="footer-socials">
                    @if(!empty(settings('instagram')))
                    <a href="{{ settings('instagram') }}" class="footer-social" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if(!empty(settings('facebook')))
                    <a href="{{ settings('facebook') }}" class="footer-social" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if(!empty(settings('company_whatsapp1')))
                    @php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); @endphp
                    <a href="https://wa.me/{{ $wp }}" class="footer-social" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    @endif
                    @if(!empty(settings('pintrest')))
                    <a href="{{ settings('pintrest') }}" class="footer-social" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="footer-col">
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about-us') }}">About Us</a></li>
                    <li><a href="{{ url('/services') }}">Services</a></li>
                    <li><a href="{{ url('/blogs') }}">Blogs</a></li>
                    <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                    <li><a href="{{ url('/camps') }}">Health Camps</a></li>
                    <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div class="footer-col">
                <h5>Our Services</h5>
                <ul class="footer-links">
                    @forelse($services as $service)
                    <li><a href="{{ url('/service-details/' . $service->slug) }}">{{ $service->name }}</a></li>
                    @empty
                    <li><span style="color:rgba(255,255,255,0.3);font-size:14px;">No services found</span></li>
                    @endforelse
                </ul>
            </div>

            {{-- Contact --}}
            <div class="footer-col">
                <h5>Contact Us</h5>

                @if(!empty(settings('company_address2')))
                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div class="fci-text">
                        <h6>Address</h6>
                        <p>{{ settings('company_address2') }}</p>
                    </div>
                </div>
                @endif

                @if(!empty(settings('company_email1')))
                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div class="fci-text">
                        <h6>Email</h6>
                        <a href="mailto:{{ settings('company_email1') }}">{{ settings('company_email1') }}</a>
                    </div>
                </div>
                @endif

                @if(!empty(settings('company_mobile1')))
                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div class="fci-text">
                        <h6>Phone</h6>
                        <a href="tel:{{ settings('company_mobile1') }}">{{ settings('company_mobile1') }}</a>
                        @if(!empty(settings('company_mobile2')))<br>
                        <a href="tel:{{ settings('company_mobile2') }}">{{ settings('company_mobile2') }}</a>
                        @endif
                    </div>
                </div>
                @endif

                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-clock-fill"></i></div>
                    <div class="fci-text">
                        <h6>Office Timings</h6>
                        @php $officeTimings = settings('office_timings'); @endphp
                        @if(!empty($officeTimings))
                            @foreach($officeTimings as $timing)
                                <p style="margin-bottom:2px;"><strong>{{ $timing['title'] ?? '' }}:</strong> {{ $timing['time'] ?? '' }}</p>
                            @endforeach
                        @else
                            <p>{{ settings('working_hours') ?? 'Physiotherapy: 9:30 AM to 7:00 PM' }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} {{ settings('company_name') ?? 'Navodayan Neuroclinic & Neurorehab' }}. All rights reserved.</p>
            <p>Designed &amp; Developed by <a href="https://www.skorasoft.com/" target="_blank" rel="noopener">SkoraSoft</a></p>
        </div>
    </div>
</footer>

{{-- ===== POPUP APPOINTMENT FORM ===== --}}
<div class="p2gh-popup" id="popupForm" role="dialog" aria-modal="true" aria-label="Book Appointment">
    <div class="popup-box">
        <div class="popup-header">
            <div>
                <h3>Book Appointment</h3>
                <p>Pick your preferred slot — our team will confirm its availability</p>
            </div>
            <button class="popup-close" id="closeForm" aria-label="Close">✕</button>
        </div>
        <div class="popup-body">
            <form action="{{ route('admin.appointments.save') }}" method="POST">
                @csrf
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
                        @forelse($services as $service)
                        <option value="{{ $service->name }}">{{ $service->name }}</option>
                        @empty
                        <option disabled>No services available</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Preferred Visit Date *</label>
                    <input type="date" name="preferred_date" id="preferredDate" class="form-control-p2gh" required min="">
                </div>
                <div class="form-group">
                    <label class="form-label">Preferred Visit Time *</label>
                    <input type="time" name="preferred_time" id="preferredTime" class="form-control-p2gh" required>
                    <small class="form-hint">Tell us the time that suits you best — our team will contact you to confirm availability for this slot.</small>
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

{{-- ===== FLOATING BUTTONS ===== --}}
<div class="float-actions">
    @if(!empty(settings('company_whatsapp1')))
    @php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); @endphp
    <a href="https://wa.me/{{ $wp }}?text=Hello, I would like to book a physiotherapy appointment." class="float-btn whatsapp" target="_blank" rel="noopener" title="WhatsApp Us">
        <i class="bi bi-whatsapp"></i>
    </a>
    @endif
    @if(!empty(settings('company_mobile1')))
    <a href="tel:{{ settings('company_mobile1') }}" class="float-btn phone" title="Call Us">
        <i class="bi bi-telephone-fill"></i>
    </a>
    @endif
</div>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

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

    // ── AOS init (single scroll-reveal system for sections/cards) ─
    // If the AOS lib fails to load (CDN blocked) or the user prefers reduced
    // motion, strip the data-aos attributes so nothing stays hidden forever.
    function stripAos() {
        document.querySelectorAll('[data-aos]').forEach(function (el) { el.removeAttribute('data-aos'); });
    }
    if (reduceMotion) {
        stripAos();
    } else if (window.AOS) {
        AOS.init({ duration: 750, once: true, offset: 60, easing: 'ease-out-cubic' });
        // Failsafe: never leave content hidden. If anything is still not
        // revealed 4s after load (slow CDN, edge-case bugs), force-reveal it.
        setTimeout(function () {
            document.querySelectorAll('[data-aos]:not(.aos-animate)').forEach(function (el) {
                var r = el.getBoundingClientRect();
                if (r.top < window.innerHeight && r.height > 0) el.classList.add('aos-animate');
            });
        }, 4000);
    } else {
        stripAos();
    }

    // ── GSAP — hero-only polish (no competing scroll reveals) ─────
    var gsapOK = window.gsap && window.ScrollTrigger && !reduceMotion;
    if (gsapOK) {
        gsap.registerPlugin(ScrollTrigger);

        // Gentle hero entrance (runs once on load, not scroll-linked)
        var heroBits = document.querySelectorAll('.hero-badge, .hero-title, .hero-desc, .hero-actions, .hero-stats');
        if (heroBits.length) {
            gsap.from(heroBits, { opacity: 0, y: 34, duration: 1, ease: 'power2.out', stagger: 0.13, delay: 0.15, clearProps: 'all' });
        }

        // Parallax on hero background via ScrollTrigger (replaces scroll listener)
        var heroBg = document.querySelector('.hero-carousel') || document.querySelector('.hero-bg');
        if (heroBg) {
            gsap.to(heroBg, {
                yPercent: 18,
                ease: 'none',
                scrollTrigger: { trigger: '.p2gh-hero', start: 'top top', end: 'bottom top', scrub: true }
            });
        }
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

    // Default the preferred date to today and block past dates
    var prefDate = document.getElementById('preferredDate');
    if (prefDate) {
        var now = new Date();
        var iso = now.getFullYear() + '-' +
                  String(now.getMonth() + 1).padStart(2, '0') + '-' +
                  String(now.getDate()).padStart(2, '0');
        prefDate.min = iso;
        if (!prefDate.value) prefDate.value = iso;
    }

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
})();


</script>

@stack('scripts')
</body>
</html>
