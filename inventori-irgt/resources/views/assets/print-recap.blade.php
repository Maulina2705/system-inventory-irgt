<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Data Inventaris — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f9ff;
            color: #0f172a;
            padding: 24px;
            font-size: 9.5pt;
            line-height: 1.35;
            -webkit-font-smoothing: antialiased;
        }

        .toolbar {
            max-width: 1180px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 14px 20px;
            border-radius: 12px;
            border: 1.5px solid #bae6fd;
            box-shadow: 0 4px 16px rgba(3, 105, 161, 0.06);
            flex-wrap: wrap;
            gap: 12px;
        }
        .toolbar h3 { font-size: 13.5pt; font-weight: 800; color: #0369a1; }
        .toolbar p { font-size: 9pt; color: #64748b; margin-top: 1px; }
        .btn-group { display: flex; gap: 8px; align-items: center; }
        .btn-action {
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 9.5pt;
            font-weight: 700;
            cursor: pointer;
            border: none;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-print { background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; box-shadow: 0 2px 8px rgba(3, 105, 161, 0.3); }
        .btn-print:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(3, 105, 161, 0.4); }
        .btn-back { background: #fff; color: #475569; border: 1.5px solid #cbd5e1; }
        .btn-back:hover { background: #f8fafc; color: #0f172a; }

        .tips-banner {
            max-width: 1180px;
            margin: 0 auto 16px auto;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 8.5pt;
            color: #1e40af;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sheet {
            max-width: 1180px;
            margin: 0 auto;
            background: #ffffff;
            padding: 28px 32px;
            border-radius: 12px;
            border: 1.5px solid #e0f2fe;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        }

        /* KOP SURAT RESMI DENGAN LOGO SEKOLAH */
        .kop-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2.5px solid #0c4a6e;
            padding-bottom: 12px;
            margin-bottom: 16px;
            gap: 16px;
        }
        .kop-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .kop-logo-img {
            width: 58px;
            height: 58px;
            object-fit: contain;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
        }
        .kop-text h1 {
            font-size: 13.5pt;
            font-weight: 800;
            color: #0c1a2e;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin: 0;
            line-height: 1.2;
        }
        .kop-text h2 {
            font-size: 10.5pt;
            font-weight: 700;
            color: #0369a1;
            margin: 2px 0 0 0;
            line-height: 1.2;
        }
        .kop-text p {
            font-size: 8pt;
            color: #64748b;
            margin-top: 2px;
            line-height: 1.2;
        }
        .kop-meta {
            text-align: right;
            font-size: 8.5pt;
            color: #475569;
            line-height: 1.4;
            flex-shrink: 0;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .report-title-box {
            text-align: center;
            margin: 14px 0 12px 0;
        }
        .report-title-box h2 {
            font-size: 12pt;
            font-weight: 800;
            color: #0c1a2e;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .report-title-box p {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 2px;
        }

        /* SUMMARY STATS */
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 14px;
        }
        .stat-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px;
            text-align: center;
        }
        .stat-box .val { font-size: 13pt; font-weight: 800; color: #0369a1; line-height: 1.2; }
        .stat-box .lbl { font-size: 7.5pt; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 2px; }

        /* FIXED TABLE DENGAN PERSENTASE LEBAR PROPORSIONAL */
        .table-responsive { width: 100%; overflow-x: auto; }
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 8pt;
            margin-top: 6px;
        }
        th {
            background: #f0f9ff;
            color: #0369a1;
            font-weight: 800;
            text-transform: uppercase;
            padding: 6px 6px;
            border: 1px solid #cbd5e1;
            text-align: left;
            font-size: 7.5pt;
            letter-spacing: 0.01em;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        td {
            padding: 5px 6px;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        tr:nth-child(even) td { background: #f8fafc; }

        /* KODE INVENTARIS: JETBRAINS MONO RAPAT & TAMPIL UTUH */
        .code-cell {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            color: #0369a1;
            font-size: 7.5pt;
            word-break: break-all;
            line-height: 1.2;
            display: block;
        }

        .sn-cell {
            font-family: 'JetBrains Mono', monospace;
            font-size: 7pt;
            color: #475569;
            word-break: break-all;
            line-height: 1.2;
        }

        .badge-status {
            font-weight: 800;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 7pt;
            display: inline-block;
            text-align: center;
        }
        .badge-ACTIVE { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-MAINTENANCE { background: #fef9c3; color: #a16207; border: 1px solid #fde68a; }
        .badge-DAMAGED { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .badge-LOST { background: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
        .badge-RETIRED { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .badge-BORROWED { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        /* SIGNATURE SECTION */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 28px;
            padding-top: 8px;
            page-break-inside: avoid;
        }
        .sign-box { text-align: center; width: 250px; }
        .sign-box .sign-title { font-size: 8.5pt; color: #475569; margin-bottom: 2px; }
        .sign-box .sign-role-top { font-size: 8.5pt; font-weight: 600; color: #334155; margin-bottom: 52px; }
        .sign-box .sign-name { font-weight: 800; font-size: 9pt; color: #0c1a2e; border-bottom: 1.5px solid #0c1a2e; padding-bottom: 2px; display: inline-block; min-width: 180px; }

        /* ATURAN KHUSUS PRINT & PDF A4 LANDSCAPE */
        @media print {
            @page {
                size: A4 landscape;
                margin: 7mm 6mm 7mm 6mm;
            }
            html, body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 7.5pt !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .toolbar, .tips-banner {
                display: none !important;
            }
            .sheet {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            table {
                table-layout: fixed !important;
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 7pt !important;
                page-break-inside: auto;
            }
            th {
                background: #f0f9ff !important;
                color: #0369a1 !important;
                padding: 4px 4px !important;
                font-size: 7pt !important;
                border: 1px solid #94a3b8 !important;
            }
            td {
                padding: 3.5px 4px !important;
                border: 1px solid #cbd5e1 !important;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            .signature-section {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div>
            <h3>Pratinjau Rekapitulasi Inventaris IRGT</h3>
            <p>Dokumen cetak landscape resmi siap cetak ke printer atau simpan sebagai PDF.</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('assets.index') }}" class="btn-action btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                <span>Kembali ke Sistem</span>
            </a>
            <button onclick="window.print()" class="btn-action btn-print">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <div class="tips-banner">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        <span><strong>Tips Cetak:</strong> Pastikan opsi Layout di dialog print browser Anda diatur ke <strong>Landscape (Mendatar)</strong> agar seluruh kolom tampil sempurna dan rapi.</span>
    </div>

    <div class="sheet">
        <!-- KOP SURAT RESMI -->
        <div class="kop-header">
            <div class="kop-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo IRGT" class="kop-logo-img">
                <div class="kop-text">
                    <h1>IRGT SCHOOL INVENTORY SYSTEM</h1>
                    <h2>SISTEM MANAJEMEN INVENTARIS & ASET IT</h2>
                    <p>Build 21st Century Skills Develop Great Generation • Care and Love</p>
                </div>
            </div>
            <div class="kop-meta">
                <div><strong>Tanggal:</strong> {{ date('d F Y') }}</div>
                <div><strong>Waktu Cetak:</strong> {{ date('H:i') }} WIB</div>
                <div><strong>Petugas:</strong> {{ auth()->check() ? auth()->user()->name : 'Admin IT' }}</div>
            </div>
        </div>

        <div class="report-title-box">
            <h2>Laporan Rekapitulasi Data Inventaris</h2>
            <p>Total Data Terdata: {{ $totalCount }} Unit Perangkat</p>
        </div>

        <div class="stats-summary">
            <div class="stat-box">
                <div class="val">{{ $totalCount }}</div>
                <div class="lbl">Total Inventaris</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color: #15803d;">{{ $activeCount }}</div>
                <div class="lbl">Status Aktif</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color: #d97706;">{{ $maintenanceCount }}</div>
                <div class="lbl">Dalam Perbaikan</div>
            </div>
            <div class="stat-box">
                <div class="val" style="color: #dc2626;">{{ $damagedCount }}</div>
                <div class="lbl">Rusak / Nonaktif</div>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 3.5%; text-align: center;">No</th>
                        <th style="width: 17%;">Kode Inventaris</th>
                        <th style="width: 16%;">Nama Perangkat</th>
                        <th style="width: 12%;">Merk / Model</th>
                        <th style="width: 11%;">Serial Number</th>
                        <th style="width: 14%;">Lokasi Ruangan</th>
                        <th style="width: 4.5%; text-align: center;">Thn</th>
                        <th style="width: 7.5%; text-align: center;">Status</th>
                        <th style="width: 6.5%; text-align: center;">Kondisi</th>
                        <th style="width: 8%;">Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $index => $asset)
                        <tr>
                            <td style="text-align: center; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <span class="code-cell">{{ $asset->asset_code }}</span>
                            </td>
                            <td style="font-weight: 700; color: #0c1a2e;">{{ $asset->name }}</td>
                            <td>{{ $asset->brand ?? '-' }} {{ $asset->model ? '('.$asset->model.')' : '' }}</td>
                            <td>
                                <span class="sn-cell">{{ $asset->serial_number ?? '-' }}</span>
                            </td>
                            <td>{{ $asset->location->name ?? '-' }} <span style="font-size: 7pt; color: #64748b;">({{ $asset->placement->name ?? '-' }})</span></td>
                            <td style="text-align: center;">{{ $asset->inventory_year }}</td>
                            <td style="text-align: center;">
                                <span class="badge-status badge-{{ $asset->status }}">{{ $asset->status }}</span>
                            </td>
                            <td style="text-align: center; font-size: 7.5pt; font-weight: 600;">{{ $asset->condition }}</td>
                            <td style="font-size: 7.5pt;">{{ $asset->assigned_to ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 20px; color: #64748b;">
                                Tidak ada data inventaris yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
