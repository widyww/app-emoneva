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

                    {{-- TABEL DATA --}}
                    <div id="detail-table-container">
                        <p class="text-muted">Pilih Kabupaten/Kota untuk menampilkan data guru dan pelatihan.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let detailTable = null;
        const API_DETAIL = "{{ route('sortgurupelatihan.getdata') }}";

        $(document).ready(function() {
            $('#kota-select').change(function() {
                loadData($(this).val());
            });
        });

        function loadData(kotaId = '') {
            $('#detail-table-container').html(
                '<p class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Memuat data...</p>');

            $.getJSON(`${API_DETAIL}?kota_id=${kotaId}`, function(list) {

                if (!list.length) {
                    $('#detail-table-container').html(
                        '<div class="alert alert-warning">Tidak ada data guru di kabupaten/kota ini.</div>');
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
            });
        }
    </script>
@endsection
