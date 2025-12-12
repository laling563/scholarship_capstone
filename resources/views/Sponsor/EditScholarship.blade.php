@extends('layouts.sponsor')

@section('title', 'Edit Scholarship - Sponsor Dashboard')

@section('styles')
<style>
    .header-container {
        background: linear-gradient(135deg, var(--sponsor-primary) 0%, var(--sponsor-accent) 100%);
        color: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .header-container h1 {
        font-weight: 700;
    }
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .form-label {
        font-weight: 600;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="header-container">
        <h1 class="mb-1">Edit Scholarship</h1>
        <p class="mb-0 opacity-75">Update the details for your scholarship program.</p>
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

    <!-- EDIT FORM -->
    <div class="card card-custom">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('sponsor.scholarships.update', $scholarship) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-12">
                        <label for="title" class="form-label">Scholarship Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="{{ old('title', $scholarship->title) }}" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $scholarship->description) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label for="budget" class="form-label">Budget</label>
                        <div class="input-group"><span class="input-group-text">₱</span><input type="number" class="form-control" name="budget" id="budget" value="{{ old('budget', $scholarship->budget) }}" min="0" step="100"></div>
                    </div>

                    <div class="col-md-4">
                        <label for="student_limit" class="form-label">Student Limit</label>
                        <div class="input-group"><input type="number" class="form-control" name="student_limit" id="student_limit" value="{{ old('student_limit', $scholarship->student_limit) }}" min="1"><span class="input-group-text">students</span></div>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="open" {{ old('status', $scholarship->status) == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status', $scholarship->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="on-hold" {{ old('status', $scholarship->status) == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $scholarship->start_date->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', $scholarship->end_date->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Requirements</label>
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
                                @if(!empty($requirement))
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
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
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
