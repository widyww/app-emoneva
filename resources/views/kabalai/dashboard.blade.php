@extends('layouts.navbar')
@section('title', 'Dashboard Kabalai BTKI EMONEV')

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
                            <div class="page-header-subtitle">Dashboard Kabalai</div>
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
                                <div class="col-xl-8 col-xxl-12">
                                    <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                        <h1 class="text-primary">Selamat Datang!</h1>
                                        <p class="text-gray-700 mb-0">EMONEV merupakan aplikasi e-Monitoring
                                            dan e-Evaluasi Berbasis TIK yang dikembangkan oleh Balai Teknologi Informasi dan
                                            Komunikasi (BTKI) Dinas Pendidikan dan Kebudayaan Provinsi Maluku</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid"
                                        src="{{ asset('sbadmin/assets/img/illustrations/at-work.svg') }}"
                                        style="max-width: 26rem" /></div>
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
                                    <div class="text-white-75 small">TOTAL SEKOLAH</div>
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
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">BELUM INPUT</div>
                                    <div class="text-lg fw-bold">{{ $jumlahSekolahNotInput }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="x-octagon"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="#">DETAIL</a>
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
                            <a class="text-white stretched-link" href="#">DETAIL</a>
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
                
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">TOTAL GURU</div>
                                    <div class="text-lg fw-bold">{{ $jumlahGuru }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="users"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="#">DETAIL</a>
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
                                    <div class="text-lg fw-bold">{{ $jumlahGuruWaitVerified }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="navigation"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="#">DETAIL</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
               
               
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 small">GURU TERVERIFIKASI</div>
                                    <div class="text-lg fw-bold">{{ $jumlahGuruVerified }}</div>
                                </div>
                                <i class="feather-xl text-white-50" data-feather="check-square"></i>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <a class="text-white stretched-link" href="#">DETAIL</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">Status Verifikasi Data Sekolah</div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                            <div id="schoolStatusChart" style="width: 100%; min-height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">Status Verifikasi Data Guru</div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                            <div id="guruStatusChart" style="width: 100%; min-height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // School Chart
            var schoolOptions = {
                series: [
                    {{ $jumlahSekolahNotInput }},
                    {{ $jumlahSekolahWaitVerified }},
                    {{ $jumlahSekolahVerified }}
                ],
                labels: ['Belum Input', 'Menunggu Verifikasi', 'Terverifikasi'],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#ff8787', '#ffc078', '#63e6be'], // Light-premium red, warning, success
                stroke: {
                    show: true,
                    colors: ['#ffffff'],
                    width: 3
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '13px',
                                    fontWeight: 600,
                                    color: '#64748b',
                                    offsetY: -8
                                },
                                value: {
                                    show: true,
                                    fontSize: '26px',
                                    fontWeight: 800,
                                    color: '#1e293b',
                                    offsetY: 6,
                                    formatter: function (w) { return w }
                                },
                                total: {
                                    show: true,
                                    label: 'Total Sekolah',
                                    color: '#64748b',
                                    fontSize: '12px',
                                    fontWeight: 600,
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 500,
                    labels: {
                        colors: '#475569'
                    },
                    markers: {
                        radius: 12
                    }
                },
                dropShadow: {
                    enabled: true,
                    top: 4,
                    left: 0,
                    blur: 10,
                    opacity: 0.05
                },
                tooltip: {
                    enabled: true
                }
            };
            var schoolChart = new ApexCharts(document.querySelector("#schoolStatusChart"), schoolOptions);
            schoolChart.render();

            // Teacher Chart
            var teacherOptions = {
                series: [
                    {{ $jumlahGuruWaitVerified }},
                    {{ $jumlahGuruVerified }}
                ],
                labels: ['Menunggu Verifikasi', 'Terverifikasi'],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#ffc078', '#63e6be'], // Light-premium warning, success
                stroke: {
                    show: true,
                    colors: ['#ffffff'],
                    width: 3
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '13px',
                                    fontWeight: 600,
                                    color: '#64748b',
                                    offsetY: -8
                                },
                                value: {
                                    show: true,
                                    fontSize: '26px',
                                    fontWeight: 800,
                                    color: '#1e293b',
                                    offsetY: 6,
                                    formatter: function (w) { return w }
                                },
                                total: {
                                    show: true,
                                    label: 'Total Guru',
                                    color: '#64748b',
                                    fontSize: '12px',
                                    fontWeight: 600,
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    fontFamily: 'Inter, sans-serif',
                    fontWeight: 500,
                    labels: {
                        colors: '#475569'
                    },
                    markers: {
                        radius: 12
                    }
                },
                dropShadow: {
                    enabled: true,
                    top: 4,
                    left: 0,
                    blur: 10,
                    opacity: 0.05
                },
                tooltip: {
                    enabled: true
                }
            };
            var teacherChart = new ApexCharts(document.querySelector("#guruStatusChart"), teacherOptions);
            teacherChart.render();
        });
    </script>
@endsection
