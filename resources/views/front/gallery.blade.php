@extends('layouts.frontend')
@section('title', 'Gallery — ' . (settings('company_name') ?? 'P2GH 24*7 Physiotherapy'))

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Photo Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Gallery</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:500px;margin:0 auto 48px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Our Clinic</div>
            <h2 class="main-heading">A Glimpse Of Our <span>Healing Space</span></h2>
        </div>

        @if($categories && $categories->count())
            @foreach($categories as $category)
            <div style="margin-bottom:56px;">
                <h3 style="font-family:var(--font-ui);font-size:18px;font-weight:700;color:var(--text-dark);margin-bottom:24px;display:flex;align-items:center;gap:12px;">
                    <span style="display:inline-block;width:4px;height:24px;background:var(--primary);border-radius:2px;"></span>
                    {{ $category->name }}
                </h3>
                <div class="gallery-grid">
                    @foreach($category->images as $item)
                    <a href="{{ asset('storage/' . $item->image) }}" class="gallery-item glightbox" data-gallery="gallery-{{ $category->id }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 40 }}">
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
        <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
            <i class="bi bi-images" style="font-size:48px;color:var(--border-mid);display:block;margin-bottom:16px;"></i>
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
