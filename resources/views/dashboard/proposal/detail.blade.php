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
            <li class="breadcrumb-item">CR</li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('content')
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">CR Details From User:</h3>
      </div>

      <div class="card-body">
        <div class="row">
          <!-- Info Boxes -->
          <div class="col-12 col-md-12 col-lg-8">
            <div class="row">
              @foreach ([
                'No Doc CR' => $proposal->no_transaksi,
                'Company Code' => $proposal->company_code,
                'User / Request' => $proposal->user_request,
                'Position' => $proposal->user_status,
                'Departement' => $proposal->departement,
                'Phone' => $proposal->ext_phone,
                'Jenis Permintaan' => $proposal->status_barang,
                'Kategori' => $proposal->kategori,
                'Facility' => $proposal->facility,
                'No Asset User' => $proposal->no_asset_user,
                'Status DH' => $proposal->status_dh,
                'Status DIVH' => $proposal->status_divh,
                'Submission Date' => \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y | H:i:s'),
                'Estimated Start Date' => \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d-m-Y | H:i:s'),
                'Request Completion Date' => \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s')
              ] as $label => $value)
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">{{ $label }}</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $value }}</span>
                    </div>
                  </div>
                </div>
              @endforeach
              
              <!-- File Attachment -->
              <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                      <div class="info-box-content text-center">
                          <span class="info-box-text text-muted">Attachment User</span>
                          
                          @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
                              @php
                                  $filePath = asset('uploads/' . $proposal->file);
                              @endphp

                              <!-- Button Preview -->
                              <button type="button" class="btn btn-success btn-preview" data-file="{{ $filePath }}">
                                  <i class="fas fa-eye"></i> Preview
                              </button>

                              <!-- Download Button -->
                              <a href="{{ route('download.file', ['filename' => $proposal->file]) }}" class="btn btn-primary">
                                  <i class="fas fa-download"></i> Unduh File
                              </a>

                              <b><label class="d-block mt-2">{{ $proposal->file }}</label></b>

                              <!-- Modal Preview -->
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

                          @else
                              <span class="text-danger">File Tidak Ditemukan!</span>
                          @endif
                      </div>
                  </div>
              </div>

              <!-- User Note -->
              <div class="col-12">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">User Note</span>
                    <div class="info-box-number text-left text-muted mb-0">
                        @if (!empty($proposal->user_note))
                            @php
                                // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                                $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->user_note);
                                // Mengonversi newline menjadi <br> agar terlihat di HTML
                                $cleanedNote = nl2br($formattedNote);
                            @endphp
                            {!! $cleanedNote !!}
                        @else
                            <!-- Jika user_note kosong, tampilkan pesan default -->
                            <textarea class="form-control" rows="5" readonly>User Note not available...</textarea>
                        @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

              <!-- Teks "CR Details From IT:" -->
              <div class="card-header">
                <h3 class="card-title">CR Details From IT:</h3>
              </div>

              <!-- IT CR Closure Date -->
              <div class="col-12 col-md-12 col-lg-3">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Estimated Completion Date</span>
                    <div class="info-box-number text-center text-muted mb-0">
                         <p><strong>{{ \Carbon\Carbon::parse($proposal->action_it_date)->format('d-m-Y | H:i:s') }}</strong></p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- IT CR Closure Date -->
              <div class="col-12 col-md-12 col-lg-3">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">IT CR Closure Date</span>
                    <div class="info-box-number text-center text-muted mb-0">
                         <p><strong>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</strong></p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- No Asset IT -->
              <div class="col-12 col-md-12 col-lg-3">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">No Asset IT</span>
                    <div class="info-box-number text-center text-muted mb-0">
                        @if (!empty($proposal->no_asset))
                          <p readonly><strong>{{ $proposal->no_asset }}</strong></p>
                        @else
                          <!-- Jika it_analys kosong, tampilkan pesan default -->
                          <p readonly>No Asset IT not available...</p>
                        @endif
                    </div>
                  </div>
                </div>
              </div>

              <!-- File Attachment IT-->
              <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                      <div class="info-box-content text-center">
                          <span class="info-box-text text-muted">Attachment IT</span>
                          
                          @if (!empty($proposal->file_it) && file_exists(public_path('uploads/' . $proposal->file_it)))
                              @php
                                  $filePath = asset('uploads/' . $proposal->file_it);
                              @endphp

                              <!-- Button Preview -->
                              <button type="button" class="btn btn-success btn-preview" data-file="{{ $filePath }}">
                                  <i class="fas fa-eye"></i> Preview
                              </button>

                              <!-- Download Button -->
                              <a href="{{ route('download.file', ['filename' => $proposal->file]) }}" class="btn btn-primary">
                                  <i class="fas fa-download"></i> Unduh File
                              </a>

                              <b><label class="d-block mt-2">{{ $proposal->file }}</label></b>

                              <!-- Modal Preview -->
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

                          @else
                              <span class="text-danger">File Tidak Ditemukan!</span>
                          @endif
                      </div>
                  </div>
              </div>

              <!-- IT Note -->
              <div class="col-12 col-md-12 col-lg-8">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">IT Note</span>
                    <div class="info-box-number text-left text-muted mb-0">
                        @if (!empty($proposal->it_analys))
                            @php
                                // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                                $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->it_analys);
                                // Mengonversi newline menjadi <br> agar terlihat di HTML
                                $cleanedNote = nl2br($formattedNote);
                            @endphp
                            {!! $cleanedNote !!}
                        @else
                          <!-- Jika it_analys kosong, tampilkan pesan default -->
                          <textarea class="form-control" rows="5" readonly>IT Note not available...</textarea>
                        @endif
                    </div>
                  </div>
                </div>
     
              <!-- Back Button -->
              <div class="col-12 col-md-12 col-lg-13 text-center mt-5 mb-3">
                <a href="{{ route('proposal.index') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>
              </div>

        </div>
      </div>
    </div>
  </section>    
@endsection

@section('script')
<script>
    $(document).ready(function () {
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
            } else if (['xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx'].includes(fileExt)) {
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