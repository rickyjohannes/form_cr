@extends('template.dashboard')

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard IT</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- CR Summary Boxes -->
                @foreach ([ 
                    ['bg' => 'bg-primary', 'icon' => 'fas fa-file-alt', 'text' => 'Total CR', 'number' => $count->proposal],
                    ['bg' => 'bg-gradient-warning', 'icon' => 'fas fa-clock', 'text' => 'Total CR Pending', 'number' => $count->pending],
                    ['bg' => 'bg-success', 'icon' => 'fas fa-check-circle', 'text' => 'Total CR Approved', 'number' => $count->approved],
                    ['bg' => 'bg-danger', 'icon' => 'fas fa-times', 'text' => 'Total CR Rejected', 'number' => $count->rejected]
                ] as $item)
                <div class="col-lg-3 col-6">
                    <div class="info-box shadow">
                        <span class="info-box-icon {{ $item['bg'] }}"><i class="{{ $item['icon'] }}"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ $item['text'] }}</span>
                            <span class="info-box-number">{{ $item['number'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <!-- Total Data Chart and Counting CR by Jenis Permintaan -->
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Total Data CR Approved</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#proposal-chart" data-toggle="tab">Status Approved</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane" id="account-chart" style="position: relative; height: 300px;">
                                    <canvas id="account-chart-canvas" style="width: 100%; height: 100%; display: block;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="proposal-chart" style="position: relative; height: 300px;">
                                    <canvas id="proposal-chart-canvas" style="width: 100%; height: 100%; display: block;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Counting CR by Jenis Permintaan</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#jenis-permintaan-chart" data-toggle="tab">Jenis Permintaan</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane active" id="jenis-permintaan-chart" style="position: relative; height: 300px;">
                                    <canvas id="jenis-permintaan-chart-canvas" style="width: 100%; height: 100%; display: block;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="row">
                <!-- Chart for Status Per User -->
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i>CR Per User</h3>
                        </div>
                        <div class="card-body">
                            <!-- Pastikan canvas memiliki ukuran responsif -->
                            <canvas id="status-per-user-chart" style="width: 100%; height: 400px;"></canvas>
                        </div>
                    </div>
                </section>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Status CR Per User IT</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="bg-gray">
                                        <tr>
                                            <th>User</th>
                                            <th>Total CR</th>
                                            <th>On Progress</th>
                                            <th>Closed</th>
                                            <th>Delay</th>
                                            <th>Closed With Delay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($crCounts as $crCount)
                                            <tr>
                                                <td>{{ $crCount->it_user }}</td>
                                                <td>{{ $crCount->total_count }}</td>
                                                <td class="bg-yellow">{{ $crCount->on_progress_count }}</td>
                                                <td class="bg-success">{{ $crCount->closed_count }}</td>
                                                <td class="bg-danger">{{ $crCount->delay_count }}</td>
                                                <td class="bg-orange">{{ $crCount->closed_delay_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        // Account Chart
        var ctxAccount = $('#account-chart-canvas').get(0).getContext('2d');
        var chartAccount = @json($chart1);
        var barData = {
            labels: chartAccount.labels,
            datasets: [{
                label: chartAccount.datasets[0].label,
                data: chartAccount.datasets[0].data,
                backgroundColor: chartAccount.datasets[0].backgroundColor
            }]
        };
        var barOptions = {
            legend: { display: false },
            maintainAspectRatio: false,
            responsive: true
        };
        var barChart = new Chart(ctxAccount, { type: 'bar', data: barData, options: barOptions });

        // Proposal Chart
        var ctxProposal = $('#proposal-chart-canvas').get(0).getContext('2d');
        var chartProposal = @json($chart2);
        var donutData = {
            labels: chartProposal.labels,
            datasets: [{
                label: chartProposal.datasets[0].label,
                data: chartProposal.datasets[0].data,
                backgroundColor: chartProposal.datasets[0].backgroundColor
            }]
        };
        var donutOptions = {
            legend: { display: false },
            maintainAspectRatio: false,
            responsive: true
        };
        var donutChart = new Chart(ctxProposal, { type: 'doughnut', data: donutData, options: donutOptions });

        // Jenis Permintaan Chart (Pie Chart for CR by Jenis Permintaan)
        document.addEventListener("DOMContentLoaded", function() {
            var ctxJenisPermintaan = document.getElementById('jenis-permintaan-chart-canvas').getContext('2d');
            var countJeninsPermintaanData = @json($countJeninsPermintaan);

            // Prepare chart data
            var labels = countJeninsPermintaanData.map(item => item.status_barang);
            var data = countJeninsPermintaanData.map(item => item.count);

            // Create the chart for Jenis Permintaan
            new Chart(ctxJenisPermintaan, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jenis Permintaan',
                        data: data,
                        backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A8'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });

            // Jenis Permintaan By User Chart (Pie Chart for CR by Jenis Permintaan)
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil data dari PHP dan ubah menjadi format yang sesuai untuk Chart.js
            var data = @json($countJeninsPermintaanByUser);

            // Extract unique users dan statuses
            var users = [...new Set(data.map(item => item.name))];
            var statuses = [...new Set(data.map(item => item.status_barang))];

            // Initialize object untuk menyimpan count per user dan status
            var dataset = {};
            statuses.forEach(status => {
                dataset[status] = users.map(user => {
                    // Cari count untuk kombinasi user dan status
                    var match = data.find(item => item.name === user && item.status_barang === status);
                    return match ? match.count : 0;
                });
            });

            // Persiapkan data untuk chart
            var chartData = {
                labels: users,
                datasets: statuses.map((status, index) => ({
                    label: status,
                    data: dataset[status],
                    backgroundColor: getColor(index),
                }))
            };

            // Opsi chart untuk stacked bar chart
            var chartOptions = {
                responsive: true, // Pastikan chart responsif
                maintainAspectRatio: false, // Allow the chart to scale with the container
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    }
                }
            };

            // Membuat chart menggunakan Chart.js
            var ctx = document.getElementById('status-per-user-chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        });

        // Fungsi untuk menghasilkan warna unik pada chart
        function getColor(index) {
            const colors = [
                '#FF5733', '#33FF57', '#3357FF', '#FF33A8', 
                '#FFD700', '#8A2BE2', '#FF6347', '#20B2AA'
            ];
            return colors[index % colors.length];
        }

    </script>
@endsection
