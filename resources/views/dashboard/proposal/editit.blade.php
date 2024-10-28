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
                    <form action="{{ route('proposal.updateit', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                          <!-- NO CR -->
                          <div class="form-group">
                              <label for="user_request">No CR</label>
                              <textarea class="form-control @error('no_transaksi') is-invalid @enderror" name="no_transaksi" rows="3" placeholder="No CR" disabled>{{ old('no_transaksi', $proposal->no_transaksi) }}</textarea>
                              @error('no_transaksi')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                            <!-- User Request -->
                            <div class="form-group">
                                <label for="user_request">User / Request</label>
                                <textarea class="form-control @error('user_request') is-invalid @enderror" name="user_request" rows="3" placeholder="Enter Name..." {{ $proposal->user_request ? 'disabled' : '' }}>{{ old('user_request', $proposal->user_request) }}</textarea>
                                @error('user_request')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- User Status -->
                            <div class="form-group">
                                <label for="user_status">User Status</label>
                                <textarea class="form-control @error('user_status') is-invalid @enderror" name="user_status" rows="3" placeholder="Enter Status..." {{ $proposal->user_status ? 'disabled' : '' }}>{{ old('user_status', $proposal->user_status) }}</textarea>
                                @error('user_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Departement -->
                            <div class="form-group">
                                <label for="departement">Departement</label>
                                <select id="select-state-depart" class="form-control mt-2 @error('departement') is-invalid @enderror" name="departement" {{ $proposal->departement ? 'disabled' : '' }}>
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
                                <textarea class="form-control @error('ext_phone') is-invalid @enderror" name="ext_phone" rows="3" placeholder="Enter Phone..." {{ $proposal->ext_phone ? 'disabled' : '' }}>{{ old('ext_phone', $proposal->ext_phone) }}</textarea>
                                @error('ext_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Barang -->
                            <div class="form-group">
                                <label>Status Barang</label>
                                @foreach (['Pembelian', 'Peminjaman', 'Pengembalian','Request CR SAP / New Software Non SAP'] as $status)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status_barang[]" id="status_barang_{{ $loop->index }}" value="{{ $status }}" {{ in_array($status, old('status_barang', $status_barang)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_barang_{{ $loop->index }}">
                                            {{ $status }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('status_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                          <!-- Fasilitas -->
                          <div class="form-group">
                                <label for="facility">Fasilitas</label>
                                @foreach ($facilityOptions as $item)
                                    <div>
                                        <input type="checkbox" name="facility[]" value="{{ $item }}" {{ in_array($item, old('facility', $facility)) ? 'checked' : '' }}>
                                        <label>{{ $item }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- User Note -->
                            <div class="form-group">
                                <label for="user_note">User Note</label>
                                <textarea class="form-control @error('user_note') is-invalid @enderror" name="user_note" rows="3" placeholder="Enter Note" {{ $proposal->user_note ? 'disabled' : '' }}>{{ old('user_note', $proposal->user_note) }}</textarea>
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
                            
                          <!-- Estimated Date -->
                        <div class="form-group">
                            <label for="estimated_date">Estimated Date</label>
                            <input type="datetime-local" class="form-control @error('estimated_date') is-invalid @enderror" name="estimated_date" value="{{ old('estimated_date', \Carbon\Carbon::parse($proposal->estimated_date)->format('Y-m-d\TH:i')) }}" {{ $proposal->estimated_date ? 'disabled' : '' }}>
                            @error('estimated_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>

                            <!-- IT Note -->
                            <div class="form-group">
                                <label for="it_analys">IT Note</label>
                                <textarea class="form-control @error('it_analys') is-invalid @enderror" name="it_analys" rows="3" placeholder="Enter Note..." {{ $proposal->it_analys ? 'disabled' : '' }}>{{ old('it_analys', $proposal->it_analys) }}</textarea>
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

                            <!-- NO ASSET -->
                            <div class="form-group">
                                <label for="no_asset">No Asset</label>
                                <textarea class="form-control @error('no_asset') is-invalid @enderror" name="no_asset" rows="3" placeholder="Enter No Asset..." {{ $proposal->no_asset ? 'disabled' : '' }}>{{ old('no_asset', $proposal->no_asset) }}</textarea>
                                @error('no_asset')
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
    document.addEventListener('DOMContentLoaded', function () {
        const statusBarangSelect = document.querySelectorAll('input[name="status_barang[]"]');
        const facilityContainer = document.getElementById('facility-container');

        const options = {
            'Pembelian': [
                "Account -> Login",
                "Account -> Email",
                "Account -> Internet",
                "Software -> Install Software",
                "Software -> Change Request",
                "Software -> New Application",
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ],
            'Peminjaman': [
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ],
            'Pengembalian': [
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ],
            'Request CR SAP / New Software Non SAP': [
                "SAP Otorisasi User",
                "New Project Software / Aplikasi",
                "Change Request Improve SAP"
            ]
        };

        statusBarangSelect.forEach(checkbox => {
            checkbox.addEventListener('change', updateFasilitas);
        });

        function updateFasilitas() {
            const selectedValues = Array.from(statusBarangSelect)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            facilityContainer.innerHTML = ''; // Clear previous options
            if (selectedValues.length > 0) {
                selectedValues.forEach(value => {
                    options[value].forEach(facility => {
                        const div = document.createElement('div');
                        div.classList.add('form-check');
                        div.innerHTML = `
                            <input class="form-check-input" type="checkbox" name="facility[]" id="facility_${facility}" value="${facility}">
                            <label class="form-check-label" for="facility_${facility}">${facility}</label>
                        `;
                        facilityContainer.appendChild(div);
                    });
                });
            } else {
                facilityContainer.innerHTML = '<p>Pilih status barang terlebih dahulu untuk melihat fasilitas.</p>';
            }
        }

        updateFasilitas(); // Initialize facilities based on pre-selected status
    });
</script>

@endsection
