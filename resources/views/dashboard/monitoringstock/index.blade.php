@extends('template.dashboard')

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Monitoring Stock</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-1 legend-item">
            <div class="legend-color color-red"></div>
            <span class="legend-text">URGENT</span>
        </div>
        <div class="col-md-1 legend-item">
            <div class="legend-color color-orange"></div>
            <span class="legend-text">KRITIS</span>
        </div>
        <div class="col-md-1 legend-item">
            <div class="legend-color color-green"></div>
            <span class="legend-text">AMAN</span>
        </div>
        <div class="col-12">
            <h3>Manage Backup Critical Hardware</h3>
            <div class="hardware-container">
                @foreach($hardware as $spesifikasi => $group)
                    <div class="box">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="border title blue">
                                        {{ $spesifikasi }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border col-value col3-value 
                                        {{ $hardwareCounts[$spesifikasi] > 5 ? 'green' : ($hardwareCounts[$spesifikasi] <= 0 ? 'red' : 'orange') }}">
                                        {{ $hardwareCounts[$spesifikasi] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

            <hr>

            <h3>Manage Request Consumable IT</h3>
            <div class="consumables-container">
                @foreach($consumables as $spesifikasi => $group)
                    <div class="box">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="border title blue">
                                        {{ $spesifikasi }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border col-value col3-value 
                                        {{ $consumablesCounts[$spesifikasi] > 5 ? 'green' : ($consumablesCounts[$spesifikasi] <= 0 ? 'red' : 'orange') }}">
                                        {{ $consumablesCounts[$spesifikasi] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* Style yang sudah ada */
    .table {
        width: 100%;
        table-layout: fixed;
    }

    .hardware-container, .consumables-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .box {
        width: 20%;  /* Each box takes up 20% of the width, adjust as needed */
        padding: 5px;
    }

    .border {
        border: 1px solid #ddd;
        text-align: center;
        padding: 5px;
    }

    .title {
        font-weight: bold;
    }

    .col-value {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .red {
        background-color: #F44336;
        color: #383838;
    }

    .orange {
        background-color: #FF9800;  /* Oranye */
        color: #383838;
    }

    .green {
        background-color: #4CAF50;
        color: #383838;
    }

    .blue {
        background-color: #2196F3;  /* Biru */
        color: white;               /* Teks berwarna putih */
        border: 2px solid blue;     /* Border berwarna biru */
    }

    .rowspan-cell {
        vertical-align: middle;
    }

    /* Style tambahan untuk legend */
    .legend-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    .legend-text {
        font-size: 14px;
        font-weight: bold;
        color: #383838;
    }

    /* Kelas warna untuk legend */
    .color-red {
        background-color: #F44336;  /* Merah */
        color: #383838;
    }

    .color-orange {
        background-color: #FF9800;  /* Oranye */
        color: #383838;
    }

    .color-green {
        background-color: #4CAF50;  /* Hijau */
        color: #383838;
    }

    .color-blue {
        background-color: #2196F3;  /* Biru */
        color: white;
        border: 2px solid blue;
    }

    /* Jika diperlukan, kelas tambahan bisa ditambahkan disini */
</style>
@endsection
