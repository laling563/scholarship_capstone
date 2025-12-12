@extends('layouts.sponsor')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        --success-gradient: linear-gradient(135deg, #3498db 0%, #ecf0f1 100%);
        --warning-gradient: linear-gradient(135deg, #f0803c 0%, #d35400 100%);
        --card-shadow: 0 10px 40px rgba(67, 97, 238, 0.1);
        --hover-shadow: 0 15px 50px rgba(67, 97, 238, 0.15);
    }

    body {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        min-height: 100vh;
    }

    .container-fluid {
        padding: 0;
    }

    .py-4 {
        padding: 2.5rem 2rem !important;
    }

    /* Header Styling */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2.5rem 2rem;
        margin: -2.5rem -2rem 2.5rem -2rem;
        border-radius: 0 0 30px 30px;
        box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        border-radius: 50%;
        transform: translate(100px, -100px);
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .header-content h2 {
        font-weight: 800;
        font-size: 2.5rem;
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .header-content h2 i {
        background: rgba(255,255,255,0.2);
        padding: 0.75rem;
        border-radius: 15px;
        margin-right: 1rem;
        font-size: 1.8rem;
    }

    .header-content p {
        color: rgba(255,255,255,0.9);
        font-size: 1.1rem;
        max-width: 600px;
    }

    .back-btn {
        background: rgba(255,255,255,0.15);
        color: white !important;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(10px);
    }

    .back-btn:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.4);
    }

    /* Alert Styling */
    .custom-alert {
        border: none;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideInDown 0.5s ease-out;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left: 5px solid #28a745;
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border-left: 5px solid #dc3545;
        color: #721c24;
    }

    .alert i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .btn-close {
        filter: brightness(0.8);
    }

    /* Card Styling */
    .creation-card {
        background: white;
        border-radius: 25px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.4s ease;
        margin-bottom: 2rem;
    }

    .creation-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        padding: 2rem 2.5rem !important;
        border-radius: 25px 25px 0 0 !important;
    }

    .card-header h5 {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header h5 i {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.5rem;
    }

    .card-header p {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0.5rem 0 0 2.5rem;
    }

    .card-body {
        padding: 2.5rem !important;
    }

    /* Form Styling */
    .form-label {
        color: #1e293b;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #4361ee;
        font-size: 1.1rem;
    }

    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        transform: translateY(-1px);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #e63946;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23e63946'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e63946' stroke='none'/%3e%3c/svg%3e");
    }

    .input-group {
        border-radius: 12px;
        overflow: hidden;
    }

    .input-group .form-control {
        border-radius: 12px 0 0 12px;
    }

    .input-group-text {
        background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        border: 2px solid #e2e8f0;
        border-left: none;
        color: #4361ee;
        font-weight: 600;
    }

    .form-text {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-style: italic;
    }

    /* Requirements Section */
    .requirements-section {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 0.5rem;
        border: 2px dashed #cbd5e1;
    }

    #requirements-container .input-group {
        margin-bottom: 0.75rem;
        animation: fadeIn 0.3s ease-out;
    }

    #requirements-container .form-control {
        border-right: none;
        border-radius: 10px 0 0 10px !important;
    }

    .remove-requirement {
        border-radius: 0 10px 10px 0;
        background: linear-gradient(135deg, #e63946 0%, #a4161a 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
    }

    .remove-requirement:hover {
        background: linear-gradient(135deg, #ff4757 0%, #c1121f 100%);
        transform: scale(1.05);
    }

    #add-requirement {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        margin-top: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    #add-requirement:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
    }

    /* Form Footer */
    .form-footer {
        background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);
        border-top: 2px solid rgba(67, 97, 238, 0.1);
        padding: 2rem 2.5rem !important;
        border-radius: 0 0 25px 25px;
        margin-top: 1.5rem;
    }

    .form-footer .btn {
        border-radius: 12px;
        padding: 0.875rem 2.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3);
    }

    /* Animations */
    @keyframes slideInDown {
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
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .py-4 {
            padding: 1.5rem 1rem !important;
        }

        .page-header {
            padding: 2rem 1rem;
            margin: -1.5rem -1rem 2rem -1rem;
            border-radius: 0 0 20px 20px;
        }

        .header-content h2 {
            font-size: 2rem;
        }

        .card-header,
        .card-body,
        .form-footer {
            padding: 1.5rem !important;
        }

        .row {
            margin: 0 -0.5rem;
        }

        .col-md-4, .col-md-12 {
            padding: 0 0.5rem;
        }
    }

    /* Custom Date Input Styling */
    input[type="date"] {
        position: relative;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    /* Select Arrow Styling */
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234361ee' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    /* Textarea Resize Handle */
    textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* Status Select Styling */
    .form-select option {
        padding: 0.5rem;
    }

    .form-select option[value="open"] {
        color: #38b000;
        font-weight: 600;
    }

    .form-select option[value="closed"] {
        color: #e63946;
        font-weight: 600;
    }

    .form-select option[value="on-hold"] {
        color: #f0803c;
        font-weight: 600;
    }
</style>

<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="header-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold text-white mb-0">
                        <i class="bi bi-plus-circle"></i> Create New Scholarship
                    </h2>
                    <p class="mb-0">Fill in the details below to launch a new scholarship program</p>
                </div>
                <a href="{{ route('sponsor.scholarships.index') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="custom-alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0 me-3"></i>
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">Success!</h6>
                <div class="mb-0">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="custom-alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-3"></i>
                <div>
                    <h6 class="fw-bold mb-2">Please correct the following errors:</h6>
                    <ul class="mb-0 ps-3" style="list-style-type: none;">
                        @foreach($errors->all() as $error)
                            <li class="mb-1">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Scholarship Creation Form --}}
    <div class="creation-card">
        <div class="card-header">
            <h5><i class="bi bi-award"></i> Scholarship Details</h5>
            <p>All fields marked with <span class="text-danger">*</span> are required</p>
        </div>

        <div class="card-body">
            <form action="{{ route('sponsor.scholarships.store') }}" method="POST">
                @csrf

                {{-- Scholarship Title --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="title" class="form-label">
                            <i class="bi bi-card-heading"></i> Scholarship Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                               value="{{ old('title') }}" placeholder="Enter scholarship title" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Make it clear and descriptive to attract qualified applicants</div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="description" class="form-label">
                            <i class="bi bi-text-paragraph"></i> Description <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                  id="description" rows="5" placeholder="Provide detailed information about the scholarship" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Describe the scholarship's purpose, benefits, and what makes it unique</div>
                    </div>
                </div>

                {{-- Requirements --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label"><i class="bi bi-list-check"></i> Requirements</label>
                        <div class="requirements-section">
                            <div id="requirements-container">
                                @if(old('requirements'))
                                    @foreach(old('requirements') as $requirement)
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="requirements[]"
                                                   value="{{ $requirement }}" placeholder="Enter a requirement">
                                            <button type="button" class="btn remove-requirement">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="requirements[]"
                                               placeholder="Enter a requirement">
                                        <button type="button" class="btn remove-requirement">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-requirement" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-circle me-2"></i> Add Requirement
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Dates & Status --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">
                            <i class="bi bi-calendar-plus"></i> Start Date <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                               name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">
                            <i class="bi bi-calendar-x"></i> End Date <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                               name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">
                            <i class="bi bi-check-circle"></i> Status
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="open" {{ old('status', 'open') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="on-hold" {{ old('status') == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Budget & Student Limit --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="budget" class="form-label">
                            <i class="bi bi-cash-coin"></i> Budget
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('budget') is-invalid @enderror"
                                   name="budget" id="budget" value="{{ old('budget') }}" min="0" step="0.01"
                                   placeholder="0.00">
                        </div>
                        @error('budget')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Total scholarship allocation</div>
                    </div>
                    <div class="col-md-4">
                        <label for="student_limit" class="form-label">
                            <i class="bi bi-people"></i> Student Limit
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('student_limit') is-invalid @enderror"
                                   name="student_limit" id="student_limit" value="{{ old('student_limit') }}" min="1"
                                   placeholder="Unlimited">
                            <span class="input-group-text">students</span>
                        </div>
                        @error('student_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Maximum number of awardees</div>
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="form-footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-save me-2"></i> Create Scholarship
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum end date based on start date
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });

    // Initialize end date min value if start date is already set
    if (startDate.value) {
        endDate.min = startDate.value;
    }

    // Requirements management
    document.getElementById('add-requirement').addEventListener('click', function() {
        const container = document.getElementById('requirements-container');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-2';
        inputGroup.innerHTML = `
            <input type="text" class="form-control" name="requirements[]" placeholder="Enter a requirement">
            <button type="button" class="btn remove-requirement">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(inputGroup);

        // Focus on the new input
        inputGroup.querySelector('input').focus();
    });

    document.getElementById('requirements-container').addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-requirement');
        if (removeBtn && this.querySelectorAll('.input-group').length > 1) {
            removeBtn.closest('.input-group').remove();
        }
    });
});
</script>
@endsection
