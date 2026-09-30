<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Berita Acara Audit Laboratorium — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #0f172a; padding: 32px 20px; min-height: 100vh; }
        
        .no-print { max-width: 1000px; margin: 0 auto 24px; display: flex; justify-content: space-between; align-items: center; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; }
        .btn-print { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; background: #0369a1; color: #fff; border: none; cursor: pointer; font-family: inherit; }
        .btn-print:hover { background: #075985; }

        .document-page {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }

        /* KOP SURAT */
        .kop-surat { display: flex; align-items: center; gap: 20px; border-bottom: 3px double #0f172a; padding-bottom: 16px; margin-bottom: 24px; }
        .kop-logo { width: 64px; height: 64px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 26px; font-weight: 800; }
        .kop-text h2 { font-size: 18px; font-weight: 800; color: #0c1a2e; text-transform: uppercase; letter-spacing: 0.05em; }
        .kop-text h3 { font-size: 14px; font-weight: 700; color: #0369a1; text-transform: uppercase; margin: 2px 0; }
        .kop-text p { font-size: 11px; color: #64748b; line-height: 1.35; }

        .doc-title { text-align: center; margin-bottom: 24px; }
        .doc-title h1 { font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; color: #0c1a2e; text-decoration: underline; }
        .doc-title p { font-size: 12px; color: #475569; margin-top: 4px; }

        /* SUMMARY METRICS */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .summary-card { background: #f0f9ff; border: 1.5px solid #bae6fd; border-radius: 10px; padding: 12px; text-align: center; }
        .summary-val { font-size: 20px; font-weight: 800; color: #0369a1; }
        .summary-lbl { font-size: 11px; font-weight: 600; color: #475569; margin-top: 2px; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; font-size: 11.5px; margin-bottom: 32px; }
        th { background: #f1f5f9; color: #0c1a2e; font-weight: 700; text-align: left; padding: 8px 10px; border: 1px solid #cbd5e1; text-transform: uppercase; font-size: 10.5px; }
        td { padding: 8px 10px; border: 1px solid #e2e8f0; vertical-align: top; color: #334155; }
        tr:nth-child(even) td { background: #f8fafc; }

        .code-tag { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 700; color: #0369a1; }

        /* TANDA TANGAN */
        .signature-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px; page-break-inside: avoid; }
        .sig-box { text-align: center; font-size: 12px; }
        .sig-date { margin-bottom: 8px; color: #475569; }
        .sig-title { font-weight: 700; color: #0c1a2e; }
        .sig-space { height: 75px; }
        .sig-name { font-weight: 800; text-decoration: underline; color: #0c1a2e; }
        .sig-nip { font-size: 10.5px; color: #64748b; margin-top: 2px; }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none !important; }
            .document-page { box-shadow: none; border: none; padding: 0; max-width: 100%; }
            @page { size: A4 portrait; margin: 15mm 12mm 15mm 12mm; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('audits.index') }}" class="btn-back">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke Audit
    </a>
    <button class="btn-print" onclick="window.print()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        Cetak Dokumen / Simpan PDF
    </button>
</div>

<div class="document-page">

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="kop-logo">IT</div>
        <div class="kop-text">
            <h2>YAYASAN PENDIDIKAN IRGT SCHOOL</h2>
            <h3>UNIT LABORATORIUM KOMPUTER & INFRASTRUKTUR TEKNOLOGI INFORMASI</h3>
            <p>Jalan Pendidikan No. 101, Kompleks Kampus IRGT • Telp: (021) 789-0123 • Email: lab-it@irgt.sch.id</p>
        </div>
    </div>

    <!-- JUDUL LAPORAN -->
    <div class="doc-title">
        <h1>REKAPITULASI BERITA ACARA AUDIT & INVENTARISASI ASET</h1>
        <p>
            @if($filterYear || $filterMonth)
                Periode: {{ $filterMonth ? date('F', mktime(0, 0, 0, (int)$filterMonth, 10)) : '' }} {{ $filterYear ?? '' }}
            @else
                Arsip Seluruh Riwayat Pemeriksaan & Audit Aset Laboratorium
            @endif
            • Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </p>
    </div>

    <!-- STATISTIK RINGKAS -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-val">{{ $totalAudits }}</div>
            <div class="summary-lbl">Total Berita Acara Audit</div>
        </div>
        <div class="summary-card">
            <div class="summary-val" style="color: #15803d;">{{ $completedCount }}</div>
            <div class="summary-lbl">Berita Acara Disahkan</div>
        </div>
        <div class="summary-card">
            <div class="summary-val" style="color: #0284c7;">{{ $totalItemsInspected }}</div>
            <div class="summary-lbl">Total Unit Aset Diperiksa</div>
        </div>
    </div>

    <!-- TABEL REKAPITULASI -->
    <table>
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th>No. Berita Acara</th>
                <th>Judul Pemeriksaan</th>
                <th>Periode Audit</th>
                <th>Lokasi / Lab</th>
                <th>Pemeriksa (IT)</th>
                <th style="text-align: center;">Total Item</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($audits as $index => $audit)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><span class="code-tag">{{ $audit->audit_code }}</span></td>
                <td>
                    <strong>{{ $audit->title }}</strong>
                    <div style="font-size: 10px; color: #64748b;">Tgl: {{ $audit->audit_date ? $audit->audit_date->format('d/m/Y') : '-' }}</div>
                </td>
                <td>{{ date('F Y', mktime(0, 0, 0, $audit->audit_month, 10, $audit->audit_year)) }}</td>
                <td>{{ $audit->location->name ?? ($audit->placement->name ?? 'Semua Ruangan') }}</td>
                <td>{{ $audit->inspector_name ?? '-' }}</td>
                <td style="text-align: center; font-weight: 700;">{{ $audit->items->count() }} unit</td>
                <td>
                    <span style="font-size: 10px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 2px 6px; border-radius: 4px;">
                        ✓ Disahkan
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #94a3b8;">
                    Tidak ada data berita acara audit yang ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- LEMBAR PENGESAHAN -->
    <div class="signature-grid">
        <div class="sig-box">
            <div class="sig-date">&nbsp;</div>
            <div class="sig-title">Petugas Pemeriksa (Teknisi IT),</div>
            <div class="sig-space"></div>
            <div class="sig-name">{{ auth()->user()->name ?? 'Tim IT Lab' }}</div>
            <div class="sig-nip">IT Infrastructure & Support</div>
        </div>
        <div class="sig-box">
            <div class="sig-date">Jakarta, {{ now()->translatedFormat('d F Y') }}</div>
            <div class="sig-title">Koordinator Laboratorium Komputer,</div>
            <div class="sig-space"></div>
            <div class="sig-name">Koordinator Labor Komputer IRGT</div>
            <div class="sig-nip">NIP. 19850412 201001 1 008</div>
        </div>
    </div>

</div>

</body>
</html>
