<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru — IRGT Inventory System</title>
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
            padding: 40px 36px;
            max-width: 460px;
            width: 100%;
            box-shadow: 0 24px 80px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        .card-header { text-align: center; margin-bottom: 24px; }
        .logo-box {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
            box-shadow: 0 8px 24px rgba(3,105,161,0.4);
        }
        .logo-box svg { color: #fff; }
        .badge-brand {
            display: inline-block;
            background: #e0f2fe;
            color: #0c4a6e;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.08em;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
        h1 { font-size: 23px; font-weight: 800; color: #0c1a2e; margin-bottom: 4px; letter-spacing: -0.02em; }
        .subtitle { font-size: 13px; color: #64748b; }

        .notice-box {
            background: #f0f9ff;
            border: 1.5px solid #bae6fd;
            border-radius: 12px;
            padding: 11px 14px;
            margin-bottom: 22px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .notice-box svg { color: #0369a1; flex-shrink: 0; margin-top: 2px; }
        .notice-text { font-size: 12px; color: #0369a1; font-weight: 600; line-height: 1.5; }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 11px 14px 11px 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 11px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0c1a2e;
            background: #f8fafc;
            transition: all 0.15s;
            outline: none;
        }
        input:focus {
            border-color: #0369a1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(3,105,161,0.12);
        }
        .pw-toggle { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px; transition: color 0.15s; }
        .pw-toggle:hover { color: #0369a1; }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #0369a1, #075985);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14.5px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(3,105,161,0.35);
            transition: all 0.15s;
            letter-spacing: 0.01em;
            margin-top: 8px;
            margin-bottom: 20px;
        }
        .btn-submit:hover { background: linear-gradient(135deg, #0ea5e9, #0369a1); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(3,105,161,0.45); }

        .card-footer { text-align: center; padding-top: 18px; border-top: 1.5px solid #f0f9ff; font-size: 13px; color: #64748b; }
        .card-footer a { color: #0369a1; font-weight: 700; text-decoration: none; }
        .card-footer a:hover { text-decoration: underline; color: #075985; }

        .alert-error { background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 12px 14px; margin-bottom: 20px; }
        .alert-error ul { list-style: none; }
        .alert-error li { font-size: 12.5px; color: #b91c1c; font-weight: 500; }

        .site-footer { margin-top: 20px; font-size: 11.5px; color: rgba(148,163,184,0.7); text-align: center; position: relative; z-index: 1; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <div class="logo-box">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        </div>
        <div class="badge-brand">IRGT INVENTORY SYSTEM</div>
        <h1>Daftar Akun Baru</h1>
        <p class="subtitle">Buat akun untuk masuk ke sistem inventaris IRGT School</p>
    </div>

    <div class="notice-box">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        <div class="notice-text">
            Akun baru dapat langsung digunakan untuk <strong>mengajukan dan memantau laporan perbaikan perangkat</strong> ke Tim IT.
        </div>
    </div>

    @if(isset($errors) && $errors->any())
    <div class="alert-error">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </span>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Nama lengkap Anda"
                    autocomplete="name"
                    required
                    autofocus
                >
            </div>
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@irgtschool.id"
                    autocomplete="email"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                    required
                >
                <button type="button" class="pw-toggle" onclick="togglePw('password', this)" title="Tampilkan / sembunyikan password">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </span>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password di atas"
                    autocomplete="new-password"
                    required
                >
                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)" title="Tampilkan / sembunyikan password">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">Daftar Sekarang</button>

        <div class="card-footer">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </form>
</div>

<div class="site-footer">
    &copy; {{ date('Y') }} IRGT School. All rights reserved.
</div>

<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
    } else {
        input.type = 'password';
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    }
}
</script>

</body>
</html>
