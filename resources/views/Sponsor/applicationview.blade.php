@extends('layouts.sponsor')

@section('title', 'View Application - Sponsor Dashboard')

@section('styles')
<style>
    .header-container {
        background: linear-gradient(135deg, var(--sponsor-primary) 0%, var(--sponsor-accent) 100%);
        color: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .info-group dt {
        font-weight: 600;
        color: #6c757d;
        flex-basis: 35%;
    }
    .info-group dd {
        font-weight: 500;
    }
    .document-card {
        transition: all 0.2s ease-in-out;
    }
    .document-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="header-container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">Student Application</h1>
            <p class="mb-0 opacity-75">Submitted on {{ date('F j, Y', strtotime($application->submission_date)) }}</p>
        </div>
        <span class="badge fs-5 rounded-pill text-bg-{{ $application->status == 'pending' ? 'warning' : ($application->status == 'accepted' ? 'success' : 'danger') }}">
            {{ ucfirst($application->status) }}
        </span>
    </div>

    <div class="row g-4">
        <!-- Main Content Column -->
        <div class="col-lg-8">

            <!-- Personal Information -->
            <div class="card card-custom mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Personal Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 info-group">
                        <dt class="col-sm-4">Date of Birth</dt><dd class="col-sm-8">{{ date('F j, Y', strtotime($application->date_of_birth)) }}</dd>
                        <dt class="col-sm-4">Civil Status</dt><dd class="col-sm-8">{{ ucfirst($application->civil_status) }}</dd>
                        <dt class="col-sm-4">Religion</dt><dd class="col-sm-8">{{ $application->religion }}</dd>
                        <dt class="col-sm-4">Place of Birth</dt><dd class="col-sm-8">{{ $application->place_of_birth }}</dd>
                        <dt class="col-sm-4">Height & Weight</dt><dd class="col-sm-8">{{ $application->height }} cm / {{ $application->weight }} kg</dd>
                    </dl>
                </div>
            </div>

            <!-- Address Information -->
            <div class="card card-custom mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Address</h5></div>
                <div class="card-body">
                    <dl class="row mb-0 info-group">
                        <dt class="col-sm-4">Home Address</dt><dd class="col-sm-8">{{ $application->home_address }}</dd>
                        <dt class="col-sm-4">Contact Address</dt><dd class="col-sm-8">{{ $application->contact_address }}</dd>
                        <dt class="col-sm-4">Boarding Address</dt><dd class="col-sm-8">{{ $application->boarding_address ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Landlord/Landlady</dt><dd class="col-sm-8">{{ $application->landlord_landlady ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

             <!-- Family Information -->
            <div class="card card-custom mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Family Information</h5></div>
                <div class="card-body">
                    <!-- Father -->
                    <h6 class="text-primary">Father's Details</h6>
                    <dl class="row mb-3 info-group">
                        <dt class="col-sm-4">Full Name</dt><dd class="col-sm-8">{{ $application->father_first_name }} {{ $application->father_last_name }}</dd>
                        <dt class="col-sm-4">Occupation</dt><dd class="col-sm-8">{{ $application->father_occupation }}</dd>
                        <dt class="col-sm-4">Monthly Income</dt><dd class="col-sm-8">₱{{ number_format($application->father_monthly_income, 2) }}</dd>
                    </dl>
                    <!-- Mother -->
                    <h6 class="text-primary mt-4">Mother's Details</h6>
                     <dl class="row mb-3 info-group">
                        <dt class="col-sm-4">Full Name</dt><dd class="col-sm-8">{{ $application->mother_first_name }} {{ $application->mother_last_name }}</dd>
                        <dt class="col-sm-4">Occupation</dt><dd class="col-sm-8">{{ $application->mother_occupation }}</dd>
                        <dt class="col-sm-4">Monthly Income</dt><dd class="col-sm-8">₱{{ number_format($application->mother_monthly_income, 2) }}</dd>
                    </dl>
                    <!-- Summary -->
                    <h6 class="text-primary mt-4">Family Summary</h6>
                     <dl class="row mb-0 info-group">
                        <dt class="col-sm-4">Number of Siblings</dt><dd class="col-sm-8">{{ $application->number_of_brothers + $application->number_of_sisters }}</dd>
                        <dt class="col-sm-4">Total Monthly Income</dt><dd class="col-sm-8">₱{{ number_format($application->total_monthly_income, 2) }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Documents -->
            <div class="card card-custom mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-file-earmark-arrow-up me-2"></i>Uploaded Documents</h5></div>
                <div class="card-body">
                    @if($application->documents->count() > 0)
                        <div class="row g-3">
                            @foreach ($application->documents as $document)
                                <div class="col-md-6">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="card document-card text-decoration-none shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="bi bi-file-earmark-text text-primary fs-2 me-3"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="card-title text-dark mb-1">{{ $document->document_type }}</h6>
                                                <small class="text-muted">Uploaded: {{ $document->created_at->format('M d, Y') }}</small>
                                            </div>
                                            <i class="bi bi-box-arrow-up-right text-muted ms-2"></i>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light text-center">No documents were uploaded.</div>
                    @endif
                </div>
            </div>

             <!-- Additional Information -->
            <div class="card card-custom">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Additional Notes</h5></div>
                <div class="card-body">
                    <p class="mb-0">{{ $application->notes ?? 'No additional notes provided.' }}</p>
                </div>
            </div>

        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">

            <!-- Student Summary -->
            <div class="card card-custom mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                    <h4 class="mt-2 mb-1">{{ $application->student->fname }} {{ $application->student->lname }}</h4>
                    <p class="text-muted mb-3">{{ $application->student->email }}</p>
                    <dl class="row mb-0 text-start info-group">
                        <dt class="col-12">Course</dt><dd class="col-12">{{ $application->student->course }}</dd>
                        <dt class="col-12">Year Level</dt><dd class="col-12">{{ $application->student->year_level }}</dd>
                        <dt class="col-12">High School</dt><dd class="col-12 mb-0">{{ $application->high_school_graduated }} ({{ $application->high_school_year_graduated }})</dd>
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="card card-custom">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-check2-circle me-2"></i>Actions</h5></div>
                <div class="card-body">
                    <p class="text-muted">Review this application and choose an action below.</p>
                    @if($application->status == 'pending')
                        <div class="d-grid gap-2">
                            <form action="{{ route('sponsor.applications.accept', $application->applicationform_id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-success btn-lg w-100"><i class="bi bi-check-circle me-2"></i>Accept</button>
                            </form>
                            <form action="{{ route('sponsor.applications.reject', $application->applicationform_id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-danger btn-lg w-100"><i class="bi bi-x-circle me-2"></i>Reject</button>
                            </form>
                        </div>
                    @else
                        <p class="text-center fw-bold">A decision has already been made for this application.</p>
                    @endif
                    <hr>
                    <a href="{{ route('sponsor.applications') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-left me-2"></i>Back to Applications</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
