@extends('layouts.navbar')
@section('title', 'Operator Sekolah - Mengisi Data Sosekbud Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="info"></i></div>
                                Kondisi Sosekbud : {{ $sekolah->nama }}
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Kondisi Sosekbud Sekolah</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Lengkapi Data Sosekbud</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('sosekbud-sekolah.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="kondisi_geografis" class="form-label">Kondisi Geografis</label>
                                    <textarea name="kondisi_geografis" id="kondisi_geografis" class="form-control" rows="3">{{ old('kondisi_geografis', $sekolah->sekolah_sosekbud->kondisi_geografis ?? '') }}</textarea>
                                    @error('kondisi_geografis')
                                        <small class="text-danger" style="font-family: Arial;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kondisi_sosekbud" class="form-label">Kondisi Sosial Ekonomi & Budaya</label>
                                    <textarea name="kondisi_sosekbud" id="kondisi_sosekbud" class="form-control" rows="3">{{ old('kondisi_sosekbud', $sekolah->sekolah_sosekbud->kondisi_sosekbud ?? '') }}</textarea>
                                    @error('kondisi_sosekbud')
                                        <small class="text-danger" style="font-family: Arial;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="akses_transportasi" class="form-label">Akses Transportasi</label>
                                    <textarea name="akses_transportasi" id="akses_transportasi" class="form-control" rows="3">{{ old('akses_transportasi', $sekolah->sekolah_sosekbud->akses_transportasi ?? '') }}</textarea>
                                    @error('akses_transportasi')
                                        <small class="text-danger" style="font-family: Arial;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
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
