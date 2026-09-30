<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Form Pengaduan Kerusakan — {{ $asset->name }} | IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* HEADER */
        .topbar { background: #0c1a2e; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-logo { width: 32px; height: 32px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0; }
        .topbar-text { font-size: 13.5px; font-weight: 800; color: #fff; line-height: 1.2; }
        .topbar-text span { font-size: 10px; font-weight: 500; color: #7dd3fc; display: block; }
        .topbar-right a { color: #bae6fd; font-size: 12px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 5px; }
        .topbar-right a:hover { color: #fff; }

        /* CONTAINER */
        .container { max-width: 580px; margin: 0 auto; padding: 20px 14px 40px; }

        /* ASSET BANNER */
        .asset-card {
            background: linear-gradient(135deg, #0369a1, #0c4a6e);
            border-radius: 16px;
            padding: 18px;
            color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(3,105,161,0.2);
            position: relative;
            overflow: hidden;
        }
        .asset-card::before { content: ''; position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; background: rgba(255,255,255,0.06); border-radius: 50%; }
        .asset-code { display: inline-block; font-family: 'JetBrains Mono', monospace; font-size: 12px; font-weight: 800; background: rgba(255,255,255,0.18); padding: 4px 10px; border-radius: 6px; letter-spacing: 0.04em; margin-bottom: 8px; }
        .asset-name { font-size: 17px; font-weight: 800; line-height: 1.3; margin-bottom: 8px; }
        .asset-meta { font-size: 12px; color: #bae6fd; display: flex; flex-wrap: wrap; gap: 12px; }

        /* FORM CARD */
        .card { background: #fff; border-radius: 18px; padding: 24px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1.5px solid #e0f2fe; }
        .form-title { font-size: 18px; font-weight: 800; color: #0c1a2e; margin-bottom: 4px; }
        .form-desc { font-size: 13px; color: #64748b; margin-bottom: 22px; line-height: 1.5; }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .required { color: #ef4444; }
        input[type="text"], input[type="tel"], select, textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            color: #0c1a2e;
            background: #f8fafc;
            outline: none;
            transition: all 0.15s;
        }
        input:focus, select:focus, textarea:focus { border-color: #0369a1; background: #fff; box-shadow: 0 0 0 3px rgba(3,105,161,0.12); }
        textarea { resize: vertical; min-height: 90px; }

        .file-upload-box {
            border: 1.5px dashed #cbd5e1;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.15s;
        }
        .file-upload-box:hover { border-color: #0369a1; background: #f0f9ff; }
        .file-upload-box input { display: none; }
        .file-upload-text { font-size: 12.5px; color: #64748b; margin-top: 4px; }
        .file-upload-name { font-size: 12.5px; font-weight: 700; color: #0369a1; margin-top: 6px; display: none; }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14.5px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(3,105,161,0.35);
            transition: all 0.15s;
            margin-top: 8px;
        }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        .alert-error { background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; }
        .alert-error li { font-size: 12.5px; color: #b91c1c; margin-left: 16px; }

        .footer { text-align: center; margin-top: 24px; font-size: 11.5px; color: #94a3b8; }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <a href="{{ route('asset.scan', $asset->qr_token) }}" class="topbar-brand">
        <div class="topbar-logo">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
        </div>
        <div class="topbar-text">
            IRGT INVENTORY
            <span>Pengaduan Kerusakan IT</span>
        </div>
    </a>
    <div class="topbar-right">
        <a href="{{ route('public.reports.track') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            Lacak Tiket
        </a>
    </div>
</div>

<div class="container">
    <!-- ASSET BANNER -->
    <div class="asset-card">
        <div class="asset-code">{{ $asset->asset_code }}</div>
        <div class="asset-name">{{ $asset->name }}</div>
        <div class="asset-meta">
            <span>{{ $asset->placement->name ?? '-' }} ({{ $asset->location->name ?? '-' }})</span>
            <span>&bull;</span>
            <span>{{ $asset->assetType->name ?? '-' }}</span>
        </div>
    </div>

    <!-- FORM -->
    <div class="card">
        <div class="form-title">Buat Pengaduan / Lapor Kerusakan</div>
        <p class="form-desc">
            Isi formulir di bawah ini untuk melaporkan kendala pada perangkat ini. Tiket Anda akan langsung masuk ke antrean Tim IT IRGT School.
        </p>

        @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('public.reports.store', $asset->qr_token) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(isset($groupAssets) && $groupAssets->count() > 1)
            <div class="form-group" style="background:#f0f9ff; border:1.5px solid #bae6fd; padding:14px; border-radius:12px;">
                <label style="color:#0369a1; font-size:13px; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    <span>Pilih Perangkat yang Mengalami Kerusakan di Meja Ini: <span class="required">*</span></span>
                </label>
                <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:6px;">
                    @foreach($groupAssets as $gItem)
                    @php $isSelected = (old('target_asset_id', $targetAsset->id ?? $asset->id) == $gItem->id); @endphp
                    <label style="display:flex; align-items:center; justify-content:space-between; background:#fff; border:1.5px solid {{ $isSelected ? '#0284c7' : '#cbd5e1' }}; padding:10px 12px; border-radius:10px; cursor:pointer; transition:all 0.15s; {{ $isSelected ? 'background:#e0f2fe;' : '' }}">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <input type="radio" name="target_asset_id" value="{{ $gItem->id }}" {{ $isSelected ? 'checked' : '' }} required onchange="this.form.querySelectorAll('label').forEach(l=>l.style.borderColor='#cbd5e1'); this.closest('label').style.borderColor='#0284c7';" style="cursor:pointer; width:16px; height:16px;">
                            <div>
                                <div style="font-weight:700; color:#0c1a2e; font-size:13px; line-height:1.2;">
                                    <span style="font-family:'JetBrains Mono', monospace; font-size:10.5px; background:#e0f2fe; color:#0369a1; padding:2px 6px; border-radius:4px; margin-right:4px;">{{ $gItem->assetItem->code ?? 'DEV' }}</span>
                                    {{ $gItem->name }}
                                </div>
                                <div style="font-size:11px; color:#64748b; margin-top:2px;">
                                    {{ $gItem->asset_code }} @if($gItem->brand) • {{ $gItem->brand }} @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <span style="font-size:10px; font-weight:800; padding:2px 7px; border-radius:4px; color: {{ $gItem->condition === 'GOOD' ? '#15803d' : '#b91c1c' }}; background: {{ $gItem->condition === 'GOOD' ? '#dcfce7' : '#fee2e2' }};">
                                {{ $gItem->condition }}
                            </span>
                        </div>
                    </label>
                    @endforeach
                </div>
                <div style="font-size:11px; color:#075985; margin-top:4px;">
                    *Tiket laporan kerusakan akan langsung dikaitkan secara spesifik pada perangkat yang Anda pilih di atas.
                </div>
            </div>
            @endif

            <div class="form-group">
                <label for="reporter_name">Nama Lengkap Pelapor <span class="required">*</span></label>
                <input
                    type="text"
                    id="reporter_name"
                    name="reporter_name"
                    value="{{ old('reporter_name', auth()->user()->name ?? '') }}"
                    placeholder="Contoh: Budi Santoso, S.Pd."
                    required
                >
            </div>

            <div class="form-group">
                <label for="reporter_department">Departemen / Unit Kerja <span class="required">*</span></label>
                <select id="reporter_department" name="reporter_department" required>
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departments as $deptKey => $deptLabel)
                    <option value="{{ $deptKey }}" {{ old('reporter_department') == $deptKey ? 'selected' : '' }}>
                        {{ $deptLabel }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="reporter_phone">No. WhatsApp / Kontak <span style="font-size:11px; font-weight:normal; color:#64748b;">(Opsional, untuk konfirmasi perbaikan)</span></label>
                <input
                    type="tel"
                    id="reporter_phone"
                    name="reporter_phone"
                    value="{{ old('reporter_phone') }}"
                    placeholder="Contoh: 081234567890"
                >
            </div>

            <div class="form-group">
                <label for="title">Judul / Ringkasan Kendala <span class="required">*</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Monitor tidak mau menyala / Printer macet"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Detail Kerusakan <span class="required">*</span></label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Jelaskan kronologi kendala atau pesan error yang muncul..."
                    required
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority">Tingkat Urgensi</label>
                <select id="priority" name="priority">
                    <option value="LOW" {{ old('priority') == 'LOW' ? 'selected' : '' }}>Rendah (Dapat menunggu)</option>
                    <option value="MEDIUM" {{ old('priority', 'MEDIUM') == 'MEDIUM' ? 'selected' : '' }}>Sedang (Standar)</option>
                    <option value="HIGH" {{ old('priority') == 'HIGH' ? 'selected' : '' }}>Tinggi (Mendesak untuk PBM/Kerja)</option>
                    <option value="EMERGENCY" {{ old('priority') == 'EMERGENCY' ? 'selected' : '' }}>Darurat (Sistem / Jaringan Utama Mati)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto Bukti Kendala <span style="font-size:11px; font-weight:normal; color:#64748b;">(Opsional, Maks 5MB)</span></label>
                <div class="file-upload-box" onclick="document.getElementById('photo-input').click()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="2" style="margin:0 auto;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <div class="file-upload-text">Ketuk untuk mengambil foto atau pilih dari galeri</div>
                    <div id="file-name" class="file-upload-name"></div>
                    <input type="file" id="photo-input" name="photo" accept="image/png, image/jpeg, image/jpg" onchange="previewFile(this)">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Kirim Pengaduan & Dapatkan Nomor Tiket
            </button>
        </form>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} IRGT School — IT Support System
    </div>
</div>

<script>
function previewFile(input) {
    const file = input.files[0];
    const nameLabel = document.getElementById('file-name');
    if (file) {
        nameLabel.innerText = 'File dipilih: ' + file.name;
        nameLabel.style.display = 'block';
    } else {
        nameLabel.style.display = 'none';
    }
}
</script>

</body>
</html>
