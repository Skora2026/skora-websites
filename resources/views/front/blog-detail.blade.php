@extends('layouts.frontend')
@section('title', ($blog->title ?? 'Blog') . ' — Website')

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down" style="font-size:1.6rem;">{{ Str::limit($blog->title ?? 'Blog Post', 60) }}</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ url('/blogs') }}" style="color:rgba(255,255,255,0.6);">Blogs</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Article</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="blog-detail-wrap">

            <article data-aos="fade-up">
                @if($blog->image)
                <div class="blog-detail-img">
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}">
                </div>
                @endif

                <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;flex-wrap:wrap;">
                    <span style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-person-fill" style="color:var(--primary);"></i>
                        {{ settings('company_short_name') ?? 'P2GH Team' }}
                    </span>
                    <span style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);font-family:var(--font-ui);font-weight:600;">
                        <i class="bi bi-calendar3" style="color:var(--primary);"></i>
                        {{ $blog->publish_date->format('d M, Y') }}
                    </span>
                </div>

                <h1 style="font-family:var(--font-display);font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;color:var(--text-dark);margin-bottom:24px;line-height:1.3;">
                    {{ $blog->title }}
                </h1>

                <div class="content-editor" style="color:var(--text-body);line-height:1.9;font-size:16px;">
                    {!! $blog->long_description !!}
                </div>
            </article>

            <aside class="blog-sidebar">
                <div class="sidebar-card">
                    <h5>Recent Posts</h5>
                    @forelse($recentBlogs ?? [] as $rb)
                    <a href="{{ url('/blog-details/' . $rb->slug) }}" style="display:flex;gap:12px;align-items:flex-start;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--border-light);">
                        <img src="{{ asset($rb->image) }}" alt="{{ $rb->title }}" style="width:68px;height:52px;object-fit:cover;border-radius:var(--radius-sm);flex-shrink:0;">
                        <div>
                            <p style="font-size:13px;font-weight:600;color:var(--text-dark);line-height:1.4;margin-bottom:4px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $rb->title }}</p>
                            <span style="font-size:11px;color:var(--text-muted);font-family:var(--font-ui);">{{ $rb->publish_date->format('d M, Y') }}</span>
                        </div>
                    </a>
                    @empty
                    <p style="font-size:14px;color:var(--text-muted);">No recent posts.</p>
                    @endforelse
                </div>

                <div class="sidebar-card" style="background:var(--primary);border-color:var(--primary);">
                    <h5 style="color:#fff;border-bottom-color:rgba(255,255,255,0.3);">Book Appointment</h5>
                    <p style="font-size:14px;color:rgba(255,255,255,0.8);margin-bottom:16px;">Experiencing pain or discomfort? Our experts are ready to help — 24x7.</p>
                    <button class="btn-p2gh btn-p2gh-white openForm" style="width:100%;justify-content:center;">
                        <span>Book Now</span>
                    </button>
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection