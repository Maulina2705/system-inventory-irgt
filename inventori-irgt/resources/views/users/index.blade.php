<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Pengguna & Role — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* NAVBAR */
        .navbar { background: #0c1a2e; min-height: 64px; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 4px 20px rgba(0,0,0,0.15); gap: 12px; }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; flex-shrink: 0; }
        .nav-logo { width: 34px; height: 34px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 3px 10px rgba(3,105,161,0.35); flex-shrink: 0; overflow: hidden; padding: 2px; }
        .nav-brand-text h2 { font-size: 14px; font-weight: 800; color: #fff; line-height: 1.2; }
        .nav-brand-text span { font-size: 10.5px; color: #7dd3fc; }
        .nav-links { display: flex; align-items: center; gap: 4px; list-style: none; }
        .nav-links a { display: flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: #bae6fd; transition: all 0.15s; white-space: nowrap; }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-links a.active { color: #fff; background: #0369a1; }
        .nav-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .user-pill { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 30px; }
        .user-avatar { width: 26px; height: 26px; background: #0369a1; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }
        .user-name { font-size: 11.5px; font-weight: 600; color: #f0f9ff; line-height: 1.2; }
        .user-role { font-size: 9.5px; color: #7dd3fc; text-transform: capitalize; }
        .btn-logout { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.25); padding: 6px 10px; border-radius: 8px; font-size: 11.5px; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.15s; }
        .btn-logout:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* CONTAINER */
        .container { max-width: 1360px; margin: 0 auto; padding: 24px 20px; }
        .page-header { margin-bottom: 20px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 3px; }
        .page-title p { font-size: 13px; color: #64748b; }

        /* ALERTS */
        .alert-success { background: #dcfce7; border: 1.5px solid #86efac; border-radius: 12px; padding: 12px 16px; color: #15803d; font-weight: 600; font-size: 13px; margin-bottom: 18px; }
        .alert-error { background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 12px; padding: 12px 16px; color: #b91c1c; font-weight: 600; font-size: 13px; margin-bottom: 18px; }

        /* STATS */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 14px 16px; border: 1.5px solid #e0f2fe; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .stat-num { font-size: 22px; font-weight: 800; color: #0369a1; margin-bottom: 2px; }
        .stat-label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; }

        /* FILTER & SEARCH */
        .filter-card { background: #fff; border-radius: 12px; padding: 14px 16px; border: 1.5px solid #e0f2fe; margin-bottom: 20px; }
        .filter-form { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .filter-input { flex: 1; min-width: 200px; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; background: #f8fafc; outline: none; }
        .filter-input:focus { border-color: #0369a1; background: #fff; }
        .filter-select { padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; background: #f8fafc; outline: none; }
        .btn-filter { padding: 9px 16px; background: #0369a1; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit; }
        .btn-filter:hover { background: #075985; }
        .btn-reset { padding: 9px 12px; background: #f1f5f9; color: #64748b; text-decoration: none; border-radius: 8px; font-size: 12.5px; font-weight: 600; }

        /* TABLE */
        .card { background: #fff; border-radius: 14px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e0f2fe; }
        .card-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 980px; }
        th { background: #f0f9ff; text-align: left; padding: 12px 14px; border-bottom: 2px solid #e0f2fe; font-size: 11.5px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 12px 14px; border-bottom: 1px solid #f0f9ff; font-size: 13px; color: #334155; vertical-align: middle; }
        tr:hover td { background: #f8fafc; }

        .user-item { display: flex; align-items: center; gap: 10px; }
        .u-avatar { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; flex-shrink: 0; }
        .u-name { font-weight: 700; color: #0c1a2e; }
        .u-email { font-size: 11.5px; color: #64748b; }

        .badge-role { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; letter-spacing: 0.02em; }
        .role-super_admin { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .role-admin { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .role-user { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        /* ROLE SELECT FORM */
        .role-form { display: flex; align-items: center; gap: 5px; }
        .select-role { padding: 5px 8px; border: 1.5px solid #cbd5e1; border-radius: 7px; font-size: 12px; font-family: inherit; background: #fff; outline: none; }
        .btn-update-role { padding: 5px 10px; background: #0369a1; color: #fff; border: none; border-radius: 7px; font-size: 11.5px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s; }
        .btn-update-role:hover { background: #075985; }

        /* ACTION BUTTONS */
        .btn-edit-pw { padding: 5px 9px; background: #0369a1; color: #fff; border: 1px solid #0369a1; border-radius: 7px; font-size: 11.5px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px; }
        .btn-edit-pw:hover { background: #075985; border-color: #075985; }

        .btn-reset-pw { padding: 5px 9px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; border-radius: 7px; font-size: 11.5px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s; white-space: nowrap; }
        .btn-reset-pw:hover { background: #bae6fd; color: #075985; }

        .btn-del-user { padding: 5px 9px; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; border-radius: 7px; font-size: 11.5px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s; }
        .btn-del-user:hover { background: #dc2626; color: #fff; }

        .pagination-wrap { padding: 0; }

        /* CUSTOM MODAL SYSTEM */
        .custom-modal-backdrop { position: fixed; inset: 0; background: rgba(12,26,46,0.65); backdrop-filter: blur(5px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 16px; opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
        .custom-modal-backdrop.active { opacity: 1; pointer-events: auto; }
        .custom-modal-card { background: #fff; border-radius: 20px; max-width: 450px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 24px; box-shadow: 0 25px 70px rgba(0,0,0,0.3); border: 1.5px solid #e0f2fe; transform: translateY(12px) scale(0.96); transition: transform 0.2s ease; }
        .custom-modal-backdrop.active .custom-modal-card { transform: translateY(0) scale(1); }

        .modal-icon-badge { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .badge-blue { background: #e0f2fe; color: #0369a1; }
        .badge-amber { background: #fef3c7; color: #b45309; }
        .badge-red { background: #fee2e2; color: #b91c1c; }

        .modal-title-wrap h3 { font-size: 17px; font-weight: 800; color: #0c1a2e; margin-bottom: 4px; }
        .modal-title-wrap p { font-size: 13px; color: #64748b; line-height: 1.5; }

        .modal-user-box { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 14px; margin: 16px 0; font-size: 12.5px; line-height: 1.6; }
        .modal-user-box strong { color: #0c1a2e; }

        .modal-actions { display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px; padding-top: 14px; border-top: 1.5px solid #f0f9ff; flex-wrap: wrap; }
        .btn-modal-cancel { padding: 9px 16px; background: #f1f5f9; color: #475569; border: none; border-radius: 9px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s; }
        .btn-modal-cancel:hover { background: #e2e8f0; color: #0c1a2e; }
        .btn-modal-submit-blue { padding: 9px 18px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; border-radius: 9px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(3,105,161,0.3); transition: all 0.15s; }
        .btn-modal-submit-blue:hover { background: linear-gradient(135deg, #0369a1, #075985); }
        .btn-modal-submit-amber { padding: 9px 18px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; border: none; border-radius: 9px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(217,119,6,0.3); transition: all 0.15s; }
        .btn-modal-submit-amber:hover { background: linear-gradient(135deg, #d97706, #b45309); }
        .btn-modal-submit-red { padding: 9px 18px; background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; border: none; border-radius: 9px; font-size: 13px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 12px rgba(220,38,38,0.3); transition: all 0.15s; }
        .btn-modal-submit-red:hover { background: linear-gradient(135deg, #dc2626, #b91c1c); }

        /* RESPONSIVE MOBILE */
        @media (max-width: 900px) {
            html, body { overflow-x: hidden; width: 100%; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .navbar { flex-wrap: wrap; height: auto; padding: 10px 14px; gap: 8px; justify-content: space-between; }
            .nav-brand { flex: 1; min-width: 0; }
            .nav-brand-text h2 { font-size: 13px; }
            .nav-brand-text span { display: none; }
            .nav-right { gap: 6px; }
            .user-pill { padding: 3px 8px; gap: 6px; border-radius: 20px; }
            .user-avatar { width: 22px; height: 22px; font-size: 10.5px; }
            .user-name { font-size: 11px; max-width: 75px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .user-role { display: none; }
            .btn-logout { padding: 6px 8px; min-width: 32px; height: 32px; justify-content: center; border-radius: 7px; }
            .btn-logout span { display: none; }
            .nav-links { order: 3; width: 100%; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
            .nav-links::-webkit-scrollbar { display: none; }
            .container { padding: 14px 10px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 8px; }
            .filter-form { flex-direction: column; gap: 8px; }
            .filter-input, .filter-select, .btn-filter, .btn-reset { width: 100%; min-width: 100%; text-align: center; }
            .custom-modal-card { padding: 18px 16px; border-radius: 16px; }
            .modal-actions { justify-content: stretch; }
            .modal-actions button { flex: 1; text-align: center; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<!-- MAIN CONTENT -->
<div class="container">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div class="page-title">
            <h1>Kelola Pengguna, Wewenang & Kredensial</h1>
            <p>Khusus Super Admin: Atur wewenang pengguna, daftarkan akun baru, dan kelola kredensial sistem.</p>
        </div>
        <div>
            <button onclick="openModal('createUserModal')" class="btn-modal-submit-blue" style="padding: 10px 18px; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Tambah Pengguna Baru</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('password_reset_success'))
    @php $pwData = session('password_reset_success'); @endphp
    <div class="alert-success" style="background:#f0fdf4; border:1.5px solid #86efac; color:#166534; padding:16px; border-radius:12px; margin-bottom:16px;">
        <div style="font-weight:800; font-size:14px; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            Password Akun Berhasil Diperbarui!
        </div>
        <div style="font-size:13px; color:#1e293b; margin:6px 0;">
            Akun <strong>{{ $pwData['name'] }}</strong> ({{ $pwData['email'] }}) telah disetel kata sandinya:
        </div>
        <div style="display:inline-flex; align-items:center; gap:8px; background:#fff; padding:6px 12px; border-radius:8px; border:1.5px solid #bbf7d0; margin-top:4px;">
            <span style="font-family:monospace; font-weight:800; font-size:15px; color:#15803d; letter-spacing:0.05em;">
                {{ $pwData['password'] }}
            </span>
            <button type="button" onclick="copyUserPw('{{ $pwData['password'] }}', this)" title="Salin password" style="background:#f1f5f9; border:1px solid #cbd5e1; border-radius:6px; padding:4px 8px; cursor:pointer; font-size:11px; font-weight:700; color:#334155; font-family:inherit;">
                Salin Password
            </button>
        </div>
        <div style="font-size:11.5px; color:#64748b; margin-top:8px;">
            <em>*Demi alasan keamanan (OWASP), password ini dienkripsi di database dan hanya ditampilkan satu kali pada notifikasi ini. Silakan salin dan berikan kepada pengguna.</em>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert-error">
        <ul style="list-style:none;">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-num">{{ $totalAll }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#b45309;">{{ $totalSuperAdmin }}</div>
            <div class="stat-label">Super Admin</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#0369a1;">{{ $totalAdmin }}</div>
            <div class="stat-label">Admin (Petugas IT)</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#475569;">{{ $totalUser }}</div>
            <div class="stat-label">User (Pelapor)</div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="filter-card">
        <form method="GET" action="{{ route('users.index') }}" class="filter-form">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nama atau email pengguna..."
                class="filter-input"
            >
            <select name="role" class="filter-select">
                <option value="">Semua Role</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
            </select>
            <select name="per_page" class="filter-select" onchange="this.form.submit()">
                @foreach([15, 25, 50, 100, 150, 200] as $num)
                <option value="{{ $num }}" {{ request('per_page', 15) == $num ? 'selected' : '' }}>{{ $num }} data</option>
                @endforeach
                <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Semua Data</option>
            </select>
            <button type="submit" class="btn-filter">Cari</button>
            @if(request()->anyFilled(['q', 'role', 'per_page']))
            <a href="{{ route('users.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-scroll">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengguna</th>
                        <th>Role Saat Ini</th>
                        <th>Keamanan Akun</th>
                        <th>Ubah Wewenang (Role)</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td style="color:#94a3b8; font-size:12.5px;">{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="user-item">
                                <div class="u-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="u-name">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                        <span style="font-size:10.5px; color:#0369a1; font-weight:700;">(Anda)</span>
                                        @endif
                                    </div>
                                    <div class="u-email">{{ $user->email }}</div>
                                    <div style="font-size:10.5px; color:#94a3b8; margin-top:2px;">Terdaftar: {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $roleClass = 'role-' . ($user->role ?? 'user');
                                $roleTitle = match($user->role) {
                                    'super_admin' => 'SUPER ADMIN',
                                    'admin' => 'ADMIN (IT)',
                                    default => 'USER',
                                };
                            @endphp
                            <span class="badge-role {{ $roleClass }}">{{ $roleTitle }}</span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="font-size:11.5px; color:#15803d; background:#f0fdf4; border:1px solid #bbf7d0; padding:4px 8px; border-radius:6px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                    Terenkripsi (Bcrypt)
                                </span>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('users.update-role', $user->id) }}" class="role-form">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="select-role">
                                    <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (IT)</option>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User (Pelapor)</option>
                                </select>
                                <button type="submit" class="btn-update-role">Ubah</button>
                            </form>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:inline-flex; align-items:center; gap:5px;">
                                <!-- TOMBOL UBAH PASSWORD (MODAL) -->
                                <button type="button" class="btn-edit-pw" onclick="openEditPwModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" title="Ubah password kustom untuk akun ini">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-1.5 6.1L13 14.5l-2.5-2.5L14.9 7.6c.4-.4.4-1 0-1.4l-1.1-1.1c-.4-.4-1-.4-1.4 0L7.5 10l-2.5-2.5L9.4 3.1c.4-.4.4-1 0-1.4L8.3.6C7.9.2 7.3.2 6.9.6L2 5.5 18.5 22 22 18.5l-4.9-4.9c-.4-.4-.4-1 0-1.4l1.1-1.1c.4-.4 1-.4 1.4 0l4.4-4.4c.4-.4.4-1 0-1.4L22.6 4c-.4-.4-1-.4-1.4 0z"></path></svg>
                                    Ubah Password
                                </button>

                                <!-- TOMBOL RESET DEFAULT (MODAL) -->
                                <button type="button" class="btn-reset-pw" onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" title="Reset password akun ini ke default IRGTE165">
                                    Reset Default
                                </button>

                                <!-- TOMBOL HAPUS AKUN (MODAL) -->
                                @if($user->id !== auth()->id())
                                <button type="button" class="btn-del-user" onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" title="Hapus Pengguna">
                                    Hapus
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- 0. CUSTOM MODAL: TAMBAH PENGGUNA BARU                 -->
<!-- ==================================================== -->
<div id="createUserModal" class="custom-modal-backdrop">
    <div class="custom-modal-card" style="max-width: 500px;">
        <div class="modal-icon-badge badge-blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
        </div>
        <div class="modal-title-wrap">
            <h3>Tambah Pengguna Baru</h3>
            <p>Daftarkan akun staf, teknisi, atau administrator baru ke sistem.</p>
        </div>

        <form method="POST" action="{{ route('users.store') }}" style="margin-top: 16px;">
            @csrf
            
            <div style="margin-bottom: 12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:5px;">
                    Nama Lengkap <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="name" required placeholder="Contoh: Ahmad Fauzi, S.Kom" value="{{ old('name') }}" style="width:100%; padding:9px 12px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; background:#f8fafc; outline:none;">
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:5px;">
                    Alamat Email <span style="color:#ef4444;">*</span>
                </label>
                <input type="email" name="email" required placeholder="nama@irgtschool.sch.id" value="{{ old('email') }}" style="width:100%; padding:9px 12px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; background:#f8fafc; outline:none;">
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:5px;">
                    Role / Wewenang Pengguna <span style="color:#ef4444;">*</span>
                </label>
                <select name="role" required style="width:100%; padding:9px 12px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; background:#f8fafc; outline:none;">
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User Biasa / Guru / Staf Pengguna</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin / Tim IT Support</option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin (Hak Akses Penuh)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 8px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:5px;">
                        Password <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="password" id="createPwInput" name="password" required minlength="8" placeholder="Min. 8 karakter" style="width:100%; padding:9px 12px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; background:#f8fafc; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:5px;">
                        Konfirmasi Password <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="password" id="createPwCfmInput" name="password_confirmation" required minlength="8" placeholder="Ulangi password" style="width:100%; padding:9px 12px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:13px; font-family:inherit; background:#f8fafc; outline:none;">
                </div>
            </div>

            <div style="display:flex; gap:6px; margin-bottom:16px;">
                <button type="button" onclick="setCreateQuickPw('IRGTE165')" style="padding:4px 8px; font-size:11px; background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; border-radius:6px; cursor:pointer; font-weight:700; font-family:inherit;">
                    Set Default: IRGTE165
                </button>
                <button type="button" onclick="generateCreateRandomPw()" style="padding:4px 8px; font-size:11px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer; font-weight:700; font-family:inherit;">
                    Acak Password
                </button>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('createUserModal')">Batal</button>
                <button type="submit" class="btn-modal-submit-blue">Daftarkan Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================================================== -->
<!-- 1. CUSTOM MODAL: UBAH PASSWORD PENGGUNA               -->
<!-- ==================================================== -->
<div id="changePwModal" class="custom-modal-backdrop">
    <div class="custom-modal-card">
        <div class="modal-icon-badge badge-blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-1.5 6.1L13 14.5l-2.5-2.5L14.9 7.6c.4-.4.4-1 0-1.4l-1.1-1.1c-.4-.4-1-.4-1.4 0L7.5 10l-2.5-2.5L9.4 3.1c.4-.4.4-1 0-1.4L8.3.6C7.9.2 7.3.2 6.9.6L2 5.5 18.5 22 22 18.5l-4.9-4.9c-.4-.4-.4-1 0-1.4l1.1-1.1c.4-.4 1-.4 1.4 0l4.4-4.4c.4-.4.4-1 0-1.4L22.6 4c-.4-.4-1-.4-1.4 0z"></path></svg>
        </div>
        <div class="modal-title-wrap">
            <h3>Ubah Password Pengguna</h3>
            <p>Tentukan kata sandi baru untuk akun pengguna ini.</p>
        </div>

        <div class="modal-user-box">
            <div>Nama Akun: <strong id="modalUserName">-</strong></div>
            <div>Email: <strong id="modalUserEmail">-</strong></div>
        </div>

        <form id="editPwForm" method="POST" action="" onsubmit="return handleEditPwSubmit(event)">
            @csrf
            @method('PATCH')
            
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12.5px; font-weight:700; color:#334155; margin-bottom:6px;">
                    Password Baru <span style="color:#ef4444;">*</span>
                </label>
                <input 
                    type="text" 
                    id="newPasswordInput" 
                    name="new_password" 
                    required 
                    minlength="8" 
                    placeholder="Minimal 8 karakter" 
                    style="width:100%; padding:10px 12px; border:1.5px solid #cbd5e1; border-radius:9px; font-size:13.5px; font-family:monospace; font-weight:700; color:#0c1a2e; background:#f8fafc; outline:none;"
                >
                <div style="display:flex; gap:6px; margin-top:8px; flex-wrap:wrap;">
                    <button type="button" onclick="setQuickPw('IRGTE165')" style="padding:4px 8px; font-size:11px; background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; border-radius:6px; cursor:pointer; font-weight:700; font-family:inherit;">
                        Gunakan Default (IRGTE165)
                    </button>
                    <button type="button" onclick="generateRandomPw()" style="padding:4px 8px; font-size:11px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer; font-weight:700; font-family:inherit;">
                        Acak Password
                    </button>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('changePwModal')">Batal</button>
                <button type="submit" class="btn-modal-submit-blue">Lanjut Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================================================== -->
<!-- 2. CUSTOM MODAL: KONFIRMASI RESET PASSWORD DEFAULT    -->
<!-- ==================================================== -->
<div id="confirmResetModal" class="custom-modal-backdrop">
    <div class="custom-modal-card">
        <div class="modal-icon-badge badge-amber">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><circle cx="12" cy="11" r="3"></circle><line x1="12" y1="14" x2="12" y2="17"></line></svg>
        </div>
        <div class="modal-title-wrap">
            <h3>Konfirmasi Reset Password Default</h3>
            <p>Password akun pengguna akan dikembalikan ke kata sandi default sistem.</p>
        </div>

        <div class="modal-user-box" style="background:#fffbeb; border-color:#fde68a;">
            <div>Pengguna: <strong id="resetUserName">-</strong></div>
            <div>Email: <strong id="resetUserEmail">-</strong></div>
            <div style="margin-top:6px; color:#b45309;">Password baru: <strong style="font-family:monospace; font-size:13px;">IRGTE165</strong></div>
        </div>

        <form id="resetPwForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('confirmResetModal')">Batal</button>
                <button type="submit" class="btn-modal-submit-amber">Ya, Reset Password</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================================================== -->
<!-- 3. CUSTOM MODAL: KONFIRMASI HAPUS PENGGUNA            -->
<!-- ==================================================== -->
<div id="confirmDeleteModal" class="custom-modal-backdrop">
    <div class="custom-modal-card">
        <div class="modal-icon-badge badge-red">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </div>
        <div class="modal-title-wrap">
            <h3>Konfirmasi Hapus Akun</h3>
            <p>Apakah Anda yakin ingin menghapus akun pengguna ini secara permanen?</p>
        </div>

        <div class="modal-user-box" style="background:#fef2f2; border-color:#fecaca;">
            <div>Nama: <strong id="deleteUserName">-</strong></div>
            <div>Email: <strong id="deleteUserEmail">-</strong></div>
            <div style="color:#b91c1c; font-size:11.5px; margin-top:4px;">Peringatan: Tindakan ini tidak dapat dibatalkan.</div>
        </div>

        <form id="deleteUserForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('confirmDeleteModal')">Batal</button>
                <button type="submit" class="btn-modal-submit-red">Ya, Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================================================== -->
<!-- 4. CUSTOM MODAL: KONFIRMASI SIMPAN UBAH PASSWORD      -->
<!-- ==================================================== -->
<div id="confirmFinalSaveModal" class="custom-modal-backdrop">
    <div class="custom-modal-card">
        <div class="modal-icon-badge badge-blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
        </div>
        <div class="modal-title-wrap">
            <h3>Anda Yakin Ingin Menyimpan?</h3>
            <p>Pastikan data password baru sudah benar sebelum disimpan ke sistem.</p>
        </div>

        <div class="modal-user-box" style="background:#f0f9ff; border-color:#bae6fd;">
            <div>Akun: <strong id="finalConfirmUserName">-</strong></div>
            <div style="margin-top:4px;">Password Baru: <strong id="finalConfirmUserPw" style="font-family:monospace; color:#0369a1; font-size:13.5px;">-</strong></div>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeModal('confirmFinalSaveModal'); openModal('changePwModal');">Kembali Ubah</button>
            <button type="button" class="btn-modal-submit-blue" onclick="executeSavePw()">Ya, Simpan Password</button>
        </div>
    </div>
</div>

<script>
let activeEditUserId = null;
let activeEditUserName = '';
let activeEditUserEmail = '';

function toggleUserPw(id) {
    const masked = document.getElementById('pw-masked-' + id);
    const plain = document.getElementById('pw-plain-' + id);
    const icon = document.getElementById('eye-icon-' + id);
    if (!plain || !masked || !icon) return;

    if (plain.style.display === 'none') {
        plain.style.display = 'inline-block';
        masked.style.display = 'none';
        icon.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
    } else {
        plain.style.display = 'none';
        masked.style.display = 'inline-block';
        icon.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    }
}

function copyUserPw(text, btn) {
    navigator.clipboard.writeText(text).then(function() {
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span style="font-size:10px; color:#15803d; font-weight:800;">✓</span>';
        setTimeout(function() {
            btn.innerHTML = originalHtml;
        }, 1500);
    });
}

function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

// 1. Ubah Password Modal
function openEditPwModal(userId, userName, userEmail) {
    activeEditUserId = userId;
    activeEditUserName = userName;
    activeEditUserEmail = userEmail;

    document.getElementById('modalUserName').innerText = userName;
    document.getElementById('modalUserEmail').innerText = userEmail;
    document.getElementById('editPwForm').action = '/users/' + userId + '/password';
    document.getElementById('newPasswordInput').value = '';
    
    openModal('changePwModal');
    setTimeout(() => {
        document.getElementById('newPasswordInput').focus();
    }, 150);
}

function setQuickPw(pw) {
    document.getElementById('newPasswordInput').value = pw;
}

function generateRandomPw() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
    let result = '';
    for (let i = 0; i < 8; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('newPasswordInput').value = result;
}

function setCreateQuickPw(pw) {
    document.getElementById('createPwInput').value = pw;
    document.getElementById('createPwCfmInput').value = pw;
}

function generateCreateRandomPw() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
    let result = '';
    for (let i = 0; i < 8; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('createPwInput').value = result;
    document.getElementById('createPwCfmInput').value = result;
}

function handleEditPwSubmit(e) {
    e.preventDefault();
    const pw = document.getElementById('newPasswordInput').value.trim();
    if (pw.length < 8) {
        alert('Password baru minimal harus 8 karakter!');
        return false;
    }
    
    closeModal('changePwModal');
    document.getElementById('finalConfirmUserName').innerText = activeEditUserName;
    document.getElementById('finalConfirmUserPw').innerText = pw;
    openModal('confirmFinalSaveModal');
    return false;
}

function executeSavePw() {
    document.getElementById('editPwForm').submit();
}

// 2. Reset Default Modal
function openResetModal(userId, userName, userEmail) {
    document.getElementById('resetUserName').innerText = userName;
    document.getElementById('resetUserEmail').innerText = userEmail;
    document.getElementById('resetPwForm').action = '/users/' + userId + '/reset-password';
    openModal('confirmResetModal');
}

// 3. Delete Modal
function openDeleteModal(userId, userName, userEmail) {
    document.getElementById('deleteUserName').innerText = userName;
    document.getElementById('deleteUserEmail').innerText = userEmail;
    document.getElementById('deleteUserForm').action = '/users/' + userId;
    openModal('confirmDeleteModal');
}

// Tutup modal jika klik di luar box
document.querySelectorAll('.custom-modal-backdrop').forEach(function(backdrop) {
    backdrop.addEventListener('click', function(e) {
        if (e.target === backdrop) {
            backdrop.classList.remove('active');
        }
    });
});
</script>

</body>
</html>
