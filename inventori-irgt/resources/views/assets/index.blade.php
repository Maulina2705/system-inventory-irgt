<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Inventaris - IRGT School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .user-role { font-size: 10px; color: #7dd3fc; text-transform: capitalize; }
        .btn-logout { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.25); padding: 7px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.15s; }
        .btn-logout:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* MAIN */
        .container { max-width: 1450px; margin: 0 auto; padding: 32px 24px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .page-title h1 { font-size: 26px; font-weight: 800; color: #0c1a2e; letter-spacing: -0.02em; margin-bottom: 4px; }
        .page-title p { font-size: 14px; color: #64748b; }
        .btn-add { display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; box-shadow: 0 4px 14px rgba(3,105,161,0.35); transition: all 0.15s; }
        .btn-add:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(3,105,161,0.45); }

        /* FLASH MESSAGE */
        .alert-success { background: #dcfce7; border: 1.5px solid #86efac; border-radius: 12px; padding: 14px 20px; color: #15803d; font-weight: 600; font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }

        /* FILTER & SEARCH CARD */
        .filter-card { background: #fff; border-radius: 16px; padding: 20px 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 24px; border: 1.5px solid #e0f2fe; }
        .filter-form { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 0.8fr auto; gap: 12px; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-group label { font-size: 11.5px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; }
        .filter-input, .filter-select {
            padding: 10px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 9px;
            font-size: 13px;
            font-family: inherit;
            background: #f8fafc;
            color: #0c1a2e;
            outline: none;
            transition: all 0.15s;
        }
        .filter-input:focus, .filter-select:focus { border-color: #0369a1; background: #fff; box-shadow: 0 0 0 3px rgba(3,105,161,0.12); }
        .filter-btn-group { display: flex; gap: 8px; }
        .btn-filter { padding: 10px 18px; border-radius: 9px; font-size: 13px; font-weight: 700; background: #0369a1; color: #fff; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-family: inherit; transition: all 0.15s; }
        .btn-filter:hover { background: #075985; }
        .btn-reset { padding: 10px 14px; border-radius: 9px; font-size: 13px; font-weight: 600; background: #f1f5f9; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.15s; }
        .btn-reset:hover { background: #e2e8f0; color: #0c1a2e; }

        /* CARD TABLE */
        .card { background: #fff; border-radius: 16px; padding: 0; box-shadow: 0 4px 24px rgba(0,0,0,0.05); overflow: hidden; }
        .card-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 1200px; }
        th { background: #f0f9ff; text-align: left; padding: 13px 16px; border-bottom: 2px solid #e0f2fe; font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 13px 16px; border-bottom: 1px solid #f0f9ff; font-size: 13.5px; color: #334155; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0f9ff; }
        .asset-code { font-weight: 700; color: #0369a1; font-family: 'JetBrains Mono', monospace; font-size: 12px; background: #e0f2fe; padding: 5px 10px; border-radius: 7px; display: inline-block; white-space: nowrap; line-height: 1.4; border: 1px solid #bae6fd; box-sizing: border-box; }
        .asset-name { font-weight: 600; color: #0c1a2e; }

        /* BADGES */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 700; }
        .badge-active { background: #dcfce7; color: #15803d; }
        .badge-maintenance { background: #fef9c3; color: #a16207; }
        .badge-damaged { background: #fee2e2; color: #b91c1c; }
        .badge-lost { background: #fce7f3; color: #be185d; }
        .badge-retired { background: #f1f5f9; color: #475569; }
        .badge-good { background: #dcfce7; color: #15803d; }
        .badge-fair { background: #fef9c3; color: #a16207; }
        .badge-poor, .badge-damaged-c { background: #fee2e2; color: #b91c1c; }

        /* ACTIONS */
        .actions-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }
        .btn-act { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; transition: all 0.15s; border: none; text-decoration: none; }
        .btn-act-qr { background: #e0f2fe; color: #0369a1; border: 1.5px solid #7dd3fc; }
        .btn-act-qr:hover { background: #0369a1; color: #fff; border-color: #0369a1; }
        .btn-act-hist { background: #ede9fe; color: #6d28d9; border: 1.5px solid #ddd6fe; }
        .btn-act-hist:hover { background: #7c3aed; color: #fff; border-color: #7c3aed; }
        .btn-act-edit { background: #fef3c7; color: #b45309; border: 1.5px solid #fde68a; }
        .btn-act-edit:hover { background: #d97706; color: #fff; border-color: #d97706; }
        .btn-act-delete { background: #fee2e2; color: #b91c1c; border: 1.5px solid #fca5a5; }
        .btn-act-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* PAGINATION */
        .pagination-wrap { padding: 0; }

        /* EMPTY */
        .empty { text-align: center; padding: 64px 20px; }
        .empty h3 { font-size: 18px; color: #0c1a2e; margin: 12px 0 6px; font-weight: 700; }
        .empty p { color: #64748b; font-size: 14px; margin-bottom: 20px; }

        /* MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(12,26,46,0.7); z-index: 60; display: flex; align-items: center; justify-content: center; padding: 24px; backdrop-filter: blur(4px); }
        .modal-card { background: #fff; border-radius: 20px; padding: 32px; max-width: 380px; width: 100%; box-shadow: 0 24px 60px rgba(0,0,0,0.2); animation: fadeUp 0.2s ease; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .modal-header h3 { font-size: 18px; font-weight: 800; color: #0c1a2e; }
        .modal-close { width: 32px; height: 32px; background: #f1f5f9; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748b; transition: all 0.15s; }
        .modal-close:hover { background: #fee2e2; color: #b91c1c; }
        .modal-qr-wrap { background: #f0f9ff; border: 2px solid #e0f2fe; border-radius: 14px; padding: 20px; text-align: center; margin-bottom: 16px; display: flex; align-items: center; justify-content: center; min-height: 240px; }
        .modal-qr-wrap img { display: block; margin: 0 auto; border-radius: 10px; background: #fff; padding: 8px; box-shadow: 0 4px 12px rgba(3,105,161,0.08); }
        .modal-code { font-family: 'JetBrains Mono', monospace; font-size: 14px; font-weight: 700; color: #0369a1; text-align: center; background: #e0f2fe; padding: 7px 12px; border-radius: 8px; margin-bottom: 6px; word-break: break-all; letter-spacing: 0.02em; }
        .modal-name { font-size: 13.5px; color: #0c1a2e; text-align: center; margin-bottom: 20px; font-weight: 700; }
        .modal-actions { display: flex; gap: 10px; }
        .btn-print { flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 11px; background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px; box-shadow: 0 4px 12px rgba(3,105,161,0.3); transition: all 0.15s; }
        .btn-print:hover { background: linear-gradient(135deg, #0369a1, #075985); transform: translateY(-1px); }
        .btn-download-png { flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 11px; background: #e0f2fe; color: #0369a1; border: 1.5px solid #7dd3fc; border-radius: 10px; font-weight: 700; font-size: 13px; font-family: inherit; cursor: pointer; transition: all 0.15s; }
        .btn-download-png:hover { background: #0369a1; color: #fff; border-color: #0369a1; }
        .btn-close-modal { width: 100%; padding: 11px; background: #f1f5f9; color: #475569; border: none; border-radius: 10px; font-weight: 700; font-size: 13.5px; font-family: inherit; cursor: pointer; transition: all 0.15s; margin-top: 8px; }
        .btn-close-modal:hover { background: #e2e8f0; }
        .loading-qr { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; color: #0369a1; font-size: 13px; font-weight: 600; padding: 20px; }
        .spinner { width: 36px; height: 36px; border: 3px solid #e0f2fe; border-top-color: #0369a1; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 1024px) {
            .filter-form { grid-template-columns: 1fr 1fr; }
            .filter-btn-group { grid-column: 1 / -1; justify-content: flex-end; }
        }
        @media (max-width: 768px) {
            body { padding-bottom: calc(76px + env(safe-area-inset-bottom)); }
            .navbar { flex-wrap: wrap; height: auto; padding: 10px 14px; gap: 8px; justify-content: space-between; }
            .nav-brand { flex: 1; min-width: 0; }
            .nav-brand-text h2 { font-size: 13px; }
            .nav-brand-text span { display: none; }
            .nav-right { gap: 6px; }
            .user-pill { padding: 3px 8px; gap: 6px; border-radius: 20px; }
            .user-avatar { width: 22px; height: 22px; font-size: 10.5px; }
            .user-name { font-size: 11px; max-width: 75px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .user-role { display: none; }
            .btn-logout { padding: 6px 8px; min-width: 32px; height: 32px; justify-content: center; border-radius: 7px; }
            .btn-logout span { display: none; }
            .nav-links { order: 3; width: 100%; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; scrollbar-width: none; padding-top: 4px; }
            .nav-links::-webkit-scrollbar { display: none; }
            .container { padding: 16px 12px; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .btn-add { width: 100%; justify-content: center; }
            .filter-form { grid-template-columns: 1fr; gap: 10px; }
            .filter-btn-group { justify-content: stretch; }
            .filter-btn-group button, .filter-btn-group a { flex: 1; text-align: center; justify-content: center; }
            
            /* MOBILE BULK BAR - POSITIONED ABOVE MOBILE BOTTOM NAV */
            #bulkActionBar {
                bottom: calc(76px + env(safe-area-inset-bottom)) !important;
                width: calc(100% - 24px) !important;
                max-width: 440px !important;
                padding: 10px 16px !important;
                gap: 8px !important;
                justify-content: space-between !important;
                z-index: 1100 !important;
            }
            #bulkActionBar button {
                padding: 8px 12px !important;
                font-size: 11.5px !important;
            }

            /* TABLE MOBILE COLUMN FIT */
            .table-wrap table th, .table-wrap table td {
                white-space: nowrap;
                padding: 12px 14px;
            }
            .asset-name {
                display: block;
                max-width: 220px;
                white-space: normal;
                line-height: 1.3;
            }
        }

        /* SMOOTH ENTRANCE ANIMATIONS */
        .filter-card, .table-card {
            animation: cardEntrance 0.35s cubic-bezier(0.16, 1, 0.3, 1) backwards;
        }
        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- UNIFIED NAVBAR -->
@include('partials.navbar')

<!-- MAIN -->
<div class="container">
    <div class="page-header">
        <div class="page-title">
            <h1>Daftar Inventaris</h1>
            <p>Kelola dan pantau seluruh aset IT & perangkat sekolah IRGT secara real-time.</p>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <a href="{{ route('assets.export.csv', request()->query()) }}" class="btn-reset" style="background: #e0f2fe; color: #0369a1; border: 1.5px solid #bae6fd; font-weight: 700; padding: 10px 14px;" title="Unduh data dalam format Excel (CSV)">
                Unduh Excel (CSV)
            </a>
            <a href="{{ route('assets.print-recap', request()->query()) }}" target="_blank" class="btn-reset" style="background: #fff; color: #475569; border: 1.5px solid #cbd5e1; font-weight: 700; padding: 10px 14px;" title="Cetak atau simpan format PDF Rekap">
                Cetak Rekap PDF
            </a>
            <a href="{{ route('assets.create') }}" class="btn-add">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Inventaris
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- FILTER & SEARCH -->
    <div class="filter-card">
        <form method="GET" action="{{ route('assets.index') }}" class="filter-form">
            <div class="filter-group">
                <label>Pencarian</label>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari kode, nama, merk, serial number, pengguna..."
                    class="filter-input"
                >
            </div>
            <div class="filter-group">
                <label>Status</label>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    @foreach(['ACTIVE' => 'Aktif', 'MAINTENANCE' => 'Perawatan', 'DAMAGED' => 'Rusak', 'LOST' => 'Hilang', 'RETIRED' => 'Afkir'] as $val => $label)
                    <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Kondisi</label>
                <select name="condition" class="filter-select">
                    <option value="">Semua Kondisi</option>
                    @foreach(['GOOD' => 'Baik', 'FAIR' => 'Cukup', 'POOR' => 'Kurang Baik', 'DAMAGED' => 'Rusak Total'] as $val => $label)
                    <option value="{{ $val }}" {{ request('condition') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Penempatan</label>
                <select name="placement_id" class="filter-select">
                    <option value="">Semua Penempatan</option>
                    @foreach($placements as $p)
                    <option value="{{ $p->id }}" {{ request('placement_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Lokasi</label>
                <select name="location_id" class="filter-select">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $l)
                    <option value="{{ $l->id }}" {{ request('location_id') == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(isset($groups) && $groups->count() > 0)
            <div class="filter-group">
                <label>Grup Meja</label>
                <select name="group_code" class="filter-select">
                    <option value="">Semua Grup Meja</option>
                    @foreach($groups as $g)
                    <option value="{{ $g->group_code }}" {{ request('group_code') == $g->group_code ? 'selected' : '' }}>
                        {{ $g->group_code }} ({{ $g->group_name ?? 'Meja' }})
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="filter-group">
                <label>Tampilkan</label>
                <select name="per_page" class="filter-select" onchange="this.form.submit()">
                    @foreach([15, 25, 50, 100, 150, 200] as $num)
                    <option value="{{ $num }}" {{ request('per_page', 15) == $num ? 'selected' : '' }}>{{ $num }} data</option>
                    @endforeach
                    <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Semua Data</option>
                </select>
            </div>
            <div class="filter-btn-group">
                <button type="submit" class="btn-filter">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Cari
                </button>
                @if(request()->anyFilled(['q', 'status', 'condition', 'placement_id', 'location_id', 'group_code', 'per_page']))
                <a href="{{ route('assets.index') }}" class="btn-reset" title="Reset Filter">✕</a>
                @endif
            </div>
        </form>
    </div>

    @if(request('group_code'))
    <div style="background: linear-gradient(135deg, #e0f2fe, #bae6fd); border: 1.5px solid #7dd3fc; border-radius: 14px; padding: 14px 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; box-shadow: 0 4px 14px rgba(3,105,161,0.08);">
        <div style="font-size: 13.5px; color: #0369a1; font-weight: 700; display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #0369a1; color: #fff; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            </div>
            <div>
                Menampilkan Seluruh Perangkat Meja / Workstation: <strong>{{ request('group_code') }}</strong>
                <div style="font-size: 11.5px; color: #075985; font-weight: 500; margin-top: 1px;">
                    Bundel perangkat CPU, monitor, dan periferal yang terpasang di meja ini.
                </div>
            </div>
        </div>
        <a href="{{ route('assets.group-print', request('group_code')) }}" target="_blank" class="btn-filter" style="background: #0369a1; padding: 9px 18px; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak Label Meja (Grup)
        </a>
    </div>
    @endif

    <div class="card">
        @if($assets->count() > 0)
        <div class="card-scroll">
            <table>
                <thead>
                    <tr>
                        <th style="width: 36px; text-align: center;">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="cursor: pointer; width: 16px; height: 16px;">
                        </th>
                        <th>No</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Aset</th>
                        <th>Penempatan</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Merk</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th style="text-align:center; min-width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" class="asset-checkbox" value="{{ $asset->id }}" onchange="updateSelectedCount()" style="cursor: pointer; width: 16px; height: 16px;">
                        </td>
                        <td style="color:#94a3b8; font-size:13px;">{{ $assets->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="asset-code">{{ $asset->asset_code }}</span>
                            @if($asset->group_code)
                            <div style="margin-top:3px;">
                                <a href="{{ route('assets.group-print', $asset->group_code) }}" target="_blank" title="Cetak Kartu Stiker Meja {{ $asset->group_code }}" style="font-size:10px; font-weight:800; background:#f0f9ff; color:#0369a1; border:1px solid #bae6fd; padding:1px 6px; border-radius:4px; display:inline-flex; align-items:center; gap:3px; text-decoration:none;">
                                    Grup: {{ $asset->group_code }} ↗
                                </a>
                            </div>
                            @endif
                        </td>
                        <td>
                            <span class="asset-name">{{ $asset->name }}</span>
                            @if($asset->group_name)
                            <div style="font-size:11px; color:#0369a1; font-weight:600;">
                                {{ $asset->group_name }}
                            </div>
                            @endif
                            @if($asset->creator)
                            <div style="font-size:11px; color:#0369a1; font-weight:600; margin-top:2px;">
                                Didaftarkan: {{ $asset->creator->name }}
                            </div>
                            @endif
                            @if($asset->solver)
                            <div style="font-size:11px; color:#15803d; font-weight:600;">
                                Diservis: {{ $asset->solver->name }}
                            </div>
                            @endif
                            @if($asset->assigned_to)
                            <div style="font-size:11px; color:#64748b;">
                                Pengguna: {{ $asset->assigned_to }}
                            </div>
                            @endif
                        </td>
                        <td>{{ $asset->placement->name ?? '-' }}</td>
                        <td>{{ $asset->location->name ?? '-' }}</td>
                        <td>{{ $asset->assetType->name ?? '-' }}</td>
                        <td>{{ $asset->brand ?? '-' }}</td>
                        <td>
                            @php
                                $condClass = match(strtoupper($asset->condition ?? '')) {
                                    'GOOD' => 'badge-good',
                                    'FAIR' => 'badge-fair',
                                    'POOR' => 'badge-poor',
                                    'DAMAGED' => 'badge-damaged-c',
                                    default => 'badge-retired',
                                };
                            @endphp
                            <span class="badge {{ $condClass }}">{{ $asset->condition }}</span>
                        </td>
                        <td>
                            @php
                                $statClass = match(strtoupper($asset->status ?? '')) {
                                    'ACTIVE' => 'badge-active',
                                    'MAINTENANCE' => 'badge-maintenance',
                                    'DAMAGED' => 'badge-damaged',
                                    'LOST' => 'badge-lost',
                                    'RETIRED' => 'badge-retired',
                                    default => 'badge-retired',
                                };
                            @endphp
                            <span class="badge {{ $statClass }}">{{ $asset->status }}</span>
                        </td>
                        <td style="text-align:center;">
                            <div class="actions-wrap">
                                <!-- QR MODAL BUTTON -->
                                <button
                                    class="btn-act btn-act-qr"
                                    onclick="openQrModal({{ $asset->id }}, '{{ $asset->asset_code }}', '{{ addslashes($asset->name) }}')"
                                    title="Lihat QR Code"
                                >
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect><path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M17 20h.01M20 14h.01M20 17h.01M20 20h.01"></path></svg>
                                </button>
                                <!-- HISTORY BUTTON -->
                                <a
                                    href="{{ route('assets.history', $asset->id) }}"
                                    class="btn-act btn-act-hist"
                                    title="Lihat Riwayat & Log Aset"
                                >
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                </a>
                                <!-- EDIT BUTTON -->
                                <a
                                    href="{{ route('assets.edit', $asset->id) }}"
                                    class="btn-act btn-act-edit"
                                    title="Edit Data Aset"
                                >
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <!-- DELETE BUTTON -->
                                <form method="POST" action="{{ route('assets.destroy', $asset->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus inventaris {{ $asset->asset_code }} ({{ addslashes($asset->name) }})?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-delete" title="Hapus Aset">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">
            {{ $assets->links() }}
        </div>
        @else
        <div class="empty">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#7dd3fc" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            <h3>Tidak Ada Data Inventaris</h3>
            <p>Tidak ditemukan data inventaris yang sesuai dengan filter pencarian.</p>
            <a href="{{ route('assets.create') }}" class="btn-add" style="display:inline-flex;">Tambah Inventaris Baru</a>
        </div>
        @endif
    </div>
</div>

<!-- QR MODAL -->
<div id="qr-modal" class="modal-overlay" style="display:none;" onclick="if(event.target===this)closeQrModal()">
    <div class="modal-card">
        <div class="modal-header">
            <h3>QR Code Aset</h3>
            <button class="modal-close" onclick="closeQrModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="modal-qr-wrap">
            <div id="qr-loading" class="loading-qr">
                <div class="spinner"></div>
                <span>Memuat QR Code...</span>
            </div>
            <img id="qr-img" src="" alt="QR Code" width="220" height="220" style="display:none; border-radius:8px;" onload="qrLoaded()" onerror="qrError()">
        </div>
        <div id="qr-code-text" class="modal-code">—</div>
        <div id="qr-name-text" class="modal-name">—</div>
        <div class="modal-actions">
            <a id="qr-print-btn" href="#" target="_blank" class="btn-print">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Cetak Label
            </a>
            <button type="button" class="btn-download-png" onclick="downloadQrPng()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download PNG
            </button>
        </div>
        <button class="btn-close-modal" onclick="closeQrModal()">Tutup</button>
    </div>
</div>

<script>
const BASE_ASSET_URL = '{{ url("/assets") }}';
let currentAssetCode = 'QR_Code';
let currentAssetName = 'Aset';

function openQrModal(id, code, name) {
    currentAssetCode = code;
    currentAssetName = name;
    
    // Reset loader UI
    const loadingEl = document.getElementById('qr-loading');
    loadingEl.innerHTML = '<div class="spinner"></div><span>Memuat QR Code...</span>';
    loadingEl.style.display = 'flex';

    const imgEl = document.getElementById('qr-img');
    imgEl.style.display = 'none';
    
    document.getElementById('qr-code-text').textContent = code;
    document.getElementById('qr-name-text').textContent = name;
    document.getElementById('qr-print-btn').href = BASE_ASSET_URL + '/' + id + '/print-label';
    document.getElementById('qr-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Set src with cache buster to prevent stale error caching
    imgEl.src = BASE_ASSET_URL + '/' + id + '/qr?t=' + new Date().getTime();
}

function qrLoaded() {
    document.getElementById('qr-loading').style.display = 'none';
    document.getElementById('qr-img').style.display = 'block';
}

function qrError() {
    const imgEl = document.getElementById('qr-img');
    if (!imgEl.src || imgEl.src === window.location.href) return;
    document.getElementById('qr-loading').innerHTML = '<span style="color:#b91c1c; font-size:13px; font-weight:700;">Gagal memuat QR Code.<br><button type="button" onclick="openQrModal(' + document.getElementById('qr-print-btn').href.split('/')[4] + ',\'' + currentAssetCode + '\',\'' + currentAssetName + '\')" style="margin-top:8px; padding:4px 10px; font-size:12px; background:#0369a1; color:#fff; border:none; border-radius:6px; cursor:pointer;">Coba Lagi</button></span>';
}

function closeQrModal() {
    document.getElementById('qr-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function downloadQrPng() {
    const qrImg = document.getElementById('qr-img');
    if (!qrImg || !qrImg.src) return;

    const img = new Image();
    img.crossOrigin = 'Anonymous';
    img.onload = function() {
        const canvas = document.createElement('canvas');
        const width = 800;
        const height = 1020;
        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');

        // 1. Background White
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, width, height);

        // 2. Outer Border
        ctx.strokeStyle = '#0284c7';
        ctx.lineWidth = 8;
        ctx.strokeRect(4, 4, width - 8, height - 8);

        // 3. Top Header Bar
        ctx.fillStyle = '#0c1a2e';
        ctx.fillRect(8, 8, width - 16, 90);

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 28px "Plus Jakarta Sans", sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('IRGT INVENTORY SYSTEM', width / 2, 50);

        ctx.fillStyle = '#7dd3fc';
        ctx.font = '600 15px "Plus Jakarta Sans", sans-serif';
        ctx.fillText('SISTEM PENDATAAN & PEMELIHARAAN ASET IT', width / 2, 78);

        // 4. Draw QR in Center
        const qrSize = 500;
        const qrX = (width - qrSize) / 2;
        const qrY = 125;
        ctx.drawImage(img, qrX, qrY, qrSize, qrSize);

        // 5. Asset Code Highlight Box
        const badgeY = 660;
        const badgeHeight = 72;
        const badgeWidth = width - 80;
        const badgeX = 40;

        ctx.fillStyle = '#e0f2fe';
        ctx.beginPath();
        if (ctx.roundRect) {
            ctx.roundRect(badgeX, badgeY, badgeWidth, badgeHeight, 12);
        } else {
            ctx.rect(badgeX, badgeY, badgeWidth, badgeHeight);
        }
        ctx.fill();

        ctx.strokeStyle = '#0284c7';
        ctx.lineWidth = 2.5;
        ctx.stroke();

        ctx.fillStyle = '#0369a1';
        ctx.font = 'bold 30px "JetBrains Mono", monospace';
        ctx.textAlign = 'center';
        ctx.fillText(currentAssetCode, width / 2, badgeY + 46);

        // 6. Asset Name
        ctx.fillStyle = '#0c1a2e';
        ctx.font = 'bold 28px "Plus Jakarta Sans", sans-serif';
        ctx.textAlign = 'center';
        let displayName = currentAssetName;
        if (displayName.length > 38) {
            displayName = displayName.substring(0, 35) + '...';
        }
        ctx.fillText(displayName, width / 2, 790);

        // 7. Subtitle / Scan Hint
        ctx.fillStyle = '#64748b';
        ctx.font = '500 16px "Plus Jakarta Sans", sans-serif';
        ctx.fillText('Pindai QR ini untuk cek spesifikasi & ajukan laporan perbaikan', width / 2, 835);

        // 8. Footer Line & Credit
        ctx.strokeStyle = '#e2e8f0';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(60, 880);
        ctx.lineTo(width - 60, 880);
        ctx.stroke();

        ctx.fillStyle = '#94a3b8';
        ctx.font = '600 14px "Plus Jakarta Sans", sans-serif';
        ctx.fillText('IRGT School — IT Infrastructure Management', width / 2, 925);

        // Trigger Download
        const link = document.createElement('a');
        link.download = 'LABEL_' + currentAssetCode.replace(/[^a-zA-Z0-9_-]/g, '_') + '.png';
        link.href = canvas.toDataURL('image/png');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
    img.src = qrImg.src;
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeQrModal();
});

// BULK SELECTION & BULK PRINT
function toggleSelectAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.asset-checkbox');
    checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
    updateSelectedCount();
}

function updateSelectedCount() {
    const selected = document.querySelectorAll('.asset-checkbox:checked');
    const count = selected.length;
    const bar = document.getElementById('bulkActionBar');
    const badge = document.getElementById('selectedCountBadge');
    
    if (badge) badge.innerText = count;
    
    if (bar) {
        if (count > 0) {
            bar.style.transform = 'translateX(-50%) translateY(0)';
        } else {
            bar.style.transform = 'translateX(-50%) translateY(120px)';
        }
    }
}

function deselectAll() {
    document.querySelectorAll('.asset-checkbox').forEach(cb => cb.checked = false);
    const master = document.getElementById('selectAllCheckbox');
    if (master) master.checked = false;
    updateSelectedCount();
}

function submitBulkPrint() {
    const selected = Array.from(document.querySelectorAll('.asset-checkbox:checked')).map(cb => cb.value);
    if (selected.length === 0) {
        alert('Silakan pilih setidaknya satu aset untuk dicetak label!');
        return;
    }
    const url = "{{ route('assets.bulk-print') }}?ids=" + selected.join(',');
    window.open(url, '_blank');
}
</script>

<!-- FLOATING BULK ACTION BAR -->
<div id="bulkActionBar" style="position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(120px); background: #0c1a2e; color: #fff; padding: 12px 24px; border-radius: 40px; box-shadow: 0 12px 36px rgba(0,0,0,0.35); display: flex; align-items: center; gap: 16px; z-index: 1000; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 2px solid #0369a1;">
    <div style="font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <span id="selectedCountBadge" style="background: #0ea5e9; color: #fff; padding: 3px 9px; border-radius: 20px; font-size: 12px; font-weight: 800;">0</span>
        <span>Aset Dipilih</span>
    </div>
    <button onclick="submitBulkPrint()" style="background: linear-gradient(135deg, #0ea5e9, #0369a1); color: #fff; border: none; padding: 9px 20px; border-radius: 30px; font-size: 13px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; font-family: inherit; box-shadow: 0 4px 14px rgba(3,105,161,0.4); transition: transform 0.15s;">
        Cetak Massal Label QR (A4)
    </button>
    <button onclick="deselectAll()" style="background: rgba(255,255,255,0.12); color: #bae6fd; border: none; padding: 9px 14px; border-radius: 30px; font-size: 12.5px; font-weight: 700; cursor: pointer; font-family: inherit;">
        Batal
    </button>
</div>

</body>
</html>
