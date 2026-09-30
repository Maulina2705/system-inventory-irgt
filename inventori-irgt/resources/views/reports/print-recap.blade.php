<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Laporan Maintenance — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #0f172a; padding: 20px; font-size: 11pt; line-height: 1.4; }

        .toolbar { max-width: 820px; margin: 0 auto 18px auto; display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 12px 18px; border-radius: 10px; border: 1px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .toolbar h3 { font-size: 13pt; font-weight: 800; color: #0369a1; }
        .toolbar p { font-size: 9.5pt; color: #64748b; margin-top: 1px; }
        .btn-group { display: flex; gap: 8px; }
        .btn-action { padding: 8px 16px; border-radius: 6px; font-size: 9.5pt; font-weight: 700; cursor: pointer; border: none; font-family: inherit; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; }
        .btn-print { background: #0369a1; color: #fff; }
        .btn-print:hover { background: #075985; }
        .btn-back { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .btn-back:hover { background: #e2e8f0; }

        .sheet { max-width: 820px; margin: 0 auto; background: #fff; padding: 28px 30px; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.03); }

        /* KOP SURAT */
        .kop-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #0369a1; padding-bottom: 12px; margin-bottom: 14px; }
        .kop-brand { display: flex; align-items: center; gap: 12px; }
        .kop-logo { width: 40px; height: 40px; background: #0369a1; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 14pt; }
        .kop-text h1 { font-size: 13pt; font-weight: 800; color: #0c1a2e; text-transform: uppercase; letter-spacing: 0.04em; }
        .kop-text p { font-size: 9pt; color: #64748b; margin-top: 1px; }
        .kop-meta { text-align: right; font-size: 8.5pt; color: #64748b; line-height: 1.4; }

        .report-title-box { text-align: center; margin: 14px 0 12px 0; }
        .report-title-box h2 { font-size: 12pt; font-weight: 800; color: #0c1a2e; text-transform: uppercase; letter-spacing: 0.04em; }
        .report-title-box p { font-size: 9pt; color: #64748b; margin-top: 2px; }

        /* SUMMARY STATS */
        .stats-summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 14px; }
        .stat-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 10px; text-align: center; }
        .stat-box .val { font-size: 13pt; font-weight: 800; color: #0369a1; }
        .stat-box .lbl { font-size: 8pt; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 1px; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 8.5pt; }
        th { background: #f0f9ff; color: #0369a1; font-weight: 800; text-transform: uppercase; padding: 6px 8px; border: 1px solid #cbd5e1; text-align: left; font-size: 8pt; letter-spacing: 0.02em; }
        td { padding: 6px 8px; border: 1px solid #e2e8f0; color: #334155; vertical-align: middle; }
        tr:nth-child(even) td { background: #f8fafc; }
        .code-cell { font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #0369a1; font-size: 8pt; white-space: nowrap; }

        .badge-status { font-weight: 700; padding: 1px 5px; border-radius: 3px; font-size: 7.5pt; display: inline-block; white-space: nowrap; }
        .badge-PENDING { background: #fef3c7; color: #b45309; }
        .badge-IN_PROGRESS { background: #e0f2fe; color: #0369a1; }
        .badge-RESOLVED { background: #dcfce7; color: #15803d; }
        .badge-REJECTED { background: #fee2e2; color: #b91c1c; }

        /* SIGNATURE */
        .signature-section { display: flex; justify-content: space-between; margin-top: 28px; padding-top: 8px; page-break-inside: avoid; }
        .sign-box { text-align: center; width: 240px; }
        .sign-box .sign-title { font-size: 9.5pt; color: #334155; margin-bottom: 2px; }
        .sign-box .sign-role-top { font-size: 9.5pt; font-weight: 600; color: #334155; margin-bottom: 60px; }
        .sign-box .sign-name { font-weight: 800; font-size: 10pt; color: #0c1a2e; border-bottom: 1.5px solid #0c1a2e; padding-bottom: 2px; display: inline-block; min-width: 180px; }

        @media print {
            body { background: #fff; padding: 0; font-size: 9pt; }
            .toolbar { display: none !important; }
            .sheet { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            table { page-break-inside: auto; width: 100%; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            .signature-section { page-break-inside: avoid; break-inside: avoid; }
            @page { size: A4 portrait; margin: 1.2cm 1cm; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div>
            <h3>Pratinjau Rekapitulasi Maintenance IRGT</h3>
            <p>Format dokumen cetak portrait resmi siap cetak atau simpan ke PDF.</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('reports.index') }}" class="btn-action btn-back">Kembali ke Sistem</a>
            <button onclick="window.print()" class="btn-action btn-print">Cetak / Simpan PDF</button>
        </div>
    </div>

    <div class="sheet">
        <div class="kop-header">
            <div class="kop-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo IRGT" style="width: 52px; height: 52px; object-fit: contain; flex-shrink: 0;">
                <div class="kop-text">
                    <h1>IRGT SCHOOL IT SUPPORT & MAINTENANCE</h1>
                    <p>Sistem Pengaduan Kendala dan Pemeliharaan Terpadu</p>
                </div>
            </div>
            <div class="kop-meta">
                <div><strong>Tanggal:</strong> {{ date('d F Y') }}</div>
                <div><strong>Waktu Cetak:</strong> {{ date('H:i') }} WIB</div>
            </div>
        </div>

        <div class="report-title-box">
            <h2>Laporan Rekapitulasi Tiket Maintenance</h2>
            <p>Total Tercatat: {{ $totalCount }} Tiket Pengaduan</p>
        </div>

        <div class="stats-summary">
            <div class="stat-box">
                <div class="val">{{ $totalCount }}</div>
                <div class="lbl">Total Tiket</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color: #d97706;">{{ $pendingCount }}</div>
                <div class="lbl">Menunggu Respon</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color: #0369a1;">{{ $inProgressCount }}</div>
                <div class="lbl">Sedang Dikerjakan</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color: #15803d;">{{ $resolvedCount }}</div>
                <div class="lbl">Selesai Diperbaiki</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 25px; text-align: center;">No</th>
                    <th>No. Tiket</th>
                    <th>Tgl</th>
                    <th>Kode & Nama Perangkat</th>
                    <th>Pelapor</th>
                    <th>Kendala / Kerusakan</th>
                    <th style="text-align: center;">Status</th>
                    <th>Teknisi & Solusi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $index => $r)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td class="code-cell">{{ $r->report_number }}</td>
                        <td style="white-space: nowrap;">{{ $r->created_at ? $r->created_at->format('d/m/Y') : '-' }}</td>
                        <td>
                            <strong style="color: #0c1a2e;">{{ $r->asset->name ?? '-' }}</strong><br>
                            <span style="font-size: 7.5pt; color: #64748b;">{{ $r->asset->asset_code ?? '-' }}</span>
                        </td>
                        <td>
                            {{ $r->reporter_name }}<br>
                            <span style="font-size: 7.5pt; color: #64748b;">{{ $r->reporter_department ?? '-' }}</span>
                        </td>
                        <td>
                            <strong>{{ $r->title }}</strong><br>
                            <span style="font-size: 7.5pt; color: #64748b;">{{ Str::limit($r->description, 50) }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-status badge-{{ $r->status }}">{{ str_replace('_', ' ', $r->status) }}</span>
                        </td>
                        <td>
                            @if($r->handler)
                                <strong>{{ $r->handler->name }}</strong><br>
                                <span style="font-size: 7.5pt; color: #64748b;">{{ Str::limit($r->technician_notes, 40) ?? '-' }}</span>
                            @else
                                <span style="color: #94a3b8;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 16px; color: #64748b;">
                            Tidak ada data tiket maintenance yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- SIGNATURE BLOCK -->
        <div class="signature-section">
            <div class="sign-box">
                <div class="sign-title">Mengetahui,</div>
                <div class="sign-role-top">Kepala Yayasan</div>
                <div class="sign-name">Drs. JASMAN JAIMAN, M.Ed</div>
            </div>
            <div class="sign-box">
                <div class="sign-title">Dicetak dan Diverifikasi Oleh:</div>
                <div class="sign-role-top">Kepala Laboratorium IRGT School,</div>
                <div class="sign-name">Maulina Hilwa Salsabillah, S.Tr.T.</div>
            </div>
        </div>
    </div>

</body>
</html>
