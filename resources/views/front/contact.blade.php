@extends('layouts.frontend')
@section('title', 'Contact Us — P2GH 24*7 Physiotherapy')

@section('content')

<div class="page-hero">
    <div class="container-p2gh" style="position:relative;z-index:1;">
        <div class="breadcrumb-title" data-aos="fade-down">Contact Us</div>
        <nav class="breadcrumb-nav" data-aos="fade-up">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(255,255,255,0.7);">Contact Us</span>
        </nav>
    </div>
</div>

<section class="p2gh-section">
    <div class="container-p2gh">
        <div class="contact-grid">

            <div class="contact-info-card" data-aos="fade-right">
                <h3>Get In Touch</h3>
                <p>We are available 24x7 — call, WhatsApp, or visit us anytime.</p>

                @if(!empty(settings('company_address2')))
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6>Our Location</h6>
                        <p>{{ settings('company_address2') }}</p>
                    </div>
                </div>
                @endif

                @if(!empty(settings('company_mobile1')))
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <h6>Phone Number</h6>
                        <a href="tel:{{ settings('company_mobile1') }}">{{ settings('company_mobile1') }}</a>
                    </div>
                </div>
                @endif

                @if(!empty(settings('company_email1')))
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <h6>Email Address</h6>
                        <a href="mailto:{{ settings('company_email1') }}">{{ settings('company_email1') }}</a>
                    </div>
                </div>
                @endif

                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <h6>Working Hours</h6>
                        <p>Open 24 hours<br>
                        <span style="color:rgba(255,255,255,0.5);font-size:13px;">Emergency: 24x7 On-Call Available</span></p>
                    </div>
                </div>
            </div>

            <div class="contact-form-card" data-aos="fade-left">
                <div class="section-label">Send Us A Message</div>
                <h2 class="main-heading" style="font-size:1.8rem;">We Would Love <span>To Hear From You</span></h2>
                <p class="section-desc" style="margin-bottom:28px;">Fill in the form below and we will get back to you within a few hours.</p>

                @if(session('success'))
                <div style="background:rgba(26,122,138,0.1);border:1px solid var(--primary);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:20px;color:var(--primary);font-size:14px;font-weight:600;">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control-p2gh" placeholder="Your full name" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" name="phone" class="form-control-p2gh" placeholder="10-digit number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control-p2gh" placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control-p2gh" placeholder="How can we help you?">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Your Message *</label>
                        <textarea name="message" class="form-control-p2gh" placeholder="Describe your condition or inquiry in detail..." required></textarea>
                    </div>
                    <button type="submit" class="btn-p2gh" style="width:100%;justify-content:center;">
                        <span>Send Message</span>
                        <span class="btn-icon">→</span>
                    </button>
                </form>
            </div>

        </div>

        @if(!empty(settings('map')))
        <div class="contact-map-wrap" data-aos="fade-up">
            @php
                $mapValue = trim(settings('map'));
            @endphp
            @if(stripos($mapValue, '<iframe') !== false)
                {{-- Admin saved a full <iframe> tag — use as-is --}}
                {!! $mapValue !!}
            @else
                {{-- Admin saved only the embed URL — wrap it in an iframe --}}
                <iframe
                    src="{{ $mapValue }}"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            @endif
        </div>
        @endif

    </div>
</section>

@endsection