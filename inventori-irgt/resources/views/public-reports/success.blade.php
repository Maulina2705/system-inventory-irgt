<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pengaduan Terkirim — {{ $report->report_number }} | IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px 14px; -webkit-font-smoothing: antialiased; }

        .card { background: #fff; border-radius: 24px; padding: 32px 24px; max-width: 480px; width: 100%; box-shadow: 0 10px 40px rgba(3,105,161,0.1); border: 1.5px solid #e0f2fe; text-align: center; }

        .icon-success {
            width: 64px; height: 64px;
            background: #dcfce7;
            color: #15803d;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 4px 16px rgba(22,163,74,0.2);
        }

        h1 { font-size: 20px; font-weight: 800; color: #0c1a2e; margin-bottom: 6px; }
        .subtitle { font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 20px; }

        /* TICKET BOX */
        .ticket-box {
            background: #f8fafc;
            border: 2px dashed #0369a1;
            border-radius: 14px;
            padding: 16px 14px;
            margin-bottom: 20px;
            position: relative;
        }
        .ticket-label { font-size: 11px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; }
        .ticket-number { font-family: 'JetBrains Mono', monospace; font-size: 22px; font-weight: 800; color: #0c1a2e; letter-spacing: 0.04em; margin-bottom: 10px; word-break: break-all; }
        .btn-copy {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-copy:hover { background: #bae6fd; color: #075985; }

        /* INFO SUMMARY */
        .info-list { text-align: left; background: #f8fafc; border-radius: 12px; padding: 12px 14px; margin-bottom: 22px; font-size: 12.5px; border: 1px solid #e2e8f0; }
        .info-row { display: flex; justify-content: space-between; padding: 5px 0; }
        .info-row:not(:last-child) { border-bottom: 1px solid #f1f5f9; }
        .info-lbl { color: #64748b; }
        .info-val { color: #0c1a2e; font-weight: 700; }

        /* ACTIONS */
        .actions { display: flex; flex-direction: column; gap: 10px; }
        .btn-track {
            padding: 13px 20px;
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(3,105,161,0.3);
            transition: all 0.15s;
        }
        .btn-track:hover { background: linear-gradient(135deg, #0369a1, #075985); }
        .btn-home {
            padding: 11px 20px;
            background: #fff;
            color: #475569;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-home:hover { background: #f8fafc; color: #0c1a2e; }

        .footer-note { font-size: 11.5px; color: #94a3b8; margin-top: 20px; line-height: 1.5; }
    </style>
</head>
<body>

<div class="card">
    <div class="icon-success">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>

    <h1>Pengaduan Berhasil Terkirim!</h1>
    <p class="subtitle">
        Laporan kerusakan telah diterima oleh sistem dan masuk ke antrean penanganan Tim IT IRGT School.
    </p>

    <!-- TICKET NUMBER BOX -->
    <div class="ticket-box">
        <div class="ticket-label">Nomor Tiket Pengaduan Anda</div>
        <div class="ticket-number" id="ticket-text">{{ $report->report_number }}</div>
        <button type="button" class="btn-copy" onclick="copyTicket()">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            <span id="copy-btn-text">Salin Nomor Tiket</span>
        </button>
    </div>

    <!-- SUMMARY -->
    <div class="info-list">
        <div class="info-row">
            <span class="info-lbl">Perangkat:</span>
            <span class="info-val">{{ $asset->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-lbl">Pelapor:</span>
            <span class="info-val">{{ $report->reporter_name }} ({{ $report->reporter_department }})</span>
        </div>
        <div class="info-row">
            <span class="info-lbl">Kendala:</span>
            <span class="info-val">{{ $report->title }}</span>
        </div>
        <div class="info-row">
            <span class="info-lbl">Waktu Lapor:</span>
            <span class="info-val">{{ $report->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="actions">
        <a href="{{ route('public.reports.track', ['ticket' => $report->report_number]) }}" class="btn-track">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            Lacak Progress Tiket Ini
        </a>
        <a href="{{ route('asset.scan', $asset->qr_token) }}" class="btn-home">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
            Kembali ke Detail Perangkat
        </a>
    </div>

    <div class="footer-note">
        <strong>Tips:</strong> Simpan nomor tiket di atas. Anda dapat mengetik nomor tiket ini kapan saja di menu <strong>Lacak Tiket</strong> untuk melihat status dan catatan teknisi IT.
    </div>
</div>

<script>
function copyTicket() {
    const text = document.getElementById('ticket-text').innerText.trim();
    navigator.clipboard.writeText(text).then(() => {
        const btnText = document.getElementById('copy-btn-text');
        btnText.innerText = 'Tersalin!';
        setTimeout(() => {
            btnText.innerText = 'Salin Nomor Tiket';
        }, 2500);
    });
}
</script>

</body>
</html>
