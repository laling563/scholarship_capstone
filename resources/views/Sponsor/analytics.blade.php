@extends('layouts.sponsor')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Analytics</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <!-- Application Volume -->
            <div class="bg-white p-4 rounded-lg shadow-md analytics-card">
                <div class="chart-wrapper">
                    <h2 class="text-lg font-medium mb-2">Application Volume by Scholarship</h2>
                    <canvas id="applicationVolumeChart" class="chart-container"></canvas>
                </div>

                <div class="description-box">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-sm text-gray-600">
                        Shows how many applications each scholarship received. Helps identify the most in-demand programs.
                    </p>
                </div>
            </div>

            <!-- Application Status -->
            <div class="bg-white p-4 rounded-lg shadow-md analytics-card">
                <div class="chart-wrapper">
                    <h2 class="text-lg font-medium mb-2">Application Status</h2>
                    <canvas id="applicationStatusChart" class="chart-container"></canvas>
                </div>

                <div class="description-box">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-sm text-gray-600">
                        Breakdown of all submitted applications by status (approved, pending, rejected).
                    </p>
                </div>
            </div>

            <!-- Allowance Distribution -->
            <div class="bg-white p-4 rounded-lg shadow-md analytics-card">
                <div class="chart-wrapper">
                    <h2 class="text-lg font-medium mb-2">Allowance Distribution</h2>
                    <canvas id="allowanceDistributionChart" class="chart-container"></canvas>
                </div>

                <div class="description-box">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-sm text-gray-600">
                        Displays how scholarships are distributed based on different grant/allowance amounts.
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- ==================== FIXED LAYOUT & CHART SIZE ==================== --}}
    <style>
        /* Ensures description stays on the right */
        .analytics-card {
            display: flex;
            flex-direction: row;
            gap: 1rem;
        }

        .chart-wrapper {
            width: 60%;
        }

        .description-box {
            width: 40%;
            border-left: 1px solid #e5e7eb;
            padding-left: 1rem;
        }

        /* Chart Height */
        .chart-container,
        canvas {
            max-height: 200px !important;
        }

        /* Mobile layout */
        @media (max-width: 768px) {
            .analytics-card {
                flex-direction: column;
            }

            .chart-wrapper,
            .description-box {
                width: 100%;
                border-left: none;
                padding-left: 0;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Application Volume Chart
        const applicationVolumeCtx = document.getElementById('applicationVolumeChart').getContext('2d');
        const applicationVolumeChart = new Chart(applicationVolumeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($applicationVolume->pluck('title')) !!},
                datasets: [{
                    label: 'Number of Applications',
                    data: {!! json_encode($applicationVolume->pluck('application_forms_count')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Application Status Chart
        const applicationStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
        const applicationStatusChart = new Chart(applicationStatusCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($applicationStatus->pluck('status')) !!},
                datasets: [{
                    label: 'Application Status',
                    data: {!! json_encode($applicationStatus->pluck('count')) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });

        // Allowance Distribution Chart
        const allowanceDistributionCtx = document.getElementById('allowanceDistributionChart').getContext('2d');
        const allowanceDistributionChart = new Chart(allowanceDistributionCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($allowanceDistribution->pluck('grant_amount')->map(fn($val) => (string)$val)) !!},
                datasets: [{
                    label: 'Total Allowance',
                    data: {!! json_encode($allowanceDistribution->pluck('count')) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true },
                    x: {
                        title: {
                            display: true,
                            text: 'Grant Amount'
                        }
                    }
                }
            }
        });
    </script>
@endsection
