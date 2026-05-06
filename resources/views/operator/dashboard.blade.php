@extends('layouts.navbar')
@section('title', 'Dashboard Operator Sekolah E-Monitoring dan Evaluasi')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Dashboard : {{ Auth::user()->sekolah->nama }}
                            </h1>
                            <div class="page-header-subtitle">Dashboard Operator Sekolah</div>
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
                                        <h1 class="text-primary">Selamat Datang!</h1>
                                        <p class="text-gray-700 mb-0">
                                            SISTEM E-MONITORING DAN EVALUASI FASILITAS TEKNOLOGI INFORMASI DAN KOMUNIKASI (TIK) SMA SE-MALUKU PADA BTIK PROVINSI MALUKU merupakan aplikasi e-Monitoring dan e-Evaluasi Berbasis
                                            TIK
                                            yang dikembangkan oleh Balai Teknologi Informasi dan Komunikasi (BTIK)
                                            Dinas Pendidikan dan Kebudayaan Provinsi Maluku
                                        </p>
                                        <hr>
                                        <h1 class="text-primary mt-3">
                                            Status Verifikasi Data Sekolah:
                                            @if ($statusSekolah == 0)
                                                <span class="badge bg-warning">Menunggu Inputan</span>
                                            @elseif ($statusSekolah == 1)
                                                <span class="badge bg-success text-white">Menunggu Verifikasi</span>
                                            @elseif ($statusSekolah == 2)
                                                <span class="badge bg-success text-white">
                                                    <i data-feather="check-circle"></i> Terverifikasi
                                                </span>
                                            @elseif ($statusSekolah == 3)
                                                <span class="badge bg-danger">Revisi</span>
                                            @else
                                                <span class="badge bg-success">Menunggu Inputan</span>
                                            @endif

                                        </h1>

                                        <hr>

                                        {{-- Tombol Ajukan Verifikasi --}}
                                        <form id="formVerifikasi" action="{{ route('sekolah.ajukanVerifikasi') }}"
                                            method="POST">
                                            @csrf
                                            <button type="button" id="btnAjukan" class="btn btn-primary btn-sm">
                                                <i data-feather="send"></i> Ajukan Verifikasi Data
                                            </button>
                                        </form>
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
        document.getElementById('btnAjukan').addEventListener('click', function() {
            Swal.fire({
                title: 'Ajukan Verifikasi Data?',
                text: 'Pastikan Anda telah melengkapi data Identitas, SOSEKBUD, Bantuan, dan Fasilitas sekolah sebelum mengajukan verifikasi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ajukan Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formVerifikasi').submit();
                }
            });
        });

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
