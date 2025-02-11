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
              <table class="table table-striped text-center">
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
                          Estimated Completion Date
                      </th>
                      <th style="width: 1%" class="text-center">
                          Status DH
                      </th>
                      <th style="width: 10%">
                          Action Date DH
                      </th>
                      <th style="width: 1%" class="text-center">
                          Status DIVH
                      </th>
                      <th style="width: 10%">
                          Action Date DIVH
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
                  @forelse ($proposalpen as $proposal)
                  @if(auth()->user()->departement == $proposal->departement)
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
                      <td>
                        <a>{{ $proposal->user_note }}</a>
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
                        <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</a>
                      </td>
                      <td>
                          @if ($proposal->status_dh === 'pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif ($proposal->status_dh === 'approved')
                          <span class="badge badge-success">Approved</span>
                          @elseif ($proposal->status_dh === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @endif
                          <br/>
                           @if ($proposal->actiondate_dh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_dh)->diffForHumans() }}</small>
                           @endif
                      </td>
                      <td>
                          @if ($proposal->actiondate_dh)
                            <a>{{ \Carbon\Carbon::parse($proposal->actiondate_dh)->format('d-m-Y | H:i:s') }}</a>
                          @endif
                      </td>
                      <td>
                          @if ($proposal->status_divh === 'pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif ($proposal->status_divh === 'approved')
                          <span class="badge badge-success">Approved</span>
                          @elseif ($proposal->status_divh === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @endif
                          <br/>
                           @if ($proposal->actiondate_divh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_divh)->diffForHumans() }}</small>
                           @endif
                      </td>
		                  <td>
                         @if ($proposal->actiondate_divh)
                           <a>{{ \Carbon\Carbon::parse($proposal->actiondate_divh)->format('d-m-Y | H:i:s') }}</a>
                         @endif
                      </td>
                      <td>
                          <div class="approval-buttons">
                              @if (Auth::user()->role->name == 'dh' && $proposal->status_dh === 'pending')
                                  @if ($proposal->token)
                                      <a href="{{ route('proposal.approveDH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-success btn-sm"><strong>Approve</strong></a>
                                      <a href="{{ route('proposal.rejectDH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-danger btn-sm"><strong>Rejected</strong></a>
                                  @else
                                      <span class="badge badge-danger">Token Missing</span>
                                  @endif
                              @elseif (Auth::user()->role->name == 'dh' && $proposal->status_dh === 'approved')
                                  <span class="badge badge-success">Approved</span>
                              @elseif (Auth::user()->role->name == 'dh' && $proposal->status_dh === 'rejected')
                                  <span class="badge badge-danger">Rejected</span>
                              @endif

                              @if (Auth::user()->role->name == 'divh' && $proposal->status_divh === 'pending')
                                  @if ($proposal->token)
                                      <a href="{{ route('proposal.approveDIVH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-success btn-sm"><strong>Approve</strong></a>
                                      <a href="{{ route('proposal.rejectDIVH', ['proposal_id' => $proposal->id, 'token' => $proposal->token]) }}" class="btn btn-danger btn-sm"><strong>Rejected</strong></a>
                                  @else
                                      <span class="badge badge-danger">Token Missing</span>
                                  @endif
                              @elseif (Auth::user()->role->name == 'divh' && $proposal->status_divh === 'approved')
                                  <span class="badge badge-success">Approved</span>
                              @elseif (Auth::user()->role->name == 'divh' && $proposal->status_divh === 'rejected')
                                  <span class="badge badge-danger">Rejected</span>
                              @endif
                          </div>
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('proposal.show', $proposal->id) }}">
                          <i class="fas fa-list"></i> Detail
                        </a>
                        <form class="d-inline" action="{{ route('proposal.destroy', $proposal->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">
                              <i class="fas fa-trash"></i> Delete
                          </button>
                        </form>
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
              <table class="table table-striped text-center">
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
                            Estimated Completion Date
                        </th>
                        <th style="width: 10%">
                            IT CR Closure Date
                        </th>
                        <th style="width: 5%">
                            IT User
                        </th>
                        <th style="width: 5%">
                            IT Note
                        </th>
                        <th style="width: 1%" class="text-center">
                            Status DH
                        </th>
                        <th style="width: 10%">
                            Action Date DH
                        </th>
                        <th style="width: 1%" class="text-center">
                            Status DIVH
                        </th>
                        <th style="width: 10%">
                            Action Date DIVH
                        </th>
                        <th style="width: 10%">
                            Status CR
                        </th>
                        
                        <th style="width: 35%">
                            Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($proposalapr as $proposal)
                      @if(auth()->user()->departement == $proposal->departement)
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
                            <td>
                              <a>{{ $proposal->user_note }}</a>
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
                              <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</a>
                            </td>
                            <td>
                              <a>{{ \Carbon\Carbon::parse($proposal->action_it_date)->format('d-m-Y | H:i:s') }}</a>
                            </td>
                            <td>
                              <a>{{ $proposal->it_user }}</a>
                            </td>
                            <td>
                              <a>{{ $proposal->it_analys }}</a>
                            </td>
                            <td>
                                @if ($proposal->status_dh === 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @elseif ($proposal->status_dh === 'approved')
                                <span class="badge badge-success">Approved</span>
                                @elseif ($proposal->status_dh === 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                                @endif
                                <br/>
                                @if ($proposal->actiondate_dh)
                                    <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_dh)->diffForHumans() }}</small>
                                @endif
                            </td>
                            <td>
                              @if ($proposal->actiondate_dh)
                                <a>{{ \Carbon\Carbon::parse($proposal->actiondate_dh)->format('d-m-Y | H:i:s') }}</a>
                              @endif
                            </td>
                            <td>
                                @if ($proposal->status_divh === 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @elseif ($proposal->status_divh === 'approved')
                                <span class="badge badge-success">Approved</span>
                                @elseif ($proposal->status_divh === 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                                @endif
                                <br/>
                                @if ($proposal->actiondate_divh)
                                    <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_divh)->diffForHumans() }}</small>
                                @endif
                            </td>
			                      <td>
                               @if ($proposal->actiondate_divh)
                                 <a>{{ \Carbon\Carbon::parse($proposal->actiondate_divh)->format('d-m-Y | H:i:s') }}</a>
                               @endif
                            </td>
                            <td>
                              <a>{{ $proposal->status_cr }}</a>
                            </td>
                            <td class="project-actions text-right">
                              <form class="d-inline" action="{{ route('proposal.print', $proposal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-file"></i>Print</button>
                              </form>

                              <a class="btn btn-info btn-sm" href="{{ route('proposal.show', $proposal->id) }}">
                                <i class="fas fa-list"></i> Detail
                              </a>
                              <form class="d-inline" action="{{ route('proposal.destroy', $proposal->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" >
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                              </form>
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
              <table class="table table-striped text-center">
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
                          Estimated Completion Date
                      </th>
                      <th style="width: 10%" class="text-center">
                          Status DH
                      </th>
                      <th style="width: 10%">
                          Action Date DH
                      </th>
                      <th style="width: 10%" class="text-center">
                          Status DIVH
                      </th>
                      <th style="width: 10%">
                          Action Date DIVH
                      </th>
                      <th style="width: 35%">
                          Action
                      </th>
                    </tr>
                </thead>
              <tbody>
                  @forelse ($proposalrej as $proposal)
                  @if(auth()->user()->departement == $proposal->departement)
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
                      <td>
                          <a>{{ $proposal->user_note }}</a>
                      </td>
                      <!-- <td>
                          <a>{{ $proposal->it_analys }}</a>
                      </td> -->
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
                          <a>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</a>
                      </td>
                      <td>
                          @if ($proposal->status_dh === 'pending')
                          <span class="badge badge-warning">Pending</span>
                          @elseif ($proposal->status_dh === 'approved')
                          <span class="badge badge-success">Approved</span>
                          @elseif ($proposal->status_dh === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @endif
                          <br/>
                           @if ($proposal->actiondate_dh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_dh)->diffForHumans() }}</small>
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
                          @elseif ($proposal->status_divh === 'approved')
                          <span class="badge badge-success">Approved</span>
                          @elseif ($proposal->status_divh === 'rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @endif
                          <br/>
                           @if ($proposal->actiondate_divh)
                            <small>Approved {{ \Carbon\Carbon::parse($proposal->actiondate_divh)->diffForHumans() }}</small>
                           @endif
                      </td>
                      <td>
                          @if ($proposal->actiondate_divh)
                           <a>{{ \Carbon\Carbon::parse($proposal->actiondate_divh)->format('d-m-Y h:i:s') }}</a>
                          @endif
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('proposal.show', $proposal->id) }}">
                            <i class="fas fa-list"></i> Detail
                        </a>
                        <form class="d-inline" action="{{ route('proposal.destroy', $proposal->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" >
                              <i class="fas fa-trash"></i> Delete
                          </button>
                        </form>
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
    const proposalRows = document.querySelectorAll('tr');
    proposalRows.forEach(row => {
        const statusDH = row.querySelector('.status-dh').textContent.trim();
        const statusDIVH = row.querySelector('.status-divh').textContent.trim();

        // Show/hide buttons based on the status of DH and DIVH
        toggleApprovalButtons(statusDH);
        toggleApprovalButtons(statusDIVH);
    });
</script>
@endsection