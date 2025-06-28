@extends('layouts.navbar')
@section('title', 'Input Data Umum dan Data TIK Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="arrow-right-circle"></i></div>
                                Input Data Umum dan Data TIK Sekolah
                            </h1>
                            <div class="page-header-subtitle">Silahkan lengkapi data dibawah ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <!-- Wizard card example with navigation-->
            <div class="card">
                <div class="card-header border-bottom">
                    <!-- Wizard navigation-->
                    <div class="nav nav-pills nav-justified flex-column flex-xl-row nav-wizard" id="cardTab"
                        role="tablist">
                        <!-- Wizard navigation item 1-->
                        <a class="nav-item nav-link active" id="wizard1-tab" href="#wizard1" data-bs-toggle="tab"
                            role="tab" aria-controls="wizard1" aria-selected="true">
                            <div class="wizard-step-icon">1</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Identitas & Data Umum</div>
                                <div class="wizard-step-text-details">Masukan identitas dan data umum sekolah</div>
                            </div>
                        </a>
                        <!-- Wizard navigation item 2-->
                        <a class="nav-item nav-link" id="wizard2-tab" href="#wizard2" data-bs-toggle="tab" role="tab"
                            aria-controls="wizard2" aria-selected="true">
                            <div class="wizard-step-icon">2</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Data Fasilitas TIK</div>
                                <div class="wizard-step-text-details">Data Fasilitas TIK dan Internet</div>
                            </div>
                        </a>

                        <!-- Wizard navigation item 4-->
                        <a class="nav-item nav-link" id="wizard4-tab" href="#wizard4" data-bs-toggle="tab" role="tab"
                            aria-controls="wizard4" aria-selected="true">
                            <div class="wizard-step-icon">4</div>
                            <div class="wizard-step-text">
                                <div class="wizard-step-text-name">Review &amp; Submit</div>
                                <div class="wizard-step-text-details">Review and submit changes</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="cardTabContent">
                        <!-- Wizard tab pane item 1-->
                        <div class="tab-pane py-5 py-xl-10 fade show active" id="wizard1" role="tabpanel"
                            aria-labelledby="wizard1-tab">
                            <div class="row justify-content-center">
                                <div class="col-xxl-10 col-xl-8">
                                    <h3 class="text-primary">Step 1</h3>
                                    <h5 class="card-title mb-4">Identitas dan Data Umum Sekolah</h5>

                                    <h5>1. IDENTITAS SEKOLAH</h5>
                                    <hr>
                                    <form>
                                        <div class="row">
                                            <!-- NPSN -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="npsn">NPSN</label>
                                                <input class="form-control bg-light text-dark" id="npsn" name="npsn"
                                                    type="text" value="{{ $sekolah->npsn }}">
                                            </div>

                                            <!-- Nama Sekolah -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="nama">Nama Sekolah</label>
                                                <input class="form-control bg-light text-dark" id="nama" name="nama"
                                                    type="text" value="{{ $sekolah->nama }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Tingkatan -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="tingkatan">Tingkatan</label>
                                                <input class="form-control bg-light text-dark" id="tingkatan"
                                                    name="tingkatan" type="text" value="{{ $sekolah->tingkatan }}"
                                                    readonly>
                                            </div>

                                            <!-- Alamat -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="alamat">Alamat</label>
                                                <input class="form-control" id="alamat" name="alamat" type="text"
                                                    placeholder="Masukkan alamat sekolah" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Kecamatan & Kota -->
                                            <div class="mb-3 col-md-6">
                                                <label for="kecamatan_id" class="form-label">Kecamatan & Kota</label>
                                                <select name="kecamatan_id" id="kecamatan_id" class="form-select" required>
                                                    <option value="">-- Pilih Kecamatan & Kota --</option>
                                                    @foreach ($kecamatanList as $kecamatan)
                                                        <option value="{{ $kecamatan->id }}">
                                                            {{ $kecamatan->nama }} ({{ $kecamatan->kota->nama }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Telepon -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="phone">Nomor Telepon</label>
                                                <input class="form-control" id="phone" name="phone" type="text"
                                                    placeholder="Masukkan nomor telepon">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Email -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="email"
                                                    placeholder="Masukkan email sekolah">
                                            </div>

                                            <!-- Website -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="website">Website</label>
                                                <input class="form-control" id="website" name="website" type="text"
                                                    placeholder="Contoh: http://example.sch.id">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- SK Izin -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="sk_ijin">Nomor SK Izin</label>
                                                <input class="form-control" id="sk_ijin" name="sk_ijin" type="text"
                                                    placeholder="Masukkan nomor SK Izin">
                                            </div>

                                            <!-- Status Negeri/Swasta -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="status">Status Sekolah
                                                    Negeri/Swasta</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="negeri">Negeri</option>
                                                    <option value="swasta">Swasta</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Akreditasi -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="akreditasi">Akreditasi</label>
                                                <input class="form-control" id="akreditasi" name="akreditasi"
                                                    type="text"
                                                    placeholder="Contoh: A, B, C, atau Belum Terakreditasi">
                                            </div>
                                            <!-- Status Kepemilikan Sertifikat Tanah -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="status_kepemilikan_sertifikat">Status
                                                    Kepemilikan Sertifikat Tanah</label>
                                                <select class="form-select" id="status_kepemilikan_sertifikat"
                                                    name="status_kepemilikan_sertifikat">
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Sertifikat Hak Milik">Sertifikat Hak Milik</option>
                                                    <option value="Sertifikat Hak Pakai">Sertifikat Hak Pakai</option>
                                                    <option value="Belum Bersertifikat">Belum Bersertifikat</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Jumlah Siswa Pria -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jum_siswa_pria">Jumlah Siswa Pria</label>
                                                <input class="form-control" id="jum_siswa_pria" name="jum_siswa_pria"
                                                    type="number" placeholder="Masukkan jumlah siswa pria">
                                            </div>
                                            <!-- Jumlah Siswa Wanita -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jum_siswa_wanita">Jumlah Siswa
                                                    Wanita</label>
                                                <input class="form-control" id="jum_siswa_wanita" name="jum_siswa_wanita"
                                                    type="number" placeholder="Masukkan jumlah siswa wanita">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Status UNBK -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="unbk_status">Status Penyelenggaraan
                                                    UNBK</label>
                                                <select class="form-select" id="unbk_status" name="unbk_status">
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Mandiri">Mandiri</option>
                                                    <option value="Menumpang">Menumpang</option>
                                                    <option value="Tidak UNBK">Tidak UNBK</option>
                                                </select>
                                            </div>
                                            <!-- Tahun UNBK -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="unbk_tahun">Tahun Pertama Kali UNBK</label>
                                                <input class="form-control" id="unbk_tahun" name="unbk_tahun"
                                                    type="number" placeholder="Contoh: 2023">
                                            </div>
                                        </div>
                                        <h5>2. DATA KONDISI GEOGRAFIS DAN SOSEKBUD</h5>
                                        <hr>
                                        <div class="row">
                                            <!-- Desa -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="desa">Desa</label>
                                                <input class="form-control" id="desa" name="desa" type="text"
                                                    placeholder="Masukkan nama desa">
                                            </div>
                                            <!-- Akses Transportasi -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="akses_transportasi">Akses
                                                    Transportasi</label>
                                                <input class="form-control" id="akses_transportasi"
                                                    name="akses_transportasi" type="text"
                                                    placeholder="Contoh: Jalan Darat, Air, Laut">
                                            </div>

                                        </div>



                                        <div class="row">

                                            <!-- Kondisi Geografis -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="kondisi_geografis">Kondisi
                                                    Geografis</label>
                                                <textarea class="form-control" id="kondisi_geografis" name="kondisi_geografis" rows="3"
                                                    placeholder="Uraian singkat kondisi geografis"></textarea>
                                            </div>
                                            <!-- Kondisi Sosial Ekonomi Budaya -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="kondisi_sosekbud">Kondisi Sosial Ekonomi
                                                    Budaya</label>
                                                <textarea class="form-control" id="kondisi_sosekbud" name="kondisi_sosekbud" rows="3"
                                                    placeholder="Uraian singkat kondisi sosial ekonomi budaya (SOSEKBUD)"></textarea>
                                            </div>

                                        </div>

                                        <h5>3. DATA LEMBAGA PEMBERIAN BANTUAN</h5>
                                        <hr>

                                        <div class="row">
                                            <!-- Status Bantuan TIK -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="status_bantuan_tik">Status Bantuan
                                                    TIK</label>
                                                <select class="form-select" id="status_bantuan_tik"
                                                    name="status_bantuan_tik">
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Pernah">Pernah</option>
                                                    <option value="Belum Pernah">Belum Pernah</option>
                                                </select>
                                            </div>
                                            <!-- Lembaga Pemberi Bantuan -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1">Lembaga Pemberi Bantuan</label>
                                                <div id="lembaga-container">
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="lembaga_bantuan[]"
                                                            class="form-control" placeholder="Masukkan nama lembaga">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-btn">Hapus</button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    id="add-lembaga">Tambah</button>
                                            </div>

                                        </div>

                                        <!-- Status Bantuan Program/Kegiatan -->
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="status_bantuan_tik">Status Bantuan
                                                    Program/Kegiatan</label>
                                                <select class="form-select" id="status_bantuan_tik"
                                                    name="status_bantuan_tik">
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Pernah">Pernah</option>
                                                    <option value="Belum Pernah">Belum Pernah</option>
                                                </select>
                                            </div>

                                            <!-- Lembaga Pemberi Bantuan -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1">Lembaga Pemberi Bantuan</label>
                                                <div id="lembaga-program-container">
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="lembaga_program[]"
                                                            class="form-control" placeholder="Masukkan nama lembaga">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-btn-program">Hapus</button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    id="add-lembaga-program">Tambah</button>
                                            </div>
                                        </div>

                                        <h5>4. DATA FASILITAS LISTRIK DAN INTERNET</h5>
                                        <hr>

                                        <div class="row">

                                            <!-- Listrik -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="listrik">Listrik</label>
                                                <select class="form-select" id="listrik" name="listrik">
                                                    <option value="">-- Pilih Ketersediaan --</option>
                                                    <option value="Tersedia">Tersedia</option>
                                                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                                                </select>
                                            </div>


                                            <!-- Fasilitas Internet -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="fasilitas_internet">Fasilitas Koneksi
                                                    Internet Saat Ini</label>
                                                <select class="form-select" id="fasilitas_internet"
                                                    name="fasilitas_internet">
                                                    <option value="">-- Pilih Fasilitas --</option>
                                                    <option value="Tidak Ada">Tidak Ada</option>
                                                    <option value="Indihome/Indibiz">Indihome/Indibiz</option>
                                                    <option value="Starlink">Starlink</option>
                                                    <option value="Astinet">Astinet</option>
                                                    <option value="Lintas Arta">Lintas Arta</option>
                                                    <option value="Lainya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Sumber Listrik -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="sumber_listrik">Sumber Listrik</label>
                                                <select class="form-select" id="sumber_listrik" name="sumber_listrik"
                                                    required>
                                                    <option value="">-- Pilih Sumber Listrik --</option>
                                                    <option value="PLN">PLN</option>
                                                    <option value="Genset">Genset</option>
                                                    <option value="PLTS">PLTS (Tenaga Surya)</option>
                                                    <option value="PLTD">PLTD (Diesel)</option>
                                                    <option value="Tidak Ada">Tidak Ada</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>

                                            <!-- Durasi Listrik -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="durasi_listrik">Durasi Listrik
                                                    (jam/hari)</label>
                                                <input class="form-control" id="durasi_listrik" name="durasi_listrik"
                                                    type="text" placeholder="Contoh: 24 jam">
                                            </div>
                                        </div>

                                        <hr class="my-4" />
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-light" type="button" disabled>Kembali</button>
                                            <button class="btn btn-primary" type="button">Simpan dan Lanjut</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- Wizard tab pane item 2-->
                        <div class="tab-pane py-5 py-xl-10 fade" id="wizard2" role="tabpanel"
                            aria-labelledby="wizard2-tab">
                            <div class="row justify-content-center">
                                <div class="col-xxl-10 col-xl-8">
                                    <h3 class="text-primary">Step 2</h3>
                                    <h5 class="card-title mb-4">Data Umum Fasilitas Sekolah</h5>
                                    <form>
                                        <h5 class="bold">1. DATA LAB KOMPUTER & PERANGKAT JARINGAN INTERNET </h5>
                                        <hr>
                                        <div class="row">

                                            <!-- Jumlah Lab Komputer -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jumlah_lab">Jumlah Lab Komputer
                                                </label>
                                                <input class="form-control" id="jumlah_lab" name="jumlah_lab"
                                                    type="text" placeholder="0">
                                            </div>
                                            <!-- Nama Lab Komputer dan Jumlah Komputer -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1">Nama Lab Komputer & Jumlah Komputer</label>
                                                <div id="lab-container">
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="lab_name[]" class="form-control"
                                                            placeholder="Nama/jenis lab">
                                                        <input type="number" name="jumlah_komputer[]"
                                                            class="form-control" placeholder="Jumlah komputer">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-btn">Hapus</button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    id="add-lab">Tambah</button>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <!-- Jenis Koneksi -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jenis_koneksi">Jenis Koneksi</label>
                                                <select class="form-select" id="jenis_koneksi" name="jenis_koneksi"
                                                    required>
                                                    <option value="">-- Pilih Jenis Koneksi --</option>
                                                    <option value="LAN">LAN</option>
                                                    <option value="Wireless LAN">Wireless LAN</option>
                                                    <option value="LAN + Wireless LAN">LAN + Wireless LAN</option>
                                                </select>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <!-- Jumlah Router -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jumlah_router">Jumlah Perangkat Jaringan
                                                    (Router/Switch/Modem)</label>
                                                <input class="form-control" id="jumlah_router" name="jumlah_router"
                                                    type="number" placeholder="Masukkan jumlah router">
                                            </div>

                                            <!-- Jumlah Komputer -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jumlah_komputer">Jumlah Komputer/Laptop di
                                                    Sekolah (Selain di Lab Komputer)</label>
                                                <input class="form-control" id="jumlah_komputer" name="jumlah_komputer"
                                                    type="number" placeholder="Masukkan jumlah komputer">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Jumlah Bandwidth -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="jumlah_bandwith">Jumlah Bandwidth
                                                    (Mbps)</label>
                                                <input class="form-control" id="jumlah_bandwith" name="jumlah_bandwith"
                                                    type="number" placeholder="Contoh: 20">
                                            </div>

                                            <!-- Sesuai Kebutuhan -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="sesuai_kebutuhan">Sesuai Kebutuhan?</label>
                                                <select class="form-select" id="sesuai_kebutuhan" name="sesuai_kebutuhan"
                                                    required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Alasan Penambahan Kuota -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="alasan_penambahan_kuota">Alasan Penambahan
                                                    Kuota</label>
                                                <textarea class="form-control" id="alasan_penambahan_kuota" name="alasan_penambahan_kuota"
                                                    placeholder="Tulis alasan jika membutuhkan penambahan kuota"></textarea>
                                            </div>

                                        </div>
                                        <h5> 2. SARAN PENGEMBANGAN </h5>
                                        <hr>
                                        <div class="row">


                                            <!-- Saran -->
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1" for="saran">Saran</label>
                                                <textarea class="form-control" id="saran" name="saran"
                                                    placeholder="Tulis saran terkait infrastruktur TIK di sekolah"></textarea>
                                            </div>
                                        </div>

                                        <!-- Hidden input untuk sekolah_id -->
                                        <input type="hidden" name="sekolah_id" value="{{ Auth::user()->sekolah_id }}">

                                        <hr class="my-4" />
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-light" type="button" disabled>Kembali</button>
                                            <button class="btn btn-primary" type="button">Simpan dan Lanjut</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Wizard tab pane item 4-->
                        <div class="tab-pane py-5 py-xl-10 fade" id="wizard4" role="tabpanel"
                            aria-labelledby="wizard4-tab">
                            <div class="row justify-content-center">
                                <div class="col-xxl-6 col-xl-8">
                                    <h3 class="text-primary">Step 4</h3>
                                    <h5 class="card-title mb-4">Review the following information and submit</h5>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Username:</em></div>
                                        <div class="col">username</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Name:</em></div>
                                        <div class="col">Valerie Luna</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Organization Name:</em></div>
                                        <div class="col">Start Bootstrap</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Location:</em></div>
                                        <div class="col">San Francisco, CA</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Email Address:</em></div>
                                        <div class="col">name@example.com</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Phone Number:</em></div>
                                        <div class="col">555-123-4567</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Birthday:</em></div>
                                        <div class="col">06/10/1988</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Credit Card Number:</em></div>
                                        <div class="col">**** **** **** 1111</div>
                                    </div>
                                    <div class="row small text-muted">
                                        <div class="col-sm-3 text-truncate"><em>Credit Card Expiration:</em></div>
                                        <div class="col">06/2024</div>
                                    </div>
                                    <hr class="my-4" />
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-light" type="button" disabled>Kembali</button>
                                        <button class="btn btn-primary" type="button">Simpan dan Lanjut</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection


@section('scripts')

    <script>
        document.getElementById('add-lab').addEventListener('click', function() {
            const container = document.getElementById('lab-container');

            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';

            // Input Nama Lab
            const labInput = document.createElement('input');
            labInput.type = 'text';
            labInput.name = 'lab_name[]';
            labInput.className = 'form-control';
            labInput.placeholder = 'Nama/jenis lab';

            // Input Jumlah Komputer
            const jumlahInput = document.createElement('input');
            jumlahInput.type = 'number';
            jumlahInput.name = 'jumlah_komputer[]';
            jumlahInput.className = 'form-control';
            jumlahInput.placeholder = 'Jumlah komputer';

            // Tombol Hapus
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-danger btn-sm remove-btn';
            btn.textContent = 'Hapus';
            btn.addEventListener('click', () => inputGroup.remove());

            // Tambahkan ke grup
            inputGroup.appendChild(labInput);
            inputGroup.appendChild(jumlahInput);
            inputGroup.appendChild(btn);

            container.appendChild(inputGroup);
        });

        // Untuk tombol hapus pertama (default input yang tampil saat awal)
        document.querySelectorAll('.remove-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                btn.parentElement.remove();
            });
        });

        // Tambah input Lembaga
        document.getElementById('add-lembaga').addEventListener('click', function() {
            const container = document.getElementById('lembaga-container');

            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'lembaga[]';
            input.className = 'form-control';
            input.placeholder = 'Masukkan nama lembaga';

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-danger btn-sm remove-btn';
            btn.textContent = 'Hapus';
            btn.addEventListener('click', () => inputGroup.remove());

            inputGroup.appendChild(input);
            inputGroup.appendChild(btn);
            container.appendChild(inputGroup);
        });

        // Tombol hapus awal
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.parentElement.remove();
            });
        });

        // tambah bantuan program/kegiatan
        document.getElementById('add-lembaga-program').addEventListener('click', function() {
            const container = document.getElementById('lembaga-program-container');

            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'lembaga_program[]';
            input.className = 'form-control';
            input.placeholder = 'Masukkan nama lembaga';

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-danger btn-sm remove-btn-program';
            btn.textContent = 'Hapus';

            btn.addEventListener('click', function() {
                inputGroup.remove();
            });

            inputGroup.appendChild(input);
            inputGroup.appendChild(btn);
            container.appendChild(inputGroup);
        });

        // Untuk tombol hapus pertama (yang muncul di awal)
        document.querySelectorAll('.remove-btn-program').forEach(function(btn) {
            btn.addEventListener('click', function() {
                btn.parentElement.remove();
            });
        });
    </script>




@endsection
