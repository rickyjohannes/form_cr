@extends('template.dashboard')

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Admin</h1>
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
                <!-- CR Per IT Chart -->
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i>Total CR By IT</h3>
                        </div>
                        <div class="card-body">
                            <!-- Pastikan canvas memiliki ukuran responsif -->
                            <canvas id="status-per-it-chart" style="width: 100%; height: 400px;"></canvas>
                        </div>
                    </div>
                </section>

                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Total CR By Jenis Permintaan</h3>
                        </div>
                        <div class="card-body">
                            <!-- Pastikan canvas memiliki ukuran responsif -->
                            <canvas id="jenis-permintaan-chart-canvas" style="width: 100%; height: 390px;"></canvas>
                        </div>
                    </div>
                </section>
            </div>

            <div class="row">
            <!-- Average Ratings by User Table -->
            <section class="col-lg-6 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Penilaian Kinerja IT</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>IT User</th>
                                    <th>Average Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ratingByUserIT as $item)
                                    <tr>
                                        <td>{{ $item->it_user }}</td>
                                        <td>
                                            <!-- Displaying rating stars -->
                                            <div class="star-rating" id="star-rating-it-{{ $item->it_user }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $item->rating ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                            <strong>{{ number_format($item->rating, 1) }}</strong> <!-- Menampilkan rating aplikasi dalam teks tebal -->
                                        </td>
                                    </tr>
                                @endforeach
                                <style>
                                    /* Star rating styles */
                                    .star-rating .fa-star {
                                        color: gray; /* Default color for unfilled stars */
                                    }

                                    .star-rating .fa-star.checked {
                                        color: orange; /* Color for filled (checked) stars */
                                    }
                                </style>
                            </tbody>
                        </table>
                    </div>

                    <!-- Average Ratings Apk -->
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Penilaian Aplikasi</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Average Rating Aplikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <!-- Displaying rating stars -->
                                        <div class="star-rating" id="star-rating-apk">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= round($ratingByApk) ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                        <strong>{{ number_format($ratingByApk, 1) }}</strong> <!-- Menampilkan rating aplikasi dalam teks tebal -->
                                    </td>
                                </tr>
                                <style>
                                    /* Star rating styles */
                                    .star-rating .fa-star {
                                        color: gray; /* Default color for unfilled stars */
                                    }

                                    .star-rating .fa-star.checked {
                                        color: orange; /* Color for filled (checked) stars */
                                    }
                                </style>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- CR Per User Chart -->
            <section class="col-lg-6 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i>Total CR By User</h3>
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
                            <h3 class="card-title">Progress CR By User IT</h3>
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

        // Jenis Permintaan By IT Chart (Pie Chart for CR by Jenis Permintaan)
        document.addEventListener("DOMContentLoaded", function() {
            var data = @json($countJeninsPermintaanByIT);

            // Extract unique users and statuses
            var users = [...new Set(data.map(item => item.it_user))];  // Assuming 'it_user' represents the IT user
            var statuses = [...new Set(data.map(item => item.status_barang))];  // Extract unique statuses

            // Prepare dataset structure
            var dataset = {};
            statuses.forEach(status => {
                dataset[status] = users.map(user => {
                    // Find the matching record for a given user and status_barang
                    var match = data.find(item => item.it_user === user && item.status_barang === status);
                    return match ? match.count : 0;  // If no match, return 0
                });
            });

            // Prepare chart data
            var chartData = {
                labels: users,  // Set user names as labels
                datasets: statuses.map((status, index) => ({
                    label: status,  // Label for each status
                    data: dataset[status],  // Data for that status across users
                    backgroundColor: getColor(index),  // Use dynamic color for each status
                }))
            };

            // Chart options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',  // Display legend at the top
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;  // Display value on hover
                            }
                        }
                    }
                },
                scales: {
                    x: { stacked: true },  // Stack on X axis (users)
                    y: { stacked: true }   // Stack on Y axis (count)
                }
            };

            // Create the chart with Chart.js
            var ctx = document.getElementById('status-per-it-chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',  // Using bar chart
                data: chartData,  // Data for the chart
                options: chartOptions  // Options for the chart
            });
        });

        // Function to generate unique colors for the chart
        function getColor(index) {
            const colors = [
                '#FF5733', '#33FF57', '#3357FF', '#FF33A8', 
                '#FFD700', '#8A2BE2', '#FF6347', '#20B2AA'
            ];
            return colors[index % colors.length];  // Return color based on index
        }

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
                        backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A8', '#FFD700', '#8A2BE2', '#FF6347', '#20B2AA'],
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

        // Menonaktifkan interaksi hover dengan star rating
        document.querySelectorAll('.star-rating .fa-star').forEach(function(star) {
            // Menghapus event listener untuk mouseover
            // Tidak ada aksi ketika mouse berada di atas bintang
            star.removeEventListener('mouseover', function() {
                let ratingIndex = parseInt(star.getAttribute('data-index'));
                let starContainer = star.closest('.star-rating');
                Array.from(starContainer.children).forEach(function(s, index) {
                    s.classList.toggle('checked', index < ratingIndex);
                });
            });

            // Menghapus event listener untuk mouseout
            // Tidak ada aksi ketika mouse keluar dari bintang
            star.removeEventListener('mouseout', function() {
                let starContainer = star.closest('.star-rating');
                Array.from(starContainer.children).forEach(function(s) {
                    s.classList.remove('checked');
                });
            });
        });
    </script>
@endsection