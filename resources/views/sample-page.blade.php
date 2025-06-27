@extends('layouts.navbar')
@yield('title')
@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="home"></i></div>
                                Pengaturan Data Kabupaten/Kota
                            </h1>
                            <div class="page-header-subtitle"></div>
                        </div>
                        <div class="col-12 col-xl-auto mt-4">Kabupaten/Kota</div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10">
            <div class="card">
                <div class="card-header">Tabel Kabupaten/Kota</div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </main>
@endsection
