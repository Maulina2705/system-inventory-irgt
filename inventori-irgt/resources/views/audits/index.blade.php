<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit & Pemeriksaan Aset Akhir Bulan — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }

        /* NAVBAR */
        .navbar { background: #0c1a2e; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-icon { width: 34px; height: 34px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; }
        .nav-brand-text h2 { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; }
        .nav-brand-text span { font-size: 10.5px; color: #7dd3fc; }
        .nav-links { display: flex; align-items: center; gap: 6px; list-style: none; }
        .nav-links a { display: flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: #cbd5e1; transition: all 0.15s; }
        .nav-links a:hover, .nav-links a.active { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-links a.active { background: #0369a1; }
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .user-pill { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.07); padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); }
        .user-avatar { width: 26px; height: 26px; background: #0369a1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: #fff; }
        .user-name { font-size: 12px; font-weight: 700; color: #fff; }
        .btn-logout { background: none; border: none; color: #94a3b8; cursor: pointer; display: flex; align-items: center; gap: 4px; font-size: 12px; padding: 6px; border-radius: 6px; font-family: inherit; }
        .btn-logout:hover { color: #f87171; background: rgba(239,68,68,0.1); }

        /* CONTAINER */
        .container { max-width: 1200px; margin: 0 auto; padding: 24px 16px 48px; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; }
        .page-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .btn-create { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; text-decoration: none; font-size: 13.5px; font-weight: 700; box-shadow: 0 4px 14px rgba(3,105,161,0.25); transition: all 0.15s; }
        .btn-create:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }
        .btn-export { display: inline-flex; align-items: center; gap: 6px; padding: 10px 14px; border-radius: 9px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.15s; }
        .btn-export-excel { background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd; }
        .btn-export-excel:hover { background: #bae6fd; }
        .btn-export-recap { background: #fff; color: #475569; border: 1.5px solid #cbd5e1; }
        .btn-export-recap:hover { background: #f8fafc; color: #0c1a2e; }

        /* FILTER & SEARCH CARD */
        .filter-card { background: #fff; border-radius: 16px; padding: 18px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 24px; border: 1.5px solid #e0f2fe; }
        .filter-form { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 12px; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-group label { font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; }
        .filter-input, .filter-select { padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; background: #f8fafc; color: #0c1a2e; outline: none; transition: all 0.15s; }
        .filter-input:focus, .filter-select:focus { border-color: #0369a1; background: #fff; box-shadow: 0 0 0 3px rgba(3,105,161,0.12); }
        .btn-filter { padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; background: #0369a1; color: #fff; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-family: inherit; }
        .btn-filter:hover { background: #075985; }
        .btn-reset { padding: 9px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; background: #f1f5f9; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-reset:hover { background: #e2e8f0; color: #0c1a2e; }

        /* STATS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 14px; padding: 18px; border: 1.5px solid #e0f2fe; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .stat-num { font-size: 24px; font-weight: 800; color: #0369a1; }
        .stat-label { font-size: 12.5px; font-weight: 600; color: #64748b; margin-top: 2px; }

        /* CARD */
        .card { background: #fff; border-radius: 16px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; }
        .card-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: left; }
        th { background: #f8fafc; padding: 12px 16px; font-weight: 700; color: #475569; border-bottom: 1.5px solid #e2e8f0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.04em; }
        td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:hover td { background: #f0f9ff; }

        .audit-code { font-family: 'JetBrains Mono', monospace; font-size: 12.5px; font-weight: 800; color: #0369a1; background: #e0f2fe; padding: 3px 8px; border-radius: 6px; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #dcfce7; color: #15803d; }

        .btn-act { padding: 6px 12px; border-radius: 7px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        .btn-act-view { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .btn-act-print { background: #fff; color: #475569; border: 1px solid #cbd5e1; }
        .btn-act-print:hover { background: #f8fafc; color: #0c1a2e; }

        .alert-success { background: #f0fdf4; border: 1.5px solid #86efac; color: #166534; padding: 14px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; }

        @media (max-width: 768px) {
            body { padding-bottom: calc(76px + env(safe-area-inset-bottom)); }
            .container { padding: 14px 12px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .btn-create { width: 100%; justify-content: center; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<div class="container">
    <!-- PENGINGAT OTOMATIS AUDIT AKHIR BULAN -->
    @php
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        $isDue = (date('j') >= 25) && !$audits->contains(fn($a) => $a->audit_month == $currentMonth && $a->audit_year == $currentYear);
    @endphp
    @if($isDue)
    <div style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1.5px solid #93c5fd; border-radius: 14px; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; box-shadow: 0 4px 14px rgba(37,99,235,0.08);">
        <div style="display: flex; align-items: center; gap: 12px; color: #1e40af; font-size: 13.5px; font-weight: 600;">
            <div style="width: 36px; height: 36px; border-radius: 8px; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            </div>
            <div>
                <strong>Waktunya pemeriksaan aset akhir bulan laboratorium!</strong><br>
                Belum ada Berita Acara Audit yang disahkan untuk periode <strong>{{ now()->translatedFormat('F Y') }}</strong>.
            </div>
        </div>
        <a href="{{ route('audits.create') }}" style="background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; text-decoration: none;">Mulai Audit Sekarang →</a>
    </div>
    @endif

    <div class="page-header">
        <div class="page-title">
            <h1>Berita Acara & Audit Aset Akhir Bulan</h1>
            <p>Pemeriksaan kondisi fisik perangkat lab/ruangan dan pengesahan resmi oleh Koordinator Labor Komputer.</p>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <a href="{{ route('audits.export.csv', request()->query()) }}" class="btn-export btn-export-excel" title="Unduh riwayat audit format Excel (CSV)">
                Unduh Excel (CSV)
            </a>
            <a href="{{ route('audits.print-recap', request()->query()) }}" target="_blank" class="btn-export btn-export-recap" title="Cetak Rekapitulasi Tahunan / PDF">
                Cetak Rekap PDF
            </a>
            <a href="{{ route('audits.create') }}" class="btn-create">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Mulai Audit Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- FILTER & PENCARIAN -->
    <div class="filter-card">
        <form method="GET" action="{{ route('audits.index') }}" class="filter-form">
            <div class="filter-group">
                <label>Pencarian</label>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari kode audit, judul, pemeriksa, atau koordinator..."
                    class="filter-input"
                >
            </div>
            <div class="filter-group">
                <label>Bulan Audit</label>
                <select name="month" class="filter-select">
                    <option value="">Semua Bulan</option>
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="filter-group">
                <label>Tahun</label>
                <select name="year" class="filter-select">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                    @endfor
                </select>
            </div>
            <div style="display: flex; gap: 6px;">
                <button type="submit" class="btn-filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Filter
                </button>
                @if(request()->anyFilled(['q', 'month', 'year']))
                <a href="{{ route('audits.index') }}" class="btn-reset" title="Reset Filter">✕</a>
                @endif
            </div>
        </form>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-num">{{ $totalAudits }}</div>
            <div class="stat-label">Total Berita Acara Audit</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#15803d;">{{ $completedAudits }}</div>
            <div class="stat-label">Disahkan Koordinator Lab</div>
        </div>
    </div>

    <div class="card">
        <div class="card-scroll">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Berita Acara</th>
                        <th>Judul Pemeriksaan</th>
                        <th>Periode Audit</th>
                        <th>Lokasi / Lab</th>
                        <th>Pemeriksa (IT)</th>
                        <th>Jumlah Aset</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audits as $audit)
                    <tr>
                        <td style="color:#94a3b8;">{{ $audits->firstItem() + $loop->index }}</td>
                        <td><span class="audit-code">{{ $audit->audit_code }}</span></td>
                        <td>
                            <strong style="color:#0c1a2e; font-size:13.5px;">{{ $audit->title }}</strong>
                            <div style="font-size:11px; color:#64748b; margin-top:2px;">Tgl Cek: {{ $audit->audit_date->format('d/m/Y') }}</div>
                        </td>
                        <td>{{ date('F Y', mktime(0, 0, 0, $audit->audit_month, 10, $audit->audit_year)) }}</td>
                        <td>{{ $audit->location->name ?? ($audit->placement->name ?? 'Semua Ruangan') }}</td>
                        <td>{{ $audit->inspector_name ?? '-' }}</td>
                        <td><strong>{{ $audit->items_count }}</strong> item</td>
                        <td>
                            <span class="badge-status">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Disahkan
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:inline-flex; gap:6px;">
                                <a href="{{ route('audits.show', $audit->id) }}" class="btn-act btn-act-view">Detail</a>
                                <a href="{{ route('audits.print', $audit->id) }}" target="_blank" class="btn-act btn-act-print">Cetak Berita Acara</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:40px; color:#94a3b8;">
                            Belum ada riwayat audit aset bulanan. Klik "Mulai Audit Akhir Bulan Baru" untuk membuat berita acara pemeriksaan pertama.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
