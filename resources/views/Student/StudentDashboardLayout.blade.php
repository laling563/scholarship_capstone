<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PSU Student System')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .nav-link.active {
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 5px;
        }
        .badge-notification {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
            font-size: 0.75rem;
        }
        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                height: auto;
                position: relative;
            }
        }
    </style>
    @yield('styles')
</head>
<body>


    <!-- Main Content -->
    <main class="py-4">


        @if(session('success'))
            <div class="d-flex">
                <div class="container-fluid" style="margin-left: 250px;">
                    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="d-flex">
                <div class="container-fluid" style="margin-left: 250px;">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <!-- <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>PSU Student Portal</h5>
                    <p>Your gateway to academic excellence and campus resources.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Academic Calendar</a></li>
                        <li><a href="#" class="text-white">Library</a></li>
                        <li><a href="#" class="text-white">Student Handbook</a></li>
                        <li><a href="#" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Connect With Us</h5>
                    <div class="d-flex gap-3 fs-4">
                        <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; 2024 PSU Student Portal. All rights reserved.</p>
            </div>
        </div>
    </footer> -->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
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
