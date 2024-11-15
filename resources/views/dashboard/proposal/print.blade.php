<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Form Request</title>
    <style>
        /* Pengaturan ukuran halaman A4 */
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            line-height: 1.4; /* Mengurangi jarak antar baris */
            color: #333;
            font-size: 0.9em; /* Memperkecil ukuran font */
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 10px; /* Mengurangi padding di container */
            background-color: #fff;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 15px; /* Mengurangi margin bawah header */
            padding-bottom: 5px; /* Mengurangi padding bawah */
            border-bottom: 1px solid #eee;
        }

        .header h1 {
            font-size: 1.4em; /* Menyesuaikan ukuran font header */
            color: #333;
            margin: 0;
        }

        .content {
            margin-bottom: 10px; /* Mengurangi jarak antar konten */
        }

        .content h2 {
            margin-top: 0;
            margin-bottom: 3px; /* Mengurangi jarak antara judul dan konten */
            font-size: 1em; /* Menyesuaikan ukuran font judul */
            font-weight: bold;
            color: #444;
        }

        .content p {
            margin: 0;
            font-size: 0.9em; /* Memperkecil ukuran font isi */
            color: #555;
        }

        /* Signature Section */
        .signature-section-wrapper {
            display: flex; /* Menggunakan flexbox agar dua signature sejajar */
            justify-content: space-between; /* Membuat jarak antar kolom signature */
            gap: 40px; /* Jarak antar kolom signature */
            margin-top: 30px;
        }

        .signature {
            flex: 1; /* Membuat kedua signature memiliki lebar yang sama */
            text-align: center;
            margin-top: 20px;
        }

        .signature p {
            margin: 0;
            font-size: 0.9em;
            color: #555;
        }

        .signature .name {
            margin-top: 10px;
            font-weight: bold;
            font-size: 1em;
        }

        .signature p:last-child {
            margin-top: 5px;
            font-style: italic;
        }

        .signature-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 5px;
        }

        .signature-image img {
            max-width: 80px; /* Memperkecil lebar gambar tanda tangan */
            height: auto;
            margin-bottom: 5px; /* Mengurangi jarak antara gambar dan teks Signed */
        }

        .notes-section {
            margin-top: 15px;
        }

        .notes-section h2 {
            font-size: 1em;
            margin-bottom: 5px; /* Mengurangi jarak antara judul dan konten */
        }

        .notes-section p {
            font-size: 0.9em;
            color: #555;
            font-style: italic;
        }

        /* Mengatur tampilan saat dicetak (print) */
        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                box-sizing: border-box;
                margin-top: 10px;
            }

            .header h1 {
                font-size: 1.3em;
            }

            .signature-section-wrapper {
                margin-top: 20px; /* Menurunkan jarak antara konten dan tanda tangan */
            }

            .signature {
                width: 48%;
                text-align: center;
                margin-top: 15px; /* Menurunkan margin pada bagian tanda tangan */
            }

            .content h2 {
                font-size: 0.9em;
            }

            .content p {
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Form Request PT. Dharma Polimetal Tbk</h1>
        </div>

        <!-- No CR -->
        <div class="content">
            <h2>No CR</h2>
            <p>{{ $proposal->no_transaksi }}</p>
        </div>

        <!-- User Request -->
        <div class="content">
            <h2>User Request</h2>
            <p>{{ $proposal->user_request }}</p>
        </div>

        <!-- Position -->
        <div class="content">
            <h2>Position</h2>
            <p>{{ $proposal->user_status }}</p>
        </div>

        <!-- Department -->
        <div class="content">
            <h2>Department</h2>
            <p>{{ $proposal->departement }}</p>
        </div>

        <!-- No Handphone -->
        <div class="content">
            <h2>No Handphone</h2>
            <p>{{ $proposal->ext_phone }}</p>
        </div>

        <!-- Jenis Permintaan -->
        <div class="content">
            <h2>Jenis Permintaan</h2>
            <p>{{ $proposal->status_barang }}</p>
        </div>

        <!-- Kategori -->
        <div class="content">
            <h2>Kategori</h2>
            <p>{{ $proposal->kategori }}</p>
        </div>

        <!-- Facility -->
        <div class="content">
            <h2>Facility</h2>
            <p>{{ $proposal->facility }}</p>
        </div>

        <!-- User Notes -->
        <div class="notes-section">
            <h2>Notes :</h2>
            <p>{{ $proposal->user_note }}</p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section-wrapper">
            <!-- Signature Section dh -->
            <div class="signature">
                <p>Approved Dept Head By:</p>
                <p class="name">
                    @php
                        // Mengambil pengguna berdasarkan departemen yang sesuai dengan departemen proposal
                        $user = \App\Models\User::where('departement', $proposal->departement)
                                    ->whereHas('role', function ($query) {
                                        $query->where('name', 'dh');
                                    })
                                    ->first();  // Mengambil pengguna pertama yang cocok
                    @endphp

                    @if ($user)
                        {{ $user->name }}

                        @if ($user->signature_image && file_exists(public_path('signatures/' . $user->signature_image)) && in_array(pathinfo($user->signature_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                            <div class="signature-image">
                                <img src="{{ public_path('signatures/' . $user->signature_image) }}" alt="Signature">
                            </div>
                        @else
                            <p style="color: red;">Signature image not available!</p>
                        @endif
                    @else
                        No user found with department {{ $proposal->departement }}.
                    @endif
                </p>
                <p>Signed.</p>
            </div>

            <!-- Signature Section divh -->
            <div class="signature">
                <p>Approved Divisi Head By:</p>
                <p class="name">
                    @php
                        // Mengambil pengguna berdasarkan departemen yang sesuai dengan departemen proposal
                        $user = \App\Models\User::where('departement', $proposal->departement)
                                    ->whereHas('role', function ($query) {
                                        $query->where('name', 'divh');
                                    })
                                    ->first();  // Mengambil pengguna pertama yang cocok
                    @endphp

                    @if ($user)
                        {{ $user->name }}

                        @if ($user->signature_image && file_exists(public_path('signatures/' . $user->signature_image)) && in_array(pathinfo($user->signature_image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                            <div class="signature-image">
                                <img src="{{ public_path('signatures/' . $user->signature_image) }}" alt="Signature">
                            </div>
                        @else
                            <p style="color: red;">Signature image not available!</p>
                        @endif
                    @else
                        No user found with department {{ $proposal->departement }}.
                    @endif
                </p>
                <p>Signed.</p>
            </div>
        </div>
    </div>

</body>
</html>
