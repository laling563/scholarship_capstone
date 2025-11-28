@extends('Admin.AdminLayout')

@section('title', 'Manage Scholarships - Admin Dashboard')

@section('styles')
<style>
    .card-custom {
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .table-custom thead th {
        background-color: #f8f9fa;
        border-bottom-width: 1px;
        font-weight: 600;
    }
    .badge-custom {
        font-size: 0.8rem;
        padding: 0.5em 0.8em;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Manage Scholarships</h1>
        {{-- <a href="#" class="btn btn-primary">Add New Scholarship</a> --}}
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="text-center">Slots</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Applicants</th>
                            <th>Created At</th>
                            {{-- <th class="text-end">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scholarships as $scholarship)
                            <tr>
                                <td>{{ $scholarship->title }}</td>
                                <td class="text-center">{{ $scholarship->slots }}</td>
                                <td class="text-center">
                                    @if($scholarship->is_open)
                                        <span class="badge bg-success badge-custom">Open</span>
                                    @else
                                        <span class="badge bg-danger badge-custom">Closed</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $scholarship->application_forms_count }}</td>
                                <td>{{ $scholarship->created_at->format('M d, Y') }}</td>
                                {{-- <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No scholarships found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $scholarships->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
