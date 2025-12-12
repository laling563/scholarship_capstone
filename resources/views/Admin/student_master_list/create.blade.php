@extends('Admin.AdminLayout')

@section('title', 'Add Student ID')

@section('styles')
<style>
    /* === ADD STUDENT ID PAGE STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --secondary: #7209b7;
        --success: #4cc9f0;
        --warning: #f72585;
        --danger: #e63946;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === PAGE LAYOUT === */
    .container-fluid {
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* === MAIN CARD === */
    .card.shadow-sm {
        border: none;
        border-radius: 24px;
        box-shadow: var(--card-shadow) !important;
        background: white;
        overflow: hidden;
        border: 1px solid #f0f3ff;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .card.shadow-sm:hover {
        box-shadow: var(--hover-shadow) !important;
    }

    /* === CARD HEADER === */
    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        padding: 2rem 2.5rem;
        border-radius: 24px 24px 0 0 !important;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.2;
        animation: float 20s linear infinite;
    }

    .card-header h5 {
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .card-header h5::before {
        content: '🎓';
        font-size: 1.3rem;
    }

    /* === CARD BODY === */
    .card-body {
        padding: 2.5rem;
        background: white;
    }

    /* === SUCCESS ALERT === */
    .alert-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(76, 201, 240, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        animation: slideIn 0.5s ease;
    }

    .alert-success::before {
        content: '✅';
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .alert-success .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    .alert-success .btn-close:hover {
        opacity: 1;
    }

    /* === FORM STYLES === */
    form {
        animation: fadeIn 0.6s ease 0.2s both;
    }

    /* === FORM GROUP === */
    .mb-4 {
        margin-bottom: 2rem !important;
    }

    /* === FORM LABEL === */
    .form-label.fw-bold {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label.fw-bold::before {
        content: '🆔';
        font-size: 1.1rem;
    }

    /* === FORM INPUT === */
    .form-control {
        border: 2px solid #e8edff;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
        background: #f8f9ff;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.02);
    }

    .form-control:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    /* === VALIDATION STATES === */
    .form-control.is-valid {
        border-color: var(--success);
        background: rgba(76, 201, 240, 0.05);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
        background: rgba(230, 57, 70, 0.05);
    }

    .invalid-feedback {
        color: var(--danger);
        font-weight: 500;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .invalid-feedback::before {
        content: '⚠️';
        font-size: 0.9rem;
    }

    /* === FORM HELP TEXT === */
    .form-text {
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-text::before {
        content: '💡';
        font-size: 0.9rem;
        opacity: 0.7;
    }

    /* === SUBMIT BUTTON === */
    .d-grid {
        margin-top: 3rem;
    }

    .btn.btn-primary.btn-lg {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white !important;
        border: none !important;
        border-radius: 14px !important;
        padding: 1.25rem 2rem !important;
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.25) !important;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .btn.btn-primary.btn-lg:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(67, 97, 238, 0.35) !important;
    }

    .btn.btn-primary.btn-lg:active {
        transform: translateY(-1px);
    }

    .btn.btn-primary.btn-lg::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn.btn-primary.btn-lg:hover::before {
        left: 100%;
    }

    .btn.btn-primary.btn-lg::after {
        content: '➕';
        font-size: 1.2rem;
    }

    /* === ANIMATIONS === */
    @keyframes float {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }
        100% {
            transform: translate(0, 0) rotate(360deg);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1.5rem 1rem;
        }

        .card-header {
            padding: 1.5rem;
        }

        .card-header h5 {
            font-size: 1.3rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .alert-success {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-success .btn-close {
            align-self: flex-end;
            margin-top: -0.5rem;
        }

        .form-control {
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
        }

        .btn.btn-primary.btn-lg {
            padding: 1rem 1.5rem !important;
            font-size: 1rem !important;
        }

        .form-label.fw-bold {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .container-fluid {
            padding: 1rem 0.75rem;
        }

        .card-header {
            padding: 1.25rem;
            text-align: center;
        }

        .card-header h5 {
            justify-content: center;
        }

        .card-body {
            padding: 1.25rem;
        }

        .btn.btn-primary.btn-lg {
            width: 100%;
            padding: 1rem !important;
        }
    }

    /* === LOADING STATE === */
    .btn.btn-primary.btn-lg.loading {
        position: relative;
        color: transparent !important;
    }

    .btn.btn-primary.btn-lg.loading::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* === SUCCESS ANIMATION === */
    @keyframes successPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .alert-success {
        animation: successPulse 2s ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Student ID to Master List</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.student_master_list.store') }}" method="POST" id="studentIdForm">
                @csrf

                <div class="mb-4">
                    <label for="student_id" class="form-label fw-bold">Student ID</label>
                    <input type="text"
                           class="form-control @error('student_id') is-invalid @enderror"
                           id="student_id"
                           name="student_id"
                           value="{{ old('student_id') }}"
                           placeholder="e.g., 22-SC-0001"
                           required
                           autocomplete="off"
                           autocapitalize="characters">

                    @error('student_id')
                        <div class="invalid-feedback d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-text mt-2">
                        <i class="fas fa-info-circle me-2"></i>
                        Enter the student's unique ID in the format: <strong>YY-SC-XXXX</strong>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add Student ID
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('studentIdForm');
    const submitBtn = document.getElementById('submitBtn');
    const studentIdInput = document.getElementById('student_id');

    // Auto-format student ID input
    studentIdInput.addEventListener('input', function(e) {
        let value = e.target.value.toUpperCase().replace(/[^A-Z0-9\-]/g, '');

        // Add hyphens automatically
        if (value.length > 2 && !value.includes('-')) {
            value = value.substring(0, 2) + '-' + value.substring(2);
        }
        if (value.length > 5 && value.split('-').length === 2) {
            value = value.substring(0, 5) + '-' + value.substring(5);
        }

        e.target.value = value;
    });

    // Form submission loading state
    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<span class="visually-hidden">Processing...</span>';
        submitBtn.disabled = true;
    });

    // Focus on input when page loads
    studentIdInput.focus();

    // Clear validation on input
    studentIdInput.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endsection
