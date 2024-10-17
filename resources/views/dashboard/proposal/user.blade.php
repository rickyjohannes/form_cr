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
              <h3 class="card-title">Data CR <a class="btn btn-success" href="{{ route('proposal.create') }}"> Create <i class="fas fa-plus"></i></a></h3>
            </div>

            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>No Doc CR</th>
                    <th>User / Requester</th>
                    <th>User Status</th>
                    <th>Departement</th>
                    <th>Ext / Phone</th>
                    <th>Status Barang</th>
                    <th>Facility</th>
                    <th>User Notes</th>
                    <th>File Attachment User</th>
                    <th>Status DH</th>
                    <th>Status DIVH</th>
                    <th>Approve Date/Time</th>
                    <th>Submission Date</th>
                    <th>IT Note</th>
                    <th>No Asset</th>
                    <th>File Attachment IT</th>
                    <th>Status CR</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($proposals as $proposal)
                  @if ($proposal->user_id == Auth::user()->id && auth()->user()->departement == $proposal->departement)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $proposal->no_transaksi }}</td>
                        <td>{{ $proposal->user_request }}</td>
                        <td>{{ $proposal->user_status }}</td>
                        <td>{{ $proposal->departement }}</td>
                        <td>{{ $proposal->ext_phone }}</td>
                        <td>{{ $proposal->status_barang }}</td>
                        <td>{{ $proposal->facility }}</td>
                        <td>{{ $proposal->user_note }}</td>
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
                          <small>Pending {{ $proposal->created_at->diffForHumans() }}</small>
                          @elseif ($proposal->status_dh === 'approved')
                          <span class="badge badge-success">Approved</span>
                          <br/>
                          <small>Approve {{ $proposal->updated_at->diffForHumans() }}</small>
                          @elseif ($proposal->status_dh === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          <br/>
                          <small>Rejected {{ $proposal->updated_at->diffForHumans() }}</small>
                          @endif
                          </td>
                        <td>
                            @if ($proposal->status_divh === 'pending')
                            <span class="badge badge-warning">Pending</span>
                            <br/>
                            <small>Pending {{ $proposal->created_at->diffForHumans() }}</small>
                            @elseif ($proposal->status_divh === 'approved')
                            <span class="badge badge-success">Approved</span>
                            <br/>
                            <small>Approve {{ $proposal->updated_at->diffForHumans() }}</small>
                            @elseif ($proposal->status_divh === 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                            <br/>
                            <small>Rejected {{ $proposal->updated_at->diffForHumans() }}</small>
                            @endif
                        </td>
                        <td>
                          <a>{{ $proposal->updated_at->format('d-m-Y h:i:s') }}</a>
                        </td>
                        <td>
                          <a>{{ $proposal->created_at->format('d-m-Y') }}</a>
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
                          @switch($proposal->status_cr)
                              @case('ON PROGRESS')
                                  <span class="text-warning">{{ $proposal->status_cr }}</span>
                                  @if (Auth::user()->role->name === 'user')
                                      <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                          @csrf
                                          @method('PATCH')
                                          <input type="hidden" name="status_cr" value="CR Closed">
                                          <button class="btn btn-success btn-sm" type="submit">CR Closed</button>
                                      </form>
                                  @elseif (Auth::user()->role->name === 'it')
                                      <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                          @csrf
                                          @method('PATCH')
                                          <input type="hidden" name="status_cr" value="Closed With IT">
                                          <button class="btn btn-danger btn-sm" type="submit">Closed CR With IT</button>
                                      </form>
                                  @endif
                                  @break

                              @case('Closed With IT')
                                  <span class="text-info">{{ $proposal->status_cr }}</span>
                                  @if (Auth::user()->role->name === 'user')
                                      <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                          @csrf
                                          @method('PATCH')
                                          <input type="hidden" name="status_cr" value="CR Closed">
                                          <button class="btn btn-success btn-sm" type="submit">CR Closed</button>
                                      </form>
                                  @endif
                                  @break

                              @case('CR Closed')
                                  <span class="text-success">CR Closed</span>
                                  @break

                              @case('Auto Close')
                                  <span class="text-success">Auto Closed</span>
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
                    @endif
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
          top2Start:{
              buttons:[
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
      })
    </script>
@endsection