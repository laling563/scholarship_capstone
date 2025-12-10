@extends('Admin.AdminLayout')

@section('title', 'Sponsor Details')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $sponsor->sponsor_name }}</h5>
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Sponsors
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Sponsor Name</dt>
                        <dd class="col-sm-8">{{ $sponsor->sponsor_name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $sponsor->email }}</dd>

                        <dt class="col-sm-4">Contact Number</dt>
                        <dd class="col-sm-8">{{ $sponsor->contact_number ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Username</dt>
                        <dd class="col-sm-8">{{ $sponsor->username }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Notes</h6>
                    <p>{{ $sponsor->notes ?? 'No notes provided.' }}</p>
                </div>
            </div>

            <hr>

            <h6 class="mt-4">Associated Scholarships</h6>
            @if ($sponsor->scholarships->isNotEmpty())
                <ul class="list-group">
                    @foreach ($sponsor->scholarships as $scholarship)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $scholarship->title }}</h6>
                                <small class="text-muted">Type: {{ ucwords(str_replace('_', ' ', $scholarship->type)) }}</small>
                            </div>
                            <a href="{{ route('admin.scholarships.show', $scholarship) }}" class="btn btn-sm btn-outline-info">View Scholarship</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-info mt-3">This sponsor has not created any scholarships yet.</div>
            @endif

            <div class="mt-4">
                 <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-primary">Edit Sponsor</a>
            </div>
        </div>
    </div>
</div>
@endsection
