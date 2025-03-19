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
                    <li class="breadcrumb-item">FORM CR</li>
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

                            <input type="hidden" name="no_transaksi" value="{{ $proposal->no_transaksi }}">

                            <!-- Company Code -->
                            <div class="form-group">
                                <label for="company_code">Company Code</label>
                                <input type="text" id="company_code_display" class="form-control mt-2" readonly>
                                <input type="hidden" id="company_code" name="company_code" value="{{ auth()->user()->company_code ?? '' }}">
                            </div>

                            <!-- User / Request -->
                            <div class="form-group">
                                <label for="name">User / Request</label>
                                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ old('name', $proposal->user_request) }}" readonly>
                            </div>

                            <!-- Position -->
                            <div class="form-group">
                                <label for="user_status">Position</label>
                                <input type="text" id="user_status" class="form-control mt-2" name="user_status" value="{{ old('user_status', $proposal->user_status) }}" readonly>
                            </div>

                            <!-- Departement -->
                            <div class="form-group">
                                <label for="departement">Departement</label>
                                <input type="text" id="departement" class="form-control mt-2" name="departement" value="{{ old('departement', $proposal->departement) }}" readonly>
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label for="ext_phone">Phone</label>
                                <input type="text" id="ext_phone" class="form-control mt-2" name="ext_phone" value="{{ old('ext_phone', $proposal->ext_phone) }}" readonly>
                            </div>

                            <!-- Jenis Permintaan -->
                            <div class="form-group">
                                <label>Jenis Permintaan</label>
                                @foreach (['Pembelian', 'Change Request', 'Peminjaman', 'Pergantian','IT Helpdesk'] as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status_barang[]" id="status_barang_{{ $loop->index }}" value="{{ $item }}" {{ in_array($item, old('status_barang', explode(',', $proposal->status_barang))) ? 'checked' : '' }} disabled>
                                        <label class="form-check-label" for="status_barang_{{ $loop->index }}">{{ $item }}</label>
                                    </div>
                                @endforeach
                                @error('status_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div class="form-group">
                                <label>Kategori</label>
                                <div id="kategori-container">
                                    @if (!empty($proposal->kategori))
                                        @foreach (explode(',', $proposal->kategori) as $kategori)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kategori[]" id="kategori_{{ $kategori }}" value="{{ $kategori }}" {{ in_array($kategori, old('kategori', explode(',', $proposal->kategori))) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="kategori_{{ $kategori }}">{{ $kategori }}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Tidak ada kategori.</p>
                                    @endif
                                </div>
                                @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fasilitas -->
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <div id="facility-container">
                                    @if (!empty($proposal->facility))
                                        @foreach (explode(',', $proposal->facility) as $facility)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="facility[]" id="facility_{{ $facility }}" value="{{ $facility }}" {{ in_array($facility, old('facility', explode(',', $proposal->facility))) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="facility_{{ $facility }}">{{ $facility }}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Tidak ada Fasilitas.</p>
                                    @endif
                                </div>
                                @error('facility')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div id="other-facility-container" style="display: none;">
                                    <label for="other_facility">Other Fasilitas</label>
                                    <input type="text" id="other_facility" class="form-control" name="other_facility" value="{{ old('other_facility', $proposal->other_facility) }}" placeholder="Isi disini jika tidak ada diopsi..." disabled>
                                </div>
                            </div>

                            <!-- User Note -->
                            <div class="form-group">
                                <label for="user_note">User Note</label>
                                <textarea id="user_note" class="form-control @error('user_note') is-invalid @enderror" name="user_note" rows="3" placeholder="Enter note...." disabled>{{ old('user_note', $proposal->user_note) }}</textarea>
                                @error('user_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No Asset Field (initially hidden) -->
                            <div class="form-group" id="no_asset_user-container" style="display: none;">
                                <label for="no_asset_user">No Asset</label>
                                <input type="text" id="no_asset_user" class="form-control" name="no_asset_user" value="{{ old('no_asset_user', $proposal->no_asset_user) }}" disabled>
                            </div>

                            <!-- File -->
                            <div class="form-group">
                                <label for="file">File Attachment User</label>
                                <input type="file" id="file" class="form-control-file @error('file') is-invalid @enderror" name="file"> 
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
                            </div>

                        </div>

                        <!-- Tombol Submit -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="submit-button">Submit</button>
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
    const noAssetContainer = document.getElementById('no_asset_user-container');
    const submitButton = document.getElementById('submit-button'); // Tombol submit
    const form = submitButton.closest('form'); // Ambil form yang paling dekat

    // Function to toggle the "No Asset" field visibility
    function toggleNoAssetField() {
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Show the "No Asset" input if "Pergantian" is selected
        if (selectedValues.includes('Pergantian')) {
            noAssetContainer.style.display = 'block';
        } else {
            noAssetContainer.style.display = 'none';
        }
    }

    // Event listener for "Jenis Permintaan" checkboxes (status_barang)
    statusBarangSelect.forEach(checkbox => {
        checkbox.addEventListener('change', toggleNoAssetField);
    });

    // Initial call to handle pre-filled values
    toggleNoAssetField();

    form.addEventListener('submit', function (event) {
        // Cek apakah tombol sudah dinonaktifkan untuk mencegah submit ganda
        if (submitButton.disabled) {
            event.preventDefault(); // Jika tombol sudah dinonaktifkan, batalkan pengiriman
            return false;
        }

        // Menonaktifkan tombol submit setelah diklik
        submitButton.disabled = true;
        submitButton.innerHTML = 'Submitting...'; // Ubah teks tombol untuk memberi tahu pengguna
    });
});
</script>

<!-- Script untuk Menampilkan Format "Kode - Nama Perusahaan" -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var companyInput = document.getElementById("company_code");
        var displayInput = document.getElementById("company_code_display");

        // Mapping company codes ke nama lengkapnya
        var companyNames = {
            "1100": "PT. Dharma Polimetal Tbk",
            "1200": "PT. Dharma Poliplast",
            "1300": "PT. Dharma Precision Part",
            "1400": "PT. Dharma Precision Tools",
            "1500": "PT. Dharma Electrindo Manufacturing",
            "1600": "PT .Dharma Control Cable",
            "1700": "PT. Trimitra Chitrahasta",
        };

        function updateDisplay() {
            var selectedValue = companyInput.value;
            displayInput.value = selectedValue && companyNames[selectedValue] 
                ? `${selectedValue} - ${companyNames[selectedValue]}` 
                : "Unknown Company Code";
        }

        // Set nilai awal saat halaman dimuat
        updateDisplay();
    });
</script>
@endsection
