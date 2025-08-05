@extends('layouts.navbar')
@section('title', 'Operator Sekolah - Pengaturan Identitas Umum Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="info"></i></div>
                                Identitas Umum : {{ $sekolah->nama }}
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Identitas Umum Sekolah</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Lengkapi Identitas Sekolah</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('identitas-sekolah.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Kolom kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="npsn" class="form-label">NPSN</label>
                                    <input type="text" class="form-control" name="npsn" id="npsn"
                                        value="{{ old('npsn', $sekolah->npsn) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tingkatan" class="form-label">Tingkatan</label>
                                    <input type="text" class="form-control" name="tingkatan" id="tingkatan"
                                        value="{{ old('tingkatan', $sekolah->tingkatan) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Sekolah</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="{{ old('nama', $sekolah->nama) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat"
                                        value="{{ old('alamat', $sekolah->alamat) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" name="telepon" id="telepon"
                                        value="{{ old('telepon', $sekolah->telepon) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email', $sekolah->email) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="text" class="form-control" name="website" id="website"
                                        value="{{ old('website', $sekolah->website) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="sk_ijin" class="form-label">SK Ijin</label>
                                    <input type="text" class="form-control" name="sk_ijin" id="sk_ijin"
                                        value="{{ old('sk_ijin', $sekolah->sk_ijin) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="status_sekolah" class="form-label">Status Sekolah</label>
                                    <select name="status_sekolah" id="status_sekolah" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Negeri"
                                            {{ old('status_sekolah', $sekolah->status_sekolah) == 'Negeri' ? 'selected' : '' }}>
                                            Negeri</option>
                                        <option value="Swasta"
                                            {{ old('status_sekolah', $sekolah->status_sekolah) == 'Swasta' ? 'selected' : '' }}>
                                            Swasta</option>
                                    </select>
                                </div>





                            </div>

                            <!-- Kolom kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jum_siswa_pria" class="form-label">Jumlah Siswa Pria</label>
                                    <input type="number" class="form-control" name="jum_siswa_pria" id="jum_siswa_pria"
                                        value="{{ old('jum_siswa_pria', $sekolah->jum_siswa_pria) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="jum_siswa_wanita" class="form-label">Jumlah Siswa Wanita</label>
                                    <input type="number" class="form-control" name="jum_siswa_wanita"
                                        id="jum_siswa_wanita"
                                        value="{{ old('jum_siswa_wanita', $sekolah->jum_siswa_wanita) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="unbk_status" class="form-label">Status UNBK</label>
                                    <select name="unbk_status" id="unbk_status" class="form-select">
                                        <option value="">-- Pilih Status UNBK --</option>
                                        <option value="Mandiri"
                                            {{ old('unbk_status', $sekolah->unbk_status) == 'Mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="Menumpang"
                                            {{ old('unbk_status', $sekolah->unbk_status) == 'Menumpang' ? 'selected' : '' }}>
                                            Menumpang</option>
                                        <option value="Gabungan"
                                            {{ old('unbk_status', $sekolah->unbk_status) == 'Gabungan' ? 'selected' : '' }}>
                                            Gabungan</option>
                                        <option value="Belum UNBK"
                                            {{ old('unbk_status', $sekolah->unbk_status) == 'Belum UNBK' ? 'selected' : '' }}>
                                            Belum UNBK</option>
                                        <option value="Tidak Berlaku"
                                            {{ old('unbk_status', $sekolah->unbk_status) == 'Tidak Berlaku' ? 'selected' : '' }}>
                                            Tidak Berlaku</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="unbk_tahun" class="form-label">Tahun UNBK</label>
                                    <input type="number" class="form-control" name="unbk_tahun" id="unbk_tahun"
                                        value="{{ old('unbk_tahun', $sekolah->unbk_tahun) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="kecamatan_id" class="form-label">Kecamatan / Kota</label>
                                    <select name="kecamatan_id" id="kecamatan_id" class="form-select" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatanList as $kecamatan)
                                            <option value="{{ $kecamatan->id }}"
                                                {{ old('kecamatan_id', $sekolah->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                                {{ $kecamatan->nama }} - {{ $kecamatan->kota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status_tanah" class="form-label">Status Tanah</label>
                                    <select name="status_tanah" id="status_tanah" class="form-select" required>
                                        <option value="">-- Pilih Status Tanah --</option>
                                        <option value="Sertifikat Hak Milik (SHM)"
                                            {{ old('status_tanah', $sekolah->status_tanah) == 'Sertifikat Hak Milik (SHM)' ? 'selected' : '' }}>
                                            Sertifikat Hak Milik (SHM)
                                        </option>
                                        <option value="Sertifikat Hak Guna Bangunan (SHGB)"
                                            {{ old('status_tanah', $sekolah->status_tanah) == 'Sertifikat Hak Guna Bangunan (SHGB)' ? 'selected' : '' }}>
                                            Sertifikat Hak Guna Bangunan (SHGB)
                                        </option>
                                        <option value="Tanah Wakaf"
                                            {{ old('status_tanah', $sekolah->status_tanah) == 'Tanah Wakaf' ? 'selected' : '' }}>
                                            Tanah Wakaf
                                        </option>
                                        <option value="Tanah Negara"
                                            {{ old('status_tanah', $sekolah->status_tanah) == 'Tanah Negara' ? 'selected' : '' }}>
                                            Tanah Negara
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status_akreditasi" class="form-label">Status Akreditasi</label>
                                    <select name="status_akreditasi" id="status_akreditasi" class="form-select" required>
                                        <option value="">-- Pilih Status Akreditasi --</option>
                                        <option value="Terakreditasi A"
                                            {{ old('status_akreditasi', $sekolah->status_akreditasi) == 'Terakreditasi A' ? 'selected' : '' }}>
                                            Terakreditasi A</option>
                                        <option value="Terakreditasi B"
                                            {{ old('status_akreditasi', $sekolah->status_akreditasi) == 'Terakreditasi B' ? 'selected' : '' }}>
                                            Terakreditasi B</option>
                                        <option value="Terakreditasi C"
                                            {{ old('status_akreditasi', $sekolah->status_akreditasi) == 'Terakreditasi C' ? 'selected' : '' }}>
                                            Terakreditasi C</option>
                                        <option value="Belum Terakreditasi"
                                            {{ old('status_akreditasi', $sekolah->status_akreditasi) == 'Belum Terakreditasi' ? 'selected' : '' }}>
                                            Belum Terakreditasi</option>
                                        <option value="Tidak Terakreditasi"
                                            {{ old('status_akreditasi', $sekolah->status_akreditasi) == 'Tidak Terakreditasi' ? 'selected' : '' }}>
                                            Tidak Terakreditasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>

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

