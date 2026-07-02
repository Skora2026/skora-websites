<!-- resources/views/errors/419.blade.php -->
@extends('errors.layout')

@section('title', 'Page Expired')
@section('error_code', '419')
@section('description', 'Your session has expired. Please refresh the page.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-clock-history"></i>
    </div>
    
    <div class="error-code">419</div>
    
    <h2 class="error-title">Page Expired</h2>
    
    <p class="error-message">
        Your session has expired due to inactivity. 
        Please refresh the page and try again.
    </p>
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="btn-primary">
        <i class="bi bi-arrow-clockwise"></i> Refresh Page
    </button>
    
    <a href="{{ url('/') }}" class="btn-secondary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
@endsection

@push('scripts')
<script>
    // Auto-refresh after 10 seconds
    setTimeout(function() {
        window.location.reload();
    }, 10000);
</script>
@endpush