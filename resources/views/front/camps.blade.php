@extends('layouts.frontend')
@section('title', 'Health Camps - ' . (settings('company_name') ?? 'Website'))
@section('navbar_class', 'transparent')

@section('content')

{{-- ===== PAGE HERO ===== --}}
<section class="page-hero page-hero--img camps-hero">
    <div class="page-hero-bg" style="background-image: url('{{ asset('front_assets/images/camps-photo.jpg') }}');"></div>
    <div class="container-p2gh">
        <div class="breadcrumb-title">Health Camps</div><p class="camps-hero-desc">Free check-ups, expert consultations and awareness drives organised by
            {{ settings('company_name') ?? 'Navodayan Neuroclinic & Neurorehab' }} — on-site and at partner locations.</p>
    </div>
</section>

<section class="p2gh-section">
    <div class="container-p2gh">

        @if($camps->count())
        <div class="camps-grid">
            @foreach($camps as $camp)
            @php
                $upcoming = $camp->camp_date && \Carbon\Carbon::parse($camp->camp_date)->isFuture();
            @endphp
            <article class="camp-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">
                <div class="camp-card-top">
                    <div class="camp-date-chip">
                        <i class="bi bi-calendar2-week-fill"></i>
                        <span>{{ $camp->camp_date ? \Carbon\Carbon::parse($camp->camp_date)->format('d M Y') : 'Date To Be Announced' }}</span>
                    </div>
                    @if($camp->camp_date)
                    <span class="camp-status {{ $upcoming ? 'is-upcoming' : 'is-past' }}">
                        {{ $upcoming ? 'Upcoming' : 'Completed' }}
                    </span>
                    @endif
                </div>

                <h3 class="camp-title">{{ $camp->title }}</h3>

                @if($camp->description)
                <p class="camp-desc">{{ $camp->description }}</p>
                @endif

                <div class="camp-meta">
                    @if($camp->location)
                    <span><i class="bi bi-geo-alt-fill"></i> {{ $camp->location }}</span>
                    @endif
                    @if($camp->camp_time)
                    <span><i class="bi bi-clock-fill"></i> {{ $camp->camp_time }}</span>
                    @endif
                </div>

                <div class="camp-actions">
                    <button class="btn-p2gh openForm">
                        <span>Book Appointment</span>
                        <span class="btn-icon">↗</span>
                    </button>
                    @if(!empty(settings('company_mobile1')))
                    <a href="tel:{{ settings('company_mobile1') }}" class="camp-call-link">
                        <i class="bi bi-telephone-fill"></i> Call For Details
                    </a>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="camps-empty" data-aos="fade-up">
            <i class="bi bi-capsule"></i>
            <h3>No Camps Scheduled Right Now</h3>
            <p>We announce our health camps here as soon as dates are confirmed — check back soon,
               or contact us to know when the next camp is planned.</p>
            <div class="camps-empty-actions">
                <button class="btn-p2gh openForm"><span>Book Appointment</span><span class="btn-icon">↗</span></button>
                @if(!empty(settings('company_mobile1')))
                <a href="tel:{{ settings('company_mobile1') }}" class="btn-p2gh btn-p2gh-outline"><span>Contact Us</span></a>
                @endif
            </div>
        </div>
        @endif

        {{-- CTA --}}
        <div class="cta-banner" data-aos="fade-up">
            <div>
                <h3>Want {{ settings('company_short_name') ?? 'Us' }} At Your Next Camp?</h3>
                <p>We partner with schools, offices, RWAs and institutions for on-site neuro &amp; rehab camps. Reach out to plan one.</p>
            </div>
            <a href="{{ url('/contact-us') }}" class="btn-p2gh btn-p2gh-white">
                <span>Contact Us</span>
                <span class="btn-icon">↗</span>
            </a>
        </div>

    </div>
</section>

@endsection
