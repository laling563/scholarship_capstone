@extends('Student.StudentDashboardLayout')

@section('title', 'Scholarship Dashboard - PSU System')

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

        .main-content {
        margin-left: 300px;
        padding: 2.5rem 3rem;
        min-height: 100vh;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        width: calc(100% - 300px); /* Add this line */
    }

    /* Scholarships Card - Fixed */
    .scholarships-card {
        border: none;
        border-radius: 25px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        animation: slideUp 0.6s ease-out 0.2s forwards;
        opacity: 0;
        width: 100%; /* Add this line */
        max-width: none; /* Ensure no max-width restriction */
    }

    /* Responsive fixes */
    @media (max-width: 1199.98px) {
        .sidebar {
            width: 280px;
        }

        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px); /* Add this line */
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
            width: 100% !important; /* Add this line */
            padding: 1.5rem;
        }

        #sidebarToggle {
            display: flex;
        }

        .scholarship-item {
            padding: 1.5rem;
        }

        .scholarship-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }

    /* Add this new rule to ensure container uses full width */
    .d-flex {
        width: 100%;
        overflow-x: hidden; /* Prevent horizontal scroll */
    }

    /* Ensure the card content stretches properly */
    .card-header, .scholarship-item, .card-footer {
        padding-left: 2.5rem;
        padding-right: 2.5rem;
    }

    /* Adjust the scholarship info to use available space better */
    .scholarship-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding-left: 1.75rem;
        width: 100%; /* Add this line */
    }

    /* Make the scholarship title and description use full width */
    .scholarship-title, .scholarship-description {
        width: 100%;
    }

    /* Adjust buttons on smaller screens */
    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.25rem;
        }

        .card-header, .scholarship-item, .card-footer {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .scholarship-info > div {
            width: 100%;
        }

        .action-btn {
            width: 100%;
            margin-top: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .main-content {
            padding: 1rem;
        }

        .card-header, .scholarship-item, .card-footer {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }
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

    /* Statistics Cards */
    .stats-card {
        border: none;
        border-radius: 20px !important;
        background: white;
        box-shadow: var(--card-shadow);
        transition: all 0.4s ease;
        overflow: hidden;
        height: 100%;
        position: relative;
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--hover-shadow);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
    }

    .stats-card-body {
        padding: 2rem !important;
        text-align: center;
    }

    .stats-icon {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        display: block;
    }

    .stats-icon-applications {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stats-icon-approved {
        background: linear-gradient(135deg, var(--success) 0%, #2d7d46 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stats-icon-pending {
        background: linear-gradient(135deg, var(--warning) 0%, #d35400 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0.5rem 0;
        text-shadow: 0 4px 8px rgba(67, 97, 238, 0.1);
    }

    .stats-number.approved {
        color: var(--success);
    }

    .stats-number.pending {
        color: var(--warning);
    }

    .stats-title {
        color: #64748b;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    /* Announcements Card */
    .announcements-card {
        border: none;
        border-radius: 20px !important;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        animation: fadeInUp 0.6s ease-out 0.3s forwards;
        opacity: 0;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .announcements-header {
        background: linear-gradient(135deg, var(--info) 0%, #0077b6 100%) !important;
        border: none !important;
        padding: 1.25rem 1.5rem !important;
    }

    .announcements-header h5 {
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .announcements-header h5::before {
        content: '📢';
        font-size: 1.1rem;
    }

    .announcement-item {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        border: none;
        border-left: 4px solid var(--info);
        border-radius: 12px !important;
        padding: 1.5rem !important;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .announcement-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.1);
    }

    .announcement-title {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .announcement-title::before {
        content: '🏆';
        font-size: 1rem;
    }

    .announcement-text {
        color: #475569;
        font-size: 0.95rem;
        margin: 0;
        line-height: 1.5;
    }

    .announcement-btn {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        color: white !important;
        text-decoration: none;
        display: inline-block;
    }

    .announcement-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    /* Applications Table Card */
    .applications-card {
        border: none;
        border-radius: 20px !important;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        animation: fadeInUp 0.6s ease-out 0.4s forwards;
        opacity: 0;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .applications-header {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
        border: none !important;
        padding: 1.25rem 1.5rem !important;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
    }

    .applications-header h5 {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .applications-header h5::before {
        content: '📋';
        font-size: 1.1rem;
    }

    .applications-table {
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
        width: 100%;
    }

    .applications-table thead th {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem !important;
        border: none;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .applications-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f3ff;
    }

    .applications-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(136, 149, 239, 0.02) 100%);
        transform: translateX(5px);
    }

    .applications-table tbody td {
        padding: 1.25rem 1.5rem !important;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
    }

    .applications-table tbody td:first-child {
        font-weight: 600;
        color: var(--primary-dark);
    }

    .status-badge {
        padding: 0.5rem 1rem !important;
        border-radius: 20px !important;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        min-width: 100px;
        text-align: center;
        display: inline-block;
    }

    .bg-success {
        background: linear-gradient(135deg, var(--success) 0%, #2d7d46 100%) !important;
        color: white !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, var(--warning) 0%, #d35400 100%) !important;
        color: white !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #a4161a 100%) !important;
        color: white !important;
    }

    .bg-secondary {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;
        color: white !important;
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
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
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

    /* Delay animations */
    .stats-card:nth-child(1) { animation-delay: 0.1s; }
    .stats-card:nth-child(2) { animation-delay: 0.2s; }
    .stats-card:nth-child(3) { animation-delay: 0.3s; }

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

        .stats-card-body {
            padding: 1.5rem !important;
        }

        .stats-number {
            font-size: 2rem;
        }

        .stats-icon {
            font-size: 2.5rem;
        }

        .announcement-item {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .announcement-btn {
            align-self: stretch;
            text-align: center;
        }

        .applications-table tbody td {
            padding: 1rem !important;
        }
    }

    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .applications-table {
            display: block;
            overflow-x: auto;
        }

        .applications-table thead {
            display: none;
        }

        .applications-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #f0f3ff;
            border-radius: 12px;
            padding: 1rem;
        }

        .applications-table tbody td {
            display: block;
            text-align: left;
            padding: 0.75rem 0 !important;
            border-bottom: 1px solid #f0f3ff;
        }

        .applications-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 0.25rem;
        }

        .applications-table tbody td:last-child {
            border-bottom: none;
            padding-top: 1rem !important;
        }

        .status-badge {
            display: inline-block;
            margin-top: 0.25rem;
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
                <a class="nav-link active" href="/student/dashboard">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/student/my-applications">
                    <i class="fas fa-scroll me-2"></i> My Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/student/find-scholarship">
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
        <div class="row mb-4">
            <div class="col-md-4 col-12 mb-3">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <i class="fas fa-scroll stats-icon stats-icon-applications"></i>
                        <h5 class="stats-title">Total Applications</h5>
                        <p class="stats-number">{{ $totalApplications ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-3">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <i class="fas fa-check-circle stats-icon stats-icon-approved"></i>
                        <h5 class="stats-title">Approved</h5>
                        <p class="stats-number approved">{{ $approvedApplications ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-3">
                <div class="stats-card">
                    <div class="stats-card-body">
                        <i class="fas fa-hourglass-half stats-icon stats-icon-pending"></i>
                        <h5 class="stats-title">Pending Review</h5>
                        <p class="stats-number pending">{{ $pendingApplications ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="announcements-card">
            <div class="card-header announcements-header">
                <h5 class="card-title mb-0">Announcements</h5>
            </div>
            <div class="card-body">
                @forelse($newScholarships as $scholarship)
                    <div class="announcement-item">
                        <div>
                            <h6 class="announcement-title">{{ $scholarship->title }}</h6>
                            <p class="announcement-text">A new scholarship is available! Don't miss the chance to apply.</p>
                        </div>
                        <a href="{{ route('student.scholarship.show', $scholarship) }}" class="announcement-btn">
                            View Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-bell fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No new announcements at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Scholarship Applications Table -->
        <div class="applications-card">
            <div class="card-header applications-header">
                <h5 class="card-title mb-0">My Scholarship Applications</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="applications-table">
                        <thead>
                            <tr>
                                <th>Scholarship Name</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications ?? [] as $app)
                                <tr>
                                    <td data-label="Scholarship Name">{{ $app->scholarship->title }}</td>
                                    <td data-label="Applied Date">{{ $app->created_at->format('F d, Y') }}</td>
                                    <td data-label="Status">
                                        @if($app->status === 'approved')
                                            <span class="status-badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i> Approved
                                            </span>
                                        @elseif($app->status === 'pending')
                                            <span class="status-badge bg-warning">
                                                <i class="fas fa-clock me-1"></i> Pending
                                            </span>
                                        @elseif($app->status === 'rejected')
                                            <span class="status-badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i> Rejected
                                            </span>
                                        @else
                                            <span class="status-badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No applications found. Start applying for scholarships!</p>
                                        <a href="{{ route('student.find-scholarship') }}" class="btn btn-primary">
                                            <i class="fas fa-search me-2"></i> Find Scholarships
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Close sidebar when clicking overlay
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
                }s
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
    });
</script>
@endsection
