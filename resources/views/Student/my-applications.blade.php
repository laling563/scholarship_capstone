@extends('Student.StudentDashboardLayout')

@section('title', 'My Applications - PSU System')

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

    /* Page Header */
    .page-header {
        margin-bottom: 2.5rem;
        animation: fadeInDown 0.6s ease-out;
    }

    .page-header h2 {
        color: var(--primary-dark);
        font-weight: 800;
        font-size: 2.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(67, 97, 238, 0.1);
    }

    .page-header h2::before {
        content: '📄';
        font-size: 2rem;
    }

    /* Applications Card */
    .applications-card {
        border: none;
        border-radius: 25px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        animation: slideUp 0.6s ease-out 0.2s forwards;
        opacity: 0;
    }

    .applications-card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        padding: 1.5rem 2rem !important;
        border-radius: 25px 25px 0 0 !important;
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
        content: '📋';
        font-size: 1.2rem;
    }

    /* Table Styling */
    .applications-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin: 0;
    }

    .applications-table thead th {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.25rem 1.5rem !important;
        border: none;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .applications-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f3ff;
    }

    .applications-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(136, 149, 239, 0.02) 100%);
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.1);
    }

    .applications-table tbody td {
        padding: 1.5rem 1.5rem !important;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .applications-table tbody td:first-child {
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 1rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.6rem 1.2rem !important;
        border-radius: 20px !important;
        font-weight: 700;
        font-size: 0.85rem;
        border: none;
        min-width: 110px;
        text-align: center;
        display: inline-block;
        letter-spacing: 0.3px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
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

    .bg-info {
        background: linear-gradient(135deg, var(--info) 0%, #0077b6 100%) !important;
        color: white !important;
    }

    /* View Button */
    .view-btn {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: 12px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        color: white !important;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
    }

    .view-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        color: white !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    /* Modal Styling */
    .application-modal {
        border-radius: 25px;
        overflow: hidden;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 1.5rem 2rem;
        color: white;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-title::before {
        content: '📋';
        font-size: 1.3rem;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-section {
        margin-bottom: 2rem;
    }

    .section-title {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
    }

    .section-title::before {
        content: '📌';
        font-size: 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1rem;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 1.5rem;
        border-radius: 15px;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    .info-item {
        margin-bottom: 0.75rem;
    }

    .info-item strong {
        color: var(--primary);
        font-weight: 600;
        display: inline-block;
        min-width: 180px;
    }

    .family-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .family-card {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 1.5rem;
        border-radius: 15px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        transition: all 0.3s ease;
    }

    .family-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.1);
    }

    .family-card h6 {
        color: var(--primary-dark);
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        padding-bottom: 0.5rem;
    }

    /* Documents List */
    .documents-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .document-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-radius: 12px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        transition: all 0.3s ease;
    }

    .document-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.1);
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
    }

    .document-item a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        flex: 1;
    }

    .document-item a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
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

        .applications-table tbody td {
            padding: 1.25rem 1rem !important;
        }
    }

    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.25rem;
        }

        .page-header h2 {
            font-size: 1.8rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .family-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
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
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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
                <a class="nav-link" href="/student/dashboard">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/student/my-applications">
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
        <div class="page-header">
            <h2>My Scholarship Applications</h2>
            <p class="text-muted">Track the status of all your scholarship applications in one place</p>
        </div>

        <div class="applications-card">
            <div class="card-header">
                <h5 class="card-title mb-0">Application History</h5>
            </div>
            <div class="card-body p-0">
                @if($applications->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-file-alt"></i>
                        <p>No applications submitted yet.</p>
                        <a href="{{ route('student.find-scholarship') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> Find Scholarships
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="applications-table">
                            <thead>
                                <tr>
                                    <th>Scholarship</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                <tr>
                                    <td data-label="Scholarship">
                                        <div class="fw-semibold">{{ $application->scholarship->title }}</div>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge
                                            @if(ucfirst($application->status) == 'Approved') bg-success
                                            @elseif(ucfirst($application->status) == 'Pending') bg-warning
                                            @elseif(ucfirst($application->status) == 'Rejected') bg-danger
                                            @elseif(ucfirst($application->status) == 'Endorsed') bg-info
                                            @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Applied Date">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </td>
                                    <td data-label="Actions">
                                        <button type="button"
                                            class="btn view-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#applicationModal"
                                            data-id="{{ $application->id }}"
                                            data-scholarship="{{ $application->scholarship->title }}"
                                            data-status="{{ $application->status }}"
                                            data-applied="{{ $application->created_at->format('F d, Y h:i A') }}"
                                            data-dob="{{ $application->date_of_birth }}"
                                            data-civil="{{ $application->civil_status }}"
                                            data-birthplace="{{ $application->place_of_birth }}"
                                            data-religion="{{ $application->religion }}"
                                            data-height="{{ $application->height }}"
                                            data-weight="{{ $application->weight }}"
                                            data-home="{{ $application->home_address }}"
                                            data-contact="{{ $application->contact_address }}"
                                            data-boarding="{{ $application->boarding_address }}"
                                            data-landlord="{{ $application->landlord_landlady }}"
                                            data-hs="{{ $application->high_school_graduated }}"
                                            data-hsyear="{{ $application->high_school_year_graduated }}"
                                            data-skills="{{ $application->special_skills }}"
                                            data-curriculum="{{ $application->curriculum_year }}"
                                            data-father="{{ $application->father_first_name }} {{ $application->father_middle_name }} {{ $application->father_last_name }}"
                                            data-foccupation="{{ $application->father_occupation }}"
                                            data-fincome="{{ $application->father_monthly_income }}"
                                            data-mother="{{ $application->mother_first_name }} {{ $application->mother_middle_name }} {{ $application->mother_last_name }}"
                                            data-moccupation="{{ $application->mother_occupation }}"
                                            data-mincome="{{ $application->mother_monthly_income }}"
                                            data-brothers="{{ $application->number_of_brothers }}"
                                            data-sisters="{{ $application->number_of_sisters }}"
                                            data-totalincome="{{ $application->total_monthly_income }}"
                                            data-notes="{{ $application->notes }}"
                                            data-documents='@json($application->documents)'>
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Application Details Modal -->
        <div class="modal fade" id="applicationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content application-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">Application Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Application Info -->
                        <div class="modal-section">
                            <h6 class="section-title">Application Information</h6>
                            <div class="info-grid">
                                <div class="info-item"><strong>Application ID:</strong> <span id="appId"></span></div>
                                <div class="info-item"><strong>Scholarship Program:</strong> <span id="appScholarship"></span></div>
                                <div class="info-item"><strong>Status:</strong> <span id="appStatus"></span></div>
                                <div class="info-item"><strong>Applied Date:</strong> <span id="appApplied"></span></div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="modal-section">
                            <h6 class="section-title">Personal Information</h6>
                            <div class="info-grid">
                                <div class="info-item"><strong>Date of Birth:</strong> <span id="appDob"></span></div>
                                <div class="info-item"><strong>Civil Status:</strong> <span id="appCivil"></span></div>
                                <div class="info-item"><strong>Place of Birth:</strong> <span id="appBirthplace"></span></div>
                                <div class="info-item"><strong>Religion:</strong> <span id="appReligion"></span></div>
                                <div class="info-item"><strong>Height:</strong> <span id="appHeight"></span></div>
                                <div class="info-item"><strong>Weight:</strong> <span id="appWeight"></span></div>
                                <div class="info-item"><strong>Home Address:</strong> <span id="appHome"></span></div>
                                <div class="info-item"><strong>Contact Address:</strong> <span id="appContact"></span></div>
                                <div class="info-item"><strong>Boarding Address:</strong> <span id="appBoarding"></span></div>
                                <div class="info-item"><strong>Landlord/Landlady:</strong> <span id="appLandlord"></span></div>
                                <div class="info-item"><strong>High School:</strong> <span id="appHs"></span></div>
                                <div class="info-item"><strong>Year Graduated:</strong> <span id="appHsYear"></span></div>
                                <div class="info-item"><strong>Special Skills:</strong> <span id="appSkills"></span></div>
                                <div class="info-item"><strong>Curriculum Year:</strong> <span id="appCurriculum"></span></div>
                            </div>
                        </div>

                        <!-- Family Background -->
                        <div class="modal-section">
                            <h6 class="section-title">Family Background</h6>
                            <div class="family-grid">
                                <div class="family-card">
                                    <h6>Father's Information</h6>
                                    <div><strong>Name:</strong> <span id="appFather"></span></div>
                                    <div><strong>Occupation:</strong> <span id="appFOccupation"></span></div>
                                    <div><strong>Monthly Income:</strong> ₱<span id="appFIncome"></span></div>
                                </div>
                                <div class="family-card">
                                    <h6>Mother's Information</h6>
                                    <div><strong>Name:</strong> <span id="appMother"></span></div>
                                    <div><strong>Occupation:</strong> <span id="appMOccupation"></span></div>
                                    <div><strong>Monthly Income:</strong> ₱<span id="appMIncome"></span></div>
                                </div>
                            </div>
                            <div class="info-grid">
                                <div class="info-item"><strong>Number of Brothers:</strong> <span id="appBrothers"></span></div>
                                <div class="info-item"><strong>Number of Sisters:</strong> <span id="appSisters"></span></div>
                                <div class="info-item"><strong>Total Monthly Income:</strong> ₱<span id="appTotalIncome"></span></div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="modal-section">
                            <h6 class="section-title">Additional Notes</h6>
                            <div class="p-3 bg-light rounded" id="appNotes"></div>
                        </div>

                        <!-- Documents -->
                        <div class="modal-section">
                            <h6 class="section-title">Submitted Documents</h6>
                            <div class="documents-list" id="appDocuments">
                                <!-- Documents will be inserted here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
                }
            });
        });

        // View Modal Script
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Application Information
                document.getElementById('appId').innerText = button.dataset.id;
                document.getElementById('appScholarship').innerText = button.dataset.scholarship;
                document.getElementById('appStatus').innerText = button.dataset.status;
                document.getElementById('appApplied').innerText = button.dataset.applied;

                // Personal Information
                document.getElementById('appDob').innerText = button.dataset.dob || 'N/A';
                document.getElementById('appCivil').innerText = button.dataset.civil || 'N/A';
                document.getElementById('appBirthplace').innerText = button.dataset.birthplace || 'N/A';
                document.getElementById('appReligion').innerText = button.dataset.religion || 'N/A';
                document.getElementById('appHeight').innerText = button.dataset.height || 'N/A';
                document.getElementById('appWeight').innerText = button.dataset.weight || 'N/A';
                document.getElementById('appHome').innerText = button.dataset.home || 'N/A';
                document.getElementById('appContact').innerText = button.dataset.contact || 'N/A';
                document.getElementById('appBoarding').innerText = button.dataset.boarding || 'N/A';
                document.getElementById('appLandlord').innerText = button.dataset.landlord || 'N/A';
                document.getElementById('appHs').innerText = button.dataset.hs || 'N/A';
                document.getElementById('appHsYear').innerText = button.dataset.hsyear || 'N/A';
                document.getElementById('appSkills').innerText = button.dataset.skills || 'N/A';
                document.getElementById('appCurriculum').innerText = button.dataset.curriculum || 'N/A';

                // Family Information
                document.getElementById('appFather').innerText = button.dataset.father || 'N/A';
                document.getElementById('appFOccupation').innerText = button.dataset.foccupation || 'N/A';
                document.getElementById('appFIncome').innerText = button.dataset.fincome ? parseFloat(button.dataset.fincome).toFixed(2) : '0.00';
                document.getElementById('appMother').innerText = button.dataset.mother || 'N/A';
                document.getElementById('appMOccupation').innerText = button.dataset.moccupation || 'N/A';
                document.getElementById('appMIncome').innerText = button.dataset.mincome ? parseFloat(button.dataset.mincome).toFixed(2) : '0.00';
                document.getElementById('appBrothers').innerText = button.dataset.brothers || '0';
                document.getElementById('appSisters').innerText = button.dataset.sisters || '0';
                document.getElementById('appTotalIncome').innerText = button.dataset.totalincome ? parseFloat(button.dataset.totalincome).toFixed(2) : '0.00';

                // Notes
                const notesElement = document.getElementById('appNotes');
                if (button.dataset.notes && button.dataset.notes.trim() !== '') {
                    notesElement.innerText = button.dataset.notes;
                    notesElement.classList.remove('text-muted');
                } else {
                    notesElement.innerText = 'No additional notes provided.';
                    notesElement.classList.add('text-muted', 'fst-italic');
                }

                // Documents
                let docs = JSON.parse(button.dataset.documents || '[]');
                let docList = document.getElementById('appDocuments');
                docList.innerHTML = '';

                if (docs.length > 0) {
                    docs.forEach(doc => {
                        let docItem = document.createElement('div');
                        docItem.className = "document-item";

                        let a = document.createElement('a');
                        a.href = `/storage/${doc.file_path}`;
                        a.target = "_blank";
                        a.className = "text-decoration-none";
                        a.innerHTML = `<i class="fas fa-file-pdf me-2 text-danger"></i>${doc.original_name || doc.file_name || 'Document'}`;

                        let downloadBtn = document.createElement('a');
                        downloadBtn.href = `/storage/${doc.file_path}`;
                        downloadBtn.download = doc.original_name || doc.file_name || 'document';
                        downloadBtn.className = "btn btn-sm btn-outline-primary";
                        downloadBtn.innerHTML = '<i class="fas fa-download"></i>';

                        docItem.appendChild(a);
                        docItem.appendChild(downloadBtn);
                        docList.appendChild(docItem);
                    });
                } else {
                    let emptyDoc = document.createElement('div');
                    emptyDoc.className = "text-center text-muted py-4";
                    emptyDoc.innerHTML = '<i class="fas fa-folder-open fa-2x mb-2"></i><p>No documents submitted with this application.</p>';
                    docList.appendChild(emptyDoc);
                }
            });
        });
    });
</script>
@endsection
