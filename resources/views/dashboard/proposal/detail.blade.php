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
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Attachment User</span>
                    <div class="poinfo-box-text text-center text-mutedst"> 
                      @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
                        <a href="{{ route('download.file', ['filename' => $proposal->file]) }}" class="btn btn-primary">Unduh File</a>
                        <b><label>{{ $proposal->file }}</label></b>
                      @else
                        <span class="text-danger">File Tidak Ditemukan!</span>
                      @endif
                    </div>
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
                              // Membersihkan tag HTML yang tidak diinginkan dan mengonversi baris baru menjadi <br />
                              $cleanedNote = strip_tags($proposal->user_note, '<br>');  // Hanya biarkan <br> tag
                              $cleanedNote = nl2br($cleanedNote);  // Ubah newline menjadi <br />
                          @endphp
                          {!! $cleanedNote !!}
                      @else
                          <!-- Jika it_analys kosong, tampilkan pesan default -->
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
              <div class="col-12 col-md-12 col-lg-3">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Attachment IT</span>
                    <div class="poinfo-box-text text-center text-mutedst"> 
                        @if (!empty($proposal->file_it) && file_exists(public_path('uploads/' . $proposal->file_it)))
                          <a href="{{ url('uploads/' . $proposal->file_it) }}" class="btn btn-primary">Unduh File</a>
                          <b><label>{{ $proposal->file_it }}</label></b>
                        @else
                          <span class="text-danger">File Tidak Ditemukan!</span>
                        @endif
                    </div>
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
                              // Membersihkan tag HTML yang tidak diinginkan dan mengonversi baris baru menjadi <br />
                              $cleanedNote = strip_tags($proposal->it_analys, '<br>');  // Hanya biarkan <br> tag
                              $cleanedNote = nl2br($cleanedNote);  // Ubah newline menjadi <br />
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
