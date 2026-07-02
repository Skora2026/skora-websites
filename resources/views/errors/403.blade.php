@extends('errors.layout')
@section('title', 'Access Denied')
@section('error_code', '403')
@section('description', 'You do not have permission to access this page.')

@section('content')
    <div class="error-code">403</div>
    <h2 class="error-title">Access Denied</h2>
    <p class="error-message">
        You don't have permission to access this page. 
        Please check your credentials or contact the administrator if you believe this is an error.
    </p>
@endsection
@section('actions')
    <a href="{{ url('/') }}" class="btn-primary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
    @if(auth()->check())
        <a href="{{ route('dashboard') }}" class="btn-secondary">
            <i class="bi bi-speedometer2"></i> Go to Dashboard
        </a>
    @else
        <a href="{{ route('login') }}" class="btn-secondary">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </a>
    @endif
@endsection