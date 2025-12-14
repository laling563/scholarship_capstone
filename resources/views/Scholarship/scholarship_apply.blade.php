@extends('Student.StudentDashboardLayout')

@section('title', 'Apply for Scholarship - PSU System')

@section('content')
<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a0ca3;
        --primary-light: #4895ef;
        --success: #38b000;
        --warning: #f0803c;
        --danger: #e63946;
        --info: #4cc9f0;
        --sidebar-gradient: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    body {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    /* Sidebar Styling */
    .sidebar {
        width: 300px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: var(--sidebar-gradient);
        color: white;
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 2px 0 25px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-header {
        background: rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1.75rem;
        text-align: center;
        backdrop-filter: blur(10px);
    }

    .sidebar-header h4 {
        font-weight: 800;
        font-size: 1.6rem;
        margin: 0;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .sidebar-header h4::before {
        content: '🎓';
        font-size: 1.8rem;
    }

    .profile-section {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.2) 0%, rgba(67, 97, 238, 0.1) 100%);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .profile-icon {
        font-size: 4.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        display: block;
        place-self: anchor-center !important;
    }

    .profile-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        margin: 0;
    }

    .sidebar-nav {
        padding: 1.5rem;
        flex: 1;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        padding: 1rem 1.25rem !important;
        border-radius: 12px !important;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease !important;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none !important;
        font-size: 1.05rem;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--primary);
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .nav-link:hover {
        color: white !important;
        background: rgba(255, 255, 255, 0.1) !important;
        transform: translateX(10px);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .nav-link:hover::before {
        transform: translateX(0);
    }

    .nav-link.active {
        color: white !important;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.2);
        font-weight: 700;
        transform: translateX(10px);
    }

    .nav-link.active::before {
        transform: translateX(0);
    }

    .nav-link i {
        width: 25px;
        font-size: 1.2rem;
        text-align: center;
    }

    .sidebar-footer {
        margin-top: auto;
        padding: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        background: rgba(0, 0, 0, 0.2);
    }

    .logout-btn {
        color: #ff6b6b !important;
        font-weight: 700;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        background: rgba(255, 107, 107, 0.15);
        border: 2px solid rgba(255, 107, 107, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .logout-btn:hover {
        background: rgba(255, 107, 107, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.2);
    }

    /* Main Content */
    .main-content {
        margin-left: 300px;
        padding: 2.5rem 3rem;
        min-height: 100vh;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2.5rem;
        animation: fadeInDown 0.6s ease-out;
    }

    .page-header h1 {
        color: var(--primary-dark);
        font-weight: 800;
        font-size: 2.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(67, 97, 238, 0.1);
    }

    .page-header h1::before {
        content: '📝';
        font-size: 2rem;
    }

    .breadcrumb {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .breadcrumb-item.active {
        color: var(--primary-dark);
        font-weight: 600;
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        border-left: 5px solid var(--danger);
        animation: fadeInDown 0.6s ease-out;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    .alert i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    /* Student Info Card */
    .student-info-card {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        animation: slideUp 0.6s ease-out 0.2s forwards;
        opacity: 0;
    }

    .student-info-card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        padding: 1.5rem 2rem !important;
        border-radius: 20px 20px 0 0 !important;
    }

    .card-header h5 {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.3rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header h5::before {
        content: '👤';
        font-size: 1.2rem;
    }

    .card-body {
        padding: 2rem !important;
    }

    .info-item {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 1.25rem;
        border-radius: 12px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.1);
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
    }

    .info-item small {
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-item p {
        color: #1e293b;
        font-weight: 500;
        font-size: 1.05rem;
        margin: 0;
    }

    /* Form Sections */
    .form-section-card {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        animation: slideUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .form-section-card:nth-child(1) { animation-delay: 0.3s; }
    .form-section-card:nth-child(2) { animation-delay: 0.4s; }
    .form-section-card:nth-child(3) { animation-delay: 0.5s; }
    .form-section-card:nth-child(4) { animation-delay: 0.6s; }
    .form-section-card:nth-child(5) { animation-delay: 0.7s; }
    .form-section-card:nth-child(6) { animation-delay: 0.8s; }

    .form-section-card:hover {
        box-shadow: var(--hover-shadow);
    }

    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        margin-right: 1rem;
    }

    /* Form Styling */
    .form-label {
        color: #1e293b;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary);
        font-size: 1rem;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        transform: translateY(-1px);
    }

    .input-group-text {
        background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        border: 2px solid #e2e8f0;
        border-right: none;
        color: var(--primary);
        font-weight: 600;
    }

    .input-group .form-control {
        border-left: none;
    }

    /* Family Section */
    .family-section {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(255, 255, 255, 0.98) 100%);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        margin-bottom: 1.5rem;
    }

    .family-section:last-child {
        margin-bottom: 0;
    }

    .family-section h6 {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .family-section h6::before {
        content: '👨';
        font-size: 1.1rem;
    }

    .family-section:nth-child(2) h6::before {
        content: '👩';
    }

    .family-section:nth-child(3) h6::before {
        content: '🏠';
    }

    /* Documents Section */
    .documents-section {
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.05) 0%, rgba(255, 255, 255, 0.98) 100%);
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid rgba(76, 201, 240, 0.2);
    }

    .documents-section p {
        color: #475569;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .file-input-container {
        position: relative;
    }

    .file-input-container input[type="file"] {
        padding: 0.75rem;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        transition: all 0.3s ease;
    }

    .file-input-container input[type="file"]:hover {
        border-color: var(--primary);
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
    }

    .file-input-container input[type="file"]::file-selector-button {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        margin-right: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-container input[type="file"]::file-selector-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    /* Form Buttons */
    .form-buttons {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 2rem;
        border-radius: 20px;
        border: 2px solid rgba(67, 97, 238, 0.1);
        margin-top: 2rem;
        animation: slideUp 0.6s ease-out 0.9s forwards;
        opacity: 0;
    }

    .btn {
        border-radius: 12px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid transparent;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
    }

    .btn-outline-secondary {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-color: #cbd5e1;
        color: #475569;
    }

    .btn-outline-secondary:hover {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%);
        transform: translateY(-3px);
        border-color: #94a3b8;
    }

    /* Toggle Button for Mobile */
    #sidebarToggle {
        position: fixed;
        top: 1.5rem;
        left: 1.5rem;
        z-index: 1100;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        width: 50px;
        height: 50px;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #sidebarToggle:hover {
        transform: scale(1.1);
    }

    /* Overlay for Mobile */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 900;
    }

    .overlay.active {
        display: block;
        animation: fadeIn 0.3s ease-out;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Responsive Design */
    @media (max-width: 1199.98px) {
        .sidebar {
            width: 280px;
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
        }
    }

    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            width: 320px;
        }

        .sidebar.active {
            transform: translateX(0);
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.25);
        }

        .main-content {
            margin-left: 0 !important;
            padding: 1.5rem;
        }

        #sidebarToggle {
            display: flex;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .info-item {
            padding: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.25rem;
        }

        .form-buttons {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            width: 100%;
            justify-content: center;
        }

        .btn + .btn {
            margin-top: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .main-content {
            padding: 1rem;
        }

        .card-header {
            padding: 1.25rem !important;
        }

        .card-header h5 {
            font-size: 1.1rem;
        }

        .section-icon {
            width: 35px;
            height: 35px;
            font-size: 1rem;
            margin-right: 0.75rem;
        }
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0">PSU Scholarship</h4>
        </div>

        <div class="profile-section">
            <i class="fas fa-user-circle profile-icon"></i>
            <h6 class="profile-name">{{ session('student_fname') }} {{ session('student_lname') }}</h6>
        </div>

        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/student/dashboard">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/student/my-applications">
                    <i class="fas fa-scroll me-2"></i> My Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/student/find-scholarship">
                    <i class="fas fa-search me-2"></i> Find Scholarships
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Toggle Button for Mobile -->
    <button class="btn btn-primary d-md-none" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Apply for Scholarship</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.find-scholarship') }}" class="text-decoration-none">Find Scholarships</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $scholarship->title }}</li>
                </ol>
            </nav>
        </div>

        <!-- Error Alert -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3"></i>
                    <div>
                        <h6 class="alert-heading mb-2">Please correct the following errors:</h6>
                        <ul class="mb-0 ps-0" style="list-style-type: none;">
                            @foreach($errors->all() as $error)
                                <li class="mb-1">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Student Information -->
        <div class="student-info-card">
            <div class="card-header">
                <h5 class="card-title mb-0">Your Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item">
                            <small>Full Name</small>
                            <p>{{ $student->fname }} {{ $student->lname }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <small>Email Address</small>
                            <p>{{ $student->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <small>Course Program</small>
                            <p>{{ $student->course }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <small>Year Level</small>
                            <p>{{ $student->year_level }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <form action="{{ route('scholarships.submit', $scholarship->scholarship_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="scholarship_id" value="{{ $scholarship->scholarship_id }}">
            <input type="hidden" name="student_id" value="{{ session('student_id') }}">

            <!-- Personal Information -->
            <div class="form-section-card">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <span class="section-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-calendar-day"></i> Date of Birth
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <input type="date" name="date_of_birth" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-heart"></i> Civil Status
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-friends"></i>
                                </span>
                                <select name="civil_status" class="form-select" required>
                                    <option value="" selected disabled>Select status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-pray"></i> Religion
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-church"></i>
                                </span>
                                <input type="text" name="religion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Place of Birth
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-globe-asia"></i>
                                </span>
                                <input type="text" name="place_of_birth" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="fas fa-ruler-vertical"></i> Height (cm)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-arrow-up"></i>
                                </span>
                                <input type="number" name="height" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="fas fa-weight"></i> Weight (kg)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-balance-scale"></i>
                                </span>
                                <input type="number" name="weight" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="form-section-card">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <span class="section-icon">
                            <i class="fas fa-home"></i>
                        </span>
                        Address Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-house-user"></i> Home Address
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-pin"></i>
                                </span>
                                <input type="text" name="home_address" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-phone"></i> Contact Number
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                <input type="text" name="contact_address" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">
                                <i class="fas fa-building"></i> Boarding Address
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-marked-alt"></i>
                                </span>
                                <input type="text" name="boarding_address" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-user-tie"></i> Landlord/Landlady
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-check"></i>
                                </span>
                                <input type="text" name="landlord_landlady" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Educational Background -->
            <div class="form-section-card">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <span class="section-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        Educational Background
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-school"></i> High School Graduated
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-university"></i>
                                </span>
                                <input type="text" name="high_school_graduated" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar-check"></i> Year Graduated
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                                <input type="text" name="high_school_year_graduated" class="form-control" required>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-tools"></i> Special Skills
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-star"></i>
                                </span>
                                <input type="text" name="special_skills" class="form-control">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-book"></i> Curriculum Year
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="text" name="curriculum_year" class="form-control" required>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Family Information -->
            <div class="form-section-card">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <span class="section-icon">
                            <i class="fas fa-users"></i>
                        </span>
                        Family Information
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Father's Information -->
                    <div class="family-section">
                        <h6>Father's Information</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">First Name</label>
                                <input type="text" name="father_first_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="father_middle_name" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="father_last_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Occupation</label>
                                <input type="text" name="father_occupation" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monthly Income</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="father_monthly_income" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mother's Information -->
                    <div class="family-section">
                        <h6>Mother's Information</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">First Name</label>
                                <input type="text" name="mother_first_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="mother_middle_name" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="mother_last_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Occupation</label>
                                <input type="text" name="mother_occupation" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monthly Income</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="mother_monthly_income" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Summary -->
                    <div class="family-section">
                        <h6>Family Summary</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Number of Brothers</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-male"></i>
                                    </span>
                                    <input type="number" name="number_of_brothers" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Number of Sisters</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-female"></i>
                                    </span>
                                    <input type="number" name="number_of_sisters" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Monthly Income</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" name="total_monthly_income" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supporting Documents -->
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

            <div class="form-section-card">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <span class="section-icon">
                            <i class="fas fa-file-alt"></i>
                        </span>
                        Supporting Documents
                    </h5>
                </div>
                <div class="card-body">
                    <div class="documents-section">
                        <p>Please upload all required supporting documents below. Accepted formats: .pdf, .jpg, .jpeg, .png, .doc, .docx</p>

                        @if(!empty($requirements))
                            @foreach($requirements as $index => $requirement)
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-file-upload me-2"></i>
                                        {{ $requirement }}
                                    </label>
                                    <div class="file-input-container">
                                        <input type="file" name="documents[{{ $index }}][file]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                    </div>
                                    <input type="hidden" name="documents[{{ $index }}][document_type]" value="{{ $requirement }}">
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No specific documents are required for this scholarship.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="form-section-card">
                <div class="card-header">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <span class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        Additional Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar-plus"></i> Submission Date
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" name="submission_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-sticky-note"></i> Additional Notes (Optional)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Any additional information you would like to share..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="form-buttons">
                <div class="d-flex justify-content-between flex-wrap gap-3">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left me-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Submit Application
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Overlay (for mobile when sidebar active) -->
    <div class="overlay" id="overlay"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        // Toggle sidebar on mobile
        if (toggleBtn && sidebar && overlay) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Close sidebar when clicking on a link (mobile)
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });

            // Initialize mobile sidebar toggle visibility
            if (window.innerWidth < 992) {
                toggleBtn.style.display = 'flex';
            } else {
                toggleBtn.style.display = 'none';
            }
        }

        // Set minimum date for submission date to today
        const submissionDate = document.querySelector('input[name="submission_date"]');
        if (submissionDate) {
            const today = new Date().toISOString().split('T')[0];
            submissionDate.min = today;
            submissionDate.value = today;
        }

        // Set maximum date for date of birth (18 years ago)
        const dateOfBirth = document.querySelector('input[name="date_of_birth"]');
        if (dateOfBirth) {
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() - 18);
            dateOfBirth.max = maxDate.toISOString().split('T')[0];
        }
    });
</script>
@endsection
