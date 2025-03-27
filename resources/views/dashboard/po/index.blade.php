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
                    <th>Date Get Data</th>
                    <th>Date Update Data</th>
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