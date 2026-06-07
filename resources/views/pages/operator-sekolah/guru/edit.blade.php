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
                            <div class="col-md-8 offset-md-2">
                                <div class="mb-3">
                                    <label for="nama" class="form-label font-weight-bold">Nama Lengkap Guru</label>
                                    <input type="text" class="form-control" name="nama" id="nama" required value="{{ old('nama', $guru->nama) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="nip" class="form-label font-weight-bold">NIP (PNS/PPPK)</label>
                                    <input type="text" class="form-control" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="nuptk" class="form-label font-weight-bold">NUPTK</label>
                                    <input type="text" class="form-control" name="nuptk" id="nuptk" value="{{ old('nuptk', $guru->nuptk) }}">
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('data-guru.index') }}" class="btn btn-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
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
