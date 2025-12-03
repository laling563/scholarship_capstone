@extends('layouts.sponsor')

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

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4">
            <h5 class="mb-0 fw-bold"><i class="bi bi-award me-2"></i> Scholarship Details</h5>
            <p class="mb-0 text-muted">Update the scholarship information below</p>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('sponsor.scholarships.update', $scholarship) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="form-label fw-bold"><i class="bi bi-card-heading me-1"></i> Scholarship Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $scholarship->title) }}" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold"><i class="bi bi-text-paragraph me-1"></i> Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" id="description" rows="5" required>{{ old('description', $scholarship->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="bi bi-list-check me-1"></i> Requirements</label>
                    <div id="requirements-container">
                        @php
                            $requirements = old('requirements', $scholarship->requirements);
                            while (is_string($requirements)) {
                                $decoded = json_decode($requirements, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $requirements = $decoded;
                                } else {
                                    $requirements = []; // Break if decoding fails
                                    break;
                                }
                            }
                            if (!is_array($requirements)) {
                                $requirements = [];
                            }
                        @endphp
                        @if(count($requirements) > 0)
                            @foreach($requirements as $requirement)
                                @if(!empty($requirement)) {{-- Added check to skip empty strings --}}
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="requirements[]" value="{{ $requirement }}">
                                        <button type="button" class="btn btn-outline-danger remove-requirement"><i class="bi bi-trash"></i></button>
                                    </div>
                                @endif
                            @endforeach
                        @else
                             <div class="input-group mb-2">
                                <input type="text" class="form-control" name="requirements[]">
                                <button type="button" class="btn btn-outline-danger remove-requirement"><i class="bi bi-trash"></i></button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-requirement" class="btn btn-outline-primary btn-sm mt-2"><i class="bi bi-plus-circle me-1"></i> Add Requirement</button>
                </div>


                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-bold"><i class="bi bi-calendar-plus me-1"></i> Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $scholarship->start_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-bold"><i class="bi bi-calendar-x me-1"></i> End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', $scholarship->end_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label fw-bold"><i class="bi bi-check-circle me-1"></i> Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="open" {{ old('status', $scholarship->status) == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status', $scholarship->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="on-hold" {{ old('status', $scholarship->status) == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="budget" class="form-label fw-bold"><i class="bi bi-cash-coin me-1"></i> Budget</label>
                        <div class="input-group"><span class="input-group-text">₱</span><input type="number" class="form-control" name="budget" id="budget" value="{{ old('budget', $scholarship->budget) }}" min="0" step="100"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="student_limit" class="form-label fw-bold"><i class="bi bi-people me-1"></i> Student Limit</label>
                        <div class="input-group"><input type="number" class="form-control" name="student_limit" id="student_limit" value="{{ old('student_limit', $scholarship->student_limit) }}" min="1"><span class="input-group-text">students</span></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between border-top pt-4 mt-3">
                    <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (startDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
        });
    }

    document.getElementById('add-requirement').addEventListener('click', function() {
        var container = document.getElementById('requirements-container');
        var inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-2';
        inputGroup.innerHTML = `<input type="text" class="form-control" name="requirements[]"><button type="button" class="btn btn-outline-danger remove-requirement"><i class="bi bi-trash"></i></button>`;
        container.appendChild(inputGroup);
    });

    document.getElementById('requirements-container').addEventListener('click', function(e) {
        let targetButton = e.target;
        if (e.target.tagName === 'I') {
            targetButton = e.target.parentElement;
        }
        if (targetButton.classList.contains('remove-requirement')) {
            targetButton.closest('.input-group').remove();
        }
    });
});
</script>
@endsection
