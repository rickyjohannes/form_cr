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
            color: #4CAF50;
            margin-bottom: 20px;
        }
        p {
            margin: 10px 0;
            color: #555;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
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
        <h1>Approval CR Divisi Head: Success</h1>
        <p>No Transaksi: {{ $proposalNo_transaksi }}</p>
        <p>User Request: {{ $proposalUserRequest }}</p>
        <p>Departement: {{ $proposalDepartement }}</p>
        <p>No Handphone: {{ $proposalNoHandphone }}</p>
        <p>Status Barang: {{ $proposalStatusBarang }}</p>
        <p>Facility: {{ $proposalFacility }}</p>
        <p>User Note: {{ $proposalUserNote }}</p>

        <!-- Button to redirect to proposal.index -->
        <a href="{{ route('proposal.index') }}" class="btn">Go to Login Page</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var proposalNo_transaksi = '{{ $proposalNo_transaksi }}'; // Ambil No Transaksi
            var proposalUserRequest = '{{ $proposalUserRequest }}';
            var proposalDepartement = '{{ $proposalDepartement }}';
            var proposalNoHandphone = '{{ $proposalNoHandphone }}';
            var proposalStatusBarang = '{{ $proposalStatusBarang }}';
            var proposalFacility = '{{ $proposalFacility }}';
            var proposalUserNote = '{{ $proposalUserNote }}';

            $.ajax({
                url: '/proposal/' + proposalId + '/approveDIVH/' + proposalToken, // Gunakan ID dan token
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
