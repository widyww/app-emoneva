@extends('layouts.navbar')
@section('title', 'Statistik Guru Berdasarkan Pendidikan Terakhir')

@section('content')
    <main>
        {{-- HEADER --}}
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="bar-chart-2"></i></div>
                        Statistik Guru Berdasarkan Pendidikan Terakhir
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

        // endpoints (pastikan route sudah dibuat)
        const API_CHART = "{{ route('sortgurupendidikan.getdata') }}";
        const API_DETAIL = "{{ route('sortgurupendidikan.getdetail') }}";

        $(document).ready(function() {
            // load awal (semua kabupaten)
            loadChart();

            // ketika pilih kabupaten/kota, tampilkan chart jenjang untuk kab tersebut
            $('#kota-select').on('change', function() {
                const kotaId = $(this).val();
                loadChart(kotaId);
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

        // loadChart: memanggil API dan render chart (labels = jenjang, series = counts)
        function loadChart(kotaId = '') {
            $('#guru-chart').html('<p class="text-center p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>');

            $.getJSON(`${API_CHART}?kota_id=${kotaId}`, function(data) {

                    // warna tiap bar
                    const colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#0dcaf0'];

                    const options = {
                        series: [{
                            name: 'Jumlah Guru',
                            data: data.series
                        }],
                        chart: {
                            type: 'bar',
                            height: 380,
                            events: {
                                dataPointSelection: function(event, ctx, config) {
                                    const level = data.labels[config.dataPointIndex];
                                    loadDetail(kotaId, level);
                                }
                            }
                        },
                        xaxis: {
                            categories: data.labels
                        },
                        colors: colors,
                        plotOptions: {
                            bar: {
                                borderRadius: 6
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        tooltip: {
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
                })
                .fail(function() {
                    $('#guru-chart').html('<p class="text-danger text-center p-4">Gagal memuat chart.</p>');
                });
        }

        // loadDetail: memanggil API_DETAIL dengan params kota_id & level
        function loadDetail(kotaId, level) {
            $('#detail-title').text(`Detail Guru: ${level}`);
            $('#detail-table-container').html(
                '<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</p>');

            $.getJSON(`${API_DETAIL}?kota_id=${kotaId}&level=${encodeURIComponent(level)}`, function(list) {

                    if (!list.length) {
                        $('#detail-table-container').html(
                            '<div class="alert alert-warning">Tidak ada guru dengan jenjang ini.</div>');
                        return;
                    }

                    let html = `
                    <div class="table-responsive">
                        <table id="detailTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NPSN</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>NUPTK</th>
                                    <th>Mapel</th>
                                    <th>Tingkatan</th>
                                    <th>Alamat</th>
                                    <th>Sekolah</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                    list.forEach(g => {
                        html += `
                        <tr>
                            <td>${g.npsn ?? '-'}</td>
                            <td>${g.nama ?? '-'}</td>
                            <td>${g.nip ?? '-'}</td>
                            <td>${g.nuptk ?? '-'}</td>
                            <td>${g.mapel ?? '-'}</td>
                            <td>${g.tingkatan ?? '-'}</td>
                            <td>${g.alamat ?? '-'}</td>
                            <td>${g.sekolah ?? '-'}</td>
                        </tr>
                    `;
                    });

                    html += `</tbody></table></div>`;

                    $('#detail-table-container').html(html);

                    // inisialisasi datatable
                    if (detailTable) {
                        detailTable.destroy();
                        detailTable = null;
                    }
                    detailTable = $('#detailTable').DataTable({
                        pageLength: 10
                    });

                })
                .fail(function() {
                    $('#detail-table-container').html('<p class="text-danger p-3">Gagal memuat detail.</p>');
                });
        }
    </script>
@endsection
