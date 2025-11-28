@extends('Login.LoginLayout')

@section('title', 'Register - PSU System')

@section('content')
<div class="register-wrapper">
    <div class="register-card animate-fade-in">
        <div class="logo-container">
            <img src="{{ asset('images/psulogo.jpg') }}" alt="PSU Logo" class="logo">
        </div>

        <div class="register-header text-center mb-4">
            <h2 class="register-title">🎓 PSU San Carlos Campus</h2>
            <p class="register-subtitle">Create a New Student Account</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('Student.store') }}" class="register-form">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <label for="fname" class="form-label"><i class="bi bi-person-fill"></i> First Name</label>
                    <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" value="{{ old('fname') }}" required>
                    @error('fname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col">
                    <label for="mname" class="form-label"><i class="bi bi-person-fill"></i> Middle Name</label>
                    <input type="text" class="form-control @error('mname') is-invalid @enderror" id="mname" name="mname" value="{{ old('mname') }}">
                    @error('mname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="lname" class="form-label"><i class="bi bi-person-fill"></i> Last Name</label>
                <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" value="{{ old('lname') }}">
                @error('lname') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="student_id" class="form-label"><i class="bi bi-card-text"></i> Student ID</label>
                    <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                    @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col">
                    <label for="sex" class="form-label"><i class="bi bi-gender-ambiguous"></i> Sex</label>
                    <select class="form-select @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                        <option value="">-- Select Sex --</option>
                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('sex') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="course" class="form-label"><i class="bi bi-journal-code"></i> Course</label>
                <select class="form-select @error('course') is-invalid @enderror" id="course" name="course" required>
                    <option value="">-- Select Course --</option>
                    @foreach (['BSIT', 'BSHM', 'BSBA', 'BSED', 'BEED'] as $course)
                        <option value="{{ $course }}" {{ old('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
                @error('course') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="year_level" class="form-label"><i class="bi bi-bar-chart-steps"></i> Year Level</label>
                <select class="form-select @error('year_level') is-invalid @enderror" id="year_level" name="year_level" required>
                    <option value="">-- Select Year Level --</option>
                    @foreach (['1ST YEAR', '2ND YEAR', '3RD YEAR', '4TH YEAR'] as $year)
                        <option value="{{ $year }}" {{ old('year_level') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                @error('year_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- 🔓 Simplified Password Fields -->
            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label"><i class="bi bi-lock-fill"></i> Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    <small class="text-muted"></small>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col">
                    <label for="password_confirmation" class="form-label"><i class="bi bi-lock"></i> Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-person-plus-fill me-2"></i> Register
            </button>

            <div class="text-center">
                Already have an account?
                <a href="{{ route('LoginPage', ['id' => 1]) }}" class="register-cta">
                    Login <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #e0f7ff, #f0f4f8);
    }

    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
    }

    .register-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        padding: 40px 35px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.12);
    }

    .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .logo {
        width: 85px;
        height: auto;
    }

    .register-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1d3557;
    }

    .register-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
        color: #343a40;
    }

    .form-control, .form-select {
        padding: 10px 12px;
        border-radius: 8px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .btn-primary {
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .register-cta {
        color: #0d6efd;
        text-decoration: none;
        margin-left: 5px;
        font-weight: 500;
    }

    .register-cta:hover {
        text-decoration: underline;
    }

    .alert {
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 0.95rem;
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
