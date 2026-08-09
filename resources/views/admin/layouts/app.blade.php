<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin DEPPA') - Si Doel Smart Finance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sidebar {
            position: sticky;
            top: 0;
            min-height: 100vh;
            background: #212529;
            color: #fff;
        }
        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            margin-bottom: 1rem;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,.7);
            padding: .6rem .9rem;
            border-radius: .5rem;
            margin-bottom: .25rem;
        }
        .sidebar .nav-link i { margin-right: .55rem; font-size: 1.05rem; }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.1);
        }
        .stat-card {
            border-left: 4px solid;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .4rem .6rem rgba(0,0,0,.07);
        }
        .stat-card.primary { border-left-color: #0d6efd; }
        .stat-card.success { border-left-color: #198754; }
        .stat-card.warning { border-left-color: #ffc107; }
        .stat-card.info    { border-left-color: #0dcaf0; }
        main.content { min-height: 100vh; background: #f6f7f9; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar d-flex flex-column flex-shrink-0 p-3" style="width: 250px;">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <i class="bi bi-controller fs-4"></i>
                <span>Si Doel SF</span>
            </a>
            <hr class="border-secondary my-2">
            <ul class="nav flex-column flex-grow-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.players.index') }}" class="nav-link {{ request()->routeIs('admin.players.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Master Player
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.export.excel') }}" class="nav-link">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.export.pdf') }}" class="nav-link" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </li>
            </ul>
            <hr class="border-secondary my-2">
            <small class="text-secondary text-center">© {{ date('Y') }} Si Doel Smart Finance</small>
        </aside>

        <main class="content flex-grow-1 p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>