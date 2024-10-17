@extends('template.dashboard')

@section('breadcrumbs')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>404 | DPM</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Dashboard</li>
                <li class="breadcrumb-item active">404</li>
                </ol>
            </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 404 | DPM</h2>
            <br>
        </div>
        <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
        <p>Kami tidak dapat menemukan halaman yang Anda cari.
        Sementara itu, Anda mungkin bisa kembali Login<a href="{{ route('dashboard') }}"><b>Klik Disini.</b></a>.
        </p>
        </div>

  </section>
@endsection