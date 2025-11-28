@extends('Student.StudentDashboardLayout')

@section('title', 'Scholarship Dashboard - PSU System')

@section('content')
<div class="d-flex flex-column flex-md-row">

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
                <a class="nav-link text-white active bg-primary bg-opacity-75 rounded" href="/student/dashboard">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/student/my-applications">
                    <i class="fas fa-scroll me-2"></i> My Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/student/find-scholarship">
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
        <div class="row mb-4">
            <div class="col-md-4 col-12 mb-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-scroll fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Applications</h5>
                        <p class="card-text">1 Active</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <h5 class="card-title">Approved</h5>
                        <p class="card-text">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <i class="fas fa-hourglass-half fa-3x mb-3 text-warning"></i>
                        <h5 class="card-title">Pending</h5>
                        <p class="card-text">1</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scholarship Applications Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">My Scholarship Applications</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Scholarship Name</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td>{{ $app->scholarship->title }}</td>
                                <td>{{ $app->created_at->format('F d, Y') }}</td>
                                <td>
                                    @if($app->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($app->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($app->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No applications found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

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
