@extends('layouts.frontend')
@section('title', 'Our Services - ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('{{ asset('front_assets/images/hero-services.jpg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Our Services</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span>Services</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up">
            <div class="section-label">Our Services</div>
            <h2 class="main-heading">Comprehensive <span>Neurology &amp; Rehabilitation</span> Services</h2>
            <p class="section-desc">
                We provide expert neurological consultation, advanced diagnostics, and personalized rehabilitation programs to help patients regain independence and improve their quality of life.
            </p>
        </div>

        @if(isset($categories) && $categories->count())
            @foreach($categories as $category)
            <div class="service-category-block">
                <h3 class="service-category-title">{{ $category->name }}</h3>
                <div class="services-list-grid">
                    @foreach($category->services as $service)
                    <div class="service-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                        <a href="{{ url('/service-details/' . $service->slug) }}">
                            <div class="service-card-img">
                                <span class="service-card-num">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" loading="lazy">
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
            @endforeach
        @else
        <div class="services-list-grid">
            @forelse($services as $service)
            <div class="service-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                <a href="{{ url('/service-details/' . $service->slug) }}">
                    <div class="service-card-img">
                        <span class="service-card-num">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" loading="lazy">
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
            @empty
            <div class="empty-state">
                <i class="bi bi-activity"></i>
                <p>No services found. Please add services from the admin panel.</p>
            </div>
            @endforelse
        </div>
        @endif

        <div class="cta-banner" data-aos="fade-up">
            <div>
                <h3>Need Help Choosing The Right Treatment?</h3>
                <p>Our experts will assess your condition and recommend the best therapy plan for you.</p>
            </div>
            <button class="btn-p2gh btn-p2gh-white openForm">
                <span>Book Consultation</span>
                <span class="btn-icon">↗</span>
            </button>
        </div>
    </div>
</section>

@endsection
