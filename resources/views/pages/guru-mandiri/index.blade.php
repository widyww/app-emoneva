@extends('layouts.navbar')
@section('title', 'Pengaturan Guru Mandiri')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Pengaturan Data Guru
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Manajemen Data Guru</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Guru</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            + Tambah Guru
                        </button>
                        <button class="btn btn-success btn-sm rounded-pill px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalUpload" style="background-color: #55d095; border-color: #55d095; color: #fff;">
                            <i data-feather="upload" style="width: 14px; height: 14px;"></i>
                            <span>Upload Excel</span>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-guru">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>NIP</th>
                                    <th>NUPTK</th>
                                    <th>Asal Sekolah</th>
                                    <th>No. Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guruList as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nip ?? '-' }}</td>
                                        <td>{{ $item->nuptk ?? '-' }}</td>
                                        <td>{{ $item->sekolah->nama ?? '-' }}</td>
                                        <td>{{ $item->telepon ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning btn-edit"
                                                data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama }}"
                                                data-nuptk="{{ $item->nuptk ?? '' }}"
                                                data-nip="{{ $item->nip ?? '' }}"
                                                data-telepon="{{ $item->telepon ?? '' }}"
                                                data-sekolah_id="{{ $item->sekolah_id }}"
                                                data-email="{{ $item->user->email ?? '' }}">
                                                <i data-feather="edit" class="me-1"></i>Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger btn-hapus"
                                                data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama }}">
                                                <i data-feather="trash" class="me-1"></i>Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('guru-mandiri.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">NUPTK</label>
                            <input type="text" name="nuptk" class="form-control" value="{{ old('nuptk') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">No. Telepon / WA</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Sekolah</label>
                            <select name="sekolah_id" class="form-control" required>
                                <option value="" disabled selected>- Pilih Sekolah -</option>
                                @foreach ($sekolah as $s)
                                    <option value="{{ $s->id }}" {{ old('sekolah_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama }} ({{ $s->npsn }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <hr>
                        
                        <!-- Toggle Buat Akun User -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="switchCreateUser" name="create_user" value="1" onchange="toggleUserFields(this)">
                            <label class="form-check-label font-weight-bold" for="switchCreateUser">Buat Akun User Login Sekaligus</label>
                        </div>
                        
                        <div id="userFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Email Login</label>
                                <input type="email" id="inputEmail" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Password Login</label>
                                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Minimal 6 karakter">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Single Modal Edit --}}
        <div class="modal fade" id="modalEdit" tabindex="-1">
            <div class="modal-dialog">
                <form id="formEdit" action="" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data & Akun Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Lengkap</label>
                            <input type="text" id="editNama" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">NUPTK</label>
                            <input type="text" id="editNuptk" name="nuptk" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">NIP</label>
                            <input type="text" id="editNip" name="nip" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">No. Telepon / WA</label>
                            <input type="text" id="editTelepon" name="telepon" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Sekolah</label>
                            <select id="editSekolahId" name="sekolah_id" class="form-control" required>
                                @foreach ($sekolah as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->npsn }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <hr>
                        <h6 class="text-primary font-weight-bold mb-3">Informasi Akun Login</h6>
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Email Login</label>
                            <input type="email" id="editEmail" name="email" class="form-control" placeholder="Masukkan email untuk membuat/mengubah akun login">
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Password Login</label>
                            <input type="password" id="editPassword" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Single Modal Hapus --}}
        <div class="modal fade" id="modalHapus" tabindex="-1">
            <div class="modal-dialog">
                <form id="formHapus" action="" method="POST" class="modal-content">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus guru <strong id="hapusNama"></strong> beserta akun user-nya (jika ada) dari database?</p>
                        <div class="text-xs text-danger mt-1">* Peringatan: Tindakan ini akan menghapus seluruh data kompetensi TIK dan riwayat pelatihan guru ini secara permanen.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Upload Excel --}}
        <div class="modal fade" id="modalUpload" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('guru-mandiri.import') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Data Guru dari Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3 text-muted">
                            Pastikan file Excel memiliki susunan kolom sebagai berikut:
                            <br>
                            - <strong>Kolom A:</strong> Nama Guru (Wajib)
                            <br>
                            - <strong>Kolom B:</strong> NIP (Opsional)
                            <br>
                            - <strong>Kolom C:</strong> NUPTK (Opsional)
                            <br>
                            - <strong>Kolom D:</strong> No. Telepon/WA (Opsional)
                            <br>
                            - <strong>Kolom E:</strong> NPSN Sekolah (Wajib)
                            <br>
                            - <strong>Kolom F:</strong> Email Akun Login (Opsional)
                            <br>
                            - <strong>Kolom G:</strong> Password Akun Login (Opsional)
                        </p>
                        <div class="mb-3">
                            <label class="form-label">Pilih File Excel (.xlsx / .xls)</label>
                            <input type="file" name="file" accept=".xlsx,.xls" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-success" type="submit" style="background-color: #55d095; border-color: #55d095;">Upload</button>
                    </div>
                </form>
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

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        @endif

        function toggleUserFields(checkbox) {
            var fields = document.getElementById('userFields');
            var email = document.getElementById('inputEmail');
            var pass = document.getElementById('inputPassword');
            if (checkbox.checked) {
                fields.style.display = 'block';
                email.required = true;
                pass.required = true;
            } else {
                fields.style.display = 'none';
                email.required = false;
                pass.required = false;
                email.value = '';
                pass.value = '';
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#tabel-guru').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100]
            });

            // Handle Tombol Edit
            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let nuptk = $(this).data('nuptk');
                let nip = $(this).data('nip');
                let telepon = $(this).data('telepon');
                let sekolahId = $(this).data('sekolah_id');
                let email = $(this).data('email');

                // Set Action URL
                let actionUrl = "{{ route('guru-mandiri.update', ':id') }}".replace(':id', id);
                $('#formEdit').attr('action', actionUrl);

                // Populate Inputs
                $('#editNama').val(nama);
                $('#editNuptk').val(nuptk);
                $('#editNip').val(nip);
                $('#editTelepon').val(telepon);
                $('#editSekolahId').val(sekolahId);
                $('#editEmail').val(email);
                
                // Reset password input
                $('#editPassword').val('');
                if (email) {
                    $('#editPassword').attr('placeholder', 'Biarkan kosong jika tidak diubah');
                } else {
                    $('#editPassword').attr('placeholder', 'Wajib diisi jika baru membuat akun');
                }

                // Show Modal
                $('#modalEdit').modal('show');
            });

            // Handle Tombol Hapus
            $('.btn-hapus').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');

                // Set Action URL
                let actionUrl = "{{ route('guru-mandiri.destroy', ':id') }}".replace(':id', id);
                $('#formHapus').attr('action', actionUrl);

                // Set Nama
                $('#hapusNama').text(nama);

                // Show Modal
                $('#modalHapus').modal('show');
            });
            feather.replace();
        });
    </script>
@endsection
