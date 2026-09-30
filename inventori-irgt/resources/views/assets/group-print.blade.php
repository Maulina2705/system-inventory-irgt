<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Meja Workstation — {{ $groupCode }} ({{ $groupName }})</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px 16px; color: #1e293b; }

        .no-print { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; justify-content: center; }
        .btn-action { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 700; text-decoration: none; font-family: inherit; cursor: pointer; transition: all 0.15s; }
        .btn-back { background: #fff; color: #475569; border: 1.5px solid #cbd5e1; }
        .btn-back:hover { background: #f8fafc; color: #0c1a2e; }
        .btn-print { background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; box-shadow: 0 4px 14px rgba(3,105,161,0.35); }
        .btn-print:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        /* KARTU MEJA WORKSTATION */
        .ws-card {
            background: #fff;
            border: 2.5px solid #0369a1;
            border-radius: 20px;
            padding: 24px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 12px 36px rgba(3,105,161,0.14);
            position: relative;
            overflow: hidden;
        }

        .ws-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #0ea5e9, #0369a1, #0284c7);
        }

        /* HEADER */
        .ws-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px dashed #bae6fd; padding-bottom: 14px; margin-bottom: 16px; }
        .ws-brand { display: flex; align-items: center; gap: 10px; }
        .ws-logo { width: 36px; height: 36px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; }
        .ws-brand-title { font-size: 13.5px; font-weight: 800; color: #0c1a2e; line-height: 1.2; }
        .ws-brand-sub { font-size: 10px; color: #0284c7; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

        /* TITLE WORKSTATION */
        .ws-title-box { background: #f0f9ff; border: 1.5px solid #bae6fd; border-radius: 12px; padding: 12px 14px; text-align: center; margin-bottom: 16px; }
        .ws-code { font-family: 'JetBrains Mono', monospace; font-size: 18px; font-weight: 800; color: #0369a1; letter-spacing: 0.04em; }
        .ws-name { font-size: 14px; font-weight: 700; color: #0c1a2e; margin-top: 2px; }
        .ws-meta { font-size: 11px; color: #64748b; margin-top: 4px; display: flex; justify-content: center; gap: 8px; }

        /* QR SECTION */
        .ws-qr-section { display: flex; align-items: center; gap: 14px; background: #fafafa; border: 1px solid #e2e8f0; border-radius: 14px; padding: 12px; margin-bottom: 16px; }
        .ws-qr-img-wrap { width: 105px; height: 105px; flex-shrink: 0; background: #fff; border: 1.5px solid #bae6fd; border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 4px; }
        .ws-qr-img-wrap svg { width: 100%; height: 100%; display: block; }
        .ws-qr-text h4 { font-size: 12.5px; font-weight: 800; color: #0c1a2e; margin-bottom: 3px; }
        .ws-qr-text p { font-size: 11px; color: #64748b; line-height: 1.35; margin-bottom: 6px; }
        .ws-qr-badge { display: inline-block; font-size: 10px; font-weight: 800; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 6px; font-family: 'JetBrains Mono', monospace; }

        /* DEVICE UNITS LIST */
        .ws-units-title { font-size: 11.5px; font-weight: 800; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; }
        .ws-units-count { background: #e0f2fe; color: #0369a1; font-size: 10.5px; padding: 1px 7px; border-radius: 10px; }
        .ws-units-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; font-size: 11.5px; }
        .ws-units-table th { background: #f0f9ff; color: #0369a1; font-weight: 700; text-align: left; padding: 6px 8px; border-top: 1px solid #bae6fd; border-bottom: 1px solid #bae6fd; font-size: 10.5px; }
        .ws-units-table td { padding: 7px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .ws-units-table tr:last-child td { border-bottom: none; }
        
        .unit-type-badge { font-weight: 800; font-size: 9.5px; padding: 2px 6px; border-radius: 4px; background: #e2e8f0; color: #334155; font-family: 'JetBrains Mono', monospace; }
        .unit-primary { background: #fef08a; color: #854d0e; }
        .unit-status-dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 4px; }
        .dot-active { background: #22c55e; }
        .dot-maint { background: #eab308; }
        .dot-damaged { background: #ef4444; }

        /* FOOTER */
        .ws-footer { border-top: 1.5px dashed #e2e8f0; padding-top: 10px; font-size: 10px; color: #94a3b8; text-align: center; line-height: 1.4; }
        .ws-footer strong { color: #0369a1; }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .ws-card { border: 2px solid #0369a1; box-shadow: none; margin: 0 auto; page-break-inside: avoid; }
            @page { margin: 8mm; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('assets.index', ['group_code' => $groupCode]) }}" class="btn-action btn-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke Daftar Aset
    </a>
    <button class="btn-action btn-print" onclick="window.print()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        Cetak Label Meja (Print)
    </button>
</div>

<!-- KARTU MEJA WORKSTATION STIKER -->
<div class="ws-card" id="printableCard">

    <!-- HEADER KARTU -->
    <div class="ws-header">
        <div class="ws-brand">
            <div class="ws-logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
            <div>
                <div class="ws-brand-title">IRGT SCHOOL IT LAB</div>
                <div class="ws-brand-sub">Workstation Asset Label</div>
            </div>
        </div>
        <div style="text-align: right;">
            <span style="font-size: 10px; font-weight: 800; background: #0369a1; color: #fff; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                {{ $primaryAsset->location->name ?? 'Laboratorium' }}
            </span>
        </div>
    </div>

    <!-- NAMA & KODE WORKSTATION -->
    <div class="ws-title-box">
        <div class="ws-code">{{ $groupCode }}</div>
        <div class="ws-name">{{ $groupName }}</div>
        <div class="ws-meta">
            <span><strong>Penempatan:</strong> {{ $primaryAsset->placement->name ?? '-' }}</span>
            <span>•</span>
            <span><strong>Ruangan:</strong> {{ $primaryAsset->location->name ?? '-' }}</span>
        </div>
    </div>

    <!-- QR CODE SECTION -->
    <div class="ws-qr-section">
        <div class="ws-qr-img-wrap" id="qrContainer">
            {!! $qrSvg !!}
        </div>
        <div class="ws-qr-text">
            <h4>Pindai QR Meja Ini</h4>
            <p>Scan untuk melihat rincian spesifikasi unit atau melaporkan gangguan pada meja ini.</p>
            <span class="ws-qr-badge">{{ $primaryAsset->asset_code }}</span>
        </div>
    </div>

    <!-- DAFTAR UNIT TERPASANG -->
    <div class="ws-units-title">
        <span>Daftar Perangkat Terpasang</span>
        <span class="ws-units-count">{{ $assets->count() }} Unit</span>
    </div>

    <table class="ws-units-table">
        <thead>
            <tr>
                <th style="width: 55px;">Item</th>
                <th>Perangkat & Spesifikasi</th>
                <th style="width: 70px; text-align: right;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $item)
            <tr>
                <td>
                    <span class="unit-type-badge {{ $item->is_group_primary ? 'unit-primary' : '' }}">
                        {{ $item->assetItem->code ?? 'DEV' }}
                    </span>
                </td>
                <td>
                    <div style="font-weight: 700; color: #0c1a2e; line-height: 1.2;">{{ $item->name }}</div>
                    <div style="font-size: 10px; color: #64748b; margin-top: 1px;">
                        <span style="font-family: 'JetBrains Mono', monospace; color: #0369a1;">{{ $item->asset_code }}</span>
                        @if($item->brand) • {{ $item->brand }} @endif
                        @if($item->serial_number) • SN: {{ $item->serial_number }} @endif
                    </div>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                    @php
                        $dotClass = match($item->status) {
                            'ACTIVE' => 'dot-active',
                            'MAINTENANCE' => 'dot-maint',
                            default => 'dot-damaged'
                        };
                    @endphp
                    <span class="unit-status-dot {{ $dotClass }}"></span>
                    <span style="font-size: 10.5px; font-weight: 700; color: #334155;">{{ $item->condition }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER STIKER -->
    <div class="ws-footer">
        Dilarang memindahkan komponen perangkat tanpa izin pengelola Lab IT IRGT.<br>
        <strong>IRGT School — IT Asset Management & Maintenance</strong>
    </div>

</div>

</body>
</html>
