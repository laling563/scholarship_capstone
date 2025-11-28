@extends('Admin.AdminLayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Left Column - Below 10k -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Applications (Income ₱10,000 below)</h3>
                </div>
                <div class="card-body p-0 d-flex flex-column">
                    @if($applications->where('total_monthly_income', '<=', 10000)->count())
                    <div class="table-responsive" style="max-height: 65vh;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th>Student</th>
                                    <th>Scholarship</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4" style="width: 170px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications->where('total_monthly_income', '<=', 10000) as $application)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $application->student->fname ?? 'No student' }} {{ $application->student->lname ?? '' }}</h6>
                                            <small class="text-muted">{{ $application->student->email ?? '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">
                                            {{ $application->scholarship->title ?? 'No scholarship' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{
                                            $application->status == 'approved' ? 'success' :
                                            ($application->status == 'rejected' ? 'danger' :
                                            'warning')
                                        }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="/applications/{{$application->applicationform_id}}/view"
                                               class="btn btn-sm btn-outline-primary rounded-circle"
                                               data-bs-toggle="tooltip"
                                               data-bs-title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            @if($application->status != 'approved')
                                            <form action="{{ route('applications.accept', $application->applicationform_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success rounded-circle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Accept">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if($application->status != 'rejected')
                                            <form action="{{ route('applications.reject', $application->applicationform_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-circle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Reject">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 flex-grow-1">
                        <i class="bi bi-file-earmark-text display-4 text-muted"></i>
                        <h4 class="mt-3 text-muted">No Applications Found</h4>
                        <p class="text-muted">No applications with income ≤ ₱10,000</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Above 10k -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Applications (Income ₱10,000 above)</h3>
                </div>
                <div class="card-body p-0 d-flex flex-column">
                    @if($applications->where('total_monthly_income', '>', 10000)->count())
                    <div class="table-responsive" style="max-height: 65vh;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th>Student</th>
                                    <th>Scholarship</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4" style="width: 170px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications->where('total_monthly_income', '>', 10000) as $application)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $application->student->fname ?? 'No student' }} {{ $application->student->lname ?? '' }}</h6>
                                            <small class="text-muted">{{ $application->student->email ?? '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-info text-info">
                                            {{ $application->scholarship->title ?? 'No scholarship' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{
                                            $application->status == 'approved' ? 'success' :
                                            ($application->status == 'rejected' ? 'danger' :
                                            'warning')
                                        }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="/applications/{{$application->applicationform_id}}/view"
                                               class="btn btn-sm btn-outline-primary rounded-circle"
                                               data-bs-toggle="tooltip"
                                               data-bs-title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            @if($application->status != 'approved')
                                            <form action="{{ route('applications.accept', $application->applicationform_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-success rounded-circle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Accept">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if($application->status != 'rejected')
                                            <form action="{{ route('applications.reject', $application->applicationform_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-circle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Reject">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 flex-grow-1">
                        <i class="bi bi-file-earmark-text display-4 text-muted"></i>
                        <h4 class="mt-3 text-muted">No Applications Found</h4>
                        <p class="text-muted">No applications with income > ₱10,000</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .badge {
        padding: 0.35em 0.5em;
        font-weight: 500;
        font-size: 0.75em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .card {
        border-radius: 0.75rem;
        height: 100%;
    }
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    .table-responsive {
        overflow-y: auto;
        flex: 1;
    }
    .sticky-top {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 1;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
