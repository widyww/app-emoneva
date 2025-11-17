@extends('layouts.navbar')
@section('title', 'Verifikator Detail Data Guru')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Detail Data Guru
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4"> Verifikasi Data Guru</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab"
                        role="tablist">
                        <!-- Step 1 -->
                        <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-bs-toggle="tab"
                            role="tab">
                            <div class="wizard-step-icon">1</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Identitas Guru</div>
                            </div>
                        </a>
                        <!-- Step 2 -->
                        <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">2</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Pelatihan Diikuti</div>
                            </div>
                        </a>
                        <!-- Step 3 -->
                        <a class="nav-item nav-link" id="wizard3-tab" href="#wizard3" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">3</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Kebutuhan Pelatihan</div>
                            </div>
                        </a>
                        <!-- Step 4 -->
                        <a class="nav-item nav-link" id="wizard4-tab" href="#wizard4" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">4</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Verifikasi Data</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="cardTabContent">
                        <!-- Step 1 -->
                        <div class="tab-pane py-5 fade show active" id="wizard1" role="tabpanel">
                            <div class="row">

                                {{-- Kolom Kiri: Identitas Guru --}}
                                <div class="col-md-6">
                                    <h5 class="mb-4">Identitas Guru</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $guru->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status PNS/PPPK</th>
                                            <td>{{ $guru->status }}</td>
                                        </tr>
                                        <tr>
                                            <th>NUPTK</th>
                                            <td>{{ $guru->nuptk ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIP</th>
                                            <td>{{ $guru->nip ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <td>{{ $guru->tempat }},
                                                {{ \Carbon\Carbon::parse($guru->tgl_lahir)->translatedFormat('j F Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Agama</th>
                                            <td>{{ $guru->agama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ ucfirst($guru->jenis_kelamin) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pendidikan Terakhir</th>
                                            <td>{{ $guru->pendidikan_terakhir }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mapel</th>
                                            <td>{{ $guru->mapel ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sekolah</th>
                                            <td>{{ $guru->sekolah->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <td>{{ $guru->sekolah->kecamatan->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kota/Kabupaten</th>
                                            <td>{{ $guru->sekolah->kecamatan->kota->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Sertifikasi</th>
                                            <td>{{ $guru->sertifikasi_status == 'Ya' ? 'Sudah' : 'Belum' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tahun Sertifikasi</th>
                                            <td>{{ $guru->sertifikasi_tahun ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                {{-- Kolom Kanan: Kompetensi --}}
                                <div class="col-md-6">
                                    <h5 class="mb-4">Kompetensi</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Microsoft Word</th>
                                            <td>
                                                {{-- Menerjemahkan nilai numerik Word ke teks --}}
                                                {{ $guru->kompetensi_word == 3
                                                    ? 'Mahir'
                                                    : ($guru->kompetensi_word == 2
                                                        ? 'Menengah'
                                                        : ($guru->kompetensi_word == 1
                                                            ? 'Dasar'
                                                            : 'Tidak Memiliki')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Microsoft Powerpoint</th>
                                            <td>
                                                {{-- Menerjemahkan nilai numerik PowerPoint ke teks --}}
                                                {{ $guru->kompetensi_powerpoin == 3
                                                    ? 'Mahir'
                                                    : ($guru->kompetensi_powerpoin == 2
                                                        ? 'Menengah'
                                                        : ($guru->kompetensi_powerpoin == 1
                                                            ? 'Dasar'
                                                            : 'Tidak Memiliki')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Microsoft Excel</th>
                                            <td>
                                                {{-- Menerjemahkan nilai numerik PowerPoint ke teks --}}
                                                {{ $guru->kompetensi_excel == 3
                                                    ? 'Mahir'
                                                    : ($guru->kompetensi_excel == 2
                                                        ? 'Menengah'
                                                        : ($guru->kompetensi_excel == 1
                                                            ? 'Dasar'
                                                            : 'Tidak Memiliki')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pemrogramman</th>
                                            <td>
                                                {{-- Menerjemahkan nilai numerik PowerPoint ke teks --}}
                                                {{ $guru->kompetensi_pemrogramman == 3
                                                    ? 'Mahir'
                                                    : ($guru->kompetensi_pemrogramman == 2
                                                        ? 'Menengah'
                                                        : ($guru->kompetensi_pemrogramman == 1
                                                            ? 'Dasar'
                                                            : 'Tidak Memiliki')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Jaringan</th>
                                            <td>
                                                {{-- Menerjemahkan nilai numerik PowerPoint ke teks --}}
                                                {{ $guru->kompetensi_jaringan == 3
                                                    ? 'Mahir'
                                                    : ($guru->kompetensi_jaringan == 2
                                                        ? 'Menengah'
                                                        : ($guru->kompetensi_jaringan == 1
                                                            ? 'Dasar'
                                                            : 'Tidak Memiliki')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Multimedia</th>
                                            <td>
                                                {{-- Menerjemahkan nilai numerik PowerPoint ke teks --}}
                                                {{ $guru->kompetensi_multimedia == 3
                                                    ? 'Mahir'
                                                    : ($guru->kompetensi_multimedia == 2
                                                        ? 'Menengah'
                                                        : ($guru->kompetensi_multimedia == 1
                                                            ? 'Dasar'
                                                            : 'Tidak Memiliki')) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="tab-pane py-5 fade" id="wizard2" role="tabpanel">
                            <h5 class="mb-4">Pelatihan yang Pernah Diikuti : {{ $guru->pelatihan_status }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelatihan</th>
                                            <th>Tingkatan</th>
                                            <th>Level</th>
                                            <th>Tahun</th>
                                            <th>Durasi (Jam)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($guru->pelatihan as $index => $p)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $p->nama_pelatihan }}</td>
                                                <td>{{ $p->tingkatan }}</td>
                                                <td>{{ $p->level }}</td>
                                                <td>{{ $p->tahun_pelatihan }}</td>
                                                <td>{{ $p->jam_pelatihan }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada data pelatihan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="tab-pane py-5 fade" id="wizard3" role="tabpanel">
                            <h5 class="mb-4">Kebutuhan Pelatihan : {{ $guru->pelatihan_kebutuhan }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelatihan Dibutuhkan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($guru->kebutuhanPelatihan as $index => $k)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $k->nama_pelatihan }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">Belum ada kebutuhan pelatihan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="tab-pane py-5 fade" id="wizard4" role="tabpanel">
                            <h5 class="mb-4">Verifikasi Data Guru</h5>
                            <form action="{{ route('verifikasi-guru.update', $guru->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Status Verifikasi</label>
                                    <select class="form-select" name="status_verifikasi" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="disetujui"
                                            {{ $guru->status_verifikasi == 'disetujui' ? 'selected' : '' }}>Disetujui
                                        </option>
                                        <option value="ditolak"
                                            {{ $guru->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Catatan Verifikasi</label>
                                    <textarea class="form-control" name="catatan_verifikasi" rows="3">{{ $guru->catatan_verifikasi }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Kembali</a>
                                    <button type="submit" class="btn btn-success">Simpan Verifikasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

        @if ($errors->any())
            let errorList = '';
            @foreach ($errors->all() as $error)
                errorList += `- {{ $error }}\n`;
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan Data',
                text: 'Periksa inputan Anda.',
                footer: `<pre style="text-align:left; color:red; font-family:Arial;">${errorList}</pre>`
            });
        @endif
    </script>
@endsection
