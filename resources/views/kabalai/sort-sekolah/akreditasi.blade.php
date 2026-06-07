@extends('layouts.navbar')
@section('title', 'Statistik Status Akreditasi Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="bar-chart-2"></i></div>
                                Statistik Akreditasi Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Diagram Statistik Akreditasi Sekolah berdasarkan Kota/Kabupaten
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
                                {{-- Pastikan Controller mengirimkan $kotas (jamak) --}}
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- 2. CONTAINER CHART --}}
                    <div id="akreditasi-chart" class="mb-5">
                        <p class="text-center text-muted p-5"><i class="fas fa-spinner fa-spin"></i> Memuat Chart...</p>
                    </div>

                    <hr class="my-4">

                    {{-- 3. CONTAINER DETAIL TABEL --}}
                    <h4 class="mb-3" id="detail-title">Detail Sekolah Berdasarkan Akreditasi (Klik pada Bar Chart)</h4>
                    <div id="sekolah-detail-table-container">
                        <p class="text-muted">Pilih status akreditasi dari bar chart di atas untuk menampilkan detail
                            sekolah di sini.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    {{-- Memuat Font Awesome (untuk ikon loading) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    {{-- SweetAlert, jQuery, dan DataTables (Sudah ada di template Anda) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- Memuat Library ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Variabel untuk menampung instance chart
        let akreditasiChart;

        // Ambil URL API dari route helper Laravel
        const API_URL_CHART = "{{ route('sekolah.getakreditasidata') }}";
        const API_URL_DETAIL = "{{ route('sekolah.getdetail') }}";

        // Ketika dokumen siap (jQuery)
        $(document).ready(function() {
            // Panggil fungsi untuk memuat data chart awal
            fetchAndRenderChart($('#kota-select').val());

            // Tambahkan event listener untuk perubahan dropdown
            $('#kota-select').on('change', function() {
                const selectedKotaId = $(this).val();
                fetchAndRenderChart(selectedKotaId);

                // Kosongkan detail saat filter kota berubah
                $('#sekolah-detail-table-container').html(
                    '<p class="text-muted">Pilih status akreditasi dari bar chart di atas untuk menampilkan detail sekolah di sini.</p>'
                );
                $('#detail-title').text('Detail Sekolah Berdasarkan Akreditasi (Klik pada Bar Chart)');
            });
        });

        // ===================================================================
        // FUNGSI 1: MENGAMBIL DATA DAN MERENDER CHART
        // ===================================================================
        async function fetchAndRenderChart(kotaId) {
            const apiUrl = `${API_URL_CHART}?kota_id=${kotaId}`;

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                renderAkreditasiChart(data.labels, data.series);

            } catch (error) {
                console.error("Gagal mengambil data akreditasi:", error);
            }
        }

        // FUNGSI RENDER/UPDATE CHART APEXCHARTS
        function renderAkreditasiChart(labels, series) {
            const colors = ['#4c6ef5', '#63e6be', '#ffc078', '#ff8787']; // Premium Indigo, Mint-green, Orange, Coral-red

            const chartOptions = {
                chart: {
                    type: 'bar',
                    height: 400,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false
                    },
                    // FUNGSI PENTING: MENGAMBIL DATA SAAT BAR DIKLIK
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            const dataIndex = config.dataPointIndex;
                            if (dataIndex !== undefined && dataIndex > -1) {
                                // Ambil kategori (status akreditasi) yang diklik
                                const akreditasiStatus = labels[dataIndex];

                                // Panggil fungsi untuk memuat detail tabel
                                loadSekolahDetail(akreditasiStatus);
                            }
                        }
                    }
                },
                series: [{
                    name: 'Jumlah Sekolah',
                    data: series
                }],
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4
                },
                xaxis: {
                    categories: labels,
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
                        },
                        formatter: function(val) {
                            return parseInt(val);
                        }
                    }
                },
                colors: colors,
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 8,
                        distributed: true
                    },
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

            if (akreditasiChart) {
                // Update penuh karena opsi events berubah
                akreditasiChart.updateOptions(chartOptions);
            } else {
                document.querySelector("#akreditasi-chart").innerHTML = ''; // Hapus loading
                akreditasiChart = new ApexCharts(document.querySelector("#akreditasi-chart"), chartOptions);
                akreditasiChart.render();
            }
        }

        // ===================================================================
        // FUNGSI 2: MENGAMBIL DATA DETAIL DAN MERENDER TABEL
        // ===================================================================
        async function loadSekolahDetail(akreditasiStatus) {
            const selectedKotaId = $('#kota-select').val();
            const apiUrl = `${API_URL_DETAIL}?kota_id=${selectedKotaId}&akreditasi=${akreditasiStatus}`;
            const container = $('#sekolah-detail-table-container');

            // Hapus dan Hancurkan DataTable lama
            if ($.fn.DataTable.isDataTable('#detailTable')) {
                $('#detailTable').DataTable().destroy();
            }

            // Tampilkan loading state
            container.html('<p class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat data sekolah...</p>');
            $('#detail-title').text(`Detail Sekolah dengan Status Akreditasi: ${akreditasiStatus}`);

            try {
                const response = await fetch(apiUrl);
                const dataSekolah = await response.json();

                if (dataSekolah.length === 0) {
                    container.html(
                        '<div class="alert alert-warning">Tidak ada sekolah yang ditemukan dengan kriteria tersebut.</div>'
                    );
                    return;
                }

                // BUILD TABEL HTML SECARA DINAMIS
                let tableHtml = `
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="detailTable">
                            <thead>
                                <tr>
                                    <th>NPSN</th>
                                    <th>Nama Sekolah</th>
                                    <th>Tingkatan</th>
                                    <th>Status Akreditasi</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                // Iterasi data sekolah dari JSON
                dataSekolah.forEach(sekolah => {
                    tableHtml += `
                        <tr>
                            <td>${sekolah.npsn}</td>
                            <td>${sekolah.nama}</td>
                            <td>${sekolah.tingkatan}</td>
                            <td><span class="badge bg-primary">${sekolah.status_akreditasi}</span></td>
                            <td>${sekolah.alamat}</td>
                        </tr>
                    `;
                });

                tableHtml += `
                            </tbody>
                        </table>
                    </div>
                `;

                // Sisipkan HTML yang sudah dibuat
                container.html(tableHtml);

                // Inisialisasi DataTables pada tabel baru
                $('#detailTable').DataTable();

            } catch (error) {
                console.error("Gagal memuat detail sekolah:", error);
                container.html('<p class="text-danger">Gagal memuat detail data. (Cek console log)</p>');
            }
        }
    </script>

@endsection
