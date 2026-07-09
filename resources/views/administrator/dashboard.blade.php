@extends('layouts.navbar')
@section('title', 'Dashboard Administrator EMONEV')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Dashboard
                            </h1>
                            <div class="page-header-subtitle">Dashboard Administrator</div>
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
                                <!-- Gambar -->
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    <img class="img-fluid" src="{{ asset('sbadmin/assets/img/illustrations/at-work.svg') }}"
                                        style="max-width: 10rem" alt="Illustration">
                                </div>

                                <!-- Teks -->
                                <div class="col-md-8 text-center text-md-start">
                                    <h1 class="text-primary">Selamat Datang!</h1>
                                    <p class="text-gray-700 mb-0">
                                        EMONEV merupakan aplikasi e-Monitoring dan e-Evaluasi Berbasis
                                        TIK
                                        yang dikembangkan oleh Balai Teknologi Informasi dan Komunikasi (BTKI)
                                        Dinas Pendidikan dan Kebudayaan Provinsi Maluku
                                    </p>
                                </div>
                            </div> 
                        </div>
                    </div>


                </div>
                <!-- Example Colored Cards for Dashboard Demo-->
                <div class="row">
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">JUMLAH SEKOLAH</div>
                                        <div class="text-lg fw-bold">{{ $jumlahSekolah }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="home"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="{{ route('sekolah.index') }}">DETAIL</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">MENUNGGU VERIFIKASI</div>
                                        <div class="text-lg fw-bold">{{ $jumlahSekolahWaitVerified }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="navigation"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="{{ route('sekolah.index') }}">DETAIL</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-3">
                                        <div class="text-white-75 small">SEKOLAH TERVERIFIKASI</div>
                                        <div class="text-lg fw-bold">{{ $jumlahSekolahVerified }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="check-square"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between small">
                                <a class="text-white stretched-link" href="{{ route('sekolah.index') }}">DETAIL</a>
                                <div class="text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
               
                

            </div>
    </main>

@endsection
