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
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit CR</h3>
                    </div>
                    <form action="{{ route('proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                          <!-- NO CR -->
                          <div class="form-group">
                              <label for="user_request">No CR</label>
                              <textarea class="form-control @error('no_transaksi') is-invalid @enderror" name="no_transaksi" rows="3" placeholder="Enter Name" disabled>{{ old('no_transaksi', $proposal->no_transaksi) }}</textarea>
                              @error('no_transaksi')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>


                            <!-- User Request -->
                            <div class="form-group">
                                <label for="user_request">User / Request</label>
                                <textarea class="form-control @error('user_request') is-invalid @enderror" name="user_request" rows="3" placeholder="Enter Name">{{ old('user_request', $proposal->user_request) }}</textarea>
                                @error('user_request')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- User Status -->
                            <div class="form-group">
                                <label for="user_status">User Status</label>
                                <textarea class="form-control @error('user_status') is-invalid @enderror" name="user_status" rows="3" placeholder="Enter Status">{{ old('user_status', $proposal->user_status) }}</textarea>
                                @error('user_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Departement -->
                            <div class="form-group">
                                <label for="departement">Departement</label>
                                <select id="select-state-depart" class="form-control mt-2 @error('departement') is-invalid @enderror" name="departement">
                                    <option value="">Pilih Departement</option>
                                    @foreach(['IT', 'PPIC', 'MARKETING', 'ACCOUNTING', 'FINANCE', 'ENGINEERING', 'MAINTENANCE', 'Other'] as $depart)
                                        <option value="{{ $depart }}" {{ (old('departement', $proposal->departement) == $depart) ? 'selected' : '' }}>{{ $depart }}</option>
                                    @endforeach
                                </select>
                                @error('departement')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label for="ext_phone">Ext / Phone</label>
                                <textarea class="form-control @error('ext_phone') is-invalid @enderror" name="ext_phone" rows="3" placeholder="Enter Phone">{{ old('ext_phone', $proposal->ext_phone) }}</textarea>
                                @error('ext_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Barang -->
                            <div class="form-group">
                                <label for="status_barang">Status Barang</label>
                                <select id="select-state-barang" class="form-control mt-2" name="status_barang[]" multiple required>
                                    <option value="">Pilih Status Barang</option>
                                    @foreach (['Pembelian', 'Peminjaman', 'Pengembalian'] as $status)
                                        <option value="{{ $status }}" {{ in_array($status, old('status_barang', $status_barang)) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                    <option value="Lainnya" {{ in_array('Lainnya', old('status_barang', $status_barang)) ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('status_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                          <!-- Fasilitas -->
                            <div class="form-group">
                                <label for="select-state">Fasilitas</label>
                                <select id="select-state" class="form-control mt-2" name="facility[]" multiple required>
                                    <option value="">Pilih Fasilitas</option>
                                    @foreach ($facility as $item)
                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                    @endforeach
                                    <option value="Lainnya" {{ in_array('Lainnya', old('facility', $facility)) ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('facility')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- User Note -->
                            <div class="form-group">
                                <label for="user_note">User Note</label>
                                <textarea class="form-control @error('user_note') is-invalid @enderror" name="user_note" rows="3" placeholder="Enter Note">{{ old('user_note', $proposal->user_note) }}</textarea>
                                @error('user_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File User -->
                            <div class="form-group">
                                <label for="file">File Attachment User</label>
                                <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file"> 
                                <b>
                                    <label>
                                        @if(old('file'))
                                            {{ old('file') }}
                                        @elseif($proposal->file)
                                            <a href="{{ asset('uploads/' . $proposal->file) }}" target="_blank">{{ basename($proposal->file) }}</a>
                                        @else
                                            No file uploaded.
                                        @endif
                                    </label>
                                </b>
                                
                                @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- IT Note -->
                            <div class="form-group">
                                <label for="it_analys">IT Note</label>
                                <textarea class="form-control @error('it_analys') is-invalid @enderror" name="it_analys" rows="3" placeholder="Enter Note">{{ old('it_analys', $proposal->it_analys) }}</textarea>
                                @error('it_analys')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <!-- File IT -->
                            <div class="form-group">
                                <label for="file_it">File Attachment IT</label>
                                <input type="file" class="form-control-file @error('file_it') is-invalid @enderror" id="file_it" name="file_it"> 
                                <b>
                                    <label>
                                        @if(old('file_it'))
                                            {{ old('file_it') }}
                                        @elseif($proposal->file_it)
                                            <a href="{{ asset('uploads/' . $proposal->file_it) }}" target="_blank">{{ basename($proposal->file_it) }}</a>
                                        @else
                                            No file uploaded.
                                        @endif
                                    </label>
                                </b>

                                @error('file_it')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const selectStateDepart = document.getElementById('select-state-depart');
    const otherOptionDepart = document.getElementById('other-option-depart');

    selectStateDepart.addEventListener('change', function() {
        otherOptionDepart.style.display = this.value === 'Other' ? 'block' : 'none';
        if (this.value !== 'Other') {
            otherOptionDepart.querySelector('input[name="departementother"]').value = ''; 
        }
    });

    const statusBarangSelect = document.getElementById('select-state-barang');
    const fasilitasSelect = document.getElementById('select-state');

    statusBarangSelect.addEventListener('change', function() {
        const selectedValues = Array.from(statusBarangSelect.selectedOptions).map(option => option.value);
        fasilitasSelect.innerHTML = '<option value="">Pilih Fasilitas</option>';

        if (selectedValues.includes('Pembelian')) {
            fasilitasSelect.innerHTML += `
                <option value="Account -> Login">Account -> Login</option>
                <option value="Account -> Email">Account -> Email</option>
                <option value="Account -> Internet">Account -> Internet</option>
                <option value="Software -> Install Software">Software -> Install Software</option>
                <option value="Software -> Change Request">Software -> Change Request</option>
                <option value="Software -> New Application">Software -> New Application</option>
                <option value="Infrastruktur -> PC / TC">Infrastruktur -> PC / TC</option>
                <option value="Infrastruktur -> Printer / Scanner">Infrastruktur -> Printer / Scanner</option>
                <option value="Infrastruktur -> Monitor">Infrastruktur -> Monitor</option>
                <option value="Infrastruktur -> Keyboard / Mouse">Infrastruktur -> Keyboard / Mouse</option>
                <option value="Infrastruktur -> Lan / Telp">Infrastruktur -> Lan / Telp</option>
            `;
        }
        if (selectedValues.includes('Peminjaman')) {
            fasilitasSelect.innerHTML += `
                <option value="Infrastruktur -> PC / TC">Infrastruktur -> PC / TC</option>
                <option value="Infrastruktur -> Printer / Scanner">Infrastruktur -> Printer / Scanner</option>
                <option value="Infrastruktur -> Monitor">Infrastruktur -> Monitor</option>
                <option value="Infrastruktur -> Keyboard / Mouse">Infrastruktur -> Keyboard / Mouse</option>
                <option value="Infrastruktur -> Lan / Telp">Infrastruktur -> Lan / Telp</option>
            `;
        }
        if (selectedValues.includes('Pengembalian')) {
            fasilitasSelect.innerHTML += `
                <option value="Infrastruktur -> PC / TC">Infrastruktur -> PC / TC</option>
                <option value="Infrastruktur -> Printer / Scanner">Infrastruktur -> Printer / Scanner</option>
                <option value="Infrastruktur -> Monitor">Infrastruktur -> Monitor</option>
                <option value="Infrastruktur -> Keyboard / Mouse">Infrastruktur -> Keyboard / Mouse</option>
                <option value="Infrastruktur -> Lan / Telp">Infrastruktur -> Lan / Telp</option>
            `;
        }
    });
</script>


@endsection

