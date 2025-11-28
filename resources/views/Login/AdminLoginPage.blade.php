@extends('Login.LoginLayout')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="col-12 col-md-8 col-lg-4">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-5">

                <!-- Header -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/psulogo.jpg') }}" alt="PSU Logo" class="mb-3" width="80">
                    <h3 class="fw-bold text-primary">Admin Login</h3>
                    <p class="text-muted small"></p>
                </div>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error:</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('admin.login') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Faculty ID -->
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label fw-semibold">Faculty ID</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bi bi-person-badge"></i>
                            </span>
                            <input type="text" class="form-control" id="faculty_id" name="faculty_id" placeholder="Enter your Faculty ID" required>
                        </div>
                        <div class="invalid-feedback">Faculty ID is required.</div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                        </div>
                        <div class="invalid-feedback">Password is required.</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">© {{ date('Y') }} Pangasinan State University | Scholarship System</p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
