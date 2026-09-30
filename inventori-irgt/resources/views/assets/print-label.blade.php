<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label - {{ $asset->asset_code }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; }

        .no-print { display: flex; gap: 10px; margin-bottom: 24px; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 9px; text-decoration: none; font-weight: 600; font-size: 13.5px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; transition: all 0.15s; }
        .btn-back:hover { background: #f8fafc; color: #0c1a2e; }
        .btn-print-go { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 9px; font-weight: 700; font-size: 13.5px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.35); transition: all 0.15s; }
        .btn-print-go:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }
        .btn-download-png { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 9px; font-weight: 700; font-size: 13.5px; background: #e0f2fe; color: #0369a1; border: 1.5px solid #7dd3fc; cursor: pointer; font-family: inherit; transition: all 0.15s; }
        .btn-download-png:hover { background: #0369a1; color: #fff; border-color: #0369a1; transform: translateY(-1px); }

        .label-card {
            background: #fff;
            border: 2.5px solid #0369a1;
            border-radius: 20px;
            padding: 28px 28px 24px;
            max-width: 360px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(3,105,161,0.12);
            text-align: center;
        }

        .label-header { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1.5px dashed #e0f2fe; }
        .label-logo { width: 34px; height: 34px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; }
        .label-school { font-size: 13px; font-weight: 800; color: #0c1a2e; letter-spacing: 0.03em; }
        .label-school span { display: block; font-size: 10px; font-weight: 500; color: #64748b; }

        .qr-wrap { background: #f0f9ff; border: 1.5px solid #e0f2fe; border-radius: 14px; padding: 14px; margin-bottom: 18px; display: inline-block; }
        .qr-wrap img { display: block; border-radius: 8px; }

        .asset-code-big { font-family: 'Courier New', monospace; font-size: 16px; font-weight: 800; color: #0369a1; background: #e0f2fe; padding: 7px 14px; border-radius: 8px; margin-bottom: 8px; word-break: break-all; display: inline-block; letter-spacing: 0.03em; }
        .asset-name-big { font-size: 15px; font-weight: 700; color: #0c1a2e; margin-bottom: 18px; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; text-align: left; margin-bottom: 16px; }
        .info-item { background: #f0f9ff; border: 1px solid #e0f2fe; border-radius: 9px; padding: 9px 12px; }
        .info-label { font-size: 10px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px; }
        .info-value { font-size: 12.5px; font-weight: 600; color: #0c1a2e; }

        .badge-row { display: flex; justify-content: center; gap: 8px; margin-bottom: 18px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; }
        .badge-active { background: #dcfce7; color: #15803d; }
        .badge-maintenance { background: #fef9c3; color: #a16207; }
        .badge-damaged { background: #fee2e2; color: #b91c1c; }
        .badge-lost { background: #fce7f3; color: #be185d; }
        .badge-retired { background: #f1f5f9; color: #475569; }
        .badge-good { background: #dcfce7; color: #15803d; }
        .badge-fair { background: #fef9c3; color: #a16207; }
        .badge-poor, .badge-damaged-c { background: #fee2e2; color: #b91c1c; }

        .label-footer { padding-top: 14px; border-top: 1.5px dashed #e0f2fe; font-size: 10.5px; color: #94a3b8; }
        .label-footer strong { color: #0369a1; }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .label-card { border: 2px solid #0369a1; box-shadow: none; margin: 0 auto; }
            @page { margin: 10mm; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('assets.index') }}" class="btn-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
    </a>
    <button class="btn-print-go" onclick="window.print()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        Cetak Label
    </button>
    <button class="btn-download-png" onclick="downloadLabelQrPng()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        Download PNG
    </button>
</div>

<div class="label-card">

    <div class="label-header">
        <div class="label-logo" style="background: transparent; width: 36px; height: 36px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo IRGT" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div class="label-school">
            IRGT SCHOOL
            <span>Sistem Inventaris Aset</span>
        </div>
    </div>

    <div class="qr-wrap">
        <img
            id="label-qr-img"
            src="{{ route('assets.qr', $asset->id) }}"
            alt="QR Code {{ $asset->asset_code }}"
            width="200"
            height="200"
        >
    </div>

    <div class="asset-code-big">{{ $asset->asset_code }}</div>
    <div class="asset-name-big">{{ $asset->name }}</div>

    @if(isset($groupMembers) && $groupMembers->count() > 1)
    <div style="background:#f0f9ff; border:1.5px solid #bae6fd; border-radius:10px; padding:10px 12px; margin-bottom:16px; text-align:left;">
        <div style="font-size:10.5px; font-weight:800; color:#0369a1; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">
            Bundel Perangkat Meja / Grup ({{ $asset->group_code }})
        </div>
        <div style="font-size:11.5px; color:#334155; line-height:1.5;">
            @foreach($groupMembers as $gm)
                • <strong>[{{ $gm->assetItem->code ?? 'DEV' }}]</strong> {{ $gm->name }} ({{ $gm->asset_code }})<br>
            @endforeach
        </div>
    </div>
    @endif

    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Penempatan</div>
            <div class="info-value">{{ $asset->placement->name ?? '-' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Lokasi</div>
            <div class="info-value">{{ $asset->location->name ?? '-' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Jenis</div>
            <div class="info-value">{{ $asset->assetType->name ?? '-' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Tipe Barang</div>
            <div class="info-value">{{ $asset->assetItem->name ?? '-' }}</div>
        </div>
        @if($asset->brand)
        <div class="info-item">
            <div class="info-label">Merk</div>
            <div class="info-value">{{ $asset->brand }}</div>
        </div>
        @endif
        <div class="info-item">
            <div class="info-label">Tahun</div>
            <div class="info-value">{{ $asset->inventory_year }}</div>
        </div>
    </div>

    <div class="badge-row">
        @php
            $statClass = match(strtoupper($asset->status ?? '')) {
                'ACTIVE' => 'badge-active',
                'MAINTENANCE' => 'badge-maintenance',
                'DAMAGED' => 'badge-damaged',
                'LOST' => 'badge-lost',
                'RETIRED' => 'badge-retired',
                default => 'badge-retired',
            };
            $condClass = match(strtoupper($asset->condition ?? '')) {
                'GOOD' => 'badge-good',
                'FAIR' => 'badge-fair',
                'POOR' => 'badge-poor',
                'DAMAGED' => 'badge-damaged-c',
                default => 'badge-retired',
            };
        @endphp
        <span class="badge {{ $statClass }}">{{ $asset->status }}</span>
        <span class="badge {{ $condClass }}">{{ $asset->condition }}</span>
    </div>

    <div class="label-footer">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        Scan QR untuk info lengkap aset ini<br>
        <strong>{{ config('app.url') }}</strong>
    </div>

</div>

<script>
function downloadLabelQrPng() {
    const qrImg = document.getElementById('label-qr-img');
    if (!qrImg || !qrImg.src) return;

    const img = new Image();
    img.crossOrigin = 'Anonymous';
    img.onload = function() {
        const canvas = document.createElement('canvas');
        const size = 1000;
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');

        // White background with clean padding
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, size, size);

        // Draw QR
        const padding = 60;
        ctx.drawImage(img, padding, padding, size - (padding * 2), size - (padding * 2));

        // Trigger Download
        const link = document.createElement('a');
        link.download = 'QR_{{ $asset->asset_code }}.png';
        link.href = canvas.toDataURL('image/png');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
    img.src = qrImg.src;
}
</script>

</body>
</html>
