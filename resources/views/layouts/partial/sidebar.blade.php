<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            {{-- ADMINISTRATOR --}}
            @if (Auth::check() && Auth::user()->role == '1')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>
                    <div class="sidenav-menu-heading">Pengaturan</div>
                    <a class="nav-link" href="{{ route('kota.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kabupaten/Kota
                    </a>
                    <a class="nav-link" href="{{ route('kecamatan.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kecamatan
                    </a>
                    <a class="nav-link" href="{{ route('periode.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Periode
                    </a>
                    <div class="sidenav-menu-heading">Data Sekolah</div>
                    <a class="nav-link" href="{{ route('sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Sekolah
                    </a>
                    <div class="sidenav-menu-heading">Pengguna</div>
                    <a class="nav-link" href="{{ route('operator-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Operator Sekolah
                    </a>
                    <a class="nav-link" href="{{ route('manajemen-user.index') }}">
                        <div class="nav-link-icon"><i data-feather="filter"></i></div>
                        Verifikator & Kabalai
                    </a>
                </div>
            @endif
            {{-- OPERATOR SEKOLAH --}}
            @if (Auth::check() && Auth::user()->role == '3')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>

                    <div class="sidenav-menu-heading">DATA SEKOLAH</div>

                    <a class="nav-link" href="{{ route('operator-input.store') }}">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Data Umum & TIK
                    </a>

                    <div class="sidenav-menu-heading">DATA GURU</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Data Guru
                    </a>


                </div>
            @endif
            {{-- VERIFIKATOR --}}
            @if (Auth::check() && Auth::user()->role == '2')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>
                    <div class="sidenav-menu-heading">Pengaturan</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kabupaten/Kota
                    </a>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kecamatan
                    </a>
                    <div class="sidenav-menu-heading">Data Sekolah</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Sekolah
                    </a>
                    <div class="sidenav-menu-heading">Pengguna</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Operator Sekolah
                    </a>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="filter"></i></div>
                        Verifikator
                    </a>
                </div>
            @endif
            {{-- KEPALA BTKI --}}
            @if (Auth::check() && Auth::user()->role == '4')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>
                    <div class="sidenav-menu-heading">Pengaturan</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kabupaten/Kota
                    </a>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kecamatan
                    </a>
                    <div class="sidenav-menu-heading">Data Sekolah</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Sekolah
                    </a>
                    <div class="sidenav-menu-heading">Pengguna</div>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Operator Sekolah
                    </a>
                    <a class="nav-link" href="#">
                        <div class="nav-link-icon"><i data-feather="filter"></i></div>
                        Verifikator
                    </a>
                </div>
            @endif

        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Login Sebagai:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </nav>
</div>
