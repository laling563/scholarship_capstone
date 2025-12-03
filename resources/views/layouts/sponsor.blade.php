<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sponsor Dashboard - PSU Scholarship System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sponsor-primary: #2c3e50;
            --sponsor-secondary: #34495e;
            --sponsor-accent: #3498db;
            --sponsor-light: #ecf0f1;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        .sponsor-sidebar {
            background: var(--sponsor-primary);
            color: white;
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            transition: all 0.3s;
            position: relative; /* Needed for footer positioning */
            z-index: 1100;
        }

        .sponsor-sidebar .sidebar-header {
            padding: 20px;
            background: var(--sponsor-secondary);
        }

        .sponsor-sidebar ul.components {
            padding: 0;
        }

        .sponsor-sidebar ul li a {
            padding: 12px 20px;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .sponsor-sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.05);
            border-left: 4px solid var(--sponsor-accent);
        }
        .sponsor-sidebar ul li a.active {
            background: rgba(52, 152, 219, 0.2);
            border-left: 4px solid var(--sponsor-accent);
            font-weight: 600;
        }

        .sponsor-sidebar ul li a i {
            margin-right: 12px;
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

        #content {
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s;
            padding: 15px;
        }

        .sidebar-toggle-btn {
            display: none; /* Hidden by default on desktop */
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
        }

        @media (max-width: 768px) {
            .sponsor-sidebar {
                position: fixed; /* Fix sidebar to the left */
                top: 0;
                left: -250px; /* Initially hidden */
                height: 100vh;
            }
            .sponsor-sidebar.active {
                left: 0;
            }
            #content {
                padding: 15px;
            }
            .sidebar-toggle-btn {
                display: block; /* Show the button */
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1200;
                background: var(--sponsor-primary);
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 5px;
            }
            .overlay.active {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sponsor-sidebar">
            <div class="sidebar-header text-center">
                <h4 class="mb-0">PSU Scholarship</h4>
                <p class="text-light mb-0"><small>Sponsor Panel</small></p>
            </div>

            <div class="px-3 py-3 d-flex align-items-center border-top border-bottom border-secondary border-opacity-25">
                <img src="/images/sponsor.jpg" class="rounded-circle me-2" alt="Sponsor"
                    style="width: 40px; height: 40px; object-fit: cover;">
                <div>
                    <h6 class="mb-0">{{ Auth::guard('sponsor')->user()->name }}</h6>
                </div>
            </div>

            <ul class="list-unstyled components mt-2">
                <li><a href="{{ route('sponsor.dashboard') }}" class="{{ request()->routeIs('sponsor.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a href="{{ route('sponsor.scholarships.index') }}" class="{{ request()->routeIs('sponsor.scholarships.*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i>Scholarships</a></li>
                <li><a href="{{ route('sponsor.applications') }}" class="{{ request()->routeIs('sponsor.applications') || request()->routeIs('sponsor.applications.view') ? 'active' : '' }}"><i class="fas fa-file-alt"></i>Applications</a></li>
                <li><a href="{{ route('sponsor.analytics') }}" class="{{ request()->routeIs('sponsor.analytics') ? 'active' : '' }}"><i class="fas fa-chart-line"></i>Analytics</a></li>
            </ul>

            <div class="sidebar-footer text-center">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger" title="Logout"><i class="fas fa-sign-out-alt fa-lg"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Toggle button for mobile -->
            <button class="sidebar-toggle-btn d-md-none"><i class="fas fa-bars"></i></button>

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
    </div>
    <!-- Overlay element -->
    <div class="overlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toggle sidebar
            $('.sidebar-toggle-btn').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('.overlay').toggleClass('active');
            });

            // Close sidebar when overlay is clicked
            $('.overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            // Auto-hide success alert
            if ($('#success-alert').length) {
                setTimeout(function() {
                    $('#success-alert').fadeOut('slow');
                }, 3000);
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
