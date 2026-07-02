<!-- resources/views/errors/404.blade.php -->
@extends('errors.layout')

@section('title', 'Page Not Found')
@section('error_code', '404')
@section('description', 'The page you are looking for could not be found.')

@section('content')
    <div class="error-code">404</div>
    <h2 class="error-title">Page Not Found</h2>
    <p class="error-message">
        Oops! The page you are looking for might have been removed, 
        had its name changed, or is temporarily unavailable.
    </p>
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn-primary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
    
    <a href="javascript:history.back()" class="btn-secondary">
        <i class="bi bi-arrow-left"></i> Go Back
    </a>
@endsection