<!-- resources/views/errors/429.blade.php -->
@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('error_code', '429')
@section('description', 'You have made too many requests. Please wait and try again.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-hourglass-split"></i>
    </div>
    
    <div class="error-code">429</div>
    
    <h2 class="error-title">Too Many Requests</h2>
    
    <p class="error-message">
        You have sent too many requests in a short period of time. 
        Please wait for a while before trying again.
    </p>
    
    <!-- Show retry time if available -->
    @if(!empty($exception->retryAfter))
    <div class="alert alert-warning mt-3" style="background: rgba(255, 193, 7, 0.1); border: 1px solid #ffc107; color: #856404; padding: 12px; border-radius: 10px; display: inline-block;">
        <i class="bi bi-clock-history me-2"></i>
        Try again after: {{ $exception->retryAfter }} seconds
    </div>
    @endif
@endsection

@section('actions')
    <button onclick="window.location.reload()" class="btn-primary">
        <i class="bi bi-arrow-clockwise"></i> Try Again
    </button>
    
    <a href="{{ url('/') }}" class="btn-secondary">
        <i class="bi bi-house-door"></i> Go to Homepage
    </a>
@endsection

@push('scripts')
<script>
    // Countdown timer if retryAfter is set
    @if(!empty($exception->retryAfter))
    let timeLeft = {{ $exception->retryAfter }};
    const countdownElement = document.querySelector('.alert-warning');
    
    const countdownInterval = setInterval(() => {
        timeLeft--;
        
        if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            countdownElement.innerHTML = '<i class="bi bi-check-circle me-2"></i>Ready to try again!';
            document.querySelector('.btn-primary').disabled = false;
        } else {
            countdownElement.innerHTML = `<i class="bi bi-clock-history me-2"></i>Try again in: ${timeLeft} seconds`;
        }
    }, 1000);
    @endif
</script>
@endpush