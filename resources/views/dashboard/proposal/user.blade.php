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
                <!-- Filters container with vertical stacking and padding -->
                <div class="d-flex flex-column flex-sm-row flex-wrap mb-3">
                    <div class="form-group mb-2">
                        <!-- Filter Date Range -->
                        <label for="daterange" class="font-weight-bold text-left">&#x1F50D; Filter Date Range:</label>
                        <input type="text" id="daterange" class="form-control" style="max-width: 250px;"/>
                    </div>

                    <div class="form-group mb-2">
                        <!-- Filter Jenis Permintaan -->
                        <label for="status_apr" class="font-weight-bold text-left">&#x1F50D; Filter Status Approved:</label>
                        <select id="status_apr" name="status_apr" class="form-control" style="max-width: 250px;">
                            <option value="">Select Status Approved</option>
                            <option value="Pending">Pending</option>
                            <option value="Partially Approved">Partially Approved</option>
                            <option value="Fully Approved">Fully Approved</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <!-- Filter Status CR -->
                        <label for="status_cr" class="font-weight-bold text-left">&#x1F50D; Filter Status CR:</label>
                        <select id="status_cr" name="status_cr" class="form-control" style="max-width: 250px;">
                            <option value="">Select Status CR</option>
                            <option value="OPEN">Open</option>
                            <option value="Open To IT">Open To IT</option>
                            <option value="On Progress">On Progress</option>
                            <option value="DELAY">Delay</option>
                            <option value="Closed By IT">Closed By IT</option>
                            <option value="Closed By User">Closed By User</option>
                            <option value="Auto Closed">Auto Closed</option>
                            <option value="Closed With Delay">Closed With Delay</option>
                            <option value="Closed By IT With Delay">Closed By IT With Delay</option>
                            <option value="Auto Closed With Delay">Auto Closed With Delay</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <!-- Filter Jenis Permintaan -->
                        <label for="status_barang" class="font-weight-bold text-left">&#x1F50D; Filter Jenis Permintaan:</label>
                        <select id="status_barang" name="status_barang" class="form-control" style="max-width: 250px;">
                            <option value="">Select Jenis Permintaan</option>
                            <option value="Pengadaan">Pengadaan</option>
                            <option value="Change Request">Change Request</option>
                            <option value="Pergantian">Pergantian</option>
                            <option value="Peminjaman">Peminjaman</option>
                            <option value="IT Helpdesk">IT Helpdesk</option>
                        </select>
                    </div>
                </div>

              <!-- Table with horizontal scroll for mobile compatibility -->
              <div style="overflow-x: auto;">
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Status CR</th>
                      <th>No Doc CR</th>
                      <th>Company Code</th>
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

                                @case('DELAY')
                                <b><span class="badge badge-danger">DELAY</span></b>
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
                                                <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;" id="rating-form-{{ $proposal->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_cr" value="{{ $status }}">
                                                    <button class="btn {{ $role === 'user' ? 'btn-success' : 'btn-success' }} btn-sm" type="button" data-toggle="modal" data-target="#ratingModal{{ $proposal->id }}">
                                                        {{ $status }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endforeach

                                        <!-- Modal for Rating and Review -->
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
                                                        @if ($proposal->rating_it !== null && $proposal->rating_apk !== null && !empty($proposal->review))
                                                            <!-- If rating and review are available, show the information -->
                                                            <div>
                                                                <strong>Rating Pelayanan IT:</strong>
                                                                <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong>Rating Aplikasi:</strong>
                                                                <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong>Review:</strong>
                                                                <p>{{ $proposal->review }}</p>
                                                            </div>
                                                        @else
                                                            <!-- If rating and review are not provided, show the form -->
                                                            <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')

                                                            <!-- Rating IT -->
                                                            <label for="rating-it-{{ $proposal->id }}">Rating Pelayanan IT (1-5):</label>
                                                            <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                            <input type="hidden" name="rating_it" id="rating-it-{{ $proposal->id }}" value="{{ old('rating_it', $proposal->rating_it ?? 0) }}">
                                                            <br>

                                                            <!-- Rating Aplikasi -->
                                                            <label for="rating-apk-{{ $proposal->id }}">Rating Aplikasi (1-5):</label>
                                                            <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                            <input type="hidden" name="rating_apk" id="rating-apk-{{ $proposal->id }}" value="{{ old('rating_apk', $proposal->rating_apk ?? 0) }}">

                                                            <br>

                                                            <!-- Review -->
                                                            <label for="review-{{ $proposal->id }}">Review:</label>
                                                            <textarea name="review" id="review-{{ $proposal->id }}" class="form-control" rows="4" placeholder="Tulis review Anda di sini...">{{ old('review', $proposal->review) }}</textarea>

                                                            <br>

                                                            <!-- Status -->
                                                            <input type="hidden" name="status_cr" value="Closed"> <!-- Set status to Closed -->

                                                            <button class="btn btn-primary" type="submit">Kirim Rating dan Review</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                @case('Closed By IT')
                                        <b><span class="badge badge-info">Closed By IT</span></b>
                                        @foreach (['user' => 'Closed'] as $role => $status)
                                            @if (Auth::user()->role->name === $role)
                                                <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;" id="rating-form-{{ $proposal->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_cr" value="{{ $status }}">
                                                    <button class="btn {{ $role === 'user' ? 'btn-success' : 'btn-success' }} btn-sm" type="button" data-toggle="modal" data-target="#ratingModal{{ $proposal->id }}">
                                                        {{ $status }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endforeach

                                        <!-- Modal for Rating and Review -->
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
                                                        @if ($proposal->rating_it !== null && $proposal->rating_apk !== null && !empty($proposal->review))
                                                            <!-- If rating and review are available, show the information -->
                                                            <div>
                                                                <strong>Rating Pelayanan IT:</strong>
                                                                <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong>Rating Aplikasi:</strong>
                                                                <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong>Review:</strong>
                                                                <p>{{ $proposal->review }}</p>
                                                            </div>
                                                        @else
                                                            <!-- If rating and review are not provided, show the form -->
                                                            <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('PATCH')

                                                            <!-- Rating IT -->
                                                            <label for="rating-it-{{ $proposal->id }}">Rating Pelayanan IT (1-5):</label>
                                                            <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                            <input type="hidden" name="rating_it" id="rating-it-{{ $proposal->id }}" value="{{ old('rating_it', $proposal->rating_it ?? 0) }}">
                                                            <br>

                                                            <!-- Rating Aplikasi -->
                                                            <label for="rating-apk-{{ $proposal->id }}">Rating Aplikasi (1-5):</label>
                                                            <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                            <input type="hidden" name="rating_apk" id="rating-apk-{{ $proposal->id }}" value="{{ old('rating_apk', $proposal->rating_apk ?? 0) }}">

                                                            <br>

                                                            <!-- Review -->
                                                            <label for="review-{{ $proposal->id }}">Review:</label>
                                                            <textarea name="review" id="review-{{ $proposal->id }}" class="form-control" rows="4" placeholder="Tulis review Anda di sini...">{{ old('review', $proposal->review) }}</textarea>

                                                            <br>

                                                            <!-- Status -->
                                                            <input type="hidden" name="status_cr" value="Closed"> <!-- Set status to Closed -->

                                                            <button class="btn btn-primary" type="submit">Kirim Rating dan Review</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                @case('Closed By IT With Delay')
                                    <b><span class="badge badge-danger">Closed By IT With Delay</span></b>
                                    @foreach (['user' => 'Closed With Delay'] as $role => $status)
                                        @if (Auth::user()->role->name === $role)
                                            <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;" id="rating-form-{{ $proposal->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status_cr" value="{{ $status }}">
                                                <button class="btn {{ $role === 'user' ? 'btn-success' : 'btn-success' }} btn-sm" type="button" data-toggle="modal" data-target="#ratingModal{{ $proposal->id }}">
                                                    {{ $status }}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach

                                    <!-- Modal for Rating and Review -->
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
                                                    @if ($proposal->rating_it !== null && $proposal->rating_apk !== null && !empty($proposal->review))
                                                        <!-- If rating and review are available, show the information -->
                                                        <div>
                                                            <strong>Rating Pelayanan IT:</strong>
                                                            <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <strong>Rating Aplikasi:</strong>
                                                            <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <strong>Review:</strong>
                                                            <p>{{ $proposal->review }}</p>
                                                        </div>
                                                    @else
                                                        <!-- If rating and review are not provided, show the form -->
                                                        <form action="{{ route('proposal.updateStatus', $proposal->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')

                                                        <!-- Rating IT -->
                                                        <label for="rating-it-{{ $proposal->id }}">Rating Pelayanan IT (1-5):</label>
                                                        <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                            @endfor
                                                        </div>
                                                        <input type="hidden" name="rating_it" id="rating-it-{{ $proposal->id }}" value="{{ old('rating_it', $proposal->rating_it ?? 0) }}">
                                                        <br>

                                                        <!-- Rating Aplikasi -->
                                                        <label for="rating-apk-{{ $proposal->id }}">Rating Aplikasi (1-5):</label>
                                                        <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star" data-index="{{ $i }}"></i>
                                                            @endfor
                                                        </div>
                                                        <input type="hidden" name="rating_apk" id="rating-apk-{{ $proposal->id }}" value="{{ old('rating_apk', $proposal->rating_apk ?? 0) }}">

                                                        <br>

                                                        <!-- Review -->
                                                        <label for="review-{{ $proposal->id }}">Review:</label>
                                                        <textarea name="review" id="review-{{ $proposal->id }}" class="form-control" rows="4" placeholder="Tulis review Anda di sini...">{{ old('review', $proposal->review) }}</textarea>

                                                        <br>

                                                        <!-- Status -->
                                                        <input type="hidden" name="status_cr" value="Closed With Delay"> <!-- Set status to Closed -->

                                                        <button class="btn btn-primary" type="submit">Kirim Rating dan Review</button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @break

                                @case('Closed')
                                    <b><span class="badge badge-success">Closed By User</span></b>

                                    @if ($proposal->rating_it !== null && $proposal->rating_apk !== null)
                                        <div>
                                            <strong>Rating Pelayanan IT:</strong>
                                            <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $proposal->rating_it ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div>
                                            <strong>Rating Aplikasi:</strong>
                                            <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $proposal->rating_apk ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                        </div>

                                        @if (!empty($proposal->review))
                                            <div>
                                                <strong>Review:</strong>
                                                <p>{{ $proposal->review }}</p>
                                            </div>
                                        @else
                                            <div>
                                                <strong>Review:</strong>
                                                <p>-</p>
                                            </div>
                                        @endif
                                    @else
                                        <p>No rating or review provided.</p>
                                    @endif
                                    <style>
                                        /* Star rating styles */
                                        .star-rating .fa-star {
                                            color: gray; /* Default color for unfilled stars */
                                        }

                                        .star-rating .fa-star.checked {
                                            color: orange; /* Color for filled (checked) stars */
                                        }
                                    </style>
                                @break

                            @case('Closed With Delay')
                                <b><span class="badge badge-danger">Closed With Delay</span></b>

                                @if ($proposal->rating_it !== null && $proposal->rating_apk !== null)
                                    <div>
                                        <strong>Rating Pelayanan IT:</strong>
                                        <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $proposal->rating_it ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <strong>Rating Aplikasi:</strong>
                                        <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $proposal->rating_apk ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>

                                    @if (!empty($proposal->review))
                                        <div>
                                            <strong>Review:</strong>
                                            <p>{{ $proposal->review }}</p>
                                        </div>
                                    @else
                                        <div>
                                            <strong>Review:</strong>
                                            <p>-</p>
                                        </div>
                                    @endif
                                @else
                                    <p>No rating or review provided.</p>
                                @endif
                                <style>
                                    /* Star rating styles */
                                    .star-rating .fa-star {
                                        color: gray; /* Default color for unfilled stars */
                                    }

                                    .star-rating .fa-star.checked {
                                        color: orange; /* Color for filled (checked) stars */
                                    }
                                </style>
                            @break

                            @case('Auto Close')
                                <b><span class="badge badge-success">Auto Close</span></b>

                                @if ($proposal->rating_it !== null && $proposal->rating_apk !== null)
                                    <div>
                                        <strong>Rating Pelayanan IT:</strong>
                                        <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $proposal->rating_it ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <strong>Rating Aplikasi:</strong>
                                        <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $proposal->rating_apk ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>

                                    @if (!empty($proposal->review))
                                        <div>
                                            <strong>Review:</strong>
                                            <p>{{ $proposal->review }}</p>
                                        </div>
                                    @else
                                        <div>
                                            <strong>Review:</strong>
                                            <p>-</p>
                                        </div>
                                    @endif
                                @else
                                    <p>No rating or review provided.</p>
                                @endif
                                <style>
                                    /* Star rating styles */
                                    .star-rating .fa-star {
                                        color: gray; /* Default color for unfilled stars */
                                    }

                                    .star-rating .fa-star.checked {
                                        color: orange; /* Color for filled (checked) stars */
                                    }
                                </style>
                            @break

                            @case('Auto Closed With Delay')
                                <b><span class="badge badge-success">Auto Closed With Delay</span></b>

                                @if ($proposal->rating_it !== null && $proposal->rating_apk !== null)
                                    <div>
                                        <strong>Rating Pelayanan IT:</strong>
                                        <div class="star-rating" id="star-rating-it-{{ $proposal->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $proposal->rating_it ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <strong>Rating Aplikasi:</strong>
                                        <div class="star-rating" id="star-rating-apk-{{ $proposal->id }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $proposal->rating_apk ? 'checked' : '' }}" data-index="{{ $i }}"></i>
                                            @endfor
                                        </div>
                                    </div>

                                    @if (!empty($proposal->review))
                                        <div>
                                            <strong>Review:</strong>
                                            <p>{{ $proposal->review }}</p>
                                        </div>
                                    @else
                                        <div>
                                            <strong>Review:</strong>
                                            <p>-</p>
                                        </div>
                                    @endif
                                @else
                                    <p>No rating or review provided.</p>
                                @endif
                                <style>
                                    /* Star rating styles */
                                    .star-rating .fa-star {
                                        color: gray; /* Default color for unfilled stars */
                                    }

                                    .star-rating .fa-star.checked {
                                        color: orange; /* Color for filled (checked) stars */
                                    }
                                </style>
                            @break

                            @case('Closed By Rejected')
                            <b></b> <span class="badge badge-danger">Closed By Rejected</span></b>
                            @break
                            
                            @default
                            <b><span class="badge badge-dark">OPEN</span></b>
                            @endswitch
                        </td>
                        <td>{{ $proposal->no_transaksi }}</td>
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
                        <td>{{ $proposal->ext_phone }}</td>
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
                        <td>{{ $proposal->no_asset_user }}</td>
                        <td>
                            @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
                                @php
                                    $filePath = asset('uploads/' . $proposal->file);
                                @endphp

                                <!-- Button Preview -->
                                <button type="button" class="btn btn-success btn-preview" data-file="{{ $filePath }}">
                                    <i class="fas fa-eye"></i> Preview
                                </button>

                                <!-- Download Button -->
                                <a href="{{ $filePath }}" class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Unduh File
                                </a>

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
                        <td>{{ $proposal->no_asset }}</td>
                        <td>
                            @if (!empty($proposal->file_it) && file_exists(public_path('uploads/' . $proposal->file_it)))
                                @php
                                    $filePath = asset('uploads/' . $proposal->file_it);
                                @endphp

                                <!-- Button Preview -->
                                <button type="button" class="btn btn-success btn-preview" data-file="{{ $filePath }}">
                                    <i class="fas fa-eye"></i> Preview
                                </button>

                                <!-- Download Button -->
                                <a href="{{ $filePath }}" class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Unduh File
                                </a>

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
                                @if($proposal->status_apr == 'pending' ||  ($proposal->status_apr == 'fully_approved' && $proposal->status_barang == 'IT Helpdesk' && $proposal->status_cr == 'Open To IT'))
                                    <form action="{{ route('proposal.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this proposal?');">
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

    // Initialize Daterangepicker dengan range default untuk bulan ini
    var startDate = moment().startOf('month');
    var endDate = moment().endOf('month');

    $('#daterange').daterangepicker({
        opens: 'left',
        startDate: startDate,
        endDate: endDate,
        autoUpdateInput: true,
        locale: {
            format: 'DD-MM-YYYY', // Menentukan format input
            cancelLabel: 'Clear'
        }
    });

    $('#daterange').on('change', function () {
        var dateRange = $(this).val().split(' - ');

        if (dateRange.length === 2) {
            var startDate = moment(dateRange[0], 'DD-MM-YYYY', true);
            var endDate = moment(dateRange[1], 'DD-MM-YYYY', true);

            if (startDate.isValid() && endDate.isValid()) {
                $(this).val(startDate.format('DD-MM-YYYY') + ' - ' + endDate.format('DD-MM-YYYY'));
                filterTable(); // Jalankan filter jika valid
            } else {
                console.warn("Invalid Date Format");
            }
        }
    });

    // Set input value awal
    $('#daterange').val(startDate.format('DD-MM-YYYY') + ' - ' + endDate.format('DD-MM-YYYY'));

    // Panggil filterTable setelah inisialisasi
    filterTable();

    // Event apply pada daterangepicker
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        filterTable(); // Trigger filter ketika tanggal diterapkan
    });

    // Event cancel pada daterangepicker
    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        filterTable(); // Trigger filter ketika tanggal dihapus
    });

    // Input event untuk input manual pada tanggal
    $('#daterange').on('input', function() {
        filterTable(); // Trigger filter pada input manual
    });

    // Trigger filter ketika status_cr berubah
    $('#status_apr').change(function() {
        filterTable(); // Trigger filter ketika status diubah
    });

    // Trigger filter ketika status_cr berubah
    $('#status_cr').change(function() {
        filterTable(); // Trigger filter ketika status diubah
    });


    // Trigger filter ketika status berubah
    $('#status_barang').change(function() {
        filterTable(); // Trigger filter ketika status diubah
    });

    // Fungsi untuk filter DataTable berdasarkan tanggal dan status
    function filterTable() {
        var dateRange = $('#daterange').val().split(' - ');

        // Parse tanggal mulai dan akhir
        var startDate = dateRange[0] ? moment(dateRange[0], 'DD-MM-YYYY').startOf('day').toDate() : null; // Awal hari
        var endDate = dateRange[1] ? moment(dateRange[1], 'DD-MM-YYYY').endOf('day').toDate() : null; // Akhir hari
        var statusAprFilter = $('#status_apr').val(); // Ambil status yang dipilih
        var statusCrFilter = $('#status_cr').val(); // Ambil status yang dipilih
        var statusFilter = $('#status_barang').val(); // Ambil status yang dipilih

        // Hapus filter pencarian sebelumnya
        $.fn.dataTable.ext.search = []; // Hapus semua filter pencarian sebelumnya

        // Terapkan filter berdasarkan rentang tanggal
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var createdAtStr = (data[16] || '').trim(); // Asumsi "Date of Submission" berada di kolom ke-16 (index 15)
            var createdAt;

            if (createdAtStr) {
                // Parse tanggal dari format 'DD-MM-YYYY HH:mm:ss' ke objek JavaScript Date
                createdAt = moment(createdAtStr, 'DD-MM-YYYY HH:mm:ss').toDate();
            }

            var isValidDate = createdAt && !isNaN(createdAt);
            var isInRange = true;

            // Jika tanggal mulai atau tanggal akhir disediakan, periksa apakah createdAt ada dalam rentang
            if (startDate && endDate) {
                isInRange = createdAt >= startDate && createdAt <= endDate;
            } else if (startDate) {
                isInRange = createdAt >= startDate;
            } else if (endDate) {
                isInRange = createdAt <= endDate;
            }

            return isInRange;
        });

        // Terapkan filter berdasarkan status_apr
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            // Ambil nilai status Apr dari kolom data (indeks ke-14)
            var statusApr = data[14];  // Misalnya status CR ada di kolom ke-14, indeks 15

            // Ambil nilai filter yang dipilih oleh pengguna
            var statusAprFilter = $('#status_apr').val();

            // Jika tidak ada filter yang dipilih, tampilkan semua data
            if (!statusAprFilter) {
                return true;
            }

            // Jika filter ada, periksa apakah nilai status CR yang ada cocok dengan filter yang dipilih
            return statusApr.indexOf(statusAprFilter) !== -1;
        });

        // Terapkan filter berdasarkan jenis_permintaan
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var statusBarang = data[8]; // Asumsi 'status_barang' ada di kolom ke-9 (index 8)

            if (!statusFilter) {
                return true; // Jika tidak ada filter status yang dipilih, tampilkan semua
            }

            return statusBarang === statusFilter; // Hanya tampilkan baris yang sesuai dengan status yang dipilih
        });

        // Terapkan filter berdasarkan status_cr
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            // Ambil nilai status CR dari kolom data (indeks ke-2)
            var statusCr = data[1];  // Misalnya status CR ada di kolom ke-2, indeks 1

            // Ambil nilai filter yang dipilih oleh pengguna
            var statusCrFilter = $('#status_cr').val();

            // Jika tidak ada filter yang dipilih, tampilkan semua data
            if (!statusCrFilter) {
                return true;
            }

            // Jika filter ada, periksa apakah nilai status CR yang ada cocok dengan filter yang dipilih
            return statusCr.indexOf(statusCrFilter) !== -1;
        });

        // Gambar ulang tabel dengan filter yang diterapkan
        table.draw();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const starContainers = document.querySelectorAll('.star-rating');

        starContainers.forEach(function(starContainer) {
            const stars = starContainer.querySelectorAll('i.fas');
            const form = starContainer.closest('form');

            if (!form) {
                return;
            }

            // Tentukan input untuk rating_it atau rating_apk dalam form ini
            const ratingInputIt = form.querySelector('input[type="hidden"][name="rating_it"]');
            const ratingInputApk = form.querySelector('input[type="hidden"][name="rating_apk"]');
            
            if (!ratingInputIt && !ratingInputApk) {
                return;
            }

            let currentRatingIt = parseInt(ratingInputIt.value) || 0;
            let currentRatingApk = parseInt(ratingInputApk.value) || 0;

            // Soroti bintang berdasarkan rating
            function highlightStars(rating, stars) {
                stars.forEach(function(star, index) {
                    if (index < rating) {
                        star.style.color = 'orange'; // Bintang terpilih
                    } else {
                        star.style.color = 'gray'; // Bintang tidak terpilih
                    }
                });
            }

            highlightStars(currentRatingIt, stars); // Highlight untuk IT
            highlightStars(currentRatingApk, stars); // Highlight untuk APK

            // Menambahkan event listener untuk mouseover, mouseout, dan klik
            stars.forEach(function(star, index) {
                star.addEventListener('mouseover', function () {
                    highlightStars(index + 1, stars); // Highlight sesuai hover
                });

                star.addEventListener('mouseout', function () {
                    if (starContainer.id.includes('it')) {
                        highlightStars(currentRatingIt, stars); // Kembali ke rating IT
                    } else {
                        highlightStars(currentRatingApk, stars); // Kembali ke rating APK
                    }
                });

                star.addEventListener('click', function () {
                    if (starContainer.id.includes('it')) {
                        currentRatingIt = index + 1;
                        ratingInputIt.value = currentRatingIt; // Update nilai rating IT
                        console.log('Updated rating IT:', currentRatingIt); // Debugging log
                    } else {
                        currentRatingApk = index + 1;
                        ratingInputApk.value = currentRatingApk; // Update nilai rating APK
                        console.log('Updated rating APK:', currentRatingApk); // Debugging log
                    }

                    highlightStars(currentRatingIt, stars); // Update UI sesuai rating IT
                    highlightStars(currentRatingApk, stars); // Update UI sesuai rating APK
                });
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Pastikan modal hanya dibuat satu kali
        if ($('#previewModal').length === 0) {
            $('body').append(`
                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewModalLabel">Preview File</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <!-- Konten preview akan diisi oleh JavaScript -->
                            </div>
                            <div class="modal-footer">
                                <a href="#" id="downloadFileBtn" class="btn btn-primary" download>
                                    <i class="fas fa-download"></i> Unduh File
                                </a>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        // Event klik tombol Preview
        $(document).on('click', '.btn-preview', function () {
            var fileUrl = $(this).data('file'); // Ambil URL file
            var fileExt = fileUrl.split('.').pop().toLowerCase(); // Ambil ekstensi file
            var modalBody = $('#previewModal .modal-body'); // Target modal body
            var downloadBtn = $('#downloadFileBtn'); // Tombol unduh di modal

            // Reset isi modal
            modalBody.html('');
            downloadBtn.attr('href', fileUrl); // Set file untuk diunduh

            // Menampilkan preview berdasarkan ekstensi file
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                modalBody.html('<img src="' + fileUrl + '" class="img-fluid" alt="Preview Image">');
            } else if (fileExt === 'pdf') {
                modalBody.html('<iframe src="' + fileUrl + '" width="100%" height="500px"></iframe>');
            } else if (['xls', 'xlsx', 'doc', 'docx'].includes(fileExt)) {
                var encodedUrl = encodeURIComponent(fileUrl);
                modalBody.html(`
                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src=${encodedUrl}" width="100%" height="500px"></iframe>
                `);
            } else {
                modalBody.html('<p class="text-danger"><i class="fas fa-file-alt"></i> Preview tidak tersedia untuk format file ini.</p>');
            }

            // Tampilkan modal
            $('#previewModal').modal('show');
        });

        // Bersihkan modal setelah ditutup
        $('#previewModal').on('hidden.bs.modal', function () {
            $('#previewModal .modal-body').html('');
        });
    });
</script>
@endsection
