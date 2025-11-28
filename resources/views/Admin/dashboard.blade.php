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

    .card-custom:hover {
        transform: translateY(-4px);
    }

    .progress-thin {
        height: 8px;
        border-radius: 4px;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    .btn-link {
        color: #007bff;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    /* === RESPONSIVE LAYOUT === */
    @media (max-width: 1200px) {
        .dashboard-header h1 {
            font-size: 1.8rem;
        }
        .stat-number {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 992px) {
        .dashboard-header {
            text-align: center;
            padding: 1.5rem;
        }
        .dashboard-header h1 {
            font-size: 1.6rem;
        }
        .stat-card {
            padding: 1rem;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.25rem;
        }

        .dashboard-header h1 {
            font-size: 1.4rem;
        }

        .stat-number {
            font-size: 1.6rem;
        }

        .stat-card {
            text-align: center;
        }

        .stat-card .d-flex {
            flex-direction: column;
            justify-content: center;
        }

        .stat-icon {
            margin-bottom: 0.5rem;
        }

        .card-custom {
            margin-bottom: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 0.75rem;
        }
        .dashboard-header h1 {
            font-size: 1.25rem;
        }
        .stat-number {
            font-size: 1.4rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="dashboard-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="text-center text-md-start w-100 w-md-auto">
                <h1>Admin Dashboard</h1>
                <p class="mb-0 text-light opacity-75">Overview of scholarships and applications</p>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-primary bg-primary bg-opacity-10 me-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Applications</p>
                        <h3 class="stat-number">{{ $TotalApplication }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-warning bg-warning bg-opacity-10 me-3">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <p class="stat-label">Pending Review</p>
                        <h3 class="stat-number">{{ $TotalPending }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-success bg-success bg-opacity-10 me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="stat-label">Approved</p>
                        <h3 class="stat-number">{{ $TotalAccept }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-info bg-info bg-opacity-10 me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="stat-label">Total Students</p>
                        <h3 class="stat-number">{{ $TotalStudent }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTIVE SCHOLARSHIPS -->
    <div class="row g-4">
        <div class="col-xl-4 col-lg-6 col-md-12">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Active Scholarships</h5>
                    <a href="#" class="btn-link small">View All</a>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-semibold mb-0 text-dark">TULong DUnong Program</h6>
                            <small class="text-muted">5 / 50 slots</small>
                        </div>
                        <div class="progress progress-thin">
                            <div class="progress-bar bg-primary" style="width: 15%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-semibold mb-0 text-dark">Educational Assistance Program</h6>
                            <small class="text-muted">3 / 100 slots</small>
                        </div>
                        <div class="progress progress-thin">
                            <div class="progress-bar bg-success" style="width: 10%"></div>
                        </div>
                    </div>

                    <div>
                        <!-- <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-semibold mb-0 text-dark">Private Sponsor A</h6>
                            <small class="text-muted">12 / 20 slots</small>
                        </div> -->
                        <!-- <div class="progress progress-thin">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART -->
        <!-- <div class="col-xl-8 col-lg-6 col-md-12">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Application Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="applicationsChart" height="180"></canvas>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartCanvas = document.getElementById('applicationsChart');
    if (!chartCanvas) return;

    const ctx = chartCanvas.getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [
                {
                    label: 'Applications',
                    data: [65, 78, 52, 91, 83, 157],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Approved',
                    data: [42, 55, 40, 65, 59, 98],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Rejected',
                    data: [10, 13, 7, 14, 12, 27],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true } },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection
