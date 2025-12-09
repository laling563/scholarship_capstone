@extends('Admin.AdminLayout')

@section('title', 'Manage Sponsors - Admin Dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Manage Sponsors</h1>
        <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">Add New Sponsor</a>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sponsors as $sponsor)
                            <tr>
                                <td>{{ $sponsor->name }}</td>
                                <td>{{ $sponsor->email }}</td>
                                <td>{{ $sponsor->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No sponsors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
