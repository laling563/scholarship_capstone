@extends('Student.StudentDashboardLayout')

@section('title', 'Scholarship Details - PSU System')

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

    /* Scholarship Details Card */
    .scholarship-details-card {
        border: none;
        border-radius: 25px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        animation: slideUp 0.6s ease-out 0.2s forwards;
        opacity: 0;
        max-width: 1200px;
        margin: 0 auto;
    }

    .scholarship-details-card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        border: none;
        padding: 2rem 3rem !important;
        border-radius: 25px 25px 0 0 !important;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        border-radius: 50%;
        transform: translate(80px, -80px);
    }

    .card-header h1 {
        font-weight: 800;
        font-size: 2.2rem;
        margin: 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .card-header h1::before {
        content: '🏆';
        font-size: 2rem;
    }

    .card-body {
        padding: 3rem !important;
    }

    /* Scholarship Description & Requirements */
    .details-section {
        margin-bottom: 3rem;
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }

    .details-section:nth-child(1) { animation-delay: 0.3s; }
    .details-section:nth-child(2) { animation-delay: 0.4s; }
    .details-section:nth-child(3) { animation-delay: 0.5s; }

    .section-title {
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
    }

    .section-title::before {
        font-size: 1.3rem;
    }

    .description-title::before {
        content: '📝';
    }

    .requirements-title::before {
        content: '📋';
    }

    .description-content {
        color: #475569;
        font-size: 1.1rem;
        line-height: 1.7;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(255, 255, 255, 0.98) 100%);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(67, 97, 238, 0.1);
    }

    /* Requirements List */
    .requirements-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .requirements-list li {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 1rem 1.5rem;
        margin-bottom: 0.75rem;
        border-radius: 12px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .requirements-list li:hover {
        transform: translateX(10px);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.1);
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.08) 0%, rgba(255, 255, 255, 0.95) 100%);
    }

    .requirements-list li::before {
        content: '✅';
        font-size: 1.1rem;
    }

    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
        padding: 2rem;
        border-radius: 20px;
        border: 1px solid rgba(67, 97, 238, 0.1);
        margin-top: 2rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        text-align: center;
    }

    .stat-item {
        padding: 1.5rem;
        border-radius: 16px;
        background: white;
        border: 1px solid rgba(67, 97, 238, 0.1);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.1);
    }

    .stat-label {
        color: #64748b;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .stat-value {
        color: var(--primary-dark);
        font-weight: 800;
        font-size: 1.8rem;
        margin: 0;
    }

    .start-date .stat-label::before { content: '📅'; }
    .end-date .stat-label::before { content: '⏰'; }
    .slots .stat-label::before { content: '👥'; }

    /* Card Footer */
    .card-footer {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
        border-top: 2px solid rgba(67, 97, 238, 0.1);
        padding: 2rem !important;
        border-radius: 0 0 25px 25px !important;
        text-align: center;
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
        min-width: 180px;
        justify-content: center;
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

    .btn-secondary {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-color: #cbd5e1;
        color: #475569;
    }

    .btn-secondary:hover {
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
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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

        .card-header {
            padding: 1.5rem 2rem !important;
        }

        .card-header h1 {
            font-size: 1.8rem;
        }

        .card-body {
            padding: 2rem !important;
        }
    }

    @media (max-width: 767.98px) {
        .main-content {
            padding: 1.25rem;
        }

        .card-header h1 {
            font-size: 1.6rem;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .btn {
            min-width: 150px;
            padding: 0.75rem 1.5rem;
        }
    }

    @media (max-width: 575.98px) {
        .main-content {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .card-footer {
            padding: 1.5rem !important;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .btn + .btn {
            margin-bottom: 0;
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
        <div class="scholarship-details-card">
            <div class="card-header">
                <h1>{{ $scholarship->title }}</h1>
            </div>

            <div class="card-body">
                <!-- Scholarship Description -->
                <div class="details-section">
                    <h3 class="section-title description-title">Description</h3>
                    <div class="description-content">
                        {{ $scholarship->description }}
                    </div>
                </div>

                <!-- Scholarship Requirements -->
                <div class="details-section">
                    <h3 class="section-title requirements-title">Requirements</h3>
                    <ul class="requirements-list">
                        @if(is_array($scholarship->requirements) && count($scholarship->requirements) > 0)
                            @foreach($scholarship->requirements as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        @else
                            <li>No specific requirements listed for this scholarship.</li>
                        @endif
                    </ul>
                </div>

                <!-- Scholarship Statistics -->
                <div class="stats-section">
                    <div class="stats-grid">
                        <div class="stat-item start-date">
                            <div class="stat-label">Application Start Date</div>
                            <p class="stat-value">{{ $scholarship->start_date->format('M d, Y') }}</p>
                        </div>

                        <div class="stat-item end-date">
                            <div class="stat-label">Application End Date</div>
                            <p class="stat-value">{{ $scholarship->end_date->format('M d, Y') }}</p>
                        </div>

                        <div class="stat-item slots">
                            <div class="stat-label">Available Slots</div>
                            <p class="stat-value">{{ $scholarship->student_limit }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
                <a href="{{ route('scholarships.apply', $scholarship->scholarship_id) }}" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i> Apply Now
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

        // Format requirements if they're in JSON string format
        const requirementsList = document.querySelectorAll('.requirements-list li');
        requirementsList.forEach(item => {
            let text = item.textContent;
            // Check if it's a JSON string and format it
            if (text.includes('[') && text.includes(']')) {
                try {
                    const parsed = JSON.parse(text);
                    if (Array.isArray(parsed)) {
                        // Replace the entire list if this is the only item
                        if (requirementsList.length === 1) {
                            const list = document.querySelector('.requirements-list');
                            list.innerHTML = '';
                            parsed.forEach(req => {
                                const li = document.createElement('li');
                                li.textContent = req;
                                list.appendChild(li);
                            });
                        }
                    }
                } catch (e) {
                    // Not a JSON string, keep as is
                }
            }
        });
    });
</script>
@endsection
