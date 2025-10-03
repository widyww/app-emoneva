@extends('layouts.navbar')
@yield('title', 'Verifikasi Data Guru')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="check"></i></div>
                                Verfikasi Data Guru
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Verifikasi Data Guru</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Guru</span>


                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-sekolah">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asal</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>NIP</th>
                                    <th>NUPTK</th>
                                    <th>Detail</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->sekolah->nama ?? '-' }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->nuptk }}</td>
                                        <td>
                                            <a href="{{ route('verifikasi-proses.show', $item->id) }}"
                                                class="btn btn-info btn-sm">
                                                LIHAT
                                            </a>
                                            <form action="{{ route('verifikasi-proses.approve', $item->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    SETUJU
                                                </button>
                                            </form>

                                            <a href="{{ route('verifikasi-proses.update', $item->id) }}"
                                                class="btn btn-danger btn-sm">
                                                TOLAK
                                            </a>
                                        </td>
                                        <td>
                                            @switch($item->status_verifikasi)
                                                @case(0)
                                                    <span class="badge bg-warning">Waiting</span>
                                                @break

                                                @case(1)
                                                    <span class="badge bg-success">Approved</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">-</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $item->catatan_verifikasi ?? '-' }}</td>

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
