@extends('layouts.frontend')
@section('title', (settings('company_name') ?? 'Website') . ' — Home')
@section('navbar_class', 'transparent')

@section('content')

{{-- ===== HERO ===== --}}
<section class="p2gh-hero">
    {{-- Background photo carousel: neurosurgeon first, then physiotherapy --}}
    <div class="hero-carousel" aria-hidden="true">
        <div class="hero-slide is-active" style="background-image: url('{{ $hero && $hero->image ? asset('storage/'.$hero->image) : asset('front_assets/images/hero-slide-neuro.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('front_assets/images/hero-slide-physio.jpg') }}');"></div>
    </div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <div class="reveal">
            <div class="hero-badge">
                <span class="dot"></span>
                {{ $hero?->badge_text ?? settings('company_tagline') ?? 'Navodayan Neuroclinic & Neurorehab' }}
            </div>

            <h1 class="hero-title">
                {{ $hero && $hero->heading ? $hero->heading : 'Restoring Brain' }}
                <span class="line2">{{ $hero && $hero->subheading ? $hero->subheading : 'And Spine Health.' }}</span>
            </h1>

            <p class="hero-desc reveal" style="--reveal-delay:120ms;">
                {{ $hero && $hero->description ? $hero->description : 'Specialist neuro consultations, neuro physiotherapy and rehabilitation for stroke, spine and nerve conditions — precise diagnosis, personal recovery plans, and compassionate care at every step.' }}
            </p>

            <div class="hero-actions reveal" style="--reveal-delay:220ms;">
                <button class="btn-p2gh btn-p2gh-accent openForm">
                    <span>{{ $hero?->btn_text ?? 'Book Appointment' }}</span>
                    <span class="btn-icon">↗</span>
                </button>
                <a href="{{ url('/services') }}" class="btn-p2gh btn-p2gh-outline">
                    {{ $hero?->btn2_text ?? 'Explore Services' }}
                </a>
            </div>
        </div>

        {{-- Dynamic Stats from progress_counters --}}
        @if($progressCounters && $progressCounters->count())
        <div class="hero-stats reveal" style="--reveal-delay:340ms;">
            @foreach($progressCounters as $counter)
            <div class="hero-stat-item">
                <div class="hero-stat-num">
                    <span data-target="{{ $counter->number }}" data-suffix="{{ $counter->suffix ?? '+' }}">
                        {{ $counter->number }}{{ $counter->suffix ?? '+' }}
                    </span>
                </div>
                <div class="hero-stat-label">{{ $counter->title }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="hero-float-card reveal reveal-right" style="--reveal-delay:500ms;">
        <div class="hero-float-icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <div class="hero-float-text">
            <strong>{{ $hero?->floating_title ?? 'Neuro Expertise' }}</strong>
            <span>{{ $hero?->floating_subtitle ?? 'Brain & Spine Rehabilitation Team' }}</span>
        </div>
    </div>
</section>


{{-- ===== ABOUT + STATS (Editorial navy panel, layered imagery) ===== --}}
<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="ddp-panel">

            <div class="ddp-panel-content reveal reveal-left">
                <div class="section-label">{{ $aboutsection->sub_title ?? 'About ' . (settings('company_short_name') ?? 'P2GH') }}</div>
                <h2 class="main-heading">
                    @if($aboutsection && $aboutsection->title_line1)
                        {{ $aboutsection->title_line1 }} <span>{{ $aboutsection->title_line2 }}</span>
                    @else
                        Passionate About <span>Providing Expert Care</span> And Support
                    @endif
                </h2>
                <p class="section-desc" style="margin-bottom:6px;">
                    {!! $aboutsection && $aboutsection->description ? nl2br(e($aboutsection->description)) : 'At <strong>'.( settings('company_name') ?? 'Navodayan Neuroclinic & Neurorehab').'</strong>, our dedicated physiotherapists combine compassionate care, continuous support, and clinical expertise to relieve pain and help patients regain a better quality of life.' !!}
                </p>

                <blockquote class="ddp-about-quote">
                    "{{ $aboutsection->quote_text ?? 'True healing comes from more than treatments — it is built on trust, patience, and compassion, reflected in each small victory.' }}"
                </blockquote>

                <div class="doctor-signature">
                    @if($aboutsection && $aboutsection->logo_image)
                        <img src="{{ asset('storage/'.$aboutsection->logo_image) }}" alt="{{ settings('company_short_name') ?? 'P2GH' }}">
                    @else
                        <img src="{{ asset('front_assets/images/doc-icon.jpg') }}" alt="Doctor">
                    @endif
                    <div>
                        <div class="doc-name">{{ $aboutsection->doctor_name ?? (settings('company_short_name') ?? 'Dr. Rajpal') }}</div>
                        <div class="doc-deg">{{ $aboutsection->doctor_qualification ?? 'Neuro Consultant · Neuro Rehabilitation' }}</div>
                    </div>
                    @if($aboutsection && $aboutsection->button_link)
                    <a href="{{ $aboutsection->button_link }}" class="btn-p2gh">
                        {{ $aboutsection->button_text ?? 'Know More' }} <span class="btn-icon">↗</span>
                    </a>
                    @endif
                </div>

                @if($progressCounters && $progressCounters->count())
                <div class="stats-grid">
                    @foreach($progressCounters as $counter)
                    <div class="stat-item">
                        <div class="stat-icon"><i class="bi {{ $counter->icon ?? 'bi-graph-up' }}"></i></div>
                        <div class="stat-num">
                            <span data-target="{{ $counter->number }}" data-suffix="{{ $counter->suffix ?? '+' }}">
                                {{ $counter->number }}{{ $counter->suffix ?? '+' }}
                            </span>
                        </div>
                        <div class="stat-label">{{ $counter->title }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="about-images-wrap reveal-img reveal" style="--reveal-delay:150ms;">
                <div class="about-img-main">
                    @if($aboutsection && $aboutsection->center_image)
                        <img src="{{ asset('storage/'.$aboutsection->center_image) }}" alt="{{ settings('company_short_name') ?? 'Navodayan' }} Neuro Care">
                    @else
                        <img src="{{ asset('front_assets/images/about-main.jpg') }}" alt="Brain and spine care at Navodayan Neuroclinic & Neurorehab">
                    @endif
                </div>
                <div class="about-img-small">
                    @if($aboutsection && $aboutsection->small_image)
                        <img src="{{ asset('storage/'.$aboutsection->small_image) }}" alt="Therapy">
                    @else
                        <img src="{{ asset('front_assets/images/about-inset-lab.jpg') }}" alt="Neuron network">
                    @endif
                </div>
                <div class="about-exp-badge">
                    @php
                        $expCounter = $progressCounters->firstWhere('title', 'Years Experience') ?? $progressCounters->first();
                    @endphp
                    <span class="num">{{ $expCounter ? $expCounter->number.$expCounter->suffix : '20+' }}</span>
                    <span class="label">Years of<br>Expertise</span>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ===== MISSION / VISION (Dynamic from CTA section context — content unchanged) ===== --}}
