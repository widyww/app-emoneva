@extends('layouts.navbar')
@section('title', 'Data Kebutuhan Pelatihan Guru')

@section('content')
    <main>
        {{-- HEADER --}}
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="book"></i></div>
                        Data Kebutuhan Pelatihan Guru
                    </h1>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header">Filter Guru</div>
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

        const API_CHART = "{{ route('sortgurupelatihan.getdata') }}";
        const API_DETAIL = "{{ route('sortgurupelatihan.getdetail') }}";

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
                if (!data.labels || totalData === 0) {
                    $('#guru-chart').html('<div class="alert alert-warning text-center my-4"><i class="fas fa-exclamation-triangle me-2"></i> Belum ada data guru untuk Kabupaten/Kota yang dipilih.</div>');
                    if (chart) {
                        chart.destroy();
                        chart = null;
                    }
                    $('#detail-title').text('Detail Guru');
                    $('#detail-table-container').html('<div class="alert alert-info text-center mt-3"><i class="fas fa-info-circle me-2"></i> Tidak ada data detail yang dapat ditampilkan untuk kriteria ini.</div>');
                    return;
                }

                // Premium colors
                const colors = [
                    '#4c6ef5', '#63e6be', '#ff8787', '#15aabf', '#b197fc',
                    '#ffc078', '#fcc419', '#e8590c', '#3b5bdb', '#2b8a3e'
                ];

                const options = {
                    series: [{
                        name: 'Jumlah Guru',
                        data: data.series
                    }],
                    chart: {
                        type: 'bar',
                        height: 480, // Taller height to give space to 10 horizontal bars
                        fontFamily: 'Inter, sans-serif',
                        toolbar: {
                            show: false
                        },
                        events: {
                            dataPointSelection: function(event, ctx, config) {
                                const pelatihan = data.labels[config.dataPointIndex];
                                loadDetail(kotaId, pelatihan);
                            }
                        }
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 4,
                        padding: {
                            right: 40 // Padding so the data labels at the end of the bars don't get cut off
                        }
                    },
                    colors: colors,
                    plotOptions: {
                        bar: {
                            horizontal: true, // Horizontal bar chart
                            borderRadius: 6,
                            barHeight: '60%', // Bar thickness
                            distributed: true,
                            dataLabels: {
                                position: 'top' // Place label at the end of the bar
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetX: 35, // Position slightly outside the end of the bar
                        style: {
                            fontSize: '11px',
                            fontWeight: 700,
                            colors: ['#475569'] // Slate-600 color for high readability outside
                        },
                        formatter: function(val) {
                            return val + " Guru";
                        }
                    },
                    legend: {
                        show: false // Hide cluttered legend
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
                                colors: '#475569', // Darker font for y-axis labels
                                fontWeight: 600,
                                fontSize: '11px'
                            },
                            maxWidth: 250 // Prevent too aggressive truncation of long training names
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
            }).fail(function() {
                $('#guru-chart').html('<div class="alert alert-danger text-center">Gagal memuat data chart dari server.</div>');
            });
        }

        function loadDetail(kotaId, pelatihan) {
            $('#detail-title').text(`Detail Guru dengan Kebutuhan Pelatihan: ${pelatihan}`);
            $('#detail-table-container').html(
                '<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</p>');

            $.getJSON(`${API_DETAIL}?kota_id=${kotaId}&pelatihan=${encodeURIComponent(pelatihan)}`, function(list) {

                if (!list.length) {
                    $('#detail-table-container').html(
                        '<div class="alert alert-warning">Tidak ada guru dengan kebutuhan pelatihan ini.</div>');
                    return;
                }

                let html = `<div class="table-responsive">
            <table id="detailTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>NUPTK</th>
                        <th>Sekolah</th>
                        <th>Kota</th>
                        <th>Pelatihan/Kebutuhan</th>
                    </tr>
                </thead>
                <tbody>`;

                list.forEach(g => {
                    html += `<tr>
                <td>${g.nama}</td>
                <td>${g.nip}</td>
                <td>${g.nuptk}</td>
                <td>${g.sekolah}</td>
                <td>${g.kota}</td>
                <td>${g.pelatihan}</td>
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
            }).fail(function() {
                $('#detail-table-container').html('<div class="alert alert-danger text-center">Gagal memuat detail guru.</div>');
            });
        }
    </script>
@endsection
