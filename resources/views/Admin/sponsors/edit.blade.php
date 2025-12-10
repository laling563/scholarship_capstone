@extends('Admin.AdminLayout')

@section('title', 'Edit Sponsor')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Sponsor: {{ $sponsor->sponsor_name }}</h5>
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Sponsors
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST">
                @csrf
                @method('PUT')

                <fieldset class="mb-4">
                    <legend class="h6">Sponsor Information</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sponsor_name" class="form-label">Sponsor Name</label>
                            <input type="text" class="form-control" id="sponsor_name" name="sponsor_name" value="{{ old('sponsor_name', $sponsor->sponsor_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Scholarship Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" disabled>Select a type</option>
                                <option value="sport" {{ old('type', $sponsor->type) == 'sport' ? 'selected' : '' }}>Sports Scholarship</option>
                                <option value="financial_aid" {{ old('type', $sponsor->type) == 'financial_aid' ? 'selected' : '' }}>Financial Aid</option>
                            </select>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $sponsor->email) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $sponsor->contact_number) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $sponsor->notes) }}</textarea>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="h6">Login Credentials</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username/Login ID</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $sponsor->username) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="password" class="form-label">New Password (optional)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Leave blank to keep the current password.</small>
                        </div>
                    </div>
                </fieldset>

                <hr>
                <button type="submit" class="btn btn-primary">Update Sponsor</button>
            </form>
        </div>
    </div>
</div>
@endsection
