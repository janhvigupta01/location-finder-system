<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Geo Referenced Map Interface') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS for maps -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS - Design System -->
    <style>
        :root {
            /* Primary Colors */
            --primary-color: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1e40af;
            
            /* Secondary Colors */
            --secondary-color: #64748b;
            --secondary-light: #94a3b8;
            
            /* Accent Colors */
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            
            /* Neutral Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-2xl: 3rem;
            
            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-full: 9999px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 0.9375rem;
            font-weight: 400;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.2;
            margin-bottom: var(--spacing-md);
        }

        h1 { font-size: 2.25rem; font-weight: 700; }
        h2 { font-size: 1.875rem; font-weight: 700; }
        h3 { font-size: 1.5rem; font-weight: 600; }
        h4 { font-size: 1.25rem; font-weight: 600; }
        h5 { font-size: 1.125rem; font-weight: 600; }
        h6 { font-size: 1rem; font-weight: 600; }

        p {
            color: var(--text-secondary);
            margin-bottom: var(--spacing-md);
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--primary-dark);
        }

        /* Navbar Styles */
        .navbar {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: var(--spacing-md) 0;
        }

        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .navbar-brand i {
            font-size: 1.75rem;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
            border-radius: var(--radius-md);
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(37, 99, 235, 0.08);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(37, 99, 235, 0.12);
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-lg);
            padding: var(--spacing-sm);
        }

        .dropdown-item {
            color: var(--text-primary);
            font-weight: 500;
            border-radius: var(--radius-md);
            margin: var(--spacing-xs) 0;
        }

        .dropdown-item:hover,
        .dropdown-item.active {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        /* Button Styles */
        .btn {
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius-lg);
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-light);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            background-color: var(--bg-primary);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .card-header {
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: var(--spacing-lg);
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body {
            padding: var(--spacing-xl);
        }

        .card-footer {
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            padding: var(--spacing-lg);
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 0.625rem var(--spacing-md);
            font-size: 0.95rem;
            color: var(--text-primary);
            background-color: var(--bg-primary);
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-light);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: var(--radius-xl);
            padding: var(--spacing-lg);
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #7f1d1d;
            border-left: 4px solid var(--danger-color);
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #78350f;
            border-left: 4px solid var(--warning-color);
        }

        .alert-info {
            background-color: rgba(59, 130, 246, 0.1);
            color: #1e3a8a;
            border-left: 4px solid var(--primary-light);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 6rem 0;
            text-align: center;
        }

        .hero-section h1 {
            color: white;
            font-size: 3.5rem;
            margin-bottom: var(--spacing-lg);
        }

        .hero-section p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-bottom: var(--spacing-xl);
        }

        /* Feature Icons */
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-xl);
            background-color: rgba(37, 99, 235, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: var(--primary-color);
            margin-bottom: var(--spacing-lg);
        }

        /* Category Badges */
        .category-badge {
            display: inline-block;
            padding: var(--spacing-sm) var(--spacing-lg);
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-hospital {
            background-color: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        .badge-school {
            background-color: rgba(59, 130, 246, 0.15);
            color: #2563eb;
        }

        .badge-restaurant {
            background-color: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }

        .badge-park {
            background-color: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .badge-tourist {
            background-color: rgba(168, 85, 247, 0.15);
            color: #a855f7;
        }

        .badge-other {
            background-color: rgba(100, 116, 139, 0.15);
            color: #475569;
        }

        /* Map Container */
        #map {
            height: 500px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        /* Footer */
        footer {
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            margin-top: var(--spacing-2xl);
            padding: var(--spacing-2xl) 0;
        }

        footer h5 {
            color: var(--text-primary);
            margin-bottom: var(--spacing-md);
        }

        footer a {
            color: var(--text-secondary);
            display: block;
            margin-bottom: var(--spacing-sm);
        }

        footer a:hover {
            color: var(--primary-color);
        }

        /* Utility Classes */
        .text-primary { color: var(--primary-color) !important; }
        .text-secondary { color: var(--text-secondary) !important; }
        .text-muted { color: var(--text-light) !important; }

        .bg-primary-light { background-color: rgba(37, 99, 235, 0.1); }
        .bg-secondary-light { background-color: var(--bg-secondary); }

        .border-primary { border-color: var(--primary-color) !important; }

        /* Responsive */
        @media (max-width: 768px) {
            h1 { font-size: 1.875rem; }
            h2 { font-size: 1.5rem; }
            .hero-section h1 { font-size: 2.5rem; }
            .card-body { padding: var(--spacing-lg); }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-map-location-dot"></i> {{ __('messages.app_name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">{{ __('messages.about') }}</a></li>

                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('map') }}">{{ __('messages.interactive_map') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('locations.index') }}">{{ __('messages.locations') }}</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('messages.profile') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">{{ __('messages.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a></li>
                    @endauth

                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i> {{ app()->getLocale() === 'en' ? 'English' : 'हिंदी' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('set-language', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('set-language', 'hi') }}">हिंदी</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('messages.error') }}!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>{{ __('messages.app_name') }}</h5>
                    <p>{{ __('messages.app_description') }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>{{ __('messages.quick_links') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li><a href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                        @auth<li><a href="{{ route('locations.index') }}">{{ __('messages.my_locations') }}</a></li>@endauth
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>{{ __('messages.features') }}</h5>
                    <ul class="list-unstyled">
                        <li>{{ __('messages.interactive_maps') }}</li>
                        <li>{{ __('messages.location_crud') }}</li>
                        <li>{{ __('messages.rest_api') }}</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2026 {{ __('messages.app_name') }}. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    @stack('scripts')
</body>
</html>
