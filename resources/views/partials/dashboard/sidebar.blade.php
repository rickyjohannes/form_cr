<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('logo/icon.png') }}" alt="DPM Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">PT Dharma Polimetal</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                  Dashboard
              </p>
            </a>
        </li>
          
        <!-- Form Memo (Proposal) -->
        <li class="nav-item">
            <a href="{{ route('proposal.index') }}" class="nav-link @if(request()->routeIs('proposal.*')) active @endif">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Form Request
                </p>
            </a>
        </li>

        <!-- Management Account (Only visible to IT) -->
        @if(auth()->check() && in_array(auth()->user()->role->name, ['it']))
        <li class="nav-item">
            <a href="{{ route('account.index') }}" class="nav-link @if(request()->routeIs('account.*')) active @endif">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>
                    Accounts
                </p>
            </a>
        </li>
        @endif
        
        <!-- Monitoring Chart PO (Only visible to IT) -->
        @if(auth()->check() && in_array(auth()->user()->role->name, ['it']))
        <li class="nav-item">
            <a href="{{ route('monitoringchartpo.index') }}" class="nav-link @if(request()->routeIs('monitoringpo.*')) active @endif">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                    Monitoring PR & PO
                </p>
            </a>
        </li>
        @endif

        <!-- Monitoring PO (Only visible to IT)
        @if(auth()->check() && in_array(auth()->user()->role->name, ['it']))
        <li class="nav-item">
            <a href="{{ route('monitoringpo.index') }}" class="nav-link @if(request()->routeIs('monitoringpo.*')) active @endif">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>
                    Monitoring PO
                </p>
            </a>
        </li>
        @endif -->

        <!-- Monitoring Stock Index Data(Only visible to IT) -->
        @if(auth()->check() && in_array(auth()->user()->role->name, ['it']))
        <li class="nav-item">
            <a href="{{ route('indexData.index') }}" class="nav-link @if(request()->routeIs('monitoringstock.*')) active @endif">
                <i class="nav-icon fas fa-database"></i>
                <p>
                    Monitoring Stock Data
                </p>
            </a>
        </li>
        @endif

        <!-- Monitoring Stock (Only visible to IT) -->
        @if(auth()->check() && in_array(auth()->user()->role->name, ['it']))
        <li class="nav-item">
            <a href="{{ route('monitoringstock.index') }}" class="nav-link @if(request()->routeIs('monitoringstock.*')) active @endif">
                <i class="nav-icon fas fa-store"></i>
                <p>
                    Monitoring Stock
                </p>
            </a>
        </li>
        @endif

        <!-- Monitoring transaksi (Only visible to IT) -->
        @if(auth()->check() && in_array(auth()->user()->role->name, ['it']))
        <li class="nav-item">
            <a href="{{ route('monitoringstock.transaksi') }}" class="nav-link @if(request()->routeIs('monitoringstock.*')) active @endif">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Transaksi Scan
                </p>
            </a>
        </li>
        @endif


      </ul>
    </nav>
  </div>
</aside>
