<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — ' : '' }}IRGT School Inventory</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Global App Styles -->
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f9ff;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        .main-container {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 20px 48px;
            flex: 1;
        }

        /* HEADER SECTION */
        .page-head-card {
            background: #ffffff;
            border: 1.5px solid #e0f2fe;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        }

        .page-head-info h1 {
            font-size: 22px;
            font-weight: 800;
            color: #0c1a2e;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-head-info p {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        /* CARD & KPI GRID */
        .kpi-row-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 1024px) {
            .kpi-row-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .kpi-row-4 {
                grid-template-columns: 1fr;
            }
        }

        .kpi-stat-card {
            background: #ffffff;
            border: 1.5px solid #e0f2fe;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            transition: transform 0.15s;
        }

        .kpi-stat-card:hover {
            transform: translateY(-2px);
        }

        .kpi-stat-label {
            font-size: 11.5px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .kpi-stat-val {
            font-size: 26px;
            font-weight: 800;
            color: #0c1a2e;
            margin-top: 4px;
            line-height: 1.1;
        }

        .kpi-stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        /* TABLES */
        .content-card {
            background: #ffffff;
            border: 1.5px solid #e0f2fe;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
            margin-bottom: 24px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .custom-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.05em;
            padding: 12px 18px;
            border-bottom: 1.5px solid #e2e8f0;
            white-space: nowrap;
        }

        .custom-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        .custom-table tr:hover td {
            background: #f8fafc;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            font-family: inherit;
            border: none;
            cursor: pointer;
            min-height: 40px;
            transition: all 0.15s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(3, 105, 161, 0.25);
        }
        .btn-primary:hover, .btn-primary:active {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(3, 105, 161, 0.35);
        }

        .btn-secondary {
            background: #e0f2fe;
            color: #0369a1;
            border: 1.5px solid #bae6fd;
        }
        .btn-secondary:hover, .btn-secondary:active {
            background: #bae6fd;
        }

        .btn-success {
            background: #10b981;
            color: #ffffff;
        }
        .btn-success:hover, .btn-success:active {
            background: #059669;
        }

        .btn-danger {
            background: #ef4444;
            color: #ffffff;
        }
        .btn-danger:hover, .btn-danger:active {
            background: #dc2626;
        }

        .btn-outline {
            background: #ffffff;
            color: #475569;
            border: 1.5px solid #cbd5e1;
        }
        .btn-outline:hover, .btn-outline:active {
            background: #f8fafc;
            color: #0f172a;
        }

        /* FORMS */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #0369a1;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            background: #f8fafc;
            color: #0c1a2e;
            outline: none;
            min-height: 42px;
            transition: all 0.15s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #0369a1;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(3, 105, 161, 0.12);
        }

        /* BADGES */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 9px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .badge-success { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-warning { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .badge-danger { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .badge-info { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-purple { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
        .badge-gray { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

        /* FOOTER */
        .app-footer {
            margin-top: auto;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e0f2fe;
            background: #ffffff;
        }

        /* ANDROID & SMARTPHONE SCREEN REFINEMENTS */
        @media (max-width: 768px) {
            body {
                padding-bottom: calc(76px + env(safe-area-inset-bottom));
            }
            .main-container {
                padding: 14px 12px 32px;
            }
            .page-head-card {
                padding: 16px;
                border-radius: 14px;
            }
            .page-head-info h1 {
                font-size: 18px;
            }
            .form-input, .form-select, .form-textarea {
                font-size: 16px; /* Prevents unwanted auto-zoom on iOS/Android keyboards */
                min-height: 46px;
            }
            .btn {
                min-height: 44px; /* Optimal tap target */
                width: 100%;
            }
            .page-head-card .btn {
                width: auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Unified Top Navigation Bar -->
    @include('partials.navbar')

    <!-- Main Content Container -->
    <main class="main-container">
        <!-- Global Flash Alerts -->
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        @if(session('warning'))
            <x-alert type="warning" :message="session('warning')" />
        @endif

        @if(session('info'))
            <x-alert type="info" :message="session('info')" />
        @endif

        @if(isset($errors) && $errors->any())
            <x-alert type="error">
                <p style="font-weight: 700; margin-bottom: 4px;">Terdapat kesalahan pengisian formulir:</p>
                <ul style="list-style-type: disc; margin-left: 20px; font-size: 12px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Global Footer -->
    <footer class="app-footer">
        <p>&copy; {{ date('Y') }} IRGT School Inventory & Infrastructure Management System.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>
