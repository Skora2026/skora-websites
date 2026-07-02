<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', settings('company_name') ?? 'P2GH - 24*7 Physiotherapy')</title>
    <meta name="description" content="@yield('meta_desc', 'P2GH - 24*7 Physiotherapy. Expert physiotherapy care available round the clock. Book your appointment today.')">
    <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) : asset('front_assets/images/logo.png') }}">

    {{-- Master CSS - Single file for entire website --}}
    <link rel="stylesheet" href="{{ asset('front_assets/css/p2gh.css') }}">

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
            <div class="topbar-item">
                <i class="bi bi-clock-fill"></i>
                <span>{{ settings('working_hours') ?? 'Open 24 hours' }}</span>
                <span class="topbar-badge">24×7</span>
            </div>
        </div>
        <div class="topbar-socials">
            @if(!empty(settings('instagram')))
            <a href="{{ settings('instagram') }}" class="topbar-social-link" target="_blank"><i class="bi bi-instagram"></i></a>
            @endif
            @if(!empty(settings('facebook')))
            <a href="{{ settings('facebook') }}" class="topbar-social-link" target="_blank"><i class="bi bi-facebook"></i></a>
            @endif
            @if(!empty(settings('company_whatsapp1')))
            @php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); @endphp
            <a href="https://wa.me/{{ $wp }}" class="topbar-social-link" target="_blank"><i class="bi bi-whatsapp"></i></a>
            @endif
            @if(!empty(settings('pintrest')))
            <a href="{{ settings('pintrest') }}" class="topbar-social-link" target="_blank"><i class="bi bi-youtube"></i></a>
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
                 alt="{{ settings('company_short_name') ?? 'P2GH' }}">
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
                <a href="#" class="nav-link" style="display:flex;align-items:center;gap:5px;">
                    Services <i class="bi bi-chevron-down" style="font-size:11px;"></i>
                </a>
                <div class="nav-dropdown">
                    @forelse($services as $service)
                    <a href="{{ url('/service-details/' . $service->slug) }}">
                        <i class="bi bi-activity" style="color:var(--primary);font-size:13px;"></i>
                        {{ $service->name }}
                    </a>
                    @empty
                    <a href="#">No services found</a>
                    @endforelse
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('/services') }}" style="font-weight:700;color:var(--primary);">
                        <i class="bi bi-grid-3x3-gap" style="font-size:13px;"></i>
                        View All Services
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ url('/blogs') }}" class="nav-link">Blogs</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" style="display:flex;align-items:center;gap:5px;">
                    Gallery <i class="bi bi-chevron-down" style="font-size:11px;"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="{{ url('/gallery') }}"><i class="bi bi-images" style="color:var(--primary);font-size:13px;"></i> Photo Gallery</a>
                    <a href="{{ url('/video') }}"><i class="bi bi-camera-video" style="color:var(--primary);font-size:13px;"></i> Video Gallery</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ url('/contact-us') }}" class="nav-link">Contact</a>
            </li>
        </ul>

        {{-- CTA --}}
        <div class="nav-cta">
            <button class="btn-p2gh openForm" style="padding:11px 22px;font-size:13px;">
                <span>Book Appointment</span>
                <span class="btn-icon">↗</span>
            </button>
            @auth
                @if(auth()->user()->role === 'admin')
                <a href="{{ url('/admin-dashboard') }}" class="btn-p2gh-outline" style="padding:10px 18px;font-size:13px;">Dashboard</a>
                @endif
            @endauth
        </div>

        {{-- Mobile toggle --}}
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>

    </div>
</nav>

{{-- ===== PAGE CONTENT ===== --}}
@yield('content')

{{-- ===== TICKER (Dynamic — from HeroBanner.move_text, split by "||") ===== --}}
<div class="p2gh-ticker">
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
                <p class="brand-desc">{{ settings('company_description') ?? 'Expert physiotherapy care available round the clock. We help you recover faster and live pain-free.' }}</p>
                <div class="footer-socials">
                    @if(!empty(settings('instagram')))
                    <a href="{{ settings('instagram') }}" class="footer-social" target="_blank"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if(!empty(settings('facebook')))
                    <a href="{{ settings('facebook') }}" class="footer-social" target="_blank"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if(!empty(settings('company_whatsapp1')))
                    @php $wp = preg_replace('/\D/', '', settings('company_whatsapp1')); @endphp
                    <a href="https://wa.me/{{ $wp }}" class="footer-social" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    @endif
                    @if(!empty(settings('pintrest')))
                    <a href="{{ settings('pintrest') }}" class="footer-social" target="_blank"><i class="bi bi-youtube"></i></a>
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
                    </div>
                </div>
                @endif

                <div class="footer-contact-item">
                    <div class="fci-icon"><i class="bi bi-clock-fill"></i></div>
                    <div class="fci-text">
                        <h6>Working Hours</h6>
                        <p>{{ settings('working_hours') ?? 'Open 24 hours' }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} {{ settings('company_name') ?? 'P2GH - 24*7 Physiotherapy' }}. All rights reserved.</p>
            <p>Designed & Developed by <a href="https://www.skorasoft.com/" target="_blank">SkoraSoft</a></p>
        </div>
    </div>
