<!-- resources/views/errors/401.blade.php -->
@extends('errors.layout')

@section('title', 'Unauthorized')
@section('error_code', '401')
@section('description', 'Authentication is required to access this page.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-person-x"></i>
    </div>
    
    <div class="error-code">401</div>
    
    <h2 class="error-title">Unauthorized Access</h2>
    
    <p class="error-message">
        You need to be authenticated to access this page. 
        Please log in with your credentials.
    </p>
@endsection

@section('actions')
    <a href="{{ route('login') }}" class="btn-primary">
        <i class="bi bi-box-arrow-in-right"></i> Login
    </a>
    
    <a href="{{ url('/') }}" class="btn-secondary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
@endsection