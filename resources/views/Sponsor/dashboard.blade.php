@extends('layouts.sponsor')

@section('content')
<div class="container my-5">
    <!-- Welcome -->
    <h2 class="fw-bold mb-4">Welcome, {{ $sponsor->name }}!</h2>

    <!-- Stats Grid -->
    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Total Applicants</h5>
                    <p class="display-5 fw-bold text-primary">{{ $applications->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Approved Applicants</h5>
                    <p class="display-5 fw-bold text-success">
                        {{ $applications->where('status', 'approved')->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Pending Applicants</h5>
                    <p class="display-5 fw-bold text-warning">
                        {{ $applications->where('status', 'pending')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scholarships -->
    <div class="mt-5">
        <h3 class="fw-bold mb-3">Your Scholarships</h3>
        <div class="card shadow-sm border-0">
            <ul class="list-group list-group-flush">
                @forelse($scholarships as $scholarship)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">{{ $scholarship->title }}</span>
                        <span class="badge bg-primary rounded-pill">
                            {{ $scholarship->application_forms_count }} applicants
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No scholarships found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
