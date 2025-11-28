@extends('layouts.sponsor')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Analytics</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-medium mb-2">Application Volume by Scholarship</h2>
                <canvas id="applicationVolumeChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-medium mb-2">Application Status</h2>
                <canvas id="applicationStatusChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-medium mb-2">Allowance Distribution</h2>
                <canvas id="allowanceDistributionChart"></canvas>
            </div>
        </div>
    </div>

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
            }
        });

        // Allowance Distribution Chart
        const allowanceDistributionCtx = document.getElementById('allowanceDistributionChart').getContext('2d');
        const allowanceDistributionChart = new Chart(allowanceDistributionCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($allowanceDistribution->pluck('grant_amount')) !!},
                datasets: [{
                    label: 'Number of Scholarships',
                    data: {!! json_encode($allowanceDistribution->pluck('count')) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
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
