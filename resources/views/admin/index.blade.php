{{-- resources/views/admin/index.blade.php --}}

@extends('layouts.admin')
@section('title', 'Dashboard')


@section('content')

 <div class="dashboard-header">
      <div class="row align-items-center">
    <div class="col-md-8">
        <h2 class="mb-1">
            Welcome, {{ auth()->user()->name }} 👋
        </h2>
        <p class="welcome-text mb-0 text-muted">
            You’re all set to manage the system efficiently.
        </p>
    </div>

    <div class="col-md-4 text-md-end">
        <span class="badge t px-3 py-2 text-rehab " style="background-color: #ececec87 !important;">
                {{ now()->format('d M Y, h:i A') }}
            </span>
        </div>
    </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stats-card ">
                <div class="card-body p-4 text-center">
                    <a href="{{ route('admin.manage-blogs') }}">
                        <h6 class="mb-3 opacity-75">Total Blogs</h6>
                        <h3>{{ number_format($totalBlogs) }}</h3>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-lg-3">
            <div class="card stats-card ">
                <div class="card-body p-4 text-center">
                    <a href="{{ route('admin.appointments') }}">
                        <h6 class="mb-3 opacity-75">Total Appointments</h6>
                        <h3>{{ number_format($totalAppointment) }}</h3>
                    </a>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6 col-lg-3">
            <div class="card stats-card ">
                <div class="card-body p-4 text-center">
                    <a href="{{ route('admin.bookingline') }}">
                        <h6 class="mb-3 opacity-75">Total Book Online</h6>
                        <h3>{{ number_format($totalBookOnline) }}</h3>
                    </a>
                </div>
            </div>
        </div> --}}
    </div>

  
@endsection

@push('scripts')
@endpush




