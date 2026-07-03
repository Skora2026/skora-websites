@extends('layouts.frontend')
@section('title', 'Our Services — Website')

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Our Services</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Services</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:600px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">What We Offer</div>
            <h2 class="main-heading">Comprehensive <span>Physiotherapy</span> Services</h2>
            <p class="section-desc">
                From sports injuries to post-surgical recovery, we provide evidence-based physiotherapy treatments tailored to your specific needs.
            </p>
        </div>

        @if(isset($categories) && $categories->count())
            @foreach($categories as $category)
            <div class="service-category-block">
                <h3 class="service-category-title">
                    {{ $category->name }}
                </h3>
                <div class="services-list-grid">
                    @foreach($category->services as $service)
                    <div class="service-card" data-aos="fade-up">
                        <a href="{{ url('/service-details/' . $service->slug) }}">
                            <div class="service-card-img">
                                @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                                @else
                                <img src="{{ asset('front_assets/images/serv1.webp') }}" alt="{{ $service->name }}">
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
            @endforeach
        @else
        <div class="services-list-grid">
            @forelse($services as $service)
            <div class="service-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                <a href="{{ url('/service-details/' . $service->slug) }}">
                    <div class="service-card-img">
                        @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                        @else
                        <img src="{{ asset('front_assets/images/serv1.webp') }}" alt="{{ $service->name }}">
                        @endif
                    </div>
                    <div class="service-card-body">
                        <h4>{{ $service->name }}</h4>
                        <p>{{ Str::limit(strip_tags($service->short_description), 90) }}</p>
                        <div class="service-card-arrow">↗</div>
                    </div>
                </a>
            </div>
            @empty
            <p style="color:var(--text-muted);">No services found. Please add services from the admin panel.</p>
            @endforelse
        </div>
        @endif

        <div class="cta-banner" data-aos="zoom-in" style="margin-top:56px;">
            <div>
                <h3>Need Help Choosing The Right Treatment?</h3>
                <p>Our experts will assess your condition and recommend the best therapy plan for you.</p>
            </div>
            <button class="btn-p2gh btn-p2gh-white openForm" style="flex-shrink:0;">
                <span>Book Consultation</span>
                <span class="btn-icon" style="color:var(--primary);">↗</span>
            </button>
        </div>
    </div>
</section>

@endsection