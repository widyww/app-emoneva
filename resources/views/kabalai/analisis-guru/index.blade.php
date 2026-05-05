@extends('layouts.navbar')
@section('title', 'Hasil Analisis Guru')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Hasil Analisis Guru
                    </h1>
                    <div class="page-header-subtitle">Klasifikasi jawaban kebutuhan pelatihan guru ke kategori baku dengan Random Forest.</div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Filter Analisis</div>
                <div class="card-body">
                    <div class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label">Pilih Kabupaten/Kota</label>
                            <select id="kota-select" class="form-select">
                                <option value="">Semua Kabupaten/Kota</option>
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <button id="btn-analyze" class="btn btn-primary" type="button">
                                <i data-feather="refresh-cw" class="me-1"></i>
                                Analisis
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="analysis-alert"></div>

            <div class="row g-4 mb-4">
                <div class="col-xl-2 col-md-4">
                    <div class="card border-start-lg border-start-primary h-100">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Jawaban</div>
                            <div class="h3 mb-0" id="total-needs">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card border-start-lg border-start-warning h-100">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Total Guru</div>
                            <div class="h3 mb-0" id="total-guru">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card border-start-lg border-start-success h-100">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Jumlah Kategori</div>
                            <div class="h3 mb-0" id="total-categories">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card border-start-lg border-start-danger h-100">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">Belum Terkategori</div>
                            <div class="h3 mb-0" id="uncategorized">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card border-start-lg border-start-info h-100">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Engine</div>
                            <div class="h6 mb-0" id="engine-label">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card border-start-lg border-start-secondary h-100">
                        <div class="card-body">
                            <div class="text-xs fw-bold text-secondary text-uppercase mb-1">Dominan</div>
                            <div class="h6 mb-0" id="dominant-category">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-xl-6">
                    <div class="card h-100">
                        <div class="card-header">Kata/N-gram Paling Berpengaruh</div>
                        <div class="card-body">
                            <div id="feature-chart">
                                <p class="text-muted">Jalankan analisis untuk melihat kata yang paling memengaruhi klasifikasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card h-100">
                        <div class="card-header">Kategori Kebutuhan Pelatihan</div>
                        <div class="card-body">
                            <div id="needs-chart">
                                <p class="text-muted">Jalankan analisis untuk melihat kelompok kebutuhan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Hasil Klasifikasi Jawaban Guru</div>
                <div class="card-body">
                    <div id="detail-table-container">
                        <p class="text-muted">Klik tombol Analisis untuk menampilkan hasil.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const API_ANALYSIS = "{{ route('analisisguru.getdata') }}";
        let featureChart = null;
        let needsChart = null;
        let detailTable = null;

        $(document).ready(function() {
            $('#btn-analyze').on('click', function() {
                loadAnalysis($('#kota-select').val());
            });

            loadAnalysis('');
        });

        function escapeHtml(value) {
            return $('<div>').text(value ?? '-').html();
        }

        function setSummary(summary) {
            $('#total-needs').text(summary.total ?? 0);
            $('#total-guru').text(summary.total_guru ?? 0);
            $('#total-categories').text(summary.total_categories ?? 0);
            $('#uncategorized').text(summary.uncategorized ?? 0);
            $('#dominant-category').text(summary.dominant_category ?? '-');
        }

        function renderBarChart(selector, instance, labels, series, colors) {
            if (instance) {
                instance.destroy();
            }

            if (!labels.length) {
                $(selector).html('<p class="text-muted">Belum ada data yang cukup untuk ditampilkan.</p>');
                return null;
            }

            $(selector).html('');

            const chart = new ApexCharts(document.querySelector(selector), {
                series: [{
                    name: 'Jumlah',
                    data: series
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                colors: colors,
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        horizontal: true
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: labels
                }
            });

            chart.render();
            return chart;
        }

        function renderAnalysis(data) {
            const accuracyText = data.accuracy !== null && data.accuracy !== undefined ?
                ` Akurasi uji: ${(data.accuracy * 100).toFixed(1)}%.` :
                '';
            const alertClass = data.engine === 'random_forest' ? 'alert-success' : 'alert-warning';

            $('#analysis-alert').html(`
                <div class="alert ${alertClass}">
                    <strong>${data.engine === 'random_forest' ? 'Random Forest aktif.' : 'Klasifikasi kata kunci aktif.'}</strong>
                    ${escapeHtml(data.message)}${accuracyText}
                </div>
            `);

            setSummary(data.summary || {});
            $('#engine-label').text(data.engine === 'random_forest' ? 'Random Forest' : 'Keyword');

            featureChart = renderBarChart(
                '#feature-chart',
                featureChart,
                (data.feature_importance || []).map(item => item.label),
                (data.feature_importance || []).map(item => Number((item.value * 1000).toFixed(2))),
                ['#0d6efd']
            );

            needsChart = renderBarChart(
                '#needs-chart',
                needsChart,
                (data.top_needs || []).map(item => item.name),
                (data.top_needs || []).map(item => item.count),
                ['#198754']
            );

            renderTable(data.rows || []);
        }

        function renderTable(rows) {
            if (detailTable) {
                detailTable.destroy();
                detailTable = null;
            }

            if (!rows.length) {
                $('#detail-table-container').html('<div class="alert alert-warning">Belum ada data kebutuhan pelatihan guru untuk dianalisis.</div>');
                return;
            }

            let html = `
                <div class="table-responsive">
                    <table id="analysisTable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Sekolah</th>
                                <th>Kota</th>
                                <th>Mapel</th>
                                <th>Jawaban Kebutuhan</th>
                                <th>Kategori</th>
                                <th>Confidence</th>
                                <th>Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            rows.forEach(row => {
                const badgeClass = row.category === 'Lainnya' ? 'bg-secondary' : 'bg-primary';
                html += `
                    <tr>
                        <td>${escapeHtml(row.nama)}</td>
                        <td>${escapeHtml(row.sekolah)}</td>
                        <td>${escapeHtml(row.kota)}</td>
                        <td>${escapeHtml(row.mapel)}</td>
                        <td>${escapeHtml(row.kebutuhan)}</td>
                        <td><span class="badge ${badgeClass}">${escapeHtml(row.category)}</span></td>
                        <td>${Number(row.confidence * 100).toFixed(1)}%</td>
                        <td>${escapeHtml(row.recommendation)}</td>
                    </tr>
                `;
            });

            html += '</tbody></table></div>';
            $('#detail-table-container').html(html);
            detailTable = $('#analysisTable').DataTable({
                pageLength: 10,
                order: [[6, 'desc']]
            });
        }

        function loadAnalysis(kotaId = '') {
            $('#btn-analyze').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menganalisis');
            $('#analysis-alert').html('');
            $('#detail-table-container').html('<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memproses analisis...</p>');

            $.getJSON(`${API_ANALYSIS}?kota_id=${kotaId}`)
                .done(renderAnalysis)
                .fail(function(xhr) {
                    const response = xhr.responseJSON || {};
                    $('#analysis-alert').html(`
                        <div class="alert alert-danger">
                            <strong>Analisis gagal.</strong> ${escapeHtml(response.error || 'Terjadi kesalahan saat mengambil data.')}
                            ${response.detail ? `<div class="small mt-2">${escapeHtml(response.detail)}</div>` : ''}
                        </div>
                    `);
                })
                .always(function() {
                    $('#btn-analyze').prop('disabled', false).html('<i data-feather="refresh-cw" class="me-1"></i> Analisis');
                    feather.replace();
                });
        }
    </script>
@endsection
