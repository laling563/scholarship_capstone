@extends('Login.LoginLayout')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100"
     style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
    <div class="col-11 col-md-8 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Header -->
            <div class="card-header bg-primary text-white text-center py-4">
                <h2 class="fw-bold mb-0">Sponsor Login</h2>
                <p class="mb-0 small text-light opacity-75"></p>
            </div>

            <!-- Body -->
            <div class="card-body p-4 bg-white">
                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <strong>Error:</strong> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('sponsor.login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-envelope-fill text-primary"></i>
                            </span>
                            <input type="email" class="form-control border-start-0" id="email" name="email"
                                placeholder="Sponsor ID" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-secondary">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock-fill text-primary"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" id="password" name="password"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="card-footer text-center bg-light py-3">
                <small class="text-muted">
                    © {{ date('Y') }} PSU Scholarship System. All rights reserved.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
