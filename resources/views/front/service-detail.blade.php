@extends('layouts.frontend')
@section('title', ($service->name ?? 'Service Detail') . ' - ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('{{ $service && $service->image ? asset('storage/' . $service->image) : asset('front_assets/images/page-hero-neuro.svg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">{{ $service->name ?? 'Service Detail' }}</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ url('/services') }}">Services</a>
            <span class="sep">/</span>
            <span>{{ $service->name ?? '' }}</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <div>
                @if($service->image)
                <div class="blog-detail-img reveal-img">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                </div>
                @endif

                <div class="reveal" style="--reveal-delay:120ms;">
                    <div class="section-label">Neurology &amp; Rehabilitation Service</div>
                    <h1 class="main-heading">{{ $service->name }}</h1>
                    <div class="content-editor">
                        {!! $service->description !!}
                    </div>
                </div>

                <div class="cta-banner" data-aos="fade-up">
                    <div>
                        <h3>Ready For This Treatment?</h3>
                        <p>Book your appointment and start your recovery journey today.</p>
                    </div>
                    <button class="btn-p2gh btn-p2gh-white openForm">
                        <span>Book Now</span>
                        <span class="btn-icon">↗</span>
                    </button>
                </div>
            </div>

            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>All Services</h5>
                    <ul class="sidebar-card-list">
                        @forelse($services as $s)
                        <li>
                            <a href="{{ url('/service-details/' . $s->slug) }}"
                               class="{{ $s->slug === $service->slug ? 'active-link' : '' }}">
                                <i class="bi bi-activity"></i>
                                <span>{{ $s->name }}</span>
                            </a>
                        </li>
                        @empty
                        <li style="color:var(--text-muted);font-size:14px;">No services found.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="sidebar-card sidebar-accent">
                    <h5>Book Appointment</h5>
                    <p>Book your slot now and start recovering.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;">
                        <span>Book Now</span>
                    </button>
                    @if(!empty(settings('company_mobile1')))
                    <a href="tel:{{ settings('company_mobile1') }}" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:14px;color:rgba(255,255,255,0.8);font-size:14px;">
                        <i class="bi bi-telephone-fill"></i> {{ settings('company_mobile1') }}
                    </a>
                    @endif
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
