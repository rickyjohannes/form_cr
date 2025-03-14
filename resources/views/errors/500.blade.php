@extends('template.dashboard')

@section('breadcrumbs')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>500</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">500</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 500 | DPM</h2>
        </div>
        <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

        <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="{{ route('dashboard') }}">return to dashboard</a>.
        </p>
        </div>

  </section>
@endsection