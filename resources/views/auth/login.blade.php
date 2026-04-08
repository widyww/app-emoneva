<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>E-MONITORING DAN EVALUASI (e-Monitoring dan e-Evaluasi Berbasis TIK | Balai Teknologi Informasi dan Komunikasi |
        Dinas Pendidikan Provinsi Maluku) - Halaman Login</title>
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header text-center">
                                    <img src="{{ asset('sbadmin/assets/img/logo_pemprov.png') }}" alt="Logo Pemprov"
                                        class="mb-3" style="max-height: 120px;">

                                    <h1 class="text-uppercase text-dark mb-2">E-Monitoring dan Evaluasi Fasilitas TIK dan Kompetensi Guru SMA Se-Maluku</h1>

                                    <h4 class="text-uppercase">Balai Teknologi Informasi dan Komunikasi</h4>
                                    <h3 class="text-uppercase mb-3">Dinas Pendidikan Provinsi Maluku</h3>

                                    <p class="text-dark small">
                                        Bagi Operator Sekolah silakan login menggunakan <strong>NPSN Sekolah</strong>
                                    </p>
                                </div>



                                <div class="card-body">
                                    <!-- Login form-->
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <!-- Form Group (email address)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="email">NPSN / Email</label>
                                            <input class="form-control" id="email" type="text" name="email"
                                                placeholder="Masukkan NPSN atau email" required autofocus />
                                        </div>
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control" id="password" type="password" name="password"
                                                placeholder="Masukkan password" required />
                                        </div>
                                        <!-- Remember me -->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="remember_me" type="checkbox"
                                                    name="remember">
                                                <label class="form-check-label" for="remember_me">Ingat saya</label>
                                            </div>
                                        </div>
                                        <!-- Submit -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">Lupa password?</a>
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="card-footer text-center">
                                    <div class="small">
                                        <a href="https://wa.me/6282198769133" target="_blank"
                                            class="text-success text-decoration-none">
                                            <img src="{{ asset('sbadmin/assets/img/logo_wa.png') }}" alt="WhatsApp"
                                                width="20" class="me-1">
                                            Jika ada pertanyaan? SILAHKAN HUBUNGI ADMIN E-Monitoring dan Evaluasi via WhatsApp
                                        </a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; E-Monitoring dan Evaluasi Fasilitas TIK dan Kompetensi Guru SMA Se-Maluku {{ now()->year }}</div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
</body>

</html>
