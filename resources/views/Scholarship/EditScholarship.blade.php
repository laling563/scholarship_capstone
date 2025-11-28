@extends('Admin.AdminLayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="bi bi-pencil-square me-2"></i> Edit Scholarship
                    </h2>
                </div>
                <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-award me-2"></i> Scholarship Details
                    </h5>
                    <p class="mb-0 text-muted">Update the scholarship information below</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('sponsor.scholarships.update', $scholarship) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="title" class="form-label fw-bold">
                                    <i class="bi bi-card-heading me-1"></i> Scholarship Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                       value="{{ old('title', $scholarship->title) }}" placeholder="Enter scholarship title" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text text-muted">Example: "Academic Excellence Scholarship 2023"</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">
                                    <i class="bi bi-text-paragraph me-1"></i> Description <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                          id="description" rows="5" placeholder="Provide detailed information about the scholarship" required>{{ old('description', $scholarship->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text text-muted">Describe the scholarship purpose, benefits, and selection criteria.</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold"><i class="bi bi-list-check me-1"></i> Requirements</label>
                                <div id="requirements-container">
                                    @if(is_array(old('requirements', $scholarship->requirements)))
                                        @foreach(old('requirements', $scholarship->requirements) as $requirement)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="requirements[]" value="{{ $requirement }}">
                                                <button type="button" class="btn btn-danger remove-requirement"><i class="bi bi-trash"></i></button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" id="add-requirement" class="btn btn-outline-primary mt-2"><i class="bi bi-plus-circle me-1"></i> Add Requirement</button>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-bold">
                                    <i class="bi bi-calendar-plus me-1"></i> Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                       name="start_date" id="start_date" value="{{ old('start_date', $scholarship->start_date) }}" required>
                                @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label fw-bold">
                                    <i class="bi bi-calendar-x me-1"></i> End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                       name="end_date" id="end_date" value="{{ old('end_date', $scholarship->end_date) }}" required>
                                @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold">
                                    <i class="bi bi-check-circle me-1"></i> Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="open" {{ old('status', $scholarship->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ old('status', $scholarship->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="on-hold" {{ old('status', $scholarship->status) == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="budget" class="form-label fw-bold">
                                    <i class="bi bi-cash-coin me-1"></i> Budget
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('budget') is-invalid @enderror"
                                           name="budget" id="budget" value="{{ old('budget', $scholarship->budget) }}" min="0" step="0.01">
                                </div>
                                @error('budget')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text text-muted">Enter the total scholarship budget.</div>
                            </div>
                            <div class="col-md-4">
                                <label for="student_limit" class="form-label fw-bold">
                                    <i class="bi bi-people me-1"></i> Student Limit
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('student_limit') is-invalid @enderror"
                                           name="student_limit" id="student_limit" value="{{ old('student_limit', $scholarship->student_limit) }}" min="1">
                                    <span class="input-group-text">students</span>
                                </div>
                                @error('student_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text text-muted">Leave empty for unlimited applicants</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-4 mt-3">
                            <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }
    .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }
    .form-switch .form-check-input {
        width: 2.5em;
        margin-left: 0;
    }
    .invalid-feedback {
        display: block;
    }
    .card {
        border-radius: 0.5rem;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    .alert {
        border-radius: 0.5rem;
    }
</style>

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

    document.getElementById('add-requirement').addEventListener('click', function() {
        var container = document.getElementById('requirements-container');
        var inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-2';
        inputGroup.innerHTML = '<input type="text" class="form-control" name="requirements[]"><button type="button" class="btn btn-danger remove-requirement"><i class="bi bi-trash"></i></button>';
        container.appendChild(inputGroup);
    });

    document.getElementById('requirements-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-requirement') || e.target.parentElement.classList.contains('remove-requirement')) {
            e.target.closest('.input-group').remove();
        }
    });
});
</script>
@endsection
