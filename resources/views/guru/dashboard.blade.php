@extends('layouts.navbar')
@section('title', 'Dashboard Guru E-Monitoring dan Evaluasi')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Dashboard Guru : {{ Auth::user()->name }}
                            </h1>
                            <div class="page-header-subtitle">Dashboard Guru</div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                                    placeholder="Select date range..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body h-100 p-5">
                            <div class="row align-items-center">
                                <div class="row align-items-center">
                                    <!-- Gambar -->
                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                        <img class="img-fluid"
                                            src="{{ asset('sbadmin/assets/img/illustrations/at-work.svg') }}"
                                            style="max-width: 10rem" alt="Illustration">
                                    </div>

                                    <!-- Teks -->
                                    <div class="col-md-8 text-center text-md-start">
                                        <h1 class="text-primary">Selamat Datang, {{ Auth::user()->name }}!</h1>
                                        <p class="text-gray-700 mb-0">
                                            E-Monitoring dan Evaluasi Fasilitas TIK dan Kompetensi Guru SMA Se-Maluku merupakan aplikasi e-Monitoring dan e-Evaluasi Berbasis
                                            TIK
                                            yang dikembangkan oleh Balai Teknologi Informasi dan Komunikasi (BTIK)
                                            Dinas Pendidikan dan Kebudayaan Provinsi Maluku
                                        </p>
                                        <hr>
                                        <h1 class="text-primary mt-3">
                                            Status Verifikasi Data Guru:
                                            @if (!$hasData)
                                                <span class="badge bg-secondary">Belum Ada Data</span>
                                            @elseif ($statusVerifikasi == 0)
                                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                                            @elseif ($statusVerifikasi == 1)
                                                <span class="badge bg-success text-white">
                                                    <i data-feather="check-circle"></i> Terverifikasi
                                                </span>
                                            @elseif ($statusVerifikasi == 2)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif ($statusVerifikasi == 3)
                                                <span class="badge bg-primary">Revisi</span>
                                            @else
                                                <span class="badge bg-secondary">Belum Ada Data</span>
                                            @endif
                                        </h1>

                                        @if ($catatanVerifikasi)
                                            <div class="alert alert-info mt-3">
                                                <strong>Catatan Verifikasi:</strong> {{ $catatanVerifikasi }}
                                            </div>
                                        @endif

                                        <hr>

                                        @if (!$hasData)
                                            <a href="{{ route('guru-data.create') }}" class="btn btn-primary btn-sm">
                                                <i data-feather="plus-circle"></i> Lengkapi Data Guru
                                            </a>
                                        @else
                                            <a href="{{ route('guru-data.index') }}" class="btn btn-primary btn-sm">
                                                <i data-feather="eye"></i> Lihat Data Guru
                                            </a>
                                            @if ($statusVerifikasi != 1)
                                                <a href="{{ route('guru-data.edit', $guru->id) }}" class="btn btn-warning btn-sm">
                                                    <i data-feather="edit"></i> Edit Data Guru
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
@endsection
