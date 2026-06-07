@extends('layouts.navbar')
@section('title', 'Pengaturan Operator Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Pengaturan Data Operator Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Manajemen User Role Operator</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Operator Sekolah</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            + Tambah
                        </button>
                        <button class="btn btn-success btn-sm rounded-pill px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalUpload" style="background-color: #55d095; border-color: #55d095; color: #fff;">
                            <i data-feather="upload" style="width: 14px; height: 14px;"></i>
                            <span>Upload Excel</span>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-operator">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Operator</th>
                                    <th>NPSN</th>
                                    <th>Nama Sekolah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->sekolah->nama ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $item->id }}"><i data-feather="edit"
                                                    class="me-1"></i>Edit</button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $item->id }}"><i data-feather="trash"
                                                    class="me-1"></i>Hapus</button>
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
                <form action="{{ route('operator-sekolah.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Operator Sekolah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>NPSN Sekolah</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Sekolah</label>
                            <select name="sekolah_id" class="form-control" required>
                                <option value="" disabled selected>- Pilih Sekolah -</option>
                                @foreach ($sekolah as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit & Delete --}}
        @foreach ($users as $item)
            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('operator-sekolah.update', $item->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Operator</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ $item->name }}" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Email/NPSN</label>
                                <input type="text" name="email" value="{{ $item->email }}" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Sekolah</label>
                                <select name="sekolah_id" class="form-control" required>
                                    @foreach ($sekolah as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $item->sekolah_id == $s->id ? 'selected' : '' }}>{{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('operator-sekolah.destroy', $item->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Hapus Operator</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin ingin menghapus operator <strong>{{ $item->name }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Modal Upload Excel --}}
        <div class="modal fade" id="modalUpload" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('operator-sekolah.import') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Data Operator dari Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3 text-muted">
                            Pastikan file Excel memiliki susunan kolom sebagai berikut:
                            <br>
                            - <strong>Kolom A:</strong> Nama Operator
                            <br>
                            - <strong>Kolom B:</strong> NPSN Sekolah
                            <br>
                            - <strong>Kolom C:</strong> Telepon/WhatsApp (Opsional)
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
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabel-operator').DataTable();
            feather.replace();
        });
    </script>
@endsection
