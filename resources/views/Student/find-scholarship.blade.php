@extends('Student.StudentDashboardLayout')

@section('title', 'Find Scholarships - PSU System')

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
        content: '🔍';
        font-size: 2rem;
    }

    .page-header p {
        color: #64748b;
        font-size: 1.1rem;
        max-width: 600px;
    }

    /* Scholarships Card */
    .scholarships-card {
        border: none;
        border-radius: 25px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        animation: slideUp 0.6s ease-out 0.2s forwards;
        opacity: 0;
    }

    .scholarships-card:hover {
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
        content: '🏆';
        font-size: 1.2rem;
    }

    /* Scholarship Items */
    .scholarship-item {
        padding: 2rem;
        border-bottom: 2px solid rgba(67, 97, 238, 0.05);
        transition: all 0.3s ease;
        background: white;
    }

    .scholarship-item:last-child {
        border-bottom: none;
    }

    .scholarship-item:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(255, 255, 255, 0.98) 100%);
        transform: translateX(10px);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.08);
        border-radius: 12px;
        margin: 0 0.5rem;
    }

    .scholarship-title {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .scholarship-title::before {
        content: '🎓';
        font-size: 1.1rem;
    }

    .scholarship-description {
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        padding-left: 1.75rem;
    }

    .scholarship-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        padding-left: 1.75rem;
    }

    .deadline-badge {
        background: linear-gradient(135deg, rgba(231, 57, 70, 0.1) 0%, rgba(231, 57, 70, 0.05) 100%);
        color: var(--danger);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid rgba(231, 57, 70, 0.2);
    }

    .deadline-badge i {
        font-size: 0.9rem;
    }

    .applicants-badge {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.05) 100%);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid rgba(67, 97, 238, 0.2);
    }

    /* Action Buttons */
    .action-btn {
        border-radius: 10px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid transparent;
        min-width: 140px;
        justify-content: center;
    }

    .btn-outline-primary {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.05) 100%);
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .btn-info {
        background: linear-gradient(135deg, #4cc9f0 0%, #0077b6 100%);
        border: none;
        color: white;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 201, 240, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        border: none;
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #e63946 0%, #a4161a 100%);
        border: none;
        color: white;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(230, 57, 70, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h4 {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #475569;
    }

    .empty-state p {
        font-size: 1.05rem;
        margin-bottom: 1.5rem;
    }

    /* Card Footer */
    .card-footer {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-top: 2px solid rgba(67, 97, 238, 0.1);
        padding: 1.25rem 2rem;
        border-radius: 0 0 25px 25px !important;
        text-align: center;
    }

    .card-footer a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 8px;
    }

    .card-footer a:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.05) 100%);
        transform: translateY(-2px);
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

        .scholarship-item {
            padding: 1.5rem;
        }

        .scholarship-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.25rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .scholarship-title {
            font-size: 1.1rem;
        }

        .scholarship-description {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 575.98px) {
        .main-content {
            padding: 1rem;
        }

        .scholarship-item {
            padding: 1.25rem;
        }

        .action-btn {
            min-width: 120px;
            padding: 0.5rem 1rem;
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
        <div class="page-header">
            <h1>Find Scholarships</h1>
            <p>Browse and apply for available scholarship opportunities. Don't miss your chance to fund your education!</p>
        </div>

        <div class="scholarships-card">
            <div class="card-header">
                <h5 class="card-title mb-0">Available Scholarship Programs</h5>
            </div>

            @if($scholarships->count())
                <div class="list-group list-group-flush">
                    @foreach($scholarships as $scholarship)
                        @php
                            $applicantCount = \App\Models\ApplicationForm::where('scholarship_id', $scholarship->scholarship_id)->count();
                            $isApplied = $appliedScholarshipIds->contains($scholarship->scholarship_id);
                            $isFull = $applicantCount >= $scholarship->student_limit;
                            $deadline = \Carbon\Carbon::parse($scholarship->end_date);
                            $isExpired = $deadline->isPast();
                        @endphp

                        <div class="scholarship-item">
                            <h5 class="scholarship-title">{{ $scholarship->title }}</h5>
                            <p class="scholarship-description">{{ $scholarship->description }}</p>

                            <div class="scholarship-info">
                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                    <span class="deadline-badge">
                                        <i class="fas fa-calendar-times"></i>
                                        Deadline: {{ $deadline->format('F d, Y') }}
                                    </span>

                                    <span class="applicants-badge">
                                        <i class="fas fa-users"></i>
                                        {{ $applicantCount }} / {{ $scholarship->student_limit }} Applicants
                                    </span>
                                </div>

                                <div>
                                    @if($hasApprovedScholarship)
                                        <button class="btn btn-info action-btn" disabled>
                                            <i class="fas fa-info-circle me-1"></i> Application Restricted
                                        </button>
                                    @elseif($isApplied)
                                        <button class="btn btn-secondary action-btn" disabled>
                                            <i class="fas fa-check-circle me-1"></i> Applied
                                        </button>
                                    @elseif($isFull)
                                        <button class="btn btn-danger action-btn" disabled>
                                            <i class="fas fa-times-circle me-1"></i> Full
                                        </button>
                                    @elseif($isExpired)
                                        <button class="btn btn-danger action-btn" disabled>
                                            <i class="fas fa-clock me-1"></i> Expired
                                        </button>
                                    @else
                                        <a href="{{ route('scholarships.apply', $scholarship->scholarship_id) }}"
                                           class="btn btn-outline-primary action-btn">
                                            <i class="fas fa-file-signature me-1"></i> Apply Now
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-trophy"></i>
                    <h4>No Scholarships Available</h4>
                    <p>There are currently no scholarship opportunities available. Please check back later.</p>
                    <a href="/student/dashboard" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i> Return to Dashboard
                    </a>
                </div>
            @endif

            <div class="card-footer">
                <a href="#" class="text-decoration-none">
                    <i class="fas fa-eye me-1"></i> View All Scholarship Programs
                </a>
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
