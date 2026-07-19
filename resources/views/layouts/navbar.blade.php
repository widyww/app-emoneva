<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4c6ef5;
            --primary-dark: #3b5bdb;
            --secondary-color: #64748b;
            --bg-light: #f4f6fc;
            --border-radius-lg: 20px;
            --border-radius-md: 12px;
        }

        *, body, h1, h2, h3, h4, h5, h6, .page-header-title, .nav-link, .navbar-brand, .sidenav-footer-title, .sidenav-menu-heading, .card-header, .form-control, .form-select, .btn {
            font-family: 'Inter', sans-serif !important;
        }

        body {
            background-color: #f4f6fc !important;
        }

        /* Gradation Header */
        .bg-gradient-primary-to-secondary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
        }

        /* Page Header Adjustments */
        .page-header {
            padding-bottom: 8rem !important;
            border-radius: 0 0 24px 24px;
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 1440 300' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M-100 80 C300 30 500 180 900 120 C1300 60 1400 150 1600 130 L1600 300 L-100 300 Z' fill='white' fill-opacity='0.05'/%3E%3Cpath d='M-100 160 C400 180 600 80 1000 140 C1400 200 1500 100 1600 120 L1600 300 L-100 300 Z' fill='white' fill-opacity='0.05'/%3E%3C/svg%3E");
            background-size: cover;
            background-position: center;
            pointer-events: none;
        }
        .page-header-title {
            font-weight: 700 !important;
            font-size: 2.1rem !important;
        }
        .page-header-subtitle {
            font-weight: 300 !important;
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 1rem !important;
        }

        /* Content Margins */
        .mt-n10, .mt-n5 {
            margin-top: -6rem !important;
        }

        /* Cards */
        .card {
            border-radius: var(--border-radius-lg) !important;
            border: 1px solid rgba(76, 110, 245, 0.08) !important;
            box-shadow: 0 10px 30px rgba(76, 110, 245, 0.04) !important;
            overflow: hidden;
            background-color: #ffffff;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .card:not([class*="bg-"]):hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 20px 40px rgba(76, 110, 245, 0.08) !important;
            border-color: rgba(76, 110, 245, 0.15) !important;
        }

        /* Welcome card premium enhancement */
        .card:has(img[src*="at-work.svg"]), 
        .card:has(img[src*="drawkit"]) {
            background: linear-gradient(135deg, #ffffff 0%, #fbfcfe 100%) !important;
            border: 1px solid rgba(76, 110, 245, 0.15) !important;
            box-shadow: 0 15px 40px rgba(76, 110, 245, 0.08) !important;
            position: relative;
            overflow: hidden;
        }
        
        .card:has(img[src*="at-work.svg"])::before, 
        .card:has(img[src*="drawkit"])::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(76, 110, 245, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .card:has(img[src*="at-work.svg"]) h1, 
        .card:has(img[src*="drawkit"]) h1 {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800 !important;
        }

        .card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            padding: 1.25rem 1.5rem !important;
            font-size: 1.05rem !important;
        }

        .card-body {
            padding: 1.5rem 1.5rem !important;
        }

        .card-footer {
            background-color: #ffffff !important;
            border-top: 1px solid #e2e8f0 !important;
            padding: 1.25rem 1.5rem !important;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: var(--border-radius-md) !important;
            border: 1.5px solid #f1f5f9 !important;
            background-color: #f8fafc !important;
            padding: 11px 16px !important;
            font-size: 0.95rem !important;
            color: #1e293b !important;
            font-weight: 500 !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.01), 0 2px 8px rgba(0,0,0,0.02) !important;
            transition: all 0.2s ease-in-out !important;
        }

        .form-control:focus, .form-select:focus {
            background-color: #ffffff !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 10px 25px rgba(76, 110, 245, 0.08) !important;
            outline: none !important;
        }

        /* Buttons styling */
        .btn {
            border-radius: 50px !important; /* Pill shaped buttons! */
            padding: 10px 24px !important;
            font-weight: 700 !important;
            font-size: 0.925rem !important;
            transition: all 0.25s ease !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Prevent icon buttons from inheriting generic button padding and border radius */
        .btn-icon {
            padding: 0 !important;
            border-radius: 50% !important;
        }
        
        .btn-icon img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 50% !important;
        }


        .btn-primary {
            background: linear-gradient(135deg, #6c8cff 0%, #4c6ef5 100%) !important;
            border: none !important;
            box-shadow: 0 6px 16px rgba(76, 110, 245, 0.2) !important;
            color: #ffffff !important;
        }

        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background: linear-gradient(135deg, #7c9aff 0%, #3b5bdb 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 24px rgba(76, 110, 245, 0.3) !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #63e6be 0%, #0ca678 100%) !important;
            border: none !important;
            box-shadow: 0 6px 16px rgba(12, 166, 120, 0.2) !important;
            color: #ffffff !important;
        }

        .btn-success:hover, .btn-success:focus, .btn-success:active {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 24px rgba(12, 166, 120, 0.3) !important;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff8787 0%, #e03131 100%) !important;
            border: none !important;
            box-shadow: 0 6px 16px rgba(224, 49, 49, 0.2) !important;
            color: #ffffff !important;
        }

        .btn-danger:hover, .btn-danger:focus, .btn-danger:active {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 24px rgba(224, 49, 49, 0.3) !important;
        }

        /* Topnav Styles */
        .topnav {
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 20px rgba(76, 110, 245, 0.02) !important;
            z-index: 1030 !important;
        }

        .topnav .navbar-brand {
            font-family: 'Inter', sans-serif !important;
            font-weight: 800 !important;
            font-size: 1.4rem !important;
            color: var(--primary-color) !important;
            letter-spacing: 0.5px;
        }

        /* Sidebar Styles */
        .sidenav-brand {
            border-bottom: 1px solid #e2e8f0 !important;
            background-color: #ffffff !important;
            height: 3.625rem !important;
            display: flex !important;
            align-items: center !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        
        .sidenav-brand a span {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800 !important;
        }

        .sidenav {
            background-color: #ffffff !important;
            border-right: 1px solid #e2e8f0 !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.01) !important;
            padding-top: 0 !important;
        }

        .sidenav .sidenav-menu .nav-link {
            font-weight: 500 !important;
            color: #475569 !important;
            padding: 0.75rem 1.25rem !important;
            border-radius: 12px !important;
            margin: 6px 14px !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative;
        }

        .sidenav .sidenav-menu .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: #f0f6ff !important;
            transform: translateX(3px);
        }

        .sidenav .sidenav-menu .nav-link.active {
            color: var(--primary-color) !important;
            background: linear-gradient(135deg, #f0f6ff 0%, #e8f0fe 100%) !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(76, 110, 245, 0.05) !important;
        }

        .sidenav .sidenav-menu .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-dark));
            border-radius: 0 4px 4px 0;
        }

        /* Glassmorphic Header Date Picker */
        .page-header .input-group-joined {
            background-color: rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 50px !important;
            overflow: hidden;
            transition: all 0.3s ease !important;
        }
        
        .page-header .input-group-joined:hover, 
        .page-header .input-group-joined:focus-within {
            background-color: rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }
        
        .page-header .input-group-joined input {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: none !important;
        }
        
        .page-header .input-group-joined input::placeholder {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .page-header .input-group-joined .input-group-text {
            background: transparent !important;
            border: none !important;
        }
        
        .page-header .input-group-joined .input-group-text i,
        .page-header .input-group-joined .input-group-text svg {
            color: #ffffff !important;
        }

        /* Premium Table Design */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        .table th {
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem !important;
            letter-spacing: 0.5px;
            color: #475569 !important;
            background-color: #f8fafc !important;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 16px !important;
        }

        .table td {
            padding: 16px !important;
            vertical-align: middle !important;
            color: #334155 !important;
            font-weight: 500;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .table tbody tr {
            transition: all 0.2s ease !important;
        }

        .table tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* Soft Colored Badges (Tailwind UI style) */
        .badge {
            font-weight: 700 !important;
            padding: 6px 14px !important;
            border-radius: 50px !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: capitalize;
            box-shadow: none !important;
        }

        .badge.bg-success {
            background-color: rgba(12, 166, 120, 0.1) !important;
            color: #0ca678 !important;
        }

        .badge.bg-warning {
            background-color: rgba(247, 103, 7, 0.1) !important;
            color: #f76707 !important;
        }

        .badge.bg-danger {
            background-color: rgba(224, 49, 49, 0.1) !important;
            color: #e03131 !important;
        }

        .badge.bg-primary {
            background-color: rgba(76, 110, 245, 0.1) !important;
            color: #4c6ef5 !important;
        }

        .badge.bg-info {
            background-color: rgba(21, 170, 191, 0.1) !important;
            color: #15aabf !important;
        }
        
        .badge.bg-secondary {
            background-color: rgba(100, 116, 139, 0.1) !important;
            color: #64748b !important;
        }

        /* Sleek Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidenav .sidenav-menu .nav-link .nav-link-icon {
            color: inherit !important;
            margin-right: 0.75rem !important;
            transition: color 0.2s ease !important;
        }

        .sidenav-menu-heading {
            padding: 1.5rem 1.75rem 0.5rem !important;
            font-size: 0.725rem !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8 !important;
        }

        .sidenav-footer {
            background-color: #f8fafc !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        /* Dashboard Colored Cards Override */
        .card.bg-primary {
            background: linear-gradient(135deg, #6c8cff 0%, #4c6ef5 100%) !important;
            box-shadow: 0 10px 25px rgba(76, 110, 245, 0.25) !important;
        }
        
        .card.bg-warning {
            background: linear-gradient(135deg, #ffc078 0%, #f76707 100%) !important;
            box-shadow: 0 10px 25px rgba(247, 103, 7, 0.25) !important;
        }
        
        .card.bg-success {
            background: linear-gradient(135deg, #63e6be 0%, #0ca678 100%) !important;
            box-shadow: 0 10px 25px rgba(12, 166, 120, 0.25) !important;
        }
        
        .card.bg-danger {
            background: linear-gradient(135deg, #ff8787 0%, #e03131 100%) !important;
            box-shadow: 0 10px 25px rgba(224, 49, 49, 0.25) !important;
        }
        
        .card[class*="bg-"] {
            border: none !important;
            transition: all 0.3s ease !important;
        }
        
        .card[class*="bg-"]:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .card[class*="bg-"] .card-body {
            padding: 1.75rem 1.5rem !important;
        }

        .card[class*="bg-"] .text-white-75 {
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            text-transform: uppercase;
        }
        
        .card[class*="bg-"] .text-lg {
            font-size: 2.2rem !important;
            font-weight: 800 !important;
            margin-top: 4px;
        }

        .card[class*="bg-"] .card-footer {
            background-color: rgba(0, 0, 0, 0.1) !important;
            border-top: none !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            font-size: 0.75rem !important;
            transition: background-color 0.2s;
        }
        
        .card[class*="bg-"] .card-footer:hover {
            background-color: rgba(0, 0, 0, 0.18) !important;
        }
        
        .card[class*="bg-"] .card-footer a {
            text-decoration: none !important;
            letter-spacing: 1px !important;
        }
        /* DataTables Fixes */
        .dataTables_length select.form-select {
            width: auto !important;
            display: inline-block !important;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem !important;
            margin: 0 0.5rem !important;
        }
    </style>

</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
        id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
                data-feather="menu"></i></button>
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="#">EMONEV</a>
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item">
                {{-- @if ($activeSemester)
                    <a class="nav-link active" aria-current="page">
                        Status Rotasi : {{ $activeSemester->periode_rotasi }}
                    </a>
                @else
                    <a class="nav-link active" aria-current="page">
                        Status Rotasi Tidak Aktif
                    </a>
                @endif --}}
            </li>

            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><img class="img-fluid"
                        src="{{ asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">

                    <a>

                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i data-feather="log-out" class="me-2"></i> {{ __('Log Out') }}
                            </button>
                        </form>

                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            @include('layouts.partial.sidebar')
            @yield('content')
            @include('layouts.partial.footer')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('sbadmin/js/litepicker.js') }}"></script>

    @yield('scripts')
</body>

</html>
