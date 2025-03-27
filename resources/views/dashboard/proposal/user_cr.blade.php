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
            <div class="card-header">
              <h3 class="card-title">Create Change Request <a class="btn btn-success" href="{{ route('proposalcr.create_cr') }}"> Create <i class="fas fa-plus"></i></a></h3>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-end mb-3">
                  <div class="form-group mb-0">
                      <label for="daterange" class="font-weight-bold text-right">&#x1F50D;Filter Date Range:</label>
                      <input type="text" id="daterange" class="form-control" style="width: 250px;" />
                  </div>
              </div>
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>No.</th>
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
                      <th>Status DH</th>
                      <th>Action Date DH</th>
                      <th>Status DIVH</th>
                      <th>Action Date DIVH</th>
                      <th>Submission Date/Time</th>
                      <th>Estimated Date/Time</th>
                      <th>Action Close IT Date/Time</th>
                      <th>IT User</th>
                      <th>IT Note</th>
                      <th>No Asset IT</th>
                      <th>File Attachment IT</th>
                      <th>Status CR</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                <tbody>
                  @foreach ($proposals as $proposal)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
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
                          @if ($proposal->status_dh === 'pending')
                          <span class="badge badge-warning">Pending</span>
                          <br/>
                           @if ($proposal->actiondate_dh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_dh)->diffForHumans() }}</small>
                           @endif
                          @elseif ($proposal->status_dh === 'approved')
                          <span class="badge badge-success">Approved</span>
                          <br/>
                           @if ($proposal->actiondate_dh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_dh)->diffForHumans() }}</small>
                           @endif
                          @elseif ($proposal->status_dh === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          <br/>
                           @if ($proposal->actiondate_dh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_dh)->diffForHumans() }}</small>
                           @endif
                          @endif
                        </td>
                        <td>
                          @if ($proposal->actiondate_dh)
                              <a>{{ \Carbon\Carbon::parse($proposal->actiondate_dh)->format('d-m-Y h:i:s') }}</a>
                            @endif
                        </td>
                        <td>
                            @if ($proposal->status_divh === 'pending')
                            <span class="badge badge-warning">Pending</span>
                            <br/>
                              @if ($proposal->actiondate_divh)
                                <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_divh)->diffForHumans() }}</small>
                              @endif
                            @elseif ($proposal->status_divh === 'approved')
                            <span class="badge badge-success">Approved</span>
                            <br/>
                              @if ($proposal->actiondate_divh)
                                <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_divh)->diffForHumans() }}</small>
                              @endif
                            @elseif ($proposal->status_divh === 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                              <br/>
                              @if ($proposal->actiondate_divh)
                                <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_divh)->diffForHumans() }}</small>
                              @endif
                            @endif
                        </td>
                        <td>
                          @if ($proposal->actiondate_divh)
                              <a>{{ \Carbon\Carbon::parse($proposal->actiondate_divh)->format('d-m-Y h:i:s') }}</a>
                            @endif
                        </td>
                        <td>
                          <a> {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y h:i:s') }}</a>
                        </td>
                        <td>
                          @if ($proposal->estimated_date)
                              <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y h:i:s') }}</a>
                            @endif
                        </td>
                        <td>
                          @if ($proposal->close_date)
                              <a>{{ \Carbon\Carbon::parse($proposal->close_date)->format('d-m-Y h:i:s') }}</a>
                            @endif
                        </td>
                        <td>{{ $proposal->it_user }}</td>
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
                              @switch($proposal->status_cr)
                              
                                  @case('Open To IT')
                                      <span class="text-warning">Open To IT</span>
                                      @break

                                  @case('ON PROGRESS')
                                      <span class="text-warning">{{ $proposal->status_cr }}</span>
                                      @foreach (['user' => 'Closed All'] as $role => $status)
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

                                  @case('Closed With IT')
                                      <span class="text-info">{{ $proposal->status_cr }}</span>
                                      @foreach (['user' => 'Closed All'] as $role => $status)
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

                                  @case('Closed All')
                                      <span class="text-success">Closed All</span>
                                      @break

                                  @case('Auto Close')
                                      <span class="text-success">Auto Closed</span>
                                      @break

                                  @case('Close By Rejected')
                                      <span class="text-danger">Close By Rejected</span>
                                      @break

                                  @case('Closed IT With Delay')
                                      <span class="text-danger">Closed IT With Delay</span>
                                      @break

                                  @case('Closed With Delay')
                                      <span class="text-danger">Closed With Delay</span>
                                      @break

                                  @case('Auto Closed With Delay')
                                      <span class="text-danger">Auto Closed With Delay</span>
                                      @break

                                  @default
                                      <span class="text-muted">Open</span>
                              @endswitch
                        </td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu">
                              @if($proposal->status == 'approved')
                                <form action="{{ route('proposal.print', $proposal->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success dropdown-item" type="submit"><i class="fas fa-print"></i> Print</button>
                                </form>
                              @endif
                              <a class="btn btn-warning dropdown-item" href="{{ route('proposal.edit', $proposal->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                              <form action="{{ route('proposal.destroy', $proposal->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger dropdown-item" type="submit"><i class="fas fa-trash"></i> Delete</button>
                              </form>
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
  </section>
@endsection


@section('script')
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

    // Initialize Daterangepicker with default range for the current month
    var startDate = moment().startOf('month');
    var endDate = moment().endOf('month');

    $('#daterange').daterangepicker({
        opens: 'left',
        startDate: startDate,
        endDate: endDate,
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    // Set the initial input value
    $('#daterange').val(startDate.format('DD-MM-YYYY') + ' - ' + endDate.format('DD-MM-YYYY'));

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        filterTable(); // Trigger filter when date is applied
    });

    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        filterTable(); // Trigger filter when date is cleared
    });

    // Input event for manual date entry
    $('#daterange').on('input', function() {
        filterTable(); // Trigger filter on manual input
    });

  // Function to filter the table
  function filterTable() {
      var dateRange = $('#daterange').val().split(' - ');

      var startDate = dateRange[0] ? new Date(dateRange[0].split('-').reverse().join('-') + 'T00:00:00') : null; // Start of the day
      var endDate = dateRange[1] ? new Date(dateRange[1].split('-').reverse().join('-') + 'T23:59:59') : null; // End of the day

      // Clear any previous search
      $.fn.dataTable.ext.search = []; // Clear all previous search filters

      // Apply the date range filter based on created_at
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
          var createdAtStr = (data[13] || '').trim(); // Indeks untuk created_at, ubah ke data[13]
          var createdAt;

          if (createdAtStr) {
              // Format yang digunakan di Blade adalah d-m-Y h:i:s (contoh: 06-11-2024 03:45:23)
              // Ubah format menjadi YYYY-MM-DDTHH:mm:ss agar bisa dibaca oleh JavaScript
              var parts = createdAtStr.split(' ');
              if (parts.length === 2) { // Pastikan ada bagian tanggal dan waktu
                  var dateParts = parts[0].split('-'); // [DD, MM, YYYY]
                  var time = parts[1]; // HH:MM:SS

                  // Ubah urutan menjadi YYYY-MM-DDTHH:MM:SS
                  var formattedDateStr = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}T${time}`; // YYYY-MM-DDTHH:MM:SS
                  createdAt = new Date(formattedDateStr);
              }
          }

          // Check if the created date is in the range
          var isValidDate = createdAt && !isNaN(createdAt);
          var isInRange = (!startDate || (isValidDate && createdAt >= startDate)) && (!endDate || (isValidDate && createdAt <= endDate));

          return isInRange;
      });

      // Redraw the table
      table.draw();
  }
  
</script>
@endsection
