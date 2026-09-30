<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label QR Code ({{ count($assets) }} Label) — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; color: #0c1a2e; padding: 20px; }

        .toolbar { max-width: 820px; margin: 0 auto 16px auto; display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 12px 18px; border-radius: 10px; border: 1px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .toolbar-info h3 { font-size: 13pt; font-weight: 800; color: #0369a1; }
        .toolbar-info p { font-size: 9.5pt; color: #64748b; margin-top: 1px; }
        .btn-group { display: flex; gap: 8px; }
        .btn-action { padding: 8px 16px; border-radius: 6px; font-size: 9.5pt; font-weight: 700; cursor: pointer; border: none; font-family: inherit; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; transition: all 0.15s; }
        .btn-print { background: #0369a1; color: #fff; }
        .btn-print:hover { background: #075985; }
        .btn-back { background: #fff; color: #475569; border: 1px solid #cbd5e1; }
        .btn-back:hover { background: #f8fafc; }

        /* A4 SHEET CONTAINER */
        .page-sheet { max-width: 820px; margin: 0 auto; background: #fff; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.03); }

        /* STICKER GRID: 2 Kolom per baris */
        .label-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }

        /* INDIVIDUAL STICKER CARD */
        .label-card {
            background: #fff;
            border: 2px solid #0369a1;
            border-radius: 10px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            page-break-inside: avoid;
            position: relative;
        }

        .qr-box {
            width: 86px;
            height: 86px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 2px;
            border-radius: 6px;
            border: 1px solid #e0f2fe;
        }
        .qr-box svg { width: 100%; height: 100%; display: block; }

        .label-info { flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center; }
        .label-school { font-size: 8pt; font-weight: 800; color: #0369a1; text-transform: uppercase; letter-spacing: 0.08em; border-bottom: 1px solid #e0f2fe; padding-bottom: 2px; margin-bottom: 6px; }
        .label-code { font-family: 'JetBrains Mono', monospace; font-size: 10.5pt; font-weight: 800; color: #0369a1; background: #e0f2fe; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-bottom: 5px; border: 1px solid #bae6fd; width: fit-content; }
        .label-name { font-size: 11pt; font-weight: 800; color: #0c1a2e; line-height: 1.25; }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none !important; }
            .page-sheet { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            .label-grid { gap: 10px; }
            .label-card {
                box-shadow: none;
                border: 1.5px solid #0369a1;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page { size: A4 portrait; margin: 1cm; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div class="toolbar-info">
            <h3>Cetak Massal Label QR Code</h3>
            <p>{{ count($assets) }} label siap dicetak ke kertas stiker A4.</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('assets.index') }}" class="btn-action btn-back">Kembali</a>
            <button onclick="window.print()" class="btn-action btn-print">Cetak Semua Label</button>
        </div>
    </div>

    <div class="page-sheet">
        <div class="label-grid">
            @foreach($assets as $asset)
                <div class="label-card">
                    <div class="qr-box">
                        {!! $asset->qr_svg !!}
                    </div>
                    <div class="label-info">
                        <div class="label-school" style="display: flex; align-items: center; gap: 5px;">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo IRGT" style="width: 14px; height: 14px; object-fit: contain;">
                            <span>IRGT SCHOOL</span>
                        </div>
                        <div class="label-code">{{ $asset->asset_code }}</div>
                        <div class="label-name" title="{{ $asset->name }}">{{ $asset->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
