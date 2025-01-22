<div class="table-responsive">
    <!-- Search Box -->
    <div class="mb-3">
        <input type="text" class="form-control" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 1%">No.</th>
                <th style="width: 10%">Status CR</th>
                <th style="width: 10%">No Doc CR</th>
                <th style="width: 5%">Jenis Permintaan</th>
                <th style="width: 10%">Kategori</th>
                <th style="width: 10%">Facility</th>
                <th style="width: 15%">User Note</th>
                <th style="width: 10%">User / Requester</th>
                <th style="width: 5%">Position</th>
                <th style="width: 5%">Departement</th>
                <th style="width: 10%">Date of Submission</th>
                <th style="width: 10%">Estimated Start Date</th>
                <th style="width: 10%">Request Completion Date</th>
                <th style="width: 1%" class="text-center">Status Approved</th>
                <th style="width: 10%">Action Date Approved</th>
                <th style="width: 20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proposals as $proposal)
            @if (auth()->user()->role->name == 'it' || auth()->user()->departement == $proposal->departement) 
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @switch($proposal->status_cr)
                                @case('Open To IT') <b><span class="badge badge-warning">Open To IT</span></b> @break
                                @case('ON PROGRESS') <b><span class="badge badge-warning">On Progress</span></b> @break
                                @case('Closed By IT') <b><span class="badge badge-info">Closed By IT</span></b> @break
                                @case('Closed') <b><span class="badge badge-success">Closed By User</span></b> @break
                                @case('Auto Close') <b><span class="badge badge-success">Auto Closed</span></b> @break
                                @case('Closed By Rejected') <b><span class="badge badge-danger">Closed By Rejected</span></b> @break
                                @case('DELAY') <b><span class="badge badge-danger">DELAY</span></b> @break
                                @case('Closed By IT With Delay') <b><span class="badge badge-danger">Closed By IT With Delay</span></b> @break
                                @case('Closed With Delay') <b><span class="badge badge-danger">Closed With Delay</span></b> @break
                                @default <b><span class="badge badge-dark">OPEN</span></b>
                            @endswitch
                        </td>
                        <td>{{ $proposal->no_transaksi }}</td>
                        <td>{{ $proposal->status_barang }}</td>
                        <td>{{ $proposal->kategori }}</td>
                        <td>{{ $proposal->facility }}</td>
                        <td>{{ $proposal->user_note }}</td>
                        <td>{{ $proposal->user_request }}</td>
                        <td>{{ $proposal->user_status }}</td>
                        <td>{{ $proposal->departement }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y') }}
                            <br/>
                            <small>Created {{ \Carbon\Carbon::parse($proposal->created_at)->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if ($proposal->estimated_start_date)
                                {{ \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d-m-Y | H:i:s') }}
                            @endif
                        </td>
                        <td>
                            @if ($proposal->estimated_date)
                                {{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}
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
                                {{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y | H:i:s') }}
                            @endif
                        </td>
                        <td class="text-right">
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $proposal->id }}">
                                <i class="fas fa-list"></i> Detail
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="detailModal{{ $proposal->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-custom" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel">Detail Proposal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Detail informasi tentang proposal {{ $proposal->no_transaksi }} akan ditampilkan di sini.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <tr>
                    <td colspan="16">No data available</td>
                </tr>
            @endforelse  
        </tbody>
    </table>
</div>

<!-- CSS -->
<style>
.table-responsive {
    overflow-x: auto;
}

.modal-custom {
    max-width: 90vw; 
    margin: auto;
}

.modal-content {
    height: auto;
}
</style>

<!-- JS -->
<script>
function searchTable() {
    let input = document.getElementById('searchInput');
    let filter = input.value.toLowerCase();
    let table = document.querySelector('table');
    let rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let isVisible = false;
        for (let cell of cells) {
            if (cell.innerText.toLowerCase().includes(filter)) {
                isVisible = true;
                break;
            }
        }
        rows[i].style.display = isVisible ? '' : 'none';
    }
}
</script>
