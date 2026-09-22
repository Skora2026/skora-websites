@extends('layouts.frontend')
@section('title', 'Health Blogs - ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('{{ asset('front_assets/images/page-hero-photo.jpg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Health Blogs</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span>Blogs</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up">
            <div class="section-label">Health Resources</div>
            <h2 class="main-heading">Expert <span>Neurology &amp; Rehabilitation</span> Insights</h2>
            <p class="section-desc">Stay informed with expert articles, neurological health tips, rehabilitation guidance, and recovery advice from our specialists.</p>
        </div>

        <div class="blog-grid">
            @forelse($blogs as $blog)
            <div class="blog-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                <a href="{{ url('/blog-details/' . $blog->slug) }}">
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
            @empty
            <div class="empty-state">
                <i class="bi bi-journal-text"></i>
                <p>No blog posts found. Check back soon for health tips and updates!</p>
            </div>
            @endforelse
        </div>

        @if(method_exists($blogs, 'links'))
        <div style="margin-top:52px;display:flex;justify-content:center;">
            {{ $blogs->links() }}
        </div>
        @endif
    </div>
</section>

@endsection