<section class="p2gh-section bg-light">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up">
            <div class="section-label">Vision To Victory</div>
            <h2 class="main-heading">A <span>Recognized Leader</span> In Quality Rehabilitation</h2>
        </div>

        <div class="mv-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="mv-card">
                <div class="mv-icon"><i class="bi bi-bullseye"></i></div>
                <h4>Our Mission</h4>
                <p>To deliver compassionate, expert physiotherapy care that relieves pain, restores mobility, and enhances quality of life for every patient — 24 hours a day, 7 days a week.</p>
            </div>
            <div class="mv-card">
                <div class="mv-icon"><i class="bi bi-lightbulb"></i></div>
                <h4>Our Vision</h4>
                <p>To be the most trusted physiotherapy provider — helping patients regain mobility and confidence through modern, evidence-based care that is always accessible.</p>
            </div>
            <div class="mv-card">
                <div class="mv-icon"><i class="bi bi-compass"></i></div>
                <h4>Our Approach</h4>
                <p>Personalized treatment plans focused on long-term healing, strength, and flexibility — addressing the root cause, not just the symptoms.</p>
            </div>
        </div>
    </div>
</section>


{{-- ===== SERVICES ===== --}}
@if($indexservices && $indexservices->count())
<section class="p2gh-section">
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
            <a href="{{ url('/services') }}" class="btn-p2gh" data-aos="fade-left">
                <span>All Services</span><span class="btn-icon">↗</span>
            </a>
        </div>

        <div class="services-grid">
            @foreach($indexservices as $service)
            <div class="service-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">
                <a href="{{ route('service.detail', $service->slug) }}">
                    <div class="service-card-img">
                        <span class="service-card-num">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        @if($service->image)
                            <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->name }}" loading="lazy">
                        @else
                            <img src="{{ asset('front_assets/images/serv1.webp') }}" alt="{{ $service->name }}" loading="lazy">
                        @endif
                    </div>
                    <div class="service-card-body">
                        <h4>{{ $service->name }}</h4>
                        <p>{{ Str::limit(strip_tags($service->short_description), 90) }}</p>
                        <div class="service-card-arrow">↗</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ===== WHY US (Dynamic) ===== --}}
