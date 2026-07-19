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
                            <a class="text-white stretched-link" href="#">DETAIL</a>
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
                            <a class="text-white stretched-link" href="#">DETAIL</a>
                            <div class="text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- SPK Shortcut Section -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card bg-white h-100">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="text-primary font-weight-bold mb-2">Memantau Hasil SPK & Rekomendasi Bantuan</h4>
                                <p class="text-muted mb-0">Lihat hasil prioritas sekolah penerima bantuan TIK berdasarkan perhitungan metode AHP-SAW, cetak laporan, dan lihat grafik statistik pendukung.</p>
                            </div>
                            <div class="ms-3">
                                <a href="{{ route('spk.rank.index') }}" class="btn btn-primary">
                                    <i data-feather="award" class="me-1"></i> Buka Halaman SPK
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header">Status Verifikasi Data Sekolah</div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                            <div id="schoolStatusChart" style="width: 100%; min-height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SPK Results Summary Table -->
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Daftar Prioritas Sekolah Pemerima Bantuan (Top 10)</span>
                            <a href="{{ route('spk.rank.index') }}" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya</a>
                        </div>
                        <div class="card-body p-0">
                            @if ($hasilSpk->isEmpty())
                                <div class="p-4 alert alert-info m-4 mb-0">
                                    Belum ada hasil perangkingan untuk periode ini. 
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0 border-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 80px;">Rank</th>
                                                <th>Nama Sekolah</th>
                                                <th class="text-center" title="Ketersediaan komputer">C1</th>
                                                <th class="text-center" title="Durasi/ketersediaan daya listrik">C2</th>
                                                <th class="text-center" title="Kapasitas jaringan internet">C3</th>
                                                <th class="text-center" title="Ketersediaan ruang laboratorium komputer">C4</th>
                                                <th class="text-center" title="Riwayat penerimaan bantuan">C5</th>
                                                <th class="text-center" style="width: 100px;">Nilai V</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hasilSpk as $h)
                                                <tr>
                                                    <td class="text-center fw-bold">{{ $h->peringkat }}</td>
                                                    <td>{{ $h->sekolah->nama ?? '-' }}</td>
                                                    <td class="text-center">{{ $h->skor['C1'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $h->skor['C2'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $h->skor['C3'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $h->skor['C4'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $h->skor['C5'] ?? '-' }}</td>
                                                    <td class="text-center fw-bold text-primary">{{ number_format($h->nilai_vi, 4) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 bg-light border-top text-muted small">
                                    <strong>Kriteria SPK:</strong> C1: Ketersediaan komputer | C2: Durasi/ketersediaan daya listrik | C3: Kapasitas jaringan internet | C4: Ketersediaan ruang laboratorium komputer | C5: Riwayat penerimaan bantuan
                                </div>
                            @endif
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
        });
    </script>
@endsection
