@extends('layouts.sponsor')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4">Edit Scholarship</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('sponsor.scholarships.update', $scholarship->scholarship_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Scholarship Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $scholarship->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $scholarship->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="grant_amount" class="form-label">Grant Amount</label>
                    <input type="number" class="form-control" id="grant_amount" name="grant_amount" value="{{ old('grant_amount', $scholarship->grant_amount) }}" required>
                </div>

                <div class="mb-3">
                    <label for="requirements" class="form-label">Requirements</label>
                    <div id="requirements-container">
                        @if(is_array($scholarship->requirements))
                            @foreach($scholarship->requirements as $requirement)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="requirements[]" value="{{ $requirement }}">
                                    <button type="button" class="btn btn-danger remove-requirement">Remove</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" id="add-requirement" class="btn btn-outline-primary mt-2">Add Requirement</button>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', optional($scholarship->start_date)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', optional($scholarship->end_date)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget" value="{{ old('budget', $scholarship->budget) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="student_limit" class="form-label">Student Limit</label>
                        <input type="number" class="form-control" id="student_limit" name="student_limit" value="{{ old('student_limit', $scholarship->student_limit) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('sponsor.scholarships.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Scholarship</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-requirement').addEventListener('click', function() {
            var container = document.getElementById('requirements-container');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';
            inputGroup.innerHTML = '<input type="text" class="form-control" name="requirements[]"><button type="button" class="btn btn-danger remove-requirement">Remove</button>';
            container.appendChild(inputGroup);
        });

        document.getElementById('requirements-container').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-requirement')) {
                e.target.closest('.input-group').remove();
            }
        });
    });
</script>
@endpush
@endsection
