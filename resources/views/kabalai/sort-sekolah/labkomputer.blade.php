@extends('layouts.navbar')
@section('title', 'Statistik Status Kepemilikan Lab Komputer Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="monitor"></i></div>
                                Statistik Status Kepemilikan Lab Komputer Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Diagram Statistik Lab Komputer berdasarkan Kota/Kabupaten
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
                                {{-- Variabel $kotas harus disediakan oleh Controller --}}
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 2. CONTAINER CHART --}}
                    <div id="labkomputer-chart" class="mb-5">
                        <p class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>
                    </div>

                    <hr class="my-4">

                    {{-- 3. CONTAINER DETAIL TABEL --}}
                    <h4 class="mb-3" id="detail-title">Detail Sekolah Berdasarkan Status Lab Komputer (Klik pada Bar
                        Chart)
                    </h4>
                    <div id="sekolah-detail-table-container">
                        <p class="text-muted">Klik pada bar chart di atas untuk menampilkan detail sekolah yang memiliki
                            atau
                            tidak memiliki lab komputer.</p>
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
        let labKomputerChart = null;
        let detailDataTable = null; // Untuk DataTables

        // Ambil URL API dari route helper Laravel (Menggunakan Route baru yang Anda buat)
        const API_URL_CHART = "{{ route('labkomputer.getdata') }}";
        const API_URL_DETAIL = "{{ route('labkomputer.getdetail') }}";
        const CHART_ID = "#labkomputer-chart";
        const DETAIL_CONTAINER_ID = "#sekolah-detail-table-container";
        const DETAIL_TITLE_ID = "#detail-title";

        // Ketika dokumen siap (jQuery)
        $(document).ready(function() {
            // Panggil fungsi untuk memuat data chart awal
            loadLabKomputerChart($('#kota-select').val());

            // Tambahkan event listener untuk perubahan dropdown
            $('#kota-select').on('change', function() {
                const selectedKotaId = $(this).val();
                loadLabKomputerChart(selectedKotaId);

                // Kosongkan detail saat filter kota berubah
                $(DETAIL_CONTAINER_ID).html(
                    '<p class="text-muted">Klik pada bar chart di atas untuk menampilkan detail sekolah penerima atau bukan penerima bantuan.</p>'
                );
                $(DETAIL_TITLE_ID).text(
                    'Detail Sekolah Berdasarkan Status Lab Komputer (Klik pada Bar Chart)');
            });
        });

        // ===================================================================
        // FUNGSI 1: MENGAMBIL DATA DAN MERENDER CHART
        // ===================================================================
        function loadLabKomputerChart(kotaId = '') {
            const url = `${API_URL_CHART}?kota_id=${kotaId}`;

            // Tampilkan loading state
            $(CHART_ID).html(
                '<p class="text-center text-muted p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>');


            $.getJSON(url)
                .done(function(data) {
                    const totalData = data.series ? data.series.reduce((a, b) => a + Number(b), 0) : 0;
                    if (totalData === 0) {
                        $(CHART_ID).html('<div class="alert alert-warning text-center my-4"><i class="fas fa-exclamation-triangle me-2"></i> Belum ada data sekolah untuk Kabupaten/Kota yang dipilih.</div>');
                        if (labKomputerChart) {
                            labKomputerChart.destroy();
                            labKomputerChart = null;
                        }
                        $(DETAIL_TITLE_ID).text('Detail Sekolah Lab Komputer');
                        $(DETAIL_CONTAINER_ID).html('<div class="alert alert-info text-center mt-3"><i class="fas fa-info-circle me-2"></i> Tidak ada data detail yang dapat ditampilkan untuk kriteria ini.</div>');
                        return;
                    }

                    // Mapping warna untuk status 'Ada' (Hijau) dan 'Tidak Ada' (Merah/Abu-abu)
                    const colorsMap = {};
                    data.labels.forEach(label => {
                        colorsMap[label] = label === 'Ada' ? '#63e6be' : '#ff8787'; // Premium mint-green / coral-red
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
                            fontFamily: 'Inter, sans-serif',
                            toolbar: {
                                show: false
                            },
                            events: {
                                dataPointSelection: function(event, chartContext, config) {
                                    // Ambil label yang diklik (status lab: Ada/Tidak Ada)
                                    const selectedStatus = data.labels[config.dataPointIndex];
                                    loadLabKomputerDetail(kotaId, selectedStatus);
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
                        colors: seriesColors,
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function(val) {
                                    return val + " sekolah";
                                }
                            }
                        }
                    };

                    // Inisialisasi atau Update Chart
                    if (labKomputerChart) {
                        labKomputerChart.updateOptions(chartOptions);
                    } else {
                        $(CHART_ID).html(''); // Hapus loading
                        labKomputerChart = new ApexCharts(document.querySelector(CHART_ID), chartOptions);
                        labKomputerChart.render();
                    }

                    // Muat detail awal (Sekolah dengan status 'Ada', jika ada)
                    if (data.labels.length > 0) {
                        // Coba muat 'Ada' terlebih dahulu
                        const defaultStatus = data.labels.includes('Ada') ? 'Ada' : data.labels[0];
                        loadLabKomputerDetail(kotaId, defaultStatus);
                    } else {
                        $(DETAIL_TITLE_ID).text('Detail Sekolah Lab Komputer');
                        $(DETAIL_CONTAINER_ID).html(
                            '<div class="alert alert-info">Tidak ada data lab komputer yang tersedia untuk kriteria ini.</div>'
                        );
                    }

                })
                .fail(function(jqxhr, textStatus, error) {
                    const err = jqxhr.responseJSON?.error || textStatus + ", " + error;
                    console.error("Gagal memuat data chart lab komputer:", err);
                    $(CHART_ID).html(`<p class="text-center text-danger p-5">Gagal memuat data chart: ${err}</p>`);
                });
        }

        // ===================================================================
        // FUNGSI 2: MENGAMBIL DATA DETAIL DAN MERENDER TABEL
        // ===================================================================
        function loadLabKomputerDetail(kotaId, statusLab) {
            // Kita asumsikan statusLab adalah 'Ada' atau 'Tidak Ada'
            const url = `${API_URL_DETAIL}?kota_id=${kotaId}&status=${statusLab}`;

            if (detailDataTable) {
                detailDataTable.destroy();
                detailDataTable = null;
            }

            $(DETAIL_TITLE_ID).text(`Detail Sekolah: Loading status "${statusLab}"...`);
            $(DETAIL_CONTAINER_ID).html(
                '<p class="text-center text-muted p-4"><i class="fas fa-spinner fa-spin"></i> Memuat data detail sekolah...</p>'
            );

            $.getJSON(url)
                .done(function(dataSekolah) {
                    $(DETAIL_TITLE_ID).text(`Detail Sekolah dengan Status Lab Komputer: ${statusLab}`);

                    if (dataSekolah.length === 0) {
                        $(DETAIL_CONTAINER_ID).html(
                            '<div class="alert alert-warning">Tidak ada sekolah dengan kriteria tersebut.</div>'
                        );
                        return;
                    }

                    let tableHtml = `
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="detailTableLab">
                    <thead>
                        <tr>
                            <th>NPSN</th>
                            <th>Nama Sekolah</th>
                            <th>Tingkatan</th>
                            <th>Alamat</th>
                            <th>Detail Lab Komputer</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

                    dataSekolah.forEach(sekolah => {
                        let labHTML = "<ul>";

                        // === DETAIL LAB KOMPUTER (Asumsi properti lab_details dari API) ===
                        if (Array.isArray(sekolah.lab_details) && sekolah.lab_details.length > 0) {
                            sekolah.lab_details.forEach(detail => {
                                labHTML += `
                            <li>
                                <strong>${detail.nama_lab}</strong> 
                                ${detail.kapasitas ? `(Kapasitas: ${detail.kapasitas})` : ''}
                            </li>
                        `;
                            });
                        } else if (statusLab === 'Ada') {
                            labHTML +=
                                "<li>Detail lab tidak tercatat/kosong, namun status kepemilikan 'Ada'.</li>";
                        } else {
                            labHTML += "<li>Tidak memiliki Lab Komputer.</li>";
                        }

                        labHTML += "</ul>";

                        tableHtml += `
                        <tr>
                            <td>${sekolah.npsn ?? '-'}</td>
                            <td>${sekolah.nama ?? '-'}</td>
                            <td>${sekolah.tingkatan ?? '-'}</td>
                            <td>${sekolah.alamat ?? '-'}</td>
                            <td>${labHTML}</td>
                        </tr>
                    `;
                    });

                    tableHtml += `
                    </tbody>
                </table>
            </div>
        `;

                    $(DETAIL_CONTAINER_ID).html(tableHtml);

                    // Inisialisasi DataTables
                    detailDataTable = $('#detailTableLab').DataTable({
                        "pageLength": 10
                    });
                })
                .fail(function(jqxhr, textStatus, error) {
                    const err = jqxhr.responseJSON?.error || textStatus + ", " + error;
                    console.error("Error:", err);
                    $(DETAIL_CONTAINER_ID).html(
                        '<p class="text-danger p-4">Gagal memuat data detail sekolah.</p>'
                    );
                });
        }
    </script>


@endsection
