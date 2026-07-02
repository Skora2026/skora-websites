<!-- resources/views/errors/402.blade.php -->
@extends('errors.layout')

@section('title', 'Payment Required')
@section('error_code', '402')
@section('description', 'Payment is required to access this content.')

@section('content')
    <div class="error-icon">
        <i class="bi bi-credit-card"></i>
    </div>
    
    <div class="error-code">402</div>
    
    <h2 class="error-title">Payment Required</h2>
    
    <p class="error-message">
        This content requires a subscription or payment to access. 
        Please upgrade your plan to continue.
    </p>
@endsection

@section('actions')
    <a href="{{ route('pricing') ?? '#' }}" class="btn-primary">
        <i class="bi bi-star"></i> View Plans
    </a>
    
    <a href="{{ route('dashboard') ?? url('/') }}" class="btn-secondary">
        <i class="bi bi-speedometer2"></i> Go to Dashboard
    </a>
@endsection