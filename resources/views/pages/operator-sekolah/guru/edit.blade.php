@extends('layouts.navbar')
@section('title', 'Operator Sekolah - Update Data Guru')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="edit"></i></div>
                                Update Data Guru
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Update Data Guru</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Data Guru :</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('data-guru.update', $guru->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <h3>1. DATA PRIBADI</h3>
                            <hr>

                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            value="{{ old('nama', $guru->nama) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nip" class="col-sm-4 col-form-label">NIP (PNS/PPPK)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nip" id="nip"
                                            value="{{ old('nip', $guru->nip) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tempat" class="col-sm-4 col-form-label">Tempat/Kota Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tempat" id="tempat"
                                            value="{{ old('tempat', $guru->tempat) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Agama</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="agama">
                                            <option value="">---Pilih Agama---</option>
                                            @foreach (['Kristen', 'Islam', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agama)
                                                <option value="{{ $agama }}"
                                                    {{ old('agama', $guru->agama) == $agama ? 'selected' : '' }}>
                                                    {{ $agama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Pendidikan Terakhir</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="pendidikan_terakhir">
                                            <option value="">---Pilih Pendidikan Terakhir---</option>
                                            @foreach ([
            'S3' => 'Doktor-S3',
            'S2' => 'Magister-S2',
            'S1/D4' => 'Sarjana/Sarjana Terapan - S1/D4',
            'D3' => 'Diploma III - D3',
            'D2' => 'Diploma II - D2',
            'SMA/SMK/Sederajat' => 'SMA/SMK/Sederajat',
        ] as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">No Telepon</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="telepon" id="telepon"
                                            value="{{ old('telepon', $guru->telepon) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Sudah Sertifikasi?</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="sertifikasi_status" id="sertifikasi_status">
                                            <option value="">-- Pilih --</option>
                                            <option value="Ya"
                                                {{ old('sertifikasi_status', $guru->sertifikasi_status) == 'Ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="Tidak"
                                                {{ old('sertifikasi_status', $guru->sertifikasi_status) == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row" id="sertifikasi_alasan_row"
                                    style="{{ old('sertifikasi_status', $guru->sertifikasi_status) == 'Tidak' ? 'display:flex;' : 'display:none;' }}">
                                    <label class="col-sm-4 col-form-label">Jika belum sertifikasi, alasannya apa?</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="sertifikasi_alasan" id="sertifikasi_alasan">{{ old('sertifikasi_alasan', $guru->sertifikasi_alasan) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="status">
                                            @foreach (['PNS', 'PPPK'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', $guru->status) == $status ? 'selected' : '' }}>
                                                    {{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nuptk" class="col-sm-4 col-form-label">NUPTK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nuptk" id="nuptk"
                                            value="{{ old('nuptk', $guru->nuptk) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tgl_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                            value="{{ old('tgl_lahir', $guru->tgl_lahir ? \Carbon\Carbon::parse($guru->tgl_lahir)->format('Y-m-d') : '') }}">

                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="jenis_kelamin">
                                            <option value="L"
                                                {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                                Laki-Laki</option>
                                            <option value="P"
                                                {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">TMT PNS</label>
                                    <div class="col-sm-8">
                                        <input type="date" name="tmt_pns_tahun" class="form-control"
                                            value="{{ old('tmt_pns_tahun', \Carbon\Carbon::parse($guru->tmt_pns_tahun)->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="mapel" class="col-sm-4 col-form-label">Mata Pelajaran</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="mapel" id="mapel"
                                            value="{{ old('mapel', $guru->mapel) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row" id="sertifikasi_tahun_row"
                                    style="{{ old('sertifikasi_status', $guru->sertifikasi_status) == 'Ya' ? 'display:flex;' : 'display:none;' }}">
                                    <label for="sertifikasi_tahun" class="col-sm-4 col-form-label">Tahun
                                        Sertifikasi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="sertifikasi_tahun"
                                            id="sertifikasi_tahun"
                                            value="{{ old('sertifikasi_tahun', $guru->sertifikasi_tahun) }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Data Kompetensi & Pelatihan -->
                            <h3 class="mt-5">2. DATA KOMPETENSI & PELATIHAN</h3>
                            <hr>

                            <h5 class="mt-3">Kompetensi Kemampuan :</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    @foreach (['word' => 'Microsoft Word', 'excel' => 'Microsoft Excel', 'jaringan' => 'Jaringan Komputer'] as $key => $label)
                                        <div class="mb-3 row">
                                            <label for="kompetensi_{{ $key }}"
                                                class="col-sm-6 col-form-label">{{ $label }}</label>
                                            <div class="col-sm-6">
                                                <select name="kompetensi_{{ $key }}"
                                                    id="kompetensi_{{ $key }}" class="form-select" required>
                                                    @foreach ([3 => 'Mahir', 2 => 'Menengah', 1 => 'Dasar', 0 => 'Tidak Memiliki'] as $val => $text)
                                                        <option value="{{ $val }}"
                                                            {{ old('kompetensi_' . $key, $guru->{'kompetensi_' . $key}) == $val ? 'selected' : '' }}>
                                                            {{ $text }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    @foreach (['powerpoin' => 'Microsoft PowerPoint', 'pemrogramman' => 'Pemrogramman', 'multimedia' => 'Multimedia (Adobe Photoshop, Adobe Premiere, Capcut, dll)'] as $key => $label)
                                        <div class="mb-3 row">
                                            <label for="kompetensi_{{ $key }}"
                                                class="col-sm-6 col-form-label">{{ $label }}</label>
                                            <div class="col-sm-6">
                                                <select name="kompetensi_{{ $key }}"
                                                    id="kompetensi_{{ $key }}" class="form-select" required>
                                                    @foreach ([3 => 'Mahir', 2 => 'Menengah', 1 => 'Dasar', 0 => 'Tidak Memiliki'] as $val => $text)
                                                        <option value="{{ $val }}"
                                                            {{ old('kompetensi_' . $key, $guru->{'kompetensi_' . $key}) == $val ? 'selected' : '' }}>
                                                            {{ $text }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Pelatihan/Seminar/Workshop -->
                            <h5 class="mt-5">Pelatihan/Seminar/Workshop :</h5>
                            <hr>
                            <div class="col-md-6 mb-3">
                                <select name="pelatihan_status" id="pelatihan_status" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya"
                                        {{ old('pelatihan_status', $guru->pelatihan->count() ? 'Ya' : 'Tidak') == 'Ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="Tidak"
                                        {{ old('pelatihan_status', $guru->pelatihan->count() ? 'Ya' : 'Tidak') == 'Tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>


                            {{-- Pelatihan --}}
                            <div id="pelatihan_container"
                                style="display: {{ $guru->pelatihan->count() ? 'block' : 'none' }};">
                                <label>Data Pelatihan</label>
                                <div id="pelatihan_list">
                                    @forelse ($guru->pelatihan as $p)
                                        <div class="row pelatihan_row mb-2">
                                            <div class="col-md-3">
                                                <input type="text" name="nama_pelatihan[]" class="form-control"
                                                    placeholder="Nama Pelatihan"
                                                    value="{{ old('nama_pelatihan.' . $loop->index, $p->nama_pelatihan) }}"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="tingkatan[]" class="form-select" required>
                                                    @foreach (['Dasar', 'Menengah', 'Mahir'] as $t)
                                                        <option value="{{ $t }}"
                                                            {{ old('tingkatan.' . $loop->index, $p->tingkatan) == $t ? 'selected' : '' }}>
                                                            {{ $t }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="level[]" class="form-select" required>
                                                    @foreach (['Lokal', 'Nasional', 'Internasional'] as $l)
                                                        <option value="{{ $l }}"
                                                            {{ old('level.' . $loop->index, $p->level) == $l ? 'selected' : '' }}>
                                                            {{ $l }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="tahun_pelatihan[]" class="form-control"
                                                    placeholder="Tahun"
                                                    value="{{ old('tahun_pelatihan.' . $loop->index, $p->tahun_pelatihan) }}"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jam_pelatihan[]" class="form-control"
                                                    placeholder="Jumlah Jam"
                                                    value="{{ old('jam_pelatihan.' . $loop->index, $p->jam_pelatihan) }}"
                                                    required>
                                            </div>
                                            <div class="col-md-1 d-grid">
                                                <button type="button" class="btn btn-danger btn-remove-sm">x</button>
                                            </div>
                                        </div>
                                    @empty
                                        {{-- Jika kosong, tampilkan 1 baris kosong --}}
                                        <div class="row pelatihan_row mb-2">
                                            <div class="col-md-3">
                                                <input type="text" name="nama_pelatihan[]" class="form-control"
                                                    placeholder="Nama Pelatihan" required>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="tingkatan[]" class="form-select" required>
                                                    @foreach (['Dasar', 'Menengah', 'Mahir'] as $t)
                                                        <option value="{{ $t }}">{{ $t }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="level[]" class="form-select" required>
                                                    @foreach (['Lokal', 'Nasional', 'Internasional'] as $l)
                                                        <option value="{{ $l }}">{{ $l }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="tahun_pelatihan[]" class="form-control"
                                                    placeholder="Tahun" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jam_pelatihan[]" class="form-control"
                                                    placeholder="Jumlah Jam" required>
                                            </div>
                                            <div class="col-md-1 d-grid">
                                                <button type="button" class="btn btn-danger btn-remove-sm">x</button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="add_pelatihan_row">+</button>
                            </div>


                            <h5 class="mt-5">Kebutuhan Pelatihan/Seminar/Workshop Saat Ini :</h5>
                            <hr>
                            <div class="col-md-6 mb-3">
                                <select name="pelatihan_kebutuhan" id="pelatihan_kebutuhan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya"
                                        {{ old('pelatihan_kebutuhan', $guru->kebutuhanPelatihan->count() ? 'Ya' : 'Tidak') == 'Ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="Tidak"
                                        {{ old('pelatihan_kebutuhan', $guru->kebutuhanPelatihan->count() ? 'Ya' : 'Tidak') == 'Tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            {{-- Kebutuhan Pelatihan --}}
                            <div id="kebutuhan_container"
                                style="display: {{ $guru->kebutuhanPelatihan->count() ? 'block' : 'none' }};">
                                <label>Daftar Kebutuhan Pelatihan</label>
                                <div id="kebutuhan_list">
                                    @forelse ($guru->kebutuhanPelatihan as $k)
                                        <div class="row kebutuhan_row mb-2">
                                            <div class="col-md-11">
                                                <input type="text" name="nama_kebutuhan[]" class="form-control"
                                                    value="{{ old('nama_kebutuhan.' . $loop->index, $k->nama_pelatihan) }}"
                                                    required>
                                            </div>
                                            <div class="col-md-1 d-grid">
                                                <button type="button" class="btn btn-danger btn-remove-sm">x</button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row kebutuhan_row mb-2">
                                            <div class="col-md-11">
                                                <input type="text" name="nama_kebutuhan[]" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-md-1 d-grid">
                                                <button type="button" class="btn btn-danger btn-remove-sm">x</button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-primary mt-2" id="add_kebutuhan_row">+</button>
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>




    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // PASTIKAN BLOK INI BENAR, TERUTAMA JIKA ADA ERROR BLADE YANG MENGANDUNG KARAKTER KHUSUS
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
            // Gunakan js() untuk mencegah karakter khusus merusak sintaks JS
            @foreach ($errors->all() as $error)
                errorList += `- {{ js($error) }}\n`;
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan Data',
                text: 'Periksa inputan Anda.',
                footer: `<pre style="text-align:left; color:red; font-family:Arial;">${errorList}</pre>`
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Variabel Elemen ---
            const pelatihanStatus = document.getElementById('pelatihan_status');
            const pelatihanContainer = document.getElementById('pelatihan_container');

            const kebutuhanStatus = document.getElementById('pelatihan_kebutuhan');
            const kebutuhanContainer = document.getElementById('kebutuhan_container');

            const sertifikasiStatus = document.getElementById('sertifikasi_status');
            const sertifikasiTahunRow = document.getElementById('sertifikasi_tahun_row');
            const sertifikasiAlasanRow = document.getElementById('sertifikasi_alasan_row');

            // --------------------------------------------------------------------------------------------------
            // --- FUNGSI UTAMA ---
            // --------------------------------------------------------------------------------------------------

            // 1. Fungsi untuk toggle container Pelatihan (dan mengatur required)
            function togglePelatihanContainer() {
                const isYa = pelatihanStatus.value === 'Ya';
                pelatihanContainer.style.display = isYa ? 'block' : 'none';

                // Atur atribut required pada input Pelatihan
                const inputs = pelatihanContainer.querySelectorAll('input, select');
                inputs.forEach(input => {
                    // Set required HANYA jika status "Ya"
                    input.required = isYa;
                });
            }

            // 2. Fungsi untuk toggle container Kebutuhan Pelatihan (dan mengatur required)
            function toggleKebutuhanContainer() {
                const isYa = kebutuhanStatus.value === 'Ya';
                kebutuhanContainer.style.display = isYa ? 'block' : 'none';

                // Atur atribut required pada input Kebutuhan
                const inputs = kebutuhanContainer.querySelectorAll('input');
                inputs.forEach(input => {
                    input.required = isYa;
                });
            }

            // 3. Fungsi untuk toggle Sertifikasi dan Alasan
            function toggleSertifikasiFields() {
                const status = sertifikasiStatus.value;

                // Hidden by default
                sertifikasiTahunRow.style.display = 'none';
                sertifikasiAlasanRow.style.display = 'none';

                // Hapus required default
                document.getElementById('sertifikasi_tahun').required = false;
                document.getElementById('sertifikasi_alasan').required = false;

                if (status === 'Ya') {
                    sertifikasiTahunRow.style.display = 'flex';
                    document.getElementById('sertifikasi_tahun').required = true;

                } else if (status === 'Tidak') {
                    sertifikasiAlasanRow.style.display = 'flex';
                    document.getElementById('sertifikasi_alasan').required = true;
                }
            }


            // --------------------------------------------------------------------------------------------------
            // --- INISIALISASI DAN LISTENER ---
            // --------------------------------------------------------------------------------------------------

            // Jalankan fungsi saat DOM dimuat
            togglePelatihanContainer();
            toggleKebutuhanContainer();
            toggleSertifikasiFields();

            // Jalankan saat user ganti select
            pelatihanStatus.addEventListener('change', togglePelatihanContainer);
            kebutuhanStatus.addEventListener('change', toggleKebutuhanContainer);
            sertifikasiStatus.addEventListener('change', toggleSertifikasiFields);

            // 4. Tambah baris pelatihan
            document.getElementById('add_pelatihan_row').addEventListener('click', function() {
                const list = document.getElementById('pelatihan_list');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'pelatihan_row', 'mb-2');
                newRow.innerHTML = `
                <div class="col-md-3">
                    <input type="text" name="nama_pelatihan[]" class="form-control" placeholder="Nama Pelatihan" required>
                </div>
                <div class="col-md-2">
                    <select name="tingkatan[]" class="form-select" required>
                        <option value="Dasar">Dasar</option>
                        <option value="Menengah">Menengah</option>
                        <option value="Mahir">Mahir</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="level[]" class="form-select" required>
                        <option value="Lokal">Lokal</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="tahun_pelatihan[]" class="form-control" placeholder="Tahun" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="jam_pelatihan[]" class="form-control" placeholder="Jumlah Jam" required>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="button" class="btn btn-danger btn-remove-sm">x</button>
                </div>
            `;
                list.appendChild(newRow);
            });

            // 5. Tambah baris kebutuhan
            document.getElementById('add_kebutuhan_row').addEventListener('click', function() {
                const list = document.getElementById('kebutuhan_list');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'kebutuhan_row', 'mb-2');
                newRow.innerHTML = `
                <div class="col-md-11">
                    <input type="text" name="nama_kebutuhan[]" class="form-control" required>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="button" class="btn btn-danger btn-remove-sm">x</button>
                </div>
            `;
                list.appendChild(newRow);
            });

            // 6. Hapus baris (Pelatihan & Kebutuhan)
            document.addEventListener('click', function(e) {
                // Pastikan target klik adalah tombol dengan class 'btn-remove-sm'
                if (e.target.classList.contains('btn-remove-sm')) {
                    const row = e.target.closest('.pelatihan_row, .kebutuhan_row');

                    // Selalu hapus baris yang diklik
                    if (row) {
                        row.remove();
                    }
                }
            });

            // Pastikan Anda menutup fungsi anonymous, event listener DOMContentLoaded, dan tag script
        }); // Penutup DOMContentLoaded
    </script>
@endsection
