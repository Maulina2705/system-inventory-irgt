<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Website Sedang Dalam Pemulihan oleh Tim IT IRGT' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #081322;
            color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* AMBIENT GLOW ANIMATIONS IN BACKGROUND */
        .ambient-glow-1 {
            position: absolute;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 400px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.18) 0%, rgba(3, 105, 161, 0.05) 50%, transparent 70%);
            border-radius: 50%;
            animation: pulseGlow 8s ease-in-out infinite alternate;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            bottom: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(2, 132, 199, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatGlow 10s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes pulseGlow {
            0% { transform: translateX(-50%) scale(1); opacity: 0.7; }
            100% { transform: translateX(-50%) scale(1.15); opacity: 1; }
        }

        @keyframes floatGlow {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-30px) scale(1.1); }
        }

        /* MAIN CARD */
        .recovery-card {
            background: rgba(12, 26, 46, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(56, 189, 248, 0.25);
            border-radius: 28px;
            max-width: 640px;
            width: 100%;
            padding: 44px 36px 36px;
            text-align: center;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.55), 0 0 30px rgba(14, 165, 233, 0.15);
            position: relative;
            z-index: 10;
            animation: cardAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* LOGO & RECOVERY BADGE */
        .logo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 24px;
        }

        .logo-box {
            width: 90px;
            height: 90px;
            background: #ffffff;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35), 0 0 0 4px rgba(56, 189, 248, 0.3);
            margin: 0 auto;
            position: relative;
            animation: logoFloat 4s ease-in-out infinite alternate;
            overflow: hidden;
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        @keyframes logoFloat {
            0% { transform: translateY(0); }
            100% { transform: translateY(-6px); }
        }

        /* FLOATING WRENCH / GEAR ICON */
        .gear-badge {
            position: absolute;
            bottom: -6px;
            right: -6px;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.5);
            border: 2.5px solid #0c1a2e;
            animation: spinGear 8s linear infinite;
        }

        @keyframes spinGear {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* PULSING STATUS CHIP */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.35);
            color: #fbbf24;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 18px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #f59e0b;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
            animation: pulseRing 1.8s infinite;
        }

        @keyframes pulseRing {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.8); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        /* TEXTS */
        h1 {
            font-size: 23px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.35;
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }

        .recovery-desc {
            font-size: 13.5px;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 26px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ANIMATED PROGRESS BAR */
        .progress-box {
            background: rgba(15, 35, 61, 0.8);
            border: 1px solid rgba(56, 189, 248, 0.18);
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 24px;
            text-align: left;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            font-weight: 700;
            color: #7dd3fc;
            margin-bottom: 8px;
        }

        .progress-bar-track {
            height: 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            width: 78%;
            background: linear-gradient(90deg, #0ea5e9, #38bdf8, #0ea5e9);
            background-size: 200% 100%;
            border-radius: 10px;
            animation: shimmerBar 2.5s infinite linear;
        }

        @keyframes shimmerBar {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* INFO TILES */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 28px;
        }

        .info-tile {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 10px 14px;
            text-align: left;
        }

        .info-tile-lbl {
            font-size: 10.5px;
            color: #7dd3fc;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 3px;
        }

        .info-tile-val {
            font-size: 12.5px;
            font-weight: 700;
            color: #f1f5f9;
        }

        /* ACTIONS */
        .action-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: inherit;
            cursor: pointer;
        }

        .btn-support {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.35);
        }
        .btn-support:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(14, 165, 233, 0.45);
        }

        .btn-login-bypass {
            background: rgba(255, 255, 255, 0.08);
            color: #bae6fd;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
        }
        .btn-login-bypass:hover {
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            border-color: #38bdf8;
        }

        /* FOOTER NOTE */
        .footer-note {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 11px;
            color: #64748b;
        }

        @media (max-width: 600px) {
            .recovery-card { padding: 32px 20px 24px; }
            h1 { font-size: 20px; }
            .info-grid { grid-template-columns: 1fr; }
            .btn-action { width: 100%; }
        }
    </style>
</head>
<body>

    @php
        $logoBase64 = '';
        $possiblePaths = [
            public_path('images/logo.png'),
            base_path('public/images/logo.png'),
            base_path('../public_html/images/logo.png'),
            'F:/1. MHS FOLDER/Project Gabut/inventory1-irgt/public_html/images/logo.png',
            'F:/1. MHS FOLDER/Project Gabut/inventory1-irgt/inventori-irgt/public/images/logo.png',
        ];
        foreach ($possiblePaths as $p) {
            if (file_exists($p)) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($p));
                break;
            }
        }
    @endphp

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="recovery-card">
        <!-- SCHOOL LOGO & BADGE -->
        <div class="logo-wrapper">
            <div class="logo-box">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo IRGT School">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Logo IRGT School" onerror="this.onerror=null; this.src='/images/logo.png';">
                @endif
            </div>
            <div class="gear-badge" title="Dalam Perawatan Sistem">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            </div>
        </div>

        <div>
            <div class="status-pill">
                <span class="pulse-dot"></span>
                <span>Mode Pemulihan Sistem IT</span>
            </div>
        </div>

        <h1>{{ $title ?? 'Website Sedang Dalam Pemulihan oleh Tim IT IRGT' }}</h1>

        <p class="recovery-desc">
            {{ $message ?? 'Sistem Inventaris dan Manajemen Infrastruktur IRGT School saat ini sedang dalam proses pemeliharaan berkala, sinkronisasi data, dan pemulihan performa oleh tim IT Support.' }}
        </p>

        <!-- PROGRESS BAR -->
        <div class="progress-box">
            <div class="progress-header">
                <span>Proses Pemeliharaan & Optimalisasi</span>
                <span style="font-family: 'JetBrains Mono', monospace;">{{ $estimated_end ?? 'Sedang Berlangsung...' }}</span>
            </div>
            <div class="progress-bar-track">
                <div class="progress-bar-fill"></div>
            </div>
        </div>

        <!-- INFO TILES -->
        <div class="info-grid">
            <div class="info-tile">
                <div class="info-tile-lbl">Tim Penanggung Jawab</div>
                <div class="info-tile-val">IT Infrastructure IRGT School</div>
            </div>
            <div class="info-tile">
                <div class="info-tile-lbl">Status Layanan</div>
                <div class="info-tile-val" style="color: #fbbf24;">Maintenance Terjadwal</div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="action-row">
            <a href="https://wa.me/?text=Halo%20Tim%20IT%20IRGT%2C%20saya%20ingin%20menanyakan%20status%20sistem%20inventaris." target="_blank" class="btn-action btn-support">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>Hubungi Tim IT Support</span>
            </a>
            <a href="{{ route('login') }}" class="btn-action btn-login-bypass" title="Login untuk Petugas & Super Admin">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>Akses Masuk Staf</span>
            </a>
        </div>

        <div class="footer-note">
            &copy; {{ date('Y') }} IRGT School — Yayasan & Manajemen Teknologi Informasi
        </div>
    </div>

</body>
</html>
