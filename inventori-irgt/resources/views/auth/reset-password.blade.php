<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Atur Password Baru — IRGT Inventory System</title>
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
        }
        .card-header { text-align: center; margin-bottom: 24px; }
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
        h1 { font-size: 21px; font-weight: 800; color: #0c1a2e; margin-bottom: 6px; }
        .subtitle { font-size: 13px; color: #64748b; line-height: 1.5; }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .input-wrap { position: relative; display: flex; align-items: center; }
        .input-icon { position: absolute; left: 13px; color: #94a3b8; pointer-events: none; display: flex; align-items: center; }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0c1a2e;
            background: #f8fafc;
            outline: none;
            transition: all 0.2s;
        }
        input:focus { border-color: #0369a1; background: #fff; box-shadow: 0 0 0 3px rgba(3,105,161,0.15); }
        .pw-toggle { position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #94a3b8; display: flex; align-items: center; padding: 4px; }
        .pw-toggle:hover { color: #0369a1; }

        .btn-submit {
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
            box-shadow: 0 4px 16px rgba(3,105,161,0.35);
            transition: all 0.2s;
            margin-top: 6px;
        }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        .card-footer {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            font-size: 13px;
            color: #64748b;
        }
        .card-footer a { color: #0369a1; font-weight: 700; text-decoration: none; }
        .card-footer a:hover { color: #075985; text-decoration: underline; }

        .alert-error { background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; }
        .alert-error li { font-size: 13px; color: #b91c1c; font-weight: 500; margin-left: 16px; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <div class="logo-box">
            @include('partials.navbar-logo')
        </div>
        <div class="badge-brand">IRGT INVENTORY SYSTEM</div>
        <h1>Atur Password Baru</h1>
        <p class="subtitle">Silakan masukkan password baru untuk akun Anda.</p>
    </div>

    @if($errors->any())
    <div class="alert-error">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                    value="{{ old('email', $request->email) }}"
                    required
                    readonly
                    style="background:#f1f5f9; color:#64748b;"
                >
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                    autofocus
                >
                <button type="button" class="pw-toggle" onclick="togglePw('password', this)" title="Tampilkan password">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="11" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><circle cx="12" cy="11" r="3"></circle></svg>
                </span>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password baru"
                    required
                >
                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)" title="Tampilkan password">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="11" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">Simpan Password & Masuk</button>
    </form>

    <div class="card-footer">
        Batal reset? <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>
</div>

<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
    } else {
        input.type = 'password';
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="11" r="3"></circle></svg>';
    }
}
</script>

</body>
</html>
