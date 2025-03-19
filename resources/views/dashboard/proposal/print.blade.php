<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Form Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 0.9em;
            color: #333;
            margin: 0;
            padding: 10px;
            background-color: #fff;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: auto;
            padding: 10px;
            border: 1px solid #000;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding: 10px;
            position: relative;
        }

        .header h1 {
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
            margin: 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table th, .info-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .my-table td {
            font-size: 10px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature {
            text-align: center;
            width: 45%;
        }

        .signature img {
            width: 100px;
            height: auto;
        }

        .print-date {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 0.8em;
            font-style: italic;
            color: #555;
        }

        .qr-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: absolute;
            right: 10px; /* Sesuaikan posisi dari kanan */
            top: 1px; /* Atur posisi dari atas */
        }

        .qr-code {
            width: 80px;
            height: auto;
            margin-bottom: 0px; /* Tambahkan sedikit jarak ke teks di bawah */
        }

        .no-cr {
            font-size: 10px;
            text-align: center;
            margin-top: 0px; /* Hapus margin tambahan agar lebih dekat */
            background: white;
            padding: 2px 4px;
            border-radius: 2px;
            display: block;
            font-weight: bold;
            line-height: 1; /* Pastikan tidak ada ruang tambahan di dalam teks */
        }

    </style>
</head>
<body>
        <div class="container">
            <div class="header">
                <img src="{{ public_path('logo/LogoDPM_1.png') }}" alt="logo" style="width: 200px; height: auto;">
                <h1>Form Request IT</h1>
                
                <div class="qr-container">
                    <img class="qr-code" src="data:image/png;base64,{{ $noTranskasi }}" alt="QR Code">
                    <span class="no-cr">{{ $proposal->no_transaksi }}</span>
                </div>
                <br/>
            </div>
            <div class="po-info">
                <p><strong>No CR:</strong> {{ $proposal->no_transaksi }}</p>
                <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y') }}</p>
            </div>

        <table class="info-table">
            <tr>
                <th>Company Code</th>
                <td>
                    @if ($proposal->company_code == '1101') 1101 - DPM Cikarang 1
                    @elseif ($proposal->company_code == '1100') 1100 - PT. Dharma Polimetal Tbk
                    @elseif ($proposal->company_code == '1200') 1200 - PT. Dharma Poliplast
                    @elseif ($proposal->company_code == '1300') 1300 - PT. Dharma Precision Part
                    @elseif ($proposal->company_code == '1400') 1400 - PT. Dharma Precision Tools
                    @elseif ($proposal->company_code == '1500') 1500 - PT. Dharma Electrindo Manufacturing
                    @elseif ($proposal->company_code == '1600') 1600 - PT .Dharma Control Cable
                    @elseif ($proposal->company_code == '1700') 1700 - PT. Trimitra Chitrahasta
                    @else - 
                    @endif
                </td>
            </tr>
            <tr>
                <th>User Request</th>
                <td>{{ $proposal->user_request }}</td>
            </tr>
            <tr>
                <th>Position</th>
                <td>{{ $proposal->user_status }}</td>
            </tr>
            <tr>
                <th>Department</th>
                <td>{{ $proposal->departement }}</td>
            </tr>
            <tr>
                <th>No Handphone</th>
                <td>{{ $proposal->ext_phone }}</td>
            </tr>
            <tr>
                <th>Jenis Permintaan</th>
                <td>{{ $proposal->status_barang }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $proposal->kategori }}</td>
            </tr>
            <tr>
                <th>Facility</th>
                <td>{{ $proposal->facility }}</td>
            </tr>
            <tr>
                <th>User Note</th>
                <td>
                    @if (!empty($proposal->user_note))
                        @php
                            // Tambahkan baris baru setelah ": " (titik dua diikuti spasi) dengan hanya satu <br>
                            $formattedNote = preg_replace('/:\s/', ":<br>", $proposal->user_note);
                            // Mengonversi newline menjadi <br> agar terlihat di HTML
                            $cleanedNote = nl2br($formattedNote);
                        @endphp
                        {!! $cleanedNote !!}
                    @else
                        <textarea class="form-control" rows="5" readonly>User Note not available...</textarea>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Request Completion Date</th>
                <td>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</td>
            </tr>
        </table>

        <div class="signature-section">
            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">Disetujui oleh</th>
                    <th style="border: 1px solid black; padding: 8px;">Disetujui Oleh</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        <p style="font-weight: bold;">SIGNED</p>
                        <img src="data:image/png;base64,{{ $qrCodeDH }}" alt="QR Code" style="width: 80px; height: auto;">
                        <p style="margin: 5px 0;">{{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y | H:i:s') }}</p>
                        <p style="margin: 5px 0;">{{ $departmentHead->name }}</p>
                    </td>
                    <td style="border: 1px solid black; padding: 10px;">
                        <p style="font-weight: bold;">SIGNED</p>
                        <img src="data:image/png;base64,{{ $qrCodeDIVH }}" alt="QR Code" style="width: 80px; height: auto;">
                        <p style="margin: 5px 0;">{{ \Carbon\Carbon::parse($proposal->actiondate_apr)->format('d-m-Y | H:i:s') }}</p>
                        <p style="margin: 5px 0;">{{ $divisionHead->name }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">DEPARTEMENT HEAD</td>
                    <td style="border: 1px solid black; padding: 8px;">DIVISION HEAD</td>
                </tr>
            </table>
        </div>

        <div class="print-date">
          <p><strong>Tanggal Print:</strong> {{ date('d-m-Y h:i:s A') }}</p>
        </div>
</body>
</html>
