<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat & Log Aset: {{ $asset->asset_code }} — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }

        /* NAVBAR */
        .navbar { background: #0c1a2e; height: 68px; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: #fff; }
        .nav-logo { width: 38px; height: 38px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 12px rgba(3,105,161,0.4); }
        .nav-brand-text h2 { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; }
        .nav-brand-text span { font-size: 11px; color: #7dd3fc; }
        .nav-links { display: flex; align-items: center; gap: 4px; list-style: none; }
        .nav-links a { display: flex; align-items: center; gap: 6px; padding: 7px 13px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: #bae6fd; transition: all 0.15s; }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-links a.active { color: #fff; background: #0369a1; }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .user-pill { display: flex; align-items: center; gap: 9px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 30px; }
        .user-avatar { width: 28px; height: 28px; background: #0369a1; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .user-name { font-size: 12px; font-weight: 600; color: #f0f9ff; line-height: 1.2; }
        .btn-logout { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.25); padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.15s; }
        .btn-logout:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* CONTAINER */
        .container { max-width: 1020px; margin: 0 auto; padding: 32px 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .page-title h1 { font-size: 24px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 4px; }
        .page-title p { font-size: 13.5px; color: #64748b; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 9px; text-decoration: none; font-weight: 600; font-size: 13.5px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; transition: all 0.15s; }
        .btn-back:hover { background: #f8fafc; color: #0c1a2e; }

        /* ASSET BANNER */
        .asset-banner { background: linear-gradient(135deg, #0c1a2e, #0c4a6e); border-radius: 18px; padding: 24px 28px; color: #fff; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(12,26,46,0.15); }
        .banner-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 10px; }
        .banner-code { font-family: monospace; font-size: 17px; font-weight: 800; background: rgba(255,255,255,0.15); padding: 6px 14px; border-radius: 8px; color: #bae6fd; letter-spacing: 0.04em; }
        .banner-name { font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 16px; }

        .banner-meta-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 16px; }
        .meta-box { background: rgba(255,255,255,0.06); padding: 10px 14px; border-radius: 10px; }
        .meta-label { font-size: 10.5px; color: #7dd3fc; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; }
        .meta-val { font-size: 13px; font-weight: 700; color: #fff; }

        /* SUMMARY CARDS (CREATOR & SOLVER) */
        .summary-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 28px; }
        .summary-card { background: #fff; border-radius: 16px; padding: 20px 24px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 18px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; }
        .sum-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .sum-icon-creator { background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd; }
        .sum-icon-solver { background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; }
        .sum-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 2px; }
        .sum-user { font-size: 15px; font-weight: 800; color: #0c1a2e; }
        .sum-time { font-size: 12px; color: #64748b; margin-top: 2px; }

        /* TIMELINE CARD */
        .timeline-card { background: #fff; border-radius: 18px; padding: 32px; box-shadow: 0 4px 24px rgba(0,0,0,0.05); }
        .card-header-title { font-size: 16px; font-weight: 800; color: #0c1a2e; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; border-bottom: 1.5px solid #f0f9ff; padding-bottom: 12px; }

        .timeline { position: relative; padding-left: 32px; }
        .timeline::before { content: ''; position: absolute; left: 11px; top: 8px; bottom: 8px; width: 2px; background: #e0f2fe; }

        .timeline-item { position: relative; margin-bottom: 28px; }
        .timeline-item:last-child { margin-bottom: 0; }

        .tl-dot { position: absolute; left: -32px; top: 2px; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; border: 2px solid #fff; box-shadow: 0 0 0 2px #e0f2fe; }
        .dot-created { background: #0369a1; color: #fff; }
        .dot-repair { background: #16a34a; color: #fff; }
        .dot-damage { background: #dc2626; color: #fff; }
        .dot-status { background: #d97706; color: #fff; }
        .dot-update { background: #64748b; color: #fff; }

        .tl-content { background: #f8fafc; border: 1.5px solid #e0f2fe; border-radius: 14px; padding: 16px 20px; transition: all 0.15s; }
        .tl-content:hover { border-color: #0ea5e9; background: #fff; box-shadow: 0 4px 16px rgba(3,105,161,0.06); }

        .tl-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 8px; }
        .tl-action-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.04em; }
        .act-created { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .act-repair { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .act-damage { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .act-status { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .act-update { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        .tl-time { font-size: 12px; color: #64748b; font-weight: 600; }
        .tl-user-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #0c1a2e; }
        .tl-avatar { width: 22px; height: 22px; border-radius: 6px; background: #0369a1; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; }

        .tl-notes { font-size: 13.5px; color: #334155; line-height: 1.5; background: #fff; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; }

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
            .banner-card { padding: 20px 16px; }
            .summary-grid, .banner-meta-grid { grid-template-columns: 1fr; gap: 10px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .header-actions { width: 100%; }
            .header-actions a { flex: 1; justify-content: center; }
            .timeline-card { padding: 20px 14px; }
            .timeline { padding-left: 20px; }
            .tl-dot { left: -20px; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<!-- MAIN CONTAINER -->
<div class="container">
    <div class="page-header">
        <div class="page-title">
            <h1>Riwayat & Log Aktivitas Aset</h1>
            <p>Rekam jejak kronologis pembuat, perubahan status, serta catatan perbaikan teknisi.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('assets.edit', $asset->id) }}" class="btn-back" style="background:#0369a1; color:#fff; border-color:#0369a1;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Edit Aset
            </a>
            <a href="{{ route('assets.index') }}" class="btn-back">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- BANNER ASET -->
    <div class="asset-banner">
        <div class="banner-top">
            <div class="banner-code">{{ $asset->asset_code }}</div>
            <div>
                <span style="font-size:12px; background:rgba(255,255,255,0.15); padding:4px 10px; border-radius:12px; font-weight:700;">
                    STATUS: {{ $asset->status }} &nbsp;|&nbsp; KONDISI: {{ $asset->condition }}
                </span>
            </div>
        </div>
        <div class="banner-name">{{ $asset->name }}</div>
        <div class="banner-meta-grid">
            <div class="meta-box">
                <div class="meta-label">Penempatan</div>
                <div class="meta-val">{{ $asset->placement->name ?? '-' }}</div>
            </div>
            <div class="meta-box">
                <div class="meta-label">Lokasi</div>
                <div class="meta-val">{{ $asset->location->name ?? '-' }}</div>
            </div>
            <div class="meta-box">
                <div class="meta-label">Jenis & Barang</div>
                <div class="meta-val">{{ $asset->assetType->name ?? '-' }} / {{ $asset->assetItem->name ?? '-' }}</div>
            </div>
            <div class="meta-box">
                <div class="meta-label">Pengguna</div>
                <div class="meta-val">{{ $asset->assigned_to ?? 'Umum / Belum ada' }}</div>
            </div>
        </div>
    </div>

    <!-- SUMMARY CARDS: CREATOR & SOLVER -->
    <div class="summary-grid">
        <!-- CREATOR -->
        <div class="summary-card">
            <div class="sum-icon sum-icon-creator">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
            </div>
            <div>
                <div class="sum-label">Didaftarkan Pertama Kali Oleh:</div>
                <div class="sum-user">{{ $asset->creator->name ?? 'Petugas (Tidak Tercatat)' }}</div>
                <div class="sum-time">{{ $asset->created_at ? $asset->created_at->format('d M Y, H:i') : '-' }}</div>
            </div>
        </div>

        <!-- SOLVER -->
        <div class="summary-card">
            <div class="sum-icon sum-icon-solver">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            </div>
            <div>
                <div class="sum-label">Penyelesai Kerusakan Terakhir (Solver):</div>
                <div class="sum-user">
                    @if($asset->solver)
                        {{ $asset->solver->name }}
                    @else
                        <span style="color:#94a3b8; font-weight:600;">Belum pernah mengalami servis</span>
                    @endif
                </div>
                <div class="sum-time">
                    {{ $asset->last_solved_at ? $asset->last_solved_at->format('d M Y, H:i') : 'Kondisi awal' }}
                </div>
            </div>
        </div>
    </div>

    <!-- LINKED MAINTENANCE REPORTS (IF ANY) -->
    @if($asset->maintenanceReports && $asset->maintenanceReports->count() > 0)
    <div style="background:#fff; border-radius:18px; padding:24px 28px; box-shadow:0 4px 24px rgba(0,0,0,0.05); margin-bottom:24px; border:1.5px solid #e0f2fe;">
        <div style="font-size:15px; font-weight:800; color:#0c1a2e; margin-bottom:16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                Tiket & Laporan Maintenance Terkait ({{ $asset->maintenanceReports->count() }})
            </div>
            <a href="{{ route('reports.create', ['asset_id' => $asset->id]) }}" style="font-size:12.5px; font-weight:700; color:#0369a1; text-decoration:none;">
                + Buat Laporan untuk Aset Ini
            </a>
        </div>
        <div style="display:flex; flex-direction:column; gap:10px;">
            @foreach($asset->maintenanceReports as $rep)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:#f8fafc; border:1px solid #e0f2fe; border-radius:12px; flex-wrap:wrap; gap:10px;">
                <div>
                    <span style="font-family:monospace; font-weight:800; color:#0369a1; font-size:12px; background:#e0f2fe; padding:2px 8px; border-radius:6px;">{{ $rep->report_number }}</span>
                    <span style="font-weight:700; color:#0c1a2e; margin-left:6px;">{{ $rep->title }}</span>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
                        Pelapor: {{ $rep->reporter_name }} ({{ $rep->created_at->format('d M Y, H:i') }})
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="badge {{ $rep->status_badge_class }}">{{ $rep->status_label }}</span>
                    <a href="{{ route('reports.show', $rep->id) }}" style="font-size:12px; font-weight:700; color:#0369a1; text-decoration:none; background:#fff; border:1px solid #bae6fd; padding:5px 10px; border-radius:8px;">
                        Buka Tiket
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TIMELINE CARD -->
    <div class="timeline-card">
        <div class="card-header-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Kronologi Riwayat Perubahan & Tindakan Aset
        </div>

        @if($asset->histories->count() > 0)
        <div class="timeline">
            @foreach($asset->histories as $history)
            <div class="timeline-item">
                @php
                    $dotClass = match($history->action) {
                        'CREATED' => 'dot-created',
                        'REPAIR_SOLVED' => 'dot-repair',
                        'MAINTENANCE_REPORTED' => 'dot-damage',
                        'STATUS_CHANGED' => 'dot-status',
                        default => 'dot-update',
                    };
                    $actClass = match($history->action) {
                        'CREATED' => 'act-created',
                        'REPAIR_SOLVED' => 'act-repair',
                        'MAINTENANCE_REPORTED' => 'act-damage',
                        'STATUS_CHANGED' => 'act-status',
                        default => 'act-update',
                    };
                    $actTitle = match($history->action) {
                        'CREATED' => 'Didaftarkan',
                        'REPAIR_SOLVED' => 'Servis / Perbaikan Selesai',
                        'MAINTENANCE_REPORTED' => 'Kerusakan / Maintenance',
                        'STATUS_CHANGED' => 'Perubahan Status',
                        default => 'Pembaruan Data',
                    };
                @endphp
                <div class="tl-dot {{ $dotClass }}">
                    @if($history->action === 'CREATED') ＋
                    @elseif($history->action === 'REPAIR_SOLVED') ✓
                    @elseif($history->action === 'MAINTENANCE_REPORTED') !
                    @else •
                    @endif
                </div>
                <div class="tl-content">
                    <div class="tl-header">
                        <span class="tl-action-badge {{ $actClass }}">{{ $actTitle }}</span>
                        <span class="tl-time">{{ $history->created_at->format('d M Y, H:i') }} ({{ $history->created_at->diffForHumans() }})</span>
                    </div>

                    <div class="tl-user-row">
                        <div class="tl-avatar">{{ strtoupper(substr($history->user->name ?? 'P', 0, 1)) }}</div>
                        <div>Oleh: {{ $history->user->name ?? 'Petugas' }} <span style="font-size:11px; color:#64748b; font-weight:500;">({{ $history->user->role ?? 'admin' }})</span></div>
                    </div>

                    <div class="tl-notes">
                        {{ $history->notes ?? 'Tidak ada catatan tambahan.' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center; padding:32px 10px; color:#64748b;">
            <p>Belum ada riwayat aktivitas yang tercatat untuk aset ini.</p>
        </div>
        @endif
    </div>
</div>

</body>
</html>
