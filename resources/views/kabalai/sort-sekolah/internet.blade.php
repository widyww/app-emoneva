@extends('layouts.navbar')
@section('title', 'Statistik Status Kesesuaian Internet Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="wifi"></i></div>
                                Statistik Status Kesesuaian Internet Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            Diagram Statistik Internet Berdasarkan Kabupaten/Kota
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Filter Statistik</span>
                </div>

                <div class="card-body">

                    {{-- 1. FILTER KOTA --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="kota-select" class="form-label">Pilih Kabupaten/Kota:</label>
                            <select id="kota-select" class="form-select">
                                <option value="">Semua Kabupaten/Kota</option>
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 2. CHART INTERNET --}}
                    <div id="internet-chart" class="mb-5">
                        <p class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>
                    </div>

                    <hr class="my-4">

                    {{-- 3. DETAIL TABEL --}}
                    <h4 class="mb-3" id="detail-title">
                        Detail Sekolah Berdasarkan Status Kesesuaian (Klik pada Bar Chart)
                    </h4>

                    <div id="internet-detail-table-container">
                        <p class="text-muted">
                            Klik pada bar chart untuk melihat daftar sekolah sesuai status kesesuaian internet.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        let internetChart = null;
        let detailTable = null;

        // ROUTE API
        const API_CHART = "{{ route('internet.getdata') }}";
        const API_DETAIL = "{{ route('internet.getdetail') }}";

        $(document).ready(function() {

            loadInternetChart($('#kota-select').val());

            $('#kota-select').on('change', function() {
                loadInternetChart($(this).val());

                $("#internet-detail-table-container").html(
                    '<p class="text-muted">Klik pada bar chart untuk melihat detail sekolah.</p>'
                );
                $("#detail-title").text(
                    'Detail Sekolah Berdasarkan Status Kesesuaian (Klik pada Bar Chart)');
            });
        });

        // =============================
        // 1. LOAD CHART
        // =============================
        function loadInternetChart(kotaId = '') {

            $("#internet-chart").html(
                '<p class="text-center text-muted p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>');

            const url = `${API_CHART}?kota_id=${kotaId}`;

            $.getJSON(url)
                .done(function(data) {

                    // Warna: Sesuai / Tidak
                    const colorMap = {
                        'Sesuai': '#63e6be',       // Premium Mint-green
                        'Tidak Sesuai': '#ff8787'  // Premium Coral-red
                    };

                    const chartColors = data.labels.map(label => colorMap[label] || '#64748b');

                    const options = {
                        series: [{
                            name: 'Jumlah Sekolah',
                            data: data.series
                        }],
                        chart: {
                            type: 'bar',
                            height: 400,
                            fontFamily: 'Inter, sans-serif',
                            toolbar: {
                                show: false
                            },
                            events: {
                                dataPointSelection: function(e, ctx, config) {
                                    const status = data.labels[config.dataPointIndex];
                                    loadInternetDetail(kotaId, status);
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
                        colors: chartColors,
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function(val) {
                                    return val + " sekolah";
                                }
                            }
                        }
                    };

                    if (internetChart) {
                        internetChart.updateOptions(options);
                    } else {
                        $("#internet-chart").html("");
                        internetChart = new ApexCharts(document.querySelector("#internet-chart"), options);
                        internetChart.render();
                    }

                })
                .fail(function() {
                    $("#internet-chart").html(
                        '<p class="text-danger text-center p-5">Gagal memuat chart.</p>');
                });
        }

        // =============================
        // 2. LOAD DETAIL TABEL
        // =============================
        function loadInternetDetail(kotaId, status) {
            const url = `${API_DETAIL}?kota_id=${kotaId}&status=${status}`;

            $("#detail-title").text(`Detail Sekolah dengan Status: ${status}`);
            $("#internet-detail-table-container").html(
                '<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</p>'
            );

            $.getJSON(url)
                .done(function(list) {

                    if (detailTable) {
                        detailTable.destroy();
                        detailTable = null;
                    }

                    if (list.length === 0) {
                        $("#internet-detail-table-container").html(
                            '<div class="alert alert-warning">Tidak ada sekolah pada kategori ini.</div>');
                        return;
                    }

                    let html = `
                        <div class="table-responsive">
                            <table class="table table-bordered" id="detailInternetTable">
                                <thead>
                                    <tr>
                                        <th>NPSN</th>
                                        <th>Nama Sekolah</th>
                                        <th>Tingkatan</th>
                                        <th>Alamat</th>
                                        <th>Kesesuaian</th>
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
                                <td>${status}</td>
                            </tr>
                        `;
                    });

                    html += `</tbody></table></div>`;

                    $("#internet-detail-table-container").html(html);

                    detailTable = $("#detailInternetTable").DataTable();

                })
                .fail(function() {
                    $("#internet-detail-table-container").html(
                        '<p class="text-danger p-3">Gagal memuat detail sekolah.</p>'
                    );
                });
        }
    </script>

@endsection
