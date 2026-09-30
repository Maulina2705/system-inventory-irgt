<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Terjadi Kendala Sistem | IRGT Inventory</title>
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
            color: #b91c1c;
            margin-bottom: 12px;
            letter-spacing: -0.04em;
        }
        h1 { font-size: 20px; font-weight: 800; color: #0c1a2e; margin-bottom: 10px; }
        p { font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
        .actions-group { display: flex; flex-direction: column; gap: 10px; }
        .btn-reload {
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
            cursor: pointer;
            border: none;
            font-family: inherit;
        }
        .btn-reload:hover { background: linear-gradient(135deg, #0369a1, #075985); }
        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 24px;
            background: #f8fafc;
            color: #475569;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13.5px;
            transition: all 0.15s;
        }
        .btn-home:hover { background: #e2e8f0; color: #0c1a2e; }
        .site-footer { margin-top: 20px; font-size: 11.5px; color: rgba(148,163,184,0.7); text-align: center; }
    </style>
</head>
<body>

<div class="card">
    <div class="error-code">500</div>
    <h1>Terjadi Kendala Sistem</h1>
    <p>Mohon maaf, server sedang mengalami kendala sementara saat memproses permintaan Anda. Silakan muat ulang halaman atau hubungi administrator IT.</p>
    <div class="actions-group">
        <button onclick="window.location.reload()" class="btn-reload">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
            Muat Ulang Halaman
        </button>
        <a href="{{ url('/') }}" class="btn-home">
            Kembali ke Beranda
        </a>
    </div>
</div>

<div class="site-footer">
    &copy; {{ date('Y') }} IRGT School — Sistem Inventaris Aset IT
</div>

</body>
</html>
