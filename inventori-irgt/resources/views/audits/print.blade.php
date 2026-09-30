<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Pemeriksaan Aset - {{ $audit->audit_code }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; color: #000; line-height: 1.4; padding: 1.5cm; }

        .toolbar { margin-bottom: 20px; font-family: sans-serif; display: flex; justify-content: flex-end; gap: 8px; }
        .btn-print { padding: 8px 16px; background: #0369a1; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }

        /* KOP SURAT */
        .kop { text-align: center; border-bottom: 2.5px double #000; padding-bottom: 8px; margin-bottom: 18px; }
        .kop h2 { font-size: 15pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; }
        .kop h3 { font-size: 13pt; font-weight: bold; margin: 2px 0; }
        .kop p { font-size: 9.5pt; font-style: italic; }

        .doc-title { text-align: center; font-size: 13pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-bottom: 4px; }
        .doc-number { text-align: center; font-size: 10.5pt; margin-bottom: 16px; }

        .meta-table { width: 100%; margin-bottom: 14px; font-size: 10.5pt; }
        .meta-table td { padding: 3px 0; vertical-align: top; }

        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; font-size: 9.5pt; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        table.data-table th { background: #f2f2f2; text-align: center; font-weight: bold; }
        table.data-table tr { page-break-inside: avoid; }

        /* TANDA TANGAN */
        .signature-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-table td { width: 50%; vertical-align: top; text-align: center; font-size: 10.5pt; }
        .sig-space { height: 75px; }

        @media print {
            body { padding: 0; }
            .toolbar { display: none !important; }
            @page { size: A4 portrait; margin: 1.2cm 1cm; }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <button onclick="window.print()" class="btn-print">Cetak Dokumen (Print)</button>
</div>

<!-- KOP SURAT FORMAL -->
<div class="kop">
    <h2>YAYASAN PENDIDIKAN IRGT SCHOOL</h2>
    <h3>UNIT PENGELOLA LABORATORIUM KOMPUTER & TEKNOLOGI INFORMASI</h3>
    <p>Jl. IRGT School No. 1, Kota • Telp: (021) 123456 • Email: it.inventory@irgtschool.sch.id</p>
</div>

<div class="doc-title">BERITA ACARA PEMERIKSAAN DAN AUDIT ASET LAB</div>
<div class="doc-number">Nomor: {{ $audit->audit_code }}/BA-AUDIT/IRGT/{{ date('m/Y', strtotime($audit->audit_date)) }}</div>

<p style="text-align: justify; margin-bottom: 10px; font-size: 10.5pt;">
    Pada hari ini, tanggal <strong>{{ $audit->audit_date->translatedFormat('d F Y') }}</strong>, telah dilaksanakan kegiatan pemeriksaan fisik, uji fungsi, dan verifikasi kelayakan seluruh perangkat inventaris aset teknologi informasi di lingkungan <strong>{{ $audit->location->name ?? 'Laboratorium Komputer IRGT School' }}</strong> dengan rincian hasil pemeriksaan sebagai berikut:
</p>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 30px;">No</th>
            <th style="width: 130px;">Kode Inventaris</th>
            <th>Nama Perangkat / Aset</th>
            <th style="width: 80px;">Grup / Meja</th>
            <th style="width: 80px;">Kondisi</th>
            <th style="width: 80px;">Status</th>
            <th>Catatan Temuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($audit->items as $idx => $item)
        <tr>
            <td style="text-align: center;">{{ $idx + 1 }}</td>
            <td style="font-family: monospace; font-weight: bold;">{{ $item->asset->asset_code ?? '-' }}</td>
            <td><strong>{{ $item->asset->name ?? '-' }}</strong></td>
            <td style="text-align: center;">{{ $item->asset->group_code ?? '-' }}</td>
            <td style="text-align: center;">{{ $item->condition }}</td>
            <td style="text-align: center;">{{ $item->status }}</td>
            <td>{{ $item->notes ?? 'Normal' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="font-size: 10.5pt; margin-bottom: 8px;">
    Demikian Berita Acara Pemeriksaan dan Audit Aset ini dibuat dengan sebenarnya sesuai kondisi fisik di lapangan untuk dipergunakan sebagaimana mestinya.
</p>

<!-- TANDA TANGAN PENGESAHAN -->
<div class="signature-section">
    <table class="sig-table">
        <tr>
            <td>
                Petugas Pemeriksa IT,<br>
                <div class="sig-space"></div>
                <strong><u>{{ $audit->inspector_name }}</u></strong><br>
                Tim IT & Aset IRGT
            </td>
            <td>
                Mengetahui & Mengesahkan,<br>
                <strong>Koordinator Labor Komputer IRGT</strong><br>
                <div class="sig-space"></div>
                <strong><u>{{ $audit->coordinator_name }}</u></strong><br>
                Kepala Laboratorium IRGT School
            </td>
        </tr>
    </table>
</div>

</body>
</html>
