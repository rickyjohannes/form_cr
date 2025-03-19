<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #dc3545;
            margin-bottom: 20px;
        }
        p {
            margin: 10px 0;
            color: #555;
        }
        .btn {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Approval CR Divisi Head : Rejected</h1>
        
        <p>No CR: {{ $proposalNo_transaksi }}</p>
        <p>Company Code: {{ $proposalCompanyCode }}</p>
        <p>User Request: {{ $proposalUserRequest }}</p>
        <p>Position: {{ $proposalPosition }}</p>
        <p>Departement: {{ $proposalDepartement }}</p>
        <p>No Handphone: {{ $proposalNoHandphone }}</p>
        <p>Jenis Permintaan: {{ $proposalStatusBarang }}</p>
        <p>Kategori: {{ $proposalKategori }}</p>
        <p>Facility: {{ $proposalFacility }}</p>
        <p>User Note: {{ $proposalUserNote }}</p>
        @if (in_array($proposalStatusBarang, ['Pergantian']))
        <p>No Asset User: {{ $proposalAssetUser }}</p>
        @endif
        <p>Date of Submission:{{ \Carbon\Carbon::parse($proposalCreated)->format('d-m-Y | H:i:s') }}</p>
        @if (in_array($proposalStatusBarang, [ 'Peminjaman']))
        <p>Estimated Start Date:{{ \Carbon\Carbon::parse($proposalEstimatedStartDate)->format('d-m-Y | H:i:s') }}</p>
        @endif
        @if (in_array($proposalStatusBarang, ['Change Request', 'Peminjaman']))
        <p>Request Completion Date:{{ \Carbon\Carbon::parse($proposalEstimatedDate)->format('d-m-Y | H:i:s') }}</p>
        @endif

        <!-- Button to redirect to proposal.index -->
        <a href="{{ route('proposal.index') }}" class="btn">Go to Login Page</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var proposalNo_transaksi = '{{ $proposalNo_transaksi }}'; // Ambil No Transaksi
            var proposalUserRequest = '{{ $proposalUserRequest }}';
            var proposalPosition = '{{ $proposalPosition }}';
            var proposalDepartement = '{{ $proposalDepartement }}';
            var proposalNoHandphone = '{{ $proposalNoHandphone }}';
            var proposalStatusBarang = '{{ $proposalStatusBarang }}';
            var proposalKategori = '{{ $proposalKategori }}';
            var proposalFacility = '{{ $proposalFacility }}';
            var proposalUserNote = '{{ $proposalUserNote }}';
            var proposalAssetUser = '{{ $proposalAssetUser }}';
            var proposalCreated = '{{ $proposalCreated }}';
            var proposalEstimatedStartDate = '{{ $proposalEstimatedStartDate }}';
            var proposalEstimatedDate = '{{ $proposalEstimatedDate }}';

            $.ajax({
                url: '/proposal/' + proposalId + '/rejectDIVH/' + proposalToken, // Gunakan ID dan token
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        alert(response.success); // Menampilkan pesan sukses
                        setTimeout(function() {
                            window.location.href = '/login'; // Ganti dengan URL login Anda
                        }, 5000); // 5 detik
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        alert(xhr.responseJSON.error); // Menampilkan pesan error jika ada
                    }
                }
            });
        });
    </script>
</body>
</html>
