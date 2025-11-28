@extends('Admin.AdminLayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-2">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><i class="bi bi-award me-2"></i> Scholars</h3>
                        <p class="mb-0 small">List of all scholarship recipients</p>
                    </div>
                    <button onclick="printPage()" class="btn btn-light btn-sm">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($scholars->count())
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Student</th>
                                    <th>Scholarship</th>
                                    <th>Course</th>
                                    <th>Year Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scholars as $index => $scholar)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $scholar->student ? $scholar->student->fname . ' ' . $scholar->student->lname : 'No student' }}</h6>
                                            <small class="text-muted">{{ $scholar->student ? $scholar->student->email : '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">
                                            {{ $scholar->scholarship ? $scholar->scholarship->title : 'No scholarship' }}
                                        </span>
                                    </td>
                                    <td>{{ $scholar->student ? $scholar->student->course : 'No course' }}</td>
                                    <td>
                                        <span class="badge bg-soft-info text-info">
                                            {{ $scholar->student ? $scholar->student->year_level : 'No year level' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="bi bi-people display-4 text-muted"></i>
                    <h4 class="mt-3 text-muted">No Scholars Found</h4>
                    <p class="text-muted">There are currently no scholarship recipients to display.</p>
                    <!-- <a href="#" class="btn btn-primary mt-3"> -->
                        <!-- <i class="bi bi-plus-circle me-1"></i> Add New Scholar -->
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    @media print {
        .card-header, .btn {
            display: none !important;
        }
        body {
            background: white !important;
            color: black !important;
        }
        .table {
            width: 100% !important;
        }
    }
</style>

<script>
function printPage() {
    window.print();
}
</script>
@endsection
