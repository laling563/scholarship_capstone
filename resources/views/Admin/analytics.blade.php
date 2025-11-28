@extends('Admin.AdminLayout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="text-2xl fw-bold mb-4">Analytics</h1>

    <!-- Responsive Grid -->
    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="bg-white p-3 rounded shadow-sm h-100">
                <h2 class="fs-6 fw-semibold mb-3 text-center">Application Volume by Scholarship Type</h2>
                <canvas id="applicationVolumeByTypeChart" style="max-height: 250px;"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="bg-white p-3 rounded shadow-sm h-100">
                <h2 class="fs-6 fw-semibold mb-3 text-center">Application Volume by Course</h2>
                <canvas id="applicationVolumeByCourseChart" style="max-height: 250px;"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="bg-white p-3 rounded shadow-sm h-100">
                <h2 class="fs-6 fw-semibold mb-3 text-center">Application Volume by Year Level</h2>
                <canvas id="applicationVolumeByYearChart" style="max-height: 250px;"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6">
            <div class="bg-white p-3 rounded shadow-sm h-100">
                <h2 class="fs-6 fw-semibold mb-3 text-center">Application Status Rates</h2>
                <canvas id="applicationStatusRatesChart" style="max-height: 280px;"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6">
            <div class="bg-white p-3 rounded shadow-sm h-100">
                <h2 class="fs-6 fw-semibold mb-3 text-center">Allowance Distribution</h2>
                <canvas id="allowanceDistributionChart" style="max-height: 280px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Application Volume by Scholarship Type
    const applicationVolumeByTypeChart = new Chart(document.getElementById('applicationVolumeByTypeChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($applicationVolumeByType->pluck('title')) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($applicationVolumeByType->pluck('count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // Application Volume by Course
    const applicationVolumeByCourseChart = new Chart(document.getElementById('applicationVolumeByCourseChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($applicationVolumeByCourse->pluck('course')) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($applicationVolumeByCourse->pluck('count')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // Application Volume by Year Level
    const applicationVolumeByYearChart = new Chart(document.getElementById('applicationVolumeByYearChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($applicationVolumeByYear->pluck('year_level')) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($applicationVolumeByYear->pluck('count')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // Application Status Rates
    const applicationStatusRatesChart = new Chart(document.getElementById('applicationStatusRatesChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($applicationStatusRates->pluck('status')) !!},
            datasets: [{
                label: 'Status',
                data: {!! json_encode($applicationStatusRates->pluck('count')) !!},
                backgroundColor: [
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderWidth: 1
            }]
        },
        options: { maintainAspectRatio: false }
    });

    // Allowance Distribution
    const allowanceDistributionChart = new Chart(document.getElementById('allowanceDistributionChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($allowanceDistribution->pluck('grant_amount')) !!},
            datasets: [{
                label: 'Scholarships',
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
                x: { title: { display: true, text: 'Grant Amount' } }
            }
        }
    });
</script>
@endsection
