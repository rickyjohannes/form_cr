@extends('template.dashboard')

@section('breadcrumbs')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Account</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Account</li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit Account</h3>
                        </div>
                        <form action="{{ route('account.updateUser', $account->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <!-- NPK -->
                                <div class="form-group">
                                    <label for="npk">NPK</label>
                                    <input type="text" class="form-control @error('npk') is-invalid @enderror"
                                        name="npk" id="npk" value="{{ $account->npk }}"
                                        placeholder="ex: 12345678">
                                    @error('npk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ $account->name }}"
                                        placeholder="ex: Jana Dev">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Username -->
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" id="username" value="{{ $account->username }}"
                                        placeholder="ex: janadev">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ $account->email }}"
                                        placeholder="ex: janadev@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Departement -->
                                <div class="form-group">
                                    <label for="departement">Departement</label>
                                    <input type="text" class="form-control" value="{{ $account->departement ?? 'Tidak ada departement' }}" readonly>
                                    <input type="hidden" name="departement" value="{{ $account->departement }}">
                                </div>
                     
                                <!-- Position -->
                                <div class="form-group">
                                    <label for="user_status">Position</label>
                                    <input type="text" class="form-control @error('user_status') is-invalid @enderror"
                                        name="user_status" id="user_status" value="{{ $account->user_status }}"
                                        placeholder="ex: SectionHead,DeptHead,DivisiHead,Other...">
                                    @error('user_status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Ext Phone -->
                                <div class="form-group">
                                    <label for="ext_phone">Phone</label>
                                    <input type="text" class="form-control @error('ext_phone') is-invalid @enderror"
                                        name="ext_phone" id="ext_phone" value="{{ $account->ext_phone }}"
                                        placeholder="ex: 0813554544447">
                                    @error('ext_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <input type="text" class="form-control" value="{{ $account->role->name ?? 'Tidak ada role' }}" readonly>
                                    <input type="hidden" name="role_id" value="{{ $account->role_id }}">
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Enter Password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div class="form-group">
                                    <label for="password">Retype Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password"
                                        placeholder="Enter Password Again">
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<!-- Menambahkan CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Menambahkan JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize Select2 with the option to type in new departments -->
<script>
    $(document).ready(function() {
        $('#departement').select2({
            tags: true,  // Allows users to type their own options (not in the select)
            tokenSeparators: [',', ' '],  // Allows comma and space to separate items
            placeholder: "Select or type a department",  // Placeholder text
            width: '100%'  // Ensure full width
        });
    });
</script>
@endsection
