@extends('layouts.sponsor')

@section('title', 'Review Applications - Sponsor Dashboard')

@section('styles')
<style>
    .header-container {
        background: linear-gradient(135deg, var(--sponsor-primary) 0%, var(--sponsor-accent) 100%);
        color: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .header-container h1 {
        font-weight: 700;
    }
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }
    .badge-status {
        font-size: 0.8rem;
        padding: 0.5em 0.9em;
        font-weight: 600;
    }
    .table-responsive {
        max-height: 65vh;
        overflow-y: auto;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
    .btn-icon-only {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="header-container">
        <h1 class="mb-1">Application Review</h1>
        <p class="mb-0 opacity-75">Manage and review student applications for your scholarships.</p>
    </div>

    <div class="row g-4">
        <!-- APPLICATIONS: INCOME <= 10,000 -->
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Low Income Bracket (≤ ₱10,000)</h5>
                </div>
                <div class="card-body p-0">
                    @if($applications->where('total_monthly_income','<=',10000)->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <tbody>
                                    @foreach($applications->where('total_monthly_income','<=',10000) as $app)
                                        <tr>
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3">
                                                        <h6 class="fw-semibold mb-0">{{ $app->student->fname }} {{ $app->student->lname }}</h6>
                                                        <small class="text-muted">{{ $app->scholarship->title }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                <span class="badge rounded-pill bg-{{ $app->status == 'approved' ? 'success' : ($app->status == 'rejected' ? 'danger' : 'warning') }}-soft text-{{ $app->status == 'approved' ? 'success' : ($app->status == 'rejected' ? 'danger' : 'warning') }} badge-status">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td class="p-3 text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('sponsor.applications.view', $app->applicationform_id) }}" class="btn btn-icon-only btn-outline-primary" data-bs-toggle="tooltip" title="View"><i class="bi bi-eye-fill"></i></a>
                                                    @if($app->status != 'approved')
                                                        <form action="{{ route('sponsor.applications.accept', $app->applicationform_id) }}" method="POST"> @csrf @method('PUT')
                                                            <button class="btn btn-icon-only btn-outline-success" data-bs-toggle="tooltip" title="Accept"><i class="bi bi-check-lg"></i></button>
                                                        </form>
                                                    @endif
                                                    @if($app->status != 'rejected')
                                                        <form action="{{ route('sponsor.applications.reject', $app->applicationform_id) }}" method="POST"> @csrf @method('PUT')
                                                            <button class="btn btn-icon-only btn-outline-danger" data-bs-toggle="tooltip" title="Reject"><i class="bi bi-x-lg"></i></button>
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
                        <div class="empty-state">
                            <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                            <p class="mb-0">No applications in this bracket.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- APPLICATIONS: INCOME > 10,000 -->
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">High Income Bracket (> ₱10,000)</h5>
                </div>
                <div class="card-body p-0">
                    @if($applications->where('total_monthly_income','>',10000)->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <tbody>
                                    @foreach($applications->where('total_monthly_income','>',10000) as $app)
                                        <tr>
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3">
                                                        <h6 class="fw-semibold mb-0">{{ $app->student->fname }} {{ $app->student->lname }}</h6>
                                                        <small class="text-muted">{{ $app->scholarship->title }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                <span class="badge rounded-pill bg-{{ $app->status == 'approved' ? 'success' : ($app->status == 'rejected' ? 'danger' : 'warning') }}-soft text-{{ $app->status == 'approved' ? 'success' : ($app->status == 'rejected' ? 'danger' : 'warning') }} badge-status">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td class="p-3 text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('sponsor.applications.view', $app->applicationform_id) }}" class="btn btn-icon-only btn-outline-primary" data-bs-toggle="tooltip" title="View"><i class="bi bi-eye-fill"></i></a>
                                                    @if($app->status != 'approved')
                                                        <form action="{{ route('sponsor.applications.accept', $app->applicationform_id) }}" method="POST"> @csrf @method('PUT')
                                                            <button class="btn btn-icon-only btn-outline-success" data-bs-toggle="tooltip" title="Accept"><i class="bi bi-check-lg"></i></button>
                                                        </form>
                                                    @endif
                                                    @if($app->status != 'rejected')
                                                        <form action="{{ route('sponsor.applications.reject', $app->applicationform_id) }}" method="POST"> @csrf @method('PUT')
                                                            <button class="btn btn-icon-only btn-outline-danger" data-bs-toggle="tooltip" title="Reject"><i class="bi bi-x-lg"></i></button>
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
                        <div class="empty-state">
                            <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                            <p class="mb-0">No applications in this bracket.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
