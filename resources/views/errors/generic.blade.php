<!-- resources/views/errors/generic.blade.php -->
@extends('errors.layout')

@section('title', 'Error')
@section('error_code', $statusCode ?? 'Error')
@section('description', 'An error occurred.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-exclamation-triangle"></i>
    </div>
    
    <div class="error-code">{{ $statusCode ?? 'Error' }}</div>
    
    <h2 class="error-title">{{ $title ?? 'Something Went Wrong' }}</h2>
    
    <p class="error-message">
        {{ $message ?? 'An unexpected error has occurred. Please try again later.' }}
    </p>
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="btn-primary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
    
    <button onclick="window.location.reload()" class="btn-secondary">
        <i class="bi bi-arrow-clockwise"></i> Try Again
    </button>
@endsection