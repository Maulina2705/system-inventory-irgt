<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lacak Progress Pengaduan IT — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@700;800&display=swap" rel="stylesheet">
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
        .container { max-width: 600px; margin: 0 auto; padding: 24px 14px 48px; }

        /* SEARCH BOX */
        .search-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px 20px;
            box-shadow: 0 4px 20px rgba(3,105,161,0.06);
            border: 1.5px solid #e0f2fe;
            margin-bottom: 24px;
            text-align: center;
        }
        .search-title { font-size: 18px; font-weight: 800; color: #0c1a2e; margin-bottom: 6px; }
        .search-desc { font-size: 13px; color: #64748b; margin-bottom: 18px; line-height: 1.4; }

        .search-form { display: flex; gap: 8px; }
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            outline: none;
            background: #f8fafc;
            color: #0c1a2e;
            transition: all 0.15s;
        }
        .search-input:focus { border-color: #0369a1; background: #fff; box-shadow: 0 0 0 3px rgba(3,105,161,0.12); }
        .btn-search {
            padding: 12px 20px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 800;
            font-size: 13.5px;
            cursor: pointer;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(3,105,161,0.25);
            transition: all 0.15s;
            flex-shrink: 0;
        }
        .btn-search:hover { background: linear-gradient(135deg, #0369a1, #075985); }

        /* RESULT CARD */
        .result-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1.5px solid #e0f2fe;
            margin-bottom: 24px;
        }

        .ticket-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 18px; flex-wrap: wrap; }
        .ticket-code { font-family: 'JetBrains Mono', monospace; font-size: 18px; font-weight: 800; color: #0369a1; letter-spacing: 0.04em; }
        .ticket-time { font-size: 11.5px; color: #64748b; margin-top: 2px; }

        /* STATUS BADGE */
        .badge-status { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; }
        .status-pending { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
        .status-inprogress { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .status-resolved { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .status-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        /* PROGRESS STEP TRACKER */
        .tracker { display: flex; justify-content: space-between; position: relative; margin: 24px 0 28px; }
        .tracker::before { content: ''; position: absolute; top: 15px; left: 24px; right: 24px; height: 3px; background: #e2e8f0; z-index: 1; }
        .step { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; flex: 1; text-align: center; }
        .step-circle {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid #cbd5e1;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; color: #64748b;
            margin-bottom: 6px;
            transition: all 0.2s;
        }
        .step.active .step-circle {
            background: #0369a1;
            border-color: #0369a1;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(3,105,161,0.2);
        }
        .step.completed .step-circle {
            background: #16a34a;
            border-color: #16a34a;
            color: #fff;
        }
        .step.rejected .step-circle {
            background: #dc2626;
            border-color: #dc2626;
            color: #fff;
        }
        .step-label { font-size: 11px; font-weight: 700; color: #64748b; max-width: 90px; line-height: 1.2; }
        .step.active .step-label { color: #0369a1; font-weight: 800; }
        .step.completed .step-label { color: #16a34a; }
        .step.rejected .step-label { color: #dc2626; }

        /* DETAIL LIST */
        .info-card { background: #f8fafc; border-radius: 14px; padding: 16px; margin-bottom: 18px; border: 1px solid #e2e8f0; }
        .info-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
        .info-row:not(:last-child) { border-bottom: 1px solid #f1f5f9; }
        .info-lbl { color: #64748b; font-weight: 600; }
        .info-val { color: #0c1a2e; font-weight: 700; text-align: right; }

        /* TECHNICIAN NOTE BOX */
        .tech-box {
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 12px;
            padding: 14px;
            margin-top: 14px;
        }
        .tech-title { font-size: 12px; font-weight: 800; color: #15803d; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; display: flex; align-items: center; gap: 6px; }
        .tech-text { font-size: 13px; color: #1e293b; line-height: 1.5; }

        .tech-box-progress {
            background: #f0f9ff;
            border: 1.5px solid #bae6fd;
            border-radius: 12px;
            padding: 14px;
            margin-top: 14px;
        }
        .tech-box-progress .tech-title { color: #0369a1; }

        .not-found-card { background: #fff; border-radius: 18px; padding: 36px 20px; text-align: center; border: 1.5px solid #fed7aa; }
        .not-found-card svg { color: #ea580c; margin-bottom: 12px; }
        .not-found-card h3 { font-size: 17px; font-weight: 800; color: #0c1a2e; margin-bottom: 6px; }
        .not-found-card p { font-size: 13px; color: #64748b; line-height: 1.5; }

        .footer { text-align: center; font-size: 11.5px; color: #94a3b8; }
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
            <span>Lacak Progress Pengaduan IT</span>
        </div>
    </a>
    <div class="topbar-right">
        <a href="{{ route('public.assets.index') }}">
            Portal Publik
        </a>
    </div>
</div>

<div class="container">
    <!-- SEARCH FORM -->
    <div class="search-card">
        <div class="search-title">Lacak Status Pengaduan IT</div>
        <p class="search-desc">Ketik nomor tiket pengaduan Anda untuk memantau proses perbaikan secara real-time.</p>

        <form action="{{ route('public.reports.track') }}" method="GET" class="search-form">
            <input
                type="text"
                name="ticket"
                class="search-input"
                placeholder="TCK-20260831-0001"
                value="{{ $ticketQuery }}"
                required
                autofocus
            >
            <button type="submit" class="btn-search">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                Lacak
            </button>
        </form>
    </div>

    @if($searched)
        @if($report)
            <!-- RESULT CARD -->
            <div class="result-card">
                <div class="ticket-header">
                    <div>
                        <div class="ticket-code">{{ $report->report_number }}</div>
                        <div class="ticket-time">Diajukan: {{ $report->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                    <div>
                        @php
                            $statusClass = match($report->status) {
                                'PENDING' => 'status-pending',
                                'IN_PROGRESS' => 'status-inprogress',
                                'RESOLVED' => 'status-resolved',
                                'REJECTED' => 'status-rejected',
                                default => 'status-pending',
                            };
                            $statusLabel = match($report->status) {
                                'PENDING' => 'Menunggu Antrean',
                                'IN_PROGRESS' => 'Sedang Dikerjakan',
                                'RESOLVED' => 'Selesai Diperbaiki',
                                'REJECTED' => 'Ditolak / Dibatalkan',
                                default => $report->status,
                            };
                        @endphp
                        <span class="badge-status {{ $statusClass }}">
                            ● {{ $statusLabel }}
                        </span>
                    </div>
                </div>

                <!-- TRACKER -->
                <div class="tracker">
                    <!-- STEP 1: PENDING -->
                    <div class="step {{ $report->status === 'PENDING' ? 'active' : 'completed' }}">
                        <div class="step-circle">
                            @if(in_array($report->status, ['IN_PROGRESS', 'RESOLVED', 'REJECTED']))
                                ✓
                            @else
                                1
                            @endif
                        </div>
                        <div class="step-label">Laporan Diterima</div>
                    </div>

                    <!-- STEP 2: IN PROGRESS -->
                    <div class="step {{ $report->status === 'IN_PROGRESS' ? 'active' : ($report->status === 'RESOLVED' ? 'completed' : ($report->status === 'REJECTED' ? 'rejected' : '')) }}">
                        <div class="step-circle">
                            @if($report->status === 'RESOLVED')
                                ✓
                            @elseif($report->status === 'REJECTED')
                                ✕
                            @else
                                2
                            @endif
                        </div>
                        <div class="step-label">Penanganan Teknisi</div>
                    </div>

                    <!-- STEP 3: RESOLVED / REJECTED -->
                    <div class="step {{ $report->status === 'RESOLVED' ? 'completed active' : ($report->status === 'REJECTED' ? 'rejected active' : '') }}">
                        <div class="step-circle">
                            @if($report->status === 'RESOLVED')
                                ✓
                            @elseif($report->status === 'REJECTED')
                                ✕
                            @else
                                3
                            @endif
                        </div>
                        <div class="step-label">{{ $report->status === 'REJECTED' ? 'Ditolak' : 'Selesai' }}</div>
                    </div>
                </div>

                <!-- INFO LIST -->
                <div class="info-card">
                    <div class="info-row">
                        <span class="info-lbl">Perangkat:</span>
                        <span class="info-val">{{ $report->asset->name ?? '-' }} ({{ $report->asset->asset_code ?? '-' }})</span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Lokasi / Penempatan:</span>
                        <span class="info-val">{{ $report->asset->placement->name ?? '-' }} • {{ $report->asset->location->name ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Pelapor:</span>
                        <span class="info-val">{{ $report->reporter_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Departemen:</span>
                        <span class="info-val">{{ $report->reporter_department ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-lbl">Kendala:</span>
                        <span class="info-val">{{ $report->title }}</span>
                    </div>
                    <div class="info-row" style="flex-direction:column; gap:4px;">
                        <span class="info-lbl">Deskripsi Kerusakan:</span>
                        <span class="info-val" style="text-align:left; font-weight:500; font-size:12.5px; color:#334155; line-height:1.4;">{{ $report->description }}</span>
                    </div>
                    @if($report->handler)
                    <div class="info-row">
                        <span class="info-lbl">Teknisi Penanggung Jawab:</span>
                        <span class="info-val" style="color:#0369a1; font-weight:700;">{{ $report->handler->name }}</span>
                    </div>
                    @endif
                </div>

                <!-- TECHNICIAN NOTES (IF ANY) -->
                @if($report->status === 'RESOLVED')
                <div class="tech-box">
                    <div class="tech-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Solusi / Catatan Penyelesaian Teknisi
                    </div>
                    <div class="tech-text">{{ $report->technician_notes ?: 'Perangkat telah berhasil diperbaiki dan kembali berfungsi normal.' }}</div>
                    @if($report->resolved_at)
                    <div style="font-size:11px; color:#15803d; margin-top:6px; font-weight:600;">
                        Waktu Selesai: {{ $report->resolved_at->format('d M Y, H:i') }} WIB
                    </div>
                    @endif
                </div>
                @elseif($report->status === 'IN_PROGRESS' && $report->technician_notes)
                <div class="tech-box-progress">
                    <div class="tech-title">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                        Catatan Teknisi Saat Ini
                    </div>
                    <div class="tech-text">{{ $report->technician_notes }}</div>
                </div>
                @elseif($report->status === 'REJECTED')
                <div class="tech-box" style="background:#fee2e2; border-color:#fca5a5;">
                    <div class="tech-title" style="color:#b91c1c;">
                        Alasan Penolakan / Pembatalan
                    </div>
                    <div class="tech-text" style="color:#7f1d1d;">{{ $report->technician_notes ?: 'Laporan dibatalkan atau ditolak oleh Administrator IT.' }}</div>
                </div>
                @endif
            </div>
        @else
            <!-- NOT FOUND -->
            <div class="not-found-card">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <h3>Nomor Tiket Tidak Ditemukan</h3>
                <p>
                    Tidak ditemukan data pengaduan dengan nomor tiket <strong>"{{ $ticketQuery }}"</strong>.<br>
                    Mohon pastikan nomor tiket yang Anda ketik sudah sesuai (contoh: <code>TCK-20260831-0001</code>).
                </p>
            </div>
        @endif
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} IRGT School — IT Support System
    </div>
</div>

</body>
</html>
