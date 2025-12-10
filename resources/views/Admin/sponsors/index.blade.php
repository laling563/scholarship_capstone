@extends('Admin.AdminLayout')

@section('title', 'Sponsors')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manage Sponsors</h6>
            <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Create New Sponsor
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Sponsor Name</th>
                            <th>Scholarship Type</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Username</th>
                            <th>Scholarships</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sponsors as $sponsor)
                            <tr class="align-middle">
                                <td>{{ $sponsor->sponsor_name }}</td>
                                <td class="text-center">
                                    @if($sponsor->type === 'sport')
                                        <span class="badge bg-success">Sports Scholarship</span>
                                    @elseif($sponsor->type === 'financial_aid')
                                        <span class="badge bg-primary">Financial Aid</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $sponsor->email }}</td>
                                <td>{{ $sponsor->contact_number ?? 'N/A' }}</td>
                                <td>{{ $sponsor->username }}</td>
                                <td class="text-center">{{ $sponsor->scholarships->count() }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="btn btn-info btn-sm" title="View">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sponsor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center fst-italic">No sponsors found. Add one to get started!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sponsors->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $sponsors->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
