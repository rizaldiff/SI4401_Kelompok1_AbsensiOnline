<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Home</div>
            @pegawai
                <a class="nav-link" href="{{ route('index') }}">
                    <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                    Dashboard
                </a>
            @endpegawai
            @admin
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                    Dashboard Admin
                </a>
            @endadmin
            <div class="sb-sidenav-menu-heading">Menu</div>
            <a class="nav-link" href="{{ route('absensiku') }}">
                <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                Data Kehadiran
            </a>
            @admin
                <div class="sb-sidenav-menu-heading">Admin</div>
                <a class="nav-link" href="{{ route('datapegawai') }}">
                    <div class="sb-nav-link-icon"><span class="fas fa-users"></span></div>
                    Data Pegawai
                </a><a class="nav-link" href="{{ route('absensi') }}">
                    <div class="sb-nav-link-icon"><span class="fas fa-user-check"></span></div>
                    Absensi Pegawai
                </a>
                </a><a class="nav-link" href="{{ route('settingapp') }}">
                    <div class="sb-nav-link-icon"><span class="fas fa-cog"></span></div>
                    Settings Aplikasi
                </a>
            @endadmin
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Selamat Datang:</div>
        {{ auth()->user()->nama_lengkap }}
    </div>
</nav>
