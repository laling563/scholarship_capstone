@extends('layouts.sponsor')

@section('content')
<div class="container-fluid py-4">

    <!-- Main Content Area -->
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h4 class="mb-2 mb-md-0 text-center text-md-start"><i class="bi bi-file-earmark-text me-2"></i>Student Application</h4>
                        <span class="badge bg-warning p-2 align-self-center">{{ ucfirst($application->status) }}</span>
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
                        <div class="col-lg-6 mb-3">
                            <div class="info-item p-3 rounded bg-light">
                                <h6 class="text-muted small mb-1">Full Name</h6>
                                <p class="mb-0 h5">{{ $application->student->fname }} {{ $application->student->lname }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="info-item p-3 rounded bg-light">
                                <h6 class="text-muted small mb-1">Email</h6>
                                <p class="mb-0">{{ $application->student->email }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="info-item p-3 rounded bg-light">
                                <h6 class="text-muted small mb-1">Course & Year</h6>
                                <p class="mb-0">{{ $application->student->course }} - Year {{ $application->student->year_level }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="info-item p-3 rounded bg-light">
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
                        <div class="col-lg-4 col-md-6 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Date of Birth</h6><p class="mb-0">{{ date('F j, Y', strtotime($application->date_of_birth)) }}</p></div></div>
                        <div class="col-lg-4 col-md-6 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Civil Status</h6><p class="mb-0">{{ ucfirst($application->civil_status) }}</p></div></div>
                        <div class="col-lg-4 col-md-6 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Religion</h6><p class="mb-0">{{ $application->religion }}</p></div></div>
                        <div class="col-lg-8 col-md-6 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Place of Birth</h6><p class="mb-0">{{ $application->place_of_birth }}</p></div></div>
                        <div class="col-lg-2 col-md-6 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Height</h6><p class="mb-0">{{ $application->height }} cm</p></div></div>
                        <div class="col-lg-2 col-md-6 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Weight</h6><p class="mb-0">{{ $application->weight }} kg</p></div></div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light-blue-gradient text-white py-3"><h5 class="mb-0"><i class="bi bi-house-heart me-2"></i>Address Information</h5></div>
                <div class="card-body"><div class="row"><div class="col-12 mb-3"><div class="info-item p-3 rounded bg-light"><h6 class="text-primary mb-1"><i class="bi bi-house-door me-2"></i>Home Address</h6><p class="mb-0">{{ $application->home_address }}</p></div></div><div class="col-12 mb-3"><div class="info-item p-3 rounded bg-light"><h6 class="text-primary mb-1"><i class="bi bi-telephone me-2"></i>Contact Address</h6><p class="mb-0">{{ $application->contact_address }}</p></div></div><div class="col-12 mb-3"><div class="info-item p-3 rounded bg-light"><h6 class="text-primary mb-1"><i class="bi bi-building me-2"></i>Boarding Address</h6><p class="mb-0">{{ $application->boarding_address }}</p></div></div><div class="col-12 mb-3"><div class="info-item p-3 rounded bg-light"><h6 class="text-primary mb-1"><i class="bi bi-person-vcard me-2"></i>Landlord/Landlady</h6><p class="mb-0">{{ $application->landlord_landlady }}</p></div></div></div></div>
            </div>

            <!-- Educational Background -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light-blue-gradient text-white py-3"><h5 class="mb-0"><i class="bi bi-mortarboard me-2"></i>Educational Background</h5></div>
                <div class="card-body"><div class="row"><div class="col-md-6 mb-3"><div class="info-item p-3 rounded bg-light"><h6 class="text-muted small mb-1">High School</h6><p class="mb-0">{{ $application->high_school_graduated }}</p></div></div><div class="col-md-6 mb-3"><div class="info-item p-3 rounded bg-light"><h6 class="text-muted small mb-1">Year Graduated</h6><p class="mb-0">{{ $application->high_school_year_graduated }}</p></div></div></div></div>
            </div>

            <!-- Family Information -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light-blue-gradient text-white py-3"><h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Family Information</h5></div>
                <div class="card-body">
                    <div class="family-member mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center mb-3"><div class="bg-primary rounded-circle p-2 me-3"><i class="bi bi-gender-male text-white fs-5"></i></div><h5 class="mb-0">Father's Information</h5></div>
                        <div class="row"><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Full Name</h6><p class="mb-0">{{ $application->father_first_name }} {{ $application->father_middle_name }} {{ $application->father_last_name }}</p></div></div><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Occupation</h6><p class="mb-0">{{ $application->father_occupation }}</p></div></div><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Monthly Income</h6><p class="mb-0">₱{{ number_format($application->father_monthly_income, 2) }}</p></div></div></div>
                    </div>
                    <div class="family-member mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center mb-3"><div class="bg-danger rounded-circle p-2 me-3"><i class="bi bi-gender-female text-white fs-5"></i></div><h5 class="mb-0">Mother's Information</h5></div>
                        <div class="row"><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Full Name</h6><p class="mb-0">{{ $application->mother_first_name }} {{ $application->mother_middle_name }} {{ $application->mother_last_name }}</p></div></div><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Occupation</h6><p class="mb-0">{{ $application->mother_occupation }}</p></div></div><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Monthly Income</h6><p class="mb-0">₱{{ number_format($application->mother_monthly_income, 2) }}</p></div></div></div>
                    </div>
                    <div class="family-summary">
                        <div class="d-flex align-items-center mb-3"><div class="bg-info rounded-circle p-2 me-3"><i class="bi bi-people text-white fs-5"></i></div><h5 class="mb-0">Family Summary</h5></div>
                        <div class="row"><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Siblings (Brothers)</h6><p class="mb-0">{{ $application->number_of_brothers }}</p></div></div><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Siblings (Sisters)</h6><p class="mb-0">{{ $application->number_of_sisters }}</p></div></div><div class="col-md-4 mb-3"><div class="info-item p-3 rounded bg-light h-100"><h6 class="text-muted small mb-1">Total Monthly Income</h6><p class="mb-0">₱{{ number_format($application->total_monthly_income, 2) }}</p></div></div></div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light-blue-gradient text-white py-3"><h5 class="mb-0"><i class="bi bi-file-earmark-arrow-up me-2"></i>Uploaded Documents</h5></div>
                <div class="card-body">
                    @if($application->documents->count() > 0)
                        <div class="row">
                            @foreach ($application->documents as $document)
                                <div class="col-md-6 mb-3">
                                    <div class="document-card p-3 border rounded d-flex flex-column flex-sm-row align-items-start align-items-sm-center h-100">
                                        <i class="bi bi-file-earmark-text text-primary me-3 mb-2 mb-sm-0" style="font-size: 2.5rem;"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $document->document_type }}</h6>
                                            <small class="text-muted d-block mb-2">Uploaded: {{ $document->created_at->format('M d, Y') }}</small>
                                            <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="bi bi-download me-1"></i> View File</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No documents uploaded for this application.</div>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light-blue-gradient text-white py-3"><h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Additional Information</h5></div>
                <div class="card-body"><div class="info-item p-3 rounded bg-light"><h6 class="text-muted small mb-1">Notes</h6><p class="mb-0">{{ $application->notes ?? 'No additional notes provided.' }}</p></div></div>
            </div>

            <!-- Action Buttons -->
            <div class="card border-0 shadow-sm">
                 <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <a href="{{ route('sponsor.applications') }}" class="btn btn-outline-secondary mb-2 mb-md-0"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
                    @if($application->status == 'pending')
                        <div class="d-flex">
                            <form action="{{ route('sponsor.applications.reject', $application->applicationform_id) }}" method="POST" class="me-2">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i>Reject</button>
                            </form>
                            <form action="{{ route('sponsor.applications.accept', $application->applicationform_id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Accept</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-light-blue-gradient { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
    .document-card { transition: all 0.3s ease; }
    .document-card:hover { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); transform: translateY(-2px); }
</style>
@endsection
