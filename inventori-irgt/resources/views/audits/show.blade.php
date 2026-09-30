<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemeriksaan Aset - {{ $audit->audit_code }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }
        .container { max-width: 1000px; margin: 0 auto; padding: 24px 16px 60px; }
        .card { background: #fff; border-radius: 16px; border: 1.5px solid #e0f2fe; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .btn-act { padding: 9px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-print { background: #0369a1; color: #fff; }
        .btn-back { background: #fff; color: #475569; border: 1px solid #cbd5e1; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #f8fafc; padding: 10px 14px; font-size: 12px; font-weight: 700; color: #475569; border-bottom: 1.5px solid #e2e8f0; text-align: left; }
        td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; }
        .alert-success { background: #f0fdf4; border: 1.5px solid #86efac; color: #166534; padding: 14px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; font-weight: 600; }
    </style>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<div class="container">
    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <div>
            <span style="font-family:monospace; font-size:13px; font-weight:800; color:#0369a1; background:#e0f2fe; padding:3px 8px; border-radius:6px;">{{ $audit->audit_code }}</span>
            <h1 style="font-size:22px; font-weight:800; color:#0c1a2e; margin-top:4px;">{{ $audit->title }}</h1>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('audits.index') }}" class="btn-act btn-back">Kembali</a>
            <a href="{{ route('audits.print', $audit->id) }}" target="_blank" class="btn-act btn-print">Cetak Berita Acara (PDF)</a>
        </div>
    </div>

    <div class="card" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
        <div>
            <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Periode Audit</div>
            <div style="font-size:14px; font-weight:800; color:#0c1a2e; margin-top:2px;">{{ date('F Y', mktime(0, 0, 0, $audit->audit_month, 10, $audit->audit_year)) }}</div>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Tanggal Inspeksi</div>
            <div style="font-size:14px; font-weight:800; color:#0c1a2e; margin-top:2px;">{{ $audit->audit_date->format('d F Y') }}</div>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Petugas Pemeriksa IT</div>
            <div style="font-size:14px; font-weight:800; color:#0c1a2e; margin-top:2px;">{{ $audit->inspector_name }}</div>
        </div>
        <div>
            <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Disahkan Oleh</div>
            <div style="font-size:14px; font-weight:800; color:#0369a1; margin-top:2px;">{{ $audit->coordinator_name }}</div>
        </div>
    </div>

    <div class="card">
        <h3 style="font-size:16px; font-weight:800; color:#0c1a2e; margin-bottom:14px;">
            Rincian Pemeriksaan Fisik Aset ({{ $audit->items->count() }} Perangkat)
        </h3>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Aset</th>
                        <th>Nama Perangkat</th>
                        <th>Kondisi Fisik</th>
                        <th>Status Operasional</th>
                        <th>Catatan Temuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($audit->items as $idx => $item)
                    <tr>
                        <td style="color:#94a3b8;">{{ $idx + 1 }}</td>
                        <td><span style="font-family:monospace; font-weight:800; color:#0369a1;">{{ $item->asset->asset_code ?? '-' }}</span></td>
                        <td><strong>{{ $item->asset->name ?? '-' }}</strong></td>
                        <td>
                            <span style="font-weight:700; color:{{ $item->condition === 'GOOD' ? '#15803d' : '#b91c1c' }};">
                                {{ $item->condition }}
                            </span>
                        </td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
