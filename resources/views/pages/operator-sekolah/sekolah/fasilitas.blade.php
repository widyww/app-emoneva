@extends('layouts.navbar')
@section('title', 'Operator Sekolah - Pengisian Data Fasilitas TIK')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="info"></i></div>
                                Data Fasilitas TIK : {{ $sekolah->nama }}
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Data Fasilitas TIK</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Lengkapi Data Fasilitas TIK di Sekolah</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('fasilitas-sekolah.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            {{-- Listrik --}}
                            <div class="col-md-4 mb-3">
                                <label>Sumber Listrik</label>
                                <select name="listrik_sumber" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="PLN"
                                        {{ old('listrik_sumber', $fasilitas->listrik_sumber ?? '') == 'PLN' ? 'selected' : '' }}>
                                        PLN</option>
                                    <option value="Genset"
                                        {{ old('listrik_sumber', $fasilitas->listrik_sumber ?? '') == 'Genset' ? 'selected' : '' }}>
                                        Genset</option>
                                    <option value="Tidak Ada"
                                        {{ old('listrik_sumber', $fasilitas->listrik_sumber ?? '') == 'Tidak Ada' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Durasi Listrik Aktif (jam/hari)</label>
                                <input type="number" name="listrik_durasi" class="form-control"
                                    value="{{ old('listrik_durasi', $fasilitas->listrik_durasi ?? '') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Status Listrik</label>
                                <select name="listrik_status" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="ada"
                                        {{ old('listrik_status', $fasilitas->listrik_status ?? '') == 'ada' ? 'selected' : '' }}>
                                        Ada</option>
                                    <option value="tidak"
                                        {{ old('listrik_status', $fasilitas->listrik_status ?? '') == 'tidak' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>

                            {{-- Komputer --}}
                            <div class="col-md-4 mb-3">
                                <label>Jumlah Komputer/PC</label>
                                <input type="number" name="jumlah_kom" class="form-control"
                                    value="{{ old('jumlah_kom', $fasilitas->jumlah_kom ?? '') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Lab Komputer</label>
                                <select name="labkom_status" id="labkom_status" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="ada"
                                        {{ old('labkom_status', $fasilitas->labkom_status ?? '') == 'ada' ? 'selected' : '' }}>
                                        Ada</option>
                                    <option value="tidak"
                                        {{ old('labkom_status', $fasilitas->labkom_status ?? '') == 'tidak' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>

                            {{-- Internet --}}
                            <div class="col-md-4 mb-3">
                                <label>Status Internet</label>
                                <select name="internet_status" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="ada"
                                        {{ old('internet_status', $fasilitas->internet_status ?? '') == 'ada' ? 'selected' : '' }}>
                                        Ada</option>
                                    <option value="tidak"
                                        {{ old('internet_status', $fasilitas->internet_status ?? '') == 'tidak' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Sumber Internet</label>
                                <select name="internet_sumber" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Indihome"
                                        {{ old('internet_sumber', $fasilitas->internet_sumber ?? '') == 'Indihome' ? 'selected' : '' }}>
                                        Indihome</option>
                                    <option value="Starlink"
                                        {{ old('internet_sumber', $fasilitas->internet_sumber ?? '') == 'Starlink' ? 'selected' : '' }}>
                                        Starlink</option>
                                    <option value="Lainnya"
                                        {{ old('internet_sumber', $fasilitas->internet_sumber ?? '') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Bandwidth (Mbps)</label>
                                <input type="number" name="internet_bandwith" class="form-control"
                                    value="{{ old('internet_bandwith', $fasilitas->internet_bandwith ?? '') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Topologi Jaringan</label>
                                <select name="topologi_jaringan" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="LAN"
                                        {{ old('topologi_jaringan', $fasilitas->topologi_jaringan ?? '') == 'LAN' ? 'selected' : '' }}>
                                        LAN</option>
                                    <option value="Wireless"
                                        {{ old('topologi_jaringan', $fasilitas->topologi_jaringan ?? '') == 'Wireless' ? 'selected' : '' }}>
                                        Wireless</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Kesesuaian Internet</label>
                                <select name="internet_kesesuaian" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Sesuai"
                                        {{ old('internet_kesesuaian', $fasilitas->internet_kesesuaian ?? '') == 'Sesuai' ? 'selected' : '' }}>
                                        Sesuai</option>
                                    <option value="Tidak Sesuai"
                                        {{ old('internet_kesesuaian', $fasilitas->internet_kesesuaian ?? '') == 'Tidak Sesuai' ? 'selected' : '' }}>
                                        Tidak Sesuai</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Alasan Kuota Tidak Sesuai</label>
                                <textarea name="internet_alasankuota" class="form-control" rows="2">{{ old('internet_alasankuota', $fasilitas->internet_alasankuota ?? '') }}</textarea>
                            </div>

                            {{-- Saran --}}
                            <div class="col-12 mb-3">
                                <label>Saran Pengembangan</label>
                                <textarea name="saran_pengembangan" class="form-control" rows="3">{{ old('saran_pengembangan', $fasilitas->saran_pengembangan ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Bagian Lab Komputer --}}
                        <div id="labkom-wrapper"
                            style="{{ old('labkom_status', $fasilitas->labkom_status ?? '') !== 'ada' ? 'display: none;' : '' }}">
                            <hr>
                            <h5>Detail Lab Komputer</h5>
                            <div id="labkom-list">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <input type="text" name="labkom_nama[]" class="form-control"
                                            placeholder="Nama Lab Komputer">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="labkom_jumlah_pc[]" class="form-control"
                                            placeholder="Jumlah PC">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-remove-labkom w-10"> X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-labkom"
                                title="Tambah Lab">
                                <i data-feather="plus"></i>
                            </button>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                        </div>
                    </form>

                    <hr>
                    @if ($fasilitas && $fasilitas->labkom_status === 'ada' && $fasilitas->SekolahFasilitasLab->count())
                        <h5>Daftar Laboratorium Komputer</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lab Komputer</th>
                                    <th>Jumlah PC</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fasilitas->SekolahFasilitasLab as $i => $lab)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $lab->labkom_nama }}</td>
                                        <td>{{ $lab->labkom_jumlah_pc }}</td>
                                        <td>
                                            <form action="{{ route('fasilitas-sekolah-lab.destroy', $lab->id) }}"
                                                method="POST" class="form-delete-lab">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-lab">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Tidak ada data lab komputer yang tersedia.</p>
                    @endif




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


    <script>
        document.getElementById('labkom_status').addEventListener('change', function() {
            const wrapper = document.getElementById('labkom-wrapper');
            wrapper.style.display = this.value === 'ada' ? 'block' : 'none';
        });

        document.getElementById('btn-tambah-labkom').addEventListener('click', function() {
            const container = document.getElementById('labkom-list');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2';
            newRow.innerHTML =
                '<div class = "col-md-6" ><input type = "text" name = "labkom_nama[]" class = "form-control" placeholder = "Nama Lab Komputer" ></div> <div class = "col-md-4" ><input type = "number" name = "labkom_jumlah_pc[]" class = "form-control" placeholder = "Jumlah PC" ></div> <div class = "col-md-2" ><button type="button" class="btn btn-danger btn-remove-labkom w-10"> X</button> </div>';
            container.appendChild(newRow);
        });



        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove-labkom')) {
                e.target.closest('.row').remove();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete-lab').forEach(function(button) {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>


@endsection
