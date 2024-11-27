@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Live Visitors Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Live Visitors</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span id="liveVisitorCount">0</span>
                            <small class="text-success ml-2" id="visitorChange"></small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Today Visitors Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Today's Visitors</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="todayVisitors">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Time Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Avg. Time on Site</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="avgTime">0:00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bounce Rate Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Bounce Rate</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="bounceRate">0%</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percent fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Visitors Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Time Range:</div>
                        <a class="dropdown-item active" href="#" data-range="today">Today</a>
                        <a class="dropdown-item" href="#" data-range="week">This Week</a>
                        <a class="dropdown-item" href="#" data-range="month">This Month</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Traffic Sources</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="trafficSourceChart"></canvas>
                </div>
                <div class="mt-4 text-center small" id="trafficLegend">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Active Pages Table -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Currently Active Pages</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Page URL</th>
                                <th>Active Users</th>
                                <th>Avg. Time</th>
                                <th>Bounce Rate</th>
                            </tr>
                        </thead>
                        <tbody id="activePages">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simulasi data real-time
    let visitors = {
        count: Math.floor(Math.random() * 100),
        today: Math.floor(Math.random() * 1000),
        avgTime: Math.floor(Math.random() * 15),
        bounceRate: Math.floor(Math.random() * 100)
    };

    // Update fungsi visitor count
    function updateVisitors() {
        const change = Math.floor(Math.random() * 11) - 5; // -5 to +5
        visitors.count += change;
        visitors.count = Math.max(0, visitors.count); // Prevent negative
        
        document.getElementById('liveVisitorCount').textContent = visitors.count;
        const changeEl = document.getElementById('visitorChange');
        if (change > 0) {
            changeEl.textContent = `+${change}`;
            changeEl.className = 'text-success ml-2';
        } else if (change < 0) {
            changeEl.textContent = change;
            changeEl.className = 'text-danger ml-2';
        }
        
        visitors.today += Math.max(0, change);
        document.getElementById('todayVisitors').textContent = visitors.today;
        
        // Update average time
        visitors.avgTime += (Math.random() - 0.5) / 10;
        const minutes = Math.floor(visitors.avgTime);
        const seconds = Math.floor((visitors.avgTime - minutes) * 60);
        document.getElementById('avgTime').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        // Update bounce rate
        visitors.bounceRate += (Math.random() - 0.5) * 2;
        visitors.bounceRate = Math.min(100, Math.max(0, visitors.bounceRate));
        document.getElementById('bounceRate').textContent = `${Math.round(visitors.bounceRate)}%`;
    }

    // Visitor Chart
    const visitorCtx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(visitorCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: 24}, (_, i) => `${i}:00`),
            datasets: [{
                label: 'Visitors',
                data: Array.from({length: 24}, () => Math.floor(Math.random() * 100)),
                borderColor: 'rgb(78, 115, 223)',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.1)'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Traffic Sources Chart
    const trafficCtx = document.getElementById('trafficSourceChart').getContext('2d');
    const trafficData = {
        labels: ['Direct', 'Social', 'Referral', 'Organic'],
        datasets: [{
            data: [30, 25, 20, 25],
            backgroundColor: [
                'rgba(78, 115, 223, 0.8)',
                'rgba(28, 200, 138, 0.8)',
                'rgba(54, 185, 204, 0.8)',
                'rgba(246, 194, 62, 0.8)'
            ]
        }]
    };
    
    new Chart(trafficCtx, {
        type: 'doughnut',
        data: trafficData,
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '80%'
        }
    });

    // Update traffic legend
    const legendContainer = document.getElementById('trafficLegend');
    trafficData.labels.forEach((label, index) => {
        const percentage = trafficData.datasets[0].data[index];
        const color = trafficData.datasets[0].backgroundColor[index];
        const legendItem = document.createElement('span');
        legendItem.className = 'mr-2';
        legendItem.innerHTML = `
            <i class="fas fa-circle" style="color: ${color}"></i> ${label} (${percentage}%)
        `;
        legendContainer.appendChild(legendItem);
    });

    // Active Pages Table
    const pages = [
        '/home', '/products', '/about', '/contact', '/blog'
    ];

    function updateActivePages() {
        const tbody = document.getElementById('activePages');
        tbody.innerHTML = '';
        
        pages.forEach(page => {
            const users = Math.floor(Math.random() * 20);
            const avgTime = Math.floor(Math.random() * 10);
            const bounceRate = Math.floor(Math.random() * 100);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${page}</td>
                <td>${users}</td>
                <td>${avgTime}:${Math.floor(Math.random() * 60).toString().padStart(2, '0')}</td>
                <td>${bounceRate}%</td>
            `;
            tbody.appendChild(row);
        });
    }

    // Update data setiap 3 detik
    setInterval(updateVisitors, 3000);
    setInterval(updateActivePages, 5000);

    // Initial updates
    updateVisitors();
    updateActivePages();
});
</script>
@endpush
