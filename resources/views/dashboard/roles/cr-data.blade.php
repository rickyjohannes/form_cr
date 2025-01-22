<div class="table-responsive">
    <table class="table table-striped">
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
            @forelse ($proposals as $proposal)
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
