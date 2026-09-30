<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laporan Maintenance & Servis — IRGT School</title>
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
        .container { max-width: 1400px; margin: 0 auto; padding: 24px 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 14px; flex-wrap: wrap; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 3px; }
        .page-title p { font-size: 13px; color: #64748b; }
        .btn-add { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 18px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; box-shadow: 0 4px 14px rgba(3,105,161,0.3); transition: all 0.15s; white-space: nowrap; }
        .btn-add:hover { background: linear-gradient(135deg, #0369a1, #075985); }

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
        .filter-input { flex: 2; min-width: 200px; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; background: #f8fafc; outline: none; }
        .filter-input:focus { border-color: #0369a1; background: #fff; }
        .filter-select { flex: 1; min-width: 130px; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; background: #f8fafc; outline: none; }
        .btn-filter { padding: 9px 16px; background: #0369a1; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; font-family: inherit; }
        .btn-reset { padding: 9px 12px; background: #f1f5f9; color: #64748b; text-decoration: none; border-radius: 8px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; }

        /* TABLE */
        .card { background: #fff; border-radius: 14px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e0f2fe; }
        .card-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 860px; }
        th { background: #f0f9ff; text-align: left; padding: 12px 14px; border-bottom: 2px solid #e0f2fe; font-size: 11.5px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 12px 14px; border-bottom: 1px solid #f0f9ff; font-size: 13px; color: #334155; vertical-align: middle; }
        tr:hover td { background: #f8fafc; }

        .report-code { font-family: monospace; font-weight: 800; color: #0369a1; background: #e0f2fe; padding: 3px 7px; border-radius: 5px; font-size: 11.5px; white-space: nowrap; }
        .asset-title { font-weight: 700; color: #0c1a2e; font-size: 13px; }
        .asset-code-sub { font-size: 11px; color: #64748b; font-family: monospace; }

        /* BADGES */
        .badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .badge-in-progress { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-resolved { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        .badge-pri-low { background: #f1f5f9; color: #475569; }
        .badge-pri-medium { background: #e0f2fe; color: #0369a1; }
        .badge-pri-high { background: #ffedd5; color: #c2410c; }
        .badge-pri-emergency { background: #fee2e2; color: #b91c1c; font-weight: 800; }

        .btn-act { display: inline-flex; align-items: center; justify-content: center; gap: 4px; padding: 5px 11px; border-radius: 7px; font-size: 12px; font-weight: 700; text-decoration: none; cursor: pointer; border: none; transition: all 0.15s; white-space: nowrap; }
        .btn-act-view { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .btn-act-view:hover { background: #0369a1; color: #fff; }
        .btn-act-del { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; margin-left: 4px; padding: 5px 8px; }
        .btn-act-del:hover { background: #dc2626; color: #fff; }

        .pagination-wrap { padding: 0; }
        .empty { text-align: center; padding: 48px 16px; }

        /* RESPONSIVE MOBILE OPTIMIZATION */
        @media (max-width: 900px) {
            body { padding-bottom: calc(76px + env(safe-area-inset-bottom)); }
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
            .nav-links { order: 3; width: 100%; overflow-x: auto; white-space: nowrap; padding-bottom: 2px; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
            .nav-links::-webkit-scrollbar { display: none; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .container { padding: 16px 12px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .btn-add { width: 100%; }
            .filter-input { width: 100%; min-width: 100%; }
            .filter-select { flex: 1 1 45%; }
            .btn-filter, .btn-reset { flex: 1 1 auto; justify-content: center; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<!-- MAIN CONTENT -->
<div class="container">
    <div class="page-header">
        <div class="page-title">
            <h1>{{ $isStaff ? 'Pusat Laporan Maintenance & Servis' : 'Pengajuan & Laporan Servis Saya' }}</h1>
            <p>{{ $isStaff ? 'Pantau dan kelola antrean tiket perbaikan perangkat sekolah dari pengguna secara terstruktur.' : 'Laporkan kendala perangkat hardware/IT dan pantau proses pengerjaan teknisi secara real-time.' }}</p>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            @if($isStaff)
            <a href="{{ route('reports.export.csv', request()->query()) }}" class="btn-add" style="background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd; box-shadow: none;" title="Unduh data dalam format Excel (CSV)">
                Unduh Excel (CSV)
            </a>
            <a href="{{ route('reports.print-recap', request()->query()) }}" target="_blank" class="btn-add" style="background: #fff; color: #475569; border: 1.5px solid #cbd5e1; box-shadow: none;" title="Cetak atau simpan format PDF Rekap">
                Cetak Rekap PDF
            </a>
            @endif
            <a href="{{ route('reports.create') }}" class="btn-add">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Ajukan Laporan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-num">{{ $totalAll }}</div>
            <div class="stat-label">Total Laporan</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#b45309;">{{ $totalPending }}</div>
            <div class="stat-label">Menunggu Respon</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#0369a1;">{{ $totalInProgress }}</div>
            <div class="stat-label">Sedang Dikerjakan</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#15803d;">{{ $totalResolved }}</div>
            <div class="stat-label">Selesai Diperbaiki</div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="filter-card">
        <form method="GET" action="{{ route('reports.index') }}" class="filter-form">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nomor tiket, judul, pelapor, kode aset..."
                class="filter-input"
            >
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Menunggu Respon</option>
                <option value="IN_PROGRESS" {{ request('status') === 'IN_PROGRESS' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                <option value="RESOLVED" {{ request('status') === 'RESOLVED' ? 'selected' : '' }}>Selesai Diperbaiki</option>
                <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <select name="priority" class="filter-select">
                <option value="">Semua Prioritas</option>
                <option value="LOW" {{ request('priority') === 'LOW' ? 'selected' : '' }}>Low</option>
                <option value="MEDIUM" {{ request('priority') === 'MEDIUM' ? 'selected' : '' }}>Medium</option>
                <option value="HIGH" {{ request('priority') === 'HIGH' ? 'selected' : '' }}>High</option>
                <option value="EMERGENCY" {{ request('priority') === 'EMERGENCY' ? 'selected' : '' }}>Emergency</option>
            </select>
            <select name="per_page" class="filter-select" onchange="this.form.submit()">
                @foreach([15, 25, 50, 100, 150, 200] as $num)
                <option value="{{ $num }}" {{ request('per_page', 15) == $num ? 'selected' : '' }}>{{ $num }} data</option>
                @endforeach
                <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Semua Data</option>
            </select>
            <button type="submit" class="btn-filter">Cari</button>
            @if(request()->anyFilled(['q', 'status', 'priority', 'per_page']))
            <a href="{{ route('reports.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    <!-- TABLE -->
    <div class="card">
        @if($reports->count() > 0)
        <div class="card-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Perangkat (Aset)</th>
                        <th>Kendala & Pelapor</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Teknisi IT</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <td>
                            <span class="report-code">{{ $report->report_number }}</span>
                            <div style="font-size:11px; color:#64748b; margin-top:2px;">{{ $report->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td>
                            @if($report->asset)
                            <div class="asset-title">{{ $report->asset->name }}</div>
                            <div class="asset-code-sub">{{ $report->asset->asset_code }}</div>
                            <div style="font-size:11px; color:#64748b; margin-top:1px;">{{ $report->asset->placement->name ?? '-' }} ({{ $report->asset->location->name ?? '-' }})</div>
                            @else
                            <span style="color:#94a3b8;">Aset telah dihapus</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:700; color:#0c1a2e; margin-bottom:2px;">{{ $report->title }}</div>
                            <div style="font-size:11.5px; color:#64748b;">
                                Pelapor: <strong>{{ $report->reporter_name }}</strong>
                                @if($report->reporter_phone) &bull; Telp: {{ $report->reporter_phone }} @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $report->priority_badge_class }}">{{ $report->priority_label }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $report->status_badge_class }}">{{ $report->status_label }}</span>
                        </td>
                        <td>
                            @if($report->handler)
                            <div style="font-size:12.5px; font-weight:700; color:#0369a1;">Teknisi: {{ $report->handler->name }}</div>
                            @if($report->resolved_at)
                            <div style="font-size:11px; color:#15803d;">Selesai: {{ $report->resolved_at->format('d/m/Y H:i') }}</div>
                            @endif
                            @else
                            <span style="font-size:12px; color:#94a3b8;">Belum ditugaskan</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <div style="display:inline-flex; align-items:center; gap:4px;">
                                <a href="{{ route('reports.show', $report->id) }}" class="btn-act btn-act-view">
                                    {{ $isStaff ? 'Kelola Tiket' : 'Lihat Progres' }}
                                </a>
                                @if($isStaff)
                                <form method="POST" action="{{ route('reports.destroy', $report->id) }}" onsubmit="return confirm('Hapus laporan {{ $report->report_number }}?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del" title="Hapus Tiket">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            {{ $reports->links() }}
        </div>
        @else
        <div class="empty">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#7dd3fc" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            <h3 style="margin-top:10px; font-size:16px; font-weight:700; color:#0c1a2e;">Tidak Ada Laporan Maintenance</h3>
            <p style="color:#64748b; font-size:13px; margin-top:3px; margin-bottom:16px;">Belum ada laporan kendala yang terdaftar sesuai filter saat ini.</p>
            <a href="{{ route('reports.create') }}" class="btn-add">Ajukan Laporan Sekarang</a>
        </div>
        @endif
    </div>
</div>

</body>
</html>
