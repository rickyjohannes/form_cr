@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Monitoring Stock</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Data Monitoring Stock</li>
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
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Type Barang</th>
                    <th>Spesifikasi Barang</th>
                    <th>Barcode</th>
                    <th>Status Transaksi</th>
                    <th>Tanggal Input</th>
                    <th>Tanggal Keluar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($monitoringstock as $monitoringstock)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $monitoringstock->type_barang }}</td>
                      <td>{{ $monitoringstock->spesifikasi_barang }}</td>
                      <td>{{ $monitoringstock->barcode }}</td>
                      <td>{{ $monitoringstock->status_transaksi }}</td>
                      <td>{{ $monitoringstock->created_at }}</td>
                      <td>{{ $monitoringstock->updated_at }}</td>
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
    // Delete Button with SweetAlert2
    $('form[id^="delete-form-"]').submit(function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if(result.isConfirmed) {
          this.submit();
        }
      })
    })
    
    // DataTables
    $('#datatable').DataTable({
        responsive: true,
        autoWidth: false,
        layout: {
            top2Start: {
                buttons: [
                    {
                        extend: 'copy',
                        titleAttr: 'Copy to Clipboard',
                        text: '<i class="fas fa-copy"></i>',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excel',
                        titleAttr: 'Export to Excel',
                        text: '<i class="fas fa-file-excel"></i>',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csv',
                        titleAttr: 'Export to CSV',
                        text: '<i class="fas fa-file-csv"></i>',
                        className: 'btn btn-warning'
                    },
                    {
                        extend: 'pdf',
                        titleAttr: 'Export to PDF',
                        text: '<i class="fas fa-file-pdf"></i>',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        titleAttr: 'Print',
                        text: '<i class="fas fa-print"></i>',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'colvis',
                        titleAttr: 'Column Visibility',
                        text: '<i class="fas fa-eye"></i>',
                        className: 'btn btn-dark'
                    }
                ]
            },
            topStart: {
                pageLength: {
                    menu: ['5', '10', '25', '50', '100']
                }
            },
            topEnd: {
                search: {
                    placeholder: 'Search here ...'
                }
            }
        }
    });
  </script>
@endsection
