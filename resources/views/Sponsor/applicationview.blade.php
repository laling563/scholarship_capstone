@extends('layouts.sponsor')

@section('content')
    <div class="container-fluid py-4" style="margin-left: 100px;">

        <!-- Sidebar (same as your original) -->
        <div class="bg-dark text-white" style="width: 250px; min-height: 100vh; position: fixed; top: 0; left: 0;">
            <!-- Your sidebar content -->
        </div>

        <!-- Main Content Area -->
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="card mb-4 border-0 shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Student Application Details</h3>
                            <span class="badge bg-warning p-2">Pending Review</span>
                        </div>
                    </div>
                </div>

                <!-- Student Information -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Student Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <h6 class="text-muted small mb-1">Full Name</h6>
                                    <p class="mb-0 h5">{{ $application->student->fname }} {{ $application->student->lname }}
                                    </p>
                                </div>
                                <div class="info-item mb-3">
                                    <h6 class="text-muted small mb-1">Email</h6>
                                    <p class="mb-0">{{ $application->student->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item mb-3">
                                    <h6 class="text-muted small mb-1">Course & Year</h6>
                                    <p class="mb-0">{{ $application->student->course }} - Year
                                        {{ $application->student->year_level }}</p>
                                </div>
                                <div class="info-item mb-3">
                                    <h6 class="text-muted small mb-1">Application Date</h6>
                                    <p class="mb-0">{{ date('F j, Y', strtotime($application->submission_date)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Date of Birth</h6>
                                    <p class="mb-0">{{ date('F j, Y', strtotime($application->date_of_birth)) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Civil Status</h6>
                                    <p class="mb-0">{{ ucfirst($application->civil_status) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Religion</h6>
                                    <p class="mb-0">{{ $application->religion }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Place of Birth</h6>
                                    <p class="mb-0">{{ $application->place_of_birth }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Height</h6>
                                    <p class="mb-0">{{ $application->height }} cm</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Weight</h6>
                                    <p class="mb-0">{{ $application->weight }} kg</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-house-heart me-2"></i>Address Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="info-item">
                                    <h6 class="text-primary mb-2"><i class="bi bi-house-door me-1"></i> Home Address</h6>
                                    <p class="mb-0">{{ $application->home_address }}</p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="info-item">
                                    <h6 class="text-primary mb-2"><i class="bi bi-telephone me-1"></i> Contact Address</h6>
                                    <p class="mb-0">{{ $application->contact_address }}</p>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="info-item">
                                    <h6 class="text-primary mb-2"><i class="bi bi-building me-1"></i> Boarding Address</h6>
                                    <p class="mb-0">{{ $application->boarding_address }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-item">
                                    <h6 class="text-primary mb-2"><i class="bi bi-person-vcard me-1"></i> Landlord/Landlady
                                    </h6>
                                    <p class="mb-0">{{ $application->landlord_landlady }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Educational Background -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-mortarboard me-2"></i>Educational Background</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">High School Graduated</h6>
                                    <p class="mb-0">{{ $application->high_school_graduated }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <h6 class="text-muted small mb-1">Year Graduated</h6>
                                    <p class="mb-0">{{ $application->high_school_year_graduated }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Information -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Family Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Father's Information -->
                        <div class="family-member mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle p-2 me-3">
                                    <i class="bi bi-gender-male text-white"></i>
                                </div>
                                <h5 class="mb-0">Father's Information</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Full Name</h6>
                                        <p class="mb-0">{{ $application->father_first_name }}
                                            {{ $application->father_middle_name }} {{ $application->father_last_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Occupation</h6>
                                        <p class="mb-0">{{ $application->father_occupation }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Monthly Income</h6>
                                        <p class="mb-0">₱{{ number_format($application->father_monthly_income, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mother's Information -->
                        <div class="family-member mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-pink rounded-circle p-2 me-3">
                                    <i class="bi bi-gender-female text-white"></i>
                                </div>
                                <h5 class="mb-0">Mother's Information</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Full Name</h6>
                                        <p class="mb-0">{{ $application->mother_first_name }}
                                            {{ $application->mother_middle_name }} {{ $application->mother_last_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Occupation</h6>
                                        <p class="mb-0">{{ $application->mother_occupation }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Monthly Income</h6>
                                        <p class="mb-0">₱{{ number_format($application->mother_monthly_income, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Family Summary -->
                        <div class="family-summary">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info rounded-circle p-2 me-3">
                                    <i class="bi bi-people text-white"></i>
                                </div>
                                <h5 class="mb-0">Family Summary</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Number of Brothers</h6>
                                        <p class="mb-0">{{ $application->number_of_brothers }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Number of Sisters</h6>
                                        <p class="mb-0">{{ $application->number_of_sisters }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="info-item">
                                        <h6 class="text-muted small mb-1">Family Total Monthly Income</h6>
                                        <p class="mb-0">₱{{ number_format($application->total_monthly_income, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-arrow-up me-2"></i>Uploaded Documents</h5>
                    </div>
                    <div class="card-body">
                        @if($application->documents->count() > 0)
                            <div class="row">
                                @foreach ($application->documents as $document)
                                    <div class="col-md-6 mb-4">
                                        <div class="document-card p-3 border rounded h-100">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-file-earmark-text fs-3 me-3 text-primary"></i>
                                                <div>
                                                    <h6 class="mb-0">{{ $document->document_type }}</h6>
                                                    <small class="text-muted">Uploaded:
                                                        {{ $document->created_at->format('F d, Y h:i A') }}</small>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <p class="small mb-2">{{ $document->notes }}</p>
                                                <a href="{{ asset("storage/" . $document->file_path) }}"
                                                    class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="bi bi-download me-1"></i> View File
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                No documents uploaded for this application.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light-blue-gradient text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Additional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <h6 class="text-muted small mb-1">Notes</h6>
                            <p class="mb-0">{{ $application->notes ?? 'No additional notes provided.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="d-flex justify-content-start mt-4">
                    <a href="{{ route('sponsor.applications') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-light-blue-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }

        .info-item {
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .info-item:hover {
            background-color: #f8f9fa;
        }

        .document-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .family-member {
            transition: all 0.3s ease;
        }

        .family-member:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
    </style>
@endsection