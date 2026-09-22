@extends('layouts.frontend')
@section('title', 'Gallery - ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('{{ asset('front_assets/images/page-hero-neuro.svg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Photo Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span>Gallery</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up" style="max-width:1000px;">
            <div class="section-label">Our Gallery</div>
            <h2 class="main-heading">Inside <span>Navodayan Neuroclinic &amp; Neurorehab</span></h2>
        </div>

        @if($categories && $categories->count())
            @foreach($categories as $category)
            <div style="margin-bottom:clamp(44px,5vw,64px);">
                <h3 class="gallery-cat-title" data-aos="fade-up">{{ $category->name }}</h3>
                <div class="gallery-grid">
                    @foreach($category->images as $item)
                    <a href="{{ asset('storage/' . $item->image) }}" class="gallery-item glightbox" data-gallery="gallery-{{ $category->id }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 40 }}">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? $category->name }}" loading="lazy">
                        <div class="gallery-overlay">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-state">
            <i class="bi bi-images"></i>
            <p>Gallery coming soon. Please check back later.</p>
        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
</script>
@endpush