</footer>

{{-- ===== POPUP APPOINTMENT FORM ===== --}}
<div class="p2gh-popup" id="popupForm">
    <div class="popup-box">
        <div class="popup-header">
            <div>
                <h3>Book Appointment</h3>
                <p>We'll confirm your slot within 2 hours</p>
            </div>
            <button class="popup-close" id="closeForm">✕</button>
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
                    <label class="form-label">Message (Optional)</label>
                    <textarea name="message" class="form-control-p2gh" placeholder="Describe your symptoms or any specific concerns..."></textarea>
                </div>
                <button type="submit" class="btn-p2gh" style="width:100%;justify-content:center;margin-top:8px;">
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
    <a href="https://wa.me/{{ $wp }}?text=Hello, I would like to book a physiotherapy appointment." class="float-btn whatsapp" target="_blank" title="WhatsApp Us">
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

<script>
// Measure the topbar's real rendered height and feed it into the
// --topbar-height CSS variable, so the fixed navbar is always pushed exactly
// below it (no overlap, no gap) regardless of font rendering differences
// across browsers/OSes. Re-measures on resize since the topbar hides below
// the lg breakpoint (992px).
function syncTopbarHeight() {
    const topbar = document.querySelector('.p2gh-topbar');
    if (!topbar) return;
    const isVisible = window.getComputedStyle(topbar).display !== 'none';
    document.documentElement.style.setProperty(
        '--topbar-height',
        isVisible ? topbar.offsetHeight + 'px' : '0px'
    );
}
syncTopbarHeight();
window.addEventListener('resize', syncTopbarHeight);

// AOS Init
AOS.init({ duration: 700, once: true, offset: 60 });

// Navbar scroll behavior
const nav = document.getElementById('mainNav');

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

// Run once immediately so the correct state is applied before the user sees a flash
updateNavbarOnScroll();
window.addEventListener('scroll', updateNavbarOnScroll, { passive: true });

// JS has now taken over navbar state — the early CSS anti-flicker hook isn't needed anymore
document.documentElement.classList.remove('nav-prescroll');

// Mobile nav toggle
const navToggle = document.getElementById('navToggle');
navToggle?.addEventListener('click', () => {
    nav.classList.toggle('mobile-open');
    // Closing the menu should also reset any open dropdown state
    if (!nav.classList.contains('mobile-open')) {
        document.querySelectorAll('.nav-menu .nav-item.dropdown-open').forEach((openItem) => {
            openItem.classList.remove('dropdown-open');
        });
    }
});

// Mobile dropdown toggle (tap-to-open instead of hover, since hover is
// unreliable on touch devices) — only active while the mobile menu is open.
document.querySelectorAll('.nav-menu .nav-item').forEach((item) => {
    const dropdown = item.querySelector('.nav-dropdown');
    if (!dropdown) return;

    const trigger = item.querySelector('.nav-link');
    trigger?.addEventListener('click', (e) => {
        if (!nav.classList.contains('mobile-open')) return; // desktop uses hover
        e.preventDefault();
        const wasOpen = item.classList.contains('dropdown-open');
        document.querySelectorAll('.nav-menu .nav-item.dropdown-open').forEach((openItem) => {
            if (openItem !== item) openItem.classList.remove('dropdown-open');
        });
        item.classList.toggle('dropdown-open', !wasOpen);
    });
});

// Popup form
const openBtns = document.querySelectorAll('.openForm');
const popup = document.getElementById('popupForm');
const closeBtn = document.getElementById('closeForm');

openBtns.forEach(btn => btn.addEventListener('click', () => {
    popup.classList.add('active');
    document.body.style.overflow = 'hidden';
}));

closeBtn?.addEventListener('click', () => {
    popup.classList.remove('active');
    document.body.style.overflow = '';
});

popup?.addEventListener('click', (e) => {
    if (e.target === popup) {
        popup.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// FAQ Accordion (custom, no Bootstrap)
document.querySelectorAll('.faq-trigger').forEach(trigger => {
    trigger.addEventListener('click', () => {
        const item = trigger.closest('.faq-item');
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    });
});

// Testimonial Swiper
if (document.querySelector('.testimonial-slider')) {
    new Swiper('.testimonial-slider', {
        loop: true,
        speed: 900,
        autoplay: { delay: 3500, disableOnInteraction: false },
        spaceBetween: 24,
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
            0: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 }
        }
    });
}

// Counter animation
function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const suffix = el.getAttribute('data-suffix') || '';
    let current = 0;
    const step = Math.ceil(target / 60);
    const interval = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(interval);
        }
        el.textContent = current + suffix;
    }, 30);
}

// Intersection observer for counters
const counterEls = document.querySelectorAll('[data-target]');
if (counterEls.length) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    counterEls.forEach(el => observer.observe(el));
}
</script>

@stack('scripts')
</body>
</html>