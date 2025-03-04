<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('home') }}" class="nav-link">Home</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <!-- User Profile -->
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{ asset('template/dashboard/dist/img/avatar5.png') }}" class="user-image img-circle elevation-2" alt="User Image">
        <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Guest' }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <!-- User image -->
        <li class="user-header bg-primary">
          <img src="{{ asset('template/dashboard/dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
          <p>
            {{ auth()->user()->name ?? 'Guest' }} 
            <small>{{ auth()->user()->npk ?? 'Guest' }}</small>
            <small>{{ auth()->user()->user_status ?? 'Guest' }}</small>
            <small>{{ auth()->user()->role->name ?? 'Visitor' }}</small>
          </p>
        </li>
      </ul>
    </li>
  </ul>
  
  <!-- Menu Footer -->
  @if(auth()->check())
      <li class="user-footer d-flex justify-content-between p-2 border-top">
          <a href="{{ route('account.editUser', auth()->user()->id) }}" class="btn btn-primary btn-sm text-white">
              <i class="fas fa-user-edit"></i> Edit Account
          </a>
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf 
              <button type="submit" class="btn btn-danger btn-sm">
                  <i class="fas fa-sign-out-alt"></i> Logout
              </button>
          </form>
      </li>
  @else
      <li class="user-footer d-flex justify-content-center p-2 border-top">
          <a href="{{ route('login') }}" class="btn btn-success btn-sm text-white">
              <i class="fas fa-sign-in-alt"></i> Login
          </a>
      </li>
  @endif


</nav>
