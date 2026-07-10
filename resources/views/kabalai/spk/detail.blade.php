@extends('layouts.navbar')
@section('title', 'Rincian Skor SPK')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="file-text"></i></div>
                                {{ $sekolah->nama ?? 'Detail Sekolah' }}
                            </h1>
                            <div class="page-header-subtitle">
                                Rincian perhitungan prioritas per kriteria (SAW)
                            </div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <a href="{{ route('spk.ranking') }}" class="btn btn-white text-primary">
                                <i class="me-1" data-feather="arrow-left"></i> Kembali ke Ranking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            @include('kabalai.spk.partial.flash')

            {{-- Ringkasan --}}
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="text-muted small text-uppercase">Peringkat</div>
                            <div class="display-5 fw-bold text-primary">{{ $hasil->peringkat }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="text-muted small text-uppercase">Skor Akhir (V)</div>
                            <div class="display-5 fw-bold">{{ number_format($hasil->skor, 4) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="text-muted small text-uppercase">Kategori</div>
                            @php
                                $badge = match ($hasil->kategori) {
                                    'tinggi' => 'bg-danger',
                                    'sedang' => 'bg-warning text-dark',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <div class="mt-2">
                                <span class="badge {{ $badge }} fs-5">{{ ucfirst($hasil->kategori) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rincian per kriteria --}}
            <div class="card mb-4">
                <div class="card-header">Kontribusi per Kriteria</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;">Kode</th>
                                    <th>Kriteria</th>
                                    <th class="text-center">Skor (1&ndash;5)</th>
                                    <th class="text-center">Bobot (w)</th>
                                    <th class="text-center">Normalisasi (r)</th>
                                    <th class="text-center">Kontribusi (w&times;r)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil->rincian ?? [] as $kode => $d)
                                    <tr>
                                        <td class="fw-bold">{{ $kode }}</td>
                                        <td>{{ $d['nama'] ?? $kode }}</td>
                                        <td class="text-center">{{ $d['skor'] }}</td>
                                        <td class="text-center">{{ number_format($d['bobot'], 4) }}</td>
                                        <td class="text-center">{{ number_format($d['normalisasi'], 4) }}</td>
                                        <td class="text-center">{{ number_format($d['kontribusi'], 5) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light fw-bold">
                                    <td colspan="5" class="text-end">Total Skor (V)</td>
                                    <td class="text-center">{{ number_format($hasil->skor, 5) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <p class="text-muted small mt-3 mb-0">
                        Skor 1&ndash;5 = skor kebutuhan (makin tinggi makin membutuhkan). Normalisasi benefit r = skor / skor
                        maksimum kolom. Dihitung pada
                        {{ optional($hasil->dihitung_pada)->format('d M Y H:i') ?? '-' }}.
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
