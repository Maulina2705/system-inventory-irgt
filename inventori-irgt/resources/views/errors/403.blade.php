<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Menunggu Persetujuan — IRGT Inventory System</title>
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
            padding: 32px 20px;
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
            border-radius: 24px;
            padding: 44px 36px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 24px 80px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .icon-box {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            border: 2px solid #7dd3fc;
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #0369a1;
            box-shadow: 0 8px 24px rgba(3,105,161,0.15);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.06em;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; margin-bottom: 10px; letter-spacing: -0.02em; line-height: 1.3; }
        .description { font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }

        .account-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 20px;
            text-align: left;
        }
        .account-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: 12.5px; }
        .account-row:last-child { margin-bottom: 0; }
        .acc-label { color: #64748b; font-weight: 600; }
        .acc-val { color: #0c1a2e; font-weight: 700; }
        .acc-role { background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 800; }

        .info-tip {
            background: #f0f9ff;
            border: 1.5px solid #bae6fd;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 28px;
            font-size: 12.5px;
            color: #0369a1;
            font-weight: 600;
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: left;
        }

        .actions-group { display: flex; flex-direction: column; gap: 10px; }
        .btn-portal {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 14px rgba(3,105,161,0.35);
            transition: all 0.15s;
        }
        .btn-portal:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        .btn-logout-out {
            width: 100%;
            padding: 11px;
            background: #f8fafc;
            color: #64748b;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-logout-out:hover { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }

        .site-footer { margin-top: 20px; font-size: 11.5px; color: rgba(148,163,184,0.7); text-align: center; position: relative; z-index: 1; }
    </style>
</head>
<body>

<div class="card">
    <div class="icon-box">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
    </div>

    <div class="badge-status">
        Akses Khusus Petugas IT
    </div>

    <h1>Akses Pengelolaan Dibatasi</h1>
    <p class="description">
        @auth
            Halo <strong>{{ auth()->user()->name }}</strong>! Halaman pengelolaan master data inventaris internal khusus untuk <strong>Admin / Petugas IT</strong>. Akun Anda dapat digunakan untuk <strong>mengajukan laporan kerusakan dan memantau proses perbaikan</strong> perangkat.
        @else
            Halaman ini memerlukan wewenang sebagai Admin Petugas IT.
        @endauth
    </p>

    @auth
    <div class="account-box">
        <div class="account-row">
            <span class="acc-label">Nama Akun:</span>
            <span class="acc-val">{{ auth()->user()->name }}</span>
        </div>
        <div class="account-row">
            <span class="acc-label">Email:</span>
            <span class="acc-val">{{ auth()->user()->email }}</span>
        </div>
        <div class="account-row">
            <span class="acc-label">Role Saat Ini:</span>
            <span class="acc-role">{{ strtoupper(auth()->user()->role ?? 'USER') }} (Pelapor / User)</span>
        </div>
    </div>
    @endauth

    <div class="info-tip">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        <div>
            Gunakan tombol di bawah untuk <strong>mengajukan tiket perbaikan</strong> atau membuka <strong>daftar laporan Anda</strong>.
        </div>
    </div>

    <div class="actions-group">
        <a href="{{ route('reports.index') }}" class="btn-portal" style="background: linear-gradient(135deg, #0ea5e9, #0369a1);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            Buka Portal Laporan & Pengajuan Servis
        </a>

        <a href="{{ route('reports.create') }}" class="btn-portal" style="background: linear-gradient(135deg, #d97706, #b45309); box-shadow: 0 4px 14px rgba(180,83,9,0.35);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Ajukan Laporan Kerusakan Baru
        </a>

        <a href="{{ route('public.assets.index') }}" class="btn-portal" style="background: #f8fafc; color: #0369a1; border: 1.5px solid #bae6fd; box-shadow: none;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
            Lihat Status Inventaris Publik
        </a>

        @auth
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout-out">
                Keluar / Ganti Akun
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn-logout-out" style="text-decoration:none; display:block; text-align:center;">
            Masuk dengan Akun Lain
        </a>
        @endauth
    </div>
</div>

<div class="site-footer">
    &copy; {{ date('Y') }} IRGT School — Sistem Inventaris Aset IT
</div>

</body>
</html>
