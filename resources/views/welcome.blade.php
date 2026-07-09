<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>EMONEV - E-Monitoring dan Evaluasi Fasilitas TIK Dinas Pendidikan Provinsi Maluku</title>
    <meta name="description"
        content="EMONEV adalah aplikasi E-Monitoring dan Evaluasi Fasilitas Teknologi Informasi dan Komunikasi (TIK) di bawah Dinas Pendidikan Provinsi Maluku. Sistem ini membantu pemantauan, pelaporan, dan analisis data fasilitas TIK secara efektif dan transparan.">
    <meta name="keywords"
        content="EMONEV, E-Monitoring, Evaluasi, Fasilitas TIK, Dinas Pendidikan Maluku, Monitoring Sekolah, Evaluasi TIK, Aplikasi Pendidikan, E-Government, Sistem Informasi Pendidikan">
    <meta name="author" content="Dinas Pendidikan Provinsi Maluku">

    <!-- Favicons -->
    <link href="{{ asset('images/logo/logo_pemprov.png') }}" rel="icon">
    <link href="{{ asset('images/logo/logo_pemprov.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('constructo/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('constructo/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('constructo/assets/css/main.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4c6ef5;
            --primary-dark: #3b5bdb;
            --secondary-color: #64748b;
            --bg-light: #f4f6fc;
            
            /* Overriding template variables */
            --default-font: 'Inter', sans-serif !important;
            --heading-font: 'Inter', sans-serif !important;
            --nav-font: 'Inter', sans-serif !important;
            
            --background-color: #f4f6fc !important;
            --default-color: #334155 !important;
            --heading-color: #0f172a !important;
            --accent-color: #4c6ef5 !important;
            --surface-color: #ffffff !important;
            
            --nav-color: #475569 !important;
            --nav-hover-color: #4c6ef5 !important;
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f4f6fc !important;
            color: #334155 !important;
        }

        .dark-background {
            --background-color: var(--primary-dark) !important;
            --default-color: #ffffff !important;
            --heading-color: #ffffff !important;
            --accent-color: #ffffff !important;
            --surface-color: #1e293b !important;
            --contrast-color: #ffffff !important;
        }

        /* Topbar & Branding */
        .header {
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 20px rgba(76, 110, 245, 0.02) !important;
        }
        
        .header .logo h1 {
            font-family: 'Inter', sans-serif !important;
            font-weight: 800 !important;
            color: var(--primary-color) !important;
            font-size: 1.6rem !important;
            letter-spacing: 0.5px;
        }

        .navmenu a {
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            color: #475569 !important;
        }
        
        .navmenu a:hover, .navmenu .active {
            color: var(--primary-color) !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #7c9aff 0%, #4c6ef5 100%) !important;
            padding: 120px 0 !important;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '' !important;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 1440 900' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M-100 200 C300 150 500 450 900 300 C1300 150 1400 400 1600 350 L1600 900 L-100 900 Z' fill='white' fill-opacity='0.06'/%3E%3Cpath d='M-100 400 C400 450 600 200 1000 350 C1400 500 1500 250 1600 300 L1600 900 L-100 900 Z' fill='white' fill-opacity='0.06'/%3E%3C/svg%3E") !important;
            background-size: cover;
            background-position: center;
            pointer-events: none;
            display: block !important;
            opacity: 1 !important;
            z-index: 0;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }

        .hero .container {
            position: relative;
            z-index: 5;
        }

        .hero .hero-content .subtitle {
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px !important;
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.15) !important;
            padding: 6px 16px !important;
            border-radius: 50px !important;
            display: inline-flex !important;
            align-items: center !important;
            margin-bottom: 20px !important;
        }
        
        .hero .hero-content .subtitle::before {
            display: none !important;
        }
        
        .hero .hero-content h1 {
            font-size: 3.2rem !important;
            font-weight: 800 !important;
            color: #ffffff !important;
            line-height: 1.15 !important;
            margin-bottom: 24px !important;
        }
        
        .hero .hero-content p {
            font-size: 1.1rem !important;
            color: rgba(255, 255, 255, 0.9) !important;
            line-height: 1.6 !important;
            margin-bottom: 35px !important;
        }
        
        .hero .hero-buttons .btn-primary {
            background-color: #ffffff !important;
            color: #4c6ef5 !important;
            border: none !important;
            border-radius: 50px !important;
            padding: 14px 36px !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
        }
        
        .hero .hero-buttons .btn-primary:hover {
            background-color: #f8fafc !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
        }
        
        .hero .hero-buttons .btn-secondary {
            border: 2px solid #ffffff !important;
            background-color: transparent !important;
            color: #ffffff !important;
            border-radius: 50px !important;
            padding: 14px 36px !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            transition: all 0.3s ease !important;
        }
        
        .hero .hero-buttons .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            transform: translateY(-2px) !important;
        }
        
        .hero .hero-image {
            border-radius: 24px !important;
            box-shadow: 0 20px 50px rgba(76, 110, 245, 0.08) !important;
            background-color: #ffffff;
            border: 1px solid #f1f5f9;
        }
        
        .hero .hero-image img {
            border-radius: 24px !important;
        }
        
        .hero .hero-image .image-badge {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            border-radius: 16px !important;
            padding: 18px 24px !important;
            box-shadow: 0 10px 25px rgba(76, 110, 245, 0.2) !important;
            bottom: 25px !important;
            left: 25px !important;
            border: none !important;
        }
        
        .hero .hero-image .image-badge span {
            font-size: 1.05rem !important;
            font-weight: 700 !important;
            margin-bottom: 4px;
        }
        
        .hero .hero-image .image-badge p {
            font-size: 0.85rem !important;
            opacity: 0.9 !important;
        }

        /* About Section */
        .about {
            padding: 80px 0 !important;
            background-color: #ffffff !important;
        }
        
        .about .about-content h2 {
            font-size: 2.2rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 20px !important;
        }
        
        .about .about-content h2::after {
            display: none !important;
        }
        
        .about .about-content .lead {
            font-size: 1.15rem !important;
            color: #334155 !important;
            font-weight: 500 !important;
            line-height: 1.6 !important;
        }
        
        .about .about-content p {
            color: #475569 !important;
            font-size: 1rem !important;
        }
        
        /* Dashboard-like Statistic Cards for About Section */
        .achievement-boxes .card {
            border: none !important;
            border-radius: 20px !important;
            transition: all 0.3s ease !important;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
        }

        .achievement-boxes .card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
        }

        .achievement-boxes .card.bg-primary {
            background: linear-gradient(135deg, #6c8cff 0%, #4c6ef5 100%) !important;
            box-shadow: 0 10px 25px rgba(76, 110, 245, 0.25) !important;
        }
        
        .achievement-boxes .card.bg-warning {
            background: linear-gradient(135deg, #ffc078 0%, #f76707 100%) !important;
            box-shadow: 0 10px 25px rgba(247, 103, 7, 0.25) !important;
        }
        
        .achievement-boxes .card.bg-success {
            background: linear-gradient(135deg, #63e6be 0%, #0ca678 100%) !important;
            box-shadow: 0 10px 25px rgba(12, 166, 120, 0.25) !important;
        }
        
        .achievement-boxes .card.bg-danger {
            background: linear-gradient(135deg, #ff8787 0%, #e03131 100%) !important;
            box-shadow: 0 10px 25px rgba(224, 49, 49, 0.25) !important;
        }

        .achievement-boxes .card .card-body {
            padding: 1.5rem !important;
        }

        .achievement-boxes .card .text-white-75 {
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 0.725rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            text-transform: uppercase;
        }

        /* Call To Action & Contact */
        .call-to-action {
            background-color: #f4f6fc !important;
            padding: 80px 0 !important;
        }
        
        .call-to-action .cta-hero-content .cta-badge {
            background-color: rgba(37, 117, 252, 0.1) !important;
            color: var(--primary-color) !important;
            border-radius: 50px !important;
            padding: 6px 16px !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }
        
        .call-to-action .cta-hero-content h2 {
            font-size: 2.4rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1.2 !important;
            margin-bottom: 20px !important;
        }
        
        .call-to-action .cta-hero-content p {
            font-size: 1rem !important;
            color: #475569 !important;
            line-height: 1.6 !important;
        }
        
        .call-to-action .cta-hero-content .feature-highlights .highlight-item {
            background-color: #ffffff !important;
            padding: 16px 20px !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02) !important;
            border: 1px solid #f1f5f9 !important;
            margin-bottom: 12px;
        }
        
        .call-to-action .cta-hero-content .feature-highlights .highlight-item i {
            color: var(--primary-color) !important;
            font-size: 1.25rem !important;
        }
        
        .call-to-action .cta-hero-content .feature-highlights .highlight-item span {
            font-size: 0.95rem !important;
            color: #334155 !important;
            font-weight: 600 !important;
            line-height: 1.5 !important;
        }
        
        .call-to-action .cta-form-section .form-container {
            background-color: #ffffff !important;
            border-radius: 20px !important;
            padding: 35px !important;
            box-shadow: 0 15px 35px rgba(76, 110, 245, 0.04) !important;
            border: 1px solid #e2e8f0 !important;
        }
        
        .call-to-action .cta-form-section .form-header h3 {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 6px !important;
        }
        
        .call-to-action .cta-form-section .form-header p {
            font-size: 0.9rem !important;
            color: #64748b !important;
        }
        
        .call-to-action .cta-form-section .form-control {
            border-radius: 12px !important;
            border: 1.5px solid #f1f5f9 !important;
            padding: 12px 16px !important;
            font-size: 0.95rem !important;
            color: #1e293b !important;
            background-color: #f8fafc !important;
            font-weight: 500 !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.01), 0 2px 8px rgba(0,0,0,0.02) !important;
            transition: all 0.2s ease-in-out !important;
        }
        
        .call-to-action .cta-form-section .form-control:focus {
            background-color: #ffffff !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 10px 25px rgba(76, 110, 245, 0.08) !important;
            outline: none !important;
        }
        
        .call-to-action .cta-form-section button[type="submit"] {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 50px !important;
            padding: 12px 36px !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            box-shadow: 0 6px 16px rgba(76, 110, 245, 0.2) !important;
            transition: all 0.3s ease !important;
        }
        
        .call-to-action .cta-form-section button[type="submit"]:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 24px rgba(76, 110, 245, 0.3) !important;
        }
        
        .call-to-action .trust-indicators .trust-item {
            background-color: #ffffff !important;
            padding: 15px 10px !important;
            border-radius: 12px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.01) !important;
        }
        
        .call-to-action .trust-indicators .trust-item i {
            color: var(--primary-color) !important;
        }
        
        .call-to-action .trust-indicators .trust-item p {
            color: #475569 !important;
            font-weight: 600 !important;
        }

        /* Footer */
        .footer {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
            padding: 60px 0 30px !important;
            border-top: none !important;
        }
        
        .footer .footer-about .logo span {
            color: #ffffff !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 800 !important;
        }
        
        .footer h4 {
            color: #ffffff !important;
            border-bottom: 2px solid #1e293b !important;
            font-family: 'Inter', sans-serif !important;
            padding-bottom: 10px !important;
            margin-bottom: 20px !important;
        }
        
        .footer .footer-links ul li a {
            color: #94a3b8 !important;
            transition: color 0.2s ease !important;
        }
        
        .footer .footer-links ul li a:hover {
            color: var(--primary-color) !important;
        }
        
        .footer .social-links a {
            border: 1px solid #334155 !important;
            color: #94a3b8 !important;
            background-color: #1e293b !important;
        }
        
        .footer .social-links a:hover {
            color: #ffffff !important;
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        .footer .copyright {
            background-color: #020617 !important;
            border-top: 1px solid #1e293b !important;
            padding: 20px 0 !important;
            color: #64748b !important;
        }
    </style>

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
                    <h1 class="sitename">EMONEV</h1>
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
                            <span class="subtitle">EMONEV</span>
                            <h1>E-Monitoring dan Evaluasi Berbasis TIK</h1>
                            <p>"Data yang akurat adalah kunci menuju pendidikan yang lebih maju.
                                Melalui EMONEV, sekolah di Maluku bergerak bersama menuju transformasi digital."</p>


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
                            <h2 class="fw-bold text-primary">Tentang EMONEV</h2>
                            <p class="lead">
                                <strong>EMONEV</strong> (Emonitoring dan Evaluasi) merupakan aplikasi berbasis
                                Teknologi Informasi dan Komunikasi (TIK)
                                yang dikembangkan oleh <strong>Balai Teknologi Informasi dan Komunikasi (BTIK)</strong>,
                                Dinas Pendidikan Provinsi Maluku.
                            </p>
                            <p>
                                Melalui aplikasi ini, seluruh sekolah di Provinsi Maluku dapat menginput dan memantau
                                data terkait <strong>fasilitas TIK sekolah</strong> — meliputi kelistrikan,
                                laboratorium komputer, dan konektivitas internet — beserta kesiapan penyelenggaraan
                                asesmen berbasis komputer.
                                Aplikasi ini membantu dinas pendidikan dalam melakukan pemetaan kebutuhan,
                                penyaluran bantuan, dan perencanaan pengembangan TIK di sekolah-sekolah.
                            </p>

                            <div class="achievement-boxes row g-4 mt-4">
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                                    <div class="card bg-primary text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">KAB/KOTA</div>
                                                    <div class="text-lg fw-bold fs-3 mt-1">11</div>
                                                </div>
                                                <i class="bi bi-geo-alt fs-2 text-white-50"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                                    <div class="card bg-warning text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">SEKOLAH</div>
                                                    <div class="text-lg fw-bold fs-3 mt-1">1.000+</div>
                                                </div>
                                                <i class="bi bi-building fs-2 text-white-50"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="500">
                                    <div class="card bg-success text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">LAB KOMPUTER</div>
                                                    <div class="text-lg fw-bold fs-3 mt-1">500+</div>
                                                </div>
                                                <i class="bi bi-pc-display fs-2 text-white-50"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="600">
                                    <div class="card bg-danger text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small">MONITORING</div>
                                                    <div class="text-lg fw-bold fs-3 mt-1">100%</div>
                                                </div>
                                                <i class="bi bi-check2-square fs-2 text-white-50"></i>
                                            </div>
                                        </div>
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
        <section id="contact" class="contact call-to-action section light-background">

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
                                <strong>EMONEV</strong>, silakan hubungi tim kami melalui formulir berikut atau
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
                        <span class="sitename">EMONEV</span>
                    </a>
                    <p class="lead">
                        <strong>EMONEV</strong> (Emonitoring dan Evaluasi) merupakan aplikasi berbasis Teknologi
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
