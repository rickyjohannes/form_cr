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
            <input type="text" name="spesifikasi_barang" id="spesifikasi_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode" id="barcode" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection
