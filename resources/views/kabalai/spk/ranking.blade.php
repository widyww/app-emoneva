@extends('layouts.navbar')
@section('title', 'Ranking Prioritas Bantuan TIK')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="award"></i></div>
                                Ranking Prioritas Bantuan TIK
                            </h1>
                            <div class="page-header-subtitle">
                                Hasil perhitungan SPK (AHP + SAW) untuk sekolah terverifikasi
                            </div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <form action="{{ route('spk.hitung') }}" method="POST"
                                onsubmit="return confirm('Jalankan perhitungan prioritas untuk periode aktif? Hasil sebelumnya akan diperbarui.');">
                                @csrf
                                <button type="submit" class="btn btn-white text-primary">
                                    <i class="me-1" data-feather="cpu"></i> Hitung Prioritas
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            @include('kabalai.spk.partial.flash')

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Prioritas Sekolah</span>
                    <span class="text-muted small">
                        Periode aktif:
                        <strong>{{ $periode->tahun ?? 'Belum ada periode aktif' }}</strong>
                    </span>
                </div>
                <div class="card-body">
                    @if (!$periode)
                        <div class="alert alert-warning mb-0">
                            Belum ada periode aktif. Aktifkan satu periode terlebih dahulu sebelum menjalankan SPK.
                        </div>
                    @elseif ($hasil->isEmpty())
                        <div class="alert alert-info mb-0">
                            Belum ada hasil perhitungan untuk periode ini. Klik <strong>Hitung Prioritas</strong> untuk memulai.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Peringkat</th>
                                        <th>Nama Sekolah</th>
                                        <th>NPSN</th>
                                        <th class="text-center" style="width: 120px;">Skor (V)</th>
                                        <th class="text-center" style="width: 120px;">Kategori</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasil as $row)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $row->peringkat }}</td>
                                            <td>{{ $row->sekolah->nama ?? '-' }}</td>
                                            <td>{{ $row->sekolah->npsn ?? '-' }}</td>
                                            <td class="text-center">{{ number_format($row->skor, 4) }}</td>
                                            <td class="text-center">
                                                @php
                                                    $badge = match ($row->kategori) {
                                                        'tinggi' => 'bg-danger',
                                                        'sedang' => 'bg-warning text-dark',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badge }}">{{ ucfirst($row->kategori) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('spk.detail', $row->sekolah_id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted small mt-3 mb-0">
                            Kategori: <span class="badge bg-danger">Tinggi</span> V &ge; 0.70 &nbsp;
                            <span class="badge bg-warning text-dark">Sedang</span> 0.40&ndash;0.69 &nbsp;
                            <span class="badge bg-secondary">Rendah</span> &lt; 0.40.
                            Skor V hasil metode SAW dengan bobot kriteria dari AHP.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
