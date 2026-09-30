<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Bundel Meja & Proyektor Walas — IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f9ff; color: #1e293b; min-height: 100vh; }

        /* NAVBAR */
        .navbar { background: #0c1a2e; height: 68px; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: #fff; }
        .nav-logo { width: 38px; height: 38px; background: linear-gradient(135deg, #0ea5e9, #0369a1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 12px rgba(3,105,161,0.4); }
        .nav-brand-text h2 { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; }
        .nav-brand-text span { font-size: 11px; color: #7dd3fc; }
        .nav-links { display: flex; align-items: center; gap: 4px; list-style: none; }
        .nav-links a { display: flex; align-items: center; gap: 6px; padding: 7px 13px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: #bae6fd; transition: all 0.15s; }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-links a.active { color: #fff; background: #0369a1; }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .user-pill { display: flex; align-items: center; gap: 9px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 30px; }
        .user-avatar { width: 28px; height: 28px; background: #0369a1; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .user-name { font-size: 12px; font-weight: 600; color: #f0f9ff; line-height: 1.2; }
        .btn-logout { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.25); padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.15s; }
        .btn-logout:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* CONTAINER */
        .container { max-width: 1400px; margin: 0 auto; padding: 28px 20px 48px; }

        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .page-title h1 { font-size: 24px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; display: flex; align-items: center; gap: 10px; }
        .page-title p { font-size: 13.5px; color: #64748b; margin-top: 4px; }
        .btn-add-group { display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.35); transition: all 0.15s; }
        .btn-add-group:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }

        /* ALERT */
        .alert-success { background: #dcfce7; border: 1.5px solid #86efac; border-radius: 12px; padding: 14px 20px; color: #15803d; font-weight: 600; font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }

        /* FILTER & STATS BAR */
        .toolbar-card { background: #fff; border-radius: 16px; padding: 16px 20px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 18px rgba(0,0,0,0.03); margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
        .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
        .tab-btn { padding: 8px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700; text-decoration: none; color: #475569; background: #f1f5f9; border: 1px solid #e2e8f0; transition: all 0.15s; display: inline-flex; align-items: center; gap: 6px; }
        .tab-btn:hover { background: #e0f2fe; color: #0369a1; }
        .tab-btn.active { background: #0369a1; color: #fff; border-color: #0369a1; }

        .search-box { display: flex; align-items: center; gap: 8px; }
        .search-input { padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: inherit; outline: none; width: 220px; }
        .search-input:focus { border-color: #0369a1; box-shadow: 0 0 0 3px rgba(3,105,161,0.12); }

        /* GROUPS GRID */
        .groups-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px; margin-bottom: 32px; }
        .group-card { background: #fff; border-radius: 18px; border: 1.5px solid #e0f2fe; box-shadow: 0 4px 20px rgba(0,0,0,0.03); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.15s, border-color 0.15s; position: relative; }
        .group-card:hover { transform: translateY(-2px); border-color: #7dd3fc; box-shadow: 0 8px 28px rgba(3,105,161,0.08); }
        
        .group-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .group-type-badge { font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
        .group-code { font-family: 'JetBrains Mono', monospace; font-size: 15px; font-weight: 800; color: #0369a1; margin-top: 4px; }
        .group-name { font-size: 14px; font-weight: 700; color: #0c1a2e; margin-top: 2px; }
        .group-loc { font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 4px; margin-top: 3px; }

        .items-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; margin: 14px 0; }
        .items-header { font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; display: flex; justify-content: space-between; }
        .item-row { display: flex; align-items: center; justify-content: space-between; padding: 5px 0; border-bottom: 1px dashed #e2e8f0; font-size: 12px; }
        .item-row:last-child { border-bottom: none; }
        .item-tag { font-family: 'JetBrains Mono', monospace; font-size: 9.5px; font-weight: 800; padding: 1px 5px; border-radius: 4px; background: #e0f2fe; color: #0369a1; margin-right: 5px; }
        .item-primary-star { color: #eab308; font-size: 11px; margin-left: 2px; }

        .group-footer { display: flex; justify-content: space-between; align-items: center; gap: 8px; border-top: 1.5px dashed #f0f9ff; padding-top: 14px; margin-top: 6px; }
        .btn-card-act { display: inline-flex; align-items: center; gap: 4px; padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; font-family: inherit; cursor: pointer; transition: all 0.15s; }
        .btn-card-print { background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; box-shadow: 0 2px 8px rgba(3,105,161,0.25); }
        .btn-card-print:hover { background: #075985; }
        .btn-card-edit { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
        .btn-card-edit:hover { background: #e2e8f0; color: #0c1a2e; }

        /* MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(12,26,46,0.7); z-index: 60; display: flex; align-items: center; justify-content: center; padding: 20px; backdrop-filter: blur(4px); }
        .modal-card { background: #fff; border-radius: 20px; padding: 28px; max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 24px 60px rgba(0,0,0,0.25); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1.5px solid #f0f9ff; padding-bottom: 12px; }
        .modal-header h3 { font-size: 17px; font-weight: 800; color: #0c1a2e; }
        .modal-close { background: #f1f5f9; border: none; border-radius: 8px; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #64748b; }
        .modal-close:hover { background: #fee2e2; color: #b91c1c; }

        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; padding: 10px 12px; border: 1.5px solid #cbd5e1; border-radius: 9px; font-size: 13px; font-family: inherit; outline: none; background: #f8fafc; }
        .form-input:focus, .form-select:focus { border-color: #0369a1; background: #fff; box-shadow: 0 0 0 3px rgba(3,105,161,0.12); }

        .preset-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-bottom: 14px; }
        .preset-btn { background: #f0f9ff; border: 1.5px solid #bae6fd; border-radius: 9px; padding: 8px 10px; font-size: 12px; font-weight: 700; color: #0369a1; cursor: pointer; text-align: left; font-family: inherit; transition: all 0.15s; }
        .preset-btn:hover { background: #0369a1; color: #fff; border-color: #0369a1; }

        .asset-select-list { max-height: 200px; overflow-y: auto; border: 1.5px solid #cbd5e1; border-radius: 9px; padding: 8px; background: #f8fafc; display: flex; flex-direction: column; gap: 6px; }
        .asset-check-item { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #fff; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 12px; cursor: pointer; }
        .asset-check-item:hover { background: #f0f9ff; border-color: #bae6fd; }

        @media (max-width: 768px) {
            body { padding-bottom: calc(76px + env(safe-area-inset-bottom)); }
            .navbar { padding: 10px 14px; height: auto; flex-wrap: wrap; }
            .nav-links { order: 3; width: 100%; overflow-x: auto; padding-top: 4px; }
            .groups-grid { grid-template-columns: 1fr; }
            .preset-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<div class="container">

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div class="page-title">
            <h1>Kelola Bundel Meja & Proyektor Kelas / Lab</h1>
            <p>Atur pengelompokan perangkat (Meja Guru Walas, Proyektor Kelas, Workstation Lab Siswa) agar memiliki <strong>1 QR Code Meja Utama</strong>.</p>
        </div>
        <div>
            <button class="btn-add-group" onclick="openCreateModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                + Buat Bundel / Grup Meja Baru
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- TOOLBAR & FILTER TABS -->
    <div class="toolbar-card">
        <div class="filter-tabs">
            <a href="{{ route('asset-groups.index') }}" class="tab-btn {{ !request('type') ? 'active' : '' }}">
                Semua Grup ({{ $groups->count() }})
            </a>
            <a href="{{ route('asset-groups.index', ['type' => 'walas_meja']) }}" class="tab-btn {{ request('type') === 'walas_meja' ? 'active' : '' }}">
                Meja Walas / Guru
            </a>
            <a href="{{ route('asset-groups.index', ['type' => 'walas_proyektor']) }}" class="tab-btn {{ request('type') === 'walas_proyektor' ? 'active' : '' }}">
                Proyektor Kelas Walas
            </a>
            <a href="{{ route('asset-groups.index', ['type' => 'lab']) }}" class="tab-btn {{ request('type') === 'lab' ? 'active' : '' }}">
                Workstation Lab Komputer
            </a>
        </div>

        <form method="GET" action="{{ route('asset-groups.index') }}" class="search-box">
            @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode meja atau kelas..." class="search-input">
            <button type="submit" style="padding:8px 12px; background:#0369a1; color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer; font-size:12.5px;">Cari</button>
        </form>
    </div>

    <!-- GROUPS GRID -->
    <div class="groups-grid">
        @forelse($groups as $grp)
        <div class="group-card">
            <div>
                <div class="group-top">
                    <div>
                        <span class="group-type-badge" style="background: {{ $grp->badge_color }}15; color: {{ $grp->badge_color }}; border: 1px solid {{ $grp->badge_color }}35;">
                            {{ $grp->type_label }}
                        </span>
                        <div class="group-code">{{ $grp->code }}</div>
                        <div class="group-name">{{ $grp->name }}</div>
                    </div>
                </div>

                <div class="group-loc">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span>{{ $grp->location }}</span>
                </div>

                <!-- DAFTAR ANGGOTA DEVICE -->
                <div class="items-box">
                    <div class="items-header">
                        <span>Unit Terpasang</span>
                        <span>{{ $grp->total_items }} Perangkat</span>
                    </div>
                    @foreach($grp->items as $it)
                    <div class="item-row">
                        <div>
                            <span class="item-tag">{{ $it->assetItem->code ?? 'DEV' }}</span>
                            <strong>{{ $it->name }}</strong>
                            @if($it->is_group_primary)
                                <span class="item-primary-star" title="QR Code Utama Meja">★ (QR Utama)</span>
                            @endif
                        </div>
                        <div>
                            <span style="font-size:10px; font-weight:700; color: {{ $it->status === 'ACTIVE' ? '#15803d' : '#b91c1c' }};">
                                {{ $it->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- FOOTER AKSI -->
            <div class="group-footer">
                <a href="{{ route('assets.group-print', $grp->code) }}" target="_blank" class="btn-card-act btn-card-print">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Cetak Stiker Meja
                </a>

                <div style="display:flex; gap:6px;">
                    <a href="{{ route('assets.index', ['group_code' => $grp->code]) }}" class="btn-card-act btn-card-edit" title="Buka di Daftar Aset">
                        Buka Aset →
                    </a>
                    <form method="POST" action="{{ route('asset-groups.destroy', $grp->code) }}" onsubmit="return confirm('Bubarkan grup meja {{ $grp->code }}? Aset di dalamnya akan kembali berstatus mandiri.')" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-card-act" style="background:#fee2e2; color:#b91c1c; border:1px solid #fca5a5;" title="Bubarkan Grup Meja">
                            ✕
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #fff; border-radius: 16px; border: 1.5px solid #e0f2fe;">
            <div style="font-size: 36px; margin-bottom: 12px; color: #0284c7;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            </div>
            <h3 style="font-size: 18px; color: #0c1a2e; margin-bottom: 6px;">Belum Ada Grup Meja / Bundel Terdaftar</h3>
            <p style="font-size: 13.5px; color: #64748b; margin-bottom: 18px;">
                Kelompokkan perangkat komputer guru (Walas), proyektor kelas, atau workstation lab agar memiliki 1 QR code meja utama.
            </p>
            <button class="btn-add-group" onclick="openCreateModal()">+ Buat Bundel Meja Pertama</button>
        </div>
        @endforelse
    </div>

</div>

<!-- MODAL BUAT BUNDEL / GRUP MEJA BARU -->
<div id="createModal" class="modal-overlay" style="display:none;" onclick="if(event.target===this)closeCreateModal()">
    <div class="modal-card">
        <div class="modal-header">
            <h3>+ Buat Bundel Meja & Proyektor Baru</h3>
            <button class="modal-close" onclick="closeCreateModal()">✕</button>
        </div>

        <form method="POST" action="{{ route('asset-groups.store') }}">
            @csrf

            <!-- PRESET PINTAR -->
            <div style="margin-bottom: 14px;">
                <div class="form-label" style="color: #0369a1;">Pilih Preset Cepat:</div>
                <div class="preset-grid">
                    <button type="button" class="preset-btn" onclick="applyPreset('WALAS-7A-MEJA', 'Meja Guru Walas Kelas 7A')">
                        Meja Guru Walas
                    </button>
                    <button type="button" class="preset-btn" onclick="applyPreset('WALAS-7A-PROYEKTOR', 'Paket Proyektor Kelas 7A')">
                        Proyektor Kelas Walas
                    </button>
                    <button type="button" class="preset-btn" onclick="applyPreset('LAB1-WS-01', 'Meja Siswa 01 Lab Komputer 1')">
                        Workstation Lab Siswa
                    </button>
                    <button type="button" class="preset-btn" onclick="applyPreset('TU-WS-01', 'Meja Kerja Staf TU')">
                        Meja Kerja Kantor / TU
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kode Grup / Meja (Contoh: WALAS-7A-MEJA, WALAS-7A-PROYEKTOR, LAB1-WS-01) *</label>
                <input type="text" id="input_group_code" name="group_code" required class="form-input" placeholder="Contoh: WALAS-7A-MEJA">
            </div>

            <div class="form-group">
                <label class="form-label">Nama Meja / Bundel *</label>
                <input type="text" id="input_group_name" name="group_name" required class="form-input" placeholder="Contoh: Meja Guru Walas Kelas 7A">
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi / Ruangan (Opsional, akan menyinkronkan aset)</label>
                <select name="location_id" class="form-select">
                    <option value="">-- Pertahankan Lokasi Aset Masing-Masing --</option>
                    @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- PILIH ASET YANG INGIN DIGABUNGKAN KE GRUP INI -->
            <div class="form-group">
                <label class="form-label">Pilih Perangkat untuk Dimasukkan ke Meja / Bundel Ini: *</label>
                <div style="font-size:11.5px; color:#64748b; margin-bottom:8px;">
                    Centang seluruh perangkat (misal: PC, Monitor, Keyboard, Mouse, atau Proyektor):
                </div>

                <div class="asset-select-list">
                    @forelse($ungroupedAssets as $ua)
                    <label class="asset-check-item">
                        <input type="checkbox" name="asset_ids[]" value="{{ $ua->id }}" style="cursor:pointer;">
                        <div>
                            <span style="font-family:'JetBrains Mono', monospace; color:#0369a1; font-weight:700;">[{{ $ua->assetItem->code ?? 'DEV' }}]</span>
                            <strong>{{ $ua->name }}</strong>
                            <span style="color:#64748b; font-size:11px;">({{ $ua->asset_code }})</span>
                        </div>
                    </label>
                    @empty
                    <div style="font-size:12px; color:#94a3b8; padding:12px; text-align:center;">
                        Semua perangkat sudah memiliki grup atau belum ada data aset terdaftar.
                    </div>
                    @endforelse
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:20px;">
                <button type="button" class="btn-card-act btn-card-edit" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn-add-group" style="padding:9px 18px; font-size:13px;">Simpan & Buat Bundel Meja</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.body.style.overflow = '';
}

function applyPreset(code, name) {
    document.getElementById('input_group_code').value = code;
    document.getElementById('input_group_name').value = name;
}
</script>

</body>
</html>
