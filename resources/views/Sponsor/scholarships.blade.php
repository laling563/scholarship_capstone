@extends('layouts.sponsor')

@section('title', 'Scholarship Management - Sponsor Dashboard')

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
    }
    .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="header-container">
        <h1 class="mb-1">Scholarship Management</h1>
        <p class="mb-0 opacity-75">Oversee, create, and manage your sponsored scholarships.</p>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('sponsor.scholarships.create') }}" class="btn btn-primary fw-semibold">
            <i class="bi bi-plus-circle me-2"></i> Create New Scholarship
        </a>
    </div>

    <!-- SCHOLARSHIPS TABLE -->
    <div class="card card-custom">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">Your Scholarships</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="scholarshipsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-bold ps-4 py-3">Scholarship</th>
                            <th class="fw-bold py-3">Status</th>
                            <th class="fw-bold py-3">Timeline</th>
                            <th class="fw-bold text-center py-3">Slots</th>
                            <th class="fw-bold text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($scholarships as $scholarship)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-soft-primary text-primary me-3">
                                            <i class="bi bi-award"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-0">{{ $scholarship->title }}</h6>
                                            <small class="text-muted">
                                                {{ $scholarship->type == 'government' ? 'Government' : 'Private' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($scholarship->is_open)
                                        <span class="badge rounded-pill bg-success-soft text-success badge-status">
                                            <i class="bi bi-check-circle me-1"></i> Open
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary-soft text-secondary badge-status">
                                            <i class="bi bi-x-circle me-1"></i> Closed
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-dark">
                                            {{ \Carbon\Carbon::parse($scholarship->start_date)->format('M d, Y') }} -
                                            {{ \Carbon\Carbon::parse($scholarship->end_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-soft text-info rounded-pill badge-status">
                                        {{ $scholarship->application_forms_count }} / {{ $scholarship->student_limit }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('sponsor.scholarships.edit', $scholarship->scholarship_id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $scholarship->scholarship_id }}"
                                        data-bs-toggle="tooltip" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $scholarship->scholarship_id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title text-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this scholarship?
                                            <br><strong>{{ $scholarship->title }}</strong></p>
                                            <div class="alert alert-danger small">This action cannot be undone.</div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('sponsor.scholarships.destroy', $scholarship->scholarship_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete Permanently</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-folder-x fs-2 d-block mb-3"></i>
                                    No scholarships found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
