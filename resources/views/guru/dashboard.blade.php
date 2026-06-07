@extends('layouts.navbar')
@section('title', 'Dashboard Guru - EMONEV')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Dashboard Guru : {{ $guru->nama }}
                            </h1>
                            <div class="page-header-subtitle">Asal Sekolah: {{ $sekolah->nama }}</div>
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
                                <!-- Gambar -->
                                <div class="col-md-3 text-center mb-4 mb-md-0">
                                    <img class="img-fluid"
                                        src="{{ asset('sbadmin/assets/img/illustrations/at-work.svg') }}"
                                        style="max-width: 10rem" alt="Illustration">
                                </div>

                                <!-- Teks -->
                                <div class="col-md-9 text-center text-md-start">
                                    <h1 class="text-primary">Selamat Datang, {{ $guru->nama }}!</h1>
                                    <p class="text-gray-700 mb-0">
                                        Silakan lengkapi dan perbarui data profil serta kemampuan teknologi informasi dan komunikasi (TIK) Anda secara mandiri di halaman ini.
                                    </p>
                                    <hr>
                                    <h2 class="text-primary mt-3">
                                        Status Verifikasi Kompetensi:
                                        @if ($guru->status_verifikasi == 0)
                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                        @elseif ($guru->status_verifikasi == 1)
                                            <span class="badge bg-success text-white">
                                                <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                            </span>
                                        @elseif ($guru->status_verifikasi == 2)
                                            <span class="badge bg-danger">Revisi / Perlu Perbaikan</span>
                                        @else
                                            <span class="badge bg-warning">Menunggu Inputan</span>
                                        @endif
                                    </h2>

                                    @if ($guru->catatan_verifikasi)
                                        <div class="alert alert-warning mt-2" role="alert">
                                            <strong>Catatan Verifikator:</strong> {{ $guru->catatan_verifikasi }}
                                        </div>
                                    @endif


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
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection
