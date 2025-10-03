@extends('layouts.navbar')
@section('title', 'Verifikator Sekolah - Proses Verifikasi')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="info"></i></div>
                                Verifikasi Data Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4"> Verifikasi Data Sekolah</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">

            <div class="card">
                <div class="card-header border-bottom">
                    <!-- Wizard navigation-->
                    <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab"
                        role="tablist">
                        <!-- Step 1 -->
                        <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-bs-toggle="tab"
                            role="tab">
                            <div class="wizard-step-icon">1</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Identitas Sekolah</div>

                            </div>
                        </a>
                        <!-- Step 2 -->
                        <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">2</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Sosial Ekonomi & Budaya</div>

                            </div>
                        </a>
                        <!-- Step 3 -->
                        <a class="nav-item nav-link" id="wizard2-tab" href="#wizard3" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">3</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Fasilitas</div>

                            </div>
                        </a>
                        <!-- Step 4 -->
                        <a class="nav-item nav-link" id="wizard2-tab" href="#wizard4" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">4</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Data Bantuan</div>

                            </div>
                        </a>
                        <!-- Step 5 -->
                        <a class="nav-item nav-link" id="wizard3-tab" href="#wizard5" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">5</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Verifikasi</div>
                                <div class="wizard-step-text-details">Keputusan verifikator</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="cardTabContent">

                        <!-- Step 1 -->
                        <div class="tab-pane py-5 fade show active" id="wizard1" role="tabpanel">
                            <h5 class="mb-4">Identitas Sekolah</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>NPSN</th>
                                    <td>{{ $identitasSekolah->npsn }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $identitasSekolah->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Tingkatan</th>
                                    <td>{{ $identitasSekolah->tingkatan }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $identitasSekolah->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $identitasSekolah->telepon }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $identitasSekolah->email }}</td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td>{{ $identitasSekolah->website }}</td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#wizard2">Next</button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="tab-pane py-5 fade" id="wizard2" role="tabpanel">
                            <h5 class="mb-4">Data Sosial Ekonomi & Budaya</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Kondisi Geografis</th>
                                    <td>{{ $sosekbudSekolah->kondisi_geografis }}</td>
                                </tr>
                                <tr>
                                    <th>Kondisi Sosial Ekonomi & Budaya</th>
                                    <td>{{ $sosekbudSekolah->kondisi_sosekbud }}</td>
                                </tr>
                                <tr>
                                    <th>Akses Transportasi</th>
                                    <td>{{ $sosekbudSekolah->akses_transportasi }}</td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-light" data-bs-toggle="tab"
                                    data-bs-target="#wizard1">Previous</button>
                                <button class="btn btn-primary" data-bs-toggle="tab" data-bs-target="#wizard3">Next</button>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="tab-pane py-5 fade" id="wizard3" role="tabpanel">
                            <h5 class="mb-4">Fasilitas Sekolah</h5>

                            @if ($sekolahFasilitas)
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Listrik:</strong>
                                        {{ $sekolahFasilitas->listrik_status }} ({{ $sekolahFasilitas->listrik_sumber }} /
                                        {{ $sekolahFasilitas->listrik_durasi }} jam)</li>
                                    <li class="list-group-item"><strong>Jumlah Komputer:</strong>
                                        {{ $sekolahFasilitas->jumlah_kom }}</li>
                                    <li class="list-group-item"><strong>Status Lab Komputer:</strong>
                                        {{ $sekolahFasilitas->labkom_status }}</li>

                                    @if ($sekolahFasilitas->labkom_status == 'ada')
                                        <li class="list-group-item">
                                            <strong>Detail Lab:</strong>
                                            <ul>
                                                @foreach ($sekolahFasilitas->labs as $lab)
                                                    <li>{{ $lab->labkom_nama }} - {{ $lab->labkom_jumlah_pc }} PC</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif

                                    <li class="list-group-item"><strong>Internet:</strong>
                                        {{ $sekolahFasilitas->internet_status }}
                                        ({{ $sekolahFasilitas->internet_sumber }},
                                        {{ $sekolahFasilitas->internet_bandwith }} Mbps,
                                        Topologi: {{ $sekolahFasilitas->topologi_jaringan }})
                                    </li>
                                    <li class="list-group-item"><strong>Kesesuaian Internet:</strong>
                                        {{ $sekolahFasilitas->internet_kesesuaian }}</li>
                                    <li class="list-group-item"><strong>Alasan Kuota:</strong>
                                        {{ $sekolahFasilitas->internet_alasankuota }}</li>
                                    <li class="list-group-item"><strong>Saran Pengembangan:</strong>
                                        {{ $sekolahFasilitas->saran_pengembangan }}</li>
                                </ul>
                            @else
                                <div class="alert alert-warning">Data fasilitas belum tersedia.</div>
                            @endif
                        </div>

                        <!-- Step 4 -->
                        <div class="tab-pane py-5 fade" id="wizard4" role="tabpanel">
                            <h5 class="mb-4">Bantuan Sekolah</h5>
                            <!-- Status Bantuan -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Status Bantuan</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Status Bantuan:</strong>
                                        @if ($sekolahBantuanStatus && $sekolahBantuanStatus->status === 'ya')
                                            <span class="badge bg-success">Ya</span>
                                        @elseif($sekolahBantuanStatus && $sekolahBantuanStatus->status === 'tidak')
                                            <span class="badge bg-danger">Tidak</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Diisi</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Detail Bantuan -->
                            @if ($sekolahBantuanStatus && $sekolahBantuanStatus->status === 'ya')
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Detail Bantuan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Lembaga</th>
                                                        <th>Keterangan Bantuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($sekolahBantuanStatus->details as $index => $detail)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $detail->nama_lembaga }}</td>
                                                            <td>{{ $detail->keterangan_bantuan }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center">Belum ada data bantuan
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Tombol Navigasi -->
                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-light" data-bs-toggle="tab"
                                    data-bs-target="#wizard3">Previous</button>
                                <button class="btn btn-primary" data-bs-toggle="tab"
                                    data-bs-target="#wizard5">Next</button>
                            </div>
                        </div>
                        <!-- Step 5 -->
                        <div class="tab-pane py-5 fade" id="wizard5" role="tabpanel">
                            <h5 class="mb-4">Verifikasi Sekolah</h5>
                            <form action="{{ route('verifikasi-proses.update', $identitasSekolah->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Status Verifikasi</label>
                                    <select class="form-select" name="status_verifikasi" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Disetujui</option>
                                        <option value="0">Ditolak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan Verifikasi</label>
                                    <textarea class="form-control" name="keterangan_verifikasi" rows="3"></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-light" data-bs-toggle="tab"
                                        data-bs-target="#wizard2">Previous</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
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
