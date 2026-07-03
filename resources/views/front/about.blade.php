@extends('layouts.frontend')
@section('title', 'About Us — ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">About Us</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">About Us</span>
        </nav>
    </div>
</div>

{{-- ===== ABOUT + STATS (Merged — navy panel, image right) ===== --}}
<section class="p2gh-section ddp-about-stats">
    <div class="container-p2gh">
        <div class="ddp-panel">

            <div class="ddp-panel-content" data-aos="fade-right">
                <div class="section-label">{{ $aboutsection->sub_title ?? 'About ' . (settings('company_short_name') ?? 'P2GH') }}</div>
                <h2 class="main-heading">
                    @if($aboutsection && $aboutsection->title_line1)
                        {{ $aboutsection->title_line1 }} <span>{{ $aboutsection->title_line2 }}</span>
                    @else
                        Passionate About <span>Providing Expert Care</span> And Support
                    @endif
                </h2>
                <p class="section-desc" style="margin-bottom:20px;">
                    {!! $aboutsection && $aboutsection->description ? nl2br(e($aboutsection->description)) : 'At <strong>'.( settings('company_name') ?? 'P2GH - 24*7 Physiotherapy').'</strong>, our dedicated physiotherapists combine compassionate care, continuous support, and clinical expertise to relieve pain and help patients regain a better quality of life.' !!}
                </p>
                <blockquote style="border-left:4px solid var(--primary);padding:14px 20px;background:var(--bg-section);border-radius:0 var(--radius-sm) var(--radius-sm) 0;font-style:italic;color:var(--text-body);margin-bottom:28px;font-size:15px;">
                    "{{ $aboutsection->quote_text ?? 'True healing comes from more than treatments — it is built on trust, patience, and compassion, reflected in each small victory.' }}"
                </blockquote>
                <div class="doctor-signature">
                    @if($aboutsection && $aboutsection->logo_image)
                        <img src="{{ asset('storage/'.$aboutsection->logo_image) }}" alt="{{ settings('company_short_name') ?? 'P2GH' }}">
                    @else
                        <img src="{{ asset('front_assets/images/doc-icon.jpg') }}" alt="Doctor">
                    @endif
                    <div>
                        <div class="doc-name">{{ $aboutsection->doctor_name ?? (settings('company_short_name') ?? 'Dr. Ankit Agrawal PT') }}</div>
                        <div class="doc-deg">{{ $aboutsection->doctor_qualification ?? 'BPT · MPT · COMT · CKT' }}</div>
                    </div>
                    @if($aboutsection && $aboutsection->button_link)
                    <a href="{{ $aboutsection->button_link }}" class="btn-p2gh" style="margin-left:auto;padding:10px 20px;font-size:12px;">
                        {{ $aboutsection->button_text ?? 'Know More' }} <span class="btn-icon">↗</span>
                    </a>
                    @endif
                </div>

                @if($progressCounters && $progressCounters->count())
                <div class="stats-grid">
                    @foreach($progressCounters as $counter)
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
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

            <div class="about-images-wrap" data-aos="fade-left">
                <div class="about-img-main">
                    @if($aboutsection && $aboutsection->center_image)
                        <img src="{{ asset('storage/'.$aboutsection->center_image) }}" alt="{{ settings('company_short_name') ?? 'P2GH' }} Physiotherapy">
                    @else
                        <img src="{{ asset('front_assets/images/aa.jpeg') }}" alt="P2GH Physiotherapy">
                    @endif
                </div>
                <div class="about-img-small">
                    @if($aboutsection && $aboutsection->small_image)
                        <img src="{{ asset('storage/'.$aboutsection->small_image) }}" alt="Therapy">
                    @else
                        <img src="{{ asset('front_assets/images/aaa.jpeg') }}" alt="Therapy">
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

{{-- ===== OUR VALUES (Dynamic — from AboutSection.values, separate from homepage Why Choose Us) ===== --}}
<section class="p2gh-section bg-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Our Values</div>
            <h2 class="main-heading">Guided By <span>Purpose and Passion</span></h2>
        </div>

        @php
            $aboutValues = collect($aboutsection->values ?? [])->filter(fn($v) => !empty($v['title']));
        @endphp

        <div class="mv-grid">
            @if($aboutValues->count())
                @foreach($aboutValues as $value)
                <div class="mv-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 120 }}">
                    <div class="mv-icon"><i class="bi bi-{{ $value['icon'] ?? 'bullseye' }}"></i></div>
                    <h4>{{ $value['title'] }}</h4>
                    <p>{{ $value['description'] ?? '' }}</p>
                </div>
                @endforeach
            @else
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
            @endif
        </div>
    </div>
</section>

{{-- ===== FAQ (Dynamic — heading + items) ===== --}}
@if($faqs && $faqs->count())
<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 48px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">{{ $faqSection->sub_title ?? 'Got Questions?' }}</div>
            <h2 class="main-heading">{{ $faqSection->main_title ?? 'Frequently Asked Questions' }}</h2>
        </div>
        <div class="faq-list" style="max-width:760px;margin:0 auto;" data-aos="fade-up">
            @foreach($faqs as $faq)
            <div class="faq-item {{ $loop->first ? 'open' : '' }}">
                <button class="faq-trigger">
                    {{ $faq->question }}
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-body">{{ $faq->answer }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection