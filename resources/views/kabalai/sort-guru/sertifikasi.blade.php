@extends('layouts.navbar')
@section('title', 'Statistik Guru Berdasarkan Sertifikasi')

@section('content')
    <main>
        {{-- HEADER --}}
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="award"></i></div>
                        Statistik Guru Berdasarkan Sertifikasi
                    </h1>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header">Filter Statistik Guru</div>
                <div class="card-body">

                    {{-- FILTER KABUPATEN/KOTA --}}
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
                    <div id="guru-chart" class="mb-5">
                        <p class="text-center p-5">
                            <i class="fas fa-spinner fa-spin"></i> Memuat Chart...
                        </p>
                    </div>

                    <hr>

                    {{-- DETAIL TABEL --}}
                    <h4 id="detail-title">Detail Guru (Klik Chart)</h4>
                    <div id="detail-table-container">
                        <p class="text-muted">Klik pada bar chart untuk melihat detail guru.</p>
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

        const API_CHART = "{{ route('sortgurusertifikasi.getdata') }}";
        const API_DETAIL = "{{ route('sortgurusertifikasi.getdetail') }}";

        $(document).ready(function() {
            loadChart();

            $('#kota-select').on('change', function() {
                loadChart($(this).val());
                resetDetail();
            });
        });

        function resetDetail() {
            $('#detail-title').text("Detail Guru (Klik Chart)");
            $('#detail-table-container').html('<p class="text-muted">Klik pada bar chart untuk melihat detail guru.</p>');
            if (detailTable) {
                detailTable.destroy();
                detailTable = null;
            }
        }

        function loadChart(kotaId = '') {
            $('#guru-chart').html('<p class="text-center p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>');

            $.getJSON(`${API_CHART}?kota_id=${kotaId}`, function(data) {
                const totalData = data.series ? data.series.reduce((a, b) => a + Number(b), 0) : 0;
                    if (totalData === 0) {
                    $('#guru-chart').html('<div class="alert alert-warning text-center my-4"><i class="fas fa-exclamation-triangle me-2"></i> Belum ada data guru untuk Kabupaten/Kota yang dipilih.</div>');
                    if (chart) {
                        chart.destroy();
                        chart = null;
                    }
                    $('#detail-title').text('Detail Guru');
                    $('#detail-table-container').html('<div class="alert alert-info text-center mt-3"><i class="fas fa-info-circle me-2"></i> Tidak ada data detail yang dapat ditampilkan untuk kriteria ini.</div>');
                    return;
                }

                const colors = ['#63e6be', '#ff8787']; // Premium mint-green, coral-red

                const options = {
                    series: [{
                        name: 'Jumlah Guru',
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
                                const status = data.labels[config.dataPointIndex];
                                loadDetail(kotaId, status);
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
                            borderRadius: 6,
                            columnWidth: '45%',
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
                                return val + " guru";
                            }
                        }
                    }
                };

                $('#guru-chart').html('');
                if (chart) chart.destroy();
                chart = new ApexCharts(document.querySelector("#guru-chart"), options);
                chart.render();
            });
        }

        function loadDetail(kotaId, status) {
            $('#detail-title').text(`Detail Guru: ${status}`);
            $('#detail-table-container').html(
                '<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</p>');

            $.getJSON(`${API_DETAIL}?kota_id=${kotaId}&status=${encodeURIComponent(status)}`, function(list) {

                if (!list.length) {
                    $('#detail-table-container').html(
                        '<div class="alert alert-warning">Tidak ada guru dengan status ini.</div>');
                    return;
                }

                let html = `<div class="table-responsive">
            <table id="detailTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>NUPTK</th>
                        <th>Mapel</th>
                        <th>Sekolah</th>
                        <th>Kota</th>
                        <th>Sertifikasi Info</th>
                    </tr>
                </thead>
                <tbody>`;

                list.forEach(g => {
                    html += `<tr>
                <td>${g.nama}</td>
                <td>${g.nip}</td>
                <td>${g.nuptk}</td>
                <td>${g.mapel}</td>
                <td>${g.sekolah}</td>
                <td>${g.kota}</td>
                <td>${g.sertifikasi_info}</td>
            </tr>`;
                });

                html += `</tbody></table></div>`;
                $('#detail-table-container').html(html);

                if (detailTable) {
                    detailTable.destroy();
                    detailTable = null;
                }
                detailTable = $('#detailTable').DataTable({
                    pageLength: 10
                });
            });
        }
    </script>
@endsection
