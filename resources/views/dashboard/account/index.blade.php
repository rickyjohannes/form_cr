@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Account</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Account</li>
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
              <h3 class="card-title">Data Account <a class="btn btn-success" href="{{ route('account.create') }}"> Create <i class="fas fa-plus"></i></a></h3>
            </div>
            <div class="card-header">
                <!-- Cek jika ada pesan error -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('account.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Upload Data Master User By Excel</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                        @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Import Excel</button>
                    <a href="{{ url('uploads/user_template.xlsx') }}" class="btn btn-primary" download>Download Excel Template</a>
                </form>
            </div>

            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Company Code</th>
                    <th>NPK</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Departement</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($accounts as $account)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>
                          @if ($account->company_code == '1101') 1101 - DPM Cikarang 1
                          @elseif ($account->company_code == '1100') 1100 - PT. Dharma Polimetal Tbk
                          @elseif ($account->company_code == '1200') 1200 - PT. Dharma Poliplast
                          @elseif ($account->company_code == '1300') 1300 - PT. Dharma Precision Part
                          @elseif ($account->company_code == '1400') 1400 - PT. Dharma Precision Tools
                          @elseif ($account->company_code == '1500') 1500 - PT. Dharma Electrindo Manufacturing
                          @elseif ($account->company_code == '1600') 1600 - PT .Dharma Control Cable
                          @elseif ($account->company_code == '1700') 1700 - PT. Trimitra Chitrahasta
                          @else - 
                          @endif
                      </td>
                      <td>{{ $account->npk }}</td>
                      <td>{{ $account->name }}</td>
                      <td>{{ $account->username }}</td>
                      <td>{{ $account->email }}</td>
                      <td>{{ $account->departement }}</td>
                      <td>{{ $account->user_status }}</td>
                      <td>{{ $account->ext_phone }}</td>
                      <td>{{ $account->role->name }}</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="btn btn-warning dropdown-item" href="{{ route('account.edit', $account->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <form id="delete-form-{{ $account->id }}" action="{{ route('account.destroy', $account->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger dropdown-item" type="submit"><i class="fas fa-trash-alt"></i> Delete</button>
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
