@extends('Admin.AdminLayout')

@section('title', 'Add Student ID')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Student ID to Master List</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.student_master_list.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="student_id" class="form-label fw-bold">Student ID</label>
                    <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ old('student_id') }}" placeholder="e.g., 22-SC-0001" required>
                    @error('student_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">Enter the student's unique ID in the format: YY-SC-XXXX</div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Add Student ID</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
