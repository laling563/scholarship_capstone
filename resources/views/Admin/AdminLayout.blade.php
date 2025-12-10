<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - PSU Scholarship System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* === GLOBAL STYLES === */
        body {
            background: #f8fafc;
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 260px;
            background-color: #1e3a8a; /* PSU Blue */
            color: #fff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            text-align: center;
        }

        .sidebar-header h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: background 0.3s;
            border-radius: 8px;
            margin: 4px 12px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #3b82f6;
            color: #fff;
        }

        .sidebar a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-footer a {
            color: #f87171;
            text-decoration: none;
            font-weight: 600;
        }

        /* === CONTENT AREA === */
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* === TOGGLE BUTTON (MOBILE) === */
        .toggle-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: #1e3a8a;
            margin-bottom: 10px;
        }

        /* === OVERLAY FOR MOBILE === */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 900;
        }

        /* === RESPONSIVE === */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
                position: fixed;
            }

            .sidebar.active {
                left: 0;
                box-shadow: 2px 0 12px rgba(0, 0, 0, 0.2);
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                display: inline-block;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- === SIDEBAR === -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle bg-light text-primary d-flex align-items-center justify-content-center mb-2" style="width:60px; height:60px;">
                    <i class="fas fa-user fa-lg"></i>
                </div>
                <h4>PSU Scholarship</h4>
                <p class="text-white-50 mb-0">Admin Panel</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ url('/admin/analytics') }}" class="{{ request()->is('admin/analytics') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Analytics
            </a>
            <a href="{{ url('/admin/applications') }}" class="{{ request()->is('admin/applications') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i> Applications
            </a>
            <a href="{{ url('/Scholars') }}" class="{{ request()->is('Scholars') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Scholars
            </a>
            <a href="{{ url('/admin/sponsors') }}" class="{{ request()->is('admin/sponsors*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Sponsor
            </a>
            <a href="{{ route('admin.students.index') }}" class="{{ request()->is('admin/students*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i> Students
            </a>
             <a href="{{ route('admin.student_master_list.create') }}" class="{{ request()->is('admin/student-master-list/create') ? 'active' : '' }}">
                <i class="fas fa-plus"></i> Add Student ID
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>

    <!-- === OVERLAY === -->
    <div class="overlay" id="overlay"></div>

    <!-- === CONTENT === -->
    <div class="content">
        <!-- Mobile Toggle -->
        <button class="toggle-btn" id="toggle-btn"><i class="fas fa-bars"></i></button>

        @if(session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- === JS === -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const toggleBtn = document.getElementById('toggle-btn');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        });

        $(document).ready(function() {
            // Automatically hide the success alert after 3 seconds
            if ($('#success-alert').length) {
                setTimeout(function() {
                    $('#success-alert').fadeOut('slow');
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
