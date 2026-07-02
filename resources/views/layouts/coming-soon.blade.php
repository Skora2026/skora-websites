@extends('layouts.frontend')
@section('title', '{{ settings("company_name") ?? "P2GH" }} || Coming Soon')
@push('styles')
    <link rel="stylesheet" href="{{ asset('front_assets/css/contact.css') }}">
@endpush

@section('content')
    <style>
    .coming-soon {
        height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .overlay {
        position: absolute;
        inset: 0;
        background: rgba(64, 21, 0, 0.75);
    }

    .content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: #fff;
        padding: 20px;
        max-width: 700px;
    }

    .om-icon {
        width: 80px;
        margin-bottom: 20px;
    }

    h1 {
        font-family: 'Cinzel', serif;
        font-size: 48px;
        color: #ff9933;
        /* bhagwa */
        letter-spacing: 2px;
    }

    .tagline {
        font-size: 18px;
        margin: 15px 0;
        color: #ffd9b3;
    }

    .divider {
        font-size: 30px;
        margin: 20px 0;
        color: #ffb347;
    }

    .sub-text {
        font-size: 16px;
        line-height: 1.7;
        color: #f5f5f5;
        margin-bottom: 20px;
    }

    .mantra {
        font-style: italic;
        color: #ffe6c7;
        margin-bottom: 30px;
    }

    .notify-btn {
        display: inline-block;
        padding: 12px 35px;
        background: linear-gradient(45deg, #ff6a00, #ffb347);
        color: #111;
        font-weight: 500;
        border-radius: 30px;
        text-decoration: none;
        transition: 0.3s;
    }

    .notify-btn:hover {
        background: #fff;
        color: #ff6a00;
    }
</style>
    <section class="coming-soon">
        <div class="overlay"></div>
        <div class="content">
            <h1>Coming Soon</h1>
            <a href="{{url('/')}}" class="notify-btn"> Back To Home</a>
        </div>
    </section>
@endsection
