@extends('layouts.navbar')
@section('title', 'Data Guru Saya')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Data Guru Saya
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Data Guru</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            @if ($guru)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Data Pribadi</span>
                        @if ($guru->status_verifikasi != 1)
                            <a href="{{ route('guru-data.edit', $guru->id) }}" class="btn btn-warning btn-sm">
                                <i data-feather="edit"></i> Edit Data
                            </a>
                        @else
                            <span class="badge bg-success"><i data-feather="lock"></i> Data Terverifikasi</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><th width="40%">Nama</th><td>{{ $guru->nama ?? '-' }}</td></tr>
                                    <tr><th>NIP</th><td>{{ $guru->nip ?? '-' }}</td></tr>
                                    <tr><th>NUPTK</th><td>{{ $guru->nuptk ?? '-' }}</td></tr>
                                    <tr><th>Status</th><td>{{ $guru->status ?? '-' }}</td></tr>
                                    <tr><th>Tempat Lahir</th><td>{{ $guru->tempat ?? '-' }}</td></tr>
                                    <tr><th>Tanggal Lahir</th><td>{{ $guru->tgl_lahir ? \Carbon\Carbon::parse($guru->tgl_lahir)->format('d-m-Y') : '-' }}</td></tr>
                                    <tr><th>Agama</th><td>{{ $guru->agama ?? '-' }}</td></tr>
                                    <tr><th>Jenis Kelamin</th><td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-Laki' : ($guru->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><th width="40%">Pendidikan Terakhir</th><td>{{ $guru->pendidikan_terakhir ?? '-' }}</td></tr>
                                    <tr><th>TMT PNS</th><td>{{ $guru->tmt_pns_tahun ? \Carbon\Carbon::parse($guru->tmt_pns_tahun)->format('d-m-Y') : '-' }}</td></tr>
                                    <tr><th>Telepon</th><td>{{ $guru->telepon ?? '-' }}</td></tr>
                                    <tr><th>Mata Pelajaran</th><td>{{ $guru->mapel ?? '-' }}</td></tr>
                                    <tr><th>Sertifikasi</th><td>{{ $guru->sertifikasi_status ?? '-' }}</td></tr>
                                    <tr><th>Tahun Sertifikasi</th><td>{{ $guru->sertifikasi_tahun ?? '-' }}</td></tr>
                                    <tr><th>Asal Sekolah</th><td>{{ $guru->sekolah->nama ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>

                        <!-- Status Verifikasi -->
                        <div class="mt-3">
                            <strong>Status Verifikasi:</strong>
                            @switch($guru->status_verifikasi)
                                @case(0)
                                    <span class="badge bg-warning d-inline-flex align-items-center">
                                        <i data-feather="clock" class="me-1"></i> Menunggu Verifikasi
                                    </span>
                                @break
                                @case(1)
                                    <span class="badge bg-success d-inline-flex align-items-center">
                                        <i data-feather="check-circle" class="me-1"></i> Terverifikasi
                                    </span>
                                @break
                                @case(2)
                                    <span class="badge bg-danger d-inline-flex align-items-center">
                                        <i data-feather="x-circle" class="me-1"></i> Ditolak
                                    </span>
                                @break
                                @case(3)
                                    <span class="badge bg-primary d-inline-flex align-items-center">
                                        <i data-feather="edit" class="me-1"></i> Revisi
                                    </span>
                                @break
                                @default
                                    <span class="badge bg-secondary">-</span>
                            @endswitch

                            @if ($guru->catatan_verifikasi)
                                <div class="alert alert-info mt-2">
                                    <strong>Catatan:</strong> {{ $guru->catatan_verifikasi }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kompetensi -->
                <div class="card mb-4">
                    <div class="card-header">Kompetensi Kemampuan</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    @php
                                        $levelMap = [0 => 'Tidak Memiliki', 1 => 'Dasar', 2 => 'Menengah', 3 => 'Mahir'];
                                    @endphp
                                    <tr><th width="50%">Microsoft Word</th><td>{{ $levelMap[$guru->kompetensi_word] ?? '-' }}</td></tr>
                                    <tr><th>Microsoft Excel</th><td>{{ $levelMap[$guru->kompetensi_excel] ?? '-' }}</td></tr>
                                    <tr><th>Jaringan Komputer</th><td>{{ $levelMap[$guru->kompetensi_jaringan] ?? '-' }}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr><th width="50%">Microsoft PowerPoint</th><td>{{ $levelMap[$guru->kompetensi_powerpoin] ?? '-' }}</td></tr>
                                    <tr><th>Pemrogramman</th><td>{{ $levelMap[$guru->kompetensi_pemrogramman] ?? '-' }}</td></tr>
                                    <tr><th>Multimedia</th><td>{{ $levelMap[$guru->kompetensi_multimedia] ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pelatihan -->
                @if ($guru->pelatihan && $guru->pelatihan->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">Riwayat Pelatihan</div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelatihan</th>
                                        <th>Tingkatan</th>
                                        <th>Level</th>
                                        <th>Tahun</th>
                                        <th>Jumlah Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guru->pelatihan as $i => $p)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $p->nama_pelatihan }}</td>
                                            <td>{{ $p->tingkatan }}</td>
                                            <td>{{ $p->level }}</td>
                                            <td>{{ $p->tahun_pelatihan }}</td>
                                            <td>{{ $p->jam_pelatihan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Kebutuhan Pelatihan -->
                @if ($guru->kebutuhanPelatihan && $guru->kebutuhanPelatihan->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">Kebutuhan Pelatihan</div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($guru->kebutuhanPelatihan as $k)
                                    <li class="list-group-item">{{ $k->nama_pelatihan }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i data-feather="alert-circle" class="text-warning mb-3" style="width: 48px; height: 48px;"></i>
                        <h4>Data guru belum diisi</h4>
                        <p class="text-muted">Silakan lengkapi data guru Anda.</p>
                        <a href="{{ route('guru-data.create') }}" class="btn btn-primary">
                            <i data-feather="plus-circle"></i> Input Data Guru
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection
