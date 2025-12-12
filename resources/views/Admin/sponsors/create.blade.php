@extends('Admin.AdminLayout')

@section('title', 'Create Sponsor')

<style>
    /* === CREATE SPONSOR PAGE STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --primary-dark: #3a0ca3;
        --secondary: #7209b7;
        --success: #4cc9f0;
        --warning: #f72585;
        --danger: #e63946;
        --info: #38b000;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === PAGE LAYOUT === */
    .container-fluid {
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        min-height: calc(100vh - 70px);
    }

    /* === MAIN CARD === */
    .card.shadow-sm {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow) !important;
        background: white;
        overflow: hidden;
        border: 1px solid #f0f3ff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card.shadow-sm:hover {
        transform: translateY(-2px);
        box-shadow: var(--hover-shadow) !important;
    }

    /* === CARD HEADER === */
    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white;
        border: none;
        padding: 1.75rem 2rem !important;
        border-radius: 20px 20px 0 0 !important;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 10px 10px;
        opacity: 0.2;
    }

    .card-header h5 {
        font-size: 1.4rem !important;
        font-weight: 700 !important;
        color: white !important;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header h5::before {
        content: '👤';
        font-size: 1.3rem;
        filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.2));
    }

    /* === BACK BUTTON === */
    .btn-outline-secondary {
        border: 2px solid rgba(255, 255, 255, 0.3) !important;
        color: white !important;
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px);
        border-radius: 10px !important;
        padding: 0.5rem 1.25rem !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        transition: all 0.3s ease !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .btn-outline-secondary:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        transform: translateX(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
    }

    /* === CARD BODY === */
    .card-body {
        padding: 2.5rem 2rem !important;
        background: white;
    }

    /* === FORM FIELDSTYLES === */
    fieldset {
        border: none;
        padding: 0;
        margin: 0;
    }

    legend.h6 {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        color: var(--primary-dark) !important;
        padding: 0.75rem 1.25rem !important;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(136, 149, 239, 0.02) 100%);
        border-radius: 12px;
        margin-bottom: 1.5rem !important;
        border-left: 4px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
    }

    legend.h6::before {
        content: '📋';
        font-size: 1rem;
    }

    /* === FORM LABELS === */
    .form-label {
        font-weight: 600 !important;
        color: #1e293b !important;
        margin-bottom: 0.5rem !important;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label::after {
        content: '*';
        color: var(--danger);
        margin-left: 0.25rem;
    }

    /* Optional field indicator */
    .form-label.optional::after {
        content: '(Optional)';
        color: #94a3b8;
        font-weight: 400;
        font-size: 0.85rem;
        margin-left: 0.5rem;
    }

    /* === FORM CONTROLS === */
    .form-control, .form-select {
        border: 2px solid #e8edff !important;
        border-radius: 12px !important;
        padding: 0.875rem 1rem !important;
        font-size: 0.95rem !important;
        color: #1e293b !important;
        background: white !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 8px rgba(67, 97, 238, 0.05) !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1) !important;
        transform: translateY(-1px);
    }

    .form-control:hover, .form-select:hover {
        border-color: #c5cae9 !important;
    }

    /* === FORM ROWS === */
    .row {
        margin-bottom: 1rem;
    }

    .mb-3 {
        margin-bottom: 1.5rem !important;
    }

    /* === TEXTAREA === */
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* === SELECT OPTIONS === */
    .form-select option {
        padding: 0.75rem !important;
        border-radius: 8px !important;
        margin: 0.25rem 0 !important;
    }

    .form-select option:checked {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        color: white !important;
    }

    /* === ERROR STATES === */
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger) !important;
        background: linear-gradient(135deg, rgba(230, 57, 70, 0.02) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
    }

    .invalid-feedback {
        color: var(--danger) !important;
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: rgba(230, 57, 70, 0.05);
        border-radius: 8px;
        border-left: 3px solid var(--danger);
    }

    /* === SUCCESS/ERROR ALERTS === */
    .alert-danger {
        background: linear-gradient(135deg, rgba(230, 57, 70, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
        color: var(--danger) !important;
        border: 2px solid rgba(230, 57, 70, 0.2) !important;
        border-radius: 12px !important;
        padding: 1.25rem 1.5rem !important;
        margin-bottom: 2rem !important;
        box-shadow: 0 4px 15px rgba(230, 57, 70, 0.08) !important;
    }

    .alert-danger ul {
        margin: 0.5rem 0 0 0 !important;
        padding-left: 1.25rem !important;
    }

    .alert-danger li {
        margin-bottom: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: rgba(230, 57, 70, 0.05);
        border-radius: 8px;
        border-left: 3px solid var(--danger);
    }

    .alert-danger li:last-child {
        margin-bottom: 0;
    }

    /* === SUBMIT BUTTON === */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 1rem 2.5rem !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2) !important;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3) !important;
    }

    .btn-primary:active {
        transform: translateY(-1px) !important;
    }

    /* === HR STYLING === */
    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e8edff, transparent);
        margin: 2.5rem 0;
    }

    /* === REQUIRED FIELD NOTE === */
    .required-note {
        font-size: 0.85rem;
        color: #94a3b8;
        margin-top: 1.5rem;
        padding: 0.75rem 1rem;
        background: rgba(67, 97, 238, 0.05);
        border-radius: 8px;
        border-left: 3px solid var(--primary);
    }

    .required-note::before {
        content: '📝';
        margin-right: 0.5rem;
    }

    /* === ANIMATIONS === */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card.shadow-sm {
        animation: fadeInUp 0.5s ease-out;
    }

    .row > div {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .row > div:nth-child(1) { animation-delay: 0.1s; }
    .row > div:nth-child(2) { animation-delay: 0.2s; }
    .row > div:nth-child(3) { animation-delay: 0.3s; }
    .row > div:nth-child(4) { animation-delay: 0.4s; }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 992px) {
        .container-fluid {
            padding: 1.5rem;
        }

        .card-body {
            padding: 2rem 1.5rem !important;
        }

        .card-header {
            padding: 1.5rem !important;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem 1.25rem !important;
        }

        .card-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem;
            padding: 1.25rem !important;
        }

        .btn-outline-secondary {
            align-self: flex-start;
        }

        .form-control, .form-select {
            padding: 0.75rem !important;
        }
    }

    @media (max-width: 576px) {
        .card-header h5 {
            font-size: 1.2rem !important;
        }

        legend.h6 {
            font-size: 1rem !important;
            padding: 0.75rem 1rem !important;
        }

        .btn-primary {
            padding: 0.875rem 1.5rem !important;
            font-size: 0.95rem !important;
        }
    }
