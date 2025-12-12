@extends('Admin.AdminLayout')

@section('styles')
<style>
    /* === DROPPED APPLICATIONS PAGE STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --secondary: #7209b7;
        --danger: #e63946;
        --warning: #f72585;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === PAGE LAYOUT === */
    .container {
        padding: 2rem;
        max-width: 1400px;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        min-height: 100vh;
    }

    /* === PAGE HEADER === */
    h1 {
        color: var(--primary);
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e8edff;
        position: relative;
    }

    h1::before {
        content: '📉';
        font-size: 1.8rem;
    }

    h1::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg, var(--danger) 0%, var(--warning) 100%);
        border-radius: 2px;
    }

    /* === MAIN CARD CONTAINER === */
    .container > .table {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid #f0f3ff;
        overflow: hidden;
        margin: 0;
    }

    /* === TABLE HEADER === */
    .table.table-striped thead {
        background: linear-gradient(135deg, var(--danger) 0%, var(--warning) 100%);
    }

    .table.table-striped thead th {
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.25rem 1.5rem;
        border: none;
        position: relative;
        white-space: nowrap;
    }

    .table.table-striped thead th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: rgba(255, 255, 255, 0.2);
    }

    /* === TABLE BODY === */
    .table.table-striped tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f3ff;
    }

    .table.table-striped tbody tr:nth-child(odd) {
        background: rgba(248, 249, 255, 0.5);
    }

    .table.table-striped tbody tr:nth-child(even) {
        background: white;
    }

    .table.table-striped tbody tr:hover {
        background: linear-gradient(135deg, rgba(230, 57, 70, 0.05) 0%, rgba(247, 37, 133, 0.03) 100%);
        transform: translateX(3px);
    }

    .table.table-striped tbody tr:last-child {
        border-bottom: none;
    }

    .table.table-striped tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border: none;
        position: relative;
    }

    /* Student Name Column */
    .table.table-striped tbody td:first-child {
        font-weight: 600;
        color: #1e293b;
        min-width: 200px;
    }

    /* Scholarship Column */
    .table.table-striped tbody td:nth-child(2) {
        min-width: 250px;
    }

    /* Date Column */
    .table.table-striped tbody td:last-child {
        font-weight: 500;
        color: #64748b;
        white-space: nowrap;
        position: relative;
    }

    .table.table-striped tbody td:last-child::before {
        content: '📅';
        margin-right: 0.5rem;
        opacity: 0.7;
    }

    /* === EMPTY STATE === */
    .table.table-striped tbody tr td.text-center {
        padding: 3rem 1.5rem;
        background: white;
    }

    .table.table-striped tbody tr td.text-center {
        color: #94a3b8;
        font-size: 1.1rem;
        font-weight: 500;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        border-radius: 0 0 20px 20px;
    }

    .table.table-striped tbody tr td.text-center::before {
        content: '📭';
        font-size: 3rem;
        opacity: 0.5;
        margin-bottom: 0.5rem;
    }

    /* === DROPPED BADGE (optional enhancement) === */
    .dropped-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, rgba(230, 57, 70, 0.1) 0%, rgba(247, 37, 133, 0.05) 100%);
        color: var(--danger);
        border: 1px solid rgba(230, 57, 70, 0.2);
        border-radius: 20px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 1rem;
        white-space: nowrap;
    }

    .dropped-badge::before {
        content: '❌';
        font-size: 0.8rem;
    }

    /* === STATS HEADER (optional enhancement) === */
    .stats-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        border: 1px solid #f0f3ff;
        box-shadow: var(--card-shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--hover-shadow);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--danger) 0%, var(--warning) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .stat-content h3 {
        color: var(--danger);
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
        line-height: 1;
    }

    .stat-content p {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0.25rem 0 0;
        font-weight: 500;
    }

    /* === ANIMATIONS === */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table.table-striped tbody tr {
        animation: fadeIn 0.3s ease forwards;
        opacity: 0;
    }

    .table.table-striped tbody tr:nth-child(1) { animation-delay: 0.05s; }
    .table.table-striped tbody tr:nth-child(2) { animation-delay: 0.1s; }
    .table.table-striped tbody tr:nth-child(3) { animation-delay: 0.15s; }
    .table.table-striped tbody tr:nth-child(4) { animation-delay: 0.2s; }
    .table.table-striped tbody tr:nth-child(5) { animation-delay: 0.25s; }
    .table.table-striped tbody tr:nth-child(6) { animation-delay: 0.3s; }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 992px) {
        .container {
            padding: 1.5rem;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .stats-header {
            gap: 1rem;
        }

        .stat-card {
            padding: 0.875rem 1.25rem;
        }

        .stat-content h3 {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        h1 {
            font-size: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        h1::after {
            width: 60px;
        }

        .table.table-striped thead {
            display: none;
        }

        .table.table-striped tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e8edff;
            border-radius: 16px;
            padding: 1rem;
        }

        .table.table-striped tbody tr:nth-child(odd),
        .table.table-striped tbody tr:nth-child(even) {
            background: white;
        }

        .table.table-striped tbody tr:hover {
            background: rgba(248, 249, 255, 0.8);
            transform: translateX(2px);
        }

        .table.table-striped tbody td {
            display: block;
            text-align: left;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f3ff;
        }

        .table.table-striped tbody td:last-child {
            border-bottom: none;
        }

        .table.table-striped tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 0.25rem;
        }

        .table.table-striped tbody td:last-child::before {
            content: '📅 Date Dropped';
            display: block;
        }

        .dropped-badge {
            display: block;
            margin: 0.5rem 0 0;
            width: fit-content;
        }

        .stats-header {
            flex-direction: column;
            align-items: stretch;
        }

        .stat-card {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 1.3rem;
        }

        .table.table-striped tbody tr {
            padding: 0.875rem;
        }

        .table.table-striped tbody td {
            font-size: 0.95rem;
        }

        .stat-card {
            padding: 0.75rem 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .stat-content h3 {
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="stats-header">
        <h1>📉 Dropped Applications</h1>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $droppedStudents->count() }}</h3>
                <p>Total Dropped</p>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Scholarship</th>
                            <th>Date Dropped</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($droppedStudents as $application)
                            <tr>
                                <td data-label="Student Name">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user-circle text-muted" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $application->student->fname }} {{ $application->student->lname }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $application->student->student_id ?? 'N/A' }}</small>
                                        </div>
                                        <span class="dropped-badge ms-auto">Dropped</span>
                                    </div>
                                </td>
                                <td data-label="Scholarship">
                                    <div class="fw-semibold">{{ $application->scholarship->title }}</div>
                                    <small class="text-muted">{{ $application->scholarship->type ?? 'N/A' }}</small>
                                </td>
                                <td data-label="Date Dropped">
                                    <div class="fw-medium">{{ $application->updated_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $application->updated_at->format('h:i A') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-inbox display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Dropped Applications</h5>
                                    <p class="text-muted mb-0">No students have been dropped from scholarships.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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

    // Highlight the most recent drops (last 7 days)
    const rows = document.querySelectorAll('.table tbody tr:not(:first-child)');
    const sevenDaysAgo = new Date();
    sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);

    rows.forEach(row => {
        const dateCell = row.querySelector('td:last-child div');
        if (dateCell) {
            const dateText = dateCell.textContent.trim();
            const rowDate = new Date(dateText);

            if (rowDate > sevenDaysAgo) {
                row.style.borderLeft = '4px solid var(--danger)';
                row.style.background = 'linear-gradient(135deg, rgba(230, 57, 70, 0.08) 0%, rgba(247, 37, 133, 0.04) 100%)';
            }
        }
    });
});
</script>
@endsection
