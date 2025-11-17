@extends('layouts.navbar')
@section('title', 'Statistik Status Penerimaan Bantuan Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="bar-chart-2"></i></div>
                                Statistik Status Penerimaan Bantuan Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Diagram Statistik Penerimaan Bantuan Sekolah berdasarkan
                            Kota/Kabupaten
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
                    {{-- 1. DROP-DOWN FILTER --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="kota-select" class="form-label">Pilih Kota/Kabupaten:</label>
                            <select id="kota-select" class="form-select">
                                <option value="">Semua Kota/Kabupaten</option>
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 2. CONTAINER CHART --}}
                    {{-- ID chart diubah menjadi bantuan-chart untuk konsistensi --}}
                    <div id="bantuan-chart" class="mb-5">
                        <p class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>
                    </div>

                    <hr class="my-4">

                    {{-- 3. CONTAINER DETAIL TABEL --}}
                    <h4 class="mb-3" id="detail-title">Detail Sekolah Berdasarkan Status Bantuan (Klik pada Bar Chart)
                    </h4>
                    <div id="sekolah-detail-table-container">
                        <p class="text-muted">Klik pada bar chart di atas untuk menampilkan detail sekolah penerima atau
                            bukan penerima bantuan.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    {{-- Memuat Font Awesome (untuk ikon loading) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    {{-- SweetAlert, jQuery, dan DataTables (Diasumsikan sudah ada di template Anda) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Memuat Library ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Variabel untuk menampung instance chart
        let bantuanChart = null;
        let detailDataTable = null; // Untuk DataTables

        // Ambil URL API dari route helper Laravel
        const API_URL_CHART = "{{ route('bantuan.getdata') }}";
        const API_URL_DETAIL = "{{ route('bantuan.getdetail') }}";
        const CHART_ID = "#bantuan-chart";
        const DETAIL_CONTAINER_ID = "#sekolah-detail-table-container";
        const DETAIL_TITLE_ID = "#detail-title";

        // Ketika dokumen siap (jQuery)
        $(document).ready(function() {
            // Panggil fungsi untuk memuat data chart awal
            loadBantuanChart($('#kota-select').val());

            // Tambahkan event listener untuk perubahan dropdown
            $('#kota-select').on('change', function() {
                const selectedKotaId = $(this).val();
                loadBantuanChart(selectedKotaId);

                // Kosongkan detail saat filter kota berubah
                $(DETAIL_CONTAINER_ID).html(
                    '<p class="text-muted">Klik pada bar chart di atas untuk menampilkan detail sekolah penerima atau bukan penerima bantuan.</p>'
                );
                $(DETAIL_TITLE_ID).text('Detail Sekolah Berdasarkan Status Bantuan (Klik pada Bar Chart)');
            });
        });

        // ===================================================================
        // FUNGSI 1: MENGAMBIL DATA DAN MERENDER CHART
        // ===================================================================
        function loadBantuanChart(kotaId = '') {
            const url = `${API_URL_CHART}?kota_id=${kotaId}`;

            // Tampilkan loading state
            $(CHART_ID).html(
                '<p class="text-center text-muted p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>');


            $.getJSON(url)
                .done(function(data) {
                    // Mapping warna untuk status 'Ya' (Hijau) dan 'Tidak' (Kuning/Orange)
                    const colorsMap = {};
                    data.labels.forEach(label => {
                        colorsMap[label] = label === 'Ya' ? '#00A300' : '#FF9900'; // Dark Green/Orange
                    });
                    const seriesColors = data.labels.map(label => colorsMap[label]);

                    const chartOptions = {
                        series: [{
                            name: 'Jumlah Sekolah',
                            data: data.series
                        }],
                        chart: {
                            type: 'bar',
                            height: 400,
                            toolbar: {
                                show: true
                            },
                            events: {
                                dataPointSelection: function(event, chartContext, config) {
                                    // Ambil label yang diklik (status bantuan: Ya/Tidak)
                                    const selectedStatus = data.labels[config.dataPointIndex];
                                    loadSekolahDetail(kotaId, selectedStatus);
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                borderRadius: 4,
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: data.labels, // Label: Ya, Tidak
                            title: {
                                text: 'Status Penerima Bantuan'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Jumlah Sekolah'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        colors: seriesColors,
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " sekolah"
                                }
                            }
                        }
                    };

                    // Inisialisasi atau Update Chart
                    if (bantuanChart) {
                        bantuanChart.updateOptions(chartOptions);
                    } else {
                        $(CHART_ID).html(''); // Hapus loading
                        bantuanChart = new ApexCharts(document.querySelector(CHART_ID), chartOptions);
                        bantuanChart.render();
                    }

                    // Muat detail awal (Sekolah dengan status 'Ya', jika ada)
                    if (data.labels.length > 0) {
                        // Coba muat 'Ya' terlebih dahulu
                        const defaultStatus = data.labels.includes('Ya') ? 'Ya' : data.labels[0];
                        loadSekolahDetail(kotaId, defaultStatus);
                    } else {
                        $(DETAIL_TITLE_ID).text('Detail Sekolah Penerima Bantuan');
                        $(DETAIL_CONTAINER_ID).html(
                            '<div class="alert alert-info">Tidak ada data bantuan yang tersedia untuk kriteria ini.</div>'
                            );
                    }

                })
                .fail(function(jqxhr, textStatus, error) {
                    const err = jqxhr.responseJSON?.error || textStatus + ", " + error;
                    console.error("Gagal memuat data chart bantuan:", err);
                    $(CHART_ID).html(`<p class="text-center text-danger p-5">Gagal memuat data chart: ${err}</p>`);
                });
        }

        // ===================================================================
        // FUNGSI 2: MENGAMBIL DATA DETAIL DAN MERENDER TABEL
        // ===================================================================
        function loadSekolahDetail(kotaId, statusBantuan) {
            const url = `${API_URL_DETAIL}?kota_id=${kotaId}&status=${statusBantuan}`;

            // Hapus dan Hancurkan DataTable lama jika ada
            if (detailDataTable) {
                detailDataTable.destroy();
                detailDataTable = null;
            }

            // Tampilkan loading
            $(DETAIL_TITLE_ID).text(`Detail Sekolah: Loading status "${statusBantuan}"...`);
            $(DETAIL_CONTAINER_ID).html(
                '<p class="text-center text-muted p-4"><i class="fas fa-spinner fa-spin"></i> Memuat data detail sekolah...</p>'
                );

            $.getJSON(url)
                .done(function(dataSekolah) {
                    $(DETAIL_TITLE_ID).text(`Detail Sekolah dengan Status Bantuan: ${statusBantuan}`);

                    if (dataSekolah.length === 0) {
                        $(DETAIL_CONTAINER_ID).html(
                            '<div class="alert alert-warning">Tidak ada sekolah yang ditemukan dengan kriteria tersebut.</div>'
                        );
                        return;
                    }

                    // BUILD TABEL HTML SECARA DINAMIS (Menggunakan kelas Bootstrap 5/SB Admin)
                    let tableHtml = `
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="detailTable">
                                <thead>
                                    <tr>
                                        <th>NPSN</th>
                                        <th>Nama Sekolah</th>
                                        <th>Tingkatan</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    // Iterasi data sekolah dari JSON
                    dataSekolah.forEach(sekolah => {
                        tableHtml += `
                            <tr>
                                <td>${sekolah.npsn || '-'}</td>
                                <td>${sekolah.nama || '-'}</td>
                                <td>${sekolah.tingkatan || '-'}</td>
                                <td>${sekolah.alamat || '-'}</td>
                            </tr>
                        `;
                    });

                    tableHtml += `
                                </tbody>
                            </table>
                        </div>
                    `;

                    // Sisipkan HTML yang sudah dibuat
                    $(DETAIL_CONTAINER_ID).html(tableHtml);

                    // Inisialisasi DataTables pada tabel baru
                    detailDataTable = $('#detailTable').DataTable({
                        "pageLength": 10 // Atur jumlah baris default
                    });

                })
                .fail(function(jqxhr, textStatus, error) {
                    const err = jqxhr.responseJSON?.error || textStatus + ", " + error;
                    console.error("Gagal memuat detail sekolah:", err);
                    $(DETAIL_TITLE_ID).text(`Detail Sekolah: Gagal memuat data`);
                    $(DETAIL_CONTAINER_ID).html(
                        '<p class="text-danger p-4">Gagal memuat detail data. (Cek console log)</p>');
                });
        }
    </script>
@endsection
