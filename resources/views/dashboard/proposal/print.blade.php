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
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        .header h1 {
            font-size: 1.2em;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Form Request PT. Dharma Polimetal Tbk</h1>
            <div class="po-info">
                <p><strong>No CR:</strong> {{ $proposal->no_transaksi }}</p>
                <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($proposal->created_at)->format('d-m-Y') }}</p>
            </div>
        </div>

        <table class="info-table">
            <tr>
                <th>User Request</th>
                <td>{{ $proposal->user_request }}</td>
                <th>Position</th>
                <td>{{ $proposal->user_status }}</td>
                <th>Department</th>
                <td>{{ $proposal->departement }}</td>
                <th>No Handphone</th>
                <td>{{ $proposal->ext_phone }}</td>
            </tr>
            <tr>
                <th>Jenis Permintaan</th>
                <td>{{ $proposal->status_barang }}</td>
                <th>Kategori</th>
                <td>{{ $proposal->kategori }}</td>
                <th>Facility</th>
                <td>{{ $proposal->facility }}</td>
                <th>User Note</th>
                <td>{{ $proposal->user_note }}</td>
                
            </tr>
            <tr>
                <th>Request Completion Date</th>
                <td>{{ \Carbon\Carbon::parse($proposal->estimated_date)->format('d-m-Y | H:i:s') }}</td>
                <th></th>
                <td></td>
                <th></th>
                <td></td>
                <th></th>
                <td></td>
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
