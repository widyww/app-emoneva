@extends('layouts.navbar')
@section('title', 'Operator Sekolah - Mengisi Data Bantuan Yang Pernah Diterima')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="gift"></i></div>
                                Data Bantuan : {{ $sekolah->nama }}
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Data Bantuan</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Lengkapi Data Penerimaan Bantuan:</span>
                </div>
                <div class="card-body">
                    

                    <form action="{{ route('bantuan-sekolah.store') }}" method="POST" id="bantuanForm">
                        @csrf

                        <div class="mb-3">
                            <label for="status" class="form-label">Apakah sekolah menerima bantuan?</label>
                            <select name="status" id="status" class="form-select" required
                                onchange="toggleBantuanForm()">
                                <option value="">-- Pilih Status --</option>
                                <option value="ya" {{ old('status', $status->status ?? '') == 'ya' ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="tidak"
                                    {{ old('status', $status->status ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        <div id="bantuanSection" style="display: none;">
                            <h5>Detail Bantuan</h5>
                            <div id="bantuanList">
                                {{-- Baris inputan hanya muncul jika status = ya --}}
                                <div class="row mb-2 bantuan-item">
                                    <div class="col-md-5">
                                        <input type="text" name="nama_lembaga[]" class="form-control"
                                            placeholder="Nama Lembaga" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="keterangan_bantuan[]" class="form-control"
                                            placeholder="Keterangan Bantuan" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger"
                                            onclick="hapusBaris(this)">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mb-3" onclick="tambahBaris()">Tambah
                                Bantuan</button>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>



                    {{-- TAMPILAN DATA BANTUAN (DALAM CARD-BODY YANG SAMA) --}}
                    @if ($status && $status->status == 'ya' && count($bantuan))
                        <hr>
                        <h5 class="mb-3">Data Bantuan Tersimpan</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Lembaga</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bantuan as $item)
                                    <tr id="row-{{ $item->id }}">
                                        <td>{{ $item->nama_lembaga }}</td>
                                        <td>{{ $item->keterangan_bantuan }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="hapusBantuan({{ $item->id }})">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
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
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    </div>

    <script>
        function toggleBantuanForm() {
            const status = document.getElementById('status').value;
            const bantuanSection = document.getElementById('bantuanSection');
            const bantuanList = document.getElementById('bantuanList');

            if (status === 'ya') {
                bantuanSection.style.display = 'block';
                if (bantuanList.children.length === 0) {
                    tambahBaris(); // Auto tambah baris kalau kosong
                }
            } else {
                bantuanSection.style.display = 'none';
                bantuanList.innerHTML = ''; // Kosongkan jika bukan ya
            }
        }

        function tambahBaris() {
            const list = document.getElementById('bantuanList');
            const item = `
            <div class="row mb-2 bantuan-item">
                <div class="col-md-5">
                    <input type="text" name="nama_lembaga[]" class="form-control" placeholder="Nama Lembaga" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="keterangan_bantuan[]" class="form-control" placeholder="Keterangan Bantuan" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="hapusBaris(this)">Hapus</button>
                </div>
            </div>`;
            list.insertAdjacentHTML('beforeend', item);
        }

        function hapusBaris(button) {
            button.closest('.bantuan-item').remove();
        }

        // On load
        document.addEventListener('DOMContentLoaded', toggleBantuanForm);
    </script>

    <script>
        function hapusBantuan(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data bantuan akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = "{{ route('bantuan-sekolah.destroy', ['id' => '__id__']) }}".replace('__id__', id);
                    fetch(url, {
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error("Gagal menghapus");
                            }
                            return res.json();
                        })
                        .then(data => {
                            Swal.fire('Terhapus!', data.message ?? 'Data berhasil dihapus.', 'success');
                            document.getElementById('row-' + id)?.remove();
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        });
                }
            });
        }
    </script>


@endsection
