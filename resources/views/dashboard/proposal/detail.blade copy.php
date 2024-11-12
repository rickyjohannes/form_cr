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
        <h3 class="card-title">CR Detail</h3>
      </div>
      
      <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="{{ asset('template/dashboard/dist/img/avatar5.png') }}" alt="user image">
                    <span class="username">
                      <a href="#">{{ $proposal->user->username }}</a>
                    </span>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="row">
              <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">No Doc CR</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $proposal->no_transaksi }}</span>
                    </div>
                  </div>
                </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">User / Request</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->user_request }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Position</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->user_status }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Departement</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->departement }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Phone</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->ext_phone }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Jenis Permintaan</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->status_barang }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Kategori</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->kategori }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Facility</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->facility }}</span>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">No Asset User</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->no_asset_user }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Status DH</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->status_dh }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Status DIVH</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->status_divh }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Submission Date</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-y|h:m:s') }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Attachment User</span>
                    <div class="post"> 
                      <td>
                        @if (!empty($proposal->file) && file_exists(public_path('uploads/' . $proposal->file)))
                        <a href="{{ url('uploads/' . $proposal->file) }}" class="btn btn-primary">Unduh File</a>
                        <b><label>{{ $proposal->file }}</label></b>
                        @else
                          <span class="text-danger">File Tidak Ditemukan!</span>
                        @endif
                      </td> 
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">User Note</span>
                    <span class="info-box-number text-center text-muted mb-0">{{ $proposal->user_note }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Teks "CR Details From IT:" -->
            <p style="text-align: center; font-weight: bold;">CR Details From IT:</p>
            <!-- Garis horizontal -->
            <div style="border-bottom: 2px solid #000; margin-top: 20px;"></div>

            <!-- Down -->

            <div class="row">
              <div class="col-20">
                <h4>Estimated Date</h4>
                <div class="post"> 
                <td>
                  <b><span class="info-box-number text-center text-muted mb-0">{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y h:i:s') }}</span></b>
                </td>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-20">
                <h4>IT Note</h4>
                <div class="post"> 
                  <textarea rows="5" cols="30" readonly>{{ $proposal->it_analys }}</textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-20">
                <h4>No Asset IT</h4>
                <div class="post"> 
                  <textarea rows="5" cols="30" readonly>{{ $proposal->no_asset }}</textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-20">
                <h4>File Attachment IT</h4>
                <div class="post"> 
                  <td>
                      @if (!empty($proposal->file_it) && file_exists(public_path('uploads/' . $proposal->file_it)))
                      <a href="{{ url('uploads/' . $proposal->file) }}" class="btn btn-primary">Unduh File</a>
                      <b><label>{{ $proposal->file_it }}</label></b>
                      @else
                      <i><span class="text-danger">File Tidak Ditemukan!</span></i>
                      @endif
                  </td> 
                </div>
              </div>
            </div>
 
          </div>

          <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
            <!-- <p class="text-sm">Author
            <h3 class="text-primary"><i class="fas fa-file-signature"></i> {{ $proposal->user->profile->name }}</h3>
            <br> -->
            <div class="text-center mt-5 mb-3">
              <a href="{{ route('proposal.index') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>    
@endsection

