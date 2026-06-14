@extends('layouts.navbar')
@section('title', 'Statistik Ketersediaan Listrik Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="zap"></i></div>
                                Statistik Ketersediaan Listrik Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            Diagram Statistik Listrik Berdasarkan Kabupaten/Kota
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header">Filter Statistik</div>

                <div class="card-body">

                    {{-- FILTER KOTA --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Pilih Kabupaten/Kota</label>
                            <select id="kota-select" class="form-select">
                                <option value="">Semua Kabupaten/Kota</option>
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- CHART --}}
                    <div id="listrik-chart" class="mb-5">
                        <p class="text-center text-muted">
                            <i class="fas fa-spinner fa-spin"></i> Memuat Chart...
                        </p>
                    </div>

                    <hr>

                    {{-- TABEL DETAIL --}}
                    <h4 id="detail-title">Detail Sekolah (Klik pada Bar Chart)</h4>

                    <div id="detail-table-container">
                        <p class="text-muted">Klik pada chart untuk melihat detail.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let chart = null;
        let detailTable = null;

        const API_CHART = "{{ route('listrik.getdata') }}";
        const API_DETAIL = "{{ route('listrik.getdetail') }}";

        $(document).ready(function() {
            loadChart();

            $('#kota-select').change(function() {
                loadChart($(this).val());
                resetDetail();
            });
        });

        function resetDetail() {
            $('#detail-title').text("Detail Sekolah (Klik pada Bar Chart)");
            $('#detail-table-container').html('<p class="text-muted">Klik pada chart untuk melihat detail.</p>');
        }

        function loadChart(kotaId = '') {
            $('#listrik-chart').html(
                '<p class="text-center p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>');

            $.getJSON(`${API_CHART}?kota_id=${kotaId}`, function(data) {
                const totalData = data.series ? data.series.reduce((a, b) => a + Number(b), 0) : 0;
                    if (totalData === 0) {
                    $('#listrik-chart').html('<div class="alert alert-warning text-center my-4"><i class="fas fa-exclamation-triangle me-2"></i> Belum ada data sekolah untuk Kabupaten/Kota yang dipilih.</div>');
                    if (chart) {
                        chart.destroy();
                        chart = null;
                    }
                    $('#detail-title').text('Detail Sekolah Ketersediaan Listrik');
                    $('#detail-table-container').html('<div class="alert alert-info text-center mt-3"><i class="fas fa-info-circle me-2"></i> Tidak ada data detail yang dapat ditampilkan untuk kriteria ini.</div>');
                    return;
                }

                const colorMap = {
                    'Ada': '#63e6be',      // Premium Mint-green
                    'Tidak': '#ff8787'     // Premium Coral-red
                };

                const colors = data.labels.map(label => colorMap[label] || '#64748b');

                const options = {
                    series: [{
                        name: 'Jumlah Sekolah',
                        data: data.series
                    }],
                    chart: {
                        type: 'bar',
                        height: 380,
                        fontFamily: 'Inter, sans-serif',
                        toolbar: {
                            show: false
                        },
                        events: {
                            dataPointSelection: function(event, ctx, config) {
                                loadDetail(kotaId, data.labels[config.dataPointIndex]);
                            }
                        }
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4
                    },
                    xaxis: {
                        categories: data.labels,
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: '#64748b',
                                fontWeight: 500
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#64748b',
                                fontWeight: 500
                            }
                        }
                    },
                    colors: colors,
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: '40%',
                            distributed: true
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px',
                            fontWeight: 700,
                            colors: ['#ffffff']
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        y: {
                            formatter: function(val) {
                                return val + " sekolah";
                            }
                        }
                    }
                };

                $('#listrik-chart').html('');

                if (chart) chart.destroy();
                chart = new ApexCharts(document.querySelector("#listrik-chart"), options);
                chart.render();
            });
        }

        function loadDetail(kotaId, status) {
            $('#detail-title').text(`Detail Sekolah dengan Status Listrik: ${status}`);
            $('#detail-table-container').html(
                '<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</p>');

            $.getJSON(`${API_DETAIL}?kota_id=${kotaId}&status=${status}`, function(list) {

                if (!list.length) {
                    $('#detail-table-container').html(
                        '<div class="alert alert-warning">Tidak ada sekolah dalam kategori ini.</div>');
                    return;
                }

                let html = `
        <div class="table-responsive">
            <table id="detailTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>NPSN</th>
                        <th>Nama</th>
                        <th>Tingkatan</th>
                        <th>Alamat</th>
                        <th>Sumber Listrik</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody>
        `;

                list.forEach(s => {
                    html += `
                <tr>
                    <td>${s.npsn ?? '-'}</td>
                    <td>${s.nama ?? '-'}</td>
                    <td>${s.tingkatan ?? '-'}</td>
                    <td>${s.alamat ?? '-'}</td>
                    <td>${s.sumber ?? '-'}</td>
                    <td>${s.durasi ?? '-'}</td>
                </tr>
            `;
                });

                html += `</tbody></table></div>`;

                $('#detail-table-container').html(html);

                detailTable = $('#detailTable').DataTable();
            });
        }
    </script>
@endsection
