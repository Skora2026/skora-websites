@extends('layouts.frontend')
@section('title', 'Health Blogs — P2GH 24*7 Physiotherapy')

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Health Blogs</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Blogs</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 56px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">News and Insights</div>
            <h2 class="main-heading">Expert <span>Health Tips</span> And Guides</h2>
            <p class="section-desc">Stay informed with the latest physiotherapy insights, recovery tips, and health advice from our expert team.</p>
        </div>

        <div class="blog-grid">
            @forelse($blogs as $blog)
            <div class="blog-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <a href="{{ url('/blog-details/' . $blog->slug) }}">
                    <div class="blog-card-img">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}">
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
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted);">
                <i class="bi bi-journal-text" style="font-size:48px;color:var(--border-mid);display:block;margin-bottom:16px;"></i>
                <p>No blog posts found. Check back soon for health tips and updates!</p>
            </div>
            @endforelse
        </div>

        @if(method_exists($blogs, 'links'))
        <div style="margin-top:48px;display:flex;justify-content:center;">
            {{ $blogs->links() }}
        </div>
        @endif
    </div>
</section>

@endsection
