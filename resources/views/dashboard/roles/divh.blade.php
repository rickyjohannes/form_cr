@extends('template.dashboard')

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard DivisiHead</h1>
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
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i>Total Data</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#proposal-chart" data-toggle="tab">CR</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane" id="account-chart" style="position: relative; height: 300px;">
                                    <canvas id="account-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="proposal-chart" style="position: relative; height: 300px;">
                                    <canvas id="proposal-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- <section class="col-lg-5 connectedSortable">
                    <div class="card bg-gradient-light">
                        <div class="card-header border-0">
                            <h3 class="card-title"><i class="far fa-calendar-alt"></i> Calendar</h3>
                            <div class="card-tools">                    
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                    </div>
                </section> -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">CR Status by User</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Total CR</th>
                                        <th>On Progress</th>
                                        <th>Closed</th>
                                        <th>Delay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($crCounts as $crCount)
                                        <tr>
                                            <td>{{ $crCount->it_user }}</td>
                                            <td>{{ $crCount->total_count }}</td>
                                            <td>{{ $crCount->on_progress_count }}</td>
                                            <td>{{ $crCount->closed_count }}</td>
                                            <td>{{ $crCount->delay_count }}</td> <!-- Assuming pending_count exists -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    </script>
@endsection
