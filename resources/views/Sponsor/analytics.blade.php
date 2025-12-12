@extends('layouts.sponsor')

@section('title', 'Analytics & Reports - Sponsor Dashboard')

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
    .chart-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .chart-card .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
    }
    .chart-card .card-body {
        flex-grow: 1;
        padding: 1.5rem;
    }
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    <!-- HEADER -->
    <div class="header-container">
        <h1 class="mb-1">Analytics & Reports</h1>
        <p class="mb-0 opacity-75">Visual insights into your scholarship data.</p>
    </div>

    <!-- CHARTS GRID -->
    <div class="row g-4">
        <!-- Application Volume -->
        <div class="col-lg-6 col-xl-4">
            <div class="card chart-card">
                <div class="card-header py-3">
                    <h6 class="fw-bold mb-0 text-center">Application Volume by Scholarship</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="applicationVolumeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Status -->
        <div class="col-lg-6 col-xl-4">
            <div class="card chart-card">
                <div class="card-header py-3">
                    <h6 class="fw-bold mb-0 text-center">Overall Application Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="applicationStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Allowance Distribution -->
        <div class="col-lg-12 col-xl-4">
            <div class="card chart-card">
                <div class="card-header py-3">
                    <h6 class="fw-bold mb-0 text-center">Scholarships by Grant Amount</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="allowanceDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const commonOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0', borderDash: [2, 4] },
                    ticks: { font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        };

        const pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, boxWidth: 12, font: { size: 12 } }
                }
            }
        };

        // 1. Application Volume Chart
        const applicationVolumeCtx = document.getElementById('applicationVolumeChart')?.getContext('2d');
        if (applicationVolumeCtx) {
            new Chart(applicationVolumeCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($applicationVolume->pluck('title')) !!},
                    datasets: [{
                        label: 'Applications',
                        data: {!! json_encode($applicationVolume->pluck('application_forms_count')) !!},
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: commonOptions
            });
        }

        // 2. Application Status Chart
        const applicationStatusCtx = document.getElementById('applicationStatusChart')?.getContext('2d');
        if(applicationStatusCtx) {
            new Chart(applicationStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($applicationStatus->pluck('status')->map('ucfirst')) !!},
                    datasets: [{
                        data: {!! json_encode($applicationStatus->pluck('count')) !!},
                        backgroundColor: ['rgba(46, 204, 113, 0.7)', 'rgba(241, 196, 15, 0.7)', 'rgba(231, 76, 60, 0.7)'],
                        borderColor: ['#2ecc71', '#f1c40f', '#e74c3c'],
                        borderWidth: 2
                    }]
                },
                options: pieOptions
            });
        }

        // 3. Allowance Distribution Chart
        const allowanceDistributionCtx = document.getElementById('allowanceDistributionChart')?.getContext('2d');
        if (allowanceDistributionCtx) {
            new Chart(allowanceDistributionCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($allowanceDistribution->pluck('grant_amount')->map(fn($val) => '₱'.number_format($val))) !!},
                    datasets: [{
                        label: 'Scholarships',
                        data: {!! json_encode($allowanceDistribution->pluck('count')) !!},
                        backgroundColor: 'rgba(155, 89, 182, 0.7)',
                        borderColor: 'rgba(155, 89, 182, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: { ...commonOptions, plugins: { ...commonOptions.plugins, tooltip: { callbacks: { label: (c) => `${c.label}: ${c.raw} scholarships` } } } }
            });
        }
    });
</script>
@endsection
