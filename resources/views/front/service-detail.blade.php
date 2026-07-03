@extends('layouts.frontend')
@section('title', ($service->name ?? 'Service Detail') . ' — Website')

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">{{ $service->name ?? 'Service Detail' }}</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ url('/services') }}" style="color:rgba(255,255,255,0.6);">Services</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">{{ $service->name ?? '' }}</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <div>
                @if($service->image)
                <div class="blog-detail-img" data-aos="fade-up">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                </div>
                @endif

                <div data-aos="fade-up">
                    <div class="section-label">Physiotherapy Service</div>
                    <h1 class="main-heading">{{ $service->name }}</h1>
                    <div class="content-editor" style="color:var(--text-body);line-height:1.9;font-size:16px;">
                        {!! $service->description !!}
                    </div>
                </div>

                <div class="cta-banner" data-aos="zoom-in" style="margin-top:40px;">
                    <div>
                        <h3>Ready For This Treatment?</h3>
                        <p>Book your appointment and start your recovery journey today.</p>
                    </div>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="flex-shrink:0;">
                        <span>Book Now</span>
                        <span class="btn-icon" style="color:var(--primary);">↗</span>
                    </button>
                </div>
            </div>

            <div class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>All Services</h5>
                    <ul class="sidebar-card-list">
                        @forelse($services as $s)
                        <li>
                            <a href="{{ url('/service-details/' . $s->slug) }}"
                               class="{{ $s->slug === $service->slug ? 'active-link' : '' }}">
                                <i class="bi bi-activity" style="color:var(--primary);font-size:13px;flex-shrink:0;"></i>
                                <span>{{ $s->name }}</span>
                            </a>
                        </li>
                        @empty
                        <li style="color:var(--text-muted);font-size:14px;">No services found.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="sidebar-card" style="background:var(--primary);border-color:var(--primary);">
                    <h5 style="color:#fff;border-bottom-color:rgba(255,255,255,0.3);">Book Appointment</h5>
                    <p style="font-size:14px;color:rgba(255,255,255,0.8);margin-bottom:16px;">Available 24x7 — book your slot now and start recovering.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;justify-content:center;">
                        <span>Book Now</span>
                    </button>
                    @if(!empty(settings('company_mobile1')))
                    <a href="tel:{{ settings('company_mobile1') }}" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:12px;color:rgba(255,255,255,0.8);font-size:14px;">
                        <i class="bi bi-telephone-fill"></i> {{ settings('company_mobile1') }}
                    </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection