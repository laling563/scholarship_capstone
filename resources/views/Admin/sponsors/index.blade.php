@extends('Admin.AdminLayout')

@section('title', 'Sponsors')

@section('styles')
<style>
    /* === SPONSORS PAGE STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --secondary: #7209b7;
        --success: #4cc9f0;
        --warning: #f72585;
        --danger: #e63946;
        --info: #38b000;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === PAGE LAYOUT === */
    .container-fluid {
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        min-height: calc(100vh - 70px);
    }

    /* === MAIN CARD === */
    .card.shadow {
        border: none;
        border-radius: 24px;
        box-shadow: var(--card-shadow) !important;
        background: white;
        overflow: hidden;
        border: 1px solid #f0f3ff;
    }

    /* === CARD HEADER === */
    .card-header.py-3 {
        background: linear-gradient(135deg, #3949ab 0%, #283593 100%) !important;
        color: white;
        border: none;
        padding: 1.5rem 2rem !important;
        border-radius: 24px 24px 0 0 !important;
    }

    .card-header h6 {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: white !important;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header h6::before {
        content: '🤝';
        font-size: 1.5rem;
    }

    /* === CREATE BUTTON === */
    .btn-primary.btn-sm {
        background: white !important;
        color: #3949ab !important;
        border: 2px solid rgba(255, 255, 255, 0.5) !important;
        border-radius: 12px !important;
        padding: 0.6rem 1.5rem !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
        transition: all 0.3s ease !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem;
    }

    .btn-primary.btn-sm:hover {
        background: rgba(255, 255, 255, 0.9) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* === ALERT === */
    .alert-success {
        background: linear-gradient(135deg, #38b000 0%, #2d7d46 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* === TABLE CONTAINER === */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e8edff;
        background: white;
    }

    /* === TABLE HEADER === */
    table.table thead {
        background: linear-gradient(135deg, #5e35b1 0%, #3949ab 100%) !important;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    table.table thead th {
        color: blue !important;
        font-weight: 600 !important;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.25rem 0.75rem !important;
        border: none !important;
        vertical-align: middle !important;
        text-align: left !important;
        white-space: nowrap;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2) !important;
    }

    /* Sponsor Name header */
    table.table thead th:nth-child(1) {
        padding-left: 1.5rem !important;
        min-width: 200px;
        width: 20%;
    }

    /* Email header */
    table.table thead th:nth-child(2) {
        min-width: 180px;
        width: 20%;
    }

    /* Contact header */
    table.table thead th:nth-child(3) {
        min-width: 150px;
        width: 15%;
    }

    /* Username header */
    table.table thead th:nth-child(4) {
        min-width: 150px;
        width: 15%;
    }

    /* Scholarships header */
    table.table thead th:nth-child(5) {
        min-width: 120px;
        width: 10%;
        text-align: center !important;
    }

    /* Actions header */
    table.table thead th:nth-child(6) {
        padding-right: 1.5rem !important;
        min-width: 250px;
        width: 20%;
        text-align: center !important;
    }

    /* === TABLE BODY === */
    table.table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f3ff;
    }

    table.table tbody tr:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(136, 149, 239, 0.02) 100%) !important;
    }

    table.table tbody td {
        padding: 1rem 0.75rem !important;
        vertical-align: middle !important;
        color: #1e293b;
        font-weight: 500;
        border-color: #f0f3ff !important;
    }

    /* Sponsor Name - Left aligned */
    table.table tbody td:nth-child(1) {
        text-align: left !important;
        padding-left: 1.5rem !important;
        font-weight: 600;
        color: #1e293b;
    }

    /* Email - Left aligned */
    table.table tbody td:nth-child(2) {
        text-align: left !important;
        word-break: break-word;
    }

    /* Contact - Left aligned */
    table.table tbody td:nth-child(3) {
        text-align: left !important;
        word-break: break-word;
    }

    /* Username - Left aligned */
    table.table tbody td:nth-child(4) {
        text-align: left !important;
        word-break: break-word;
    }

    /* Scholarships Count - Center and bold */
    table.table tbody td:nth-child(5) {
        text-align: center !important;
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Actions column - Perfectly centered */
    table.table tbody td:nth-child(6) {
        text-align: center !important;
        padding: 1rem !important;
    }

    /* === ACTION BUTTONS === */
    .d-flex.justify-content-center.gap-1 {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 0.5rem !important;
        flex-wrap: nowrap !important;
        margin: 0 !important;
    }

    .btn-info.btn-sm,
    .btn-primary.btn-sm,
    .btn-danger.btn-sm {
        border: none !important;
        border-radius: 8px !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0.5rem;
        min-width: 80px;
        height: 36px;
    }

    .btn-info.btn-sm {
        background: linear-gradient(135deg, var(--info) 0%, #2d7d46 100%) !important;
        color: white !important;
    }

    .btn-primary.btn-sm {
        background: linear-gradient(135deg, var(--primary) 0%, #3a0ca3 100%) !important;
        color: white !important;
    }

    .btn-danger.btn-sm {
        background: linear-gradient(135deg, var(--danger) 0%, #a4161a 100%) !important;
        color: white !important;
    }

    .btn-info.btn-sm:hover,
    .btn-primary.btn-sm:hover,
    .btn-danger.btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15) !important;
    }

    /* Fix form button alignment */
    form {
        margin: 0 !important;
        display: inline !important;
    }

    /* === EMPTY STATE === */
    .fst-italic {
        padding: 3rem 1rem !important;
        color: #64748b !important;
        font-size: 1.1rem;
        font-weight: 500;
        text-align: center;
        background: white;
    }

    .fst-italic i {
        font-size: 3rem !important;
        margin-bottom: 1rem;
        opacity: 0.5;
        display: block;
    }

    /* === PAGINATION === */
    .d-flex.justify-content-center.mt-4 {
        margin-top: 2rem;
    }

    .pagination {
        gap: 0.5rem;
    }

    .page-link {
        border: 1px solid #e8edff;
        border-radius: 8px !important;
        color: var(--primary);
        font-weight: 600;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border-color: var(--primary);
    }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 992px) {
        .container-fluid {
            padding: 1.5rem;
        }

        .card-header.py-3 {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 1.25rem !important;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .card-header.py-3 {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .btn-primary.btn-sm {
            align-self: flex-start;
        }

        /* Stack action buttons vertically on mobile */
        .d-flex.justify-content-center.gap-1 {
            flex-direction: column !important;
            gap: 0.5rem !important;
            align-items: stretch !important;
        }

        .btn-info.btn-sm,
        .btn-primary.btn-sm,
        .btn-danger.btn-sm {
            width: 100% !important;
            justify-content: center !important;
        }

        form {
            width: 100% !important;
        }

        /* Mobile table view */
        .table-responsive {
            border: none;
            background: transparent;
        }

        table.table thead {
            display: none;
        }

        table.table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e8edff;
            border-radius: 16px;
            padding: 1rem;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        table.table tbody td {
            display: block;
            text-align: left !important;
            padding: 0.75rem 0 !important;
            border: none !important;
            border-bottom: 1px solid #f0f3ff !important;
            width: 100% !important;
        }

        table.table tbody td:nth-child(1),
        table.table tbody td:nth-child(2),
        table.table tbody td:nth-child(3),
        table.table tbody td:nth-child(4) {
            padding-left: 0 !important;
            text-align: left !important;
        }

        table.table tbody td:nth-child(5) {
            text-align: left !important;
            font-weight: 600;
        }

        table.table tbody td:nth-child(5)::before {
            content: "Scholarships: ";
            font-weight: 600;
            color: var(--primary);
        }

        table.table tbody td:nth-child(6) {
            border-bottom: none !important;
            padding-top: 1rem !important;
            padding-bottom: 0 !important;
        }

        table.table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 0.25rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">🤝 Manage Sponsors</h6>
            <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Create New Sponsor
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sponsor Name</th>
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
                                <td data-label="Sponsor Name">{{ $sponsor->sponsor_name }}</td>
                                <td data-label="Email">{{ $sponsor->email }}</td>
                                <td data-label="Contact">{{ $sponsor->contact_number ?? 'N/A' }}</td>
                                <td data-label="Username">{{ $sponsor->username }}</td>
                                <td data-label="Scholarships" class="text-center">{{ $sponsor->scholarships->count() }}</td>
                                <td data-label="Actions" class="text-center">
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
                                <td colspan="6" class="text-center fst-italic">
                                    <i class="fas fa-users-slash display-4 text-muted mb-3"></i>
                                    <div>No sponsors found. Add one to get started!</div>
                                </td>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add subtle animation to table rows
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
    });
});
</script>
@endsection
