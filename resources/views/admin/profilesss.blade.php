@extends('layouts.admin') <!-- Ya jo bhi aapka main layout hai -->

@section('title', 'Update Profile')

@push('styles')
<style>
    .password-toggle {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
@section('page', 'Update Profile')
<div class="container mt-5">
    <div class="row justify-content-center">
            <div class="card shadow">
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                        <!-- Name -->
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        <!-- Password (Optional) -->
                        <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Enter new password">
                                <span class="input-group-text password-toggle" onclick="togglePassword('password')">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="col-md-6">
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control" placeholder="Confirm new password">
                                <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                        </div>
                        </div>

                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.parentElement.querySelector('i');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endpush