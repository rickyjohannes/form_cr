<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <!-- Search Box -->
    <div class="mb-3">
        <input type="text" class="form-control" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 1%">No.</th>
                <th style="width: 5%">Status CR</th>
                <th style="width: 5%">No Doc CR</th>
                <th style="width: 5%">Jenis Permintaan</th>
                <th style="width: 5%">Kategori</th>
                <th style="width: 5%">Facility</th>
                <th style="width: 15%">User Note</th>
                <th style="width: 5%">Company Code</th>
                <th style="width: 5%">User / Requester</th>
                <th style="width: 5%">Position</th>
                <th style="width: 5%">Departement</th>
                <th style="width: 10%">Date of Submission</th>
                <th style="width: 10%">Estimated Start Date</th>
                <th style="width: 10%">Request Completion Date</th>
                <th style="width: 1%" class="text-center">Status Approved</th>
                <th style="width: 10%">Action Date Approved</th>
                <th style="width: 5%">IT User</th>
                <th style="width: 15%">IT Note</th>
                <th style="width: 10%">Estimated Completion Date</th>
                <th style="width: 10%">IT CR Closure Date</th>
                <th style="width: 20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proposals as $proposal)
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
                        <td>{{ $proposal->it_user }}</td>
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
                                    max-width: 100%; /* Sesuaikan dengan kebutuhan */
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
                            @if ($proposal->action_it_date)
                                <a>{{ \Carbon\Carbon::parse($proposal->action_it_date)->format('d-m-Y H:i:s') }}</a>
                            @endif
                        </td>
                        <td>
                            @if ($proposal->close_date)
                                <a>{{ \Carbon\Carbon::parse($proposal->close_date)->format('d-m-Y H:i:s') }}</a>
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
.modal-dialog {
    max-width: 95vw; /* Lebar modal hampir penuh */
    margin: auto;
}

.modal-content {
    max-height: 90vh; /* Hindari lebih dari 100vh agar modal tetap dalam viewport */
    display: flex;
    flex-direction: column;
}

.modal-body {
    flex: 1;
    overflow-y: auto;
    max-height: 75vh; /* Sesuaikan tinggi tabel dalam modal */
}

.table-responsive {
    max-height: 70vh; /* Buat tabel lebih tinggi tanpa menyebabkan overflow modal */
    overflow-y: auto;
    position: relative;
}

/* Sticky Header untuk Table */
.table thead {
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
}

/* Footer tetap di bawah modal */
.modal-footer {
    position: sticky;
    bottom: 0;
    background: white;
    z-index: 5;
    padding: 10px;
    border-top: 1px solid #ddd;
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

        $(document).ready(function () {
            $('.modal-custom').on('show.bs.modal', function () {
                $(this).find('.modal-dialog').css({
                    'max-width': '90vw'
                });
            });
        });

</script>
