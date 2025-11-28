@extends('Admin.AdminLayout')

@section('content')
<div class="container mt-5">
    <h2>Application Forms</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('application-forms.create') }}" class="btn btn-primary mb-3">Create New Application</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Scholarship</th>
                <th>Status</th>
                <th>Submission Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                <tr>
                    <td>{{ $app->applicationform_id }}</td>
                    <td>{{ $app->student->full_name ?? 'N/A' }}</td>
                    <td>{{ $app->scholarship->title ?? 'N/A' }}</td>
                    <td>{{ ucfirst($app->status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($app->submission_date)->format('F d, Y') }}</td>
                    <td>
                        <a href="{{ route('application-forms.show', $app->applicationform_id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('application-forms.edit', $app->applicationform_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('application-forms.destroy', $app->applicationform_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No application forms found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $applications->links() }}
    </div>
</div>
@endsection
