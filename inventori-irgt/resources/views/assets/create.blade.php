<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Inventaris - IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; color: #1e293b; min-height: 100vh; }
        .container { max-width: 980px; margin: 0 auto; padding: 28px 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; }
        .page-title h1 { font-size: 22px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; }
        .page-title p { font-size: 13px; color: #64748b; margin-top: 2px; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; text-decoration: none; font-weight: 600; font-size: 13px; background: #fff; color: #475569; border: 1.5px solid #cbd5e1; transition: all 0.15s; }
        .btn-back:hover { background: #f8fafc; color: #0c1a2e; }

        .card { background: #fff; border-radius: 18px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .section-box { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 20px; margin-bottom: 20px; }
        .section-header { font-size: 14px; font-weight: 800; color: #0369a1; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .form-grid.grid-3 { grid-template-columns: repeat(3, 1fr); }
        .form-grid.grid-4 { grid-template-columns: repeat(4, 1fr); }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.full { grid-column: 1 / -1; }

        label { font-size: 12px; font-weight: 700; color: #334155; }
        .required { color: #e11d48; }

        input, select, textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #cbd5e1;
            border-radius: 9px;
            font-size: 13px;
            font-family: inherit;
            color: #0c1a2e;
            background: #fff;
            transition: all 0.15s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }
        textarea { resize: vertical; min-height: 70px; }

        .spec-dynamic-box {
            background: linear-gradient(180deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1.5px solid #7dd3fc;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.25s ease;
        }

        .form-actions { display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1.5px solid #e2e8f0; }
        .btn-submit { display: inline-flex; align-items: center; gap: 8px; padding: 11px 24px; border-radius: 10px; font-weight: 700; font-size: 13.5px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.35); transition: all 0.15s; }
        .btn-submit:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        @media (max-width: 768px) {
            .form-grid, .form-grid.grid-3, .form-grid.grid-4 { grid-template-columns: 1fr; }
            .card { padding: 18px 14px; }
            .form-actions { flex-direction: column; }
            .btn-submit, .btn-back { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- Unified Navbar -->
    @include('partials.navbar')

    <div class="container">
        <div class="page-header">
            <div class="page-title">
                <h1>Tambah Inventaris Baru</h1>
                <p>Klasifikasikan perangkat dan sesuaikan spesifikasi teknis berdasarkan jenis barang.</p>
            </div>
            <a href="{{ route('assets.index') }}" class="btn-back">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if($errors->any())
            <x-alert type="error">
                <p class="font-bold mb-1">Gagal menyimpan data inventaris:</p>
                <ul class="list-disc list-inside text-xs">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <div class="card">
            <form action="{{ route('assets.store') }}" method="POST" id="assetForm">
                @csrf

                <!-- SEKSI 1: IDENTITAS DASAR & KLASIFIKASI -->
                <div class="section-box">
                    <div class="section-header">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        1. Identitas & Klasifikasi Aset
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nama Perangkat / Aset <span class="required">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Komputer Siswa Lab 1 / Projector Epson Kelas 8" required>
                        </div>

                        <div class="form-group">
                            <label for="year">Tahun Pendataan <span class="required">*</span></label>
                            <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="placement_id">Penempatan <span class="required">*</span></label>
                            <select name="placement_id" id="placement_id" required>
                                <option value="">-- Pilih Penempatan --</option>
                                @foreach($placements as $p)
                                    <option value="{{ $p->id }}" @selected(old('placement_id') == $p->id)>{{ $p->code }} - {{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="location_id">Lokasi Ruangan <span class="required">*</span></label>
                            <select name="location_id" id="location_id" required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}" @selected(old('location_id') == $loc->id)>{{ $loc->code }} - {{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asset_type_id">Kategori Aset <span class="required">*</span></label>
                            <select name="asset_type_id" id="asset_type_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($assetTypes as $at)
                                    <option value="{{ $at->id }}" data-code="{{ $at->code }}" @selected(old('asset_type_id') == $at->id)>{{ $at->code }} - {{ $at->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asset_item_id">Jenis Barang <span class="required">*</span></label>
                            <select name="asset_item_id" id="asset_item_id" required>
                                <option value="">-- Pilih Jenis Barang --</option>
                                @foreach($assetItems as $ai)
                                    <option value="{{ $ai->id }}" data-code="{{ $ai->code }}" data-name="{{ strtolower($ai->name) }}" @selected(old('asset_item_id') == $ai->id)>{{ $ai->code }} - {{ $ai->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: KONDISIONAL SPESIFIKASI TEKNIS BERDASARKAN JENIS BARANG -->
                <div id="specContainer" class="spec-dynamic-box">
                    <div class="section-header" style="color: #0284c7;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <span id="specTitle">2. Spesifikasi Teknis Perangkat</span>
                    </div>

                    <!-- PANDUAN BANNER DINAMIS -->
                    <p id="specHelper" class="text-xs text-slate-600 mb-3">Field spesifikasi teknis disesuaikan otomatis dengan jenis aset yang dipilih.</p>

                    <!-- BLOK SPESIFIKASI DINAMIS -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="brand">Merek / Brand</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand') }}" placeholder="Contoh: Asus, Lenovo, Epson, MikroTik, Hikvision">
                        </div>

                        <div class="form-group">
                            <label for="model">Model / Seri</label>
                            <input type="text" name="model" id="model" value="{{ old('model') }}" placeholder="Contoh: ThinkCentre M70 / EB-X500 / RB750Gr3">
                        </div>

                        <div class="form-group">
                            <label for="serial_number">Nomor Seri (Serial Number) <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span></label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" placeholder="Kosongkan jika tidak terdapat Serial Number">
                        </div>

                        <div class="form-group">
                            <label for="assigned_to">Pengguna / Penanggung Jawab</label>
                            <input type="text" name="assigned_to" id="assigned_to" value="{{ old('assigned_to') }}" placeholder="Contoh: Guru / Siswa / Lab 1 / Koordinator">
                        </div>

                        <!-- FIELD KHUSUS COMPUTER / LAPTOP / SERVER -->
                        <div class="form-group spec-field spec-computer">
                            <label for="spec_processor">Processor (CPU)</label>
                            <input type="text" name="specifications[processor]" id="spec_processor" value="{{ old('specifications.processor') }}" placeholder="Contoh: Intel Core i5-12400 / AMD Ryzen 5">
                        </div>

                        <div class="form-group spec-field spec-computer">
                            <label for="spec_ram">Kapasitas RAM</label>
                            <input type="text" name="specifications[ram]" id="spec_ram" value="{{ old('specifications.ram') }}" placeholder="Contoh: 16 GB DDR4 / 8 GB">
                        </div>

                        <div class="form-group spec-field spec-computer">
                            <label for="spec_storage">Storage / Penyimpanan</label>
                            <input type="text" name="specifications[storage]" id="spec_storage" value="{{ old('specifications.storage') }}" placeholder="Contoh: 512 GB NVMe SSD + 1 TB HDD">
                        </div>

                        <div class="form-group spec-field spec-computer">
                            <label for="spec_os">Sistem Operasi (OS)</label>
                            <input type="text" name="specifications[os]" id="spec_os" value="{{ old('specifications.os') }}" placeholder="Contoh: Windows 11 Pro 64-bit / Ubuntu 24.04 LTS">
                        </div>

                        <div class="form-group spec-field spec-laptop">
                            <label for="spec_battery">Kondisi Baterai (Laptop)</label>
                            <input type="text" name="specifications[battery_condition]" id="spec_battery" value="{{ old('specifications.battery_condition') }}" placeholder="Contoh: Normal (Health 92%) / Perlu Ganti">
                        </div>

                        <div class="form-group spec-field spec-server">
                            <label for="spec_hostname">Hostname Server</label>
                            <input type="text" name="specifications[hostname]" id="spec_hostname" value="{{ old('specifications.hostname') }}" placeholder="Contoh: srv-db-primary.irgt.local">
                        </div>

                        <!-- FIELD KHUSUS NETWORK DEVICE -->
                        <div class="form-group spec-field spec-network">
                            <label for="spec_port_count">Jumlah Port (Port Count)</label>
                            <input type="text" name="specifications[port_count]" id="spec_port_count" value="{{ old('specifications.port_count') }}" placeholder="Contoh: 24 Port Gigabit PoE + 4 SFP">
                        </div>

                        <div class="form-group spec-field spec-network">
                            <label for="spec_firmware">Versi Firmware / RouterOS</label>
                            <input type="text" name="specifications[firmware_version]" id="spec_firmware" value="{{ old('specifications.firmware_version') }}" placeholder="Contoh: RouterOS v7.14 / SwitchOS 2.13">
                        </div>

                        <!-- FIELD KHUSUS CCTV -->
                        <div class="form-group spec-field spec-cctv">
                            <label for="spec_resolution_cctv">Resolusi Kamera CCTV</label>
                            <input type="text" name="specifications[resolution]" id="spec_resolution_cctv" value="{{ old('specifications.resolution') }}" placeholder="Contoh: 4 MP (2560x1440) / 1080p Full HD">
                        </div>

                        <div class="form-group spec-field spec-cctv">
                            <label for="spec_camera_type">Tipe Kamera CCTV</label>
                            <select name="specifications[camera_type]" id="spec_camera_type">
                                <option value="">-- Pilih Tipe Kamera --</option>
                                <option value="Dome Indoor">Dome (Indoor)</option>
                                <option value="Bullet Outdoor">Bullet (Outdoor)</option>
                                <option value="PTZ (Pan-Tilt-Zoom)">PTZ (Pan-Tilt-Zoom)</option>
                                <option value="Fisheye 360">Fisheye 360°</option>
                            </select>
                        </div>

                        <!-- FIELD KHUSUS PROJECTOR -->
                        <div class="form-group spec-field spec-projector">
                            <label for="spec_resolution_proj">Resolusi Proyektor</label>
                            <input type="text" name="specifications[resolution]" id="spec_resolution_proj" value="{{ old('specifications.resolution') }}" placeholder="Contoh: WXGA (1280x800) / Full HD 1080p">
                        </div>

                        <div class="form-group spec-field spec-projector">
                            <label for="spec_lamp_hours">Jam Pemakaian Lampu (Lamp Hours)</label>
                            <input type="text" name="specifications[lamp_hours]" id="spec_lamp_hours" value="{{ old('specifications.lamp_hours') }}" placeholder="Contoh: 450 Jam / 3000 Jam Max">
                        </div>

                        <div class="form-group spec-field spec-projector">
                            <label for="spec_connectivity">Konektivitas Port</label>
                            <input type="text" name="specifications[connectivity]" id="spec_connectivity" value="{{ old('specifications.connectivity') }}" placeholder="Contoh: 2x HDMI, 1x VGA, Wireless Screen Mirroring">
                        </div>

                        <!-- FIELD IP & MAC ADDRESS (Hanya muncul jika Computer, Network, Server, CCTV) -->
                        <div class="form-group spec-field spec-ip">
                            <label for="ip_address">Alamat IP (IP Address)</label>
                            <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}" placeholder="Contoh: 192.168.10.45">
                        </div>

                        <div class="form-group spec-field spec-mac">
                            <label for="mac_address">MAC Address</label>
                            <input type="text" name="mac_address" id="mac_address" value="{{ old('mac_address') }}" placeholder="Contoh: 00:1A:2B:3C:4D:5E">
                        </div>

                        <!-- GROUPING BUNDLE MEJA (Optional) -->
                        <div class="form-group full" style="background:#fff; border:1px solid #bae6fd; padding:12px; border-radius:10px; margin-top:6px;">
                            <div style="font-weight:700; font-size:12.5px; color:#0369a1; margin-bottom:2px;">
                                Bundel 1 QR Code Meja Siswa / Walas (Opsional)
                            </div>
                            <p style="font-size:11.5px; color:#64748b; margin-bottom:8px;">
                                Hubungkan perangkat ke grup meja (PC + Monitor + Keyboard + Mouse) agar dapat dipindai bersamaan.
                            </p>
                            <div class="form-grid">
                                <div>
                                    <label for="group_code" style="font-size:11.5px;">Kode Meja / Grup</label>
                                    <input type="text" name="group_code" id="group_code" value="{{ old('group_code') }}" placeholder="Contoh: LAB1-WS-01">
                                </div>
                                <div>
                                    <label for="group_name" style="font-size:11.5px;">Nama Meja / Grup</label>
                                    <input type="text" name="group_name" id="group_name" value="{{ old('group_name') }}" placeholder="Contoh: Meja Komputer Siswa 01">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SEKSI 3: STATUS & PEMBELIAN -->
                <div class="section-box">
                    <div class="section-header">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        3. Status & Informasi Kepemilikan
                    </div>

                    <div class="form-grid grid-4">
                        <div class="form-group">
                            <label for="status">Status Operasional <span class="required">*</span></label>
                            <select name="status" id="status" required>
                                <option value="ACTIVE" @selected(old('status', 'ACTIVE') === 'ACTIVE')>Aktif (Normal)</option>
                                <option value="MAINTENANCE" @selected(old('status') === 'MAINTENANCE')>Maintenance (Perbaikan)</option>
                                <option value="BORROWED" @selected(old('status') === 'BORROWED')>Sedang Dipinjam</option>
                                <option value="DAMAGED" @selected(old('status') === 'DAMAGED')>Damaged (Rusak)</option>
                                <option value="LOST" @selected(old('status') === 'LOST')>Lost (Hilang)</option>
                                <option value="RETIRED" @selected(old('status') === 'RETIRED')>Retired (Afkir)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="condition">Kondisi Fisik <span class="required">*</span></label>
                            <select name="condition" id="condition" required>
                                <option value="GOOD" @selected(old('condition', 'GOOD') === 'GOOD')>Good (Baik)</option>
                                <option value="FAIR" @selected(old('condition') === 'FAIR')>Fair (Cukup)</option>
                                <option value="POOR" @selected(old('condition') === 'POOR')>Poor (Kurang Baik)</option>
                                <option value="DAMAGED" @selected(old('condition') === 'DAMAGED')>Damaged (Rusak)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="purchase_date">Tanggal Pembelian</label>
                            <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}">
                        </div>

                        <div class="form-group">
                            <label for="vendor">Vendor / Toko</label>
                            <input type="text" name="vendor" id="vendor" value="{{ old('vendor') }}" placeholder="Nama penyedia toko">
                        </div>
                    </div>

                    <div class="form-group full" style="margin-top: 14px;">
                        <label for="notes">Catatan Tambahan</label>
                        <textarea name="notes" id="notes" placeholder="Catatan khusus kelengkapan unit, riwayat servis awal, atau lokasi penyimpanan detail...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('assets.index') }}" class="btn-back">Batal</a>
                    <button type="submit" class="btn-submit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Inventaris
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT CONDITIONAL TECHNICAL SPECIFICATIONS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('asset_item_id');
            const typeSelect = document.getElementById('asset_type_id');
            const specTitle = document.getElementById('specTitle');
            const specHelper = document.getElementById('specHelper');

            const computerFields = document.querySelectorAll('.spec-computer');
            const laptopFields = document.querySelectorAll('.spec-laptop');
            const serverFields = document.querySelectorAll('.spec-server');
            const networkFields = document.querySelectorAll('.spec-network');
            const cctvFields = document.querySelectorAll('.spec-cctv');
            const projectorFields = document.querySelectorAll('.spec-projector');
            const ipFields = document.querySelectorAll('.spec-ip');
            const macFields = document.querySelectorAll('.spec-mac');

            function hideAllSpecFields() {
                const allCustomFields = document.querySelectorAll('.spec-field');
                allCustomFields.forEach(el => el.style.display = 'none');
            }

            function updateFormFields() {
                hideAllSpecFields();

                const selectedItemOption = itemSelect.options[itemSelect.selectedIndex];
                const selectedTypeOption = typeSelect.options[typeSelect.selectedIndex];

                const itemCode = selectedItemOption ? (selectedItemOption.getAttribute('data-code') || '') : '';
                const itemName = selectedItemOption ? (selectedItemOption.getAttribute('data-name') || '') : '';
                const typeCode = selectedTypeOption ? (selectedTypeOption.getAttribute('data-code') || '') : '';

                // 1. PC / KOMPUTER / LAPTOP / SERVER
                if (itemCode === 'PC' || itemName.includes('komputer') || itemName.includes('pc') || itemName.includes('laptop') || itemName.includes('server')) {
                    computerFields.forEach(el => el.style.display = 'flex');
                    ipFields.forEach(el => el.style.display = 'flex');
                    macFields.forEach(el => el.style.display = 'flex');
                    
                    if (itemName.includes('laptop')) {
                        laptopFields.forEach(el => el.style.display = 'flex');
                        specTitle.innerText = '2. Spesifikasi Teknis Laptop';
                    } else if (itemName.includes('server')) {
                        serverFields.forEach(el => el.style.display = 'flex');
                        specTitle.innerText = '2. Spesifikasi Teknis Server';
                    } else {
                        specTitle.innerText = '2. Spesifikasi Teknis Komputer PC';
                    }
                    specHelper.innerText = 'Field processor, RAM, storage, sistem operasi, IP, dan MAC Address diaktifkan.';
                    return;
                }

                // 2. NETWORK DEVICE (Router, Switch, AP - NE)
                if (typeCode === 'NE' || itemName.includes('router') || itemName.includes('switch') || itemName.includes('access point') || itemName.includes('hub')) {
                    networkFields.forEach(el => el.style.display = 'flex');
                    ipFields.forEach(el => el.style.display = 'flex');
                    macFields.forEach(el => el.style.display = 'flex');
                    specTitle.innerText = '2. Spesifikasi Perangkat Jaringan (Network Device)';
                    specHelper.innerText = 'Field port count, firmware version, IP, dan MAC Address diaktifkan.';
                    return;
                }

                // 3. CCTV (CC)
                if (itemCode === 'CC' || itemName.includes('cctv') || itemName.includes('kamera')) {
                    cctvFields.forEach(el => el.style.display = 'flex');
                    ipFields.forEach(el => el.style.display = 'flex');
                    macFields.forEach(el => el.style.display = 'flex');
                    specTitle.innerText = '2. Spesifikasi Kamera CCTV';
                    specHelper.innerText = 'Field resolusi kamera, tipe kamera, IP, dan MAC Address diaktifkan.';
                    return;
                }

                // 4. PROJECTOR (PY)
                if (itemCode === 'PY' || itemName.includes('proyektor') || itemName.includes('projector')) {
                    projectorFields.forEach(el => el.style.display = 'flex');
                    specTitle.innerText = '2. Spesifikasi Unit Proyektor';
                    specHelper.innerText = 'Field resolusi proyeksi, umur jam lampu, dan konektivitas port diaktifkan.';
                    return;
                }

                // 5. GENERIC / NON-TECHNICAL (Kabel, Keyboard, Mouse, Speaker, Mic, Mixer, Meja, Aksesoris)
                specTitle.innerText = '2. Informasi Merek & Seri Perangkat';
                specHelper.innerText = 'Perangkat non-komputasi standar. Spesifikasi kompleks (CPU/RAM/IP/MAC) disembunyikan.';
            }

            itemSelect.addEventListener('change', updateFormFields);
            typeSelect.addEventListener('change', updateFormFields);

            // Initial trigger
            updateFormFields();
        });
    </script>
</body>
</html>
