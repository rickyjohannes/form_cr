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
                    <form action="{{ route('proposal.updateit', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            <!-- <input type="hidden" name="no_transaksi" value="{{ $proposal->no_transaksi }}"> -->

                            <!-- Pembatas -->
                            <div style="font-size: 18px; font-weight: bold;">CR Details From USER:</div>
                            <hr style="border: 1px solid #000; margin-top: 5px; margin-bottom: 20px;">

                             <!-- No Doc CR -->
                             <div class="form-group">
                                <label for="name">No Doc CR</label>
                                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ old('name', $proposal->no_transaksi) }}" readonly>
                            </div>

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

                            <!-- Tanggal Start Peminjaman -->
                            <div class="form-group" id="tanggal-start-container" style="display: none;">
                                <label for="estimated_start_date">Estimated Start Date</label>
                                <input 
                                    type="text" 
                                    id="estimated_start_date" 
                                    class="form-control @error('estimated_start_date') is-invalid @enderror" 
                                    name="estimated_start_date"
                                    value="{{ old('estimated_start_date', $proposal->estimated_start_date ? \Carbon\Carbon::parse($proposal->estimated_start_date)->format('d/m/Y H:i') : '') }}"
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)"
                                    readonly
                                    {{ $proposal->estimated_start_date ? 'disabled' : '' }}
                                >

                                @error('estimated_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Tanggal Perkiraan Close -->
                            <div class="form-group" id="tanggal-end-container" style="display: none;">
                                <label for="estimated_date">Request Completion Date</label>
                                <input 
                                    type="text" 
                                    id="estimated_date" 
                                    class="form-control @error('estimated_date') is-invalid @enderror" 
                                    name="estimated_date"
                                    value="{{ old('estimated_date', $proposal->estimated_date ? \Carbon\Carbon::parse($proposal->estimated_date)->format('d/m/Y H:i') : '') }}"
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)"
                                    readonly
                                    {{ $proposal->estimated_date ? 'disabled' : '' }}
                                >

                                @error('estimated_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File User -->
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

                            <!-- Pembatas -->
                            <div style="font-size: 18px; font-weight: bold;">CR Details From IT:</div>
                            <hr style="border: 1px solid #000; margin-top: 5px; margin-bottom: 20px;">

                          

                            <!-- Input untuk Estimated Completion Date -->
                            <div class="form-group">
                                <label for="action_it_date">Estimated Completion Date</label>
                                <input type="text" id="action_it_date_text" class="form-control @error('action_it_date') is-invalid @enderror" name="action_it_date"
                                    value="{{ old('action_it_date', \Carbon\Carbon::parse($proposal->action_it_date)->format('d/m/Y H:i')) }}"
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)" 
                                    {{ $proposal->action_it_date ? 'disabled' : '' }}>

                                @error('action_it_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- IT User Field -->
                            <div class="form-group">
                                <label for="it_user">IT User</label>
                                <textarea id="it_user" class="form-control @error('it_user') is-invalid @enderror" name="it_user" rows="3" placeholder="-" disabled>{{ old('it_user', $proposal->it_user) }}</textarea>
                                @error('it_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- IT Note -->
                            <div class="form-group">
                                <label for="it_analys">IT Note</label>

                                <!-- Box 1, 2, dan 3 hanya ditampilkan jika it_analys kosong -->
                                @if(empty($proposal->it_analys)) 
                                    <!-- Box 1 (Penjelasan Bisnis Proses yang sedang berjalan) -->
                                    <div class="note-box" id="note-box-1">
                                        <label>Ruang Lingkup dan Pengaruh Perubahan :</label>
                                        <input type="text" id="box1" class="form-control" placeholder="Jelaskan ruang lingkup dan pengaruh perubahannya.">
                                    </div>

                                    <!-- Box 2 (Penjelasan Bisnis Proses yang diharapkan) -->
                                    <div class="note-box" id="note-box-2">
                                        <label>Analisa Fungsi dan Teknikal :</label>
                                        <input type="text" id="box2" class="form-control" placeholder="Jelaskan hasil analisa secara fungsi dan teknikal.">
                                    </div>

                                    <!-- Box 3 (Keuntungan/Kelebihan perubahan Bisnis Proses dan biaya) -->
                                    <div class="note-box" id="note-box-3">
                                        <label>Resiko Pengembangan dan Implementasi :</label>
                                        <input type="text" id="box3" class="form-control" placeholder="Jelaskan resiko pengembangan dan implementasinya.">
                                    </div>
                                @endif

                                <!-- Textarea untuk User Note -->
                                @if(in_array('Change Request', old('status_barang', explode(',', $proposal->status_barang)))) 
                                    <textarea
                                        id="it_analys"
                                        class="form-control @error('it_analys') is-invalid @enderror"
                                        name="it_analys"
                                        rows="10"
                                        placeholder="Penjelasan tambahan terkait Change Request disini..."
                                    >{{ old('it_analys', $proposal->it_analys) }}</textarea>
                                @else
                                    <textarea
                                        id="it_analys"
                                        class="form-control @error('it_analys') is-invalid @enderror"
                                        name="it_analys"
                                        rows="3"
                                        placeholder="Tuliskan tujuan permintaan Anda di sini..."
                                        {{ $proposal->it_analys ? 'disabled' : '' }}
                                    >{{ old('it_analys', $proposal->it_analys) }}</textarea>
                                @endif

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

                           <!-- No Asset Field -->
                           <div class="form-group" id="no-asset-container" style="display: none;">
                                <label for="no_asset">No Asset</label>
                                <textarea class="form-control @error('no_asset') is-invalid @enderror" name="no_asset" rows="3" placeholder="Enter No Asset..." {{ $proposal->no_asset ? 'disabled' : '' }}>{{ old('no_asset', $proposal->no_asset) }}</textarea>
                                @error('no_asset')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusBarangSelect = document.querySelectorAll('input[name="status_barang[]"]');
    const noAssetUserContainer = document.getElementById('no_asset_user-container');
    const noAssetContainer = document.getElementById('no-asset-container');
    const itAnalysField = document.getElementById('it_analys');
    const tanggalStartContainer = document.getElementById('tanggal-start-container'); // Input tanggal peminjaman
    const tanggalEndContainer = document.getElementById('tanggal-end-container'); // Input tanggal pengembalian
    const noteBox1 = document.getElementById('note-box-1');
    const noteBox2 = document.getElementById('note-box-2');
    const noteBox3 = document.getElementById('note-box-3');
    const dateInput = document.getElementById('action_it_date_text');
    const form = dateInput.closest('form'); // Ambil form tempat input berada
    const submitButton = document.getElementById('submit-button'); // Tombol submit form
    var itAnalysTextarea = document.getElementById('it_analys');
        

    function updateITNote() {
        let box1 = document.getElementById('box1').value;
        let box2 = document.getElementById('box2').value;
        let box3 = document.getElementById('box3').value;

        let userNote = `Penjelasan Bisnis Proses yang sedang berjalan pada saat ini: ${box1}\n\nPenjelasan Bisnis Proses yang diharapkan: ${box2}\n\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya: ${box3}`;

        itAnalysField.value = userNote;
    }

    function toggleNoAssetField() {
        // Mendapatkan semua checkbox yang dipilih
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
            
        // Pastikan elemen-elemen yang ingin dimanipulasi ada di DOM
        if (tanggalEndContainer !== null && tanggalStartContainer !== null) {
            // Menyembunyikan atau menampilkan tanggalEndContainer dan tanggalStartContainer
            if (selectedValues.includes('Change Request')) {
                tanggalEndContainer.style.display = 'block';
                tanggalStartContainer.style.display = 'none';
            } else if (selectedValues.includes('Peminjaman')) {
                tanggalStartContainer.style.display = 'block';
                tanggalEndContainer.style.display = 'block';
            } else {
                tanggalEndContainer.style.display = 'none';
                tanggalStartContainer.style.display = 'none';
            }
        } else {
            // Menyembunyikan tanggalEndContainer jika tanggalEndContainer atau tanggalStartContainer tidak ada
            if (tanggalEndContainer !== null) {
                tanggalEndContainer.style.display = 'none';
            }
            if (tanggalStartContainer !== null) {
                tanggalStartContainer.style.display = 'none';
            }
        }

        if (noAssetUserContainer !== null) {
            if (selectedValues.includes('Pergantian')) {
                noAssetUserContainer.style.display = 'block';
            } else {
                noAssetUserContainer.style.display = 'none';
            }
        }

        if (noAssetContainer !== null) {
            if (selectedValues.includes('Pembelian') || selectedValues.includes('Peminjaman') || selectedValues.includes('Pergantian')) {
                noAssetContainer.style.display = 'block';
            } else {
                noAssetContainer.style.display = 'none';
            }
        }

        if (itAnalysField !== null) {
            if (selectedValues.includes('Change Request')) {
                itAnalysField.placeholder = "Penjelasan tambahan terkait Change Request disini...";
                itAnalysField.disabled = false;

                if (noteBox1 !== null) noteBox1.style.display = 'block';
                if (noteBox2 !== null) noteBox2.style.display = 'block';
                if (noteBox3 !== null) noteBox3.style.display = 'block';
            } else {
                itAnalysField.placeholder = "Enter Note....";
                itAnalysField.disabled = false;

                if (noteBox1 !== null) noteBox1.style.display = 'none';
                if (noteBox2 !== null) noteBox2.style.display = 'none';
                if (noteBox3 !== null) noteBox3.style.display = 'none';
            }
        }
    }


    statusBarangSelect.forEach(checkbox => {
        checkbox.addEventListener('change', toggleNoAssetField);
    });

    toggleNoAssetField();

    const box1Input = document.getElementById('box1');
    const box2Input = document.getElementById('box2');
    const box3Input = document.getElementById('box3');

    if (box1Input) {
        box1Input.addEventListener('input', updateITNote);
    }
    if (box2Input) {
        box2Input.addEventListener('input', updateITNote);
    }
    if (box3Input) {
        box3Input.addEventListener('input', updateITNote);
    }

    // Cek jika input tidak dalam keadaan disabled
    if (dateInput && !dateInput.disabled) {
        flatpickr(dateInput, {
            enableTime: true,                 // Menyediakan input waktu
            dateFormat: "d/m/Y H:i",          // Format tanggal yang digunakan di UI
            time_24hr: true,                  // 24-hour format untuk waktu
            defaultDate: new Date()           // Set default date to now (current date and time)
        });
    }

    // Event listener untuk form submission
    form.addEventListener('submit', function (e) {
        // Cek apakah tombol sudah dinonaktifkan untuk mencegah submit ganda
        if (submitButton.disabled) {
            e.preventDefault(); // Jika tombol sudah dinonaktifkan, batalkan pengiriman
            return false;
        }

        // Validasi dan konversi tanggal
        let rawDate = dateInput.value;

        // Validasi dan parsing input 'd/m/Y H:i'
        const regex = /^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/;
        const match = rawDate.match(regex);

        if (match) {
            const day = match[1];
            const month = match[2];
            const year = match[3];
            const hour = match[4];
            const minute = match[5];

            // Format ke yyyy-mm-ddThh:mm untuk datetime-local
            const formattedDate = `${year}-${month}-${day}T${hour}:${minute}`;

            // Setkan nilai input form ke format yang sesuai untuk datetime-local
            dateInput.value = formattedDate;
        } else {
            alert('Please enter the date in the correct format (dd/mm/yyyy hh:mm)');
            e.preventDefault(); // Hentikan form submission jika format salah
            return false;
        }

        // Menonaktifkan tombol submit setelah form dikirim
        submitButton.disabled = true;
        submitButton.innerHTML = 'Submitting...'; // Ubah teks tombol untuk memberi tahu pengguna
    });

        // Cek apakah nilai it_analys ada
        if (itAnalysTextarea.value.trim() !== '') {
            itAnalysTextarea.disabled = true; // Nonaktifkan textarea jika ada nilai
        }
    
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

@section('styles')
    <style>
        .note-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .note-box label {
            font-weight: bold;
        }

        .note-box input {
            width: 100%;
            margin-top: 5px;
            padding: 8px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #user_note {
            width: 100%;
            margin-top: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            resize: vertical;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
@endsection
