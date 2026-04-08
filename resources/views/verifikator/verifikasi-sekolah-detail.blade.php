@extends('layouts.navbar')
@section('title', 'Dashboard Verifikator E-Monitoring dan Evaluasi - Verifikasi Data Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="info"></i></div>
                                Monitoring dan Evaluasi Data Sekolah
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
                        <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-bs-toggle="tab"
                            role="tab">
                            <div class="wizard-step-icon">1</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Identitas Sekolah</div>
                            </div>
                        </a>
                        <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">2</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Sosial Ekonomi & Budaya</div>
                            </div>
                        </a>
                        <a class="nav-item nav-link" id="wizard3-tab" href="#wizard3" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">3</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Fasilitas</div>
                            </div>
                        </a>
                        <a class="nav-item nav-link" id="wizard4-tab" href="#wizard4" data-bs-toggle="tab" role="tab">
                            <div class="wizard-step-icon">4</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Data Bantuan</div>
                            </div>
                        </a>

                        @if ($identitasSekolah->status_verifikasi != 2)
                            <a class="nav-item nav-link" id="wizard5-tab" href="#wizard5" data-bs-toggle="tab"
                                role="tab">
                                <div class="wizard-step-icon">5</div>
                                <div class="wizard-step-text">
                                    <div class="wizard-step-text-name">Verifikasi</div>
                                    <div class="wizard-step-text-details">Keputusan verifikator</div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="cardTabContent">
                        <!-- Step 1 -->
                        <div class="tab-pane fade show active" id="wizard1" role="tabpanel">
                            <h5 class="mb-4">Identitas Sekolah</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Foto Sekolah</th>
                                    <td>
                                        @if ($identitasSekolah->foto_sekolah)
                                            <img src="{{ asset('uploads/kepsek/' . $identitasSekolah->foto_sekolah) }}"
                                                alt="Foto  Sekolah" style="max-width: 150px; border-radius: 8px;">
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>NPSN</th>
                                    <td>{{ $identitasSekolah->npsn }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $identitasSekolah->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $identitasSekolah->status_sekolah }}</td>
                                </tr>
                                <tr>
                                    <th>Tingkatan</th>
                                    <td>{{ $identitasSekolah->tingkatan }}</td>
                                </tr>
                                <tr>
                                    <th>Status Akreditasi</th>
                                    <td>{{ $identitasSekolah->status_akreditasi }}</td>
                                </tr>
                                <tr>
                                    <th>SK Ijin Operasional</th>
                                    <td>{{ $identitasSekolah->sk_ijin }}</td>
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
                                <tr>
                                    <th>Jumlah Guru (Tenaga Pendidik)</th>
                                    <td>{{ $identitasSekolah->jum_guru }}</td>
                                </tr>
                                <tr>
                                    <th>Kepemilikian Tanah</th>
                                    <td>{{ $identitasSekolah->status_tanah }}</td>
                                </tr>

                                <tr>
                                    <th>Nama Kepala Sekolah</th>
                                    <td>{{ $identitasSekolah->kepsek_nama }}</td>
                                </tr>
                                <tr>
                                    <th>Foto Kepala Sekolah</th>
                                    <td>
                                        @if ($identitasSekolah->kepsek_foto)
                                            <img src="{{ asset('uploads/kepsek/' . $identitasSekolah->kepsek_foto) }}"
                                                alt="Foto Kepala Sekolah" style="max-width: 150px; border-radius: 8px;">
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>No Kontak Kepala Sekolah</th>
                                    <td>{{ $identitasSekolah->kepsek_hp }}</td>
                                </tr>

                            </table>

                        </div>

                        <!-- Step 2 -->
                        <div class="tab-pane fade" id="wizard2" role="tabpanel">
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

                        </div>

                        <!-- Step 3 -->
                        <div class="tab-pane fade" id="wizard3" role="tabpanel">
                            <h5 class="mb-4">Fasilitas Sekolah</h5>
                            @if ($sekolahFasilitas)
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Listrik:</strong>
                                        {{ $sekolahFasilitas->listrik_status }}
                                        ({{ $sekolahFasilitas->listrik_sumber }}/{{ $sekolahFasilitas->listrik_durasi }}
                                        jam)</li>
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
                                        {{ $sekolahFasilitas->internet_bandwith }} Mbps, Topologi:
                                        {{ $sekolahFasilitas->topologi_jaringan }})</li>
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
                        <div class="tab-pane fade" id="wizard4" role="tabpanel">
                            <h5 class="mb-4">Bantuan Sekolah</h5>
                            <p><strong>Status Bantuan:</strong>
                                @if ($sekolahBantuanStatus && $sekolahBantuanStatus->status === 'ya')
                                    <span class="badge bg-success">Ya</span>
                                @elseif($sekolahBantuanStatus && $sekolahBantuanStatus->status === 'tidak')
                                    <span class="badge bg-danger">Tidak</span>
                                @else
                                    <span class="badge bg-secondary">Belum Diisi</span>
                                @endif
                            </p>

                            @if ($sekolahBantuanStatus && $sekolahBantuanStatus->status === 'ya')
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
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
                                                    <td colspan="3" class="text-center">Belum ada data bantuan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif


                        </div>

                        <!-- Step 5 -->
                        @if ($identitasSekolah->status_verifikasi != 2)
                            <div class="tab-pane fade" id="wizard5" role="tabpanel">
                                <h5 class="mb-4">Verifikasi Sekolah</h5>
                                <form action="{{ route('verifikasi-sekolah.update', $identitasSekolah->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Status Verifikasi</label>
                                        <select class="form-select" name="status_verifikasi" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Catatan Verifikasi</label>
                                        <textarea class="form-control" name="keterangan_verifikasi" rows="3"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">

                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        @endif

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
