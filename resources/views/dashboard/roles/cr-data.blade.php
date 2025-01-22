<div class="table-responsive">
    <!-- Search Box -->
    <div class="mb-3">
        <input type="text" class="form-control" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
    </div>

    <table class="table table-striped">
    <thead>
    <tr>
        <th style="width: 1%">
            No.
        </th>
        <th style="width: 10%">
            Status CR
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

                            @default
                            <b><span class="badge badge-dark">OPEN</span></b>
                        @endswitch
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
                    <p>{{ $proposal->user_request }}</p>
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

<script>
    function searchTable() {
        let input = document.getElementById('searchInput');
        let filter = input.value.toLowerCase();
        let table = document.querySelector('table');
        let rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName('td');
            let rowVisible = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        rowVisible = true;
                        break;
                    }
                }
            }
            rows[i].style.display = rowVisible ? '' : 'none';
        }
    }
</script>