<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemeriksaan & Diagnostik CCTV — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }
        .container { max-width: 900px; margin: 0 auto; padding: 24px 16px 60px; }
        .card { background: #fff; border-radius: 16px; border: 1.5px solid #e0f2fe; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; }
        .page-title p { font-size: 13.5px; color: #64748b; margin-top: 2px; }

        .section-box { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 18px; }
        .section-header { font-size: 14px; font-weight: 800; color: #0369a1; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }

        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; }
        label { display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 1.5px solid #cbd5e1; border-radius: 9px; font-size: 13px; font-family: inherit; background: #fff; outline: none; }
        input:focus, select:focus, textarea:focus { border-color: #0369a1; }

        .btn-submit { padding: 12px 24px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; border-radius: 10px; font-weight: 800; font-size: 14px; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.3); }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); }
        .btn-back { padding: 10px 18px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; border-radius: 9px; font-weight: 700; font-size: 13px; text-decoration: none; }
    </style>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <div class="page-title">
            <h1>Form Checklist Diagnostik CCTV</h1>
            <p>Pemeriksaan mendalam 3 pilar: Jaringan (Koneksi & Ping), Fisik (Lensa & Bracket), dan Memori (Kapasitas & Status Rekaman).</p>
        </div>
        <a href="{{ route('cctv.index') }}" class="btn-back">Kembali</a>
    </div>

    <form method="POST" action="{{ route('cctv.store') }}">
        @csrf

        <div class="card">
            <!-- 1. IDENTITAS CCTV -->
            <div class="section-box">
                <div class="section-header">1. Identitas Unit CCTV & Tanggal Cek</div>
                <div class="form-grid">
                    <div style="grid-column: 1 / -1;">
                        <label>Pilih Unit CCTV yang Diperiksa *</label>
                        <select name="asset_id" required>
                            <option value="">-- Pilih Unit CCTV --</option>
                            @foreach($cctvAssets as $cAsset)
                            <option value="{{ $cAsset->id }}" {{ (old('asset_id', $selectedAsset->id ?? null) == $cAsset->id) ? 'selected' : '' }}>
                                [{{ $cAsset->asset_code }}] {{ $cAsset->name }} — {{ $cAsset->location->name ?? 'Tanpa Lokasi' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Tanggal Pemeriksaan *</label>
                        <input type="date" name="check_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <!-- 2. PEMERIKSAAN KONEKSI JARINGAN -->
            <div class="section-box">
                <div class="section-header">2. Pemeriksaan Koneksi Jaringan & Video Stream</div>
                <div class="form-grid">
                    <div>
                        <label>Status Jaringan *</label>
                        <select name="network_status" required>
                            <option value="ONLINE">ONLINE (Terhubung Normal)</option>
                            <option value="UNSTABLE">UNSTABLE (Sering RTO / Putus-putus)</option>
                            <option value="OFFLINE">OFFLINE (Mati / Tidak Terdeteksi)</option>
                        </select>
                    </div>
                    <div>
                        <label>IP Address Kamera</label>
                        <input type="text" name="ip_address" value="{{ old('ip_address', $selectedAsset->ip_address ?? '') }}" placeholder="Contoh: 192.168.1.150">
                    </div>
                    <div>
                        <label>Latency / Ping (ms)</label>
                        <input type="number" name="ping_ms" placeholder="Contoh: 8">
                    </div>
                    <div>
                        <label>Kualitas Video Stream *</label>
                        <select name="stream_status" required>
                            <option value="OK">OK (Lancar & Jernih)</option>
                            <option value="LAG">LAG / Patah-patah</option>
                            <option value="FLICKER">FLICKER (Garis-garis / Glitch)</option>
                            <option value="NO_VIDEO">NO VIDEO (Layar Hitam)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 3. PEMERIKSAAN FISIK & OPTIK -->
            <div class="section-box">
                <div class="section-header">3. Pemeriksaan Kondisi Fisik, Lensa & Night Vision</div>
                <div class="form-grid">
                    <div>
                        <label>Kondisi Fisik & Lensa *</label>
                        <select name="physical_condition" required>
                            <option value="CLEAN">CLEAN (Bersih & Normal)</option>
                            <option value="DIRTY_LENS">DIRTY LENS (Lensa Berdebu/Sarang Laba-laba)</option>
                            <option value="BLURRY">BLURRY (Fokus Kabur)</option>
                            <option value="LOOSE_BRACKET">LOOSE BRACKET (Dudukan / Bracket Kendor)</option>
                            <option value="WATER_DAMAGE">WATER DAMAGE (Kemungkinan Lembap/Kemasukan Air)</option>
                            <option value="DAMAGED">DAMAGED (Fisik Pecah / Rusak Total)</option>
                        </select>
                    </div>
                    <div>
                        <label>Night Vision / Infra-Red *</label>
                        <select name="night_vision_status" required>
                            <option value="OK">OK (Bekerja Normal Saat Gelap)</option>
                            <option value="FAIL">FAIL (LED IR Mati / Gelap Gulita)</option>
                            <option value="NOT_APPLICABLE">Tidak Memiliki IR</option>
                        </select>
                    </div>
                    <div>
                        <label>Fungsi Gerak PTZ (Pan-Tilt-Zoom) *</label>
                        <select name="ptz_function" required>
                            <option value="NOT_APPLICABLE">Bukan Tipe PTZ (Fixed Camera)</option>
                            <option value="NORMAL">NORMAL (Bisa Berputar & Zoom)</option>
                            <option value="STUCK">STUCK (Macet / Motor Rusak)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 4. PEMERIKSAAN MEMORI & PENYIMPANAN -->
            <div class="section-box">
                <div class="section-header">4. Pemeriksaan Memori & Status Rekaman</div>
                <div class="form-grid">
                    <div>
                        <label>Media Penyimpanan Rekaman *</label>
                        <select name="storage_type" required>
                            <option value="NVR_HDD">HDD NVR Pusat</option>
                            <option value="SD_CARD">MicroSD Card Internal</option>
                            <option value="CLOUD">Cloud Storage</option>
                            <option value="NONE">Tanpa Penyimpanan (Live View Only)</option>
                        </select>
                    </div>
                    <div>
                        <label>Status Perekaman (Recording) *</label>
                        <select name="storage_status" required>
                            <option value="RECORDING_NORMAL">RECORDING NORMAL (Merekam Lancar)</option>
                            <option value="OVERFLOW_ERROR">OVERFLOW ERROR (Tidak Auto-Overwrite)</option>
                            <option value="CORRUPT">CORRUPT (File Rekaman Tidak Bisa Diputar)</option>
                            <option value="UNFORMATTED">UNFORMATTED (Memori Minta Diformat)</option>
                            <option value="NO_STORAGE">NO STORAGE (Memori Rusak/Tidak Terdeteksi)</option>
                        </select>
                    </div>
                    <div>
                        <label>Kapasitas Storage (GB)</label>
                        <input type="number" name="storage_capacity_gb" placeholder="Contoh: 128 atau 2000">
                    </div>
                    <div>
                        <label>Retensi Hari Rekaman (Hari)</label>
                        <input type="number" name="days_retained" placeholder="Contoh: 14 atau 30">
                    </div>
                </div>
            </div>

            <!-- 5. KESIMPULAN DIAGNOSTIK -->
            <div class="section-box" style="background:#fffbeb; border-color:#fde68a;">
                <div class="section-header" style="color:#b45309;">5. Kesimpulan Diagnostik & Rekomendasi</div>
                <div class="form-grid">
                    <div>
                        <label>Kesimpulan Pemeriksaan *</label>
                        <select name="overall_verdict" required>
                            <option value="NORMAL">NORMAL (Siap Beroperasi)</option>
                            <option value="NEED_MAINTENANCE">BUTUH MAINTENANCE (Pembersihan / Setting Ulang)</option>
                            <option value="REPLACE_DEVICE">REPLACE DEVICE (Perlu Ganti Unit / Memori)</option>
                        </select>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label>Catatan Teknisi / Tindakan Lanjutan</label>
                        <textarea name="notes" rows="2" placeholder="Catatan perbaikan atau pembersihan lensa yang dilakukan..."></textarea>
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="submit" class="btn-submit">
                    Simpan Hasil Diagnostik CCTV
                </button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