</style>

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">👤 Create New Sponsor</h5>
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Sponsors
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div class="flex-grow-1">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.sponsors.store') }}" method="POST">
                @csrf

                {{-- Sponsor Details --}}
                <fieldset class="mb-4">
                    <legend class="h6">📋 Sponsor Information</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sponsor_name" class="form-label">
                                <i class="fas fa-user-circle me-1"></i> Sponsor Name
                            </label>
                            <input type="text" class="form-control @error('sponsor_name') is-invalid @enderror"
                                   id="sponsor_name" name="sponsor_name"
                                   value="{{ old('sponsor_name') }}"
                                   placeholder="Enter sponsor full name" required>
                            @error('sponsor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">
                                <i class="fas fa-award me-1"></i> Scholarship Type
                            </label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type" required>
                                <option value="" disabled selected>Select a scholarship type</option>
                                <option value="sport" {{ old('type') == 'sport' ? 'selected' : '' }}>
                                    ⚽ Sports Scholarship
                                </option>
                                <option value="financial_aid" {{ old('type') == 'financial_aid' ? 'selected' : '' }}>
                                    💰 Financial Aid
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="sponsor@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label optional">
                                <i class="fas fa-phone me-1"></i> Contact Number
                            </label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                   id="contact_number" name="contact_number"
                                   value="{{ old('contact_number') }}"
                                   placeholder="(123) 456-7890">
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label optional">
                            <i class="fas fa-sticky-note me-1"></i> Additional Notes
                        </label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="3"
                                  placeholder="Enter any additional information about the sponsor...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                {{-- Login Credentials --}}
                <fieldset class="mb-4">
                    <legend class="h6">🔐 Login Credentials</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-1"></i> Username
                            </label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   id="username" name="username"
                                   value="{{ old('username') }}"
                                   placeholder="Enter login username" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter secure password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="required-note">
                        Fields marked with * are required
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Create Sponsor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add input animations
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Password strength indicator (optional enhancement)
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = this.value.length;
            const parent = this.parentElement;
            parent.classList.remove('weak', 'medium', 'strong');

            if (strength > 0) {
                if (strength < 6) {
                    parent.classList.add('weak');
                } else if (strength < 10) {
                    parent.classList.add('medium');
                } else {
                    parent.classList.add('strong');
                }
            }
        });
    }
});
</script>
@endsection
