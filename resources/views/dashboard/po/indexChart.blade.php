@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Monitoring PR & PO</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Data Monitoring PR & PO</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12 d-flex align-items-end flex-wrap gap-3">
                    <div class="me-3">
                        <label for="daterange">&#xE163; Filter Range PR Date:</label>
                        <input type="text" id="daterange" class="form-control" style="max-width: 250px;" />
                    </div>
                    <div class="me-3">
                        <label for="banfn">&#xE14C; Filter No PR:</label>
                        <input type="text" id="banfn" class="form-control" style="max-width: 250px;" />
                    </div>
                    <div class="me-3">
                        <label for="ebeln">&#xE130; Filter No PO:</label>
                        <input type="text" id="ebeln" class="form-control" style="max-width: 250px;" />
                    </div>
                    <div class="me-3">
                        <label for="matnr1">&#xE123; Filter Material:</label>
                        <input type="text" id="matnr1" class="form-control" style="max-width: 250px;" />
                    </div>
                    <div class="me-3">
                        <label for="afnam">&#xE125; Filter Requisnr:</label>
                        <input type="text" id="afnam" class="form-control" style="max-width: 250px;" />
                    </div>
                    <div class="me-3">
                        <label for="ernam">&#xE125; Filter Created By</label>
                        <input type="text" id="ernam" class="form-control" style="max-width: 250px;" />
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-warning" id="clearFilter">
                            <i class="fas fa-times"></i> Clear Filter
                        </button>
                    </div>
                </div>
            </div>


              <!-- Modal -->
              <div class="row">
                  @foreach ([ 
                      ['bg' => 'bg-gradient-warning', 'icon' => 'fas fa-clock', 'text' => 'Total PR Non Approve', 'id' => 'prNonApprove'],
                      ['bg' => 'bg-success', 'icon' => 'fas fa-check-circle', 'text' => 'Total PR Fully Approve', 'id' => 'prFullyApprove'],
                      ['bg' => 'bg-gradient-warning', 'icon' => 'fas fa-clock', 'text' => 'Total PO Non Approve', 'id' => 'poNonApprove'],
                      ['bg' => 'bg-success', 'icon' => 'fas fa-check-circle', 'text' => 'Total PO Fully Approve', 'id' => 'poFullyApprove']
                  ] as $item)
                  <div class="col-lg-3 col-6">
                      <div class="info-box shadow">
                          <a href="javascript:void(0)" class="info-box-icon {{ $item['bg'] }}" data-toggle="modal" data-target="#crModal" data-status="{{ $item['text'] }}">
                              <i class="{{ $item['icon'] }}"></i>
                          </a>
                          <div class="info-box-content">
                              <span class="info-box-text">{{ $item['text'] }}</span>
                              <span class="info-box-number" id="{{ $item['id'] }}">0</span> <!-- Default 0, nanti diperbarui lewat AJAX -->
                          </div>
                      </div>
                  </div>
                  @endforeach
              </div>


              <div class="row">
                  <!-- Chart PR Non Approve vs Fully Approve -->
                  <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Total PR Non Approve vs Fully Approve</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="prChart" style="max-width: 100%; max-height: 350px;"></canvas>
                        </div>
                    </div>
                  </section>

                  <!-- Chart PO Non Approve vs Fully Approve -->
                <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i> Total PO Non Approve vs Fully Approve
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md-3">
                                    <span class="badge badge-warning">PR Belum Jadi PO:</span>
                                    <h5 id="prsnBelumJadiPO">0%</h5>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="badge badge-primary">PR Sudah jadi PO:</span>
                                    <h5 id="prsnPOdariPRapprove">0%</h5>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="badge badge-success">PO Fully Approve:</span>
                                    <h5 id="prsnPOapprove">0%</h5>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="badge badge-danger">PO Non Approve:</span>
                                    <h5 id="prsnPOnonapprove">0%</h5>
                                </div>
                            </div>
                            <canvas id="poChart" style="max-width: 100%; max-height: 350px;"></canvas>
                        </div>
                    </div>
                </section>

                  <!-- Chart Avarage Lead Time -->
                  <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Avarage LeadTime PR To PO</h3>
                        </div>
                        <div class="card-body">
                           <canvas id="LeadTimeChart" style="max-width: 100%; max-height: 350px;"></canvas>
                        </div>
                    </div>
                  </section>

                   <!-- Chart Avarage Lead Time PR vs Lead Time PO -->
                   <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Avarage LeadTime Approval PR vs PO</h3>
                        </div>
                        <div class="card-body">
                           <canvas id="LeadTimePRPOChart" style="max-width: 100%; max-height: 350px;"></canvas>
                        </div>
                    </div>
                  </section>
              </div>

              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Purchase Req.</th>
                    <th>Req. Date</th>
                    <th>Approval Name PR</th>
                    <th>Next Approval PR</th>
                    <th>Created By</th>
                    <th>Changed On</th>
                    <th>Item</th>
                    <th>Material</th>
                    <th>Short Text PR</th>
                    <th>Long Text PR</th>
                    <th>Quantity</th>
                    <th>Satuan</th>
                    <th>Val. Price</th>
                    <th>Total Value</th>
                    <th>Requisnr.</th>
                    <th>Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>PO</th>
                    <th>PO Date</th>
                    <th>Item</th>
                    <th>Approval Name PO</th>
                    <th>Next Approval PO</th>
                    <th>Material</th>
                    <th>Short Text PO / Contract</th>
                    <th>Delete Indicator</th>
                    <th>Order Quantity</th>
                    <th>Order Unit</th>
                    <th>Net Order Price</th>
                    <th>Crcy</th>
                    <th>Mtr Doc. (GR No)</th>
                    <th>GR Quantity</th>
                    <th>GR Value</th>
                    <th>IR Doc.</th>
                    <th>Posting Date</th>
                    <th>IR Quantity</th>
                    <th>IR Value</th>
                    <th>Doc Clearing</th>
                    <th>Clrng Value</th>
                    <th>Debt/Credit Ind.</th>
                    <th>Reff on IR</th>
                    <th>Header Text on IR</th>
                    <th>To Be Delivered (Qty)</th>
                    <th>To Be Delivered (Value)</th>
                    <th>Still to be invoic. (Qty)</th>
                    <th>Still to be invoic. (Value)</th>
                    <th>PR Lead Time</th>
                    <th>PR Status</th>
                    <th>PO Lead Time</th>
                    <th>PO Status</th>
                    <th>PR to PO Lead Time</th>
                    <th>PR Currency</th>
                    <th>Date Get Data</th>
                    <th>Date Update Data</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('style')
