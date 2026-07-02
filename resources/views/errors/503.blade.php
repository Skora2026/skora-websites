<!-- resources/views/errors/503.blade.php -->
@extends('errors.layout')

@section('title', 'Service Unavailable')
@section('error_code', '503')
@section('description', 'The service is temporarily unavailable for maintenance.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-tools"></i>
    </div>
    
    <div class="error-code">503</div>
    
    <h2 class="error-title">Service Unavailable</h2>
    
    <p class="error-message">
        We're currently performing maintenance to improve your experience. 
        The site will be back online shortly. Thank you for your patience.
    </p>
    
    <!-- Optional: Show maintenance end time -->
    @if(!empty($exception->retryAfter))
    <div class="alert alert-info mt-3" style="background: rgba(13, 110, 253, 0.1); border: 1px solid #0d6efd; color: #0d6efd; padding: 12px; border-radius: 10px; display: inline-block;">
        <i class="bi bi-clock me-2"></i>
        Expected back: {{ date('h:i A', strtotime($exception->retryAfter)) }}
    </div>
    @endif
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="btn-primary">
        <i class="bi bi-arrow-clockwise"></i> Check Again
    </button>
    
    <a href="javascript:void(0)" onclick="history.back()" class="btn-secondary">
        <i class="bi bi-arrow-left"></i> Go Back
    </a>
@endsection

@push('scripts')
<script>
    // Auto-refresh every 30 seconds
    setInterval(function() {
        window.location.reload();
    }, 30000);
</script>
@endpush