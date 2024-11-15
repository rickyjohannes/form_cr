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
                    <li class="breadcrumb-item active">Create</li>
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
                        <h3 class="card-title">Create CR</h3>
                    </div>

                    <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="no_transaksi" value="{{ \App\Models\Proposal::generateNoTransaksi() }}">

                            <!-- User / Request -->
                            <div class="form-group">
                                <label for="name">User / Request</label>
                                <input type="text" id="name" class="form-control mt-2" name="name" value="{{ auth()->user()->name ?? '' }}" readonly>
                            </div>

                            <!-- Position -->
                            <div class="form-group">
                                <label for="user_status">Position</label>
                                <input type="text" id="user_status" class="form-control mt-2" name="user_status" value="{{ auth()->user()->user_status ?? '' }}" readonly>
                            </div>

                            <!-- Departement -->
                            <div class="form-group">
                                <label for="departement">Departement</label>
                                <input type="text" id="departement" class="form-control mt-2" name="departement" value="{{ auth()->user()->departement ?? '' }}" readonly>
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label for="ext_phone">Phone</label>
                                <input type="text" id="ext_phone" class="form-control mt-2" name="ext_phone" value="{{ auth()->user()->ext_phone ?? '' }}" readonly>
                            </div>

                            <!-- Jenis Permintaan -->
                            <div class="form-group">
                                <label>Jenis Permintaan</label>
                                @foreach (['Pembelian', 'Change Request', 'Peminjaman', 'Pergantian'] as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status_barang[]" id="status_barang_{{ $loop->index }}" value="{{ $item }}" @if(is_array(old('status_barang')) && in_array($item, old('status_barang'))) checked @endif>
                                        <label class="form-check-label" for="status_barang_{{ $loop->index }}">
                                            {{ $item }}
                                        </label>
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
                                    <p>Pilih Jenis Permintaan terlebih dahulu untuk melihat kategori.</p>
                                </div>
                                @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fasilitas -->
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <div id="facility-container">
                                    <p>Pilih Kategori terlebih dahulu untuk melihat fasilitas.</p>
                                </div>
                                @error('facility')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Other Facility Input -->
                                <div id="other-facility-container" style="display: none;">
                                    <label for="other_facility">Other Facility</label>
                                    <input type="text" id="other_facility" class="form-control" name="other_facility" placeholder="Ketik disini jika tidak ada data yang dipilih...">
                                </div>
                            </div>

                            <!-- User Note -->
                            <div class="form-group">
                                <label for="user_note">User Note</label>

                                <!-- Box 1 (Penjelasan Bisnis Proses yang sedang berjalan) -->
                                <div class="note-box" id="note-box-1" style="display: none;">
                                    <label>Penjelasan Bisnis Proses yang sedang berjalan pada saat ini :</label>
                                    <input type="text" id="box1" class="form-control" placeholder="Jelaskan mengenai proses yang berjalan saat ini atau skenario yang ingin diubah." oninput="updateUserNote()">
                                </div>

                                <!-- Box 2 (Penjelasan Bisnis Proses yang diharapkan) -->
                                <div class="note-box" id="note-box-2" style="display: none;">
                                    <label>Penjelasan Bisnis Proses yang diharapkan :</label>
                                    <input type="text" id="box2" class="form-control" placeholder="Apa persyaratan bisnis yang kurang, yang perlu dimasukkan sebagai bagian dari desain." oninput="updateUserNote()">
                                </div>

                                <!-- Box 3 (Keuntungan/Kelebihan perubahan Bisnis Proses dan biaya) -->
                                <div class="note-box" id="note-box-3" style="display: none;">
                                    <label>Keuntungan/Kelebihan perubahan Bisnis Proses dan biaya :</label>
                                    <input type="text" id="box3" class="form-control" placeholder="Jelaskan alasan bisnis mengapa hal ini diperlukan." oninput="updateUserNote()">
                                </div>

                                <!-- Textarea untuk User Note -->
                                <textarea
                                    id="user_note"
                                    class="form-control @error('user_note') is-invalid @enderror"
                                    name="user_note"
                                    rows="10"
                                    placeholder="Penjelasan tambahan disini..."
                                ></textarea>

                                @error('user_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- No Asset (tampilkan hanya jika Pergantian dipilih) -->
                            <div class="form-group" id="no-asset-container" style="display: none;">
                                <label for="no_asset_user">No Asset User</label>
                                <input type="text" id="no_asset_user" class="form-control" name="no_asset_user" placeholder="Isi No Asset jika Pergantian">
                            </div>

                            <!-- Tanggal Pengembalian (Tampil jika Peminjaman dipilih) -->
                            <div class="form-group" id="tanggal-pengembalian-container" style="display: none;">
                                <label for="estimated_date">Tanggal Pengembalian</label>
                                <input 
                                    type="text" 
                                    id="estimated_date_text" 
                                    class="form-control @error('estimated_date') is-invalid @enderror" 
                                    name="estimated_date" 
                                    value="{{ old('estimated_date', \Carbon\Carbon::now()->format('d/m/Y H:i')) }}" 
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)"
                                >
                                @error('estimated_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- File -->
                            <div class="form-group">
                                <label for="file">File Tambahan User</label>
                                <input type="file" id="file" class="form-control-file @error('file') is-invalid @enderror" name="file">
                                @error('file')
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
    const kategoriContainer = document.getElementById('kategori-container');
    const facilityContainer = document.getElementById('facility-container');
    const otherFacilityContainer = document.getElementById('other-facility-container');
    const noAssetContainer = document.getElementById('no-asset-container');
    const tanggalPengembalianContainer = document.getElementById('tanggal-pengembalian-container'); // Input tanggal pengembalian
    const noteBoxes = document.querySelectorAll('.note-box');  // Koleksi semua note-box
    const dateInput = document.getElementById('estimated_date_text'); // Menggunakan input tanggal yang benar
    const form = dateInput.closest('form'); // Ambil form tempat input berada
    const submitButton = document.getElementById('submit-button'); // Tombol submit form

    const options = {
        'Pembelian': [
            "Software",
            "Infrastruktur",
        ],
        'Change Request': [
            "Non SAP",
            "SAP",
        ],
        'Pergantian': [
            "Infrastruktur",
        ],
        'Peminjaman': [
            "Infrastruktur",
        ],
    };

    const options2 = {
        'Software': [
            "Solid Work",
            "Catia",
            "AutoCad",
            "ChatGPT",
        ],
        'Infrastruktur': [
            "PC SET",
            "Laptop",
            "HDMI",
            "Mouse",
            "Keyboard",
            "Power Supply",
            "Monitor",
            "TV",
            "Kabel Charger Laptop",
            "Baterai Laptop",
            "CCTV",
            "NVR",
            "HARDISK",
            "SSD",
            "RAM",
            "IP Phone",
            "Switch",
            "Wireless AccessPoint",
            "Wireless Addaptor",
            "Web Cam",
            "Headset",
        ],
        'Non SAP': [
            "WMS",
            "E-invoice",
            "E-LMR",
            "SSO",
            "TP Go",
            "Tracebility Delivery ADM",
            "Tracebility Delivery HPM",
            "Tracebility Delivery TMMIN",
            "Email",
            "User ID WEB",
            "Account Login PC / Laptop",
            "Other",
        ],
        'SAP': [
            "User ID",
            "Autorisasi",
            "Function", 
        ],
    };

    // Tambahkan event listener ke setiap checkbox status barang
    statusBarangSelect.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleUserNoteBoxes();  // Update tampilan kotak note saat checkbox berubah
            updateFasilitas();       // Update fasilitas berdasarkan jenis permintaan yang dipilih
        });
    });

    kategoriContainer.addEventListener('change', updateFacilities);

    // Fungsi untuk menangani status barang dan menampilkan atau menyembunyikan note-box
    function toggleUserNoteBoxes() {
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Jika "Change Request" dipilih, tampilkan semua note-box
        if (selectedValues.includes('Change Request')) {
            noteBoxes.forEach(noteBox => {
                noteBox.style.display = 'block';  // Tampilkan semua kotak note
            });
        } else {
            noteBoxes.forEach(noteBox => {
                noteBox.style.display = 'none';  // Sembunyikan kotak note
            });
        }
    }
    
    function updateFasilitas() {
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        kategoriContainer.innerHTML = ''; // Clear previous options
        facilityContainer.innerHTML = ''; // Clear facilities
        checkNoAsset(); // Cek apakah Pergantian dipilih
        checkTanggalPengembalian(); // Cek apakah Peminjaman dipilih

        if (selectedValues.length > 0) {
            selectedValues.forEach(value => {
                options[value].forEach(kategori => {
                    const div = document.createElement('div');
                    div.classList.add('form-check');
                    div.innerHTML = `

                        <input class="form-check-input" type="checkbox" name="kategori[]" id="kategori_${kategori}" value="${kategori}">
                        <label class="form-check-label" for="kategori_${kategori}">${kategori}</label>
                    `;
                    kategoriContainer.appendChild(div);
                });
            });
        } else {
            kategoriContainer.innerHTML = '<p>Pilih jenis permintaan terlebih dahulu untuk melihat kategori.</p>';
        }
    }

    function checkNoAsset() {
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        if (selectedValues.includes('Pergantian') || selectedValues.includes('Peminjaman')) {
            noAssetContainer.style.display = 'block'; // Tampilkan input No Asset
        } else {
            noAssetContainer.style.display = 'none'; // Sembunyikan input No Asset
        }
    }

    // Menangani perubahan status barang
    statusBarangSelect.forEach(function(checkbox) {
        checkbox.addEventListener('change', checkTanggalPengembalian);
    });

    function checkTanggalPengembalian() {
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

    // Tampilkan atau sembunyikan input Tanggal Pengembalian jika 'Peminjaman' dipilih
        if (selectedValues.includes('Peminjaman')) {
             tanggalPengembalianContainer.style.display = 'block'; // Tampilkan input Tanggal Pengembalian
        } else {
            tanggalPengembalianContainer.style.display = 'none'; // Sembunyikan input Tanggal Pengembalian
        }
    }

    kategoriContainer.addEventListener('change', function (e) {
        if (e.target.name === 'kategori[]') {
            updateFacilities();
        }
    });

    function updateFacilities() {
        const selectedCategories = Array.from(document.querySelectorAll('input[name="kategori[]"]:checked')).map(checkbox => checkbox.value);
        facilityContainer.innerHTML = ''; // Clear previous facilities
        otherFacilityContainer.style.display = 'none'; // Hide other facility by default

        if (selectedCategories.length > 0) {
            selectedCategories.forEach(category => {
                const facilities = options2[category] || [];
                facilities.forEach(facility => {
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
            facilityContainer.innerHTML = '<p>Pilih kategori terlebih dahulu untuk melihat fasilitas.</p>';
        }

        checkOtherFacility(); // Check if we should show the other facility input
    }

    function checkOtherFacility() {
        const facilityCheckboxes = document.querySelectorAll('input[name="facility[]"]');
        const otherFacilityChecked = Array.from(facilityCheckboxes).some(checkbox => checkbox.checked && checkbox.value === 'Other');
        otherFacilityContainer.style.display = otherFacilityChecked ? 'none' : 'block'; // Show or hide based on 'Other' selection
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

});

function updateUserNote() {
        // Ambil nilai dari ketiga box input
        let box1 = document.getElementById('box1').value;
        let box2 = document.getElementById('box2').value;
        let box3 = document.getElementById('box3').value;

        // Gabungkan ketiga nilai box ke dalam user_note
        let userNote = `Penjelasan Bisnis Proses yang sedang berjalan pada saat ini : ${box1}\n\nPenjelasan Bisnis Proses yang diharapkan : ${box2}\n\nKeuntungan/Kelebihan perubahan Bisnis Proses dan biaya : ${box3}`;

        // Masukkan ke dalam textarea
        document.getElementById('user_note').value = userNote;
    }

</script>

@endsection

@section('styles')
    <style>
        /* Style untuk kotak dengan batas dan padding */
        .note-box {
            border: 1px solid #ccc;  /* Menambahkan garis batas */
            padding: 10px;
            margin-bottom: 15px;  /* Menjaga jarak antar box */
            background-color: #f9f9f9; /* Background box agar tidak terlihat terlalu monoton */
            border-radius: 5px; /* Memberikan sudut yang agak melengkung pada border */
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

        /* Styling untuk textarea */
        #user_note {
            width: 100%;
            margin-top: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            resize: vertical; /* Memungkinkan untuk resize textarea hanya secara vertikal */
        }

        /* Styling untuk pesan error */
        .invalid-feedback {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
@endsection





