<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ajukan Laporan Kerusakan / Maintenance — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* NAVBAR */
        .navbar { background: #0c1a2e; min-height: 64px; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 4px 20px rgba(0,0,0,0.15); gap: 12px; }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; flex-shrink: 0; }
        .nav-logo { width: 34px; height: 34px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 3px 10px rgba(3,105,161,0.35); flex-shrink: 0; }
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
        .btn-logout:hover { background: #dc2626; color: #fff; }

        /* CONTAINER */
        .container { max-width: 860px; margin: 0 auto; padding: 24px 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 3px; }
        .page-title p { font-size: 13px; color: #64748b; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; transition: all 0.15s; }
        .btn-back:hover { background: #f8fafc; color: #0c1a2e; }

        /* PRESELECTED ASSET BANNER */
        .asset-box { background: linear-gradient(135deg, #0c1a2e, #0c4a6e); border-radius: 14px; padding: 16px 20px; color: #fff; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .asset-code-badge { font-family: monospace; font-size: 14px; font-weight: 800; background: rgba(255,255,255,0.15); padding: 4px 10px; border-radius: 6px; color: #bae6fd; letter-spacing: 0.03em; }
        .asset-box-name { font-size: 16px; font-weight: 800; color: #fff; margin-top: 4px; }
        .asset-box-meta { font-size: 12px; color: #7dd3fc; margin-top: 2px; }

        /* CARD FORM */
        .card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 4px 24px rgba(0,0,0,0.05); border: 1px solid #e0f2fe; }
        .section-title { font-size: 13.5px; font-weight: 800; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1.5px solid #e0f2fe; display: flex; align-items: center; gap: 8px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.full { grid-column: 1 / -1; }

        label { font-size: 12.5px; font-weight: 700; color: #334155; }
        .required { color: #e11d48; }

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 9px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0c1a2e;
            background: #f8fafc;
            transition: all 0.15s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #0369a1;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(3,105,161,0.12);
        }
        textarea { resize: vertical; min-height: 90px; }

        .form-actions { display: flex; justify-content: flex-end; gap: 10px; padding-top: 18px; border-top: 1.5px solid #f0f9ff; }
        .btn-submit { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 11px 22px; border-radius: 9px; font-weight: 700; font-size: 13.5px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.3); transition: all 0.15s; }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); }

        .alert-error { background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; }
        .alert-error li { font-size: 12.5px; color: #b91c1c; margin-left: 16px; }

        /* RESPONSIVE MOBILE */
        @media (max-width: 768px) {
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
            .nav-links { order: 3; width: 100%; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; scrollbar-width: none; padding-top: 4px; }
            .nav-links::-webkit-scrollbar { display: none; }
            .container { padding: 16px 12px; }
            .card { padding: 18px 14px; }
            .form-grid { grid-template-columns: 1fr; gap: 12px; }
            .form-actions { flex-direction: column; }
            .btn-submit, .btn-back { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<!-- CONTAINER -->
<div class="container">
    <div class="page-header">
        <div class="page-title">
            <h1>Ajukan Laporan Kerusakan</h1>
            <p>Sampaikan kendala teknis atau perbaikan perangkat kepada Tim IT IRGT School.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali
        </a>
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

    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <!-- 1. IDENTITAS PERANGKAT -->
            <div class="section-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                1. Perangkat / Aset yang Bermasalah
            </div>

            @if($selectedAsset)
            <input type="hidden" name="asset_id" value="{{ $selectedAsset->id }}">
            <div class="asset-box">
                <div>
                    <span class="asset-code-badge">{{ $selectedAsset->asset_code }}</span>
                    <div class="asset-box-name">{{ $selectedAsset->name }}</div>
                    <div class="asset-box-meta">Lokasi: {{ $selectedAsset->placement->name ?? '-' }} ({{ $selectedAsset->location->name ?? '-' }})</div>
                </div>
                <a href="{{ route('reports.create') }}" style="font-size:12px; color:#bae6fd; text-decoration:underline;">Ganti Perangkat</a>
            </div>
            @else
            <div class="form-group full" style="margin-bottom:16px;">
                <label>Pilih Aset / Perangkat <span class="required">*</span></label>
                <select name="asset_id" required>
                    <option value="">-- Pilih Perangkat yang Mengalami Kendala --</option>
                    @foreach($assets as $asset)
                    <option value="{{ $asset->id }}" {{ (old('asset_id') == $asset->id) ? 'selected' : '' }}>
                        [{{ $asset->asset_code }}] {{ $asset->name }} — {{ $asset->placement->name ?? '' }} ({{ $asset->location->name ?? '' }})
                    </option>
                    @endforeach
                </select>
                <div style="font-size:11.5px; color:#64748b; margin-top:3px;">
                    Catatan: Anda juga dapat scan QR Code pada bodi perangkat untuk langsung mengajukan laporan.
                </div>
            </div>
            @endif

            <!-- 2. DETAIL KENDALA -->
            <div class="section-title" style="margin-top:14px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                2. Detail Gejala Kerusakan
            </div>

            <div class="form-grid">
                <div class="form-group full">
                    <label>Judul / Ringkasan Masalah <span class="required">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Monitor tidak mau menyala, Keyboard tombol space macet" required>
                </div>

                <div class="form-group">
                    <label>Tingkat Urgensi / Prioritas <span class="required">*</span></label>
                    <select name="priority" required>
                        <option value="MEDIUM" {{ old('priority', 'MEDIUM') === 'MEDIUM' ? 'selected' : '' }}>Sedang (Medium) — Digunakan reguler</option>
                        <option value="LOW" {{ old('priority') === 'LOW' ? 'selected' : '' }}>Rendah (Low) — Kendala kecil</option>
                        <option value="HIGH" {{ old('priority') === 'HIGH' ? 'selected' : '' }}>Tinggi (High) — Mengganggu aktivitas KBM</option>
                        <option value="EMERGENCY" {{ old('priority') === 'EMERGENCY' ? 'selected' : '' }}>Darurat (Emergency) — Perangkat vital / server</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp / Telepon (Opsional)</label>
                    <input type="text" name="reporter_phone" value="{{ old('reporter_phone') }}" placeholder="081234567890 (agar tim IT mudah menghubungi)">
                </div>

                <div class="form-group full">
                    <label>Deskripsi Lengkap Gejala Kerusakan <span class="required">*</span></label>
                    <textarea name="description" placeholder="Jelaskan secara rinci apa yang terjadi, kapan kendala muncul, pesan error (jika ada), dll." required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group full">
                    <label>Lampirkan Foto Kendala (Opsional)</label>
                    <input type="file" name="photo" accept="image/png,image/jpeg,image/jpg" style="background:#fff;">
                    <div style="font-size:11.5px; color:#64748b; margin-top:3px;">
                        Hanya format <strong>PNG</strong> atau <strong>JPG/JPEG</strong>. Foto akan otomatis dikompresi untuk mempercepat proses upload dan menghemat penyimpanan.
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="form-actions">
                <a href="{{ route('reports.index') }}" class="btn-back">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Kirim Laporan Kerusakan
                </button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
