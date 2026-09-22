@extends('layouts.frontend')
@section('title', 'Video Gallery - ' . (settings('company_name') ?? 'Website'))

@section('content')

<div class="page-hero page-hero--img">
    <div class="page-hero-bg" style="background-image: url('{{ asset('front_assets/images/page-hero-neuro.svg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title" data-aos="fade-down">Video Gallery</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span>Video</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="section-header-center" data-aos="fade-up" style="max-width:1000px;">
            <div class="section-label">Video Gallery</div>
            <h2 class="main-heading">Watch <span>Navodayan Neuroclinic &amp; Neurorehab</span> In Action</h2>
        </div>

        @if($categories && $categories->count())
            @foreach($categories as $category)
            <div style="margin-bottom:clamp(44px,5vw,64px);">
                <h3 class="gallery-cat-title" data-aos="fade-up">{{ $category->name }}</h3>
                <div class="gallery-grid">
                    @foreach($category->videos as $video)
                    <div class="gallery-item video-item" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 40 }}"
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
        <div class="empty-state">
            <i class="bi bi-camera-video"></i>
            <p>No videos yet. Please check back soon.</p>
        </div>
        @endif
    </div>
</section>

{{-- ===== VIDEO MODAL ===== --}}
<div class="video-modal" id="videoModal">
    <div class="video-modal-inner">
        <button class="video-modal-close" id="videoModalClose" aria-label="Close">✕</button>
        <div class="video-modal-frame" id="videoModalFrame"></div>
    </div>
</div>

@endsection

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
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && videoModal.classList.contains('active')) closeVideoModal();
});
</script>
@endpush
