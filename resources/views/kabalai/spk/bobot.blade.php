@extends('layouts.navbar')
@section('title', 'Bobot Kriteria (AHP)')

@php
    $kriteria = $kriteria->values();
    $n = $kriteria->count();
    // Opsi skala Saaty: nilai i-vs-j (>1 = i lebih penting, <1 = j lebih penting)
    $opsiSaaty = [
        '1/9' => '1/9 — kolom mutlak lebih penting',
        '1/7' => '1/7 — kolom jauh lebih penting',
        '1/5' => '1/5 — kolom lebih penting',
        '1/3' => '1/3 — kolom sedikit lebih penting',
        '1'   => '1 — sama penting',
        '3'   => '3 — baris sedikit lebih penting',
        '5'   => '5 — baris lebih penting',
        '7'   => '7 — baris jauh lebih penting',
        '9'   => '9 — baris mutlak lebih penting',
    ];
@endphp

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="sliders"></i></div>
                                Bobot Kriteria (AHP)
                            </h1>
                            <div class="page-header-subtitle">
                                Tentukan bobot kriteria melalui perbandingan berpasangan
                            </div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">
                            <a href="{{ route('spk.ranking') }}" class="btn btn-white text-primary">
                                <i class="me-1" data-feather="award"></i> Lihat Ranking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            @include('kabalai.spk.partial.flash')

            {{-- Bobot saat ini --}}
            <div class="card mb-4">
                <div class="card-header">Bobot Kriteria Saat Ini</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70px;">Kode</th>
                                    <th>Kriteria</th>
                                    <th class="text-center" style="width: 140px;">Bobot</th>
                                    <th class="text-center" style="width: 100px;">Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $k)
                                    <tr>
                                        <td class="fw-bold">{{ $k->kode }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td class="text-center">{{ number_format($k->bobot, 4) }}</td>
                                        <td class="text-center">
                                            @if ($k->aktif)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light fw-bold">
                                    <td colspan="2" class="text-end">Total</td>
                                    <td class="text-center">{{ number_format($kriteria->sum('bobot'), 4) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Form perbandingan berpasangan --}}
            <div class="card mb-4">
                <div class="card-header">Perbandingan Berpasangan (Skala Saaty 1&ndash;9)</div>
                <div class="card-body">
                    @if ($n < 2)
                        <div class="alert alert-warning mb-0">
                            Minimal 2 kriteria diperlukan untuk melakukan perbandingan AHP.
                        </div>
                    @else
                        <p class="text-muted">
                            Untuk setiap pasangan, pilih seberapa penting kriteria <strong>baris</strong> dibanding kriteria
                            <strong>kolom</strong>. Bobot akan dihitung otomatis dan hanya disimpan jika
                            <strong>Consistency Ratio (CR) &le; 10%</strong>.
                        </p>
                        <form action="{{ route('spk.bobot.simpan') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kriteria (baris)</th>
                                            <th>Kriteria (kolom)</th>
                                            <th style="width: 320px;">Tingkat Kepentingan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < $n; $i++)
                                            @for ($j = $i + 1; $j < $n; $j++)
                                                <tr>
                                                    <td>{{ $kriteria[$i]->kode }} — {{ $kriteria[$i]->nama }}</td>
                                                    <td>{{ $kriteria[$j]->kode }} — {{ $kriteria[$j]->nama }}</td>
                                                    <td>
                                                        <select name="nilai[{{ $i }}][{{ $j }}]" class="form-select">
                                                            @foreach ($opsiSaaty as $val => $label)
                                                                <option value="{{ $val }}" @selected($val === '1')>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endfor
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="me-1" data-feather="save"></i> Hitung &amp; Simpan Bobot
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
