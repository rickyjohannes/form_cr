@extends('template.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Monitoring Stock</div>

                <div class="card-body">
                    <!-- Menampilkan pesan error jika ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('monitoringstock.update', $monitoringstock->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="type_barang" class="form-label">Type Barang</label>
                            <input type="text" class="form-control" id="type_barang" name="type_barang" value="{{ old('type_barang', $monitoringstock->type_barang) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="spesifikasi_barang" class="form-label">Spesifikasi Barang</label>
                            <input type="text" class="form-control" id="spesifikasi_barang" name="spesifikasi_barang" value="{{ old('spesifikasi_barang', $monitoringstock->spesifikasi_barang) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode" value="{{ old('barcode', $monitoringstock->barcode) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status_transaksi" class="form-label">Status Transaksi</label>
                            <select class="form-select" id="status_transaksi" name="status_transaksi" required>
                                <option value="0" {{ $monitoringstock->status_transaksi == 0 ? 'selected' : '' }}>Stock Available!</option>
                                <option value="1" {{ $monitoringstock->status_transaksi == 1 ? 'selected' : '' }}>Stock Finished</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required>{{ old('keterangan', $monitoringstock->keterangan) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="created_at" class="form-label">Tanggal Masuk</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="{{ old('created_at', $monitoringstock->created_at ? $monitoringstock->created_at->format('Y-m-d\TH:i') : '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="updated_at" class="form-label">Tanggal Keluar</label>
                            <input type="datetime-local" class="form-control" id="updated_at" name="updated_at" value="{{ old('updated_at', $monitoringstock->updated_at ? $monitoringstock->updated_at->format('Y-m-d\TH:i') : '') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('indexData.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