@php $why = $whyChooseUsSections->first(); @endphp
<section class="p2gh-section bg-light">
    <div class="container-p2gh">
        <div class="why-grid">

            <div class="why-img-wrap reveal reveal-left">
                <div class="why-img-main">
                    @if($why && $why->right_image)
                        <img src="{{ asset('storage/'.$why->right_image) }}" alt="Why Choose {{ settings('company_short_name') ?? 'P2GH' }}">
                    @else
                        <img src="{{ asset('front_assets/images/doctor.png') }}" alt="Why Choose Navodayan">
                    @endif
                </div>
                @php $satisfactionCounter = $progressCounters->where('title', 'Success Rate')->first() ?? $progressCounters->last(); @endphp
                <div class="why-accent-card reveal reveal-zoom" style="--reveal-delay:300ms;">
                    <span class="big-num">{{ $satisfactionCounter ? $satisfactionCounter->number.$satisfactionCounter->suffix : '98%' }}</span>
                    <span class="label">Patient<br>Satisfaction</span>
                </div>
            </div>

            <div class="reveal reveal-right">
                <div class="section-label">{{ $why->sub_title ?? 'Why Choose Us' }}</div>
                <h2 class="main-heading">
                    @if($why && $why->main_title)
                        {!! $why->main_title !!}
                    @else
                        Excellence In <span>Care</span> And Rehabilitation
                    @endif
                </h2>                    <p class="section-desc" style="margin-bottom:8px;">
                    We combine expert neuro care with personalized rehabilitation plans so you get lasting recovery, not just temporary relief.
                </p>

                <div class="why-list">
                    @if($whyChooseUsSections && $whyChooseUsSections->count())
                        @if($why && $why->features && count($why->features))
                            @foreach(array_slice($why->features, 0, 4) as $index => $feature)
                            <div class="why-item" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}">
                                <div class="why-item-icon {{ $index % 2 !== 0 ? 'accent' : '' }}">
                                    <i class="bi bi-{{ $feature['icon'] ?? 'check-circle' }}"></i>
                                </div>
                                <div class="why-item-body">
                                    <h5>{{ $feature['title'] ?? '' }}</h5>
                                    <p>{{ $feature['description'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                        {{-- Fallback hardcoded --}}
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
                            <div class="why-item-body"><h5>Convenient Timings</h5><p>Morning to evening physiotherapy hours, with specialist consultations by appointment.</p></div>
                        </div>
                        @endif
                    @else
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
                        <div class="why-item-body"><h5>Convenient Timings</h5><p>Morning to evening physiotherapy hours, with specialist consultations by appointment.</p></div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ===== PROCESS STEPS (Dynamic — visual journey) ===== --}}
@if($processSteps && $processSteps->count())
<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up">
            <div class="section-label">How It Works</div>
            <h2 class="main-heading">
                {{ $processSteps->count() }} Simple Steps To <span>Begin Your Recovery</span>
            </h2>
            <p class="section-desc">Getting neuro & rehabilitation care at {{ settings('company_short_name') ?? 'Navodayan' }} is straightforward. Book, assess, and recover — we handle everything else.</p>
        </div>

        @php $psCols = min($processSteps->count(), 3); @endphp
        <div class="process-steps" data-steps="{{ $psCols }}" style="grid-template-columns: repeat({{ $psCols }}, 1fr); --ps-cols: {{ $psCols }};">
            @foreach($processSteps as $step)
            <div class="process-step reveal" style="--reveal-delay: {{ $loop->index * 140 }}ms;">
                <div class="step-num-wrap">
                    <div class="step-circle-outer">
                        <div class="step-inner-circle">{{ $step->step_number }}</div>
                    </div>
                    <div class="step-badge">{{ $loop->last ? '✓' : '→' }}</div>
                </div>
                <h4>{{ $step->title }}</h4>
                <p>{{ $step->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ===== TESTIMONIALS (Dynamic) ===== --}}
@if($testimonials && $testimonials->count())
<section class="p2gh-section bg-light">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up">
            <div class="section-label">Patient Reviews</div>
            <h2 class="main-heading">What Our <span>Patients</span> Say</h2>
            <p class="section-desc">Real recovery stories from real patients. Hear how {{ settings('company_short_name') ?? 'Navodayan' }} has helped people get back to living fully.</p>
        </div>

        <div class="swiper testimonial-slider">
            <div class="swiper-wrapper">
                @foreach($testimonials as $t)
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">{{ str_repeat('★', (int)$t->rating) }}</div>
                        <p class="testimonial-text">"{{ $t->message }}"</p>
                        <div class="testimonial-client">
                            @if($t->client_image)
                                <img src="{{ asset('storage/'.$t->client_image) }}" alt="{{ $t->client_name }}" loading="lazy">
                            @else
                                <span class="testimonial-avatar-initials">{{ mb_strtoupper(mb_substr(trim($t->client_name), 0, 1)) }}</span>
                            @endif
                            <div>
                                <div class="client-name">{{ $t->client_name }}</div>
                                <div class="client-role">Verified Patient</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif


{{-- ===== BLOGS (Dynamic — featured editorial grid) ===== --}}
@if($blogs && $blogs->count())
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
            <a href="{{ url('/blogs') }}" class="btn-p2gh" data-aos="fade-left">
                <span>All Blogs</span><span class="btn-icon">↗</span>
            </a>
        </div>

        <div class="blog-grid has-featured">
            @foreach($blogs as $blog)
            <div class="blog-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">
                <a href="{{ url('/blog-details/'.$blog->slug) }}">
                    <div class="blog-card-img">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" loading="lazy">
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-meta">
                            <span><i class="bi bi-person-fill"></i> {{ settings('company_short_name') ?? 'P2GH' }}</span>
                            <span><i class="bi bi-calendar3"></i> {{ $blog->publish_date->format('d M, Y') }}</span>
                        </div>
                        <h5>{{ $blog->title }}</h5>
                        <div class="blog-read-more">Read More <i class="bi bi-arrow-right"></i></div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @if($cta)
        <div class="cta-banner" data-aos="fade-up" style="{{ $cta->background_image ? 'background-image:url(\''.asset('storage/'.$cta->background_image).'\');background-size:cover;background-position:center;' : '' }}">
            <div>
                <h3>{{ $cta->heading ?? 'Ready To Start Your Recovery Journey?' }}</h3>                            <p>{{ $cta->description ?? 'Book your consultation today — we\'re here to help you recover.' }}</p>
            </div>
            @if(!empty($cta->button_link) && trim($cta->button_link) !== '#')
            <a href="{{ $cta->button_link }}" class="btn-p2gh btn-p2gh-white">
                <span>{{ $cta->button_text ?? 'Book Now' }}</span>
                <span class="btn-icon">↗</span>
            </a>
            @else
            <button class="btn-p2gh btn-p2gh-white openForm">
                <span>{{ $cta->button_text ?? 'Book Now' }}</span>
                <span class="btn-icon">↗</span>
            </button>
            @endif
        </div>
        @else
        <div class="cta-banner" data-aos="fade-up">
            <div>
                <h3>Ready To Start Your Recovery Journey?</h3>
                <p>Book your initial consultation today — we're here to help you recover.</p>
            </div>
            <button class="btn-p2gh btn-p2gh-white openForm">
                <span>Book Now</span>
                <span class="btn-icon">↗</span>
            </button>
        </div>
        @endif
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function () {
    'use strict';
    var slides = document.querySelectorAll('.hero-carousel .hero-slide');
    if (slides.length < 2) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        slides.forEach(function (s, i) { s.classList.toggle('is-active', i === 0); });
        return;
    }
    var current = 0;
    setInterval(function () {
        var prev = slides[current];
        current = (current + 1) % slides.length;
        var next = slides[current];
        prev.classList.remove('is-active');
        prev.classList.add('is-leaving');
        next.classList.add('is-active');
        setTimeout(function () { prev.classList.remove('is-leaving'); }, 1500);
    }, 6000);
})();
</script>
@endpush