<style>
  #datatable_wrapper {
    overflow-x: auto;
  }
</style>
@endsection

@section('script')
<!-- Stylesheets -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    $(document).ready(function () {
        // Ambil tanggal awal & akhir bulan berjalan
        let startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
        let endOfMonth = moment().endOf('month').format('YYYY-MM-DD');

        // Inisialisasi Daterangepicker dengan default bulan berjalan
        $('#daterange').daterangepicker({
            startDate: startOfMonth,
            endDate: endOfMonth,
            opens: 'left',
            autoUpdateInput: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        // Set input dengan tanggal default
        $('#daterange').val(startOfMonth + ' - ' + endOfMonth);

        // Inisialisasi DataTables dengan filter default
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dataChart.po') }}",
                data: function (d) {
                    let dateRange = $('#daterange').val();
                    if (dateRange) {
                        let dates = dateRange.split(' - ');
                        d.badat_from = dates[0];
                        d.badat_to = dates[1];
                    }
                    d.banfn = $('#banfn').val();
                    d.ebeln = $('#ebeln').val();
                    d.matnr1 = $('#matnr1').val();
                    d.afnam = $('#afnam').val();
                    d.ernam = $('#ernam').val();
                }
            },
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            autoWidth: false,
            responsive: false,
            dom: 'lBfrtip',
            lengthMenu: [[10, 25, 50, 100, 1000, 10000], [10, 25, 50, 100, 1000, 10000]],
            pageLength: 10,
            buttons: [
                { extend: 'copy', className: 'btn btn-secondary' },
                { extend: 'excel', className: 'btn btn-success' },
                { extend: 'csv', className: 'btn btn-warning' },
                { extend: 'pdf', className: 'btn btn-danger' },
                { extend: 'print', className: 'btn btn-info' },
                { extend: 'colvis', className: 'btn btn-dark' }
            ],
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'banfn' }, { data: 'badat' }, { data: 'pr_already' }, { data: 'pr_next' }, 
                { data: 'ernam' }, { data: 'erdat' }, { data: 'bnfpo' }, { data: 'matnr1' }, { data: 'txz011' },
                { data: 'txz02' }, { data: 'menge1' }, { data: 'meins1' }, { data: 'preis' }, { data: 'total' },
                { data: 'afnam' }, { data: 'lifnr' }, { data: 'mcod1' }, { data: 'ebeln' }, { data: 'aedat' },
                { data: 'ebelp' }, { data: 'po_already' }, { data: 'po_next' }, { data: 'matnr2' }, { data: 'txz012' },
                { data: 'loekz' }, { data: 'menge2' }, { data: 'meins2' }, { data: 'netwr' }, { data: 'waers' },
                { data: 'mblnr' }, { data: 'grjum' }, { data: 'grval' }, { data: 'belnr' }, { data: 'budat' },
                { data: 'irjum' }, { data: 'irval' }, { data: 'ficlear' }, { data: 'wrbtr' }, { data: 'shkzg' },
                { data: 'xblnr' }, { data: 'bktxt' }, { data: 'begrjum' }, { data: 'begrval' },
                { data: 'beirjum' }, { data: 'beirval' }, { data: 'leadtime_pr' }, { data: 'status_pr' },
                { data: 'leadtime_po' }, { data: 'status_po' }, { data: 'leadtime_prpo' }, { data: 'waers_pr' },
                { 
                    data: 'created_at',
                    render: function(data) { return data ? new Date(data).toLocaleString() : '-'; }
                },
                { 
                    data: 'updated_at',
                    render: function(data) { return data ? new Date(data).toLocaleString() : '-'; }
                },
            ]
        });

        // Fungsi debounce untuk menghindari request berlebihan saat user mengetik
        function debounce(func, wait) {
            let timeout;
            return function () {
                let context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        // Filter otomatis untuk DataTables
        function applyFilter() {
            table.ajax.reload();
        }

        // Event listener untuk filter tanggal
        $('#daterange').on('apply.daterangepicker', function () {
            applyFilter();
        });

        // Event listener untuk input filter dengan debounce (500ms)
        $('#banfn, #ebeln,#matnr1, #afnam, #ernam').on('keyup', debounce(applyFilter, 500));

    });
