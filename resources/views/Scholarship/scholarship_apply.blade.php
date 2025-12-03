@extends('Student.StudentDashboardLayout')

@section('title', 'Apply for Scholarship - PSU System')

@section('content')
<div class="d-flex flex-column flex-md-row">

    <!-- Sidebar -->
    <div class="bg-dark text-white sidebar d-flex flex-column" id="sidebar">
        <div class="p-3 border-bottom border-secondary text-center">
            <h4 class="mb-0">PSU Scholarship</h4>
        </div>

        <div class="p-3 border-bottom border-secondary bg-primary bg-opacity-25 text-center">
            <i class="fas fa-user-circle fa-3x mb-2"></i>
            <h6 class="mb-0">{{ session('student_fname') }} {{ session('student_lname') }}</h6>
        </div>

        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a class="nav-link text-white" href="/student/dashboard">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/student/my-applications">
                    <i class="fas fa-scroll me-2"></i> My Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white active bg-primary bg-opacity-75 rounded" href="/student/find-scholarship">
                    <i class="fas fa-search me-2"></i> Find Scholarships
                </a>
            </li>
        </ul>

        <div class="sidebar-footer text-center mt-auto mb-3">
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-danger fw-bold">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Toggle Button for Mobile -->
    <button class="btn btn-primary d-md-none m-2" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <div class="container-fluid py-4 main-content">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                    <div>
                        <strong>Please correct the errors below:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Apply for Scholarship</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{ $scholarship->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 d-flex align-items-center">
                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-person-badge"></i>
                    </span>
                    Your Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-item"><small class="text-muted">Full Name</small><p class="mb-0">{{ $student->fname }} {{ $student->lname }}</p></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item"><small class="text-muted">Email</small><p class="mb-0">{{ $student->email }}</p></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item"><small class="text-muted">Course</small><p class="mb-0">{{ $student->course }}</p></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item"><small class="text-muted">Year Level</small><p class="mb-0">{{ $student->year_level }}</p></div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('scholarships.submit', $scholarship->scholarship_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="scholarship_id" value="{{ $scholarship->scholarship_id }}">
            <input type="hidden" name="student_id" value="{{ session('student_id') }}">

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 d-flex align-items-center"><span class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-card-list"></i></span> Personal Information</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Date of Birth</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-calendar3 text-muted"></i></span><input type="date" name="date_of_birth" class="form-control"></div></div>
                        <div class="col-md-4"><label class="form-label">Civil Status</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-person-lines-fill text-muted"></i></span><select name="civil_status" class="form-select"><option value="" selected disabled>Select status</option><option value="Single">Single</option><option value="Married">Married</option><option value="Divorced">Divorced</option><option value="Widowed">Widowed</option></select></div></div>
                        <div class="col-md-4"><label class="form-label">Religion</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-bookmark text-muted"></i></span><input type="text" name="religion" class="form-control"></div></div>
                        <div class="col-md-6"><label class="form-label">Place of Birth</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-geo-alt text-muted"></i></span><input type="text" name="place_of_birth" class="form-control"></div></div>
                        <div class="col-md-3"><label class="form-label">Height (cm)</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-rulers text-muted"></i></span><input type="number" name="height" class="form-control"></div></div>
                        <div class="col-md-3"><label class="form-label">Weight (kg)</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-speedometer2 text-muted"></i></span><input type="number" name="weight" class="form-control"></div></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 d-flex align-items-center"><span class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-house-door"></i></span> Address Information</h5></div>
                <div class="card-body"><div class="row g-3"><div class="col-md-12"><label class="form-label">Home Address</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-house text-muted"></i></span><input type="text" name="home_address" class="form-control"></div></div><div class="col-md-12"><label class="form-label">Contact Number</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span><input type="text" name="contact_address" class="form-control"></div></div><div class="col-md-8"><label class="form-label">Boarding Address</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-building text-muted"></i></span><input type="text" name="boarding_address" class="form-control"></div></div><div class="col-md-4"><label class="form-label">Landlord/Landlady</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span><input type="text" name="landlord_landlady" class="form-control"></div></div></div></div>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 d-flex align-items-center"><span class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-mortarboard"></i></span> Educational Background</h5></div>
                <div class="card-body"><div class="row g-3"><div class="col-md-6"><label class="form-label">High School Graduated</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-building text-muted"></i></span><input type="text" name="high_school_graduated" class="form-control"></div></div><div class="col-md-6"><label class="form-label">Year Graduated</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-calendar-check text-muted"></i></span><input type="text" name="high_school_year_graduated" class="form-control"></div></div></div></div>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 d-flex align-items-center"><span class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-people"></i></span> Family Information</h5></div>
                <div class="card-body">
                    <div class="border-bottom pb-3 mb-3"><h6 class="mb-3 d-flex align-items-center"><span class="icon-circle-sm bg-info bg-opacity-10 text-info me-2"><i class="bi bi-person"></i></span> Father's Information</h6><div class="row g-3"><div class="col-md-4"><label class="form-label">First Name</label><input type="text" name="father_first_name" class="form-control"></div><div class="col-md-4"><label class="form-label">Middle Name</label><input type="text" name="father_middle_name" class="form-control"></div><div class="col-md-4"><label class="form-label">Last Name</label><input type="text" name="father_last_name" class="form-control"></div><div class="col-md-4"><label class="form-label">Occupation</label><input type="text" name="father_occupation" class="form-control"></div><div class="col-md-4"><label class="form-label">Monthly Income</label><div class="input-group"><span class="input-group-text bg-light">₱</span><input type="number" name="father_monthly_income" class="form-control"></div></div></div></div>
                    <div class="border-bottom pb-3 mb-3"><h6 class="mb-3 d-flex align-items-center"><span class="icon-circle-sm bg-info bg-opacity-10 text-info me-2"><i class="bi bi-person"></i></span> Mother's Information</h6><div class="row g-3"><div class="col-md-4"><label class="form-label">First Name</label><input type="text" name="mother_first_name" class="form-control"></div><div class="col-md-4"><label class="form-label">Middle Name</label><input type="text" name="mother_middle_name" class="form-control"></div><div class="col-md-4"><label class="form-label">Last Name</label><input type="text" name="mother_last_name" class="form-control"></div><div class="col-md-4"><label class="form-label">Occupation</label><input type="text" name="mother_occupation" class="form-control"></div><div class="col-md-4"><label class="form-label">Monthly Income</label><div class="input-group"><span class="input-group-text bg-light">₱</span><input type="number" name="mother_monthly_income" class="form-control"></div></div></div></div>
                    <div><h6 class="mb-3 d-flex align-items-center"><span class="icon-circle-sm bg-info bg-opacity-10 text-info me-2"><i class="bi bi-people"></i></span> Family Summary</h6><div class="row g-3"><div class="col-md-4"><label class="form-label">Number of Brothers</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span><input type="number" name="number_of_brothers" class="form-control"></div></div><div class="col-md-4"><label class="form-label">Number of Sisters</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span><input type="number" name="number_of_sisters" class="form-control"></div></div><div class="col-md-4"><label class="form-label">Family Total Monthly Income</label><div class="input-group"><span class="input-group-text bg-light">₱</span><input type="number" name="total_monthly_income" class="form-control"></div></div></div></div>
                </div>
            </div>

            @php
                $requirements = $scholarship->requirements;
                while (is_string($requirements)) {
                    $decoded = json_decode($requirements, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $requirements = $decoded;
                    } else {
                        $requirements = [];
                        break;
                    }
                }
                if (is_array($requirements)) {
                    $requirements = array_filter($requirements);
                } else {
                    $requirements = [];
                }
            @endphp

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 d-flex align-items-center"><span class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-file-earmark-text"></i></span> Supporting Documents</h5></div>
                <div class="card-body">
                    <p class="text-muted mb-4">Please upload all required supporting documents below (.pdf, .jpg, .jpeg, .png, .doc, .docx)</p>
                    @if(!empty($requirements))
                        @foreach($requirements as $index => $requirement)
                            <div class="mb-3">
                                <label class="form-label">{{ $requirement }}</label>
                                <input type="file" name="documents[{{ $index }}][file]" class="form-control">
                                <input type="hidden" name="documents[{{ $index }}][document_type]" value="{{ $requirement }}">
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No specific documents are required for this scholarship.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom"><h5 class="mb-0 d-flex align-items-center"><span class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-info-circle"></i></span> Additional Information</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Submission Date</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-calendar3 text-muted"></i></span><input type="date" name="submission_date" class="form-control"></div></div>
                        <div class="col-md-12"><label class="form-label">Notes (Optional)</label><div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-pencil text-muted"></i></span><textarea name="notes" class="form-control" rows="3" placeholder="Any additional information you would like to share..."></textarea></div></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between border-top pt-4 mb-5">
                <div><button type="button" class="btn btn-outline-secondary me-2"><i class="bi bi-x-circle me-2"></i>Cancel</button><button type="submit" class="btn btn-primary"><i class="bi bi-send me-2"></i>Submit Application</button></div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Sidebar styling */
    .sidebar {
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #212529;
        color: #fff;
        z-index: 2000;
        transition: transform 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
    }

    /* Toggle button (mobile) */
    #sidebarToggle {
        width: 40px !important;
        height: 38px !important;
        padding: 0 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 6px;
    }

    /* Hide sidebar on mobile initially */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.active {
            transform: translateX(0);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        }
        .main-content {
            margin-left: 0 !important;
        }

        /* Add overlay background when sidebar active */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1500;
        }
        .overlay.active {
            display: block;
        }
    }

    /* Desktop sidebar behavior */
    @media (min-width: 769px) {
        .main-content {
            margin-left: 250px;
        }
        #sidebarToggle {
            display: none;
        }
    }

    /* Sidebar footer */
    .sidebar-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: auto;
    }

    .nav-link.active {
        font-weight: 600;
    }

    .icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .info-item {
        background-color: #f8f9fa;
        border-radius: 6px;
        padding: 1rem;
    }
    .card {
        border-radius: 10px;
    }
    .card-header {
        padding: 0.75rem 1.25rem;
    }
    .form-control, .form-select, .input-group-text {
        font-size: 0.875rem;
    }
</style>

<!-- Overlay (for mobile when sidebar active) -->
<div class="overlay" id="overlay"></div>

<!-- Script -->
<script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (toggleBtn && sidebar && overlay) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
</script>
@endsection
