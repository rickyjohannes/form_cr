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

                            @php
                                // Ensure $status_barang is always an array
                                $status_barang = is_string($status_barang) ? explode(',', $status_barang) : $status_barang ?? [];
                            @endphp

                            <!-- Status Barang -->
                            <div class="form-group">
                                <label for="status_barang">Status Barang</label>
                                <select id="select-state-barang" class="form-control mt-2" name="status_barang[]" multiple required>
                                    <option value="">Pilih Status Barang</option>
                                    @foreach(['Pembelian', 'Peminjaman', 'Pengembalian'] as $status)
                                        <option value="{{ $status }}" {{ (in_array($status, old('status_barang', $status_barang))) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Fasilitas -->
                            <div class="form-group">
                                <label for="facility">Fasilitas</label>
                                <select id="select-state" class="form-control mt-2" name="facility[]" multiple required>
                                    <option value="">Pilih Fasilitas</option>
                                    <!-- Add facility options here as needed -->
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

                            <!-- File -->
                            <div class="form-group">
                                <label for="file">File Tambahan User</label>
                                <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file">
                                @error('file')
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
    const statusBarangSelect = document.getElementById('select-state-barang');
    const fasilitasSelect = document.getElementById('select-state');

    const facilities = {
        'Pembelian': [
            '(Account -> Login)', 
            '(Software -> Install Software)',
            '(Software -> Change Request)',
            '(Infrastruktur -> PC / TC)',
            '(Infrastruktur -> Printer / Scanner)',
            '(Infrastruktur -> Monitor)',
            '(Infrastruktur -> Keyboard / Mouse)',
            '(Infrastruktur -> Lan / Telp)'
        ],
        'Peminjaman': [
            '(Infrastruktur -> PC / TC)', 
            '(Infrastruktur -> Printer / Scanner)',
            '(Infrastruktur -> Monitor)',
            '(Infrastruktur -> Keyboard / Mouse)',
            '(Infrastruktur -> Lan / Telp)'
        ],
        'Pengembalian': [
            '(Infrastruktur -> PC / TC)', 
            '(Infrastruktur -> Printer / Scanner)',
            '(Infrastruktur -> Monitor)',
            '(Infrastruktur -> Keyboard / Mouse)',
            '(Infrastruktur -> Lan / Telp)'
        ]
    };

    const loadFacilities = () => {
        const selectedValues = Array.from(statusBarangSelect.selectedOptions).map(option => option.value);
        fasilitasSelect.innerHTML = '<option value="">Pilih Fasilitas</option>'; // Reset options

        selectedValues.forEach(value => {
            if (facilities[value]) {
                facilities[value].forEach(facility => {
                    const option = document.createElement('option');
                    option.value = facility;
                    option.textContent = facility;
                    fasilitasSelect.appendChild(option);
                });
            }
        });
    };

    // Add event listener for status selection changes
    statusBarangSelect.addEventListener('change', loadFacilities);

    // Initial load for pre-selected status
    document.addEventListener('DOMContentLoaded', loadFacilities);
</script>
@endsection

