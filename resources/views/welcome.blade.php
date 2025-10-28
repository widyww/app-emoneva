<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Emon & Eva - E-Monitoring dan Evaluasi Fasilitas TIK Dinas Pendidikan Provinsi Maluku</title>
    <meta name="description"
        content="Emon & Eva adalah aplikasi E-Monitoring dan Evaluasi Fasilitas Teknologi Informasi dan Komunikasi (TIK) di bawah Dinas Pendidikan Provinsi Maluku. Sistem ini membantu pemantauan, pelaporan, dan analisis data fasilitas TIK secara efektif dan transparan.">
    <meta name="keywords"
        content="Emon Eva, E-Monitoring, Evaluasi, Fasilitas TIK, Dinas Pendidikan Maluku, Monitoring Sekolah, Evaluasi TIK, Aplikasi Pendidikan, E-Government, Sistem Informasi Pendidikan">
    <meta name="author" content="Dinas Pendidikan Provinsi Maluku">

    <!-- Favicons -->
    <link href="{{ asset('images/logo/logo_pemprov.png') }}" rel="icon">
    <link href="{{ asset('images/logo/logo_pemprov.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('constructo/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('constructo/assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center dark-background">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a
                            href="mailto:contact@example.com">btkimalukuprov@gmail.com</a></i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>+6282198769133 </span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">

                    <a href="https://www.instagram.com/btki.dikbud_promal/" class="instagram"><i
                            class="bi bi-instagram"></i></a>
                    <a href="https://www.youtube.com/@btki.dikbud_promal" class="youtube"><i
                            class="bi bi-youtube"></i></a>




                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('homepage') }}" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="{{ asset('images/logo/logo_pemprov.png') }}"
                        alt="Logo Balai Teknologi Informasi dan Komunikasi" style="width: 40px;">
                    <h1 class="sitename">EMON & EVA</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="{{ route('homepage') }}" class="active">Home</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#">Statistik</a></li>

                        <li><a href="#contact">Hubungi Kami</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-right" data-aos-delay="200">
                            <span class="subtitle">EMON & EVA</span>
                            <h1>E-Monitoring dan Evaluasi Berbasis TIK</h1>
                            <p>"Data yang akurat adalah kunci menuju pendidikan yang lebih maju.
                                Melalui Emon & Eva, sekolah di Maluku bergerak bersama menuju transformasi digital."</p>


                            <div class="hero-buttons">
                                <a href="{{ route('login') }}" class="btn-primary">LOGIN</a>
                                <a href="#about" class="btn-secondary">TENTANG</a>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                        <div class="hero-image">
                            <img src="{{ asset('images/logo/emnitoringicon.png') }}"
                                alt="E-Monitoring dan E-Evaluasi Berbasis TIK" class="img-fluid">
                            <div class="image-badge">
                                <span>Balai Teknologi Informasi dan Komunikasi</span>
                                <p>Dinas Pendidikan Provinsi Maluku</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center g-5">
                    <div class="col-lg-12">
                        <div class="about-content" data-aos="fade-right" data-aos-delay="200">
                            <h2 class="fw-bold text-primary">Tentang Emon dan Eva</h2>
                            <p class="lead">
                                <strong>Emon dan Eva</strong> (Emonitoring dan Evaluasi) merupakan aplikasi berbasis
                                Teknologi Informasi dan Komunikasi (TIK)
                                yang dikembangkan oleh <strong>Balai Teknologi Informasi dan Komunikasi (BTIK)</strong>,
                                Dinas Pendidikan Provinsi Maluku.
                            </p>
                            <p>
                                Melalui aplikasi ini, seluruh sekolah di Provinsi Maluku dapat menginput dan memantau
                                data terkait <strong>fasilitas TIK sekolah</strong> serta data <strong>kompetensi
                                    guru</strong> dalam penguasaan teknologi digital.
                                Aplikasi ini membantu dinas pendidikan dalam melakukan pemetaan kebutuhan,
                                peningkatan kapasitas, dan perencanaan pengembangan TIK di sekolah-sekolah.
                            </p>

                            <div class="achievement-boxes row g-4 mt-4">
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                                    <div class="achievement-box">
                                        <h3>11</h3>
                                        <p>Kab/Kota Terintegrasi</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                                    <div class="achievement-box">
                                        <h3>1.000+</h3>
                                        <p>Sekolah Terdaftar</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="500">
                                    <div class="achievement-box">
                                        <h3>5.000+</h3>
                                        <p>Guru Terdata</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="600">
                                    <div class="achievement-box">
                                        <h3>100%</h3>
                                        <p>Monitoring Digital</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

            </div>

        </section>
        <!-- /About Section -->


        <!-- Kontak Kami Section -->
        <section id="contact" class="contact section light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-5 align-items-center">

                    <!-- Informasi Kontak -->
                    <div class="col-lg-6">
                        <div class="cta-hero-content" data-aos="fade-right" data-aos-delay="200">
                            <div class="badge-wrapper mb-3">
                                <span class="cta-badge">
                                    <i class="bi bi-envelope-check"></i>
                                    Hubungi Kami
                                </span>
                            </div>

                            <h2>Butuh Bantuan atau Informasi Lebih Lanjut?</h2>
                            <p>Jika Anda memiliki pertanyaan, saran, atau membutuhkan bantuan teknis terkait penggunaan
                                aplikasi
                                <strong>Emon &amp; Eva</strong>, silakan hubungi tim kami melalui formulir berikut atau
                                lewat kontak di bawah ini.
                            </p>

                            <div class="feature-highlights mt-4">
                                <div class="highlight-item">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>Balai Teknologi Informasi dan Komunikasi
                                        <br>Dinas Pendidikan Provinsi Maluku</span>
                                </div>
                                <div class="highlight-item">
                                    <i class="bi bi-telephone-fill"></i>
                                    <span>Telepon: (0911) 123-4567</span>
                                </div>
                                <div class="highlight-item">
                                    <i class="bi bi-envelope-fill"></i>
                                    <span>Email: <a
                                            href="mailto:baltikom@malukuprov.go.id">baltikom@malukuprov.go.id</a></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Kontak -->
                    <div class="col-lg-6">
                        <div class="cta-form-section" data-aos="fade-left" data-aos-delay="300">
                            <div class="form-container shadow-sm p-4 rounded bg-white">
                                <div class="form-header text-center mb-4">
                                    <h3>Kirim Pesan kepada Kami</h3>
                                    <p>Kami akan segera menanggapi pertanyaan Anda</p>
                                </div>

                                <form action="#" method="post" class="php-email-form">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Nama Lengkap" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Alamat Email" required>
                                        </div>
                                        <div class="col-12">
                                            <input type="tel" name="phone" class="form-control"
                                                placeholder="Nomor Telepon (opsional)">
                                        </div>
                                        <div class="col-12">
                                            <textarea name="message" class="form-control" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                        </div>
                                    </div>

                                    <div class="loading">Loading...</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>

                                    <div class="form-actions text-center mt-3">
                                        <button type="submit" class="btn btn-primary px-5">
                                            <i class="bi bi-send"></i> Kirim Pesan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Indikator Kepercayaan -->
                            <div class="trust-indicators mt-5 text-center" data-aos="fade-up" data-aos-delay="400">
                                <div class="row g-3 justify-content-center">
                                    <div class="col-4 col-md-3">
                                        <div class="trust-item">
                                            <i class="bi bi-clock fs-2"></i>
                                            <p class="mb-0 mt-2 small">Respon Cepat</p>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <div class="trust-item">
                                            <i class="bi bi-chat-dots fs-2"></i>
                                            <p class="mb-0 mt-2 small">Layanan Ramah</p>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <div class="trust-item">
                                            <i class="bi bi-people fs-2"></i>
                                            <p class="mb-0 mt-2 small">Tim Profesional</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>
        <!-- /Kontak Kami Section -->


    </main>

    <footer id="footer" class="footer dark-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">EMON DAN EVA PAKE BATIK</span>
                    </a>
                    <p class="lead">
                        <strong>Emon dan Eva</strong> (Emonitoring dan Evaluasi) merupakan aplikasi berbasis Teknologi
                        Informasi dan Komunikasi (TIK)
                        yang dikembangkan oleh <strong>Balai Teknologi Informasi dan Komunikasi (BTIK)</strong>,
                        Dinas Pendidikan Provinsi Maluku.
                    </p>
                    <div class="social-links d-flex mt-4">
                        <a href="https://www.instagram.com/btki.dikbud_promal/" class="instagram"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/@btki.dikbud_promal" class="youtube"><i
                                class="bi bi-youtube"></i></a>

                    </div>
                </div>

                <div class="col-lg-3 col-6 footer-links">
                    <h4>Link Terkait</h4>
                    <ul>
                        <li><a href="#">Dinas Pendidikan</a></li>
                        <li><a href="#">Pemerintah Provinsi Maluku</a></li>
                    </ul>
                </div>

                

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Alamat Kami</h4>
                    <p>Jl. Pemuda, Kel Amantelu, Kecamatan. Sirimau</p>
                    <p>Kota Ambon, Maluku</p>
                    <p>Indonesia</p>
                    <p class="mt-4"><strong>Phone:</strong> <span>+ 6282198769133</span></p>
                    <p><strong>Email:</strong> <span>btkimalukuprov@gmail.com</span></p>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span>
                <strong class="px-1 sitename">Balai Teknologi Informasi dan Komunikasi - Dinas Pendidikan dan
                    Kebudayaan Provinsi Maluku</strong>
                <span>{{ date('Y') }} All Rights Reserved</span>
            </p>


        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('constructo/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('constructo/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('constructo/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('constructo/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('constructo/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('constructo/assets/js/main.js') }}"></script>

</body>

</html>
