<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Page</title>
</head>
<body>
    <h1>Approval CR Dept Head : Success</h1>
    <p>ID: {{ $proposalId }}</p>
    <p>No Transaksi: {{ $proposalNo_transaksi }}</p>
    <p>Token: {{ $proposalToken }}</p>

    <!-- Button to redirect to proposal.index -->
    <button id="redirectButton" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Go to Login Page
    </button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var proposalId = '{{ $proposalId }}'; // Ambil ID proposal
            var proposalNo_transaksi = '{{ $proposalNo_transaksi }}'; // Ambil No Transaksi
            var proposalToken = '{{ $proposalToken }}'; // Ambil token proposal

            // Handle button click to redirect to proposal.index
            $('#redirectButton').click(function() {
                window.location.href = '{{ route("proposal.index") }}'; // Redirect to proposal.index
            });

            $.ajax({
                url: '/proposal/' + proposalId + '/approveDH/' + proposalToken, // Gunakan ID dan token
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
