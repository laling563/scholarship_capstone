<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sponsor Dashboard - PSU Scholarship System')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sponsor-primary: #2c3e50;
            --sponsor-secondary: #34495e;
            --sponsor-accent: #3498db;
            --sponsor-light: #ecf0f1;
            --sponsor-danger: #e74c3c;
            --sponsor-success: #2ecc71;
            --sponsor-warning: #f39c12;
            --sponsor-info: #3498db;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar */
        .sponsor-sidebar {
            background: var(--sponsor-primary);
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sponsor-sidebar .sidebar-header {
            padding: 20px;
            background: var(--sponsor-secondary);
        }

        .sponsor-sidebar ul.components {
            padding: 0;
            border-bottom: 1px solid #47748b;
        }

        .sponsor-sidebar ul li a {
            padding: 12px 20px;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sponsor-sidebar ul li a:hover,
        .sponsor-sidebar ul li a.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--sponsor-accent);
        }

        .sponsor-sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sponsor-sidebar .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 15px;
            background: var(--sponsor-secondary);
        }

        /* Page content */
        .sponsor-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .sponsor-sidebar {
                margin-left: -250px;
            }

            .sponsor-sidebar.active {
                margin-left: 0;
            }

            .sponsor-content {
                margin-left: 0;
            }

            .sidebar-toggle-btn {
                display: inline-block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1100;
                background: var(--sponsor-primary);
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 5px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar toggle button for mobile -->
    <button class="sidebar-toggle-btn d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        <nav id="sidebar" class="sponsor-sidebar">
            <div class="sidebar-header">
                <h4 class="mb-0">PSU Scholarship</h4>
                <p class="text-light mb-0"><small>Sponsor Panel</small></p>
            </div>

            <div class="px-3 py-2 d-flex align-items-center">
                <img src="/images/sponsor.jpg" class="rounded-circle me-2" alt="Sponsor"
                    style="width: 40px; height: 40px; object-fit: cover;">
                <div>
                    <h6 class="mb-0">{{ Auth::guard('sponsor')->user()->name }}</h6>
                </div>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('sponsor.dashboard') }}"
                        class="{{ request()->routeIs('sponsor.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('sponsor.scholarships.index') }}"
                        class="{{ request()->routeIs('sponsor.scholarships.index') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i> Scholarships
                    </a>
                </li>
                <li>
                    <a href="{{ route('sponsor.applications') }}"
                        class="{{ request()->routeIs('sponsor.applications') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Applications
                    </a>
                </li>
                <li>
                    <a href="{{ route('sponsor.analytics') }}"
                        class="{{ request()->routeIs('sponsor.analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Analytics
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer text-center">
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-danger" title="Logout">
                    <i class="fas fa-sign-out-alt fa-lg"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content" class="sponsor-content">
            <div class="container-fluid py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.sidebar-toggle-btn').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
