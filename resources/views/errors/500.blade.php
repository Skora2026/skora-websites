<!-- resources/views/errors/500.blade.php -->
@extends('errors.layout')

@section('title', 'Server Error')
@section('error_code', '500')
@section('description', 'Something went wrong on our server. Please try again later.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-server"></i>
    </div>
    
    <div class="error-code">500</div>
    
    <h2 class="error-title">Internal Server Error</h2>
    
    <p class="error-message">
        Something went wrong on our servers. 
        Our team has been notified and is working to fix the issue.
        Please try again later.
    </p>
    
    @if(config('app.debug'))
    <div class="alert alert-info mt-4" style="text-align: left; background: rgba(13, 110, 253, 0.1); border: 1px solid #0d6efd; color: #0d6efd; padding: 15px; border-radius: 10px; font-size: 0.9rem;">
        <strong>Debug Information:</strong><br>
        Error: {{ $exception->getMessage() ?? 'Unknown error' }}
    </div>
    @endif
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn-primary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
    
    <button onclick="window.location.reload()" class="btn-secondary">
        <i class="bi bi-arrow-clockwise"></i> Try Again
    </button>
@endsection