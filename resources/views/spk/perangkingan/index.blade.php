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
                                Hasil perhitungan SPK (AHP-SAW) &mdash; periode
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
            
            <!-- QUICK LINKS / EXTENDS -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3 font-weight-bold text-primary">Lihat Grafik Statistik Sekolah (Ekstensi SPK)</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('sekolah.sort.akreditasi') }}" class="btn btn-outline-primary btn-sm"><i data-feather="pie-chart" class="me-1"></i> Akreditasi</a>
                                <a href="{{ route('sekolah.sort.bantuan') }}" class="btn btn-outline-primary btn-sm"><i data-feather="bar-chart-2" class="me-1"></i> Bantuan</a>
                                <a href="{{ route('sekolah.sort.labkomputer') }}" class="btn btn-outline-primary btn-sm"><i data-feather="monitor" class="me-1"></i> Lab Komputer</a>
                                <a href="{{ route('internet.sort') }}" class="btn btn-outline-primary btn-sm"><i data-feather="wifi" class="me-1"></i> Internet</a>
                                <a href="{{ route('listrik.index') }}" class="btn btn-outline-primary btn-sm"><i data-feather="zap" class="me-1"></i> Listrik</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if ($ringkasan)
            <!-- BOBOT KRITERIA (SAW) -->
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header bg-white font-weight-bold text-primary">Nilai Bobot Kriteria Akhir (SAW)</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>C1 (Ketersediaan komputer)</th>
                                            <th>C2 (Durasi/ketersediaan daya listrik)</th>
                                            <th>C3 (Kapasitas jaringan internet)</th>
                                            <th>C4 (Ketersediaan ruang laboratorium komputer)</th>
                                            <th>C5 (Riwayat penerimaan bantuan)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ number_format($ringkasan->bobot_kriteria['C1'] ?? 0, 4) }}</td>
                                            <td>{{ number_format($ringkasan->bobot_kriteria['C2'] ?? 0, 4) }}</td>
                                            <td>{{ number_format($ringkasan->bobot_kriteria['C3'] ?? 0, 4) }}</td>
                                            <td>{{ number_format($ringkasan->bobot_kriteria['C4'] ?? 0, 4) }}</td>
                                            <td>{{ number_format($ringkasan->bobot_kriteria['C5'] ?? 0, 4) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Prioritas Sekolah</span>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-success" onclick="window.print()">
                            <i data-feather="printer" class="me-1"></i> Cetak Laporan
                        </button>
                        @if ($ringkasan)
                            <span class="text-muted small ms-2">
                                CR = {{ number_format($ringkasan->cr, 4) }}
                                <span class="badge bg-{{ $ringkasan->konsisten ? 'success' : 'danger' }}">
                                    {{ $ringkasan->konsisten ? 'Konsisten' : 'Tidak konsisten' }}
                                </span>
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- FILTER SECTION -->
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('spk.rank.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label class="visually-hidden">Kabupaten/Kota</label>
                            <select name="kota_id" id="kota_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">-- Semua Kabupaten/Kota --</option>
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota->id }}" {{ isset($kota_id) && $kota_id == $kota->id ? 'selected' : '' }}>
                                        {{ $kota->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="visually-hidden">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">-- Semua Kecamatan --</option>
                                @if(isset($kecamatans))
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ isset($kecamatan_id) && $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                            {{ $kecamatan->nama }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('spk.rank.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
                
                <div class="card-body" id="printArea">
                    @if ($hasil->isEmpty())
                        <div class="alert alert-info mb-0">
                            Belum ada hasil perangkingan untuk periode/filter ini. Klik
                            <strong>Hitung Ulang Perangkingan</strong> untuk memulai, atau sesuaikan filter.
                        </div>
                    @else
                        <div class="text-center d-none d-print-block mb-4">
                            <h4>LAPORAN HASIL PRIORITAS BANTUAN TIK</h4>
                            <p>Periode: {{ $periode->tahun }}</p>
                            @if(isset($kota_id) && $kota_id)
                                <p>Filter: {{ $kotas->where('id', $kota_id)->first()->nama ?? '' }} 
                                {{ isset($kecamatan_id) && $kecamatan_id ? ' - ' . ($kecamatans->where('id', $kecamatan_id)->first()->nama ?? '') : '' }}
                                </p>
                            @endif
                        </div>
                    
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
                                        <th class="text-center d-print-none" style="width: 100px;">Aksi</th>
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
                                            <td class="text-center d-print-none">
                                                <button class="btn btn-sm btn-info text-white" 
                                                    onclick="showDetail({{ json_encode($h->sekolah) }})" title="Lihat Detail">
                                                    <i data-feather="eye"></i>
                                                </button>
                                            </td>
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
        
        <!-- Modal Detail Sekolah -->
        <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalDetailTitle">Detail Data Sekolah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                 <table class="table table-bordered">
                    <tr><th width="30%">Nama Sekolah</th><td id="d_nama"></td></tr>
                    <tr><th>NPSN</th><td id="d_npsn"></td></tr>
                    <tr><th>Tingkatan</th><td id="d_tingkatan"></td></tr>
                    <tr><th>Alamat</th><td id="d_alamat"></td></tr>
                    <tr><th>Status Akreditasi</th><td id="d_akreditasi"></td></tr>
                    <tr><th>Total Siswa</th><td id="d_siswa"></td></tr>
                    <tr><th>Email</th><td id="d_email"></td></tr>
                 </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
        
    </main>
@endsection

@section('scripts')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printArea, #printArea * {
        visibility: visible;
    }
    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
<script>
function showDetail(sekolah) {
    if(!sekolah) return;
    document.getElementById('d_nama').textContent = sekolah.nama || '-';
    document.getElementById('d_npsn').textContent = sekolah.npsn || '-';
    document.getElementById('d_tingkatan').textContent = sekolah.tingkatan || '-';
    document.getElementById('d_alamat').textContent = sekolah.alamat || '-';
    document.getElementById('d_akreditasi').textContent = sekolah.status_akreditasi || 'Belum Terakreditasi';
    
    let totalSiswa = (parseInt(sekolah.jum_siswa_pria) || 0) + (parseInt(sekolah.jum_siswa_wanita) || 0);
    document.getElementById('d_siswa').textContent = totalSiswa;
    document.getElementById('d_email').textContent = sekolah.email || '-';
    
    var myModal = new bootstrap.Modal(document.getElementById('modalDetail'));
    myModal.show();
}
</script>
@endsection
