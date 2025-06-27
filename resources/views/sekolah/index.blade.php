@extends('layouts.navbar')
@yield('title', 'Pengaturan Data Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Data Sekolah
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Pengaturan Data Sekolah</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Sekolah</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        + Tambah Sekolah
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-sekolah">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NPSN</th>
                                    <th>Nama Sekolah</th>
                                    <th>Tingkatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->npsn }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->tingkatan }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $item->id }}">
                                                <i data-feather="edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $item->id }}">
                                                <i data-feather="trash-2"></i>
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
                <form action="{{ route('sekolah.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Sekolah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>NPSN</label>
                            <input type="text" name="npsn" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tingkatan</label>
                            <select name="tingkatan" class="form-control" required>
                                <option value="">-- Pilih Tingkatan --</option>
                                <option value="SD">TK</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="SMK">SMK</option>
                                <option value="TKLB">TKLB</option>
                                <option value="SDLB">SDLB</option>
                                <option value="SMPLB">SMPLB</option>
                                <option value="SMALB">SMALB</option>
                                <option value="SLB">SLB</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nama Sekolah</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit & Hapus --}}
        @foreach ($data as $item)
            {{-- Modal Edit --}}
            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('sekolah.update', $item->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Sekolah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>NPSN</label>
                                <input type="text" name="npsn" class="form-control" value="{{ $item->npsn }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Nama Sekolah</label>
                                <input type="text" name="nama" class="form-control" value="{{ $item->nama }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>Tingkatan</label>
                                <select name="tingkatan" class="form-control" required>
                                    <option value="TKLB" {{ $item->tingkatan == 'TKLB' ? 'selected' : '' }}>TKLB</option>
                                    <option value="SDLB" {{ $item->tingkatan == 'SDLB' ? 'selected' : '' }}>SDLB</option>
                                    <option value="SMPLB" {{ $item->tingkatan == 'SMPLB' ? 'selected' : '' }}>SMPLB
                                    </option>
                                    <option value="SMALB" {{ $item->tingkatan == 'SMALB' ? 'selected' : '' }}>SMALB
                                    </option>
                                    <option value="SLB" {{ $item->tingkatan == 'SLB' ? 'selected' : '' }}>SLB</option>
                                    <option value="SD" {{ $item->tingkatan == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ $item->tingkatan == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ $item->tingkatan == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="SMK" {{ $item->tingkatan == 'SMK' ? 'selected' : '' }}>SMK</option>
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

            {{-- Modal Hapus --}}
            <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('sekolah.destroy', $item->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Hapus Sekolah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Yakin ingin menghapus <strong>{{ $item->npsn }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
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

    {{-- jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabel-sekolah').DataTable();
            feather.replace(); // Untuk icon feather di modal
        });
    </script>
@endsection
