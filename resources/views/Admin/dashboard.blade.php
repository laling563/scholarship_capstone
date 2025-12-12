@extends('Admin.AdminLayout')

@section('title', 'Admin Dashboard - PSU Scholarship System')

@section('styles')
<style>
    /* === LIGHT & FRESH DASHBOARD STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --secondary: #7209b7;
        --success: #4cc9f0;
        --warning: #f72585;
        --info: #3a0ca3;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === CLEAN HEADER === */
    .dashboard-header {
        background: linear-gradient(135deg, #4361ee 0%, #4895ef 100%);
        color: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .dashboard-header h1 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .dashboard-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
        font-weight: 400;
    }

    /* === LIGHT FILTER === */
    .filter-container {
        background: #fff;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #f0f3ff;
    }

    .filter-container label {
        font-weight: 600;
        color: #4361ee;
        margin-right: 0.75rem;
    }

    .form-select-sm {
        border-radius: 12px;
        border: 2px solid #e8edff;
        transition: all 0.3s ease;
        font-weight: 500;
        min-width: 160px;
        background: #f8f9ff;
        color: #4361ee;
    }

    .form-select-sm:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        background: #fff;
    }

    /* === LIGHT STAT CARDS === */
    .stat-card {
        border: none;
        border-radius: 18px;
        padding: 1.75rem;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        height: 100%;
        border: 1px solid #f0f3ff;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--card-accent);
        transition: height 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
        border-color: #e0e7ff;
    }

    .stat-card:hover::before {
        height: 6px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border-radius: 14px;
        background: var(--icon-bg);
        flex-shrink: 0;
        margin-right: 1.25rem;
        color: var(--icon-color);
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.08);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0;
        color: #2d3748;
        letter-spacing: -0.5px;
    }

    .stat-label {
        color: #64748b;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-trend {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: #94a3b8;
    }

    /* === LIGHT SCHOLARSHIPS CARD === */
    .card-custom {
        border: none;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(67, 97, 238, 0.05);
        transition: all 0.3s ease;
        border: 1px solid #f0f3ff;
        overflow: hidden;
        background: #fff;
    }

    .card-custom:hover {
        box-shadow: 0 12px 40px rgba(67, 97, 238, 0.08);
    }

    .card-header {
        background: linear-gradient(90deg, #f8f9ff 0%, #fff 100%);
        border-bottom: 1px solid #e8edff;
        padding: 1.5rem 2rem;
        border-radius: 20px 20px 0 0 !important;
    }

    .card-header h5 {
        font-weight: 700;
        color: #4361ee;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .card-header h5::before {
        content: '🎯';
        font-size: 1.1rem;
    }

    .card-body {
        padding: 2rem;
        background: #fafbff;
    }

    /* === LIGHT PROGRESS BARS === */
    .scholarship-item {
        padding: 1.5rem;
        border-radius: 14px;
        background: #fff;
        margin-bottom: 1rem;
        border: 1px solid #e8edff;
        transition: all 0.3s ease;
    }

    .scholarship-item:hover {
        background: #f8f9ff;
        border-color: #4361ee;
        transform: translateX(4px);
    }

    .scholarship-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .scholarship-title {
        font-weight: 600;
        color: #1e293b;
        font-size: 1rem;
        flex: 1;
        line-height: 1.4;
    }

    .scholarship-slots {
        background: #4361ee;
        color: white;
        padding: 0.35rem 0.85rem;
        border-radius: 16px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 3px 10px rgba(67, 97, 238, 0.15);
    }

    .progress-container {
        position: relative;
    }

    .progress-thin {
        height: 10px;
        border-radius: 8px;
        background: #e8edff;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #4361ee 0%, #4895ef 100%);
        border-radius: 8px;
        transition: width 1s ease-in-out;
        position: relative;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    .progress-percentage {
        color: #4361ee;
        font-weight: 600;
    }

    /* === LIGHT BUTTONS === */
    .btn-outline-primary {
        border-color: #e8edff;
        color: #4361ee;
        font-weight: 500;
    }

    .btn-outline-primary:hover {
        background: #4361ee;
        border-color: #4361ee;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4361ee 0%, #4895ef 100%);
        border: none;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.25);
    }

    /* === LIGHT EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e8edff;
    }

    .empty-state h5 {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 0.95rem;
    }

    /* === ANIMATIONS === */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .stat-card:hover .stat-icon {
        animation: float 2s ease-in-out infinite;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.75rem;
            border-radius: 16px;
        }

        .dashboard-header h1 {
            font-size: 1.8rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        .stat-number {
            font-size: 1.8rem;
        }

        .scholarship-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .scholarship-slots {
            align-self: flex-start;
        }

        .card-header {
            padding: 1.25rem;
            flex-direction: column;
            gap: 1rem;
        }

        .card-header > div {
            width: 100%;
            justify-content: space-between;
        }
    }

    /* === STATUS COLORS FOR STAT CARDS === */
    .applications { --card-accent: #4361ee; --icon-bg: rgba(67, 97, 238, 0.1); --icon-color: #4361ee; }
    .pending { --card-accent: #f72585; --icon-bg: rgba(247, 37, 133, 0.1); --icon-color: #f72585; }
    .approved { --card-accent: #4cc9f0; --icon-bg: rgba(76, 201, 240, 0.1); --icon-color: #4cc9f0; }
    .students { --card-accent: #7209b7; --icon-bg: rgba(114, 9, 183, 0.1); --icon-color: #7209b7; }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- IMPROVED HEADER -->
    <div class="dashboard-header">
        <h1>Welcome to Dashboard</h1>
        <p class="mb-0 text-light opacity-90">Monitor scholarship applications and manage system activities</p>
    </div>

    <!-- IMPROVED FILTER -->
    <div class="filter-container">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex justify-content-end align-items-center">
            <label for="period" class="fw-semibold">Filter by period:</label>
            <select name="period" id="period" class="form-select form-select-sm ms-2" onchange="this.form.submit()">
                <option value="all" @if(request('period') == 'all' || !request('period')) selected @endif>📊 All Time</option>
                <option value="last_year" @if(request('period') == 'last_year') selected @endif>📅 Last Year</option>
                <option value="first_semester" @if(request('period') == 'first_semester') selected @endif>🎓 First Semester</option>
                <option value="second_semester" @if(request('period') == 'second_semester') selected @endif>🎯 Second Semester</option>
            </select>
        </form>
    </div>

    <!-- ENHANCED STATS -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-accent: #667eea; --icon-bg: rgba(102, 126, 234, 0.1); --icon-color: #667eea; --number-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Total Applications</p>
                        <h3 class="stat-number">{{ $TotalApplication }}</h3>
                        <div class="stat-trend text-success">
                            <i class="fas fa-arrow-up"></i>
                            <span>Updated daily</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-accent: #f6ad55; --icon-bg: rgba(246, 173, 85, 0.1); --icon-color: #f6ad55; --number-gradient: linear-gradient(135deg, #f6ad55 0%, #f56565 100%);">
                <div class="d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Pending Review</p>
                        <h3 class="stat-number">{{ $TotalPending }}</h3>
                        <div class="stat-trend text-warning">
                            <i class="fas fa-clock"></i>
                            <span>Awaiting action</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-accent: #48bb78; --icon-bg: rgba(72, 187, 120, 0.1); --icon-color: #48bb78; --number-gradient: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <div class="d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Approved</p>
                        <h3 class="stat-number">{{ $TotalAccept }}</h3>
                        <div class="stat-trend text-success">
                            <i class="fas fa-check"></i>
                            <span>Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-accent: #4299e1; --icon-bg: rgba(66, 153, 225, 0.1); --icon-color: #4299e1; --number-gradient: linear-gradient(135deg, #4299e1 0%, #667eea 100%);">
                <div class="d-flex align-items-center">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-content">
                        <p class="stat-label">Total Students</p>
                        <h3 class="stat-number">{{ $TotalStudent }}</h3>
                        <div class="stat-trend text-info">
                            <i class="fas fa-user-plus"></i>
                            <span>Registered</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ENHANCED ACTIVE SCHOLARSHIPS -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Active Scholarships ({{ $TotalActiveScholarships }})</h5>
                </div>
                <div class="card-body">
                    @if($activeScholarshipsList->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-award"></i>
                            <h5 class="text-muted">No Active Scholarships</h5>
                            <p class="text-muted mb-0">Create new scholarships to get started</p>
                        </div>
                    @else
                        @foreach($activeScholarshipsList as $scholarship)
                            @php
                                $progress = ($scholarship->slots > 0) ? ($scholarship->application_forms_count / $scholarship->slots) * 100 : 0;
                                $progress = min($progress, 100);
                            @endphp
                            <div class="scholarship-item">
                                <div class="scholarship-header">
                                    <h6 class="scholarship-title">{{ $scholarship->title }}</h6>
                                    <span class="scholarship-slots">
                                        {{ $scholarship->application_forms_count }} / {{ $scholarship->slots }} slots filled
                                    </span>
                                </div>
                                <div class="progress-container">
                                    <div class="progress progress-thin">
                                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="progress-label">
                                        <span>Progress</span>
                                        <span>{{ number_format($progress, 1) }}%</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
