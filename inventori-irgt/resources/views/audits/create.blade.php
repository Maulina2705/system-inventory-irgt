<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Checklist Audit Aset Akhir Bulan — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }
        .container { max-width: 1100px; margin: 0 auto; padding: 24px 16px 60px; }
        .card { background: #fff; border-radius: 16px; border: 1.5px solid #e0f2fe; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; }
        .page-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
        label { display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 1.5px solid #cbd5e1; border-radius: 9px; font-size: 13px; font-family: inherit; background: #f8fafc; outline: none; }
        input:focus, select:focus, textarea:focus { border-color: #0369a1; background: #fff; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 14px; }
        th { background: #f8fafc; padding: 10px 14px; font-size: 12px; font-weight: 700; color: #475569; border-bottom: 1.5px solid #e2e8f0; text-align: left; }
        td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

        .btn-submit { padding: 12px 24px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; border-radius: 10px; font-weight: 800; font-size: 14px; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.3); }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); }
        .btn-back { padding: 12px 20px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; border-radius: 10px; font-weight: 700; font-size: 13.5px; text-decoration: none; font-family: inherit; }
    </style>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <div class="page-title">
            <h1>Form Checklist Pemeriksaan Aset Akhir Bulan</h1>
            <p>Pilih ruangan / laboratorium yang akan diinspeksi, lalu periksa kondisi fisik masing-masing perangkat.</p>
        </div>
        <a href="{{ route('audits.index') }}" class="btn-back">Kembali</a>
    </div>

    <!-- FILTER RUANGAN / LOKASI -->
    <div class="card" style="background:#f8fafc;">
        <form method="GET" action="{{ route('audits.create') }}" style="display:grid; grid-template-columns: 1fr 1fr auto; gap:12px; align-items:flex-end;">
            <div>
                <label>Filter Lokasi / Ruangan</label>
                <select name="location_id" onchange="this.form.submit()">
                    <option value="">-- Pilih Lokasi / Lab --</option>
                    @foreach($locations as $l)
                    <option value="{{ $l->id }}" {{ $selectedLocationId == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Filter Penempatan (Kepemilikan)</label>
                <select name="placement_id" onchange="this.form.submit()">
                    <option value="">-- Semua Penempatan --</option>
                    @foreach($placements as $p)
                    <option value="{{ $p->id }}" {{ $selectedPlacementId == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" style="padding:10px 16px; background:#0369a1; color:#fff; border:none; border-radius:9px; font-weight:700; cursor:pointer;">Muat Aset</button>
            </div>
        </form>
    </div>

    @if($assets->count() > 0)
    <form method="POST" action="{{ route('audits.store') }}">
        @csrf
        <input type="hidden" name="location_id" value="{{ $selectedLocationId }}">
        <input type="hidden" name="placement_id" value="{{ $selectedPlacementId }}">

        <!-- INFORMASI BERITA ACARA -->
        <div class="card">
            <h3 style="font-size:15px; font-weight:800; color:#0c1a2e; margin-bottom:14px; border-bottom:1px solid #e2e8f0; padding-bottom:8px;">
                1. Data Berita Acara Pemeriksaan
            </h3>
            <div class="form-grid">
                <div style="grid-column: 1 / -1;">
                    <label>Judul Berita Acara / Pemeriksaan *</label>
                    <input type="text" name="title" required value="{{ old('title', 'Pemeriksaan Rutin Aset Laboratorium Komputer Akhir Bulan ' . date('F Y')) }}" placeholder="Contoh: Audit Aset Komputer Lab 1 & 2">
                </div>
                <div>
                    <label>Bulan Audit *</label>
                    <select name="audit_month" required>
                        @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label>Tahun Audit *</label>
                    <input type="number" name="audit_year" value="{{ date('Y') }}" required>
                </div>
                <div>
                    <label>Tanggal Pelaksanaan Inspeksi *</label>
                    <input type="date" name="audit_date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label>Pengesahan: Koordinator Labor Komputer *</label>
                    <input type="text" name="coordinator_name" value="{{ old('coordinator_name', 'Maulina Hilwa Salsabillah, S.Tr.T.') }}" required>
                </div>
            </div>
        </div>

        <!-- CHECKLIST ASET -->
        <div class="card">
            <h3 style="font-size:15px; font-weight:800; color:#0c1a2e; margin-bottom:4px;">
                2. Checklist Kondisi Fisik Perangkat ({{ $assets->count() }} Aset)
            </h3>
            <p style="font-size:12.5px; color:#64748b; margin-bottom:14px;">
                Periksa satu per satu kondisi fisik dan kelayakan fungsi perangkat di ruangan:
            </p>

            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">No</th>
                            <th>Kode & Nama Perangkat</th>
                            <th>Grup / Meja</th>
                            <th style="width:160px;">Kondisi Fisik</th>
                            <th style="width:160px;">Status Operasional</th>
                            <th>Catatan Temuan Inspeksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $index => $asset)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <input type="hidden" name="items[{{ $index }}][asset_id]" value="{{ $asset->id }}">
                                <strong style="color:#0c1a2e; font-size:13px;">{{ $asset->name }}</strong>
                                <div style="font-family:monospace; font-size:11px; color:#0369a1;">{{ $asset->asset_code }}</div>
                            </td>
                            <td>
                                @if($asset->group_code)
                                    <span style="font-size:11px; font-weight:700; background:#e0f2fe; color:#0369a1; padding:2px 6px; border-radius:4px;">{{ $asset->group_code }}</span>
                                @else
                                    <span style="color:#94a3b8; font-size:11.5px;">-</span>
                                @endif
                            </td>
                            <td>
                                <select name="items[{{ $index }}][condition]" style="padding:6px 8px; font-size:12px;">
                                    <option value="GOOD" {{ $asset->condition === 'GOOD' ? 'selected' : '' }}>Baik (Normal)</option>
                                    <option value="FAIR" {{ $asset->condition === 'FAIR' ? 'selected' : '' }}>Cukup (Layak)</option>
                                    <option value="POOR" {{ $asset->condition === 'POOR' ? 'selected' : '' }}>Kurang Baik</option>
                                    <option value="DAMAGED" {{ $asset->condition === 'DAMAGED' ? 'selected' : '' }}>Rusak Total</option>
                                </select>
                            </td>
                            <td>
                                <select name="items[{{ $index }}][status]" style="padding:6px 8px; font-size:12px;">
                                    <option value="ACTIVE" {{ $asset->status === 'ACTIVE' ? 'selected' : '' }}>Aktif (Siap Pakai)</option>
                                    <option value="MAINTENANCE" {{ $asset->status === 'MAINTENANCE' ? 'selected' : '' }}>Dalam Perawatan</option>
                                    <option value="DAMAGED" {{ $asset->status === 'DAMAGED' ? 'selected' : '' }}>Rusak</option>
                                    <option value="LOST" {{ $asset->status === 'LOST' ? 'selected' : '' }}>Hilang</option>
                                    <option value="RETIRED" {{ $asset->status === 'RETIRED' ? 'selected' : '' }}>Afkir</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $index }}][notes]" placeholder="Kabel kendor, tombol macet, dll (opsional)" style="padding:6px 8px; font-size:12px;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                <button type="submit" class="btn-submit">
                    Simpan Hasil Audit & Sahkan Berita Acara
                </button>
            </div>
        </div>
    </form>
    @else
    <div class="card" style="text-align:center; padding:48px 16px; color:#64748b;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#0369a1" stroke-width="1.5" style="margin-bottom:10px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <h3 style="color:#0c1a2e; font-size:16px; font-weight:800; margin-bottom:4px;">Pilih Ruangan untuk Diinspeksi</h3>
        <p style="font-size:13px;">Silakan pilih lokasi / laboratorium pada form filter di atas untuk memuat daftar perangkat yang akan diperiksa.</p>
    </div>
    @endif
</div>

</body>
</html>
