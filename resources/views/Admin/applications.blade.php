@extends('Admin.AdminLayout')

@section('styles')
<style>
    /* === FRESH DESIGN STYLES === */
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

    /* === PAGE HEADER === */
    .container.py-5 {
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
        max-width: 1400px;
    }

    h2.fw-bold.text-primary {
        color: var(--primary) !important;
        font-size: 1.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        padding: 0.5rem 0;
    }

    h2.fw-bold.text-primary::before {
        content: '📋';
        font-size: 1.5rem;
    }

    /* === ALERT STYLES === */
    .alert-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 20px rgba(76, 201, 240, 0.15);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success::before {
        content: '✅';
        font-size: 1.2rem;
    }

    /* === MAIN CARD === */
    .card.shadow-lg.border-0.rounded-3 {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow) !important;
        background: #fff;
        overflow: hidden;
        border: 1px solid #f0f3ff;
        transition: all 0.3s ease;
        margin: 0 auto;
    }

    .card.shadow-lg.border-0.rounded-3:hover {
        box-shadow: var(--hover-shadow) !important;
    }

    /* === TABLE CONTAINER === */
    .table-responsive {
        border-radius: 0 0 20px 20px;
        overflow: hidden;
    }

    /* === TABLE HEADER === */
    .table-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
    }

    .table-primary th {
        color: black;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border: none;
        position: relative;
        vertical-align: middle;
        text-align: center;
    }

    .table-primary th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: rgba(255, 255, 255, 0.2);
    }

    /* === TABLE BODY - IMPROVED ALIGNMENT === */
    .table.align-middle.table-hover.text-center {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .table.align-middle.table-hover.text-center tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f3ff;
    }

    .table.align-middle.table-hover.text-center tbody tr:hover {
        background: #f8f9ff;
        transform: translateX(2px);
    }

    /* === CHANGED TO BLACK TEXT === */
    .table.align-middle.table-hover.text-center tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        color: #000000 !important; /* Changed from #475569 to black */
        font-weight: 500;
        text-align: center;
        line-height: 1.4;
    }

    /* Student ID Column - CHANGED TO BLACK */
    .table.align-middle.table-hover.text-center tbody td:first-child {
        font-weight: 600;
        color: #000000 !important; /* Changed from var(--primary) to black */
        font-family: 'Courier New', monospace;
    }

    /* Student Name Column - CHANGED TO BLACK */
    .table.align-middle.table-hover.text-center tbody td:nth-child(2) {
        text-align: left;
        padding-left: 1rem;
        color: #000000 !important; /* Added black color */
    }

    /* Scholarship Column - CHANGED TO BLACK */
    .table.align-middle.table-hover.text-center tbody td:nth-child(3) {
        text-align: left;
        max-width: 250px;
        word-wrap: break-word;
        color: #000000 !important; /* Added black color */
    }

    /* Status Column - CHANGED TO BLACK */
    .table.align-middle.table-hover.text-center tbody td:nth-child(4) {
        text-align: center;
        color: #000000 !important; /* Added black color */
    }

    /* Date Column - CHANGED TO BLACK */
    .table.align-middle.table-hover.text-center tbody td:nth-child(5) {
        text-align: center;
        white-space: nowrap;
        color: #000000 !important; /* Added black color */
    }

    /* Actions Column */
    .table.align-middle.table-hover.text-center tbody td:last-child {
        text-align: center;
        min-width: 280px;
    }

    /* === STATUS BADGES - IMPROVED ALIGNMENT === */
    .badge {
        padding: 0.5rem 1rem !important;
        border-radius: 20px !important;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 90px;
        height: 32px;
    }

    .bg-success {
        background: linear-gradient(135deg, var(--success) 0%, #3a0ca3 100%) !important;
        color: white !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, var(--warning) 0%, #b5179e 100%) !important;
        color: white !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #a4161a 100%) !important;
        color: white !important;
    }

    .bg-info {
        background: linear-gradient(135deg, var(--secondary) 0%, #3a0ca3 100%) !important;
        color: white !important;
    }

    .bg-secondary {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;
        color: white !important;
    }

    /* === ACTION BUTTONS - IMPROVED ALIGNMENT === */
    .d-flex.justify-content-center.align-items-center {
        gap: 0.5rem;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        min-height: 40px;
    }

    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-danger {
        min-width: 80px;
        height: 36px;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0.5rem !important;
        white-space: nowrap;
    }

    .btn-outline-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2) !important;
    }

    .btn-outline-primary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(67, 97, 238, 0.3) !important;
        color: white !important;
    }

    .btn-outline-success {
        background: linear-gradient(135deg, var(--success) 0%, #3a0ca3 100%);
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(76, 201, 240, 0.2) !important;
    }

    .btn-outline-success:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(76, 201, 240, 0.3) !important;
        color: white !important;
    }

    .btn-outline-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #a4161a 100%);
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(230, 57, 70, 0.2) !important;
    }

    .btn-outline-danger:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(230, 57, 70, 0.3) !important;
        color: white !important;
    }

    /* === TABLE ROW COLORS === */
    .table-success {
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.08) 0%, rgba(58, 12, 163, 0.03) 100%) !important;
    }

    .table-danger {
        background: linear-gradient(135deg, rgba(230, 57, 70, 0.08) 0%, rgba(164, 22, 26, 0.03) 100%) !important;
    }

    .table-warning {
        background: linear-gradient(135deg, rgba(247, 37, 133, 0.08) 0%, rgba(181, 23, 158, 0.03) 100%) !important;
    }

    /* === MODAL STYLES - IMPROVED ALIGNMENT === */
    .modal-content.border-0.shadow-lg.rounded-4 {
        border: none;
        border-radius: 20px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
        overflow: hidden;
    }

    .modal-header.bg-primary.text-white {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        color: white;
        border: none;
        padding: 1.5rem 2rem;
        border-radius: 20px 20px 0 0 !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title.fw-semibold {
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    .modal-title.fw-semibold::before {
        content: '👤';
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        margin: 0;
    }

    .btn-close-white:hover {
        opacity: 1;
    }

    /* === MODAL BODY - IMPROVED ALIGNMENT === */
    .modal-body.p-4 {
        background: #f8f9ff;
        padding: 2rem !important;
    }

    section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e8edff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
    }

    h5.text-primary.fw-semibold.mb-3 {
        color: var(--primary) !important;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f0f3ff;
    }

    h5.text-primary.fw-semibold.mb-3::before {
        content: '📋';
        font-size: 1rem;
    }

    /* Application Info Grid */
    .p-3.border.rounded.bg-light {
        background: #f8f9ff !important;
        border: 1px solid #e8edff !important;
        border-radius: 12px !important;
        padding: 1.5rem !important;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .p-3.border.rounded.bg-light div {
        padding: 0.5rem 0;
        color: #000000 !important; /* Changed to black */
        border-bottom: 1px solid #e8edff;
        display: flex;
        align-items: flex-start;
        min-height: 40px;
    }

    .p-3.border.rounded.bg-light div:last-child {
        border-bottom: none;
    }

    .p-3.border.rounded.bg-light strong {
        color: var(--primary);
        font-weight: 600;
        min-width: 120px;
        display: inline-block;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .p-3.border.rounded.bg-light span {
        flex: 1;
        word-break: break-word;
        color: #000000 !important; /* Changed to black */
    }

    /* Family Section - Improved Alignment */
    .row.g-3 {
        display: flex;
        align-items: stretch;
        margin: 0 -0.75rem;
    }

    .col-md-6 {
        padding: 0 0.75rem;
        display: flex;
    }

    .col-md-6 .p-3.border.rounded.bg-light.h-100 {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    h6.fw-bold.text-secondary.mb-2 {
        color: var(--secondary) !important;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e8edff;
    }

    h6.fw-bold.text-secondary.mb-2::before {
        content: '👨';
    }

    .col-md-6:nth-child(2) h6.fw-bold.text-secondary.mb-2::before {
        content: '👩';
    }

    .col-md-6 .p-3.border.rounded.bg-light.h-100 p {
        margin: 0.5rem 0;
        display: flex;
        align-items: baseline;
        min-height: 32px;
    }

    .col-md-6 .p-3.border.rounded.bg-light.h-100 p strong {
        color: var(--primary);
        font-weight: 600;
        min-width: 100px;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .col-md-6 .p-3.border.rounded.bg-light.h-100 p span {
        flex: 1;
        color: #000000 !important; /* Changed to black */
        font-weight: 500;
    }

    /* Stats Grid - Improved Alignment */
    .row.mt-3.g-3.text-center {
        margin: 1.5rem -0.75rem 0;
        display: flex;
        justify-content: center;
    }

    .row.mt-3.g-3.text-center .col-md-4 {
        padding: 0 0.75rem;
        flex: 1;
        max-width: 200px;
        min-width: 150px;
    }

    .row.mt-3.g-3.text-center .col-md-4 .p-3.border.rounded.bg-light {
        background: white !important;
        border: 1px solid #e8edff !important;
        border-radius: 12px !important;
        padding: 1.5rem 1rem !important;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .row.mt-3.g-3.text-center .col-md-4 .p-3.border.rounded.bg-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .row.mt-3.g-3.text-center .col-md-4 .p-3.border.rounded.bg-light strong {
        color: var(--primary);
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        display: block;
        text-align: center;
    }

    .row.mt-3.g-3.text-center .col-md-4 .p-3.border.rounded.bg-light p {
        color: #000000 !important; /* Changed to black */
        font-size: 1.75rem;
        font-weight: 800;
        margin: 0;
        line-height: 1;
    }

    /* Notes Section */
    .p-3.bg-light.rounded {
        background: #f8f9ff !important;
        border: 1px solid #e8edff !important;
        border-radius: 12px !important;
        padding: 1.5rem !important;
        color: #000000 !important; /* Changed to black */
        font-size: 0.95rem;
        line-height: 1.6;
        min-height: 120px;
    }

    /* Documents Section */
    .list-group.list-group-flush {
        background: white;
        border-radius: 12px;
        border: 1px solid #e8edff;
        overflow: hidden;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid #e8edff;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .list-group-item:hover {
        background: #f8f9ff;
        padding-left: 1.75rem;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-item a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
    }

    .list-group-item a:hover {
        color: var(--secondary);
        text-decoration: underline;
    }

    .list-group-item a::before {
        content: '📄';
        font-size: 1.1rem;
    }

    .text-muted.text-center {
        color: #94a3b8 !important;
        padding: 3rem 1rem !important;
        text-align: center;
    }

    .text-muted.text-center::before {
        content: '📁';
        font-size: 2rem;
        display: block;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* === MODAL FOOTER === */
    .modal-footer {
        border: none;
        padding: 1.5rem 2rem;
        background: #f8f9ff;
        border-radius: 0 0 20px 20px;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-outline-secondary {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 0.75rem 2.5rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        min-width: 120px;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(100, 116, 139, 0.3) !important;
        color: white !important;
    }

    /* === HR STYLES === */
    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, #e8edff 0%, #f0f3ff 100%);
        margin: 2rem 0;
    }

    /* === ICONS === */
    .bi::before, [class*="bi-"]::before {
        font-size: 1rem;
    }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 1200px) {
        .table.align-middle.table-hover.text-center tbody td:nth-child(3) {
            max-width: 200px;
        }
    }

    @media (max-width: 992px) {
        .table.align-middle.table-hover.text-center tbody td:last-child {
            min-width: 250px;
        }

        .d-flex.justify-content-center.align-items-center {
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-danger {
            min-width: 70px;
            font-size: 0.8rem !important;
            padding: 0.4rem 0.75rem !important;
        }
    }

    @media (max-width: 768px) {
        .container.py-5 {
            padding: 1.5rem 1rem !important;
        }

        h2.fw-bold.text-primary {
            font-size: 1.5rem;
        }

        .d-flex.justify-content-center.align-items-center {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-danger {
            width: 100%;
            justify-content: center;
            height: 40px;
        }

        .table.align-middle.table-hover.text-center tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.9rem;
            color: #000000 !important; /* Added for mobile */
        }

        .table.align-middle.table-hover.text-center tbody td:last-child {
            min-width: auto;
        }

        .badge {
            padding: 0.4rem 0.75rem !important;
            min-width: 80px;
            font-size: 0.75rem;
        }

        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-body.p-4 {
            padding: 1.25rem !important;
        }

        section {
            padding: 1.25rem;
        }

        .modal-header.bg-primary.text-white {
            padding: 1.25rem;
        }

        .p-3.border.rounded.bg-light {
            grid-template-columns: 1fr;
            padding: 1.25rem !important;
        }

        .row.g-3 {
            flex-direction: column;
            gap: 1rem;
        }

        .col-md-6 {
            width: 100%;
        }

        .row.mt-3.g-3.text-center {
            flex-direction: column;
            align-items: stretch;
        }

        .row.mt-3.g-3.text-center .col-md-4 {
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .row.mt-3.g-3.text-center .col-md-4:last-child {
            margin-bottom: 0;
        }

        .list-group-item {
            padding: 0.75rem 1rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .list-group-item a {
            width: 100%;
        }

        .modal-footer {
            padding: 1.25rem;
            flex-direction: column;
        }

        .btn-outline-secondary {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .table.align-middle.table-hover.text-center thead {
            display: none;
        }

        .table.align-middle.table-hover.text-center tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e8edff;
            border-radius: 12px;
            padding: 1rem;
        }

        .table.align-middle.table-hover.text-center tbody td {
            display: block;
            text-align: left;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f3ff;
            color: #000000 !important; /* Added for mobile */
        }

        .table.align-middle.table-hover.text-center tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 0.25rem;
        }

        .table.align-middle.table-hover.text-center tbody td:last-child {
            border-bottom: none;
            padding-top: 1rem;
        }

        .table.align-middle.table-hover.text-center tbody td:last-child:before {
            display: none;
        }

        .badge {
            display: inline-block;
            margin-top: 0.25rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">🎓 Scholarship Applications</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover text-center">
                    <thead class="table-primary">
                        <tr class="align-middle">
                            <th style="width: 10%">Student ID</th>
                            <th style="width: 20%">Full Name</th>
                            <th style="width: 20%">Scholarship</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 15%">Applied At</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                        <tr class="align-middle
                            @if($application->status == 'Approved') table-success
                            @elseif($application->status == 'Rejected') table-danger
                            @elseif($application->status == 'Pending') table-warning
                            @endif">

                            <td>{{ $application->student->student_id }}</td>
                            <td>{{ $application->student->fname }} {{ $application->student->lname }}</td>
                            <td>{{ $application->scholarship->title }}</td>
                            <td>
                                <span class="badge
                                    @if($application->status == 'Approved') bg-success
                                    @elseif($application->status == 'Pending') bg-warning text-dark
                                    @elseif($application->status == 'Rejected') bg-danger
                                    @elseif($application->status == 'Endorsed') bg-info text-dark
                                    @else bg-secondary @endif px-3 py-2">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                            <td class="d-flex justify-content-center align-items-center" style="gap: 0.5rem;">
                                <button type="button"
                                    class="btn btn-outline-primary btn-sm viewBtn px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#applicationModal"

                                    data-id="{{ $application->id }}"
                                    data-scholarship="{{ $application->scholarship->title }}"
                                    data-student="{{ $application->student->fname }} {{ $application->student->lname }}"
                                    data-status="{{ $application->status }}"
                                    data-applied="{{ $application->created_at }}"

                                    data-dob="{{ $application->date_of_birth }}"
                                    data-civil="{{ $application->civil_status }}"
                                    data-birthplace="{{ $application->place_of_birth }}"
                                    data-religion="{{ $application->religion }}"
                                    data-height="{{ $application->height }}"
                                    data-weight="{{ $application->weight }}"
                                    data-home="{{ $application->home_address }}"
                                    data-contact="{{ $application->contact_address }}"
                                    data-boarding="{{ $application->boarding_address }}"
                                    data-landlord="{{ $application->landlord_landlady }}"
                                    data-hs="{{ $application->high_school_graduated }}"
                                    data-hsyear="{{ $application->high_school_year_graduated }}"
                                    data-skills="{{ $application->special_skills }}"
                                    data-curriculum="{{ $application->curriculum_year }}"

                                    data-father="{{ $application->father_first_name }} {{ $application->father_middle_name }} {{ $application->father_last_name }}"
                                    data-foccupation="{{ $application->father_occupation }}"
                                    data-fincome="{{ $application->father_monthly_income }}"
                                    data-fedu="{{ $application->father_educational_attainment }}"
                                    data-fschool="{{ $application->father_school_graduated }}"
                                    data-fyear="{{ $application->father_year_graduated }}"

                                    data-mother="{{ $application->mother_first_name }} {{ $application->mother_middle_name }} {{ $application->mother_last_name }}"
                                    data-moccupation="{{ $application->mother_occupation }}"
                                    data-mincome="{{ $application->mother_monthly_income }}"
                                    data-medu="{{ $application->mother_educational_attainment }}"
                                    data-mschool="{{ $application->mother_school_graduated }}"
                                    data-myear="{{ $application->mother_year_graduated }}"

                                    data-brothers="{{ $application->number_of_brothers }}"
                                    data-sisters="{{ $application->number_of_sisters }}"
                                    data-totalincome="{{ $application->total_monthly_income }}"

                                    data-notes="{{ $application->notes }}"
                                    data-documents='@json($application->documents)'
                                >
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <form action="{{ route('admin.applications.accept', $application) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Accept
                                    </button>
                                </form>
                                <form action="{{ route('admin.applications.reject', $application) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">Application Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Application Info</h5>
                    <div class="p-3 border rounded bg-light">
                        <div><strong>ID:</strong> <span id="appId"></span></div>
                        <div><strong>Scholarship:</strong> <span id="appScholarship"></span></div>
                        <div><strong>Student:</strong> <span id="appStudent"></span></div>
                        <div><strong>Status:</strong> <span id="appStatus"></span></div>
                        <div><strong>Applied At:</strong> <span id="appApplied"></span></div>
                    </div>
                </section>

                <hr>

                <!-- Personal Info -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Personal Information</h5>
                    <div class="p-3 border rounded bg-light">
                        <div><strong>Date of Birth:</strong> <span id="appDob"></span></div>
                        <div><strong>Civil Status:</strong> <span id="appCivil"></span></div>
                        <div><strong>Place of Birth:</strong> <span id="appBirthplace"></span></div>
                        <div><strong>Religion:</strong> <span id="appReligion"></span></div>
                        <div><strong>Height:</strong> <span id="appHeight"></span></div>
                        <div><strong>Weight:</strong> <span id="appWeight"></span></div>
                        <div><strong>Home Address:</strong> <span id="appHome"></span></div>
                        <div><strong>Contact Address:</strong> <span id="appContact"></span></div>
                        <div><strong>Boarding Address:</strong> <span id="appBoarding"></span></div>
                        <div><strong>Landlord:</strong> <span id="appLandlord"></span></div>
                        <div><strong>High School:</strong> <span id="appHs"></span></div>
                        <div><strong>Year Graduated:</strong> <span id="appHsYear"></span></div>
                    </div>
                </section>

                <hr>

                <!-- Family -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Family Background</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light h-100">
                                <h6 class="fw-bold text-secondary mb-2">Father</h6>
                                <p><strong>Name:</strong> <span id="appFather"></span></p>
                                <p><strong>Occupation:</strong> <span id="appFOccupation"></span></p>
                                <p><strong>Monthly Income:</strong> ₱<span id="appFIncome"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light h-100">
                                <h6 class="fw-bold text-secondary mb-2">Mother</h6>
                                <p><strong>Name:</strong> <span id="appMother"></span></p>
                                <p><strong>Occupation:</strong> <span id="appMOccupation"></span></p>
                                <p><strong>Monthly Income:</strong> ₱<span id="appMIncome"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 g-3 text-center">
                        <div class="col-md-4"><div class="p-3 border rounded bg-light"><strong>Brothers:</strong> <p id="appBrothers"></p></div></div>
                        <div class="col-md-4"><div class="p-3 border rounded bg-light"><strong>Sisters:</strong> <p id="appSisters"></p></div></div>
                        <div class="col-md-4"><div class="p-3 border rounded bg-light"><strong>Total Monthly Income:</strong> ₱<p id="appTotalIncome"></p></div></div>
                    </div>
                </section>

                <hr>

                <!-- Notes -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Notes</h5>
                    <div class="p-3 bg-light rounded" id="appNotes"></div>
                </section>

                <hr>

                <!-- Documents -->
                <section>
                    <h5 class="text-primary fw-semibold mb-3">Application Documents</h5>
                    <ul id="appDocuments" class="list-group list-group-flush"></ul>
                </section>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.viewBtn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('appId').innerText = button.dataset.id;
        document.getElementById('appScholarship').innerText = button.dataset.scholarship;
        document.getElementById('appStudent').innerText = button.dataset.student;
        document.getElementById('appStatus').innerText = button.dataset.status;
        document.getElementById('appApplied').innerText = button.dataset.applied;
        document.getElementById('appDob').innerText = button.dataset.dob;
        document.getElementById('appCivil').innerText = button.dataset.civil;
        document.getElementById('appBirthplace').innerText = button.dataset.birthplace;
        document.getElementById('appReligion').innerText = button.dataset.religion;
        document.getElementById('appHeight').innerText = button.dataset.height;
        document.getElementById('appWeight').innerText = button.dataset.weight;
        document.getElementById('appHome').innerText = button.dataset.home;
        document.getElementById('appContact').innerText = button.dataset.contact;
        document.getElementById('appBoarding').innerText = button.dataset.boarding;
        document.getElementById('appLandlord').innerText = button.dataset.landlord;
        document.getElementById('appHs').innerText = button.dataset.hs;
        document.getElementById('appHsYear').innerText = button.dataset.hsyear;
        document.getElementById('appFather').innerText = button.dataset.father;
        document.getElementById('appFOccupation').innerText = button.dataset.foccupation;
        document.getElementById('appFIncome').innerText = button.dataset.fincome;
        document.getElementById('appMother').innerText = button.dataset.mother;
        document.getElementById('appMOccupation').innerText = button.dataset.moccupation;
        document.getElementById('appMIncome').innerText = button.dataset.mincome;
        document.getElementById('appBrothers').innerText = button.dataset.brothers;
        document.getElementById('appSisters').innerText = button.dataset.sisters;
        document.getElementById('appTotalIncome').innerText = button.dataset.totalincome;
        document.getElementById('appNotes').innerText = button.dataset.notes;

        let docs = JSON.parse(button.dataset.documents || '[]');
        let docList = document.getElementById('appDocuments');
        docList.innerHTML = '';
        if (docs.length > 0) {
            docs.forEach(doc => {
                let li = document.createElement('li');
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                let a = document.createElement('a');
                a.href = `/storage/${doc.file_path}`;
                a.target = "_blank";
                a.innerText = doc.document_type;
                li.appendChild(a);
                docList.appendChild(li);
            });
        } else {
            docList.innerHTML = '<li class="list-group-item text-muted text-center">No documents submitted.</li>';
        }
    });
});
</script>
@endsection
