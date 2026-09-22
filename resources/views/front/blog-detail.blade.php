@extends('layouts.frontend')
@section('title', ($blog->title ?? 'Blog Details') . ' - ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('{{ $blog && $blog->image ? asset($blog->image) : asset('front_assets/images/page-hero-neuro.svg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down" style="font-size:1.6rem;">{{ Str::limit($blog->title ?? 'Blog Post', 60) }}</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ url('/blogs') }}">Blogs</a>
            <span class="sep">/</span>
            <span>Article</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <article class="reveal">
                @if($blog->image)
                <div class="blog-detail-img">
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}">
                </div>
                @endif

                <div style="display:flex;align-items:center;gap:20px;margin-bottom:22px;flex-wrap:wrap;">
                    <span style="display:flex;align-items:center;gap:7px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-person-fill" style="color:var(--accent);"></i>
                        {{ settings('company_short_name') ?? 'P2GH Team' }}
                    </span>
                    <span style="display:flex;align-items:center;gap:7px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-calendar3" style="color:var(--accent);"></i>
                        {{ $blog->publish_date->format('d M, Y') }}
                    </span>
                </div>

                <h1 style="font-family:var(--font-display);font-size:clamp(1.7rem,3.2vw,2.4rem);font-weight:700;color:var(--text-dark);margin-bottom:26px;line-height:1.25;">
                    {{ $blog->title }}
                </h1>

                <div class="content-editor">
                    {!! $blog->long_description !!}
                </div>
            </article>

            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>Recent Posts</h5>
                    @forelse($recentBlogs ?? [] as $rb)
                    <a href="{{ url('/blog-details/' . $rb->slug) }}" class="sidebar-post-item">
                        <img src="{{ asset($rb->image) }}" alt="{{ $rb->title }}" loading="lazy">
                        <div>
                            <p>{{ $rb->title }}</p>
                            <span>{{ $rb->publish_date->format('d M, Y') }}</span>
                        </div>
                    </a>
                    @empty
                    <p style="font-size:14px;color:var(--text-muted);">No recent posts.</p>
                    @endforelse
                </div>

                <div class="sidebar-card sidebar-accent">
                    <h5>Book Appointment</h5>
                    <p>Experiencing pain or discomfort? Our experts are ready to help.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;">
                        <span>Book Now</span>
                    </button>
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
