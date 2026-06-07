<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <!-- Sidenav Brand -->
        <div class="sidenav-brand d-flex align-items-center pt-1 pb-3 px-4 border-bottom">
            <a href="{{ route('homepage') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('images/logo/logo_pemprov.png') }}" alt="Logo EMONEV" style="width: 32px; height: 32px; object-fit: contain;" class="me-2">
                <span class="fs-4 fw-bold" style="letter-spacing: 0.5px; font-family: 'Inter', sans-serif;">EMONEV</span>
            </a>
        </div>
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

                    <div class="sidenav-menu-heading">Pengguna</div>
                    <a class="nav-link" href="{{ route('operator-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                        Operator Sekolah
                    </a>
                    <a class="nav-link" href="{{ route('manajemen-user.index') }}">
                        <div class="nav-link-icon"><i data-feather="filter"></i></div>
                        Verifikator & Kabalai
                    </a>
                    <a class="nav-link" href="{{ route('guru-mandiri.index') }}">
                        <div class="nav-link-icon"><i data-feather="users"></i></div>
                        Guru
                    </a>
                </div>
            @endif
            {{-- OPERATOR SEKOLAH --}}
            @if (Auth::check() && Auth::user()->role == '3')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('operator.dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>

                    <div class="sidenav-menu-heading">DATA SEKOLAH</div>

                    <a class="nav-link" href="{{ route('identitas-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="info"></i></div>
                        Identitas
                    </a>
                    <a class="nav-link" href="{{ route('sosekbud-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="aperture"></i></div>
                        Sosekbud
                    </a>
                    <a class="nav-link" href="{{ route('bantuan-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="airplay"></i></div>
                        Bantuan
                    </a>
                    <a class="nav-link" href="{{ route('fasilitas-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="battery-charging"></i></div>
                        Listrik dan Internet
                    </a>
                    <a class="nav-link" href="{{ route('data-guru.index') }}">
                        <div class="nav-link-icon"><i data-feather="users"></i></div>
                        Data Guru
                    </a>


                </div>
            @endif
            {{-- GURU --}}
            @if (Auth::check() && Auth::user()->role == '5')
                <div class="nav accordion" id="accordionSidenav">
                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('guru.dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>
                    <div class="sidenav-menu-heading">Manajemen Profil</div>
                    <a class="nav-link" href="{{ route('guru.profil.edit') }}">
                        <div class="nav-link-icon"><i data-feather="user"></i></div>
                        Profil &amp; Kompetensi TIK
                    </a>
                </div>
            @endif
            {{-- VERIFIKATOR --}}
            @if (Auth::check() && Auth::user()->role == '2')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('verifikator.dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('verifikasi-guru.index') }}">
                        <div class="nav-link-icon"><i data-feather="check"></i></div>
                        Verifikasi Data Guru
                    </a>
                    <a class="nav-link" href="{{ route('verifikasi-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="check"></i></div>
                        Verifikasi Data Sekolah
                    </a>
                    <a class="nav-link" href="{{ route('verifikasi-sekolah.index') }}">
                        <div class="nav-link-icon"><i data-feather="edit"></i></div>
                        Monev Data Sekolah
                    </a>
                    <a class="nav-link" href="{{ route('monitoring-guru.index') }}">
                        <div class="nav-link-icon"><i data-feather="edit"></i></div>
                        Monev Data Guru
                    </a>
                </div>
            @endif
            {{-- KEPALA BTKI --}}
            @if (Auth::check() && Auth::user()->role == '4')
                <div class="nav accordion" id="accordionSidenav">


                    <div class="sidenav-menu-heading"></div>
                    <a class="nav-link" href="{{ route('kabalai.dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Dashboard
                    </a>
                    <div class="sidenav-menu-heading">Data Statistik Guru</div>
                    <a class="nav-link" href="{{ route('sortgurupendidikan.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Pendidikan
                    </a>
                    <a class="nav-link" href="{{ route('sortgurustatus.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Status
                    </a>
                    <a class="nav-link" href="{{ route('sortgurusertifikasi.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Sertifikasi
                    </a>
                    <a class="nav-link" href="{{ route('sortgurupelatihan.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Kebutuhan Pelatihan
                    </a>

                    





                    <div class="sidenav-menu-heading">Data Statistik Sekolah</div>
                    <a class="nav-link" href="{{ route('sekolah.sort.akreditasi') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Akreditasi
                    </a>
                    <a class="nav-link" href="{{ route('sekolah.sort.bantuan') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Bantuan
                    </a>
                    <a class="nav-link" href="{{ route('sekolah.sort.labkomputer') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Lab Komputer
                    </a>
                    <a class="nav-link" href="{{ route('internet.sort') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Internet
                    </a>
                    <a class="nav-link" href="{{ route('listrik.index') }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Listrik
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
