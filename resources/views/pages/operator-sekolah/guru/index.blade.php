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
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Data Guru
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
                    <span>Daftar Guru</span>
                    <a href="{{ route('data-guru.create') }}" class="btn btn-primary btn-sm">
                        + Tambah Guru
                    </a>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-sekolah">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Asal Sekolah</th>
                                    <th>Status</th>
                                    <th>NIP</th>
                                    <th>NUPTK</th>
                                    <th>Edit/Hapus</th>
                                    <th>Status</th>
                                    <th>Catatan Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->sekolah->nama }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->nuptk }}</td>
                                        <td class="text-center">
                                            @if ($item->status_verifikasi != 1)
                                                {{-- ✅ Bisa edit & hapus kalau belum terverifikasi --}}
                                                <a href="{{ route('data-guru.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $item->id }}" title="Hapus">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            @else
                                                {{-- ❌ Sudah terverifikasi, nonaktifkan tombol --}}
                                                <button class="btn btn-sm btn-secondary" disabled
                                                    title="Tidak dapat diubah">
                                                    <i data-feather="lock"></i>
                                                </button>
                                            @endif
                                        </td>

                                        <td>
                                            @switch($item->status_verifikasi)
                                                @case(0)
                                                    <span class="badge bg-warning d-inline-flex align-items-center">
                                                        <i data-feather="clock" class="me-1"></i> Menunggu Verifikasi
                                                    </span>
                                                @break

                                                @case(1)
                                                    <span class="badge bg-success d-inline-flex align-items-center">
                                                        <i data-feather="check-circle" class="me-1"></i> Terverifikasi
                                                    </span>
                                                @break

                                                @case(2)
                                                    <span class="badge bg-danger d-inline-flex align-items-center">
                                                        <i data-feather="x-circle" class="me-1"></i> Ditolak
                                                    </span>
                                                @break

                                                @case(3)
                                                    <span class="badge bg-primary d-inline-flex align-items-center">
                                                        <i data-feather="edit" class="me-1"></i> Revisi
                                                    </span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary d-inline-flex align-items-center">
                                                        <i data-feather="minus-circle" class="me-1"></i> -
                                                    </span>
                                            @endswitch

                                        </td>
                                        <td>{{ $item->catatan_verifikasi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




    </main>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.btn-delete').click(function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: "Data guru beserta pelatihan dan kebutuhan akan ikut terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan route name Laravel agar URL selalu sesuai
                        let url = '{{ route('data-guru.destroy', ':id') }}';
                        url = url.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'POST', // tetap POST, karena kita pakai _method DELETE
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal',
                                    'Terjadi kesalahan saat menghapus:\n' + xhr
                                    .responseText, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

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



    <script>
        $(document).ready(function() {
            $('#tabel-sekolah').DataTable();
            feather.replace(); // Untuk icon feather di modal
        });
    </script>
@endsection
