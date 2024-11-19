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
                                @foreach (['Pembelian', 'Change Request', 'Peminjaman', 'Pergantian','IT Helpdesk'] as $item)
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
                                    <label for="other_facility">Fasilitas Lain</label>
                                    <input type="text" id="other_facility" class="form-control" name="other_facility" placeholder="Sebutkan fasilitas lainnya jika tidak tersedia dalam pilihan, ketikan disini...">
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
                                    placeholder="Tuliskan tujuan permintaan Anda di sini..."
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

                            <!-- Tanggal Target Permintaan (Tampil jika Change Request dipilih) -->
                            <div class="form-group" id="tanggal-permintaan-container" style="display: none;">
                                <label for="estimated_date_permintaan">Estimated Completion Date (Tanggal Target Permintaan)</label>
                                <input 
                                    type="text" 
                                    id="estimated_date_text_permintaan" 
                                    class="form-control @error('estimated_date_permintaan') is-invalid @enderror" 
                                    name="estimated_date_permintaan" 
                                    value="{{ old('estimated_date_permintaan', \Carbon\Carbon::now()->format('d/m/Y H:i')) }}" 
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)"
                                >
                                @error('estimated_date_permintaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Start Peminjaman (Tampil jika Peminjaman dipilih) -->
                            <div class="form-group" id="tanggal-peminjaman-container" style="display: none;">
                                <label for="estimated_start_date">Estimated Start Date (Tanggal Start Peminjaman)</label>
                                <input 
                                    type="text" 
                                    id="estimated_start_date_text" 
                                    class="form-control @error('estimated_start_date') is-invalid @enderror" 
                                    name="estimated_start_date" 
                                    value="{{ old('estimated_start_date', \Carbon\Carbon::now()->format('d/m/Y H:i')) }}" 
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)"
                                >
                                @error('estimated_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Pengembalian (Tampil jika Peminjaman dipilih) -->
                            <div class="form-group" id="tanggal-pengembalian-container" style="display: none;">
                                <label for="estimated_date_pengembalian">Estimated Completion Date (Tanggal Target Pengembalian)</label>
                                <input 
                                    type="text" 
                                    id="estimated_date_text" 
                                    class="form-control @error('estimated_date_pengembalian') is-invalid @enderror" 
                                    name="estimated_date_pengembalian"  
                                    value="{{ old('estimated_date_pengembalian', \Carbon\Carbon::now()->format('d/m/Y H:i')) }}" 
                                    placeholder="Enter Date (dd/mm/yyyy hh:mm)"
                                >
                                @error('estimated_date_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File -->
                            <div class="form-group">
                                <label for="file">File Attachment User</label>
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
    const noteBoxes = document.querySelectorAll('.note-box');  // Koleksi semua note-box
    const tanggalPermintaanContainer = document.getElementById('tanggal-permintaan-container'); // Input tanggal permintaan
    const tanggalPeminjamanContainer = document.getElementById('tanggal-peminjaman-container'); // Input tanggal peminjaman
    const tanggalPengembalianContainer = document.getElementById('tanggal-pengembalian-container'); // Input tanggal pengembalian
    const dateInput = document.getElementById('estimated_date_text'); // Menggunakan input tanggal yang benar
    const dateInput2 = document.getElementById('estimated_date_text_permintaan'); // Menggunakan input tanggal yang benar
    const dateInput3 = document.getElementById('estimated_start_date_text'); // Menggunakan input tanggal yang benar
    const submitButton = document.getElementById('submit-button'); // Tombol submit form
    const form = document.querySelector('form');  // Pastikan form memiliki event listener submit
    
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
        'IT Helpdesk': [
            "Support Software",
            "Support Infrastruktur",
            "Support SAP",
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

        if (selectedValues.includes('Pergantian')) {
            noAssetContainer.style.display = 'block'; // Tampilkan input No Asset
        } else {
            noAssetContainer.style.display = 'none'; // Sembunyikan input No Asset
        }
    }

    // Menambahkan event listener untuk perubahan pada status barang
    statusBarangSelect.forEach(function(checkbox) {
        checkbox.addEventListener('change', handleTanggalVisibility);
    });

    // Fungsi untuk mengatur tampilan elemen terkait tanggal berdasarkan status barang yang dipilih
    function handleTanggalVisibility() {
        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Cek jika "Peminjaman" dipilih untuk menampilkan tanggal pengembalian
        if (selectedValues.includes('Peminjaman')) {
            tanggalPeminjamanContainer.style.display = 'block'; // Sembunyikan input Tanggal Peminjaman
            tanggalPengembalianContainer.style.display = 'block'; // Tampilkan input Tanggal Pengembalian
            tanggalPermintaanContainer.style.display = 'none'; // Sembunyikan input Tanggal Permintaan
        } else {
            tanggalPeminjamanContainer.style.display = 'none'; // Sembunyikan input Tanggal Peminjaman
            tanggalPengembalianContainer.style.display = 'none'; // Sembunyikan input Tanggal Pengembalian

        }

        // Cek jika "Change Request" dipilih untuk menampilkan tanggal permintaan
        if (selectedValues.includes('Change Request')) {
            tanggalPermintaanContainer.style.display = 'block'; // Tampilkan input Tanggal Permintaan
            tanggalPeminjamanContainer.style.display = 'none'; // Sembunyikan input Tanggal Peminjaman
            tanggalPengembalianContainer.style.display = 'none'; // Sembunyikan input Tanggal Pengembalian
        } else {
            tanggalPermintaanContainer.style.display = 'none'; // Sembunyikan input Tanggal Permintaan
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
    
    // Flatpickr initialization for both date inputs
    if (dateInput && !dateInput.disabled) {
        flatpickr(dateInput, {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            time_24hr: true,
            defaultDate: null,  // Jangan set default date, agar tidak mengirimkan nilai default
        });
    }

    if (dateInput2 && !dateInput2.disabled) {
        flatpickr(dateInput2, {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            time_24hr: true,
            defaultDate: dateInput2.value ? dateInput2.value : null,  // Atur default date jika sudah ada nilai
        });
    }

    // Flatpickr initialization for both date inputs
    if (dateInput3 && !dateInput3.disabled) {
        flatpickr(dateInput3, {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            time_24hr: true,
            defaultDate: null,  // Jangan set default date, agar tidak mengirimkan nilai default
        });
    }

    // Form submit event listener
    form.addEventListener('submit', function (e) {
        let rawDate1 = dateInput.value.trim();  // Tanggal Permintaan (Change Request)
        let rawDate2 = dateInput2.value.trim(); // Tanggal Pengembalian (Peminjaman)
        let rawDate3 = dateInput3.value.trim(); // Tanggal Peminjaman (Peminjaman)

        console.log("Raw Tanggal Permintaan:", rawDate1);
        console.log("Raw Tanggal Pengembalian:", rawDate2);
        console.log("Raw Tanggal Peminjaman:", rawDate3);

        const selectedValues = Array.from(statusBarangSelect)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Validasi input sesuai dengan status barang yang dipilih
        

        if (selectedValues.includes('Change Request') && !rawDate1) {
            alert('Please enter a valid date for the estimated request date.');
            e.preventDefault();
            return false;
        }

        if (selectedValues.includes('Peminjaman') && !rawDate2) {
            alert('Please enter a valid date for the estimated return date.');
            e.preventDefault();
            return false;
        }
        if (selectedValues.includes('Peminjaman') && !rawDate3) {
            alert('Please enter a valid date for the estimated return date.');
            e.preventDefault();
            return false;
        }

        // Pilih tanggal yang sesuai untuk dikirim
        let selectedDate = null;

        if (selectedValues.includes('Change Request') && rawDate1) {
            selectedDate = rawDate1;  // Pilih Tanggal Permintaan jika Change Request
        } else if (selectedValues.includes('Peminjaman') && rawDate2) {
            selectedDate = rawDate2;  // Pilih Tanggal Pengembalian jika Peminjaman
        } else if (selectedValues.includes('Peminjaman') && rawDate3) {
            selectedDate = rawDate3;  // Pilih Tanggal Peminjaman jika Peminjaman
        }

        // Validasi format tanggal
        if (!isValidDate(selectedDate)) {
            alert('Please enter a valid date in the correct format (dd/mm/yyyy hh:mm)');
            e.preventDefault(); // Prevent form submission
            return false;
        }

        // Konversi ke format timestamp
        let formattedDate = convertToTimestamp(selectedDate);

        if (!formattedDate) {
            alert('Error: Invalid date format.');
            e.preventDefault();
            return false;
        }

        // Set nilai formattedDate ke input dengan name="estimated_date"
        document.querySelector('[name="estimated_date"]').value = formattedDate;

        // Disable submit button untuk mencegah double submission
        submitButton.disabled = true;
        submitButton.innerHTML = 'Submitting...'; // Ganti teks tombol menjadi "Submitting..."
    });


    // Fungsi validasi tanggal
    function isValidDate(dateString) {
        const regex = /^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/;  // Format dd/mm/yyyy hh:mm
        const match = dateString.match(regex);
        if (!match) return false;

        const day = parseInt(match[1], 10);
        const month = parseInt(match[2], 10) - 1;  // Bulan dimulai dari 0
        const year = parseInt(match[3], 10);
        const hour = parseInt(match[4], 10);
        const minute = parseInt(match[5], 10);

        const date = new Date(year, month, day, hour, minute);

        return date.getDate() === day && date.getMonth() === month && date.getFullYear() === year
            && date.getHours() === hour && date.getMinutes() === minute;
    }

    // Fungsi untuk mengonversi tanggal ke timestamp
    function convertToTimestamp(dateString) {
        const regex = /^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/;
        const match = dateString.match(regex);
        if (!match) return null;

        const day = match[1];
        const month = match[2] - 1;  // Bulan dimulai dari 0
        const year = match[3];
        const hour = match[4];
        const minute = match[5];

        const date = new Date(year, month, day, hour, minute);

        if (date.getDate() !== parseInt(day, 10) || date.getMonth() !== month || date.getFullYear() !== parseInt(year, 10)) {
            return null;
        }

        // Format: yyyy-mm-dd hh:mm:00
        return `${year}-${('0' + (month + 1)).slice(-2)}-${('0' + day).slice(-2)} ${('0' + hour).slice(-2)}:${('0' + minute).slice(-2)}:00`;
    }


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





