<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Halaman Login EMONEV BTIK Dinas Pendidikan Provinsi Maluku" />
    <meta name="author" content="EMONEV" />
    <title>EMONEV BTIK - Halaman Login</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #7c9aff 0%, #4c6ef5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Abstract Background Elements */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: -200px;
            left: -200px;
            filter: blur(80px);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            bottom: -250px;
            right: -250px;
            filter: blur(95px);
            pointer-events: none;
        }

        .background-curve {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .background-curve svg {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.35;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 1050px;
            max-width: 100%;
            background: rgba(255, 255, 255, 0.15);
            padding: 12px;
            border-radius: 36px;
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .login-card {
            width: 100%;
            background: #ffffff;
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            min-height: 630px;
        }

        /* Panel Kiri - Gradient Promosi */
        .panel-left {
            flex: 1;
            background: linear-gradient(135deg, #6c8cff 0%, #4c6ef5 100%);
            padding: 50px 45px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 5;
        }

        .brand-logo {
            max-height: 55px;
            object-fit: contain;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .welcome-content {
            margin: 40px 0;
            z-index: 5;
        }

        .welcome-content h1 {
            font-size: 2.3rem;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .welcome-content p {
            font-size: 0.95rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
        }

        .illustration-container {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 5;
        }

        .footer-text {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 18px;
            z-index: 5;
        }

        /* Panel Kanan - Form Login */
        .panel-right {
            flex: 1.2;
            padding: 50px 65px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .header-section {
            margin-bottom: 30px;
        }

        .header-section h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .header-section p {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Form Input styling to match mockup */
        .form-group {
            margin-bottom: 20px;
            background: #f8fafc;
            border-radius: 16px;
            padding: 10px 18px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.01), 0 2px 8px rgba(0,0,0,0.01);
            border: 1.5px solid #f1f5f9;
            transition: all 0.2s ease-in-out;
        }

        .form-group:focus-within {
            background: #ffffff;
            border-color: #4c6ef5;
            box-shadow: 0 10px 25px rgba(76, 110, 245, 0.08);
        }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            color: #94a3b8;
            font-size: 1.05rem;
            margin-right: 10px;
        }

        .form-control {
            width: 100%;
            padding: 4px 0;
            font-size: 0.95rem;
            border: none !important;
            background: transparent !important;
            font-family: inherit;
            color: #1e293b;
            font-weight: 600;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        /* Checkbox & Forgot Password Row */
        .option-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 0.88rem;
            padding: 0 4px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            cursor: pointer;
            user-select: none;
            font-weight: 600;
        }

        .checkbox-container input {
            cursor: pointer;
            accent-color: #4c6ef5;
            width: 18px;
            height: 18px;
            border-radius: 6px;
        }

        .forgot-link {
            color: #4c6ef5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #3b5bdb;
            text-decoration: underline;
        }

        /* Pill Shaped Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6c8cff 0%, #4c6ef5 100%);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(76, 110, 245, 0.25);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(76, 110, 245, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Alert Error */
        .alert-error {
            background: #fef2f2;
            border: 1.5px solid #fee2e2;
            color: #b91c1c;
            border-radius: 14px;
            padding: 12px 18px;
            margin-bottom: 20px;
            font-size: 0.88rem;
            line-height: 1.4;
            font-weight: 500;
        }

        .alert-error ul {
            padding-left: 20px;
        }

        /* Footer WhatsApp Help */
        .wa-support {
            margin-top: 35px;
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .wa-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #10b981;
            text-decoration: none;
            font-weight: 700;
            padding: 8px 18px;
            border: 1.5px solid #a7f3d0;
            border-radius: 50px;
            background: #f0fdf4;
            transition: all 0.2s ease;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.05);
        }

        .wa-link:hover {
            background: #dcfce7;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(16, 185, 129, 0.12);
        }

        .wa-logo {
            width: 16px;
            height: 16px;
        }

        /* Responsive Layout */
        @media (max-width: 950px) {
            .login-container {
                padding: 0;
                border-radius: 28px;
                border: none;
            }

            .login-card {
                flex-direction: column;
                min-height: auto;
                border-radius: 24px;
            }

            .panel-left {
                padding: 40px 30px;
                gap: 25px;
            }

            .welcome-content {
                margin: 15px 0;
            }

            .welcome-content h1 {
                font-size: 1.8rem;
            }

            .panel-right {
                padding: 40px 30px;
            }

            .header-section h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <!-- Background Curves -->
    <div class="background-curve">
        <svg viewBox="0 0 1440 900" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M-100 200 C300 150 500 450 900 300 C1300 150 1400 400 1600 350 L1600 900 L-100 900 Z" fill="white" opacity="0.05"/>
            <path d="M-100 400 C400 450 600 200 1000 350 C1400 500 1500 250 1600 300 L1600 900 L-100 900 Z" fill="white" opacity="0.05"/>
        </svg>
    </div>

    <div class="login-container">
        <div class="login-card">
            <!-- Panel Kiri -->
            <div class="panel-left">
                <div class="brand-section">
                    <img src="{{ asset('images/logo/logo_pemprov.png') }}" alt="Logo Pemprov Maluku" class="brand-logo" />
                    <div>
                        <span class="brand-text" style="display:block; line-height: 1.2;">EMONEV</span>
                    </div>
                </div>
                
                <div class="welcome-content">
                    <p>
                        Aplikasi e-Monitoring dan e-Evaluasi Berbasis TIK yang dikembangkan oleh Balai Teknologi Informasi dan Komunikasi (BTIK) Dinas Pendidikan Provinsi Maluku.
                    </p>
                </div>

                <!-- Custom SVG Illustration based on mockup -->
                <div class="illustration-container">
                    <svg viewBox="0 0 300 250" width="100%" height="auto" fill="none" xmlns="http://www.w3.org/2000/svg" style="max-width: 260px; margin: 0 auto; display: block;">
                        <!-- Background glow -->
                        <circle cx="150" cy="125" r="80" fill="white" opacity="0.08" filter="blur(15px)"/>
                        
                        <!-- Document 3 (Purple/Pink - Image) -->
                        <g transform="translate(145, 45) rotate(15)">
                            <rect width="55" height="75" rx="8" fill="#e8eafe" />
                            <rect x="5" y="5" width="45" height="35" rx="4" fill="#a5b4fc" />
                            <circle cx="20" cy="18" r="5" fill="#e0e7ff" />
                            <path d="M10 35 L22 23 L32 30 L45 15 L45 35 Z" fill="#818cf8" />
                            <rect x="8" y="48" width="38" height="4" rx="2" fill="#818cf8" />
                            <rect x="8" y="56" width="25" height="4" rx="2" fill="#818cf8" />
                        </g>
                        
                        <!-- Document 2 (Cyan/Green - Text) -->
                        <g transform="translate(105, 50) rotate(-10)">
                            <rect width="55" height="75" rx="8" fill="#e0f2fe" />
                            <rect x="8" y="12" width="38" height="6" rx="3" fill="#38bdf8" />
                            <rect x="8" y="24" width="38" height="4" rx="2" fill="#7dd3fc" />
                            <rect x="8" y="32" width="38" height="4" rx="2" fill="#7dd3fc" />
                            <rect x="8" y="40" width="25" height="4" rx="2" fill="#7dd3fc" />
                            <circle cx="15" cy="54" r="5" fill="#38bdf8" />
                            <rect x="25" y="52" width="20" height="4" rx="2" fill="#7dd3fc" />
                        </g>

                        <!-- Document 1 (Red/Orange - Video) -->
                        <g transform="translate(75, 80) rotate(-25)">
                            <rect width="55" height="75" rx="8" fill="#fee2e2" />
                            <rect x="5" y="5" width="45" height="40" rx="6" fill="#fca5a5" />
                            <!-- Play button -->
                            <circle cx="27" cy="25" r="10" fill="#ef4444" />
                            <path d="M25 21 L32 25 L25 29 Z" fill="white" />
                            <rect x="8" y="52" width="38" height="4" rx="2" fill="#fca5a5" />
                            <rect x="8" y="60" width="25" height="4" rx="2" fill="#fca5a5" />
                        </g>

                        <!-- Main Blue Folder -->
                        <g transform="translate(65, 110)">
                            <!-- Back panel of folder -->
                            <path d="M5 15 C5 8 10 5 15 5 L55 5 C60 5 62 10 65 12 L75 22 L145 22 C152 22 155 25 155 32 L155 105 C155 112 152 115 145 115 L15 115 C8 115 5 112 5 105 Z" fill="#1e40af" opacity="0.3" />
                            <!-- Front panel of folder -->
                            <path d="M0 25 C0 18 5 15 12 15 L138 15 C145 15 150 18 150 25 L150 95 C150 102 145 105 138 105 L12 105 C5 105 0 102 0 95 Z" fill="url(#folderGrad)" filter="drop-shadow(0 10px 20px rgba(30, 64, 175, 0.25))" />
                        </g>

                        <!-- Magnifying Glass -->
                        <g transform="translate(130, 160) rotate(-15)">
                            <!-- Handle -->
                            <rect x="18" y="45" width="12" height="35" rx="6" fill="#f59e0b" transform="rotate(-45 18 45)" filter="drop-shadow(0 4px 6px rgba(0,0,0,0.15))" />
                            <rect x="23" y="50" width="6" height="15" rx="3" fill="#d97706" transform="rotate(-45 18 45)" />
                            <!-- Metal connector -->
                            <rect x="18" y="40" width="12" height="8" fill="#94a3b8" transform="rotate(-45 18 45)" />
                            <!-- Ring -->
                            <circle cx="15" cy="15" r="22" stroke="#3b82f6" stroke-width="6" fill="#e0f2fe" fill-opacity="0.3" filter="drop-shadow(0 8px 16px rgba(59, 130, 246, 0.2))" />
                            <!-- Glass reflection -->
                            <path d="M-2 -2 A 16 16 0 0 1 12 -12" stroke="white" stroke-width="3" stroke-linecap="round" transform="translate(15, 15)" />
                        </g>

                        <!-- Gradients -->
                        <defs>
                            <linearGradient id="folderGrad" x1="0" y1="15" x2="150" y2="105" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#60a5fa" />
                                <stop offset="100%" stop-color="#2563eb" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                
                <div class="footer-text">
                    &copy; {{ now()->year }} BTIK Dinas Pendidikan Provinsi Maluku.
                </div>
            </div>

            <!-- Panel Kanan -->
            <div class="panel-right">
                <div class="header-section">
                    <h2>Login</h2>
                    <p>Bagi Operator Sekolah gunakan <b>NPSN</b> untuk login, pengguna internal gunakan <b>email</b>.</p>
                </div>

                <!-- Menampilkan Error jika ada -->
                @if ($errors->any())
                    <div class="alert-error">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email / NPSN / NIP -->
                    <div class="form-group">
                        <label for="email">Email atau NPSN</label>
                        <div class="input-wrapper">
                            <i data-feather="user"></i>
                            <input class="form-control" id="email" type="text" name="email"
                                placeholder="Masukkan email atau NPSN" required autofocus value="{{ old('email') }}" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i data-feather="lock"></i>
                            <input class="form-control" id="password" type="password" name="password"
                                placeholder="Masukkan password Anda" required />
                        </div>
                    </div>

                    <!-- Opsi checkbox & lupa password -->
                    <div class="option-row">
                        <label class="checkbox-container" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember" />
                            <span>Ingat saya</span>
                        </label>
                        <a class="forgot-link" href="#">Lupa password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Login</span>
                    </button>
                </form>

                <!-- Support Area -->
                <div class="wa-support">
                    <span>Mengalami kendala login atau butuh bantuan?</span>
                    <br>
                    <a href="https://wa.me/6282198769133" target="_blank" class="wa-link">
                        <img src="{{ asset('sbadmin/assets/img/logo_wa.png') }}" alt="WhatsApp Logo" class="wa-logo" />
                        <span>Hubungi Admin BTIK (WhatsApp)</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi Feather Icons
        feather.replace();
    </script>
</body>

</html>
