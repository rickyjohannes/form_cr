@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Form CR</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Form CR</li>
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
          <!-- Pending -->
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Status Pending</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>

            <div class="card-body p-0">
            <div class="table-responsive">
              <!-- Search Box -->
              <div class="mb-3">
                  <input type="text" class="form-control searchInput" data-table="table1" placeholder="Search...">
              </div>
              <table class="table table-striped text-center" id="table1-content">
                <thead>
                    <tr>
                      <th style="width: 1%">
                          No.
                      </th>
                      <th style="width: 10%">
                          No Doc CR
                      </th>
                      <th style="width: 5%">
                          Jenis Permintaan
                      </th>
                      <th style="width: 10%">
                          Kategori
                      </th>
                      <th style="width: 10%">
                          Facility
                      </th>
                      <th style="width: 15%">
                          User Note
                      </th>
                      <th style="width: 10%">
                          Company Code
                      </th>
                      <th style="width: 10%">
                          User / Requester
                      </th>
                      <th style="width: 5%">
                          Position
                      </th>
                      <th style="width: 5%">
                          Departement
                      </th>
                      <th style="width: 10%">
                          Date of Submission
                      </th>
                      <th style="width: 10%">
                          Estimated Start Date
                      </th>
                      <th style="width: 10%">
                          Request Completion Date
                      </th>
                      <th style="width: 1%" class="text-center">
                          Status Approved
                      </th>
                      <th style="width: 10%">
                          Action Date Approved
                      </th>
                      <th style="width: 35%" class="text-center" > 
                          Action Approval
                      </th>
                      <th style="width: 35%">
                          Action
                      </th>
                    </tr>
                  </thead>
                <tbody>
                @php
                    $role = auth()->user()->role->name;
                    $proposals = ($role == 'dh') ? $proposalpen : (($role == 'divh') ? $proposalpendivh : []);
                    $userDepartments = array_map('trim', explode(',', auth()->user()->departement ?? ''));
                @endphp

                    @forelse ($proposals as $proposal)
                    @php
                        $proposalDepartments = array_map('trim', explode(',', $proposal->departement ?? ''));
                    @endphp
                    
                    @if(array_intersect($proposalDepartments, $userDepartments))
                    <tr>
                      <td>
                        {{ $loop->iteration }}
                      </td>
                      <td>
                        <a>{{ $proposal->no_transaksi }}</a>
                      </td>
                      <td>
                        <a>{{ $proposal->status_barang }}</a>
                      </td>
                      <td>
                        <a>{{ $proposal->kategori }}</a>
                      </td>
                      <td>
                        <a>{{ $proposal->facility }}</a>
                      </td>
                      <td class="user-note">
                          @if (!empty($proposal->user_note))
                              @php
                                  // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                                  $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->user_note);
                                  // Mengonversi newline menjadi <br> agar terlihat di HTML
                                  $cleanedNote = nl2br($formattedNote);
                              @endphp
                              <div class="note-content">{!! $cleanedNote !!}</div>
                          @else
                              <textarea class="form-control" rows="5" readonly>User Note not available...</textarea>
                          @endif
                          <style>
                              .user-note {
                                  max-width: 300px; /* Sesuaikan dengan kebutuhan */
                                  word-wrap: break-word;
                                  white-space: normal;
                              }

                              .note-content {
                                  display: block;
                                  max-width: 100%;
                                  overflow-wrap: break-word;
                                  word-wrap: break-word;
                                  white-space: pre-wrap; /* Agar newline (\n) tetap terlihat */
                              }
                          </style>
                      </td>
                      <td>
                          @if ($proposal->company_code == '1101') 1101 - DPM Cikarang 1
                          @elseif ($proposal->company_code == '1100') 1100 - PT. Dharma Polimetal Tbk
                          @elseif ($proposal->company_code == '1200') 1200 - PT. Dharma Poliplast
                          @elseif ($proposal->company_code == '1300') 1300 - PT. Dharma Precision Part
                          @elseif ($proposal->company_code == '1400') 1400 - PT. Dharma Precision Tools
                          @elseif ($proposal->company_code == '1500') 1500 - PT. Dharma Electrindo Manufacturing
                          @elseif ($proposal->company_code == '1600') 1600 - PT .Dharma Control Cable
                          @elseif ($proposal->company_code == '1700') 1700 - PT. Trimitra Chitrahasta
                          @else - 
                          @endif
                      </td>
                      <td>
                        <ul class="list-inline text-center">
                          <li class="list-inline-item">
                            <img alt="Avatar" class="img-circle" width="80" height="80" src="{{ asset('template/dashboard/dist/img/avatar5.png') }}">
                            <p>{{ $proposal->user_request }}</p>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <a>{{ $proposal->user_status }}</a>
                      </td>
                      <td>
                        <a>{{ $proposal->departement }}</a>
                      </td>
                      <td>
                        <a>{{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y') }}</a>
                        <br/>
                        <small>Created {{ \Carbon\Carbon::parse($proposal->created_at)->diffForHumans() }}</small>
                      </td>
                      <td>
                        @if ($proposal->estimated_start_date)
                        <a>{{ \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d-m-Y | H:i:s') }}</a>
                        @endif
                      </td>
                      <td>
                        @if ($proposal->estimated_date)
                        <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</a>
                        @endif
                      </td>
                      <td>
                          @if ($proposal->status_apr === 'pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif ($proposal->status_apr === 'partially_approved')
                          <span class="badge badge-warning">Partially Approved</span>
                          @elseif ($proposal->status_apr === 'fully_approved')
                          <span class="badge badge-success">Fully Approved</span>
                          @elseif ($proposal->status_apr === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @endif
                          <br/>
                           @if ($proposal->actiondate_apr)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                           @endif
                      </td>
                      <td>
                          @if ($proposal->actiondate_apr)
                            <a>{{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y | H:i:s') }}</a>
                          @endif
                      </td>
                      <td>
                          <div class="approval-buttons">
                              @if (Auth::user()->role->name == 'dh' && $proposal->status_apr === 'pending')
                                  @if ($proposal->token)
                                      <a href="{{ route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-success btn-sm"><strong>Approved</strong></a>
                                      <a href="{{ route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-danger btn-sm"><strong>Rejected</strong></a>
                                  @else
                                      <span class="badge badge-danger">Token Missing</span>
                                  @endif
                              @elseif (Auth::user()->role->name == 'dh' && $proposal->status_apr === 'partially_approved')
                                  <span class="badge badge-success">Approved</span>
                              @elseif (Auth::user()->role->name == 'dh' && $proposal->status_apr === 'rejected')
                                  <span class="badge badge-danger">Rejected</span>
                              @endif

                              @if (Auth::user()->role->name == 'divh' && $proposal->status_apr === 'pending')
                                  @if ($proposal->token)
                                      <a href="{{ route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-success btn-sm"><strong>Approved</strong></a>
                                      <a href="{{ route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-danger btn-sm"><strong>Rejected</strong></a>
                                  @else
                                      <span class="badge badge-danger">Token Missing</span>
                                  @endif
                              @elseif (Auth::user()->role->name == 'divh' && $proposal->status_apr === 'partially_approved')
                                  @if ($proposal->token)
                                      <a href="{{ route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-success btn-sm"><strong>Approved</strong></a>
                                      <a href="{{ route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-danger btn-sm"><strong>Rejected</strong></a>
                                  @else
                                      <span class="badge badge-danger">Token Missing</span>
                                  @endif
                              @elseif (Auth::user()->role->name == 'divh' && $proposal->status_apr === 'fully_approved')
                                  <span class="badge badge-success">Approved</span>
                              @elseif (Auth::user()->role->name == 'divh' && $proposal->status_apr === 'rejected')
                                  <span class="badge badge-danger">Rejected</span>
                              @endif
                          </div>
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('proposal.show', $proposal->id) }}">
                          <i class="fas fa-list"></i> Detail
                        </a>
                        <!-- <form class="d-inline" action="{{ route('proposal.destroy', $proposal->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">
                              <i class="fas fa-trash"></i> Delete
                          </button>
                        </form> -->
                      </td>
                    </tr>
                   @endif
                  @empty
                    <tr>
                      <td colspan="6">No data available</td>
                    </tr>
                  @endforelse                        
                </tbody>
              </table>
             </div>
            </div>
          </div>

          <!-- Approved -->
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Status Approved</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
            <!-- Search Box -->
            <div class="mb-3">
                <input type="text" class="form-control searchInput" data-table="table2" placeholder="Search...">
            </div>
            <table class="table table-striped text-center" id="table2-content">
                <thead>
                      <tr>
                        <th style="width: 1%">
                            No.
                        </th>
                        <th style="width: 10%">
                            No Doc CR
                        </th>
                        <th style="width: 5%">
                            Jenis Permintaan
                        </th>
                        <th style="width: 10%">
                            Kategori
                        </th>
                        <th style="width: 10%">
                            Facility
                        </th>
                        <th style="width: 15%">
                            User Note
                        </th>
                        <th style="width: 10%">
                            Company Code
                        </th>
                        <th style="width: 10%">
                            User / Requester
                        </th>
                        <th style="width: 5%">
                            Position
                        </th>
                        <th style="width: 5%">
                            Departement
                        </th>
                        <th style="width: 10%">
                            Date of Submission
                        </th>
                        <th style="width: 10%">
                            Estimated Start Date
                        </th>
                        <th style="width: 10%">
                            Request Completion Date
                        </th>
                        <th style="width: 10%">
                            Estimated Completion Date
                        </th>
                        <th style="width: 5%">
                            IT User
                        </th>
                        <th style="width: 5%">
                            IT Note
                        </th>
                        <th style="width: 1%" class="text-center">
                            Status Approved
                        </th>
                        <th style="width: 10%">
                            Action Date Approved
                        </th>
                        <th style="width: 10%">
                            Status CR
                        </th>
                        <th style="width: 10%">
                            IT CR Closure Date
                        </th>
                        <th style="width: 35%">
                            Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($proposalapr as $proposal)
                      @php
                          $proposalDepartments = array_map('trim', explode(',', $proposal->departement ?? ''));
                          $userDepartments = array_map('trim', explode(',', auth()->user()->departement ?? ''));
                      @endphp
                      
                      @if(array_intersect($proposalDepartments, $userDepartments))
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                              <a>{{ $proposal->no_transaksi }}</a>
                            </td>
                            <td>
                              <a>{{ $proposal->status_barang }}</a>
                            </td>
                            <td>
                              <a>{{ $proposal->kategori }}</a>
                            </td>
                            <td>
                              <a>{{ $proposal->facility }}</a>
                            </td>
                                <td class="user-note">
                                @if (!empty($proposal->user_note))
                                    @php
                                        // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                                        $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->user_note);
                                        // Mengonversi newline menjadi <br> agar terlihat di HTML
                                        $cleanedNote = nl2br($formattedNote);
                                    @endphp
                                    <div class="note-content">{!! $cleanedNote !!}</div>
                                @else
                                    <textarea class="form-control" rows="5" readonly>User Note not available...</textarea>
                                @endif
                                <style>
                                    .user-note {
                                        max-width: 300px; /* Sesuaikan dengan kebutuhan */
                                        word-wrap: break-word;
                                        white-space: normal;
                                    }

                                    .note-content {
                                        display: block;
                                        max-width: 100%;
                                        overflow-wrap: break-word;
                                        word-wrap: break-word;
                                        white-space: pre-wrap; /* Agar newline (\n) tetap terlihat */
                                    }
                                </style>
                            </td>
                            <td>
                                @if ($proposal->company_code == '1101') 1101 - DPM Cikarang 1
                                @elseif ($proposal->company_code == '1100') 1100 - PT. Dharma Polimetal Tbk
                                @elseif ($proposal->company_code == '1200') 1200 - PT. Dharma Poliplast
                                @elseif ($proposal->company_code == '1300') 1300 - PT. Dharma Precision Part
                                @elseif ($proposal->company_code == '1400') 1400 - PT. Dharma Precision Tools
                                @elseif ($proposal->company_code == '1500') 1500 - PT. Dharma Electrindo Manufacturing
                                @elseif ($proposal->company_code == '1600') 1600 - PT .Dharma Control Cable
                                @elseif ($proposal->company_code == '1700') 1700 - PT. Trimitra Chitrahasta
                                @else - 
                                @endif
                            </td>
                            <td>
                                <ul class="list-inline text-center">
                                    <li class="list-inline-item">
                                        <img alt="Avatar" class="img-circle" width="80" height="80" src="{{ asset('template/dashboard/dist/img/avatar5.png') }}">
                                        <p>{{ $proposal->user_request }}</p>
                                    </li>
                                </ul>
                            </td>
                            <td>
                              <a>{{ $proposal->user_status }}</a>
                            </td>
                            <td>
                              <a>{{ $proposal->departement }}</a>
                            </td>
                            <td>
                              <a>{{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y') }}</a>
                              <br/>
                              <small>Created {{ \Carbon\Carbon::parse($proposal->created_at)->diffForHumans() }}</small>
                            </td>
                            <td>
                              @if ($proposal->estimated_start_date)
                              <a>{{ \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d-m-Y | H:i:s') }}</a>
                              @endif
                            </td>
                            <td>
                              @if ($proposal->estimated_date)
                              <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</a>
                              @endif
                            </td>
                            <td>
                              @if ($proposal->action_it_date)
                              <a>{{ \Carbon\Carbon::parse($proposal->action_it_date)->format('d-m-Y | H:i:s') }}</a>
                              @endif
                            </td>
                            <td>
                              <a>{{ $proposal->it_user }}</a>
                            </td>
                            <td class="user-note">
                                @if (!empty($proposal->it_analys))
                                    @php
                                        // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                                        $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->it_analys);
                                        // Mengonversi newline menjadi <br> agar terlihat di HTML
                                        $cleanedNote = nl2br($formattedNote);
                                    @endphp
                                    <div class="note-content">{!! $cleanedNote !!}</div>
                                @else
                                    <textarea class="form-control" rows="5" readonly>IT Note not available...</textarea>
                                @endif
                                <style>
                                    .user-note {
                                        max-width: 300px; /* Sesuaikan dengan kebutuhan */
                                        word-wrap: break-word;
                                        white-space: normal;
                                    }

                                    .note-content {
                                        display: block;
                                        max-width: 100%;
                                        overflow-wrap: break-word;
                                        word-wrap: break-word;
                                        white-space: pre-wrap; /* Agar newline (\n) tetap terlihat */
                                    }
                                </style>
                            </td>
                            <td>
                                @if ($proposal->status_apr === 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @elseif ($proposal->status_apr === 'partially_approved')
                                <span class="badge badge-warning">Partially Approved</span>
                                @elseif ($proposal->status_apr === 'fully_approved')
                                <span class="badge badge-success">Fully Approved</span>
                                @elseif ($proposal->status_apr === 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                                @endif
                                <br/>
                                @if ($proposal->actiondate_apr)
                                    <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                                @endif
                            </td>
                            <td>
                              @if ($proposal->actiondate_apr)
                              <a>{{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y | H:i:s') }}</a>
                              @endif
                            </td>
                            <td>
                                  @switch($proposal->status_cr)
                                  
                                      @case('Open To IT')
                                      <b><span class="badge badge-warning">Open To IT</span></b>
                                          @break

                                      @case('ON PROGRESS')
                                      <b><span class="badge badge-warning">On Progress</span></b>
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
                                      <b><span class="badge badge-danger">Closed By Rejected</span></b>
                                          @break

                                      @case('DELAY')
                                      <b><span class="badge badge-danger">DELAY</span></b>
                                          @break

                                      @case('Closed By IT With Delay')
                                      <b><span class="badge badge-danger">Closed By IT With Delay</span></b>
                                          @break

                                      @case('Closed With Delay')
                                      <b><span class="badge badge-danger">Closed With Delay</span></b>
                                          @break

                                      @case('Auto Closed With Delay')
                                      <b><span class="badge badge-success">Auto Closed With Delay</span></b>
                                          @break

                                      @default
                                      <b><span class="badge badge-dark">OPEN</span></b>
                                  @endswitch
                            </td>
                            <td>
                                @if ($proposal->close_date)
                                  <a>{{ \Carbon\Carbon::parse($proposal->close_date)->format('d-m-Y h:i:s') }}</a>
                                @endif
                            </td>
                            <td class="project-actions text-right">
                              <form class="d-inline" action="{{ route('proposal.print', $proposal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-file"></i>Print</button>
                              </form>

                              <a class="btn btn-info btn-sm" href="{{ route('proposal.show', $proposal->id) }}">
                                <i class="fas fa-list"></i> Detail
                              </a>
                              <!-- <form class="d-inline" action="{{ route('proposal.destroy', $proposal->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" >
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                              </form> -->
                            </td>
                        </tr>
                        @endif
                      @empty
                      <tr>
                        <td colspan="6">No data available</td>
                      </tr>
                      @endforelse
                    </tbody>
              </table>
             </div>
            </div>
          </div>

          <!-- Rejected -->
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Status Rejected</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
            <!-- Search Box -->
            <div class="mb-3">
                <input type="text" class="form-control searchInput" data-table="table3" placeholder="Search...">
            </div>
            <table class="table table-striped text-center" id="table3-content">
                <thead>
                    <tr>
                      <th style="width: 1%">
                          No.
                      </th>
                      <th style="width: 10%">
                          No Doc CR
                      </th>
                      <th style="width: 5%">
                          Jenis Permintaan
                      </th>
                      <th style="width: 10%">
                          Kategori
                      </th>
                      <th style="width: 10%">
                          Facility
                      </th>
                      <th style="width: 15%">
                          User Note
                      </th>
                      <th style="width: 10%">
                          Company Code
                      </th>
                      <th style="width: 10%">
                          User / Requester
                      </th>
                      <th style="width: 5%">
                          Position
                      </th>
                      <th style="width: 5%">
                          Departement
                      </th>
                      <th style="width: 10%">
                          Date of Submission
                      </th>
                      <th style="width: 10%">
                          Estimated Start Date
                      </th>
                      <th style="width: 10%">
                          Request Completion Date
                      </th>
                      <th style="width: 1%" class="text-center">
                          Status Approved
                      </th>
                      <th style="width: 10%">
                          Action Date Approved
                      </th>
                      <th style="width: 35%">
                          Action
                      </th>
                    </tr>
                </thead>
              <tbody>
                  @forelse ($proposalrej as $proposal)
                  @php
                      $proposalDepartments = array_map('trim', explode(',', $proposal->departement ?? ''));
                      $userDepartments = array_map('trim', explode(',', auth()->user()->departement ?? ''));
                  @endphp
                  
                  @if(array_intersect($proposalDepartments, $userDepartments))
                    <tr>
                      <td>
                          {{ $loop->iteration }}
                      </td>
                      <td>
                          <a>{{ $proposal->no_transaksi }}</a>
                      </td>
                      <td>
                          <a>{{ $proposal->status_barang }}</a>
                      </td>
                      <td>
                          <a>{{ $proposal->kategori }}</a>
                      </td>
                      <td>
                          <a>{{ $proposal->facility }}</a>
                      </td>
                      <td class="user-note">
                          @if (!empty($proposal->user_note))
                              @php
                                  // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                                  $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->user_note);
                                  // Mengonversi newline menjadi <br> agar terlihat di HTML
                                  $cleanedNote = nl2br($formattedNote);
                              @endphp
                              <div class="note-content">{!! $cleanedNote !!}</div>
                          @else
                              <textarea class="form-control" rows="5" readonly>User Note not available...</textarea>
                          @endif
                          <style>
                              .user-note {
                                  max-width: 300px; /* Sesuaikan dengan kebutuhan */
                                  word-wrap: break-word;
                                  white-space: normal;
                              }

                              .note-content {
                                  display: block;
                                  max-width: 100%;
                                  overflow-wrap: break-word;
                                  word-wrap: break-word;
                                  white-space: pre-wrap; /* Agar newline (\n) tetap terlihat */
                              }
                          </style>
                      </td>
                      <!-- <td>
                          <a>{{ $proposal->it_analys }}</a>
                      </td> -->
                      <td>
                          @if ($proposal->company_code == '1101') 1101 - DPM Cikarang 1
                          @elseif ($proposal->company_code == '1100') 1100 - PT. Dharma Polimetal Tbk
                          @elseif ($proposal->company_code == '1200') 1200 - PT. Dharma Poliplast
                          @elseif ($proposal->company_code == '1300') 1300 - PT. Dharma Precision Part
                          @elseif ($proposal->company_code == '1400') 1400 - PT. Dharma Precision Tools
                          @elseif ($proposal->company_code == '1500') 1500 - PT. Dharma Electrindo Manufacturing
                          @elseif ($proposal->company_code == '1600') 1600 - PT .Dharma Control Cable
                          @elseif ($proposal->company_code == '1700') 1700 - PT. Trimitra Chitrahasta
                          @else - 
                          @endif
                      </td>
                      <td>
                        <ul class="list-inline text-center">
                          <li class="list-inline-item">
                            <img alt="Avatar" class="img-circle" width="80" height="80" src="{{ asset('template/dashboard/dist/img/avatar5.png') }}">
                            <p>{{ $proposal->user_request }}</p>
                          </li>
                        </ul>
                      </td>
                      <td>
                          <a>{{ $proposal->user_status }}</a>
                      </td>
                      <td>
                          <a>{{ $proposal->departement }}</a>
                      </td>
                      <td>
                          <a>{{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y') }}</a>
                          <br/>
                          <small>Created {{ \Carbon\Carbon::parse($proposal->created_at)->diffForHumans() }}</small>
                      </td>
                      <td>
                        @if ($proposal->estimated_start_date)
                        <a>{{ \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d-m-Y | H:i:s') }}</a>
                        @endif
                      </td>
                      <td>
                        @if ($proposal->estimated_date)
                        <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</a>
                        @endif
                      </td>
                      <td>
                          @if ($proposal->status_apr === 'pending')
                            <span class="badge badge-warning">Pending</span>
                          @elseif ($proposal->status_apr === 'partially_approved')
                            <span class="badge badge-warning">Partially Approved</span>
                          @elseif ($proposal->status_apr === 'fully_approved')
                            <span class="badge badge-success">Fully Approved</span>
                          @elseif ($proposal->status_apr === 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                          @endif
                          <br/>
                          @if ($proposal->actiondate_apr)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->diffForHumans() }}</small>
                          @endif
                      </td>
                      <td>
                          @if ($proposal->actiondate_apr)
                            <a>{{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y | H:i:s') }}</a>
                          @endif
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('proposal.show', $proposal->id) }}">
                            <i class="fas fa-list"></i> Detail
                        </a>
                        <!-- <form class="d-inline" action="{{ route('proposal.destroy', $proposal->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" >
                              <i class="fas fa-trash"></i> Delete
                          </button>
                        </form> -->
                      </td>
                    </tr>
                  @endif
                  @empty
                  <tr>
                    <td colspan="6">No data available</td>
                  </tr>
                  @endforelse
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
    // Function to toggle the visibility of the approval buttons
    function toggleApprovalButtons(status) {
        const approvalButtons = document.querySelectorAll('.approval-buttons');
        const dhApprovalButtons = document.querySelectorAll('.dh-approval-buttons');
        const divhApprovalButtons = document.querySelectorAll('.divh-approval-buttons');

        // Show approval buttons for the corresponding status
        if (status === 'pending') {
            approvalButtons.forEach(button => button.style.display = 'block');
            dhApprovalButtons.forEach(button => button.style.display = 'block');
            divhApprovalButtons.forEach(button => button.style.display = 'block');
        } else if (status === 'approved' || status === 'rejected') {
            approvalButtons.forEach(button => button.style.display = 'none');
            dhApprovalButtons.forEach(button => button.style.display = 'none');
            divhApprovalButtons.forEach(button => button.style.display = 'none');
        }
    }

    // Toggle the approval buttons based on the proposal status
    /*const proposalRows = document.querySelectorAll('tr');
    proposalRows.forEach(row => {
        const statusDH = row.querySelector('.status-dh').textContent.trim();
        const statusDIVH = row.querySelector('.status-divh').textContent.trim();

        // Show/hide buttons based on the status of DH and DIVH
        toggleApprovalButtons(statusDH);
        toggleApprovalButtons(statusDIVH);
    });*/
    
</script>
<script>
    // Function to filter table based on input value
    document.querySelectorAll('.searchInput').forEach(input => {
        input.addEventListener('keyup', function() {
            const tableId = input.getAttribute('data-table'); // Get the target table ID
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId + '-content'); // Get the content of the table
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Skip header row
                let cells = rows[i].getElementsByTagName('td');
                let rowVisible = false;

                // Loop through cells to find a match
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j]) {
                        if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                            rowVisible = true;
                            break;
                        }
                    }
                }
                // Show or hide the row
                rows[i].style.display = rowVisible ? '' : 'none';
            }
        });
    });
</script>
@endsection