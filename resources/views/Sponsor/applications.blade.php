@extends('layouts.sponsor')

@section('content')
<div class="container-fluid py-4">

    <div class="row g-4">

        <!-- ================= LEFT COLUMN ≤ ₱10,000 ================= -->
        <div class="col-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white py-2">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Applications (Income ≤ ₱10,000)
                    </h5>
                </div>

                <div class="card-body p-0 d-flex flex-column">
                    @if($applications->where('total_monthly_income','<=',10000)->count())
                        <div class="table-responsive app-table-wrap">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="sticky-top bg-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Scholarship</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width:100px;">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications->where('total_monthly_income','<=',10000) as $application)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong class="text-dark">
                                                        {{ $application->student->fname }} {{ $application->student->lname }}
                                                    </strong><br>
                                                    <small class="text-muted">
                                                        {{ $application->student->email }}
                                                    </small>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-primary text-primary">
                                                    {{ $application->scholarship->title }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge
                                                    @if($application->status=='approved')
                                                        bg-success
                                                    @elseif($application->status=='rejected')
                                                        bg-danger
                                                    @else
                                                        bg-warning
                                                    @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>

                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-1">

                                                    <a href="{{ route('sponsor.applications.view', $application->applicationform_id) }}"
                                                        class="btn btn-icon btn-outline-primary btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @if($application->status != 'approved')
                                                        <form action="{{ route('sponsor.applications.accept',$application->applicationform_id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <button class="btn btn-icon btn-outline-success btn-sm"
                                                                data-bs-toggle="tooltip" data-bs-title="Accept">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($application->status != 'rejected')
                                                        <form action="{{ route('sponsor.applications.reject',$application->applicationform_id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <button class="btn btn-icon btn-outline-danger btn-sm"
                                                                data-bs-toggle="tooltip" data-bs-title="Reject">
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
                        <div class="empty-container">
                            <i class="bi bi-inboxes display-5 text-muted"></i>
                            <p class="mt-2 text-muted">No applications ≤ ₱10,000</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ================= RIGHT COLUMN > ₱10,000 ================= -->
        <div class="col-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-info text-white py-2">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Applications (Income > ₱10,000)
                    </h5>
                </div>

                <div class="card-body p-0 d-flex flex-column">
                    @if($applications->where('total_monthly_income','>',10000)->count())
                        <div class="table-responsive app-table-wrap">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="sticky-top bg-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Scholarship</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width:100px;">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications->where('total_monthly_income','>',10000) as $application)
                                        <tr>
                                            <td>
                                                <strong>{{ $application->student->fname }} {{ $application->student->lname }}</strong><br>
                                                <small class="text-muted">{{ $application->student->email }}</small>
                                            </td>

                                            <td>
                                                <span class="badge bg-soft-info text-info">
                                                    {{ $application->scholarship->title }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge
                                                    @if($application->status=='approved')
                                                        bg-success
                                                    @elseif($application->status=='rejected')
                                                        bg-danger
                                                    @else
                                                        bg-warning
                                                    @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>

                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-1">

                                                    <a href="{{ route('sponsor.applications.view', $application->applicationform_id) }}"
                                                        class="btn btn-icon btn-outline-primary btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @if($application->status != 'approved')
                                                        <form action="{{ route('sponsor.applications.accept',$application->applicationform_id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <button class="btn btn-icon btn-outline-success btn-sm"
                                                                data-bs-toggle="tooltip" data-bs-title="Accept">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($application->status != 'rejected')
                                                        <form action="{{ route('sponsor.applications.reject',$application->applicationform_id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <button class="btn btn-icon btn-outline-danger btn-sm"
                                                                data-bs-toggle="tooltip" data-bs-title="Reject">
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
                        <div class="empty-container">
                            <i class="bi bi-inboxes display-5 text-muted"></i>
                            <p class="mt-2 text-muted">No applications > ₱10,000</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ==================== STYLE ==================== --}}
<style>

    .app-table-wrap {
        max-height: 65vh;
        overflow-y: auto;
    }

    .card-header {
        border-radius: .75rem .75rem 0 0;
    }

    .table-sm td,
    .table-sm th {
        padding: 6px 10px !important;
        font-size: 13px;
    }

    /* ==================== FIX: prevent <th> overlapping sidebar ==================== */
    .table thead.sticky-top {
        z-index: 1 !important;
    }

    .badge {
        font-size: 11px;
        padding: 5px 8px;
    }

    .btn-icon {
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .empty-container {
        text-align: center;
        padding: 4rem 0;
    }

    /* ==================== MOBILE FIXES ==================== */
    @media (max-width: 576px) {

        .table th:nth-child(3),
        .table td:nth-child(3),
        .table th:nth-child(4),
        .table td:nth-child(4) {
            white-space: nowrap;
        }

        .badge {
            font-size: 10px !important;
            padding: 4px 6px !important;
        }

        .btn-icon {
            width: 22px !important;
            height: 22px !important;
        }

        .card-header h5 {
            font-size: 14px;
        }

        .app-table-wrap {
            max-height: 50vh !important;
        }
    }

</style>


{{-- ==================== JS ==================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>

@endsection
