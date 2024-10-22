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

                            @foreach (['user_request' => 'User / Request', 'user_status' => 'User Status', 'ext_phone' => 'Ext / Phone', 'user_note' => 'User Note'] as $field => $label)
                                <div class="form-group">
                                    <label for="{{ $field }}">{{ $label }}</label>
                                    <textarea id="{{ $field }}" class="form-control @error($field) is-invalid @enderror" name="{{ $field }}" rows="3" placeholder="Enter {{ $label }}">{{ old($field) }}</textarea>
                                    @error($field)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach

                            <!-- Departement -->
                            <div class="form-group">
                                <label for="departement">Departement</label>
                                <input type="text" id="departement" class="form-control mt-2" name="departement" value="{{ auth()->user()->departement ?? '' }}" readonly>
                            </div>

                            <!-- Status Barang -->
                            <div class="form-group">
                                <label>Status Barang</label>
                                @foreach (['Pembelian', 'Peminjaman', 'Pengembalian'] as $item)
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

                            <!-- Fasilitas -->
                            <div class="form-group">
                                <label>Fasilitas</label>
                                <div id="facility-container">
                                    <p>Pilih status barang terlebih dahulu untuk melihat fasilitas.</p>
                                </div>
                                @error('facility')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File -->
                            <div class="form-group">
                                <label for="file">File Tambahan User</label>
                                <input type="file" id="file" class="form-control-file @error('file') is-invalid @enderror" name="file">
                                @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusBarangSelect = document.querySelectorAll('input[name="status_barang[]"]');
        const facilityContainer = document.getElementById('facility-container');

        const options = {
            'Pembelian': [
                "Account -> Login",
                "Account -> Email",
                "Account -> Internet",
                "Software -> Install Software",
                "Software -> Change Request",
                "Software -> New Application",
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ],
            'Peminjaman': [
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ],
            'Pengembalian': [
                "Infrastruktur -> PC / TC",
                "Infrastruktur -> Printer / Scanner",
                "Infrastruktur -> Monitor",
                "Infrastruktur -> Keyboard / Mouse",
                "Infrastruktur -> Lan / Telp"
            ]
        };

        statusBarangSelect.forEach(checkbox => {
            checkbox.addEventListener('change', updateFasilitas);
        });

        function updateFasilitas() {
            const selectedValues = Array.from(statusBarangSelect)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            facilityContainer.innerHTML = ''; // Clear previous options
            if (selectedValues.length > 0) {
                selectedValues.forEach(value => {
                    options[value].forEach(facility => {
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
                facilityContainer.innerHTML = '<p>Pilih status barang terlebih dahulu untuk melihat fasilitas.</p>';
            }
        }
    });
</script>
@endsection
