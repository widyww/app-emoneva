@extends('layouts.navbar')
@section('title', 'Operator Sekolah - Input Data Guru')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="info"></i></div>
                                Input Data Guru : {{ $sekolah->nama }}
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Data Guru</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Silahkan lengkapi data :</span>
                </div>

                <div class="card-body">
                    <form action="#" method="POST">
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
                                        <input type="text" class="form-control" name="nama" id="nama">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nip" class="col-sm-4 col-form-label">NIP (PNS/PPPK)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nip" id="nip">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tempat" class="col-sm-4 col-form-label">Tempat/Kota Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tempat" id="tempat">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Agama</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="agama">
                                            <option value="Kristen">Kristen</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Pendidikan Terakhir</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="pendidikan_terakhir">
                                            <option value="S3">Doktor-S3</option>
                                            <option value="S2">Magister-S2</option>
                                            <option value="S1/D4">Sarjana/Sarjana Terapan - S1/D4</option>
                                            <option value="D3">Diploma III - D3</option>
                                            <option value="D2">Diploma II - D2</option>
                                            <option value="SMA/SMK/Sederajat">SMA/SMK/Sederajat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">No Telepon</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="telepon" id="telepon">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Sudah Sertifikasi?</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="sertifikasi_status">
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="status">
                                            <option value="PNS">PNS</option>
                                            <option value="PPPK">PPPK</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nuptk" class="col-sm-4 col-form-label">NUPTK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nuptk" id="nuptk">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tgl_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" name="jenis_kelamin">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label">TMT PNS</label>
                                    <div class="col-sm-4">
                                        <select name="bulan" class="form-select">
                                            @foreach (range(1, 12) as $b)
                                                <option value="{{ str_pad($b, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select name="tahun" class="form-select">
                                            @for ($y = date('Y'); $y >= 1970; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="mapel" class="col-sm-4 col-form-label">Mata Pelajaran</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="mapel" id="mapel">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="sertifikasi_tahun" class="col-sm-4 col-form-label">Tahun
                                        Sertifikasi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="sertifikasi_tahun"
                                            id="sertifikasi_tahun">
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Kompetensi -->
                            <h3 class="mt-5">2. DATA KOMPETENSI & PELATIHAN</h3>
                            <hr>
                            <h5 class="mt-5">Kompetensi Kemampuan :</h5>
                            <hr>
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="kompetensi_word" class="col-sm-6 col-form-label">Microsoft Word</label>
                                    <div class="col-sm-6">
                                        <select name="kompetensi_word" id="kompetensi_word" class="form-select" required>
                                            <option value="3">Mahir</option>
                                            <option value="2">Menengah</option>
                                            <option value="1">Dasar</option>
                                            <option value="0">Tidak Memiliki</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="kompetensi_excel" class="col-sm-6 col-form-label">Microsoft Excel</label>
                                    <div class="col-sm-6">
                                        <select name="kompetensi_excel" id="kompetensi_excel" class="form-select"
                                            required>
                                            <option value="3">Mahir</option>
                                            <option value="2">Menengah</option>
                                            <option value="1">Dasar</option>
                                            <option value="0">Tidak Memiliki</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kompetensi_jaringan" class="col-sm-6 col-form-label">Jaringan
                                        Komputer</label>
                                    <div class="col-sm-6">
                                        <select name="kompetensi_powerpoin" id="kompetensi_powerpoin" class="form-select"
                                            required>
                                            <option value="3">Mahir</option>
                                            <option value="2">Menengah</option>
                                            <option value="1">Dasar</option>
                                            <option value="0">Tidak Memiliki</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="kompetensi_powerpoin" class="col-sm-6 col-form-label">Microsoft
                                        PowerPoint</label>
                                    <div class="col-sm-6">
                                        <select name="kompetensi_powerpoin" id="kompetensi_powerpoin" class="form-select"
                                            required>
                                            <option value="3">Mahir</option>
                                            <option value="2">Menengah</option>
                                            <option value="1">Dasar</option>
                                            <option value="0">Tidak Memiliki</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kompetensi_pemrogramman"
                                        class="col-sm-6 col-form-label">Pemrogramman</label>
                                    <div class="col-sm-6">
                                        <select name="kompetensi_pemrogramman" id="kompetensi_pemrogramman"
                                            class="form-select" required>
                                            <option value="3">Mahir</option>
                                            <option value="2">Menengah</option>
                                            <option value="1">Dasar</option>
                                            <option value="0">Tidak Memiliki</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kompetensi_pemrogramman" class="col-sm-6 col-form-label">Multimedia (Adobe
                                        Photoshop, Adobe Premiere, Capcut, dll)</label>
                                    <div class="col-sm-6">
                                        <select name="kompetensi_pemrogramman" id="kompetensi_pemrogramman"
                                            class="form-select" required>
                                            <option value="3">Mahir</option>
                                            <option value="2">Menengah</option>
                                            <option value="1">Dasar</option>
                                            <option value="0">Tidak Memiliki</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Pelatihan -->

                            <h5 class="mt-5">Pelatihan/Seminar/Workshop :</h5>
                            <hr>
                            <div class="col-md-6">
                                <div class="mb-3 row align-items-center">
                                    <label for="pelatihan_status" class="col-sm-4 col-form-label form-label fs-6">
                                        Pernah ikut pelatihan?
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="pelatihan_status" id="pelatihan_status" class="form-select"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            

                            <!-- Container untuk repeater -->
                            <div id="pelatihan_container" style="display: none;">
                                <label>Data Pelatihan</label>
                                <div id="pelatihan_list">
                                    <div class="row pelatihan_row mb-2">
                                        <div class="col-md-3">
                                            <input type="text" name="nama_pelatihan[]" class="form-control"
                                                placeholder="Nama Pelatihan" required>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="tingkatan[]" class="form-select" required>
                                                <option value="">Tingkatan</option>
                                                <option value="Dasar">Dasar</option>
                                                <option value="Menengah">Menengah</option>
                                                <option value="Mahir">Mahir</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="level[]" class="form-select" required>
                                                <option value="">Level</option>
                                                <option value="Lokal">Lokal</option>
                                                <option value="Nasional">Nasional</option>
                                                <option value="Internasional">Internasional</option>
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
                                </div>
                                <button type="button" class="btn btn-success mt-2" id="add_row">+Tambah</button>
                            </div>

                            <script>
                                // Tampilkan atau sembunyikan form pelatihan
                                document.getElementById('pelatihan_status').addEventListener('change', function() {
                                    const container = document.getElementById('pelatihan_container');
                                    container.style.display = this.value === 'Ya' ? 'block' : 'none';
                                });

                                // Tambah baris pelatihan
                                document.getElementById('add_row').addEventListener('click', function() {
                                    const pelatihanList = document.getElementById('pelatihan_list');
                                    const newRow = pelatihanList.querySelector('.pelatihan_row').cloneNode(true);

                                    // Kosongkan semua input di baris baru
                                    newRow.querySelectorAll('input, select').forEach(el => el.value = '');

                                    pelatihanList.appendChild(newRow);
                                });

                                // Hapus baris pelatihan
                                document.getElementById('pelatihan_list').addEventListener('click', function(e) {
                                    if (e.target.classList.contains('btn-remove')) {
                                        const rows = document.querySelectorAll('.pelatihan_row');
                                        if (rows.length > 1) {
                                            e.target.closest('.pelatihan_row').remove();
                                        } else {
                                            alert('Minimal 1 baris harus ada.');
                                        }
                                    }
                                });
                            </script>



                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
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
