@extends('Student.StudentDashboardLayout')

@section('title', 'Find Scholarships - PSU System')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-dark text-white sidebar" id="sidebar">
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

    <!-- Main Content -->
    <div class="container-fluid py-4 main-content">
        <!-- Mobile Sidebar Toggle -->
        <button id="sidebarToggle" class="btn btn-primary d-md-none mb-3">
            <i class="fas fa-bars"></i>
        </button>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Available Scholarships</h5>
            </div>
            <div class="card-body p-0">
                @if($scholarships->count())
                    <ul class="list-group list-group-flush">
                        @foreach($scholarships as $scholarship)
                            @php
                                $applicantCount = \App\Models\ApplicationForm::where('scholarship_id', $scholarship->scholarship_id)->count();
                                $isApplied = $appliedScholarshipIds->contains($scholarship->scholarship_id);
                                $isFull = $applicantCount >= $scholarship->student_limit;
                            @endphp
                            <li class="list-group-item">
                                <h6 class="mb-1">{{ $scholarship->title }}</h6>
                                <p class="mb-1 small">{{ $scholarship->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-danger">Deadline:
                                        {{ \Carbon\Carbon::parse($scholarship->end_date)->format('M d, Y') }}
                                    </small>

                                    @if($isApplied)
                                        <button class="btn btn-sm btn-secondary" disabled>Already Applied</button>
                                    @elseif($isFull)
                                        <button class="btn btn-sm btn-danger" disabled>Slots Full</button>
                                    @else
                                        <a href="{{ route('scholarships.apply', $scholarship->scholarship_id) }}"
                                           class="btn btn-sm btn-outline-primary">Apply</a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-3">
                        <p class="mb-0">No scholarships available at the moment.</p>
                    </div>
                @endif
            </div>
            <div class="card-footer text-center">
                <a href="#" class="text-decoration-none">View All Scholarships</a>
            </div>
        </div>
    </div>
</div>

<!-- CSS -->
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
</style>

<!-- Overlay (for mobile when sidebar active) -->
<div class="overlay" id="overlay"></div>

<!-- Script -->
<script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
</script>

@endsection
