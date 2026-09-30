<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lupa Password — IRGT Inventory System</title>
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
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -120px; left: -120px;
            width: 480px; height: 480px;
            background: radial-gradient(circle, rgba(14,165,233,0.25) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 6s ease-in-out infinite alternate;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(3,105,161,0.2) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite alternate-reverse;
        }
        @keyframes pulse { from { transform: scale(1); } to { transform: scale(1.12); } }

        .card {
            background: #fff;
            border-radius: 22px;
            padding: 36px 32px;
            max-width: 430px;
            width: 100%;
            box-shadow: 0 24px 80px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .logo-box {
            width: 54px; height: 54px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            box-shadow: 0 8px 24px rgba(14,165,233,0.4);
            color: #fff;
            overflow: hidden;
            padding: 4px;
        }
        .badge-brand {
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 8px;
        }
        h1 { font-size: 21px; font-weight: 800; color: #0c1a2e; margin-bottom: 8px; }
        .subtitle { font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 20px; }

        .it-contact-card {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 24px;
            text-align: left;
        }
        .it-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            font-size: 12.5px;
        }
        .it-row:not(:last-child) { border-bottom: 1px solid #f1f5f9; }
        .it-lbl { color: #64748b; font-weight: 600; }
        .it-val { color: #0c1a2e; font-weight: 700; }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(3,105,161,0.35);
            transition: all 0.2s;
        }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        .site-footer { margin-top: 20px; font-size: 11.5px; color: rgba(148,163,184,0.7); text-align: center; position: relative; z-index: 1; }
    </style>
</head>
<body>

<div class="card">
    <div class="logo-box">
        @include('partials.navbar-logo')
    </div>
    <div class="badge-brand">IRGT INVENTORY SYSTEM</div>
    <h1>Lupa Password Akun?</h1>
    <p class="subtitle">
        Untuk alasan keamanan data inventaris, silakan <strong>hubungi Pihak IT IRGT School (Super Admin)</strong> untuk melakukan reset atau perubahan password akun Anda.
    </p>

    <div class="it-contact-card">
        <div class="it-row">
            <span class="it-lbl">Kontak Tim IT</span>
            <span class="it-val">it@zigge.my.id</span>
        </div>
        <div class="it-row">
            <span class="it-lbl">Penanggung Jawab</span>
            <span class="it-val">Super Admin / Petugas IT</span>
        </div>
        <div class="it-row">
            <span class="it-lbl">Password Default Reset</span>
            <span class="it-val" style="font-family:monospace; color:#0369a1; font-weight:700;">IRGTE165</span>
        </div>
    </div>

    <a href="{{ route('login') }}" class="btn-submit">Kembali ke Halaman Login</a>
</div>

<div class="site-footer">
    &copy; {{ date('Y') }} IRGT School. All rights reserved.
</div>

</body>
</html>
