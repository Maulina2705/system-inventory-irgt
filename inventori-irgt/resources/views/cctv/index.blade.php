<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring & Diagnostik CCTV — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }

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

        .container { max-width: 1200px; margin: 0 auto; padding: 24px 16px 48px; }

        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; }
        .page-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .btn-create { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 10px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; text-decoration: none; font-size: 13.5px; font-weight: 700; box-shadow: 0 4px 14px rgba(3,105,161,0.25); }
        .btn-create:hover { background: linear-gradient(135deg, #0369a1, #075985); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 14px; padding: 18px; border: 1.5px solid #e0f2fe; }
        .stat-num { font-size: 24px; font-weight: 800; color: #0369a1; }
        .stat-label { font-size: 12.5px; font-weight: 600; color: #64748b; margin-top: 2px; }

        .card { background: #fff; border-radius: 16px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: left; }
        th { background: #f8fafc; padding: 12px 16px; font-weight: 700; color: #475569; border-bottom: 1.5px solid #e2e8f0; font-size: 12px; }
        td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:hover td { background: #f0f9ff; }

        .badge-online { background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 20px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; }
        .badge-offline { background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 20px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; }
        .badge-warning { background: #fef9c3; color: #a16207; padding: 3px 8px; border-radius: 20px; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; }

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
    <div class="page-header">
        <div class="page-title">
            <h1>Monitoring & Diagnostik CCTV Sekolah</h1>
            <p>Pemeriksaan rutin 3 pilar: Koneksi Jaringan IP/Ping, Kondisi Fisik & Lensa, serta Status Memori/Penyimpanan.</p>
        </div>
        <div>
            <a href="{{ route('cctv.create') }}" class="btn-create">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Input Pemeriksaan CCTV Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-num">{{ $totalCctv }}</div>
            <div class="stat-label">Total Titik CCTV Terpasang</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#15803d;">{{ $onlineCount }}</div>
            <div class="stat-label">CCTV Online & Normal</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#b91c1c;">{{ $needMaintenanceCount }}</div>
            <div class="stat-label">Butuh Perawatan / Perbaikan</div>
        </div>
    </div>

    <!-- TABEL STATUS CCTV -->
    <div class="card">
        <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1.5px solid #e2e8f0;">
            <h3 style="font-size: 15px; font-weight: 800; color: #0c1a2e;">Daftar Titik CCTV & Hasil Diagnostik Terkini</h3>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode & Nama Titik CCTV</th>
                        <th>Lokasi</th>
                        <th>Koneksi Jaringan (IP / Ping)</th>
                        <th>Fisik & Lensa</th>
                        <th>Status Memori / Storage</th>
                        <th>Kesimpulan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cctvAssets as $idx => $asset)
                    @php $lastCheck = $asset->cctvChecks->first(); @endphp
                    <tr>
                        <td style="color:#94a3b8;">{{ $idx + 1 }}</td>
                        <td>
                            <strong style="color:#0c1a2e; font-size:13.5px;">{{ $asset->name }}</strong>
                            <div style="font-family:monospace; font-size:11px; color:#0369a1;">{{ $asset->asset_code }}</div>
                        </td>
                        <td>{{ $asset->location->name ?? '-' }}</td>
                        <td>
                            @if($lastCheck)
                                <span class="{{ $lastCheck->network_status === 'ONLINE' ? 'badge-online' : 'badge-offline' }}">
                                    {{ $lastCheck->network_status }}
                                </span>
                                <div style="font-size:11px; color:#64748b; margin-top:2px;">
                                    IP: {{ $lastCheck->ip_address ?? ($asset->ip_address ?? '-') }} • {{ $lastCheck->ping_ms ? $lastCheck->ping_ms . 'ms' : 'No Ping' }}
                                </div>
                            @else
                                <span class="badge-warning">Belum Dicek</span>
                            @endif
                        </td>
                        <td>
                            @if($lastCheck)
                                <strong style="font-size:12px; color:#0c1a2e;">{{ str_replace('_', ' ', $lastCheck->physical_condition) }}</strong>
                                <div style="font-size:11px; color:#64748b;">Night Vision: {{ $lastCheck->night_vision_status }}</div>
                            @else
                                <span style="color:#94a3b8;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($lastCheck)
                                <strong style="font-size:12px; color:#0c1a2e;">{{ $lastCheck->storage_type }}</strong>
                                <div style="font-size:11px; color:{{ $lastCheck->storage_status === 'RECORDING_NORMAL' ? '#15803d' : '#b91c1c' }};">
                                    {{ str_replace('_', ' ', $lastCheck->storage_status) }}
                                    @if($lastCheck->days_retained) ({{ $lastCheck->days_retained }} hari) @endif
                                </div>
                            @else
                                <span style="color:#94a3b8;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($lastCheck)
                                <span class="{{ $lastCheck->overall_verdict === 'NORMAL' ? 'badge-online' : 'badge-offline' }}">
                                    {{ str_replace('_', ' ', $lastCheck->overall_verdict) }}
                                </span>
                            @else
                                <span style="color:#94a3b8; font-size:12px;">Menunggu Cek</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('cctv.create', ['asset_id' => $asset->id]) }}" style="padding:5px 10px; background:#e0f2fe; color:#0369a1; border-radius:6px; font-weight:700; text-decoration:none; font-size:11.5px; border:1px solid #bae6fd;">
                                Cek Unit Ini
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:#94a3b8;">
                            Belum ada aset dengan tipe CCTV. Daftarkan aset dengan tipe barang CCTV (CC) pada menu Tambah Inventaris terlebih dahulu.
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
