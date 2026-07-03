@extends('layouts.frontend')
@section('title', 'Video Gallery — ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Video Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Video</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div style="text-align:center;max-width:560px;margin:0 auto 48px;" data-aos="fade-up">
            <div class="section-label" style="justify-content:center;">Our Videos</div>
            <h2 class="main-heading">Explore Our <span>Activities</span> In Videos</h2>
            <p class="section-desc">Watch our videos to see treatment approaches, recovery stories, and expert physiotherapy care in action.</p>
        </div>

        @if($categories && $categories->count())
            @foreach($categories as $category)
            <div style="margin-bottom:56px;">
                <h3 style="font-family:var(--font-ui);font-size:18px;font-weight:700;color:var(--text-dark);margin-bottom:24px;display:flex;align-items:center;gap:12px;">
                    <span style="display:inline-block;width:4px;height:24px;background:var(--primary);border-radius:2px;"></span>
                    {{ $category->name }}
                </h3>
                <div class="gallery-grid">
                    @foreach($category->videos as $video)
                    <div class="gallery-item video-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 40 }}"
                         data-video-type="{{ $video->video_type }}"
                         data-video-src="{{ $video->video_type === 'youtube' ? $video->embed_url : asset('storage/'.$video->video_file) }}">
                        @if($video->thumbnail)
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('front_assets/images/v.png') }}" alt="{{ $video->title }}" loading="lazy">
                        @endif
                        <div class="gallery-overlay video-play-overlay">
                            <i class="bi bi-play-circle-fill"></i>
                        </div>
                        <div class="video-title-bar">{{ $video->title }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @else
        <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
            <i class="bi bi-camera-video" style="font-size:48px;color:var(--border-mid);display:block;margin-bottom:16px;"></i>
            <p>No videos yet. Please check back soon.</p>
        </div>
        @endif
    </div>
</section>

{{-- ===== VIDEO MODAL ===== --}}
<div class="video-modal" id="videoModal">
    <div class="video-modal-inner">
        <button class="video-modal-close" id="videoModalClose">✕</button>
        <div class="video-modal-frame" id="videoModalFrame"></div>
    </div>
</div>

@endsection

@push('styles')
<style>
.video-item { cursor: pointer; }
.video-play-overlay i { font-size: 48px; }
.video-title-bar {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 14px 16px;
    background: linear-gradient(transparent, rgba(10,45,53,0.85));
    color: #fff;
    font-family: var(--font-ui);
    font-size: 13px;
    font-weight: 600;
}

.video-modal {
    position: fixed;
    inset: 0;
    background: rgba(10,45,53,0.92);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
}
.video-modal.active { display: flex; }
.video-modal-inner {
    width: 100%;
    max-width: 900px;
    position: relative;
}
.video-modal-frame {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    background: #000;
    border-radius: var(--radius-md);
    overflow: hidden;
}
.video-modal-frame iframe,
.video-modal-frame video {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
}
.video-modal-close {
    position: absolute;
    top: -44px;
    right: 0;
    background: rgba(255,255,255,0.12);
    color: #fff;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.2s;
}
.video-modal-close:hover { background: rgba(255,255,255,0.25); }

@media (max-width: 480px) {
    .video-modal-close { top: -40px; }
}
</style>
@endpush

@push('scripts')
<script>
const videoModal = document.getElementById('videoModal');
const videoModalFrame = document.getElementById('videoModalFrame');
const videoModalClose = document.getElementById('videoModalClose');

document.querySelectorAll('.video-item').forEach(item => {
    item.addEventListener('click', () => {
        const type = item.dataset.videoType;
        const src = item.dataset.videoSrc;
        if (!src) return;

        videoModalFrame.innerHTML = type === 'youtube'
            ? `<iframe src="${src}?autoplay=1" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>`
            : `<video src="${src}" controls autoplay></video>`;

        videoModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
});

function closeVideoModal() {
    videoModal.classList.remove('active');
    videoModalFrame.innerHTML = '';
    document.body.style.overflow = '';
}

videoModalClose?.addEventListener('click', closeVideoModal);
videoModal?.addEventListener('click', (e) => {
    if (e.target === videoModal) closeVideoModal();
});
</script>
@endpush
