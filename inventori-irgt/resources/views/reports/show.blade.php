<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $report->report_number }} — Detail Laporan Maintenance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; -webkit-font-smoothing: antialiased; }
        .container { max-width: 1060px; margin: 0 auto; padding: 24px 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 3px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .page-title p { font-size: 13px; color: #64748b; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; transition: all 0.15s; }
        .btn-back:hover { background: #f8fafc; color: #0c1a2e; }

        .tracker-card { background: #fff; border-radius: 16px; padding: 20px 24px; border: 1px solid #e0f2fe; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .tracker-steps { display: flex; align-items: center; justify-content: space-between; position: relative; }
        .tracker-step { display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2; flex: 1; text-align: center; }
        .step-circle { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; background: #f1f5f9; color: #64748b; border: 2px solid #cbd5e1; margin-bottom: 6px; transition: all 0.2s; }
        .step-title { font-size: 12px; font-weight: 700; color: #64748b; line-height: 1.2; }
        .step-date { font-size: 10.5px; color: #94a3b8; margin-top: 2px; }

        .step-active .step-circle { background: #0369a1; color: #fff; border-color: #0369a1; box-shadow: 0 0 0 4px rgba(3,105,161,0.15); }
        .step-active .step-title { color: #0369a1; }
        .step-done .step-circle { background: #15803d; color: #fff; border-color: #15803d; }
        .step-done .step-title { color: #15803d; }
        .step-rejected .step-circle { background: #dc2626; color: #fff; border-color: #dc2626; }
        .step-rejected .step-title { color: #dc2626; }

        .tracker-line { position: absolute; top: 18px; left: 10%; right: 10%; height: 3px; background: #e2e8f0; z-index: 1; }
        .tracker-line-fill { height: 100%; background: #0369a1; transition: width 0.3s; }

        .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: #fff; border-radius: 16px; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #e0f2fe; margin-bottom: 20px; }
        .card-header-title { font-size: 14px; font-weight: 800; color: #0c1a2e; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1.5px solid #f0f9ff; padding-bottom: 10px; }

        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13px; gap: 10px; }
        .info-label { color: #64748b; font-weight: 600; font-size: 12.5px; }
        .info-val { color: #0c1a2e; font-weight: 700; text-align: right; word-break: break-word; }

        .desc-box { background: #f8fafc; border: 1.5px solid #e0f2fe; border-radius: 12px; padding: 14px; margin-top: 12px; font-size: 13px; color: #334155; line-height: 1.6; white-space: pre-wrap; }
        .photo-box { margin-top: 14px; border-radius: 12px; overflow: hidden; border: 1.5px solid #e0f2fe; max-width: 100%; text-align: center; background: #f8fafc; padding: 8px; }
        .photo-box img { max-width: 100%; max-height: 360px; object-fit: contain; border-radius: 8px; }

        .action-card { background: #fff; border: 2px solid #bae6fd; border-radius: 16px; padding: 22px; margin-bottom: 20px; }
        .btn-act-blue { background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; font-weight: 700; border: none; padding: 11px 18px; border-radius: 9px; cursor: pointer; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%; font-family: inherit; }
        .btn-act-green { background: linear-gradient(135deg, #22c55e, #15803d); color: #fff; font-weight: 700; border: none; padding: 11px 18px; border-radius: 9px; cursor: pointer; font-size: 13px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%; font-family: inherit; }
        .btn-act-red { background: #fee2e2; color: #b91c1c; border: 1.5px solid #fca5a5; font-weight: 700; padding: 9px 14px; border-radius: 9px; cursor: pointer; font-size: 12.5px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; width: 100%; font-family: inherit; }

        .cost-box { background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 16px; margin-top: 14px; }
        .cost-row { display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 6px; color: #166534; }
        .cost-total { display: flex; justify-content: space-between; font-size: 15px; font-weight: 800; padding-top: 8px; border-top: 1.5px dashed #86efac; color: #14532d; }

        @media (max-width: 860px) {
            .layout-grid { grid-template-columns: 1fr; }
            .container { padding: 16px 12px; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<!-- CONTAINER -->
<div class="container">
    <div class="page-header">
        <div class="page-title">
            <h1>
                <span>{{ $report->report_number }}</span>
                <x-badge-status :status="$report->status" />
            </h1>
            <p>Diajukan oleh <strong class="text-slate-800">{{ $report->reporter_name }}</strong> ({{ $report->reporter_department ?? 'Umum' }}) pada {{ $report->created_at->format('d M Y, H:i') }} WIB</p>
        </div>
        <a href="{{ route('reports.index') }}" class="btn-back">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <!-- PROGRESS TIMELINE STEP TRACKER -->
    <div class="tracker-card">
        @php
            $isPending = ($report->status === 'PENDING');
            $isInProgress = ($report->status === 'IN_PROGRESS');
            $isResolved = ($report->status === 'RESOLVED');
            $isRejected = ($report->status === 'REJECTED');
        @endphp
        <div class="tracker-steps">
            <div class="tracker-line">
                <div class="tracker-line-fill" style="width: {{ $isResolved ? '100%' : ($isInProgress ? '50%' : '0%') }}; {{ $isRejected ? 'background:#dc2626; width:100%;' : '' }}"></div>
            </div>

            <!-- STEP 1: LAPORAN DITERIMA -->
            <div class="tracker-step {{ $isPending ? 'step-active' : 'step-done' }}">
                <div class="step-circle">1</div>
                <div class="step-title">Laporan Diajukan</div>
                <div class="step-date">{{ $report->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <!-- STEP 2: PENANGANAN TEKNISI -->
            <div class="tracker-step {{ $isInProgress ? 'step-active' : ($isResolved ? 'step-done' : ($isRejected ? 'step-rejected' : '')) }}">
                <div class="step-circle">2</div>
                <div class="step-title">Penanganan Teknisi</div>
                <div class="step-date">{{ $report->handler ? $report->handler->name : 'Menunggu Tim IT' }}</div>
            </div>

            <!-- STEP 3: SELESAI / REJECTED -->
            <div class="tracker-step {{ $isResolved ? 'step-done' : ($isRejected ? 'step-rejected' : '') }}">
                <div class="step-circle">{{ $isRejected ? '✕' : '3' }}</div>
                <div class="step-title">{{ $isRejected ? 'Tiket Ditolak' : 'Selesai Diperbaiki' }}</div>
                <div class="step-date">{{ $report->resolved_at ? $report->resolved_at->format('d/m/Y H:i') : ($isRejected ? 'Dibatalkan' : '-') }}</div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="layout-grid">
        <!-- LEFT: DETAIL KENDALA & BIAYA -->
        <div>
            <!-- RINCIAN KENDALA -->
            <div class="card">
                <div class="card-header-title">
                    <span>Rincian Masalah / Kendala</span>
                    <span class="px-2.5 py-0.5 rounded text-xs font-bold {{ $report->priority_badge_class }}">
                        Prioritas: {{ $report->priority_label }}
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Judul Kendala:</span>
                    <span class="info-val" style="color:#0369a1; font-size:14px;">{{ $report->title }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Pelapor:</span>
                    <span class="info-val">{{ $report->reporter_name }} ({{ $report->reporter_department ?? '-' }})</span>
                </div>

                @if($report->reporter_phone)
                <div class="info-row">
                    <span class="info-label">Nomor Kontak:</span>
                    <span class="info-val">{{ $report->reporter_phone }}</span>
                </div>
                @endif

                <div style="margin-top: 14px;">
                    <span class="info-label">Deskripsi Lengkap Kendala:</span>
                    <div class="desc-box">{{ $report->description }}</div>
                </div>

                @if($report->photo_path)
                <div style="margin-top: 16px;">
                    <span class="info-label">Foto Bukti Kerusakan:</span>
                    <div class="photo-box">
                        <img src="{{ $report->photo_url }}" alt="Bukti Kendala">
                    </div>
                </div>
                @endif
            </div>

            <!-- BIAYA MAINTENANCE (COST TRACKER DISPLAY) -->
            <div class="card" style="border-left: 4px solid #10b981;">
                <div class="card-header-title">
                    <span class="flex items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-emerald-600"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Pencatatan Biaya Perbaikan (Maintenance Cost Tracker)
                    </span>
                    <span class="text-xs font-mono font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">
                        {{ $report->formatted_total_cost }}
                    </span>
                </div>

                <div class="cost-box">
                    <div class="cost-row">
                        <span>Biaya Jasa / Teknisi (Labour Cost):</span>
                        <strong>{{ $report->formatted_labour_cost }}</strong>
                    </div>
                    <div class="cost-row">
                        <span>Biaya Penggantian Komponen / Spare Part:</span>
                        <strong>{{ $report->formatted_spare_part_cost }}</strong>
                    </div>
                    <div class="cost-row">
                        <span>Biaya Tambahan Lainnya (Other Cost):</span>
                        <strong>{{ $report->formatted_other_cost }}</strong>
                    </div>
                    <div class="cost-total">
                        <span>TOTAL BIAYA MAINTENANCE:</span>
                        <span>{{ $report->formatted_total_cost }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-4 text-xs">
                    <div>
                        <span class="text-slate-500 font-medium">Vendor / Supplier:</span>
                        <p class="font-bold text-slate-800">{{ $report->vendor_name ?: 'Internal IT Team' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-500 font-medium">Nomor Nota / Invoice:</span>
                        <p class="font-bold font-mono text-slate-800">{{ $report->invoice_number ?: '-' }}</p>
                    </div>
                </div>

                @if($report->cost_notes)
                <div class="mt-3 text-xs text-slate-600">
                    <span class="text-slate-500 font-medium">Rincian Pembelian:</span>
                    <p class="bg-slate-50 p-2 rounded border border-slate-200 mt-1">{{ $report->cost_notes }}</p>
                </div>
                @endif
            </div>

            <!-- RESPONSE TEKNISI -->
            @if($report->technician_notes || $report->handler)
            <div class="card" style="border-left: 4px solid #0369a1;">
                <div class="card-header-title">
                    <span>Catatan & Solusi dari Teknisi IT</span>
                    @if($report->handler)
                    <span style="font-size:12px; color:#0369a1; font-weight:700;">Teknisi: {{ $report->handler->name }}</span>
                    @endif
                </div>

                @if($report->technician_notes)
                <div class="desc-box" style="background:#f0f9ff; border-color:#bae6fd; color:#0c4a6e;">
                    {{ $report->technician_notes }}
                </div>
                @endif

                @if($report->resolved_at)
                <div style="font-size:12px; color:#15803d; font-weight:700; margin-top:10px;">
                    Tindakan perbaikan diselesaikan pada: {{ $report->resolved_at->format('d M Y, H:i') }} WIB
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- RIGHT: ASSET INFO & TECHNICIAN ACTION -->
        <div>
            <!-- ASSET SUMMARY -->
            <div class="card">
                <div class="card-header-title">Perangkat Terkait</div>
                @if($report->asset)
                <div class="info-row">
                    <span class="info-label">Nama Aset:</span>
                    <span class="info-val">{{ $report->asset->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kode Aset:</span>
                    <span class="info-val font-mono text-sky-700">{{ $report->asset->asset_code }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Penempatan:</span>
                    <span class="info-val">{{ $report->asset->placement->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Lokasi:</span>
                    <span class="info-val">{{ $report->asset->location->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status Aset:</span>
                    <span class="info-val"><strong>{{ $report->asset->status }}</strong></span>
                </div>
                <div style="margin-top:14px; display:flex; flex-direction:column; gap:6px;">
                    @if(in_array(auth()->user()->role, ['super_admin','admin']))
                    <a href="{{ route('assets.history', $report->asset->id) }}" style="font-size:12px; font-weight:700; color:#0369a1; text-decoration:none;">
                        Buka Riwayat & Timeline Aset ➔
                    </a>
                    @endif
                    <a href="{{ route('asset.scan', $report->asset->qr_token) }}" target="_blank" style="font-size:12px; font-weight:600; color:#64748b; text-decoration:none;">
                        Halaman Publik Aset ➔
                    </a>
                </div>
                @else
                <p style="font-size:12.5px; color:#94a3b8;">Data aset telah dihapus.</p>
                @endif
            </div>

            <!-- TECHNICIAN ACTION PANEL (ADMIN & SUPER ADMIN ONLY) -->
            @if(in_array(auth()->user()->role, ['super_admin', 'admin']))
            <div class="action-card">
                <div class="card-header-title" style="color:#0369a1;">
                    Kelola Tiket & Input Biaya
                </div>

                @if($report->status === 'PENDING')
                <!-- ACTION: SET IN_PROGRESS -->
                <form method="POST" action="{{ route('reports.update-status', $report->id) }}" style="margin-bottom:12px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="IN_PROGRESS">
                    <button type="submit" class="btn-act-blue">
                        Mulai Kerjakan (Set In Progress)
                    </button>
                </form>

                <!-- ACTION: REJECT -->
                <form method="POST" action="{{ route('reports.update-status', $report->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="REJECTED">
                    <div style="margin-bottom:8px;">
                        <textarea name="technician_notes" placeholder="Alasan penolakan..." required style="width:100%; font-size:12px; min-height:60px; padding:8px; border-radius:8px; border:1px solid #cbd5e1;"></textarea>
                    </div>
                    <button type="submit" class="btn-act-red" onclick="return confirm('Tolak laporan tiket ini?')">
                        Tolak / Batalkan Tiket
                    </button>
                </form>

                @else
                <!-- ACTION: RESOLVE / UPDATE COSTS & SOLUSI -->
                <form method="POST" action="{{ route('reports.update-status', $report->id) }}" id="costForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="RESOLVED">
                    
                    <div class="space-y-3 mb-4">
                        <div>
                            <label style="font-size:11.5px; font-weight:700; color:#15803d; display:block; margin-bottom:3px;">Catatan Solusi / Perbaikan:</label>
                            <textarea name="technician_notes" placeholder="Contoh: Mengganti switch dan crimping ulang kabel LAN..." required style="width:100%; font-size:12px; min-height:60px; padding:8px; border-radius:8px; border:1px solid #cbd5e1;">{{ old('technician_notes', $report->technician_notes) }}</textarea>
                        </div>

                        <!-- INPUT BIAYA REALTIME -->
                        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl space-y-2">
                            <div class="text-xs font-bold text-emerald-800 uppercase tracking-wide">Pencatatan Biaya (Opsional)</div>
                            
                            <div>
                                <label class="text-[11px] font-semibold text-slate-600">Biaya Jasa / Servis (Rp)</label>
                                <input type="number" step="any" name="labour_cost" id="in_labour" value="{{ old('labour_cost', $report->labour_cost) }}" placeholder="0" class="w-full text-xs p-1.5 border border-slate-300 rounded cost-calc">
                            </div>

                            <div>
                                <label class="text-[11px] font-semibold text-slate-600">Biaya Spare Part / Komponen (Rp)</label>
                                <input type="number" step="any" name="spare_part_cost" id="in_spare" value="{{ old('spare_part_cost', $report->spare_part_cost) }}" placeholder="0" class="w-full text-xs p-1.5 border border-slate-300 rounded cost-calc">
                            </div>

                            <div>
                                <label class="text-[11px] font-semibold text-slate-600">Biaya Lainnya (Rp)</label>
                                <input type="number" step="any" name="other_cost" id="in_other" value="{{ old('other_cost', $report->other_cost) }}" placeholder="0" class="w-full text-xs p-1.5 border border-slate-300 rounded cost-calc">
                            </div>

                            <div class="pt-1.5 border-t border-emerald-300 flex justify-between items-center text-xs font-bold text-emerald-900">
                                <span>Estimasi Total:</span>
                                <span id="calc_total">Rp 0</span>
                            </div>

                            <div class="pt-2 border-t border-emerald-200 space-y-1.5">
                                <input type="text" name="vendor_name" value="{{ old('vendor_name', $report->vendor_name) }}" placeholder="Nama Toko / Vendor Pengadaan" class="w-full text-xs p-1.5 border border-slate-300 rounded">
                                <input type="text" name="invoice_number" value="{{ old('invoice_number', $report->invoice_number) }}" placeholder="No. Invoice / Kwitansi" class="w-full text-xs p-1.5 border border-slate-300 rounded">
                                <textarea name="cost_notes" placeholder="Rincian part (misal: SSD 512GB Kingston)..." class="w-full text-xs p-1.5 border border-slate-300 rounded" rows="2">{{ old('cost_notes', $report->cost_notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-act-green">
                        {{ $report->status === 'RESOLVED' ? 'Perbarui Catatan & Biaya' : 'Selesaikan Tiket (Mark as Resolved)' }}
                    </button>
                </form>

                @if($report->status !== 'REJECTED' && $report->status !== 'RESOLVED')
                <!-- ACTION: REJECT -->
                <form method="POST" action="{{ route('reports.update-status', $report->id) }}" style="margin-top:10px;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="REJECTED">
                    <button type="submit" class="btn-act-red" onclick="return confirm('Tolak/batalkan tiket ini?')">
                        Batalkan Pengerjaan (Reject)
                    </button>
                </form>
                @endif

                @endif

                <hr style="margin: 16px 0; border: none; border-top: 1px solid #e2e8f0;">
                <form method="POST" action="{{ route('reports.destroy', $report->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket #{{ $report->report_number }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; padding: 8px 12px; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; border-radius: 8px; font-size: 11.5px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                        Hapus Tiket Laporan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inLabour = document.getElementById('in_labour');
        const inSpare = document.getElementById('in_spare');
        const inOther = document.getElementById('in_other');
        const calcTotal = document.getElementById('calc_total');

        function updateTotal() {
            if (!inLabour || !inSpare || !inOther || !calcTotal) return;
            const labour = parseFloat(inLabour.value) || 0;
            const spare = parseFloat(inSpare.value) || 0;
            const other = parseFloat(inOther.value) || 0;
            const total = labour + spare + other;

            calcTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        if (inLabour && inSpare && inOther) {
            inLabour.addEventListener('input', updateTotal);
            inSpare.addEventListener('input', updateTotal);
            inOther.addEventListener('input', updateTotal);
            updateTotal();
        }
    });
</script>

</body>
</html>
