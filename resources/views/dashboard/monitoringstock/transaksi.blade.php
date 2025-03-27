@extends('template.dashboard')

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Scan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi Scan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container mt-4">

    <!-- Menampilkan Pesan Error jika ada -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Menampilkan Pesan Sukses setelah Transaksi berhasil -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>Transaksi Scan</h3>
    <form action="{{ route('monitoringstock.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="type_barang">Type Barang:</label>
            <select name="type_barang" id="type_barang" class="form-control" required>
                <option value="HARDWARE">HARDWARE</option>
                <option value="CONSUMABLE">CONSUMABLE</option>
            </select>
        </div>
        <div class="form-group">
            <label for="spesifikasi_barang">Spesifikasi Barang:</label>
            <select name="spesifikasi_barang" id="spesifikasi_barang" class="form-control" required>
                <!-- Opsi default yang meminta pengguna untuk memilih spesifikasi barang -->
                <option value="" disabled selected>--Pilih Spesifikasi Barang Dahulu!!!--</option>
                
                @foreach($spesifikasiBarangs as $spesifikasi)
                    <option value="{{ $spesifikasi }}">{{ $spesifikasi }}</option>
                @endforeach

                <!-- Opsi untuk memilih spesifikasi lain -->
                <option value="other">Other (Lainnya)</option>
            </select>
        </div>
        
        <!-- Input manual spesifikasi barang, akan muncul hanya jika memilih "Other" -->
        <div class="form-group" id="other_spesifikasi" style="display: none;">
            <label for="other_spesifikasi_barang">Spesifikasi Barang Lainnya:</label>
            <input type="text" name="other_spesifikasi_barang" id="other_spesifikasi_barang" class="form-control">
        </div>

        <div class="form-group">
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode" id="barcode" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection

@section('script')
<!-- Menambahkan CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Menambahkan JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen dropdown
        $('#spesifikasi_barang').select2({
            allowClear: true  // Menambahkan tombol clear untuk menghapus pilihan
        });

        // Menangani perubahan pilihan pada dropdown spesifikasi barang
        $('#spesifikasi_barang').change(function() {
            // Jika memilih "Other", tampilkan input teks untuk spesifikasi barang lainnya
            if ($(this).val() === 'other') {
                $('#other_spesifikasi').show();  // Menampilkan input manual
            } else {
                $('#other_spesifikasi').hide();  // Menyembunyikan input manual
                $('#other_spesifikasi_barang').val('');  // Kosongkan input teks jika memilih opsi lain
            }
        });
    });

</script>
@endsection

