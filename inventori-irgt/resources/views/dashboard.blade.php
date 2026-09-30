<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Ringkasan Eksekutif — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* CONTAINER */
        .container { max-width: 1400px; margin: 0 auto; padding: 28px 20px; }

        /* HEADER */
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .header-title h1 { font-size: 24px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 4px; display: flex; align-items: center; gap: 10px; }
        .header-title p { font-size: 13px; color: #64748b; }
        .quick-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-quick { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; font-family: inherit; transition: all 0.15s; }
        .btn-primary { background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; box-shadow: 0 4px 12px rgba(3,105,161,0.25); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(3,105,161,0.35); }
        .btn-outline { background: #fff; color: #0369a1; border: 1.5px solid #bae6fd; }
        .btn-outline:hover { background: #e0f2fe; color: #075985; }

        /* ALERT PENDING TICKETS & AUDIT REMINDER */
        @if($pendingTickets > 0)
        .banner-alert { background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1.5px solid #fde68a; border-radius: 14px; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; box-shadow: 0 2px 10px rgba(217,119,6,0.08); }
        .banner-alert-text { display: flex; align-items: center; gap: 12px; color: #92400e; font-size: 13.5px; font-weight: 600; }
        .banner-icon { width: 36px; height: 36px; border-radius: 10px; background: #fef08a; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .btn-banner { background: #d97706; color: #fff; padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700; text-decoration: none; transition: all 0.15s; }
        .btn-banner:hover { background: #b45309; }
        @endif

        .banner-reminder { background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1.5px solid #93c5fd; border-radius: 14px; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; box-shadow: 0 4px 14px rgba(37,99,235,0.08); }
        .banner-reminder-text { display: flex; align-items: center; gap: 12px; color: #1e40af; font-size: 13.5px; font-weight: 600; }
        .banner-reminder-icon { width: 38px; height: 38px; border-radius: 10px; background: #bfdbfe; color: #1d4ed8; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .btn-reminder { background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; text-decoration: none; transition: all 0.15s; box-shadow: 0 2px 8px rgba(37,99,235,0.25); }
        .btn-reminder:hover { background: #1d4ed8; }

        /* WIDGET GRID (AUDIT & CCTV) */
        .widget-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .widget-card { background: #fff; border-radius: 16px; padding: 20px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 18px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; }
        .widget-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .widget-title-wrap { display: flex; align-items: center; gap: 10px; }
        .widget-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .widget-title { font-size: 14.5px; font-weight: 800; color: #0c1a2e; }
        .widget-subtitle { font-size: 11.5px; color: #64748b; margin-top: 1px; }
        .widget-badge { font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
        .badge-done { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-waiting { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .widget-body { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 14px; margin-bottom: 14px; }
        .widget-stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; text-align: center; }
        .widget-stat-item { padding: 4px; }
        .widget-stat-val { font-size: 18px; font-weight: 800; color: #0c1a2e; line-height: 1.2; }
        .widget-stat-lbl { font-size: 10.5px; font-weight: 600; color: #64748b; margin-top: 2px; }
        .widget-footer { display: flex; justify-content: space-between; align-items: center; gap: 8px; }
        .widget-btn-link { font-size: 12px; font-weight: 700; color: #0369a1; text-decoration: none; }
        .widget-btn-link:hover { text-decoration: underline; }
        .widget-btn-action { display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 700; text-decoration: none; font-family: inherit; }
        .widget-btn-primary { background: #0369a1; color: #fff; }
        .widget-btn-primary:hover { background: #075985; }
        .widget-btn-secondary { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .widget-btn-secondary:hover { background: #bae6fd; }

        /* KPI GRID & ANIMATIONS */
        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        @media (max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .kpi-grid { grid-template-columns: 1fr; } }
        
        .kpi-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            border: 1.5px solid #e0f2fe;
            box-shadow: 0 4px 18px rgba(0,0,0,0.03);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            animation: dashFadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) backwards;
        }
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(3, 105, 161, 0.12);
            border-color: #bae6fd;
        }
        .kpi-card:active {
            transform: scale(0.98);
        }

        .widget-card, .chart-box-card, .panel-card {
            animation: dashFadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) backwards;
            transition: all 0.2s ease;
        }
        .widget-card:hover, .chart-box-card:hover {
            border-color: #bae6fd;
        }

        @keyframes dashFadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-quick, .btn-banner, .btn-reminder, .widget-btn-action {
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-quick:active, .btn-banner:active, .btn-reminder:active, .widget-btn-action:active {
            transform: scale(0.96);
        }

        .kpi-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .kpi-label { font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        .kpi-icon-wrap { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; transition: transform 0.25s ease; }
        .kpi-card:hover .kpi-icon-wrap { transform: scale(1.1) rotate(4deg); }
        .kpi-val { font-size: 28px; font-weight: 800; color: #0c1a2e; line-height: 1; margin-bottom: 6px; }
        .kpi-sub { font-size: 11.5px; color: #64748b; display: flex; align-items: center; gap: 4px; }
        .kpi-sub strong { color: #0c1a2e; }

        .icon-blue { background: #e0f2fe; color: #0369a1; }
        .icon-green { background: #dcfce7; color: #15803d; }
        .icon-amber { background: #fef3c7; color: #b45309; }
        .icon-red { background: #fee2e2; color: #b91c1c; }
        .icon-purple { background: #ede9fe; color: #6d28d9; }

        /* CHARTS SECTION */
        .charts-section-header { margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
        .charts-section-title { font-size: 16px; font-weight: 800; color: #0c1a2e; display: flex; align-items: center; gap: 8px; }
        .charts-section-subtitle { font-size: 12px; color: #64748b; margin-top: 2px; }
        .charts-grid-main { display: grid; grid-template-columns: 1.4fr 1fr; gap: 16px; margin-bottom: 24px; }
        .charts-grid-secondary { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .chart-box-card { background: #fff; border-radius: 16px; padding: 20px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 18px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; }
        .chart-box-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .chart-box-title { font-size: 14px; font-weight: 800; color: #0c1a2e; display: flex; align-items: center; gap: 8px; }
        .chart-box-subtitle { font-size: 11.5px; color: #64748b; margin-top: 2px; }
        .chart-canvas-container { position: relative; width: 100%; height: 230px; }

        /* MAIN CONTENT LAYOUT: 2 COLS */
        .dashboard-grid { display: grid; grid-template-columns: 1.3fr 0.9fr; gap: 20px; }

        .panel-card { background: #fff; border-radius: 16px; padding: 22px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1.5px solid #f0f9ff; }
        .panel-title { font-size: 15px; font-weight: 800; color: #0c1a2e; display: flex; align-items: center; gap: 8px; }
        .panel-link { font-size: 12px; font-weight: 700; color: #0369a1; text-decoration: none; }
        .panel-link:hover { text-decoration: underline; }

        /* TICKET ITEMS LIST */
        .ticket-list { display: flex; flex-direction: column; gap: 10px; }
        .ticket-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; gap: 12px; text-decoration: none; color: inherit; transition: all 0.15s; }
        .ticket-item:hover { background: #f0f9ff; border-color: #bae6fd; transform: translateX(3px); }
        .ticket-info { flex: 1; min-width: 0; }
        .ticket-num { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: #0369a1; }
        .ticket-title { font-size: 13px; font-weight: 700; color: #0c1a2e; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 2px 0; }
        .ticket-meta { font-size: 11px; color: #64748b; display: flex; gap: 8px; flex-wrap: wrap; }
        .ticket-badge { padding: 3px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; white-space: nowrap; }
        .badge-p-EMERGENCY { background: #fee2e2; color: #991b1b; }
        .badge-p-HIGH { background: #fef3c7; color: #92400e; }
        .badge-p-MEDIUM { background: #e0f2fe; color: #075985; }
        .badge-p-LOW { background: #f1f5f9; color: #475569; }

        /* PROGRESS BARS & STATS */
        .bar-list { display: flex; flex-direction: column; gap: 14px; }
        .bar-item { display: flex; flex-direction: column; gap: 4px; }
        .bar-header { display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 600; color: #334155; }
        .bar-track { height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 10px; background: #0369a1; }

        /* ASSET MINI LIST */
        .asset-mini-list { display: flex; flex-direction: column; gap: 8px; }
        .asset-mini-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 12.5px; }
        .asset-mini-code { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: #0369a1; }
        .asset-mini-name { font-weight: 700; color: #0c1a2e; margin-top: 1px; }

        @media (max-width: 992px) {
            .widget-grid { grid-template-columns: 1fr; }
            .charts-grid-main { grid-template-columns: 1fr; }
            .charts-grid-secondary { grid-template-columns: 1fr; }
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            body { padding-bottom: calc(76px + env(safe-area-inset-bottom)); }
            .container { padding: 14px 12px 36px; }
            .header-title h1 { font-size: 20px; }
            .quick-actions { width: 100%; display: flex; flex-wrap: wrap; gap: 8px; }
            .btn-quick { flex: 1 1 calc(50% - 8px); justify-content: center; min-height: 44px; text-align: center; font-size: 12px; }
            .chart-canvas-container { height: 200px; }
            .panel-card { padding: 16px; }
        }
    </style>
</head>
<body>

    <!-- UNIFIED NAVBAR -->
    @include('partials.navbar')

    <div class="container">

        <!-- HEADER -->
        <div class="dashboard-header">
            <div class="header-title">
                <h1>Ringkasan Eksekutif Inventaris</h1>
                <p>Status operasional perangkat, pemeliharaan IT, dan metrik inventaris IRGT School terkini.</p>
            </div>
            <div class="quick-actions">
                @if(auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
                <button type="button" onclick="openRecoveryModal()" class="btn-quick btn-outline" style="background: {{ \App\Models\SystemSetting::isRecoveryMode() ? '#fef3c7' : '#fff' }}; border-color: {{ \App\Models\SystemSetting::isRecoveryMode() ? '#f59e0b' : '#bae6fd' }}; color: {{ \App\Models\SystemSetting::isRecoveryMode() ? '#b45309' : '#0369a1' }}; cursor: pointer;" title="Atur Mode Pemulihan Sistem (Maintenance Mode)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                    Mode Pemulihan IT ({{ \App\Models\SystemSetting::isRecoveryMode() ? 'AKTIF' : 'Off' }})
                </button>
                <a href="{{ route('backup.download') }}" class="btn-quick btn-outline" style="background:#f0fdf4; border-color:#86efac; color:#166534;" title="Unduh seluruh cadangan data & tabel MySQL (.sql)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Backup Database (.sql)
                </a>
                @endif
                <a href="{{ route('assets.create') }}" class="btn-quick btn-primary">+ Tambah Inventaris</a>
                <a href="{{ route('assets.print-recap') }}" target="_blank" class="btn-quick btn-outline">Cetak Rekap Aset</a>
                <a href="{{ route('reports.index') }}" class="btn-quick btn-outline">Tiket Maintenance</a>
            </div>
        </div>

        <!-- PENGINGAT OTOMATIS AUDIT AKHIR BULAN (BIRU) -->
        @if($isAuditDueReminder)
        <div class="banner-reminder">
            <div class="banner-reminder-text">
                <div class="banner-reminder-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <div>
                    <strong>Pengingat Audit Akhir Bulan:</strong> Waktunya pemeriksaan fisik & inventarisasi laboratorium untuk periode <strong>{{ $currentMonthName }}</strong>! Belum ada Berita Acara yang dibuat.
                </div>
            </div>
            <a href="{{ route('audits.create') }}" class="btn-reminder">Mulai Audit Lab Sekarang →</a>
        </div>
        @endif

        <!-- BANNER PENDING TICKETS -->
        @if($pendingTickets > 0)
        <div class="banner-alert">
            <div class="banner-alert-text">
                <div class="banner-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
                <div>
                    <strong>Perhatian Tim IT Support:</strong> Terdapat <strong>{{ $pendingTickets }} tiket kendala baru</strong> yang menunggu penanganan teknisi.
                </div>
            </div>
            <a href="{{ route('reports.index', ['status' => 'PENDING']) }}" class="btn-banner">Lihat Antrean Tiket →</a>
        </div>
        @endif

        <!-- WIDGET RINGKASAN AUDIT LAB & CCTV MONITORING -->
        <div class="widget-grid">
            <!-- WIDGET 1: AUDIT AKHIR BULAN LAB -->
            <div class="widget-card">
                <div>
                    <div class="widget-header">
                        <div class="widget-title-wrap">
                            <div class="widget-icon" style="background: #e0f2fe; color: #0369a1;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                            </div>
                            <div>
                                <div class="widget-title">Status Audit Akhir Bulan Lab</div>
                                <div class="widget-subtitle">Periode: {{ $currentMonthName }}</div>
                            </div>
                        </div>
                        @if($currentMonthAudit)
                            <span class="widget-badge badge-done">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                Selesai Disahkan
                            </span>
                        @else
                            <span class="widget-badge badge-waiting">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Belum Diperiksa
                            </span>
                        @endif
                    </div>

                    <div class="widget-body">
                        @if($currentMonthAudit)
                            <div style="font-size: 12.5px; color: #0c1a2e; line-height: 1.5;">
                                <div><strong>No. Berita Acara:</strong> <span style="font-family: 'JetBrains Mono', monospace; color: #0369a1; font-weight: 700;">{{ $currentMonthAudit->audit_code }}</span></div>
                                <div style="color: #64748b; font-size: 11.5px; margin-top: 3px;">
                                    Disahkan oleh <strong>{{ $currentMonthAudit->coordinator_name }}</strong> • Tgl: {{ $currentMonthAudit->audit_date->format('d/m/Y') }}
                                </div>
                            </div>
                        @elseif($lastAudit)
                            <div style="font-size: 12.5px; color: #0c1a2e; line-height: 1.5;">
                                <div><strong>Audit Terakhir:</strong> Periode {{ date('F Y', mktime(0, 0, 0, $lastAudit->audit_month, 10, $lastAudit->audit_year)) }}</div>
                                <div style="color: #64748b; font-size: 11.5px; margin-top: 3px;">
                                    Kode #{{ $lastAudit->audit_code }} • Pemeriksa: {{ $lastAudit->inspector_name }}
                                </div>
                            </div>
                        @else
                            <div style="font-size: 12px; color: #64748b; text-align: center; padding: 4px 0;">
                                Belum ada riwayat audit yang disahkan.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="widget-footer">
                    <a href="{{ route('audits.index') }}" class="widget-btn-link">Lihat Riwayat & Rekap ({{ $totalAuditsCount }}) →</a>
                    @if($currentMonthAudit)
                        <a href="{{ route('audits.show', $currentMonthAudit->id) }}" class="widget-btn-action widget-btn-secondary">Lihat Detail Audit</a>
                    @else
                        <a href="{{ route('audits.create') }}" class="widget-btn-action widget-btn-primary">+ Mulai Audit Bulan Ini</a>
                    @endif
                </div>
            </div>

            <!-- WIDGET 2: PEMANTAUAN CCTV -->
            <div class="widget-card">
                <div>
                    <div class="widget-header">
                        <div class="widget-title-wrap">
                            <div class="widget-icon" style="background: #ede9fe; color: #6d28d9;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                            </div>
                            <div>
                                <div class="widget-title">Status Pemantauan CCTV</div>
                                <div class="widget-subtitle">Infrastruktur Pengawasan Kampus & Lab</div>
                            </div>
                        </div>
                        <a href="{{ route('cctv.create') }}" class="widget-btn-action widget-btn-secondary" style="padding: 4px 8px; font-size: 11px;">+ Cek Unit</a>
                    </div>

                    <div class="widget-body">
                        <div class="widget-stats-row">
                            <div class="widget-stat-item">
                                <div class="widget-stat-val" style="color: #0369a1;">{{ $totalCctv }}</div>
                                <div class="widget-stat-lbl">Total Kamera</div>
                            </div>
                            <div class="widget-stat-item" style="border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0;">
                                <div class="widget-stat-val" style="color: #15803d;">{{ $cctvOnlineCount }}</div>
                                <div class="widget-stat-lbl">Stream Online</div>
                            </div>
                            <div class="widget-stat-item">
                                <div class="widget-stat-val" style="color: {{ $cctvNeedMaintenanceCount > 0 ? '#dc2626' : '#64748b' }};">
                                    {{ $cctvNeedMaintenanceCount }}
                                </div>
                                <div class="widget-stat-lbl">Butuh Perawatan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-footer">
                    <div style="font-size: 11px; color: #64748b;">
                        @if($cctvNeedMaintenanceCount > 0)
                            <span style="color: #dc2626; font-weight: 700;">● {{ $cctvNeedMaintenanceCount }} unit perlu perhatian!</span>
                        @else
                            <span style="color: #15803d; font-weight: 700;">✓ Seluruh stream dalam kondisi optimal</span>
                        @endif
                    </div>
                    <a href="{{ route('cctv.index') }}" class="widget-btn-action widget-btn-secondary">Panel CCTV →</a>
                </div>
            </div>
        </div>

        <!-- KPI STATS CARDS -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Total Inventaris</span>
                    <div class="kpi-icon-wrap icon-blue">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    </div>
                </div>
                <div class="kpi-val">{{ number_format($totalAssets) }}</div>
                <div class="kpi-sub">Unit perangkat terdata</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Aset Aktif / Normal</span>
                    <div class="kpi-icon-wrap icon-green">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #15803d;">{{ number_format($activeAssets) }}</div>
                <div class="kpi-sub">
                    <strong>{{ $totalAssets > 0 ? round(($activeAssets / $totalAssets) * 100) : 100 }}%</strong> dari total inventaris
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Dalam Perbaikan</span>
                    <div class="kpi-icon-wrap icon-amber">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #d97706;">{{ number_format($maintenanceAssets) }}</div>
                <div class="kpi-sub">Aset berstatus maintenance</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Aset Rusak / Nonaktif</span>
                    <div class="kpi-icon-wrap icon-red">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #dc2626;">{{ number_format($damagedAssets) }}</div>
                <div class="kpi-sub">Rusak, hilang, dipensiunkan</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Sedang Dipinjam</span>
                    <div class="kpi-icon-wrap" style="background:#fef3c7; color:#b45309;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #b45309;">{{ number_format($borrowedAssets) }}</div>
                <div class="kpi-sub">
                    <a href="{{ route('borrowings.index') }}" style="color: #b45309; font-weight:700; text-decoration:none;">{{ $overdueBorrowingsCount }} Terlambat ➔</a>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Overdue PM</span>
                    <div class="kpi-icon-wrap" style="background:#fee2e2; color:#dc2626;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #dc2626;">{{ number_format($overdueSchedulesCount) }}</div>
                <div class="kpi-sub">
                    <a href="{{ route('maintenance-schedules.index') }}" style="color: #dc2626; font-weight:700; text-decoration:none;">{{ $dueSoonSchedulesCount }} Segera Jatuh Tempo ➔</a>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Biaya Servis Bulan Ini</span>
                    <div class="kpi-icon-wrap" style="background:#dcfce7; color:#15803d;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #15803d; font-size:20px;">{{ $formattedMonthlyCost }}</div>
                <div class="kpi-sub">
                    <span>Tahun Ini: <strong>{{ $formattedYearlyCost }}</strong></span>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">Penyelesaian Tiket</span>
                    <div class="kpi-icon-wrap icon-purple">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                </div>
                <div class="kpi-val" style="color: #6d28d9;">{{ $resolutionRate }}%</div>
                <div class="kpi-sub">{{ $resolvedTickets }} dari {{ $totalTickets }} tiket selesai</div>
            </div>
        </div>

        <!-- VISUALISASI DATA & GRAFIK INTERAKTIF -->
        <div class="charts-section-header">
            <div>
                <div class="charts-section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    <span>Analisis Visual & Tren Operasional</span>
                </div>
                <div class="charts-section-subtitle">Grafik komparasi pemeliharaan, komposisi aset, dan sebaran inventaris secara visual.</div>
            </div>
        </div>

        <div class="charts-grid-main">
            <!-- CHART 1: TREN MAINTENANCE 6 BULAN -->
            <div class="chart-box-card">
                <div class="chart-box-header">
                    <div>
                        <div class="chart-box-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                            Tren Tiket Maintenance (6 Bulan Terakhir)
                        </div>
                        <div class="chart-box-subtitle">Perbandingan tiket dilaporkan vs tiket berhasil diperbaiki</div>
                    </div>
                </div>
                <div class="chart-canvas-container">
                    <canvas id="chartMaintenanceTrend"></canvas>
                </div>
            </div>

            <!-- CHART 2: STATUS & KONDISI FISIK ASET -->
            <div class="chart-box-card">
                <div class="chart-box-header">
                    <div>
                        <div class="chart-box-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg>
                            Komposisi Status Operasional Aset
                        </div>
                        <div class="chart-box-subtitle">Proporsi kesiapan perangkat sekolah</div>
                    </div>
                </div>
                <div class="chart-canvas-container" style="display: flex; align-items: center; justify-content: center;">
                    <canvas id="chartAssetStatus"></canvas>
                </div>
            </div>
        </div>

        <div class="charts-grid-secondary">
            <!-- CHART 3: KATEGORI PERANGKAT UTAMA -->
            <div class="chart-box-card">
                <div class="chart-box-header">
                    <div>
                        <div class="chart-box-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            Distribusi Kategori Perangkat Terbanyak
                        </div>
                        <div class="chart-box-subtitle">5 Kategori aset dengan jumlah unit terbanyak</div>
                    </div>
                </div>
                <div class="chart-canvas-container">
                    <canvas id="chartAssetCategories"></canvas>
                </div>
            </div>

            <!-- CHART 4: DISTRIBUSI LOKASI / RUANGAN -->
            <div class="chart-box-card">
                <div class="chart-box-header">
                    <div>
                        <div class="chart-box-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Sebaran Aset per Ruangan / Laboratorium
                        </div>
                        <div class="chart-box-subtitle">5 Lokasi penempatan dengan inventaris tertinggi</div>
                    </div>
                </div>
                <div class="chart-canvas-container">
                    <canvas id="chartAssetLocations"></canvas>
                </div>
            </div>
        </div>

        <!-- 2 COLUMNS LAYOUT -->
        <div class="dashboard-grid">

            <!-- LEFT COLUMN -->
            <div>
                <!-- ANTREAN TIKET MAINTENANCE -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <span>Tiket Maintenance Perlu Tindakan Segera</span>
                        </div>
                        <a href="{{ route('reports.index') }}" class="panel-link">Semua Tiket →</a>
                    </div>

                    <div class="ticket-list">
                        @forelse($urgentTickets as $ticket)
                            <a href="{{ route('reports.show', $ticket->id) }}" class="ticket-item">
                                <div class="ticket-info">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span class="ticket-num">{{ $ticket->report_number }}</span>
                                        <span class="ticket-badge badge-p-{{ $ticket->priority }}">{{ $ticket->priority }}</span>
                                    </div>
                                    <div class="ticket-title">{{ $ticket->title }}</div>
                                    <div class="ticket-meta">
                                        <span>Lokasi: {{ $ticket->asset->location->name ?? '-' }}</span>
                                        <span>Pelapor: {{ $ticket->reporter_name }}</span>
                                        <span>{{ $ticket->created_at ? $ticket->created_at->diffForHumans() : '-' }}</span>
                                    </div>
                                </div>
                                <div>
                                    <span style="font-size: 11px; font-weight: 700; color: {{ $ticket->status === 'PENDING' ? '#d97706' : '#0369a1' }};">
                                        {{ $ticket->status === 'PENDING' ? 'Menunggu' : 'Proses' }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div style="text-align: center; padding: 24px; color: #64748b; font-size: 13px;">
                                Tidak ada tiket maintenance yang menunggu tindakan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- PERINGATAN GARANSI -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <span>Peringatan Masa Garansi Aset (< 60 Hari)</span>
                        </div>
                        <span style="font-size: 12px; font-weight: 700; color: #d97706;">{{ $expiringCount }} Aset Mendekati Jatuh Tempo</span>
                    </div>

                    <div class="asset-mini-list">
                        @forelse($expiringAssets as $asset)
                            <div class="asset-mini-item">
                                <div>
                                    <div class="asset-mini-code">{{ $asset->asset_code }}</div>
                                    <div class="asset-mini-name">{{ $asset->name }} ({{ $asset->brand ?? '-' }})</div>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                        Lokasi: {{ $asset->location->name ?? '-' }} | Vendor: {{ $asset->vendor ?? '-' }}
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 12px; font-weight: 800; color: #dc2626;">
                                        {{ date('d/m/Y', strtotime($asset->warranty_expiry)) }}
                                    </div>
                                    <div style="font-size: 10.5px; color: #64748b;">
                                        {{ \Carbon\Carbon::parse($asset->warranty_expiry)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 18px; color: #64748b; font-size: 13px;">
                                Tidak ada aset yang masa garansinya akan habis dalam waktu dekat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div>
                <!-- DISTRIBUSI STATUS TIKET -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <span>Distribusi Status Tiket Maintenance</span>
                        </div>
                        <span style="font-size: 12px; color: #64748b;">Total: {{ $totalTickets }} Tiket</span>
                    </div>

                    <div class="bar-list">
                        <div class="bar-item">
                            <div class="bar-header">
                                <span>Menunggu Respon (Pending)</span>
                                <strong>{{ $pendingTickets }}</strong>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $totalTickets > 0 ? ($pendingTickets / $totalTickets) * 100 : 0 }}%; background: #f59e0b;"></div>
                            </div>
                        </div>

                        <div class="bar-item">
                            <div class="bar-header">
                                <span>Sedang Dikerjakan</span>
                                <strong>{{ $inProgressTickets }}</strong>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $totalTickets > 0 ? ($inProgressTickets / $totalTickets) * 100 : 0 }}%; background: #0ea5e9;"></div>
                            </div>
                        </div>

                        <div class="bar-item">
                            <div class="bar-header">
                                <span>Selesai Diperbaiki</span>
                                <strong>{{ $resolvedTickets }}</strong>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $totalTickets > 0 ? ($resolvedTickets / $totalTickets) * 100 : 0 }}%; background: #22c55e;"></div>
                            </div>
                        </div>

                        <div class="bar-item">
                            <div class="bar-header">
                                <span>Ditolak / Dibatalkan</span>
                                <strong>{{ $rejectedTickets }}</strong>
                            </div>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $totalTickets > 0 ? ($rejectedTickets / $totalTickets) * 100 : 0 }}%; background: #94a3b8;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INVENTARIS BARU DITAMBAHKAN -->
                <div class="panel-card">
                    <div class="panel-header">
                        <div class="panel-title">
                            <span>Inventaris Baru Ditambahkan</span>
                        </div>
                        <a href="{{ route('assets.index') }}" class="panel-link">Lihat Semua →</a>
                    </div>

                    <div class="asset-mini-list">
                        @foreach($recentAssets as $asset)
                            <div class="asset-mini-item">
                                <div>
                                    <div class="asset-mini-code">{{ $asset->asset_code }}</div>
                                    <div class="asset-mini-name">{{ $asset->name }}</div>
                                    <div style="font-size: 11px; color: #64748b;">{{ $asset->location->name ?? '-' }}</div>
                                </div>
                                <div>
                                    <a href="{{ route('assets.print-label', $asset->id) }}" target="_blank" style="padding: 4px 8px; background: #e0f2fe; color: #0369a1; border-radius: 6px; font-size: 11px; font-weight: 700; text-decoration: none;">Label QR</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- CHART.JS INITIALIZATION -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#64748b';

        // 1. CHART TREN MAINTENANCE
        const ctxTrend = document.getElementById('chartMaintenanceTrend');
        if (ctxTrend) {
            new Chart(ctxTrend, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthLabels) !!},
                    datasets: [
                        {
                            label: 'Tiket Masuk',
                            data: {!! json_encode($createdMonthly) !!},
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderColor: '#dc2626',
                            borderWidth: 1.5,
                            borderRadius: 6,
                        },
                        {
                            label: 'Tiket Selesai',
                            data: {!! json_encode($resolvedMonthly) !!},
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: '#059669',
                            borderWidth: 1.5,
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { boxWidth: 12, usePointStyle: true, font: { weight: 600, size: 11.5 } }
                        },
                        tooltip: {
                            padding: 10,
                            backgroundColor: '#0c1a2e',
                            titleFont: { weight: 700 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 11 } },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { font: { weight: 600, size: 11 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. CHART STATUS & KONDISI ASET
        const ctxStatus = document.getElementById('chartAssetStatus');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Aktif / Normal', 'Dalam Perawatan', 'Rusak / Nonaktif'],
                    datasets: [{
                        data: [{{ $activeAssets }}, {{ $maintenanceAssets }}, {{ $damagedAssets }}],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, usePointStyle: true, font: { weight: 600, size: 11.5 }, padding: 12 }
                        },
                        tooltip: {
                            padding: 10,
                            backgroundColor: '#0c1a2e'
                        }
                    },
                    cutout: '68%'
                }
            });
        }

        // 3. CHART KATEGORI PERANGKAT
        const ctxCat = document.getElementById('chartAssetCategories');
        if (ctxCat) {
            new Chart(ctxCat, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($categoriesData->pluck('type_name')) !!},
                    datasets: [{
                        label: 'Jumlah Unit',
                        data: {!! json_encode($categoriesData->pluck('total')) !!},
                        backgroundColor: [
                            'rgba(14, 165, 233, 0.85)',
                            'rgba(99, 102, 241, 0.85)',
                            'rgba(168, 85, 247, 0.85)',
                            'rgba(236, 72, 153, 0.85)',
                            'rgba(245, 158, 11, 0.85)'
                        ],
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 10,
                            backgroundColor: '#0c1a2e'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 11 } },
                            grid: { color: '#f1f5f9' }
                        },
                        y: {
                            ticks: { font: { weight: 600, size: 11 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 4. CHART DISTRIBUSI LOKASI
        const ctxLoc = document.getElementById('chartAssetLocations');
        if (ctxLoc) {
            new Chart(ctxLoc, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($locationStats->pluck('loc_name')) !!},
                    datasets: [{
                        label: 'Jumlah Unit',
                        data: {!! json_encode($locationStats->pluck('total')) !!},
                        backgroundColor: 'rgba(217, 119, 6, 0.85)',
                        borderColor: '#b45309',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 10,
                            backgroundColor: '#0c1a2e'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 11 } },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            ticks: { font: { weight: 600, size: 11 } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });
    </script>

</body>
</html>
