@extends('layouts.sponsor')
@php $hideSidebar = true; @endphp

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="bi bi-award-fill me-2"></i> Scholarship Management
                        </h2>
                    </div>
                    <div class="d-flex">
                        <!-- <div class="input-group me-3" style="width: 250px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="scholarshipSearch" class="form-control border-start-0" placeholder="Search scholarships...">
                        </div> -->
                        <a href="{{ route('sponsor.scholarships.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> Create New
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-list-check me-2"></i> Available Scholarships
                            </h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="scholarshipsTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="fw-bold ps-4">Title</th>
                                        <th class="fw-bold">Description</th>
                                        <th class="fw-bold">Requirements</th>
                                        <th class="fw-bold text-center">Status</th>
                                        <th class="fw-bold">Timeline</th>
                                        <th class="fw-bold text-center">Limit</th>
                                        <th class="fw-bold text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scholarships as $scholarship)
                                        <tr>
                                            <td class="ps-4 fw-bold">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape icon-md bg-soft-primary text-primary rounded-3 me-3">
                                                        <i class="bi bi-award"></i>
                                                    </div>
                                                    <div>
                                                        {{ $scholarship->title }}
                                                        <div class="text-muted small mt-1">
                                                            Created: {{ $scholarship->created_at->format('M d, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip"
                                                    title="{{ $scholarship->description }}">
                                                    {{ $scholarship->description }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($scholarship->requirements && is_string($scholarship->requirements))
                                                    @php
                                                        // 1. Decode the JSON-formatted string into a true PHP array
                                                        $requirementsArray = json_decode($scholarship->requirements, true);

                                                        // 2. Check if the decoding was successful and resulted in an array
                                                        if (is_array($requirementsArray)) {
                                                            // 3. Implode the array to get the "cor, cog" format
                                                            $requirementsString = implode(', ', $requirementsArray);
                                                        } else {
                                                            // Fallback in case decoding fails (e.g., if it's just plain text)
                                                            $requirementsString = $scholarship->requirements;
                                                        }
                                                    @endphp

                                                    <div class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip"
                                                        title="{{ $requirementsString }}">
                                                        {{ $requirementsString }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($scholarship->is_open)
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Open
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                                        <i class="bi bi-x-circle-fill me-1"></i> Closed
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-primary small">
                                                        <i class="bi bi-calendar-check me-1"></i>
                                                        {{ \Carbon\Carbon::parse($scholarship->start_date)->format('M d, Y') }}
                                                    </span>
                                                    <span class="text-danger small">
                                                        <i class="bi bi-calendar-x me-1"></i>
                                                        {{ \Carbon\Carbon::parse($scholarship->end_date)->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                                                    {{ $scholarship->student_limit }} slots
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <!-- <a href="#" class="btn btn-sm btn-outline-info rounded-pill" data-bs-toggle="tooltip" title="View Details">
                                                        <i class="bi bi-eye"></i> -->
                                                    </a>
                                                    <a href="{{ route('sponsor.scholarships.edit', $scholarship->scholarship_id) }}"
                                                        class="btn btn-sm btn-outline-warning rounded-pill"
                                                        data-bs-toggle="tooltip" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $scholarship->scholarship_id }}"
                                                        data-bs-tooltip="tooltip" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $scholarship->scholarship_id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $scholarship->scholarship_id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title text-danger"
                                                            id="deleteModalLabel{{ $scholarship->scholarship_id }}">
                                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm
                                                            Deletion
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to permanently delete this scholarship?</p>
                                                        <div class="alert alert-danger">
                                                            <strong>{{ $scholarship->title }}</strong>
                                                            <div class="small">This action cannot be undone and will remove all
                                                                associated data.</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form
                                                            action="{{ route('sponsor.scholarships.destroy', $scholarship->scholarship_id) }}"
                                                            method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="bi bi-trash-fill me-1"></i> Delete Permanently
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4">
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .icon-shape {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.03);
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Search functionality
            const searchInput = document.getElementById('scholarshipSearch');
            const table = document.getElementById('scholarshipsTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function () {
                const query = searchInput.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const titleCell = rows[i].getElementsByTagName('td')[0];
                    const descriptionCell = rows[i].getElementsByTagName('td')[1];
                    const requirementsCell = rows[i].getElementsByTagName('td')[2];

                    if (titleCell && descriptionCell && requirementsCell) {
                        const titleText = titleCell.textContent || titleCell.innerText;
                        const descriptionText = descriptionCell.textContent || descriptionCell.innerText;
                        const requirementsText = requirementsCell.textContent || requirementsCell.innerText;

                        if (titleText.toLowerCase().includes(query) ||
                            descriptionText.toLowerCase().includes(query) ||
                            requirementsText.toLowerCase().includes(query)) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            });
        });
    </script>
@endsection