@extends('Login.LoginLayout')

@section('title', 'Login - PSU System')

@section('content')
<div class="login-wrapper">
    <div class="login-card animate-fade-in">
        <!-- PSU Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/psulogo.jpg') }}" alt="PSU Logo" class="logo">
        </div>

        <div class="login-header">
            <h2 class="login-title">🎓 PSU San Carlos Campus</h2>
            <p class="login-subtitle">Scholarship Application Management System</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="login" class="form-label">
                    <i class="bi bi-person-fill"></i> Student ID
                </label>
                <div class="input-group">
                    <!-- <span class="input-group-text"><i class="bi bi-person"></i></span> -->
                    <input type="text" class="form-control @error('login') is-invalid @enderror"
                        id="login" name="login" value="{{ old('login') }}"
                        placeholder="Enter your ID or email" required autofocus>
                </div>
                @error('login')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="bi bi-lock-fill"></i> Password
                </label>
                <div class="input-group">
                    <!-- <span class="input-group-text"><i class="bi bi-lock"></i></span> -->
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" name="password" placeholder="Enter your password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary login-btn w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>

            <div class="divider"><span>or</span></div>

            <div class="register-link text-center">
                Don't have an account?
                <a href="{{ route('RegistrationPage') }}" class="register-cta">
                    Sign up <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('admin.login') }}" class="sponsor-login-link">
                    Login as Admin
                </a>
                <span class="mx-2">|</span>
                <a href="{{ route('sponsor.login') }}" class="sponsor-login-link">
                    Login as Sponsor
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #e0f2fe, #f0f4f8);
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 20px;
    }

    .login-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.1);
        max-width: 480px;
        width: 100%;
        padding: 40px 35px;
        transition: all 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 55px rgba(0, 0, 0, 0.12);
    }

    .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 90px;
        height: auto;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-title {
        font-size: 1.7rem;
        font-weight: 700;
        color: #1d3557;
    }

    .login-subtitle {
        font-size: 1rem;
        color: #6c757d;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 5px;
        display: block;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: 0;
    }

    .form-control {
        border-left: 0;
        padding: 12px 14px;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .toggle-password {
        border-left: 0;
        background: transparent;
        border: none;
    }

    .login-btn {
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        background-color: #0d6efd;
        border-color: #0d6efd;
        transition: background-color 0.2s ease-in-out;
    }

    .login-btn:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 30px 0;
        color: #adb5bd;
    }

    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #dee2e6;
    }

    .divider::before {
        margin-right: 10px;
    }

    .divider::after {
        margin-left: 10px;
    }

    .register-link {
        font-size: 0.95rem;
        color: #495057;
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

    .forgot-password {
        font-size: 0.9rem;
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s;
    }

    .forgot-password:hover {
        color: #0d6efd;
    }

    .sponsor-login-link {
        font-size: 0.95rem;
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s;
    }

    .sponsor-login-link:hover {
        color: #0d6efd;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 30px 20px;
        }

        .logo {
            width: 70px;
        }

        .login-title {
            font-size: 1.4rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('.toggle-password');
        const password = document.querySelector('#password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    });
</script>
@endsection
