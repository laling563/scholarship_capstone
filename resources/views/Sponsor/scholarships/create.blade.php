@extends('layouts.sponsor')

@section('title', 'Create Scholarship - Sponsor Dashboard')

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
        <h1 class="mb-1">Create New Scholarship</h1>
        <p class="mb-0 opacity-75">Fill out the form below to launch a new scholarship program.</p>
    </div>

    <!-- CREATE FORM -->
    <div class="card card-custom">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('sponsor.scholarships.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-12">
                        <label for="title" class="form-label">Scholarship Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="grant_amount" class="form-label">Grant Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number" class="form-control" id="grant_amount" name="grant_amount" value="{{ old('grant_amount') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="student_limit" class="form-label">Student Limit</label>
                        <input type="number" class="form-control" id="student_limit" name="student_limit" value="{{ old('student_limit') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Requirements</label>
                        <div id="requirements-container">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="requirements[]">
                                <button type="button" class="btn btn-outline-danger remove-requirement"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        <button type="button" id="add-requirement" class="btn btn-outline-primary btn-sm mt-2"><i class="bi bi-plus-circle me-1"></i> Add Requirement</button>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-5">
                    <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Scholarship</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-requirement').addEventListener('click', function() {
            var container = document.getElementById('requirements-container');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';
            inputGroup.innerHTML = `<input type="text" class="form-control" name="requirements[]"><button type="button" class="btn btn-outline-danger remove-requirement"><i class="bi bi-trash"></i></button>`;
            container.appendChild(inputGroup);
        });

        document.getElementById('requirements-container').addEventListener('click', function(e) {
            let targetButton = e.target.closest('.remove-requirement');
            if (targetButton) {
                targetButton.closest('.input-group').remove();
            }
        });
    });
</script>
@endpush
