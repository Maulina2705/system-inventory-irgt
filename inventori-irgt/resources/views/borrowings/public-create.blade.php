<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ajukan Peminjaman {{ $asset->name }} — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; padding-bottom: 40px; }

        .topbar { background: #0c1a2e; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 10px; color: #fff; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; font-weight: 800; font-size: 14px; }
        .btn-back { background: rgba(255,255,255,0.12); color: #bae6fd; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.15s; }

        .container { max-width: 520px; margin: 20px auto; padding: 0 16px; }
        
        .card { background: #ffffff; border-radius: 18px; border: 1.5px solid #e0f2fe; padding: 22px; box-shadow: 0 8px 24px rgba(3,105,161,0.06); margin-bottom: 20px; }

        .asset-summary { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 1.5px solid #bae6fd; border-radius: 14px; padding: 14px 16px; margin-bottom: 20px; }
        .asset-code { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: #0369a1; background: #fff; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-bottom: 4px; }
        .asset-name { font-size: 15px; font-weight: 800; color: #0c1a2e; line-height: 1.3; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 11.5px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; }
        .form-label span { color: #ef4444; }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            background: #f8fafc;
            color: #0c1a2e;
            outline: none;
            transition: all 0.15s;
        }
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            border-color: #0369a1;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(3, 105, 161, 0.12);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
            transition: all 0.15s;
        }
        .btn-submit:active { transform: scale(0.98); }

        .alert-error { background: #fee2e2; border: 1.5px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 16px; }
    </style>
</head>
<body>

    <div class="topbar">
        <a href="{{ route('asset.scan', $asset->qr_token) }}" class="topbar-brand">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            <span>Form Pengajuan Peminjaman</span>
        </a>
        <a href="{{ route('asset.scan', $asset->qr_token) }}" class="btn-back">Batal</a>
    </div>

    <div class="container">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="list-style: disc; margin-left: 20px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <!-- Asset Summary -->
            <div class="asset-summary">
                <span class="asset-code">{{ $asset->asset_code }}</span>
                <div class="asset-name">{{ $asset->name }}</div>
                <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">
                    Lokasi: {{ $asset->location->name ?? '-' }} • Jenis: {{ $asset->assetType->name ?? '-' }}
                </div>
            </div>

            <form method="POST" action="{{ route('public.borrowings.store', $asset->qr_token) }}">
                @csrf

                <!-- Nama Peminjam -->
                <div class="form-group">
                    <label class="form-label">Nama Lengkap Peminjam <span>*</span></label>
                    <input 
                        type="text" 
                        name="borrower_name" 
                        value="{{ old('borrower_name', auth()->user()?->name) }}" 
                        placeholder="Contoh: Budi Santoso / Guru Matematika" 
                        class="form-input" 
                        required
                    >
                </div>

                <!-- Nomor Identitas / Kontak -->
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp / NIP / NIS</label>
                    <input 
                        type="text" 
                        name="borrower_identifier" 
                        value="{{ old('borrower_identifier') }}" 
                        placeholder="Contoh: 081234567890 / 19850..." 
                        class="form-input"
                    >
                </div>

                <!-- Unit / Departemen / Kelas -->
                <div class="form-group">
                    <label class="form-label">Departemen / Kelas / Bagian</label>
                    <input 
                        type="text" 
                        name="department_class" 
                        value="{{ old('department_class') }}" 
                        placeholder="Contoh: Kelas 8 Al-Khawarizmi / Tim OSIS" 
                        class="form-input"
                    >
                </div>

                <!-- Keperluan -->
                <div class="form-group">
                    <label class="form-label">Keperluan Peminjaman <span>*</span></label>
                    <textarea 
                        name="purpose" 
                        rows="2" 
                        placeholder="Contoh: Presentasi materi ujian praktik di Laboratorium IPA..." 
                        class="form-textarea" 
                        required
                    >{{ old('purpose') }}</textarea>
                </div>

                <!-- Waktu Pinjam & Rencana Kembali -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Mulai Pinjam <span>*</span></label>
                        <input 
                            type="datetime-local" 
                            name="borrowed_at" 
                            value="{{ old('borrowed_at', date('Y-m-d\TH:i')) }}" 
                            class="form-input" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">Rencana Kembali <span>*</span></label>
                        <input 
                            type="datetime-local" 
                            name="expected_return_at" 
                            value="{{ old('expected_return_at', date('Y-m-d\TH:i', strtotime('+1 day'))) }}" 
                            class="form-input" 
                            required
                        >
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div class="form-group">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea 
                        name="notes" 
                        rows="2" 
                        placeholder="Contoh: Mohon disiapkan kabel konverter HDMI tambahan..." 
                        class="form-textarea"
                    >{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Kirim Pengajuan Peminjaman</span>
                </button>
            </form>
        </div>
    </div>

</body>
</html>
