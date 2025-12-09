@extends('Admin.AdminLayout')

@section('title', 'Admin Dashboard - PSU Scholarship System')

@section('styles')
<style>
    /* === DASHBOARD STYLES === */
    .dashboard-header {
        background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
        color: #fff;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .dashboard-header h1 {
        font-weight: 700;
        font-size: 2rem;
    }

    /* STATISTIC CARDS */
    .stat-card {
        border: none;
        border-radius: 16px;
        padding: 1.5rem;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border-radius: 12px;
        background: rgba(0, 123, 255, 0.1);
        flex-shrink: 0;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-label {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    /* ACTIVE SCHOLARSHIPS */
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .progress-thin {
        height: 8px;
        border-radius: 4px;
    }

    .btn-link {
        color: #007bff;
        font-weight: 600;
        text-decoration: none;
    }

</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p class="mb-0 text-light opacity-75">Overview of scholarships and applications</p>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.dashboard') }}" class="my-3">
        <div class="d-flex justify-content-end align-items-center">
            <label for="period" class="me-2 fw-bold">Filter by period:</label>
            <select name="period" id="period" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                <option value="all" @if(request('period') == 'all' || !request('period')) selected @endif>All Time</option>
                <option value="last_year" @if(request('period') == 'last_year') selected @endif>Last Year</option>
                <option value="first_semester" @if(request('period') == 'first_semester') selected @endif>First Semester</option>
                <option value="second_semester" @if(request('period') == 'second_semester') selected @endif>Second Semester</option>
            </select>
        </div>
    </form>

    <!-- STATS -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                 <div class="d-flex align-items-center">
                    <div class="stat-icon text-primary"><i class="fas fa-file-alt"></i></div>
                    <div class="ms-3">
                        <p class="stat-label">Total Applications</p>
                        <h3 class="stat-number">{{ $TotalApplication }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                 <div class="d-flex align-items-center">
                    <div class="stat-icon text-warning"><i class="fas fa-hourglass-half"></i></div>
                    <div class="ms-3">
                        <p class="stat-label">Pending Review</p>
                        <h3 class="stat-number">{{ $TotalPending }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                 <div class="d-flex align-items-center">
                    <div class="stat-icon text-success"><i class="fas fa-check-circle"></i></div>
                    <div class="ms-3">
                        <p class="stat-label">Approved</p>
                        <h3 class="stat-number">{{ $TotalAccept }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                 <div class="d-flex align-items-center">
                    <div class="stat-icon text-info"><i class="fas fa-users"></i></div>
                    <div class="ms-3">
                        <p class="stat-label">Total Students</p>
                        <h3 class="stat-number">{{ $TotalStudent }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTIVE SCHOLARSHIPS -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Active Scholarships ({{ $TotalActiveScholarships }})</h5>
                    <a href="{{ route('admin.scholarships.index') }}" class="btn-link small">View All</a>
                </div>
                <div class="card-body">
                    @if($activeScholarshipsList->isEmpty())
                        <p class="text-center text-muted">No active scholarships at the moment.</p>
                    @else
                        @foreach($activeScholarshipsList as $scholarship)
                            @php
                                $progress = ($scholarship->slots > 0) ? ($scholarship->application_forms_count / $scholarship->slots) * 100 : 0;
                            @endphp
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="fw-semibold mb-0 text-dark">{{ $scholarship->title }}</h6>
                                    <small class="text-muted">{{ $scholarship->application_forms_count }} / {{ $scholarship->slots }} slots</small>
                                </div>
                                <div class="progress progress-thin">
                                    <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
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
