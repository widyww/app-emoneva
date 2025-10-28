@extends('layouts.navbar')
@section('title', 'Monitoring Data Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Monitoring Data Sekolah
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span>📊 Daftar Sekolah dan Jumlah Guru</span>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Filter Kecamatan -->
                        <select id="filterKecamatan" class="form-select form-select-sm" style="width: 200px">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatan as $kec)
                                <option value="{{ $kec->nama }}">{{ $kec->nama }}</option>
                            @endforeach
                        </select>

                        <!-- Filter Kota -->
                        <select id="filterKota" class="form-select form-select-sm" style="width: 200px">
                            <option value="">Semua Kota/Kabupaten</option>
                            @foreach ($kota as $k)
                                <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>

                        <!-- Tombol Print -->
                        <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                            <i data-feather="printer"></i> Print
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="tabel-sekolah">
                            <thead class="table text-center">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama Sekolah</th>
                                    <th>NPSN</th>
                                    <th>Kecamatan</th>
                                    <th>Kota/Kabupaten</th>
                                    <th>Jumlah Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalGuru = 0; @endphp
                                @foreach ($data as $index => $item)
                                    @php
                                        $jumlahGuru = $item->guru->count();
                                        $totalGuru += $jumlahGuru;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-center">{{ $item->npsn ?? '-' }}</td>
                                        <td>{{ $item->kecamatan->nama ?? '-' }}</td>
                                        <td>{{ $item->kecamatan->kota->nama ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $jumlahGuru }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if ($data->count() > 0)
                                <tfoot class="table-light fw-bold">
                                    <tr>
                                        <td colspan="5" class="text-end">Total Guru Seluruh Sekolah:</td>
                                        <td class="text-center">{{ $totalGuru }}</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#tabel-sekolah').DataTable({
                pageLength: 10,
                order: [
                    [1, 'asc']
                ]
            });

            feather.replace();

            // Filter berdasarkan Kecamatan
            $('#filterKecamatan').on('change', function() {
                let val = $(this).val();
                table.column(3).search(val).draw();
            });

            // Filter berdasarkan Kota/Kabupaten
            $('#filterKota').on('change', function() {
                let val = $(this).val();
                table.column(4).search(val).draw();
            });
        });
    </script>
@endsection
