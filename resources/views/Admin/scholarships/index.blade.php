@extends('Admin.AdminLayout')

@section('title', 'Manage Scholarships')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Manage Scholarships</h1>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="createScholarshipDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Create Scholarship
            </button>
            <ul class="dropdown-menu" aria-labelledby="createScholarshipDropdown">
                <li><a class="dropdown-item" href="{{ route('admin.scholarships.create.sport') }}">Sports Scholarship</a></li>
                {{-- Add other scholarship types here --}}
            </ul>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Scholarship</th>
                            <th>Sponsor</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scholarships as $scholarship)
                            <tr>
                                <td>{{ $scholarship->full_name }}</td>
                                <td>{{ $scholarship->sponsor->sponsor_name }}</td>
                                <td>{{ ucfirst($scholarship->type) }}</td>
                                <td>{{ $scholarship->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No scholarships found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
