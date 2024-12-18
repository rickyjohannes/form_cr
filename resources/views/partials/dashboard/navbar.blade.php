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
  <!--Menu Footer-->
  <li class="user-footer">
          <!-- <a href="{{ route('profile.index') }}" class="btn btn-default btn-flat">Profile</a>
          <a href="#" class="float-right"> -->
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf 
              <button type="submit" class="btn btn-default btn-flat">Logout</button>
          </form>
          </a>
        </li> 
</nav>
