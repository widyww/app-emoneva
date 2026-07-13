@extends('layouts.navbar')
@section('title', 'Bobot Kriteria (AHP)')

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
                                Matriks perbandingan berpasangan skala Saaty &mdash; periode
                                <strong>{{ $periode->tahun }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header">Matriks Perbandingan Berpasangan</div>
                <div class="card-body">
                    <p class="text-muted small">
                        Isi hanya sel di atas diagonal (baris terhadap kolom). Sel di bawah diagonal otomatis
                        menjadi kebalikannya. Gunakan skala Saaty 1&ndash;9 (mis. <code>3</code>) atau pecahan desimal
                        (mis. <code>0.3333</code> untuk 1/3).
                    </p>

                    <form method="POST" action="{{ route('spk.ahp.hitung') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        @foreach ($kriteria as $k)
                                            <th title="{{ $k->nama }}">{{ $k->kode }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteria as $i => $baris)
                                        <tr>
                                            <th class="table-light" title="{{ $baris->nama }}">{{ $baris->kode }}</th>
                                            @foreach ($kriteria as $j => $kolom)
                                                @if ($i === $j)
                                                    <td class="text-muted">1</td>
                                                @elseif ($i < $j)
                                                    <td>
                                                        <input type="number" step="0.0001" min="0.11"
                                                            name="nilai[{{ $i }}][{{ $j }}]"
                                                            value="{{ optional($sel->get($baris->id . '-' . $kolom->id))->nilai ?? 1 }}"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                @else
                                                    <td class="text-muted small">1/({{ $kolom->kode }},{{ $baris->kode }})</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary">
                            <i class="me-1" data-feather="cpu"></i> Hitung Bobot
                        </button>
                    </form>
                </div>
            </div>

            @if ($ringkasan)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Hasil Pembobotan</span>
                        <span class="badge bg-{{ $ringkasan->konsisten ? 'success' : 'danger' }}">
                            {{ $ringkasan->konsisten ? 'Konsisten' : 'Tidak konsisten' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            &lambda;maks = <strong>{{ number_format($ringkasan->lambda_maks, 4) }}</strong> &nbsp;&middot;&nbsp;
                            CI = <strong>{{ number_format($ringkasan->ci, 4) }}</strong> &nbsp;&middot;&nbsp;
                            RI = <strong>{{ number_format($ringkasan->ri, 2) }}</strong> &nbsp;&middot;&nbsp;
                            CR = <strong>{{ number_format($ringkasan->cr, 4) }}</strong>
                            (syarat konsisten: CR &le; 0,10)
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kriteria</th>
                                        <th class="text-center" style="width: 140px;">Bobot (Wj)</th>
                                        <th class="text-center" style="width: 120px;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kriteria as $k)
                                        @php $w = (float) ($bobot[$k->id] ?? 0); @endphp
                                        <tr>
                                            <td>{{ $k->kode }} &mdash; {{ $k->nama }}</td>
                                            <td class="text-center">{{ number_format($w, 4) }}</td>
                                            <td class="text-center">{{ number_format($w * 100, 2) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted small mt-3 mb-0">
                            Terakhir dihitung: {{ optional($ringkasan->dihitung_pada)->format('d M Y H:i') ?? '-' }}.
                            Setelah bobot konsisten, Kepala Balai dapat menjalankan perangkingan SAW.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
