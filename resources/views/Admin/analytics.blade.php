@extends('Admin.AdminLayout')

@section('styles')
<style>
    /* === ANALYTICS PAGE STYLES === */
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
        --chart-bg: #ffffff;
    }

    /* === PAGE HEADER === */
    .page-header {
        background: linear-gradient(135deg, #4361ee 0%, #4895ef 100%);
        color: #fff;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
    }

    .page-header h1 {
        font-weight: 700;
        font-size: 1.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-header h1::before {
        content: '📊';
        font-size: 1.5rem;
    }

    /* === FILTER STYLES === */
    .analytics-filter {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 0.5rem 1rem;
        backdrop-filter: blur(10px);
    }

    .analytics-filter label {
        font-weight: 600;
        color: #fff;
        margin-right: 0.75rem;
        font-size: 0.95rem;
    }

    .analytics-filter select {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        color: #4361ee;
        font-weight: 500;
        min-width: 180px;
        transition: all 0.3s ease;
    }

    .analytics-filter select:focus {
        background: white;
        border-color: white;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
    }

    /* === CHART CARDS === */
    .chart-card {
        background: var(--chart-bg);
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        border: 1px solid #f0f3ff;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
        border-color: #e0e7ff;
    }

    .chart-header {
        margin-bottom: 1.25rem;
        border-bottom: 2px solid #f0f3ff;
        padding-bottom: 0.75rem;
    }

    .chart-header h2 {
        font-weight: 700;
        color: #4361ee;
        font-size: 1.1rem;
        margin: 0;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .chart-container {
        flex: 1;
        min-height: 250px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* === CHART SPECIFIC STYLES === */
    .chart-card:nth-child(1) .chart-header h2::before { content: '🎓'; }
    .chart-card:nth-child(2) .chart-header h2::before { content: '📚'; }
    .chart-card:nth-child(3) .chart-header h2::before { content: '🎯'; }
    .chart-card:nth-child(4) .chart-header h2::before { content: '📈'; }
    .chart-card:nth-child(5) .chart-header h2::before { content: '💰'; }

    /* === CHART COLORS === */
    .type-chart { --chart-primary: #4361ee; --chart-secondary: #4895ef; }
    .course-chart { --chart-primary: #f72585; --chart-secondary: #b5179e; }
    .year-chart { --chart-primary: #4cc9f0; --chart-secondary: #3a0ca3; }
    .status-chart { --chart-primary: #7209b7; --chart-secondary: #f72585; }
    .allowance-chart { --chart-primary: #38b000; --chart-secondary: #70e000; }

    /* === RESPONSIVE GRID === */
    .analytics-grid {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    @media (min-width: 768px) {
        .analytics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .analytics-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .col-span-2 {
            grid-column: span 2;
        }
    }

    /* === STATS SUMMARY === */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f3ff;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #4361ee;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* === CHART LEGENDS === */
    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
        justify-content: center;
        font-size: 0.8rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        background: #f8f9ff;
        border-radius: 6px;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 2px;
    }

    /* === EMPTY STATE === */
    .chart-empty {
        text-align: center;
        color: #94a3b8;
        padding: 2rem 1rem;
    }

    .chart-empty i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }

    .chart-empty p {
        font-size: 0.95rem;
        margin: 0;
    }

    /* === LOADING STATE === */
    .chart-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f0f3ff;
        border-top: 3px solid #4361ee;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* === TOOLTIP STYLES === */
    .chartjs-tooltip {
        background: rgba(67, 97, 238, 0.9) !important;
        border: none !important;
        border-radius: 8px !important;
        color: white !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 0.85rem !important;
        backdrop-filter: blur(10px);
    }

    /* === RESPONSIVE ADJUSTMENTS === */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.25rem;
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start !important;
        }

        .analytics-filter {
            width: 100%;
        }

        .analytics-filter select {
            width: 100%;
            min-width: auto;
        }

        .chart-card {
            padding: 1.25rem;
        }

        .chart-header h2 {
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- ENHANCED HEADER WITH FILTER -->
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h1>Analytics Dashboard</h1>
        <form method="GET" action="{{ route('admin.analytics') }}" class="analytics-filter">
            <div class="d-flex align-items-center">
                <label for="period">Filter period:</label>
                <select name="period" id="period" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all" @if(request('period') == 'all' || !request('period')) selected @endif>📊 All Time</option>
                    <option value="last_year" @if(request('period') == 'last_year') selected @endif>📅 Last Year</option>
                    <option value="first_semester" @if(request('period') == 'first_semester') selected @endif>🎓 First Semester</option>
                    <option value="second_semester" @if(request('period') == 'second_semester') selected @endif>🎯 Second Semester</option>
                </select>
            </div>
        </form>
    </div>

    <!-- QUICK STATS SUMMARY -->
    <div class="stats-summary mb-4">
        <div class="stat-item">
            <div class="stat-value">{{ $applicationVolumeByType->sum('count') }}</div>
            <div class="stat-label">Total Applications</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $applicationStatusRates->where('status', 'approved')->first()->count ?? 0 }}</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $applicationVolumeByType->count() }}</div>
            <div class="stat-label">Scholarship Types</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $allowanceDistribution->count() }}</div>
            <div class="stat-label">Allowance Tiers</div>
        </div>
    </div>

    <!-- RESPONSIVE CHART GRID -->
    <div class="row g-4">
        <!-- Scholarship Type Chart -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="chart-card type-chart">
                <div class="chart-header">
                    <h2>Applications by Type</h2>
                </div>
                <div class="chart-container">
                    <canvas id="applicationVolumeByTypeChart"></canvas>
                </div>
                <div class="chart-legend" id="typeLegend"></div>
            </div>
        </div>

        <!-- Course Chart -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="chart-card course-chart">
                <div class="chart-header">
                    <h2>Applications by Course</h2>
                </div>
                <div class="chart-container">
                    <canvas id="applicationVolumeByCourseChart"></canvas>
                </div>
                <div class="chart-legend" id="courseLegend"></div>
            </div>
        </div>

        <!-- Year Level Chart -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="chart-card year-chart">
                <div class="chart-header">
                    <h2>Applications by Year Level</h2>
                </div>
                <div class="chart-container">
                    <canvas id="applicationVolumeByYearChart"></canvas>
                </div>
                <div class="chart-legend" id="yearLegend"></div>
            </div>
        </div>

        <!-- Status Rates Chart -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="chart-card status-chart">
                <div class="chart-header">
                    <h2>Application Status Distribution</h2>
                </div>
                <div class="chart-container">
                    <canvas id="applicationStatusRatesChart"></canvas>
                </div>
                <div class="chart-legend" id="statusLegend"></div>
            </div>
        </div>

        <!-- Allowance Distribution Chart -->
        <div class="col-12 col-md-6 col-lg-6">
            <div class="chart-card allowance-chart">
                <div class="chart-header">
                    <h2>Allowance Distribution</h2>
                </div>
                <div class="chart-container">
                    <canvas id="allowanceDistributionChart"></canvas>
                </div>
                <div class="chart-legend" id="allowanceLegend"></div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Color palette
    const colors = {
        primary: '#4361ee',
        secondary: '#4895ef',
        success: '#4cc9f0',
        warning: '#f72585',
        info: '#7209b7',
        lightPrimary: 'rgba(67, 97, 238, 0.1)'
    };

    // Helper function to generate gradient
    function createGradient(ctx, color1, color2) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    }

    // Initialize all charts
    document.addEventListener('DOMContentLoaded', function() {
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: colors.primary,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#64748b'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#64748b'
                    }
                }
            }
        };

        // 1. Application Volume by Scholarship Type
        const typeCtx = document.getElementById('applicationVolumeByTypeChart').getContext('2d');
        const typeChart = new Chart(typeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($applicationVolumeByType->pluck('title')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($applicationVolumeByType->pluck('count')) !!},
                    backgroundColor: createGradient(typeCtx, colors.primary, colors.secondary),
                    borderColor: colors.primary,
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: chartOptions
        });

        // 2. Application Volume by Course
        const courseCtx = document.getElementById('applicationVolumeByCourseChart').getContext('2d');
        const courseChart = new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($applicationVolumeByCourse->pluck('course')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($applicationVolumeByCourse->pluck('count')) !!},
                    backgroundColor: createGradient(courseCtx, colors.warning, '#b5179e'),
                    borderColor: colors.warning,
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: chartOptions
        });

        // 3. Application Volume by Year Level
        const yearCtx = document.getElementById('applicationVolumeByYearChart').getContext('2d');
        const yearChart = new Chart(yearCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($applicationVolumeByYear->pluck('year_level')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($applicationVolumeByYear->pluck('count')) !!},
                    backgroundColor: createGradient(yearCtx, colors.success, colors.info),
                    borderColor: colors.success,
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: chartOptions
        });

        // 4. Application Status Rates
        const statusCtx = document.getElementById('applicationStatusRatesChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($applicationStatusRates->pluck('status')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($applicationStatusRates->pluck('count')) !!},
                    backgroundColor: [
                        createGradient(statusCtx, colors.info, colors.warning),
                        createGradient(statusCtx, colors.success, '#3a0ca3'),
                        createGradient(statusCtx, colors.warning, '#f72585')
                    ],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 20
                }]
            },
            options: {
                ...chartOptions,
                cutout: '60%',
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        // 5. Allowance Distribution
        const allowanceCtx = document.getElementById('allowanceDistributionChart').getContext('2d');
        const allowanceChart = new Chart(allowanceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($allowanceDistribution->pluck('grant_amount')) !!},
                datasets: [{
                    label: 'Scholarships',
                    data: {!! json_encode($allowanceDistribution->pluck('count')) !!},
                    backgroundColor: createGradient(allowanceCtx, '#38b000', '#70e000'),
                    borderColor: '#38b000',
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    ...chartOptions.scales,
                    x: {
                        ...chartOptions.scales.x,
                        title: {
                            display: true,
                            text: 'Grant Amount (₱)',
                            color: '#64748b',
                            font: {
                                weight: '600'
                            }
                        }
                    },
                    y: {
                        ...chartOptions.scales.y,
                        title: {
                            display: true,
                            text: 'Number of Scholarships',
                            color: '#64748b',
                            font: {
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });

        // Create custom legends
        function createLegend(chartId, labels) {
            const legendContainer = document.getElementById(chartId + 'Legend');
            if (!legendContainer) return;

            labels.forEach((label, index) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'legend-item';

                const colorBox = document.createElement('div');
                colorBox.className = 'legend-color';
                colorBox.style.backgroundColor = getComputedStyle(document.documentElement)
                    .getPropertyValue('--chart-primary').trim();

                const text = document.createElement('span');
                text.textContent = label;

                legendItem.appendChild(colorBox);
                legendItem.appendChild(text);
                legendContainer.appendChild(legendItem);
            });
        }

        // Initialize legends
        createLegend('type', {!! json_encode($applicationVolumeByType->pluck('title')) !!});
        createLegend('course', {!! json_encode($applicationVolumeByCourse->pluck('course')) !!});
        createLegend('year', {!! json_encode($applicationVolumeByYear->pluck('year_level')) !!});
    });
</script>
@endsection
