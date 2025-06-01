<ul class="navbar-nav sidebar sidebar-night accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('../assets/logo-cekmeter.png') }}" alt="cek-meter" width="100%">
        </div>
        <div class="sidebar-brand-text mt-3">
            <h3 style="font-size: 15px; margin-bottom: 0; font-weight: bold;">Cek Meter</h3>
            <p style="font-size: 12px; margin-top: 0;">PUDAM Banyuwangi</p>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(Request::is('dashboard')) active @endif">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Log Data -->
    <li class="nav-item @if(Route::is('logdata.index')) active @endif">
        <a class="nav-link" href="{{ route('logdata.index') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Log Data</span>
        </a>
    </li>

    <!-- Nav Item - Data Pelanggan -->
    <li class="nav-item @if(Route::is('pelanggan.index')) active @endif">
        <a class="nav-link" href="{{ route('pelanggan.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span>
        </a>
    </li>

    <!-- Nav Item - Data Merk Meter -->
    <li class="nav-item @if(Route::is('alatmeter.index')) active @endif">
        <a class="nav-link" href="{{ route('alatmeter.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Alat Meter</span>
        </a>
    </li>

    <!-- Nav Item - Data Staff -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user"></i>
            <span>Staf Lapangan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white collapse-inner rounded">
                <a class="collapse-item" href="{{ route('staflapangan.rekap') }}">Rekap Staf</a>
                <a class="collapse-item" href="{{ route('staflapangan.index') }}">Akun Staf</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
