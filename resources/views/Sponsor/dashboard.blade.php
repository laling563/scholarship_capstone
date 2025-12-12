@extends('layouts.sponsor')

@section('title', 'Sponsor Dashboard - PSU Scholarship System')

@section('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, var(--sponsor-primary) 0%, var(--sponsor-accent) 100%);
        color: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .dashboard-header h1 {
        font-weight: 700;
        font-size: 2.25rem; /* Larger font for welcome */
    }

    .dashboard-header p {
        font-size: 1rem;
        opacity: 0.8;
    }

    .stat-card {
        border: none;
        border-radius: 16px;
        padding: 1.5rem;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>Welcome, {{ $sponsor->name }}!</h1>
        <p class="mb-0">Here's an overview of your sponsored scholarships and applicant activity.</p>
    </div>

    <!-- STATS -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-label">Total Applicants</div>
                <div class="stat-number text-primary">{{ $applications->count() }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-label">Approved Applicants</div>
                <div class="stat-number text-success">{{ $applications->where('status', 'approved')->count() }}</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-label">Pending Applicants</div>
                <div class="stat-number text-warning">{{ $applications->where('status', 'pending')->count() }}</div>
            </div>
        </div>
         <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-label">Your Scholarships</div>
                <div class="stat-number text-info">{{ $scholarships->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Scholarships List -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
             <h5 class="fw-bold mb-0">Your Active Scholarships</h5>
        </div>
        <div class="card-body">
             @if($scholarships->isEmpty())
                <div class="text-center text-muted py-4">
                    <p class="mb-2">You haven't created any scholarships yet.</p>
                    <a href="{{ route('sponsor.scholarships.create') }}" class="btn btn-primary">Create Scholarship</a>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($scholarships as $scholarship)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div>
                                <h6 class="fw-semibold mb-1">{{ $scholarship->title }}</h6>
                                <small class="text-muted">{{ $scholarship->type == 'government' ? 'Government Scholarship' : 'Private Scholarship' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill fs-6">
                                {{ $scholarship->application_forms_count }} Applicants
                            </span>
                        </li>
                    @endforeach
                </ul>
             @endif
        </div>
         <div class="card-footer bg-white border-0 text-center py-3">
            <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-outline-primary btn-sm">Manage All Scholarships</a>
        </div>
    </div>
</div>
@endsection
