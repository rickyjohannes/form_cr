@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Monitoring PO</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Data Monitoring PO</li>
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
                  <div class="col-md-6 d-flex align-items-end">
                      <div class="me-2">
                          <label for="daterange">&#x1F50D; Select Filter PR Date:</label>
                          <input type="text" id="daterange" class="form-control" style="max-width: 250px;" />
                      </div>
                      <button id="filterBtn" class="btn btn-primary">Filter</button>
                  </div>
              </div>


              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>PR Number</th>
                    <th>PR Date</th>
                    <th>PR Already</th>
                    <th>PR Next</th>
                    <th>Requester</th>
                    <th>Request Date</th>
                    <th>Item Number</th>
                    <th>Material</th>
                    <th>Description 1</th>
                    <th>Description 2</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Applicant</th>
                    <th>Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>PO Number</th>
                    <th>PO Date</th>
                    <th>PO Item</th>
                    <th>PO Already</th>
                    <th>PO Next</th>
                    <th>Material 2</th>
                    <th>Description 2</th>
                    <th>PO Status</th>
                    <th>Ordered Quantity</th>
                    <th>Ordered Unit</th>
                    <th>Net Price</th>
                    <th>Currency</th>
                    <th>GR Document</th>
                    <th>GR Quantity</th>
                    <th>GR Value</th>
                    <th>Invoice Document</th>
                    <th>Posting Date</th>
                    <th>Invoice Quantity</th>
                    <th>Invoice Value</th>
                    <th>Clearing Status</th>
                    <th>Amount in Local Currency</th>
                    <th>Debit/Credit Indicator</th>
                    <th>Reference Document</th>
                    <th>Text</th>
                    <th>GR Cumulative Quantity</th>
                    <th>GR Cumulative Value</th>
                    <th>IR Cumulative Quantity</th>
                    <th>IR Cumulative Value</th>
                    <th>Date Get Data</th>
                    <th>Date Updated Get Data</th>
                    <!-- <th>Action</th> -->
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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
                url: "{{ route('data.po') }}",
                data: function (d) {
                    let dateRange = $('#daterange').val();
                    if (dateRange) {
                        let dates = dateRange.split(' - ');
                        d.badat_from = dates[0];
                        d.badat_to = dates[1];
                    }
                }
            },
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            autoWidth: false,
            responsive: false,
            dom: 'lBfrtip',
            lengthMenu: [[10, 25, 50, 100, 1000,10000], [10, 25, 50, 100, 1000, 10000]],
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
                { data: 'banfn' }, 
                { data: 'badat' }, 
                { data: 'pr_already' }, 
                { data: 'pr_next' }, 
                { data: 'ernam' }, 
                { data: 'erdat' }, 
                { data: 'bnfpo' }, 
                { data: 'matnr1' }, 
                { data: 'txz011' },
                { data: 'txz02' }, 
                { data: 'menge1' }, 
                { data: 'meins1' }, 
                { data: 'preis' }, 
                { data: 'total' },
                { data: 'afnam' }, 
                { data: 'lifnr' }, 
                { data: 'mcod1' }, 
                { data: 'ebeln' }, 
                { data: 'aedat' },
                { data: 'ebelp' }, 
                { data: 'po_already' }, 
                { data: 'po_next' }, 
                { data: 'matnr2' }, 
                { data: 'txz012' },
                { data: 'loekz' }, 
                { data: 'menge2' }, 
                { data: 'meins2' }, 
                { data: 'netwr' }, 
                { data: 'waers' },
                { data: 'mblnr' }, 
                { data: 'grjum' }, 
                { data: 'grval' }, 
                { data: 'belnr' }, 
                { data: 'budat' },
                { data: 'irjum' }, 
                { data: 'irval' }, 
                { data: 'ficlear' }, 
                { data: 'wrbtr' }, 
                { data: 'shkzg' },
                { data: 'xblnr' }, 
                { data: 'bktxt' }, 
                { data: 'begrjum' }, 
                { data: 'begrval' },
                { data: 'beirjum' }, 
                { data: 'beirval' },
                { 
                    data: 'created_at',
                    render: function(data) { return data ? new Date(data).toLocaleString() : '-'; }
                },
                { 
                    data: 'updated_at',
                    render: function(data) { return data ? new Date(data).toLocaleString() : '-'; }
                },
                // { data: 'action', orderable: false, searchable: false }
            ]
        });

        // Set value ketika user memilih tanggal baru
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        // Reset value ketika tombol "Clear" diklik
        $('#daterange').on('cancel.daterangepicker', function () {
            $(this).val('');
        });

        // Filter otomatis saat halaman dimuat
        table.ajax.reload();

        // Event ketika tombol filter ditekan
        $('#filterBtn').on('click', function () {
            table.ajax.reload();
        });

        // Event Listener untuk tombol Delete dengan SweetAlert2
        // $(document).on('click', '.delete-btn', function (e) {
        //     e.preventDefault();
        //     let id = $(this).data('id');
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: 'This action cannot be undone!',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#d33',
        //         cancelButtonColor: '#3085d6',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: '/delete/' + id,
        //                 type: 'DELETE',
        //                 data: { _token: '{{ csrf_token() }}' },
        //                 success: function (response) {
        //                     Swal.fire('Deleted!', response.message, 'success');
        //                     table.ajax.reload();
        //                 },
        //                 error: function () {
        //                     Swal.fire('Error!', 'Something went wrong.', 'error');
        //                 }
        //             });
        //         }
        //     });
        // });
    });
  </script>
  @endsection