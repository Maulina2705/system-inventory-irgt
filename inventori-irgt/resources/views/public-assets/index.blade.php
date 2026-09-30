<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Portal Analisis & Inventaris Publik — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; width: 100%; max-width: 100vw; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* NAVBAR */
        .navbar { background: #0c1a2e; min-height: 64px; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 20px rgba(0,0,0,0.15); position: sticky; top: 0; z-index: 40; }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo { width: 38px; height: 38px; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 3px 10px rgba(0,0,0,0.25); flex-shrink: 0; overflow: hidden; padding: 2px; }
        .nav-brand-text h2 { font-size: 14.5px; font-weight: 800; color: #fff; line-height: 1.2; }
        .nav-brand-text span { font-size: 10.5px; color: #7dd3fc; }
        .nav-right { display: flex; align-items: center; gap: 8px; }
        .badge-publik { background: rgba(14,165,233,0.15); color: #7dd3fc; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(14,165,233,0.3); letter-spacing: 0.04em; }
        .btn-panel { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; text-decoration: none; font-size: 12.5px; font-weight: 700; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; transition: all 0.15s; box-shadow: 0 3px 10px rgba(3,105,161,0.3); white-space: nowrap; }
        .btn-panel:hover { background: linear-gradient(135deg, #0369a1, #075985); }

        /* HERO HEADER */
        .hero-section { background: linear-gradient(135deg, #0c1a2e 0%, #0c4a6e 100%); padding: 32px 20px 36px; text-align: center; color: #fff; border-bottom: 2.5px solid #0284c7; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #bae6fd; margin-bottom: 10px; }
        .hero-section h1 { font-size: 24px; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.02em; line-height: 1.3; }
        .hero-section p { font-size: 13px; color: #bae6fd; max-width: 580px; margin: 0 auto; line-height: 1.5; }

        /* CONTAINER */
        .container { max-width: 1320px; margin: 0 auto; padding: 24px 18px 60px; }

        /* SECTION HEADER */
        .section-header { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
        .section-title { display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 800; color: #0c1a2e; }
        .section-title svg { color: #0369a1; flex-shrink: 0; }
        .section-subtitle { font-size: 12px; color: #64748b; margin-top: 2px; }

        /* KPI METRICS GRID */
        .kpi-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; margin-bottom: 22px; }
        .kpi-card { background: #fff; border-radius: 12px; padding: 12px 14px; border: 1.5px solid #e0f2fe; box-shadow: 0 2px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; min-height: 90px; }
        .kpi-icon-wrap { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; }
        .kpi-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .kpi-num { font-size: 21px; font-weight: 800; line-height: 1.1; margin-bottom: 2px; }
        .kpi-label { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.03em; }

        .theme-blue .kpi-icon { background: #e0f2fe; color: #0369a1; }
        .theme-blue .kpi-num { color: #0369a1; }
        .theme-green .kpi-icon { background: #dcfce7; color: #15803d; }
        .theme-green .kpi-num { color: #15803d; }
        .theme-amber .kpi-icon { background: #fef3c7; color: #b45309; }
        .theme-amber .kpi-num { color: #b45309; }
        .theme-purple .kpi-icon { background: #f3e8ff; color: #7e22ce; }
        .theme-purple .kpi-num { color: #7e22ce; }
        .theme-emerald .kpi-icon { background: #ecfdf5; color: #047857; }
        .theme-emerald .kpi-num { color: #047857; }
        .theme-slate .kpi-icon { background: #f1f5f9; color: #475569; }
        .theme-slate .kpi-num { color: #475569; }

        /* CHARTS SECTION */
        .charts-row { display: grid; grid-template-columns: 1.5fr 1fr; gap: 14px; margin-bottom: 22px; width: 100%; max-width: 100%; }
        .charts-row > div { min-width: 0; width: 100%; box-sizing: border-box; }
        .chart-card { background: #fff; border-radius: 14px; padding: 16px; border: 1.5px solid #e0f2fe; box-shadow: 0 3px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; }
        .chart-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; gap: 8px; position: relative; z-index: 5; }
        .chart-title-wrap { min-width: 0; }
        .chart-title { font-size: 13.5px; font-weight: 800; color: #0c1a2e; display: flex; align-items: center; gap: 6px; white-space: nowrap; }
        .chart-subtitle { font-size: 11px; color: #64748b; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        .chart-actions { display: inline-flex; gap: 4px; background: #f1f5f9; padding: 3px; border-radius: 8px; flex-shrink: 0; }
        .btn-period { padding: 5px 11px; border: none; border-radius: 6px; font-size: 11.5px; font-weight: 700; font-family: inherit; cursor: pointer; color: #64748b; background: transparent; transition: all 0.15s; touch-action: manipulation; -webkit-tap-highlight-color: transparent; }
        .btn-period.active { background: #0369a1; color: #fff; box-shadow: 0 2px 5px rgba(3,105,161,0.25); }

        .chart-canvas-wrap { position: relative; width: 100%; max-width: 100%; height: 190px; overflow: hidden; }

        /* STATUS 2X2 COMPACT GRID */
        .status-grid-box { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; height: 100%; align-content: center; }
        .status-mini-card { border-radius: 10px; padding: 10px 12px; display: flex; flex-direction: column; justify-content: space-between; min-height: 78px; border: 1px solid transparent; }
        .st-mini-header { display: flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; }
        .st-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .st-mini-val { font-size: 18px; font-weight: 800; font-family: 'JetBrains Mono', monospace; line-height: 1.1; margin-top: 4px; }
        .st-mini-val small { font-size: 11px; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; color: #64748b; margin-left: 2px; }

        .st-box-green { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .st-box-green .st-dot { background: #16a34a; }
        .st-box-green .st-mini-val { color: #15803d; }

        .st-box-amber { background: #fffbeb; border-color: #fde68a; color: #b45309; }
        .st-box-amber .st-dot { background: #d97706; }
        .st-box-amber .st-mini-val { color: #b45309; }

        .st-box-red { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }
        .st-box-red .st-dot { background: #dc2626; }
        .st-box-red .st-mini-val { color: #b91c1c; }

        .st-box-blue { background: #f0f9ff; border-color: #bae6fd; color: #0369a1; }
        .st-box-blue .st-dot { background: #0284c7; }
        .st-box-blue .st-mini-val { color: #0369a1; }

        /* SEARCH & FILTER */
        .filter-box { background: #fff; border-radius: 12px; padding: 12px 14px; border: 1.5px solid #e0f2fe; margin-bottom: 14px; }
        .filter-form { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .filter-input { flex: 1; min-width: 200px; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 12.5px; font-family: inherit; background: #f8fafc; outline: none; }
        .filter-input:focus { border-color: #0369a1; background: #fff; }
        .filter-select { padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 12.5px; font-family: inherit; background: #f8fafc; outline: none; }
        .btn-search { padding: 8px 16px; background: #0369a1; color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 12.5px; cursor: pointer; font-family: inherit; }
        .btn-search:hover { background: #075985; }
        .btn-reset { padding: 8px 12px; background: #f1f5f9; color: #64748b; text-decoration: none; border-radius: 8px; font-size: 12px; font-weight: 600; }

        /* TABLE */
        .card-table { background: #fff; border-radius: 14px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 20px rgba(0,0,0,0.02); overflow: hidden; }
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 880px; }
        th { background: #f0f9ff; text-align: left; padding: 11px 14px; border-bottom: 2px solid #e0f2fe; font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 12px 14px; border-bottom: 1px solid #f0f9ff; font-size: 12.5px; color: #334155; vertical-align: middle; }
        tr:hover td { background: #f8fafc; }

        .asset-code { font-family: 'JetBrains Mono', monospace; font-size: 12px; font-weight: 700; color: #0369a1; background: #e0f2fe; padding: 5px 10px; border-radius: 7px; display: inline-block; white-space: nowrap; line-height: 1.4; letter-spacing: 0.02em; border: 1px solid #bae6fd; box-sizing: border-box; }
        .asset-title { font-weight: 700; color: #0c1a2e; }

        .badge-status { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 800; letter-spacing: 0.02em; }
        .st-active { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .st-maintenance { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .st-damaged { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        .badge-cond { display: inline-block; padding: 2px 7px; border-radius: 6px; font-size: 11px; font-weight: 700; }
        .cd-good { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .cd-fair { background: #fffbeb; color: #d97706; border: 1px solid #fef3c7; }
        .cd-poor { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        .pagination-wrap { padding: 0; }

        /* FOOTER */
        .footer { text-align: center; padding: 28px 20px 20px; font-size: 11.5px; color: #64748b; }

        /* RESPONSIVE SMARTPHONE */
        @media (max-width: 1024px) {
            .kpi-grid { grid-template-columns: repeat(3, 1fr); gap: 8px; }
            .charts-row { grid-template-columns: 1fr; gap: 12px; }
        }
        @media (max-width: 640px) {
            .navbar { padding: 8px 12px; min-height: 52px; }
            .nav-brand-text h2 { font-size: 13px; }
            .nav-brand-text span { font-size: 9px; }
            .hero-section { padding: 18px 12px 20px; }
            .hero-section h1 { font-size: 17px; margin-bottom: 3px; }
            .hero-section p { font-size: 11.5px; }
            .container { padding: 10px 8px 30px; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); gap: 6px; }
            .kpi-card { padding: 8px 10px; border-radius: 10px; min-height: 75px; }
            .kpi-num { font-size: 17px; }
            .kpi-label { font-size: 8.5px; }
            .chart-card { padding: 12px 10px; border-radius: 12px; }
            .chart-header { flex-direction: row; align-items: center; justify-content: space-between; gap: 6px; }
            .chart-title { font-size: 12px; }
            .chart-subtitle { font-size: 10px; }
            .chart-canvas-wrap { height: 160px !important; }
            .chart-actions { display: inline-flex; gap: 2px; padding: 2px; }
            .btn-period { padding: 5px 8px; font-size: 10.5px; border-radius: 5px; }
            .status-grid-box { gap: 6px; }
            .status-mini-card { padding: 8px 10px; min-height: 65px; border-radius: 8px; }
            .st-mini-header { font-size: 10px; }
            .st-mini-val { font-size: 16px; }
            .filter-box { padding: 10px; }
            .filter-form { flex-direction: column; gap: 6px; }
            .filter-input, .filter-select, .btn-search, .btn-reset { width: 100%; min-width: 100%; text-align: center; }
            .btn-search, .btn-reset { padding: 8px; }
            .asset-code { font-size: 11px; padding: 4px 8px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('public.assets.index') }}" class="nav-brand">
        @include('partials.navbar-logo')
        <div class="nav-brand-text">
            <h2>IRGT INVENTORY</h2>
            <span>Portal Analisis & Inventaris Publik</span>
        </div>
    </a>
    <div class="nav-right">
        <a href="{{ route('public.reports.track') }}" class="btn-panel" style="background:rgba(14,165,233,0.15); color:#7dd3fc; border-color:rgba(14,165,233,0.3);">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            Lacak Tiket
        </a>
        @auth
        <a href="{{ route('assets.index') }}" class="btn-panel">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Panel Internal
        </a>
        @else
        <a href="{{ route('login') }}" class="btn-panel">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
            Masuk Petugas
        </a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<div class="hero-section">
    <div class="hero-badge">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
        Statistik Terbuka & Real-Time
    </div>
    <h1>Transparansi Inventaris & Pemeliharaan IT</h1>
    <p>Monitoring berkala jumlah perangkat sekolah, efektivitas penanganan tiket perbaikan teknisi, serta kondisi operasional fasilitas IT IRGT School.</p>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- KPI METRICS (6 KARTU RINGKASAN) -->
    <div class="section-header">
        <div>
            <div class="section-title">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                Ringkasan Inventaris & Maintenance
            </div>
            <div class="section-subtitle">Rekapitulasi kondisi perangkat dan efisiensi pengerjaan tiket perbaikan.</div>
        </div>
    </div>

    <div class="kpi-grid">
        <!-- 1. Total Perangkat -->
        <div class="kpi-card theme-blue">
            <div class="kpi-icon-wrap">
                <span class="kpi-label">Total Perangkat</span>
                <div class="kpi-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                </div>
            </div>
            <div class="kpi-num">{{ $totalAssets }}</div>
            <div style="font-size:10px; color:#64748b;">Unit Aset Terdata</div>
        </div>

        <!-- 2. Perangkat Aktif -->
        <div class="kpi-card theme-green">
            <div class="kpi-icon-wrap">
                <span class="kpi-label">Siap Pakai (Aktif)</span>
                <div class="kpi-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
            </div>
            <div class="kpi-num">{{ $activeAssets }}</div>
            <div style="font-size:10px; color:#15803d;">Beroperasi Normal</div>
        </div>

        <!-- 3. Sedang Maintenance -->
        <div class="kpi-card theme-amber">
            <div class="kpi-icon-wrap">
                <span class="kpi-label">Dalam Perawatan</span>
                <div class="kpi-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                </div>
            </div>
            <div class="kpi-num">{{ $maintenanceAssets }}</div>
            <div style="font-size:10px; color:#b45309;">Sedang Diservis IT</div>
        </div>

        <!-- 4. Total Tiket Masuk -->
        <div class="kpi-card theme-purple">
            <div class="kpi-icon-wrap">
                <span class="kpi-label">Total Tiket Masuk</span>
                <div class="kpi-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
            </div>
            <div class="kpi-num">{{ $totalTickets }}</div>
            <div style="font-size:10px; color:#7e22ce;">Laporan Diajukan</div>
        </div>

        <!-- 5. Tiket Berhasil Selesai -->
        <div class="kpi-card theme-emerald">
            <div class="kpi-icon-wrap">
                <span class="kpi-label">Tiket Selesai</span>
                <div class="kpi-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><circle cx="12" cy="11" r="3"></circle><line x1="12" y1="14" x2="12" y2="17"></line></svg>
                </div>
            </div>
            <div class="kpi-num">{{ $resolvedTickets }}</div>
            <div style="font-size:10px; color:#047857;">Tuntas Diperbaiki</div>
        </div>

        <!-- 6. Tingkat Resolusi -->
        <div class="kpi-card theme-slate">
            <div class="kpi-icon-wrap">
                <span class="kpi-label">Tingkat Resolusi</span>
                <div class="kpi-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
            </div>
            <div class="kpi-num">{{ $resolutionRate }}%</div>
            <div style="font-size:10px; color:#475569;">Efektivitas Perbaikan</div>
        </div>
    </div>

    <!-- CHARTS SECTION (2 KARTU UTAMA RAPI & TIDAK KEPOTONG) -->
    <div class="charts-row">
        <!-- GRAFIK 1: TREN TIKET & RESOLUSI -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        Tren Laporan & Penyelesaian
                    </div>
                    <div class="chart-subtitle">Laju kendala masuk vs perbaikan selesai</div>
                </div>
                <div class="chart-actions">
                    <button type="button" class="btn-period active" onclick="switchTrendPeriod('monthly', this)">12 Bulan</button>
                    <button type="button" class="btn-period" onclick="switchTrendPeriod('daily', this)">30 Hari</button>
                </div>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- GRAFIK 2: STATUS OPERASIONAL (2X2 GRID COMPACT) -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title-wrap">
                    <div class="chart-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        Status Operasional Aset
                    </div>
                    <div class="chart-subtitle">Kondisi terkini seluruh unit fisik IT</div>
                </div>
            </div>
            <div class="status-grid-box">
                <div class="status-mini-card st-box-green">
                    <div class="st-mini-header">
                        <span class="st-dot dot-green"></span>
                        <span>Siap Pakai</span>
                    </div>
                    <div class="st-mini-val">{{ $activeAssets }} <small>Unit</small></div>
                </div>
                <div class="status-mini-card st-box-amber">
                    <div class="st-mini-header">
                        <span class="st-dot dot-amber"></span>
                        <span>Maintenance</span>
                    </div>
                    <div class="st-mini-val">{{ $maintenanceAssets }} <small>Unit</small></div>
                </div>
                <div class="status-mini-card st-box-red">
                    <div class="st-mini-header">
                        <span class="st-dot dot-red"></span>
                        <span>Rusak/Ganti</span>
                    </div>
                    <div class="st-mini-val">{{ $damagedAssets }} <small>Unit</small></div>
                </div>
                <div class="status-mini-card st-box-blue">
                    <div class="st-mini-header">
                        <span class="st-dot dot-blue"></span>
                        <span>Kondisi Baik</span>
                    </div>
                    <div class="st-mini-val">{{ $conditionGood }} <small>Unit</small></div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH & INVENTORY TABLE -->
    <div class="section-header" style="margin-top:20px;">
        <div>
            <div class="section-title">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                Katalog Inventaris Publik
            </div>
            <div class="section-subtitle">Daftar perangkat teknologi sekolah yang dapat dipantau secara terbuka.</div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-box">
        <form method="GET" action="{{ route('public.assets.index') }}" class="filter-form">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Cari kode aset, nama perangkat, atau lokasi..." 
                class="filter-input"
            >
            <select name="type_id" class="filter-select">
                <option value="">Semua Tipe Perangkat</option>
                @foreach($allTypes as $t)
                <option value="{{ $t->id }}" {{ request('type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Aktif</option>
                <option value="MAINTENANCE" {{ request('status') === 'MAINTENANCE' ? 'selected' : '' }}>Maintenance</option>
                <option value="DAMAGED" {{ request('status') === 'DAMAGED' ? 'selected' : '' }}>Rusak</option>
            </select>
            <button type="submit" class="btn-search">Cari</button>
            @if(request()->anyFilled(['q', 'type_id', 'status']))
            <a href="{{ route('public.assets.index') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    <!-- TABLE -->
    <div class="card-table">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th style="min-width:190px;">Kode Aset</th>
                        <th style="min-width:180px;">Nama Perangkat</th>
                        <th style="min-width:140px;">Tipe / Kategori</th>
                        <th style="min-width:160px;">Penempatan Ruangan</th>
                        <th style="text-align:center; min-width:90px;">Kondisi</th>
                        <th style="text-align:center; min-width:110px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td><span class="asset-code">{{ $asset->asset_code }}</span></td>
                        <td>
                            <div class="asset-title">{{ $asset->name }}</div>
                            <div style="font-size:11px; color:#64748b;">{{ $asset->brand }} {{ $asset->model ? '• ' . $asset->model : '' }}</div>
                        </td>
                        <td><span style="font-weight:600; color:#475569;">{{ $asset->assetType->name ?? '-' }}</span></td>
                        <td>{{ $asset->placement->name ?? ($asset->location->name ?? '-') }}</td>
                        <td style="text-align:center;">
                            @php
                                $cond = strtolower($asset->condition ?? 'good');
                                $condLabel = match($cond) {
                                    'good', 'baik' => 'Baik',
                                    'fair', 'cukup' => 'Cukup',
                                    default => 'Rusak',
                                };
                                $condClass = match($cond) {
                                    'good', 'baik' => 'cd-good',
                                    'fair', 'cukup' => 'cd-fair',
                                    default => 'cd-poor',
                                };
                            @endphp
                            <span class="badge-cond {{ $condClass }}">{{ $condLabel }}</span>
                        </td>
                        <td style="text-align:center;">
                            @php
                                $st = strtoupper($asset->status ?? 'ACTIVE');
                                $stClass = match($st) {
                                    'ACTIVE' => 'st-active',
                                    'MAINTENANCE' => 'st-maintenance',
                                    default => 'st-damaged',
                                };
                                $stLabel = match($st) {
                                    'ACTIVE' => 'AKTIF',
                                    'MAINTENANCE' => 'MAINTENANCE',
                                    default => 'RUSAK',
                                };
                            @endphp
                            <span class="badge-status {{ $stClass }}">{{ $stLabel }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:36px; color:#64748b;">
                            Tidak ada data perangkat yang cocok dengan pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($assets->hasPages())
        <div class="pagination-wrap">
            {{ $assets->links() }}
        </div>
        @endif
    </div>

    <!-- FOOTER -->
    <div class="footer">
        &copy; 2026 IRGT School — Sistem Informasi & Inventaris Perangkat IT. Data diperbarui secara otomatis.
    </div>

</div>

<!-- CHART.JS SCRIPT -->
<script>
const monthlyLabels = @json($monthsLabels);
const createdMonthly = @json($ticketsCreatedMonthly);
const resolvedMonthly = @json($ticketsResolvedMonthly);

const dailyLabels = @json($daysLabels);
const createdDaily = @json($ticketsCreatedDaily);
const resolvedDaily = @json($ticketsResolvedDaily);

const ctxTrend = document.getElementById('trendChart').getContext('2d');
let trendChart = new Chart(ctxTrend, {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [
            {
                label: 'Tiket Masuk',
                data: createdMonthly,
                borderColor: '#0284c7',
                backgroundColor: 'rgba(2, 132, 199, 0.10)',
                fill: true,
                tension: 0.35,
                borderWidth: 2,
                pointBackgroundColor: '#0284c7',
                pointRadius: 3,
                pointHoverRadius: 5,
            },
            {
                label: 'Tiket Selesai',
                data: resolvedMonthly,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.10)',
                fill: true,
                tension: 0.35,
                borderWidth: 2,
                pointBackgroundColor: '#10b981',
                pointRadius: 3,
                pointHoverRadius: 5,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: { top: 5, bottom: 5, left: 5, right: 10 }
        },
        plugins: {
            legend: { 
                position: 'top', 
                align: 'end',
                labels: { boxWidth: 10, boxHeight: 10, font: { family: 'Plus Jakarta Sans', weight: '700', size: 10.5 }, padding: 8 } 
            },
            tooltip: { 
                padding: 8, 
                cornerRadius: 7, 
                titleFont: { family: 'Plus Jakarta Sans', weight: '700', size: 11 },
                bodyFont: { family: 'Plus Jakarta Sans', size: 10.5 }
            }
        },
        scales: {
            y: { 
                beginAtZero: true, 
                ticks: { precision: 0, font: { family: 'Plus Jakarta Sans', size: 10 } }, 
                grid: { color: '#f1f5f9' } 
            },
            x: { 
                ticks: { 
                    font: { family: 'Plus Jakarta Sans', size: 9.5 },
                    maxRotation: 0,
                    autoSkip: true,
                    maxTicksLimit: 7
                }, 
                grid: { display: false } 
            }
        }
    }
});

function switchTrendPeriod(period, btn) {
    document.querySelectorAll('.btn-period').forEach(b => b.classList.remove('active'));
    if (btn) {
        btn.classList.add('active');
    }
    if (period === 'daily') {
        trendChart.data.labels = dailyLabels;
        trendChart.data.datasets[0].data = createdDaily;
        trendChart.data.datasets[1].data = resolvedDaily;
        trendChart.options.scales.x.ticks.maxTicksLimit = 6;
    } else {
        trendChart.data.labels = monthlyLabels;
        trendChart.data.datasets[0].data = createdMonthly;
        trendChart.data.datasets[1].data = resolvedMonthly;
        trendChart.options.scales.x.ticks.maxTicksLimit = 7;
    }
    trendChart.update();
}
</script>

</body>
</html>
