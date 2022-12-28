<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand truncate" href="{{ route('index') }}">{{ config('settings.nama_app_absensi') }}</td>
    </a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button><!-- Navbar Search-->
    <div class="navbar-nav mr-auto">
    </div>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset(auth()->user()->image) }}" alt="Profile Image" width="35" class="rounded mr-2" />
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <h6 class="dropdown-header">
                    <div class="d-inline mr-1">Nama:</div>{{ auth()->user()->nama_lengkap }}
                </h6>
                <h6 class="dropdown-header">
                    <div class="mr-1 d-inline">Jabatan:</div>{{ auth()->user()->jabatan }}
                </h6>
                <h6 class="dropdown-header">
                    <div class="mr-1 d-inline">Kode Pegawai:</div>{{ auth()->user()->kode_pegawai }}
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile') }}"><span class="fas fa-user-tie mr-1"></span>Profil
                    Saya</a>
                <a class="dropdown-item" href="{{ route('setting') }}"><span class="fas fa-cog mr-1"></span>Setelan</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item logout" href="#"><span
                        class="fas fa-fw fa-sign-out-alt mr-2"></span>Logout</a>
            </div>
        </div>
        </li>
    </ul>
</nav>
