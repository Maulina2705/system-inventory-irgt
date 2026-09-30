<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $asset->name }} — Inventaris IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* MINI NAV */
        .topbar { background: #0c1a2e; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-logo { width: 32px; height: 32px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0; }
        .topbar-text { font-size: 13.5px; font-weight: 800; color: #fff; line-height: 1.2; }
        .topbar-text span { font-size: 10px; font-weight: 500; color: #7dd3fc; display: block; }
        .topbar-badge { background: #0369a1; color: #bae6fd; font-size: 10px; font-weight: 700; padding: 4px 9px; border-radius: 20px; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 4px; }

        /* HERO */
        .hero { background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 60%, #075985 100%); padding: 32px 16px 56px; text-align: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -60px; right: -60px; width: 200px; height: 200px; background: rgba(255,255,255,0.06); border-radius: 50%; }
        .hero::after { content: ''; position: absolute; bottom: -70px; left: -40px; width: 240px; height: 240px; background: rgba(255,255,255,0.04); border-radius: 50%; }
        
        .hero-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-bottom: 12px; position: relative; z-index: 1; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-active-hero { background: rgba(22,163,74,0.25); color: #4ade80; border: 1px solid rgba(74,222,128,0.3); }
        .badge-maintenance-hero { background: rgba(202,138,4,0.25); color: #facc15; border: 1px solid rgba(250,204,21,0.3); }
        .badge-damaged-hero { background: rgba(220,38,38,0.25); color: #f87171; border: 1px solid rgba(248,113,113,0.3); }
        .badge-lost-hero { background: rgba(217,70,239,0.2); color: #f0abfc; border: 1px solid rgba(240,171,252,0.3); }
        .badge-retired-hero { background: rgba(148,163,184,0.2); color: #cbd5e1; border: 1px solid rgba(203,213,225,0.3); }
        
        .hero-code { font-family: monospace; font-size: 16px; font-weight: 800; color: #fff; background: rgba(255,255,255,0.18); padding: 6px 14px; border-radius: 8px; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em; position: relative; z-index: 1; word-break: break-all; }
        .hero-name { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 6px; position: relative; z-index: 1; line-height: 1.3; padding: 0 8px; }
        .hero-year { font-size: 12px; color: #bae6fd; position: relative; z-index: 1; font-weight: 500; }

        /* CARD */
        .content { padding: 0 12px 32px; max-width: 520px; margin: 0 auto; }
        .detail-card { background: #fff; border-radius: 18px; padding: 22px 18px; box-shadow: 0 10px 32px rgba(3,105,161,0.1); margin-top: -28px; position: relative; z-index: 2; border: 1px solid #e0f2fe; }
        .card-title { font-size: 14px; font-weight: 800; color: #0c1a2e; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .card-title::before { content: ''; display: block; width: 4px; height: 16px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 2px; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
        .info-item { background: #f8fafc; border: 1px solid #e0f2fe; border-radius: 10px; padding: 10px 12px; }
        .info-item.full { grid-column: 1 / -1; }
        .info-label { font-size: 10px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px; display: flex; align-items: center; gap: 4px; }
        .info-value { font-size: 13px; font-weight: 700; color: #0c1a2e; word-break: break-word; }

        .divider { border: none; border-top: 1px dashed #e0f2fe; margin: 16px 0; }

        .badge-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; }
        .badge-active { background: #dcfce7; color: #15803d; }
        .badge-maintenance { background: #fef9c3; color: #a16207; }
        .badge-damaged { background: #fee2e2; color: #b91c1c; }
        .badge-lost { background: #fce7f3; color: #be185d; }
        .badge-retired { background: #f1f5f9; color: #475569; }
        .badge-good { background: #dcfce7; color: #15803d; }
        .badge-fair { background: #fef9c3; color: #a16207; }
        .badge-poor, .badge-damaged-c { background: #fee2e2; color: #b91c1c; }

        .note-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 10px 12px; display: flex; gap: 8px; align-items: flex-start; }
        .note-box svg { color: #0369a1; flex-shrink: 0; margin-top: 2px; }
        .note-text { font-size: 11.5px; color: #475569; line-height: 1.5; }

        /* CTA */
        .cta-section { margin-top: 14px; display: flex; flex-direction: column; align-items: center; gap: 10px; width: 100%; }
        .btn-report { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13.5px; background: linear-gradient(135deg, #d97706, #b45309); color: #fff; box-shadow: 0 4px 14px rgba(180,83,9,0.25); transition: all 0.15s; width: 100%; }
        .btn-report:active { transform: scale(0.98); }
        .btn-portal { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13.5px; background: #fff; color: #0369a1; border: 1.5px solid #bae6fd; box-shadow: 0 2px 8px rgba(3,105,161,0.06); transition: all 0.15s; width: 100%; }
        .btn-portal:active { background: #e0f2fe; }

        /* FOOTER */
        .footer { text-align: center; padding: 20px 16px; font-size: 11px; color: #94a3b8; line-height: 1.5; }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <a href="{{ route('public.assets.index') }}" class="topbar-brand">
        <div class="topbar-logo" style="background: transparent; overflow: hidden; padding: 0;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo IRGT" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div class="topbar-text">
            IRGT INVENTORY
            <span>IRGT School IT System</span>
        </div>
    </a>
    <span class="topbar-badge">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        SCAN QR
    </span>
</div>

<!-- HERO -->
<div class="hero">
    @php
        $heroClass = match(strtoupper($asset->status ?? '')) {
            'ACTIVE' => 'badge-active-hero',
            'MAINTENANCE' => 'badge-maintenance-hero',
            'DAMAGED' => 'badge-damaged-hero',
            'LOST' => 'badge-lost-hero',
            'RETIRED' => 'badge-retired-hero',
            default => 'badge-retired-hero',
        };
    @endphp
    <div class="hero-badge {{ $heroClass }}">{{ $asset->status }}</div>
    <div class="hero-code">{{ $asset->asset_code }}</div>
    <div class="hero-name">{{ $asset->name }}</div>
    <div class="hero-year">Inventaris Tahun {{ $asset->inventory_year }}</div>
</div>

<!-- DETAIL CARD -->
<div class="content">
    <div class="detail-card">
        <div class="card-title">Informasi Aset</div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                    Penempatan
                </div>
                <div class="info-value">{{ $asset->placement->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Lokasi
                </div>
                <div class="info-value">{{ $asset->location->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    Jenis Barang
                </div>
                <div class="info-value">{{ $asset->assetType->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    Tipe Barang
                </div>
                <div class="info-value">{{ $asset->assetItem->name ?? '-' }}</div>
            </div>
            @if($asset->brand)
            <div class="info-item">
                <div class="info-label">Merk / Brand</div>
                <div class="info-value">{{ $asset->brand }}</div>
            </div>
            @endif
            @if($asset->assigned_to)
            <div class="info-item">
                <div class="info-label">Pengguna</div>
                <div class="info-value">{{ $asset->assigned_to }}</div>
            </div>
            @endif
        </div>

        <hr class="divider">

        <div class="card-title" style="margin-bottom:12px;">Status & Kondisi</div>
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
            <span class="badge {{ $statClass }}">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle></svg>
                Status: {{ $asset->status }}
            </span>
            <span class="badge {{ $condClass }}">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Kondisi: {{ $asset->condition }}
            </span>
        </div>

        @if(isset($groupAssets) && $groupAssets->count() > 1)
        <hr class="divider">
        <div style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 1.5px solid #bae6fd; border-radius: 14px; padding: 14px; margin-bottom: 16px;">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                <strong style="font-size:13.5px; color:#0369a1;">
                    Bundel Terpadu: {{ $asset->group_name ?? $asset->group_code }}
                </strong>
            </div>
            <div style="font-size:11.5px; color:#475569; line-height:1.4; margin-bottom:12px;">
                QR Code ini mewakili seluruh perangkat di meja / bundel ini. Pilih perangkat spesifik di bawah yang mengalami gangguan:
            </div>
            
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach($groupAssets as $gAsset)
                <div style="display:flex; align-items:center; justify-content:space-between; background:#fff; border:1.5px solid {{ $gAsset->id === $asset->id ? '#0284c7' : '#e2e8f0' }}; padding:10px 12px; border-radius:10px; gap:8px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span style="font-family:'JetBrains Mono', monospace; font-size:10.5px; font-weight:800; color:#0369a1; background:#e0f2fe; padding:2px 6px; border-radius:4px;">
                                {{ $gAsset->assetItem->code ?? 'DEV' }}
                            </span>
                            <strong style="font-size:13px; color:#0c1a2e; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $gAsset->name }}
                            </strong>
                            @if($gAsset->is_group_primary)
                                <span style="font-size:9.5px; font-weight:800; background:#fef08a; color:#854d0e; padding:1px 5px; border-radius:4px;">QR Utama</span>
                            @endif
                        </div>
                        <div style="font-size:11px; color:#64748b; margin-top:3px;">
                            <span style="font-family:'JetBrains Mono', monospace;">{{ $gAsset->asset_code }}</span>
                            @if($gAsset->brand) • {{ $gAsset->brand }} @endif
                            • Kondisi: <strong style="color:{{ $gAsset->condition === 'GOOD' ? '#15803d' : '#b91c1c' }}">{{ $gAsset->condition }}</strong>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('public.reports.create', ['token' => $asset->qr_token, 'asset_id' => $gAsset->id]) }}" style="padding:7px 12px; font-size:11.5px; font-weight:800; background:linear-gradient(135deg, #d97706, #b45309); color:#fff; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:4px; white-space:nowrap; box-shadow:0 2px 6px rgba(217,119,6,0.25);">
                            Lapor Kendala
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="note-box">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <div class="note-text">
                Halaman ini tersedia untuk publik. Informasi sensitif (serial number, IP, MAC address) tidak ditampilkan di sini.
            </div>
        </div>
    </div>

    <div class="cta-section">
        <!-- 1. LAPOR KERUSAKAN -->
        <a href="{{ route('public.reports.create', $asset->qr_token) }}" class="btn-report">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            <span>Laporkan Kerusakan / Masalah</span>
        </a>

        <!-- 2. AJUKAN PEMINJAMAN -->
        @if($asset->status === 'BORROWED')
            <div style="width: 100%; background: #fef3c7; border: 1.5px solid #fde68a; border-radius: 12px; padding: 12px 14px; text-align: center; color: #92400e; font-size: 13px; font-weight: 700;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 2px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span>Unit Sedang Dipinjam</span>
                </div>
                <div style="font-size: 11.5px; font-weight: 500; color: #b45309;">
                    Aset tidak dapat dipinjam saat ini sampai unit dikembalikan ke Tim IT.
                </div>
            </div>
        @else
            <a href="{{ route('public.borrowings.create', $asset->qr_token) }}" class="btn-portal" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; border: none; box-shadow: 0 4px 14px rgba(2, 132, 199, 0.3);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                <span>Ajukan Peminjaman Unit Ini</span>
            </a>
        @endif

        <div style="display: flex; gap: 8px; width: 100%;">
            <a href="{{ route('public.reports.track') }}" class="btn-portal" style="flex: 1; padding: 10px 12px; font-size: 12px; background: #fff;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Lacak Tiket</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-portal" style="flex: 1; padding: 10px 12px; font-size: 12px; background: #0c1a2e; color: #bae6fd; border-color: #0c1a2e;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Dashboard</span>
                </a>
            @else
                <a href="{{ route('public.assets.index') }}" class="btn-portal" style="flex: 1; padding: 10px 12px; font-size: 12px; background: #fff;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span>Katalog Aset</span>
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    &copy; {{ date('Y') }} IRGT School — Sistem Inventaris Aset IT<br>
    <a href="{{ route('public.assets.index') }}" style="color:#7dd3fc; text-decoration:none;">{{ config('app.url') }}</a>
</div>

</body>
</html>
