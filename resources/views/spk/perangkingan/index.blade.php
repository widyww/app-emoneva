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
                                Hasil perhitungan SAW dengan bobot AHP &mdash; periode
                                <strong>{{ $periode->tahun }}</strong>
                            </div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <form action="{{ route('spk.rank.hitung') }}" method="POST"
                                onsubmit="return confirm('Jalankan perangkingan untuk periode aktif? Hasil sebelumnya akan diperbarui.');">
                                @csrf
                                <button type="submit" class="btn btn-white text-primary">
                                    <i class="me-1" data-feather="cpu"></i> Hitung Ulang Perangkingan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            @if (!$ringkasan)
                <div class="alert alert-warning">
                    Bobot AHP untuk periode ini belum dihitung. Minta Administrator mengisi matriks AHP terlebih dahulu.
                </div>
            @elseif (!$ringkasan->konsisten)
                <div class="alert alert-danger">
                    Bobot AHP belum konsisten (CR = {{ number_format($ringkasan->cr, 4) }} &gt; 0,10).
                    Perbaiki penilaian sebelum menjalankan perangkingan.
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Prioritas Sekolah</span>
                    @if ($ringkasan)
                        <span class="text-muted small">
                            CR = {{ number_format($ringkasan->cr, 4) }}
                            <span class="badge bg-{{ $ringkasan->konsisten ? 'success' : 'danger' }}">
                                {{ $ringkasan->konsisten ? 'Konsisten' : 'Tidak konsisten' }}
                            </span>
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    @if ($hasil->isEmpty())
                        <div class="alert alert-info mb-0">
                            Belum ada hasil perangkingan untuk periode ini. Klik
                            <strong>Hitung Ulang Perangkingan</strong> untuk memulai.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Peringkat</th>
                                        <th>Nama Sekolah</th>
                                        <th class="text-center">C1</th>
                                        <th class="text-center">C2</th>
                                        <th class="text-center">C3</th>
                                        <th class="text-center">C4</th>
                                        <th class="text-center">C5</th>
                                        <th class="text-center" style="width: 120px;">Nilai V</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hasil as $h)
                                        <tr @class(['table-warning' => $h->peringkat <= 10])>
                                            <td class="text-center fw-bold">{{ $h->peringkat }}</td>
                                            <td>{{ $h->sekolah->nama ?? '-' }}</td>
                                            <td class="text-center">{{ $h->skor['C1'] ?? '-' }}</td>
                                            <td class="text-center">{{ $h->skor['C2'] ?? '-' }}</td>
                                            <td class="text-center">{{ $h->skor['C3'] ?? '-' }}</td>
                                            <td class="text-center">{{ $h->skor['C4'] ?? '-' }}</td>
                                            <td class="text-center">{{ $h->skor['C5'] ?? '-' }}</td>
                                            <td class="text-center">{{ number_format($h->nilai_vi, 4) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted small mt-3 mb-0">
                            Baris tersorot = 10 sekolah prioritas teratas penerima bantuan.
                            Skor C1&ndash;C5 adalah skor kebutuhan (1&ndash;5); V dihitung dengan SAW.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
