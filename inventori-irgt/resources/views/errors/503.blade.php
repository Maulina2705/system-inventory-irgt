<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 — Pemeliharaan Sistem | IRGT Inventory</title>
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
        .icon-wrap {
            width: 64px;
            height: 64px;
            background: #e0f2fe;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0369a1;
            margin: 0 auto 16px;
        }
        h1 { font-size: 20px; font-weight: 800; color: #0c1a2e; margin-bottom: 10px; }
        p { font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
        .site-footer { margin-top: 20px; font-size: 11.5px; color: rgba(148,163,184,0.7); text-align: center; }
    </style>
</head>
<body>

<div class="card">
    <div class="icon-wrap">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
    </div>
    <h1>Pemeliharaan Sistem</h1>
    <p>Sistem inventaris sedang dalam proses pemeliharaan rutin atau pembaruan berkala. Layanan akan segera aktif kembali.</p>
</div>

<div class="site-footer">
    &copy; {{ date('Y') }} IRGT School — Sistem Inventaris Aset IT
</div>

</body>
</html>