</script>
<script>
  $(document).ready(function () {
      // Daftarkan Chart.js Datalabels Plugin
      Chart.register(ChartDataLabels);

      let startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
      let endOfMonth = moment().endOf('month').format('YYYY-MM-DD');

      if (!$('#daterange').val()) {
          $('#daterange').val(`${startOfMonth} - ${endOfMonth}`);
      }

      function showLoadingState() {
          $("#prNonApprove, #prFullyApprove, #poNonApprove, #poFullyApprove, #LeadTime, #LeadTimePR, #LeadTimePO").text("Loading...");
      }

      function hideLoadingState(response) {
          $("#prNonApprove").text(response.pr_non_approve);
          $("#prFullyApprove").text(response.pr_fully_approve);
          $("#poNonApprove").text(response.po_non_approve);
          $("#poFullyApprove").text(response.po_fully_approve);
          $("#LeadTime").text(response.LeadTime);
          $("#LeadTimePR").text(response.LeadTimePR);
          $("#LeadTimePO").text(response.LeadTimePO);
          $("#prsnBelumJadiPO").text(response.persentase_pr_belum_jadi_po + "%");
          $("#prsnPOdariPRapprove").text(response.persentase_po_dari_pr_approve + "%");
          $("#prsnPOapprove").text(response.persentase_po_fully_approve + "%");
          $("#prsnPOnonapprove").text(response.persentase_po_belum_approve + "%");
      }

      function clearCharts() {
          if (window.prChartInstance) window.prChartInstance.destroy();
          if (window.poChartInstance) window.poChartInstance.destroy();
          if (window.LeadTimeChartInstance) window.LeadTimeChartInstance.destroy();
          if (window.LeadTimePRPOChartInstance) window.LeadTimePRPOChartInstance.destroy();
      }

      function loadChart() {
          let dateRange = $('#daterange').val().split(' - ');
          let badat_from = dateRange.length > 1 ? dateRange[0] : startOfMonth;
          let badat_to = dateRange.length > 1 ? dateRange[1] : endOfMonth;
          let banfn = $('#banfn').val();
          let ebeln = $('#ebeln').val();
          let matnr1 = $('#matnr1').val();
          let afnam = $('#afnam').val();
          let ernam = $('#ernam').val();

          showLoadingState();

          $.ajax({
              url: "{{ route('Chart.po') }}",
              type: "GET",
              data: {
                  badat_from: badat_from,
                  badat_to: badat_to,
                  banfn: banfn,
                  ebeln: ebeln,
                  matnr1: matnr1,
                  afnam: afnam,
                  ernam: ernam
              },
              dataType: "json",
              success: function (response) {
                  console.log(response);

                  hideLoadingState(response);

                  if (response.pr_non_approve !== undefined && response.pr_fully_approve !== undefined &&
                      response.po_non_approve !== undefined && response.po_fully_approve !== undefined &&
                      response.LeadTime !== undefined && response.LeadTimePR !== undefined && response.LeadTimePO !== undefined
                      && response.persentase_pr_belum_jadi_po !== undefined && response.persentase_po_dari_pr_approve !== undefined
                      && response.persentase_po_fully_approve !== undefined && response.persentase_po_belum_approve !== undefined) {
                      renderChart(response.pr_non_approve, response.pr_fully_approve, 
                                  response.po_non_approve, response.po_fully_approve,
                                  response.LeadTime, response.LeadTimePR, response.LeadTimePO);
                  } else {
                      console.error("Data chart tidak ditemukan:", response);
                  }
              },
              error: function (xhr, status, error) {
                  console.error("Error fetching chart data:", error);
              }
          });
      }

      function renderChart(prNonApprove, prApprove, poNonApprove, poApprove, LeadTime, LeadTimePR, LeadTimePO,prsnBelumJadiPO,prsnPOdariPRapprove,prsnPOapprove,prsnPOnonapprove) {
          let prCtx = document.getElementById("prChart").getContext("2d");
          let poCtx = document.getElementById("poChart").getContext("2d");
          let LeadTimeCtx = document.getElementById("LeadTimeChart").getContext("2d");
          let LeadTimePRPOCtx = document.getElementById("LeadTimePRPOChart").getContext("2d");

          clearCharts();

          let chartOptions = {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  datalabels: {
                      color: '#fff',
                      font: {
                          weight: 'bold',
                          size: 20
                      },
                      anchor: 'center',
                      align: 'center',
                      formatter: (value) => value.toLocaleString()
                  }
              }
          };

          window.prChartInstance = new Chart(prCtx, {
              type: "pie",
              data: {
                  labels: ["PR Non Approve", "PR Fully Approve"],
                  datasets: [{
                      data: [prNonApprove, prApprove],
                      backgroundColor: ["#FF6384", "#36A2EB"]
                  }]
              },
              options: chartOptions
          });

          window.poChartInstance = new Chart(poCtx, {
              type: "pie",
              data: {
                  labels: ["PO Non Approve", "PO Fully Approve"],
                  datasets: [{
                      data: [poNonApprove, poApprove],
                      backgroundColor: ["#FF9F40", "#4BC0C0"]
                  }]
              },
              options: chartOptions
          });

          window.LeadTimeChartInstance = new Chart(LeadTimeCtx, {
              type: "pie",
              data: {
                  labels: ["Average Lead Time (Day)"],
                  datasets: [{
                      data: [parseFloat(LeadTime) || 0],
                      backgroundColor: ["#FF9F40"]
                  }]
              },
              options: chartOptions
          });

          window.LeadTimePRPOChartInstance = new Chart(LeadTimePRPOCtx, {
              type: "pie",
              data: {
                  labels: ["Lead Time Approval PR", "Lead Time Approval PO"],
                  datasets: [{
                       data: [parseFloat(LeadTimePR) || 0, parseFloat(LeadTimePO) || 0],
                       borderColor: ['#2980b9', '#27ae60'],
                       backgroundColor: ['#3498db', '#2ecc71']
                   }]
            },
              options: chartOptions
          });
      }

      loadChart();

      $('#daterange').on('apply.daterangepicker', function () {
          loadChart();
      });

      function debounce(func, wait) {
          let timeout;
          return function () {
              let context = this, args = arguments;
              clearTimeout(timeout);
              timeout = setTimeout(() => func.apply(context, args), wait);
          };
      }

      $('#banfn,#ebeln,#matnr1, #afnam, #ernam').on('keyup', debounce(loadChart, 500));
      $('#daterange').on('apply.daterangepicker', function () {
          loadChart();
      });

  });
</script>
<script>
    document.getElementById('clearFilter').addEventListener('click', function() {
        document.getElementById('daterange').value = '';
        document.getElementById('banfn').value = '';
        document.getElementById('ebeln').value = '';
        document.getElementById('matnr1').value = '';
        document.getElementById('afnam').value = '';
        document.getElementById('ernam').value = '';
    });
</script>
@endsection
