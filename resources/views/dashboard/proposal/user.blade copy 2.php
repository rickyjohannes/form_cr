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
                <h3 class="card-title">Data CR <a class="btn btn-success" href="{{ route('proposal.create') }}">Create <i class="fas fa-plus"></i></a></h3>
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
                  @foreach ($proposals as $proposal)
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
                                      @foreach (['user' => 'Closed'] as $role => $status)
                                          @if (Auth::user()->role->name === $role)
                                              <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                                  @csrf
                                                  @method('PATCH')
                                                  <input type="hidden" name="status_cr" value="{{ $status }}">
                                                  <button class="btn {{ $role === 'user' ? 'btn-success' : 'btn-success' }} btn-sm" type="button" data-toggle="modal" data-target="#ratingModal{{ $proposal->id }}">
                                                      {{ $status }}
                                                  </button>
                                              </form>
                                          @endif
                                      @endforeach

                                      <div class="modal fade" id="ratingModal{{ $proposal->id }}" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel{{ $proposal->id }}" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="ratingModalLabel{{ $proposal->id }}">Rating and Review</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      @if ($proposal->rating && $proposal->review)
                                                          <div>
                                                              <strong>Rating:</strong>
                                                              <div class="star-rating" id="star-rating-{{ $proposal->id }}">
                                                                  @for ($i = 1; $i <= 5; $i++)
                                                                      <i class="fas fa-star {{ $i <= $proposal->rating ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                                                  @endfor
                                                              </div>
                                                          </div>
                                                          <div>
                                                              <strong>Review:</strong>
                                                              <p>{{ $proposal->review }}</p>
                                                          </div>
                                                      @else
                                                          <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="margin-top: 15px;">
                                                          @csrf
                                                          @method('PATCH')

                                                          <label for="rating-{{ $proposal->id }}">Rating (1-5):</label>
                                                          <div class="star-rating" id="star-rating-{{ $proposal->id }}">
                                                              @for ($i = 1; $i <= 5; $i++)
                                                                  <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                              @endfor
                                                          </div>

                                                          <input type="hidden" name="rating" id="rating-{{ $proposal->id }}" value="{{ old('rating', $proposal->rating ?? 0) }}">

                                                          <br>

                                                          <label for="review-{{ $proposal->id }}">Review:</label>
                                                          <textarea name="review" id="review-{{ $proposal->id }}" class="form-control" rows="4" placeholder="Tulis review Anda di sini...">{{ old('review', $proposal->review) }}</textarea>

                                                          <br>

                                                          <button class="btn btn-primary" type="submit">Kirim Rating dan Review</button>
                                                      </form>

                                                      @endif
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      @break
                                  @endcase


                                   @case('Closed By IT With Delay')
                                  <b><span class="badge badge-danger">Closed By IT With Delay</span></b>
                                      @foreach (['user' => 'Closed All With Delay'] as $role => $status)
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

                                  @case('Closed All With Delay')
                                  <b><span class="badge badge-danger">Closed All With Delay</span></b>
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
                                    <button class="btn btn-success dropdown-item" type="submit"><i class="fas fa-print"></i> Print</button>
                                </form>
                              @endif
                              
                              <a class="btn btn-warning dropdown-item" href="{{ route('proposal.show', $proposal->id) }}"><i class="fas fa-list"></i> Show</a>
                              @if($proposal->status_apr == 'pending')
                              <form action="{{ route('proposal.destroy', $proposal->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger dropdown-item" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                  <!-- <a class="btn btn-warning dropdown-item" href="{{ route('proposal.edit', $proposal->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a> -->
                              </form>
                              @endif
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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

//     document.addEventListener('DOMContentLoaded', function () {
//     const starContainers = document.querySelectorAll('.star-rating');

//     starContainers.forEach(function(starContainer) {
//         // Select all star icons inside the container
//         const stars = starContainer.querySelectorAll('i.fas');
//         // Find the hidden input for rating within the form
//         const ratingInput = starContainer.closest('form')?.querySelector('input[type="hidden"]');
        
//         // If ratingInput is not found, log an error and skip
//         if (!ratingInput) {
//             console.error("Rating input not found!");
//             return; // Exit if no hidden input
//         }

//         let currentRating = parseInt(ratingInput.value) || 0;

//         // Function to highlight stars based on the rating
//         function highlightStars(rating) {
//             stars.forEach(function(star, index) {
//                 if (index < rating) {
//                     star.style.color = 'yellow'; // Set color to yellow for selected stars
//                 } else {
//                     star.style.color = 'gray'; // Reset to gray for unselected stars
//                 }
//             });
//         }

//         // Set the initial rating
//         highlightStars(currentRating);

//         stars.forEach(function(star, index) {
//             // Hover event - highlight stars on mouse over
//             star.addEventListener('mouseover', function () {
//                 highlightStars(index + 1);
//             });

//             // Mouseout event - reset to current rating
//             star.addEventListener('mouseout', function () {
//                 highlightStars(currentRating);
//             });

//             // Click event - update rating and hidden input value
//             star.addEventListener('click', function () {
//                 currentRating = index + 1;
//                 ratingInput.value = currentRating; // Update hidden input value
//                 console.log('Rating updated to:', currentRating); // Debugging log
//                 highlightStars(currentRating); // Update the stars

//                 // After updating rating, we can check if the hidden input is updated correctly
//                 console.log('Hidden input value after click:', ratingInput.value);
//             });
//         });
//     });

//     // Optional: Check the hidden input value before submitting the form
//     document.querySelector('form').addEventListener('submit', function(event) {
//         const ratingInput = document.querySelector('input[name="rating"]');
//         const ratingValue = ratingInput.value;

//         console.log('Form will be submitted with rating:', ratingValue);
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    const starContainers = document.querySelectorAll('.star-rating');

    starContainers.forEach(function(starContainer) {
        const stars = starContainer.querySelectorAll('i.fas');
        const ratingInput = starContainer.closest('form')?.querySelector('input[name="rating"]');
        
        if (!ratingInput) {
            console.error("Rating input not found!");
            return;
        }

        let currentRating = parseInt(ratingInput.value) || 0;

        // Highlight stars based on current rating
        function highlightStars(rating) {
            stars.forEach(function(star, index) {
                if (index < rating) {
                    star.style.color = 'yellow';
                } else {
                    star.style.color = 'gray';
                }
            });
        }

        highlightStars(currentRating);  // Set initial rating

        stars.forEach(function(star, index) {
            star.addEventListener('mouseover', function () {
                highlightStars(index + 1);  // Highlight stars on hover
            });

            star.addEventListener('mouseout', function () {
                highlightStars(currentRating);  // Reset to current rating
            });

            star.addEventListener('click', function () {
                currentRating = index + 1;
                ratingInput.value = currentRating;  // Correctly update hidden input value
                console.log('Rating updated to:', currentRating);  // Debugging log
                highlightStars(currentRating);  // Update stars on click
            });
        });
    });

    // Debugging: Ensure the correct rating value is being sent
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const ratingInput = form.querySelector('input[name="rating"]');
            console.log('Form will be submitted with rating:', ratingInput.value);  // Check rating before submission
        });
    });
});


</script>
@endsection
