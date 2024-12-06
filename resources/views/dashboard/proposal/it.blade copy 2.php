@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>FORM CR</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">FORM CR</li>
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
            <!-- <div class="card-header">
              <h3 class="card-title">Data CR <a class="btn btn-success" href="{{ route('proposal.create') }}"> Create <i class="fas fa-plus"></i></a></h3>
            </div> -->
            <div class="card-body">
              <div class="d-flex justify-content-end mb-3">
                <div class="form-group mb-0">
                  <label for="daterange" class="font-weight-bold text-right">&#x1F50D;Filter Date Range:</label>
                  <input type="text" id="daterange" class="form-control" style="width: 250px;" />
                </div>
                <div class="form-group mb-0">
                  <label for="status_barang" class="font-weight-bold text-right">&#x1F50D; Filter Status Barang:</label>
                  <select id="status_barang" name="status_barang" class="form-control" style="width: 250px;">
                      <option value="">Select Status</option>
                      <option value="Pembelian">Pembelian</option>
                      <option value="Change Request">Change Request</option>
                      <option value="Pergantian">Pergantian</option>
                      <option value="Peminjaman">Peminjaman</option>
                      <option value="IT Helpdesk">IT Helpdesk</option>
                  </select>
                </div>
              </div>

              

              <!-- Add a wrapper div to enable horizontal scroll -->
              <div style="overflow-x: auto;">
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Status CR</th>
                      <th>No Doc CR</th>
                      <th>User / Requester</th>
                      <th>Position</th>
                      <th>Departement</th>
                      <th>Phone</th>
                      <th>Jenis Permintaan</th>
                      <th>Kategori</th>
                      <th>Facility</th>
                      <th>User Notes</th>
                      <th>No Asset User</th>
                      <th>File Attachment User</th>
                      <th>Status Approved</th>
                      <th>Action Date Approved</th>
                      <th>Date of Submission</th>
                      <th>Estimated Start Date</th>
                      <th>Request Completion Date</th>
                      <th>IT User</th>
                      <th>Estimated Completion Date</th>
                      <th>IT Note</th>
                      <th>No Asset IT</th>
                      <th>File Attachment IT</th>
                      <th>IT CR Closure Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($proposalsit as $proposal)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                          @switch($proposal->status_cr)
                            @case('Open To IT')
                              <b><span class="badge badge-warning">Open To IT</span></b>
                              @break

                            @case('ON PROGRESS')
                              <b><span class="badge badge-warning">On Progress</span></b>
                              @foreach (['user' => 'Closed'] as $role => $status)
                                @if (Auth::user()->role->name === $role)
                                  <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_cr" value="{{ $status }}">
                                    <button class="btn {{ $role === 'user' ? 'btn-success' : 'btn-success' }} btn-sm" type="submit">{{ $status }}</button>
                                  </form>
                                @endif
                              @endforeach
                              @break

                            @case('Closed By IT')
                              <b><span class="badge badge-info">Closed By IT</span></b>
                              @break

                            @case('Closed')
                              <b><span class="badge badge-success">Closed By User</span></b>
                              @break

                            @case('Auto Close')
                              <b><span class="badge badge-success">Auto Closed</span></b>
                              @break

                            @case('Closed By Rejected')
                              <b></b> <span class="badge badge-danger">Closed By Rejected</span></b>
                              @break

                            @case('Closed By IT With Delay')
                              <b><span class="badge badge-danger">Closed By IT With Delay</span></b>
                              @break

                            @case('Closed With Delay')
                              <b><span class="badge badge-danger">Closed With Delay</span></b>
                              @break
                              
                            @case('DELAY')
                              <b><span class="badge badge-danger">DELAY</span></b>
                              @break

                            @default
                              <b><span class="badge badge-dark">OPEN</span></b>
                          @endswitch
                        </td>
                        <td>{{ $proposal->no_transaksi }}</td>
                        <td>{{ $proposal->user_request }}</td>
                        <td>{{ $proposal->user_status }}</td>
                        <td>{{ $proposal->departement }}</td>
                        <td>{{ $proposal->ext_phone }}</td>
                        <td>{{ $proposal->status_barang }}</td>
                        <td>{{ $proposal->kategori }}</td>
                        <td>{{ $proposal->facility }}</td>
                        <td>{{ $proposal->user_note }}</td>
                        <td>{{ $proposal->no_asset_user }}</td>
                        <td>
                          @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
                            <a href="{{ url('uploads/' . $proposal->file) }}" class="btn btn-primary">Unduh File</a>
                            <b><label>{{ $proposal->file }}</label></b>
                          @else
                            <i><span class="text-danger">File Tidak Ditemukan!</span></i>
                          @endif
                        </td>
                        <td>
                          @if ($proposal->status_apr === 'pending')
                            <span class="badge badge-warning">Pending</span>
                            <br />
                            @if ($proposal->actiondate_apr)
                              <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                            @endif
                          @elseif ($proposal->status_apr === 'partially_approved')
                            <span class="badge badge-warning">Partially Approved</span>
                            <br />
                            @if ($proposal->actiondate_apr)
                              <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                            @endif
                          @elseif ($proposal->status_apr === 'fully_approved')
                            <span class="badge badge-success">Fully Approved</span>
                            <br />
                            @if ($proposal->actiondate_apr)
                              <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                            @endif
                          @elseif ($proposal->status_apr === 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                            <br />
                            @if ($proposal->actiondate_apr)
                              <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                            @endif
                          @endif
                        </td>
                        <td>
                          @if ($proposal->actiondate_apr)
                            <a>{{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y H:i:s') }}</a>
                          @endif
                        </td>
                        <td>
                          <a> {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y H:i:s') }}</a>
                        </td>
                        <td>
                          @if ($proposal->estimated_start_date)
                            <a>{{ \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d-m-Y H:i:s') }}</a>
                          @endif
                        </td>
                        <td>
                          @if ($proposal->estimated_date)
                            <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y H:i:s') }}</a>
                          @endif
                        </td>
                        <td>{{ $proposal->it_user }}</td>
                        <td>
                          @if ($proposal->action_it_date)
                            <a>{{ \Carbon\Carbon::parse($proposal->action_it_date)->format('d-m-Y H:i:s') }}</a>
                          @endif
                        </td>
                        <td>{{ $proposal->it_analys }}</td>
                        <td>{{ $proposal->no_asset }}</td>
                        <td>
                          @if (!empty($proposal->file_it) && file_exists(public_path('uploads/' . $proposal->file_it)))
                            <a href="{{ url('uploads/' . $proposal->file_it) }}" class="btn btn-primary">Unduh File</a>
                            <b><label>{{ $proposal->file_it }}</label></b>
                          @else
                            <i><span class="text-danger">File Tidak Ditemukan!</span></i>
                          @endif
                        </td>
                        <td>
                          @if ($proposal->close_date)
                            <a>{{ \Carbon\Carbon::parse($proposal->close_date)->format('d-m-Y H:i:s') }}</a>
                          @endif
                        </td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu">
                              @if($proposal->status_apr == 'fully_approved')
                                <form action="{{ route('proposal.print', $proposal->id) }}" method="POST">
                                  @csrf
                                  <a class="btn btn-warning dropdown-item" href="{{ route('proposal.editit', $proposal->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                  <button class="btn btn-success dropdown-item" type="submit"><i class="fas fa-print"></i> Print</button>
                                </form>
                              @endif
                              <a class="btn btn-warning dropdown-item" href="{{ route('proposal.show', $proposal->id) }}"><i class="fas fa-list"></i> Show</a>
                            </div>
                          </div>
                        </td>
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
<!-- Link untuk CSS dan JS Daterangepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    // Delete Button with SweetAlert2
    $('#delete-form').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // Initialize DataTables
    var table = $('#datatable').DataTable({
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

    // Initialize Daterangepicker dengan range default untuk bulan ini
    var startDate = moment().startOf('month');
    var endDate = moment().endOf('month');

    $('#daterange').daterangepicker({
        opens: 'left',
        startDate: startDate,
        endDate: endDate,
        autoUpdateInput: true,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    // Set input value awal
    $('#daterange').val(startDate.format('DD-MM-YYYY') + ' - ' + endDate.format('DD-MM-YYYY'));

    // Event apply pada daterangepicker
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        filterTable(); // Trigger filter ketika tanggal diterapkan
    });

    // Event cancel pada daterangepicker
    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        filterTable(); // Trigger filter ketika tanggal dihapus
    });

    // Input event untuk input manual pada tanggal
    $('#daterange').on('input', function() {
        filterTable(); // Trigger filter pada input manual
    });

    // Trigger filter ketika status berubah
    $('#status_barang').change(function() {
        filterTable(); // Trigger filter ketika status diubah
    });

    function filterTable() {
        var dateRange = $('#daterange').val().split(' - ');

        // Parse tanggal mulai dan akhir
        var startDate = dateRange[0] ? moment(dateRange[0], 'DD-MM-YYYY').startOf('day').toDate() : null; // Awal hari
        var endDate = dateRange[1] ? moment(dateRange[1], 'DD-MM-YYYY').endOf('day').toDate() : null; // Akhir hari
        var statusFilter = $('#status_barang').val(); // Ambil status yang dipilih

        // Hapus filter pencarian sebelumnya
        $.fn.dataTable.ext.search = []; // Hapus semua filter pencarian sebelumnya

        // Terapkan filter berdasarkan rentang tanggal
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var createdAtStr = (data[15] || '').trim(); // Asumsi "Date of Submission" berada di kolom ke-16 (index 15)
            var createdAt;

            if (createdAtStr) {
                // Parse tanggal dari format 'DD-MM-YYYY HH:mm:ss' ke objek JavaScript Date
                createdAt = moment(createdAtStr, 'DD-MM-YYYY HH:mm:ss').toDate();
            }

            var isValidDate = createdAt && !isNaN(createdAt);
            var isInRange = true;

            // Jika tanggal mulai atau tanggal akhir disediakan, periksa apakah createdAt ada dalam rentang
            if (startDate && endDate) {
                isInRange = createdAt >= startDate && createdAt <= endDate;
            } else if (startDate) {
                isInRange = createdAt >= startDate;
            } else if (endDate) {
                isInRange = createdAt <= endDate;
            }

            return isInRange;
        });

        // Terapkan filter berdasarkan status
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var statusBarang = data[7]; // Asumsi 'status_barang' ada di kolom ke-8 (index 7)

            console.log("Filtering by Status: ", statusBarang, " Selected Status: ", statusFilter);

            if (!statusFilter) {
                return true; // Jika tidak ada filter status yang dipilih, tampilkan semua
            }

            return statusBarang === statusFilter; // Hanya tampilkan baris yang sesuai dengan status yang dipilih
        });

        // Gambar ulang tabel dengan filter yang diterapkan
        table.draw();
    }

</script>
@endsection
