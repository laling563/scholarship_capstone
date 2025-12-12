@extends('Admin.AdminLayout')

@section('styles')
<style>
    /* === SCHOLARS PAGE STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --secondary: #7209b7;
        --success: #4cc9f0;
        --warning: #f72585;
        --danger: #e63946;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === PAGE LAYOUT === */
    .container-fluid.py-4 {
        padding: 2rem !important;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        min-height: 100vh;
    }

    /* === HEADER CARD === */
    .card.shadow-sm.border-2 {
        border: none !important;
        border-radius: 20px;
        box-shadow: var(--card-shadow) !important;
        background: white;
        overflow: hidden;
        border: 1px solid #f0f3ff !important;
        transition: all 0.3s ease;
    }

    .card.shadow-sm.border-2:hover {
        box-shadow: var(--hover-shadow) !important;
    }

    .card-header.bg-primary.text-white {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        color: white;
        border: none;
        padding: 1.5rem 2rem;
        border-radius: 20px 20px 0 0 !important;
        position: relative;
        overflow: hidden;
    }

    .card-header.bg-primary.text-white::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.3;
    }

    .card-header h3 {
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .card-header h3::before {
        content: '🏆';
        font-size: 1.3rem;
    }

    .card-header p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0.25rem 0 0;
        position: relative;
        z-index: 1;
    }

    /* === PRINT BUTTON === */
    .btn.btn-light.btn-sm {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
        border: none !important;
        border-radius: 10px !important;
        padding: 0.5rem 1.25rem !important;
        color: var(--primary) !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1) !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .btn.btn-light.btn-sm:hover {
        background: white !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15) !important;
    }

    /* === MAIN CONTENT CARD === */
    .card.shadow-sm.border-0 {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow) !important;
        background: white;
        overflow: hidden;
        border: 1px solid #f0f3ff !important;
        margin-top: 1.5rem;
    }

    .card-body.p-0 {
        border-radius: 0 0 20px 20px;
        overflow: hidden;
    }

    /* === TABLE STYLES === */
    .table-responsive {
        border-radius: 0 0 20px 20px;
        overflow: hidden;
    }

    .table.table-hover.align-middle.mb-0 {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    /* === TABLE HEADER === */
    .table.table-hover.align-middle.mb-0 thead {
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        border-bottom: 2px solid #e8edff;
    }

    .table.table-hover.align-middle.mb-0 thead th {
        color: var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.25rem 1.5rem;
        border: none;
        position: relative;
        white-space: nowrap;
    }

    .table.table-hover.align-middle.mb-0 thead th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: linear-gradient(180deg, #e8edff 0%, #ffffff 100%);
    }

    .table.table-hover.align-middle.mb-0 thead th:first-child {
        padding-left: 2rem;
    }

    /* === TABLE BODY === */
    .table.table-hover.align-middle.mb-0 tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f3ff;
    }

    .table.table-hover.align-middle.mb-0 tbody tr:last-child {
        border-bottom: none;
    }

    .table.table-hover.align-middle.mb-0 tbody tr:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(136, 149, 239, 0.01) 100%);
        transform: translateX(3px);
    }

    .table.table-hover.align-middle.mb-0 tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        color: #1e293b;
        font-weight: 500;
        border: none;
    }

    .table.table-hover.align-middle.mb-0 tbody td:first-child {
        padding-left: 2rem;
        font-weight: 700;
        color: var(--primary);
        font-size: 1.1rem;
        width: 60px;
    }

    /* === STUDENT COLUMN === */
    .table.table-hover.align-middle.mb-0 tbody td:nth-child(2) {
        min-width: 250px;
    }

    .table.table-hover.align-middle.mb-0 tbody td:nth-child(2) h6 {
        color: #1e293b;
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
        line-height: 1.4;
    }

    .table.table-hover.align-middle.mb-0 tbody td:nth-child(2) small {
        color: #64748b;
        font-size: 0.85rem;
        display: block;
        margin-top: 0.25rem;
    }

    /* === SCHOLARSHIP BADGE === */
    .badge.bg-soft-primary.text-primary {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(136, 149, 239, 0.05) 100%) !important;
        color: var(--primary) !important;
        border: 1px solid rgba(67, 97, 238, 0.2) !important;
        border-radius: 20px !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: normal;
        max-width: 250px;
        word-break: break-word;
        line-height: 1.4;
    }

    .badge.bg-soft-primary.text-primary::before {
        content: '🎓';
        font-size: 0.9rem;
    }

    /* === COURSE COLUMN === */
    .table.table-hover.align-middle.mb-0 tbody td:nth-child(4) {
        color: #475569;
        font-weight: 600;
        min-width: 150px;
    }

    /* === YEAR LEVEL BADGE === */
    .badge.bg-soft-info.text-info {
        background: linear-gradient(135deg, rgba(114, 9, 183, 0.1) 0%, rgba(163, 12, 58, 0.05) 100%) !important;
        color: var(--secondary) !important;
        border: 1px solid rgba(114, 9, 183, 0.2) !important;
        border-radius: 20px !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .badge.bg-soft-info.text-info::before {
        content: '📅';
        font-size: 0.9rem;
    }

    /* === EMPTY STATE === */
    .card-body.text-center.py-5 {
        padding: 4rem 2rem !important;
        background: white;
    }

    .bi-people.display-4.text-muted {
        font-size: 4rem;
        color: #e8edff !important;
        margin-bottom: 1.5rem;
        display: inline-block;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        padding: 2rem;
        border-radius: 50%;
        border: 2px dashed #e8edff;
    }

    .card-body.text-center.py-5 h4 {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 1.3rem;
    }

    .card-body.text-center.py-5 p {
        color: #94a3b8;
        font-size: 0.95rem;
        max-width: 400px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.75rem 2rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2) !important;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3) !important;
        color: white !important;
    }

    .btn-primary::before {
        content: '➕';
        font-size: 1rem;
    }

    /* === COUNTER BADGE (if you want to show total count) === */
    .scholar-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: white;
        border-radius: 12px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        margin-left: 1rem;
        box-shadow: 0 3px 10px rgba(67, 97, 238, 0.2);
    }

    /* === PRINT STYLES === */
    @media print {
        .container-fluid.py-4 {
            background: white !important;
            padding: 1rem !important;
        }

        .card-header, .btn {
            display: none !important;
        }

        .card.shadow-sm.border-0 {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .table.table-hover.align-middle.mb-0 thead {
            background: #f8f9fa !important;
        }

        .table.table-hover.align-middle.mb-0 thead th {
            color: #000 !important;
        }

        .table.table-hover.align-middle.mb-0 tbody tr:hover {
            background: none !important;
            transform: none !important;
        }

        .badge {
            background: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
        }

        .badge::before {
            display: none !important;
        }
    }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 768px) {
        .container-fluid.py-4 {
            padding: 1rem !important;
        }

        .card-header.bg-primary.text-white {
            padding: 1.25rem 1.5rem;
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start !important;
        }

        .card-header h3 {
            font-size: 1.3rem;
        }

        .btn.btn-light.btn-sm {
            align-self: flex-start;
        }

        .table-responsive {
            border-radius: 0;
        }

        .table.table-hover.align-middle.mb-0 thead {
            display: none;
        }

        .table.table-hover.align-middle.mb-0 tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e8edff;
            border-radius: 12px;
            padding: 1rem;
        }

        .table.table-hover.align-middle.mb-0 tbody td {
            display: block;
            text-align: left;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f3ff;
        }

        .table.table-hover.align-middle.mb-0 tbody td:first-child {
            padding-left: 0;
            font-size: 1rem;
            width: auto;
            border-bottom: none;
            margin-bottom: 0.5rem;
        }

        .table.table-hover.align-middle.mb-0 tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 0.25rem;
        }

        .table.table-hover.align-middle.mb-0 tbody td:last-child {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            margin-top: 0.25rem;
        }

        .card-body.text-center.py-5 {
            padding: 3rem 1rem !important;
        }

        .bi-people.display-4.text-muted {
            font-size: 3rem;
            padding: 1.5rem;
        }
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

    .table.table-hover.align-middle.mb-0 tbody tr {
        animation: fadeIn 0.3s ease forwards;
        opacity: 0;
    }

    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(1) { animation-delay: 0.05s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(2) { animation-delay: 0.1s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(3) { animation-delay: 0.15s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(4) { animation-delay: 0.2s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(5) { animation-delay: 0.25s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(6) { animation-delay: 0.3s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(7) { animation-delay: 0.35s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(8) { animation-delay: 0.4s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(9) { animation-delay: 0.45s; }
    .table.table-hover.align-middle.mb-0 tbody tr:nth-child(10) { animation-delay: 0.5s; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-2">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">🏆 Scholars</h3>
                        <p class="mb-0 small">List of all scholarship recipients</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        @if($scholars->count())
                        <span class="scholar-count">
                            <i class="bi bi-person-fill me-1"></i> {{ $scholars->count() }} Scholars
                        </span>
                        @endif
                        <button onclick="printPage()" class="btn btn-light btn-sm">
                            <i class="bi bi-printer me-1"></i> Print List
                        </button>
                    </div>
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
                                    <td class="ps-4 fw-bold" data-label="No.">{{ $index + 1 }}</td>
                                    <td data-label="Student">
                                        <div>
                                            <h6 class="mb-0">{{ $scholar->student ? $scholar->student->fname . ' ' . $scholar->student->lname : 'No student' }}</h6>
                                            <small class="text-muted">{{ $scholar->student ? $scholar->student->email : '' }}</small>
                                        </div>
                                    </td>
                                    <td data-label="Scholarship">
                                        <span class="badge bg-soft-primary text-primary">
                                            {{ $scholar->scholarship ? $scholar->scholarship->title : 'No scholarship' }}
                                        </span>
                                    </td>
                                    <td data-label="Course">{{ $scholar->student ? $scholar->student->course : 'No course' }}</td>
                                    <td data-label="Year Level">
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
                    <div class="mt-4">
                        <p class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>
                            Scholars will appear here once applications are approved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function printPage() {
    // Add print-specific styling
    const printStyle = document.createElement('style');
    printStyle.innerHTML = `
        @media print {
            body * {
                visibility: hidden;
            }
            .card.shadow-sm.border-0,
            .card.shadow-sm.border-0 * {
                visibility: visible;
            }
            .card.shadow-sm.border-0 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
                border: none !important;
            }
            .table-responsive {
                overflow: visible !important;
            }
            .badge {
                background: #f8f9fa !important;
                color: #000 !important;
                border: 1px solid #ddd !important;
            }
            .table.table-hover.align-middle.mb-0 thead {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }
    `;
    document.head.appendChild(printStyle);

    window.print();

    // Remove the style after printing
    setTimeout(() => {
        document.head.removeChild(printStyle);
    }, 100);
}
</script>
@endsection
