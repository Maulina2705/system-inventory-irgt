<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | IRGT Inventory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0c1a2e 0%, #0c4a6e 50%, #0c1a2e 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            padding: 40px 32px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 24px 80px rgba(0,0,0,0.3);
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .error-code {
            font-size: 56px;
            font-weight: 800;
            line-height: 1;
            color: #0369a1;
            margin-bottom: 12px;
            letter-spacing: -0.04em;
        }
        h1 { font-size: 20px; font-weight: 800; color: #0c1a2e; margin-bottom: 10px; }
        p { font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 14px rgba(3,105,161,0.35);
            transition: all 0.15s;
            width: 100%;
        }
        .btn-home:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }
        .site-footer { margin-top: 20px; font-size: 11.5px; color: rgba(148,163,184,0.7); text-align: center; }
    </style>
</head>
<body>

<div class="card">
    <div class="error-code">404</div>
    <h1>Halaman Tidak Ditemukan</h1>
    <p>Halaman atau tautan yang Anda tuju tidak tersedia atau telah dipindahkan.</p>
    <a href="{{ auth()->check() ? (in_array(auth()->user()->role, ['super_admin','admin']) ? route('assets.index') : route('reports.index')) : route('login') }}" class="btn-home">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
        Kembali ke Beranda
    </a>
</div>

<div class="site-footer">
    &copy; {{ date('Y') }} IRGT School — Sistem Inventaris Aset IT
</div>

</body>
</html>
