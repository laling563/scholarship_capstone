@extends('Student.StudentDashboardLayout')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg" style="border-radius: 1rem;">
                <div class="card-header bg-primary text-white" style="border-radius: 1rem 1rem 0 0;">
                    <h1 class="h2 mb-0 fw-bold">{{ $scholarship->title }}</h1>
                </div>
                <div class="card-body p-5">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold text-primary">Description</h5>
                            <p>{{ $scholarship->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-primary">Requirements</h5>
                            <ul class="list-unstyled">
                                @foreach($scholarship->requirements as $requirement)
                                    <li><i class="fas fa-check text-success me-2"></i>{{ $requirement }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6 class="text-muted fw-bold">Application Start Date</h6>
                            <p class="fs-5">{{ $scholarship->start_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted fw-bold">Application End Date</h6>
                            <p class="fs-5">{{ $scholarship->end_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted fw-bold">Available Slots</h6>
                            <p class="fs-5">{{ $scholarship->student_limit }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light text-center" style="border-radius: 0 0 1rem 1rem;">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                    <a href="{{ route('student.scholarships.apply', $scholarship->scholarship_id) }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
