<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard') | Larablog</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --bs-sidebar-width: 280px;
            --bs-sidebar-bg: #212529;
            --bs-sidebar-color: rgba(255, 255, 255, 0.75);
            --bs-sidebar-hover-color: rgba(255, 255, 255, 0.9);
            --bs-sidebar-active-color: #fff;
            --bs-sidebar-active-bg: rgba(255, 255, 255, 0.1);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            width: var(--bs-sidebar-width);
            height: 100vh;
            background-color: var(--bs-sidebar-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link {
            color: var(--bs-sidebar-color);
            padding: 0.75rem 1rem;
            margin: 0.125rem 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.15s ease-in-out;
        }

        .sidebar .nav-link:hover {
            color: var(--bs-sidebar-hover-color);
            background-color: var(--bs-sidebar-active-bg);
        }

        .sidebar .nav-link.active {
            color: var(--bs-sidebar-active-color);
            background-color: var(--bs-sidebar-active-bg);
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 1rem;
        }

        .main-content {
            margin-left: var(--bs-sidebar-width);
            padding: 1.5rem;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .stats-card.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stats-card.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stats-card.info {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: skewX(-15deg) translateX(100%);
            transition: transform 0.6s;
        }

        .stats-card:hover::before {
            transform: skewX(-15deg) translateX(-100%);
        }

        .card-icon {
            font-size: 3rem;
            opacity: 0.7;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: block;
        }

        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .btn-icon {
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-speedometer2"></i>
            Larablog Admin
        </a>
        
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="bi bi-people"></i>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}" href="{{ route('admin.posts') }}">
                    <i class="bi bi-file-text"></i>
                    Posts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('posts.index') }}">
                    <i class="bi bi-eye"></i>
                    View Site
                </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link" href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main content -->
    <main class="main-content">
        <!-- Top navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4 d-md-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
            </div>
        </nav>

        <!-- Page header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">@yield('page-title', 'Dashboard')</h1>
                <p class="text-muted mb-0">@yield('page-description', 'Welcome to the admin dashboard')</p>
            </div>
            <div>
                <span class="text-muted">Welcome, {{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page content -->
        @yield('content')
    </main>

    <!-- Logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.querySelector('.navbar-toggler');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggleButton.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>