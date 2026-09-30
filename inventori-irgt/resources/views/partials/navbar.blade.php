<!-- UNIFIED GLOBAL NAVBAR + ANDROID MOBILE APP BAR & OFFCANVAS DRAWER -->
<style>
    /* DESKTOP NAVBAR BASE */
    .app-navbar {
        background: #0c1a2e;
        height: 64px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        gap: 16px;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .app-nav-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #fff;
        flex-shrink: 0;
        transition: opacity 0.15s;
    }
    .app-nav-brand:hover {
        opacity: 0.92;
    }

    .app-nav-logo {
        width: 38px;
        height: 38px;
        background: #ffffff;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
        flex-shrink: 0;
        overflow: hidden;
        padding: 3px;
    }

    .app-nav-brand-text h2 {
        font-size: 14.5px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: -0.01em;
        margin: 0;
        padding: 0;
    }

    .app-nav-brand-text span {
        font-size: 10px;
        color: #7dd3fc;
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    /* NAV LINKS LIST */
    .app-nav-menu-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .app-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .app-nav-item {
        position: relative;
    }

    .app-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        color: #bae6fd;
        transition: all 0.15s ease;
        white-space: nowrap;
        background: transparent;
        border: none;
        cursor: pointer;
        font-family: inherit;
        line-height: 1.4;
    }

    .app-nav-link:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.08);
    }

    .app-nav-link.active {
        color: #ffffff;
        background: #0369a1;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(3, 105, 161, 0.35);
    }

    .app-nav-badge {
        background: #ef4444;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 10px;
        line-height: 1.2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 2px;
    }

    /* DROPDOWN MENU */
    .app-dropdown {
        position: relative;
    }

    .app-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 220px;
        background: #0f233d;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        padding: 6px;
        z-index: 1050;
        backdrop-filter: blur(8px);
    }

    .app-dropdown:hover .app-dropdown-menu,
    .app-dropdown:focus-within .app-dropdown-menu {
        display: block;
        animation: appNavFadeDown 0.15s ease-out;
    }

    @keyframes appNavFadeDown {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .app-dropdown-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 12px;
        color: #e0f2fe;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.12s;
    }

    .app-dropdown-item:hover {
        background: rgba(14, 165, 233, 0.18);
        color: #ffffff;
        transform: translateX(2px);
    }

    .app-dropdown-item.active {
        background: #0284c7;
        color: #ffffff;
    }

    .app-dropdown-item svg {
        flex-shrink: 0;
        color: #38bdf8;
    }

    .app-dropdown-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.08);
        margin: 4px 6px;
    }

    /* RIGHT SIDE USER & LOGOUT */
    .app-nav-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .app-btn-quick-add {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: #ffffff;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35);
        transition: all 0.15s;
    }
    .app-btn-quick-add:hover {
        background: #0369a1;
        transform: translateY(-1px);
    }

    .app-user-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px 10px;
        border-radius: 30px;
    }

    .app-user-avatar {
        width: 26px;
        height: 26px;
        background: #0369a1;
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .app-user-name {
        font-size: 11.5px;
        font-weight: 600;
        color: #f0f9ff;
        line-height: 1.2;
        max-width: 110px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .app-user-role {
        font-size: 9.5px;
        color: #7dd3fc;
        text-transform: capitalize;
        line-height: 1.1;
    }

    .app-btn-logout {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.25);
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }

    .app-btn-logout:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    /* ==========================================================================
       ANDROID / MOBILE BOTTOM NAVIGATION BAR & OFFCANVAS DRAWER (SCREEN <= 768PX)
       ========================================================================== */
    .mobile-bottom-nav {
        display: none;
    }

    .mobile-drawer-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(4px);
        z-index: 2000;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .mobile-drawer-backdrop.active {
        display: block;
        opacity: 1;
    }

    .mobile-drawer {
        position: fixed;
        top: 0;
        right: -320px;
        width: 300px;
        max-width: 85vw;
        height: 100%;
        background: #0c1a2e;
        z-index: 2010;
        box-shadow: -4px 0 25px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        transition: right 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .mobile-drawer.active {
        right: 0;
    }

    .mobile-drawer-header {
        padding: 20px 18px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .mobile-drawer-close {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .app-nav-hamburger {
        display: none;
    }

    @media (max-width: 768px) {
        .app-nav-hamburger {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            border: none;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
        }
    }

    .mobile-user-card {
        margin: 14px 18px;
        padding: 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mobile-drawer-menu {
        padding: 10px 14px;
        flex: 1;
    }

    .mobile-menu-section {
        margin-bottom: 16px;
    }

    .mobile-menu-heading {
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #7dd3fc;
        padding: 6px 10px;
    }

    .mobile-menu-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 12px;
        color: #e0f2fe;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 10px;
        margin-bottom: 3px;
        min-height: 44px;
        transition: background 0.15s;
    }

    .mobile-menu-link:active, .mobile-menu-link:hover {
        background: rgba(14, 165, 233, 0.15);
        color: #ffffff;
    }

    .mobile-menu-link.active {
        background: #0284c7;
        color: #ffffff;
    }

    .mobile-menu-link-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .mobile-drawer-footer {
        padding: 16px 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        background: #081322;
    }

    @media (max-width: 768px) {
        .app-nav-menu-wrapper {
            display: none !important;
        }

        .app-nav-right .app-user-pill,
        .app-nav-right form,
        .app-nav-right .app-btn-quick-add {
            display: none !important;
        }

        .mobile-bottom-nav {
            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 62px;
            background: rgba(12, 26, 46, 0.96);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            padding-bottom: env(safe-area-inset-bottom);
            justify-content: space-around;
            align-items: center;
        }

        .mobile-nav-btn {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #94a3b8;
            font-size: 10.5px;
            font-weight: 600;
            height: 100%;
            min-height: 48px;
            gap: 3px;
            background: none;
            border: none;
            cursor: pointer;
            position: relative;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-nav-btn.active, .mobile-nav-btn:active {
            color: #38bdf8;
            transform: scale(1.05);
        }

        .mobile-nav-btn svg {
            width: 20px;
            height: 20px;
            transition: transform 0.2s ease;
        }

        .mobile-nav-btn:active svg {
            transform: translateY(-2px);
        }

        /* CENTER PROMINENT SCAN BUTTON WITH PULSING GLOW ANIMATION */
        .mobile-nav-scan {
            position: relative;
            top: -14px;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 18px rgba(14, 165, 233, 0.6);
            border: 3px solid #0c1a2e;
            text-decoration: none;
            flex-shrink: 0;
            animation: mobileScanGlow 3s infinite;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes mobileScanGlow {
            0%, 100% { box-shadow: 0 4px 16px rgba(14, 165, 233, 0.45); }
            50% { box-shadow: 0 4px 24px rgba(56, 189, 248, 0.85); transform: translateY(-2px); }
        }

        .mobile-nav-scan:active {
            transform: scale(0.90);
        }

        .mobile-nav-scan svg {
            width: 24px;
            height: 24px;
        }
    }
</style>

<!-- RECOVERY MODE NOTIFICATION BANNER (SUPER ADMIN & ADMIN) -->
@if(\App\Models\SystemSetting::isRecoveryMode() && auth()->check() && in_array(auth()->user()->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_ADMIN], true))
<div style="background: linear-gradient(135deg, #b45309, #92400e); color: #ffffff; padding: 8px 18px; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; justify-content: space-between; gap: 12px; z-index: 1050; position: sticky; top: 0; box-shadow: 0 2px 12px rgba(0,0,0,0.25); font-family: 'Plus Jakarta Sans', sans-serif;">
    <div style="display: flex; align-items: center; gap: 9px;">
        <span style="display: inline-block; width: 9px; height: 9px; border-radius: 50%; background: #fde047; box-shadow: 0 0 8px #fde047;"></span>
        <span><strong>MODE PEMULIHAN AKTIF:</strong> Pengunjung publik saat ini dialihkan ke layar <em>"Website Sedang Dalam Pemulihan oleh Tim IT IRGT"</em>. Akun Anda tetap dapat beroperasi normal.</span>
    </div>
    <div style="display: flex; align-items: center; gap: 8px;">
        @if(auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
            <a href="{{ route('system-recovery.preview') }}" target="_blank" style="color: #fef08a; text-decoration: underline; font-size: 11.5px; font-weight: 700;">Pratinjau Layar ↗</a>
            <button type="button" onclick="openRecoveryModal()" style="background: #ffffff; color: #92400e; border: none; padding: 4px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;">
                Kelola / Matikan
            </button>
        @else
            <span style="background: rgba(255,255,255,0.15); padding: 4px 10px; border-radius: 6px; font-size: 11px;">Akses Terbuka untuk Staf Admin</span>
        @endif
    </div>
</div>
@endif

<!-- TOP NAVBAR -->
<nav class="app-navbar">
    <!-- BRAND LOGO -->
    <a href="{{ route('dashboard') }}" class="app-nav-brand">
        @if(file_exists(public_path('images/logo.png')) || file_exists(public_path('images/logo.jpg')) || file_exists(public_path('images/logo.jpeg')) || file_exists(public_path('images/logo.svg')))
            <div class="app-nav-logo">
                @include('partials.navbar-logo')
            </div>
        @else
            <div class="app-nav-logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
        @endif
        <div class="app-nav-brand-text">
            <h2>IRGT INVENTORY</h2>
            <span>Management System</span>
        </div>
    </a>

    <!-- DESKTOP NAV MENU -->
    <div class="app-nav-menu-wrapper">
        <ul class="app-nav-links">
            <!-- 1. DASHBOARD -->
            <li class="app-nav-item">
                <a href="{{ route('dashboard') }}" class="app-nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- 2. INVENTARIS DROPDOWN -->
            <li class="app-nav-item app-dropdown">
                <button type="button" class="app-nav-link {{ (request()->routeIs('assets*') || request()->routeIs('asset-groups*') || request()->routeIs('scan*') || request()->routeIs('public.assets*')) ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    <span>Inventaris</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="app-dropdown-menu">
                    <a href="{{ route('assets.index') }}" class="app-dropdown-item {{ (request()->routeIs('assets.index') || request()->routeIs('assets.show') || request()->routeIs('assets.edit') || request()->routeIs('assets.history')) ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>Daftar Inventaris</span>
                    </a>
                    <a href="{{ route('asset-groups.index') }}" class="app-dropdown-item {{ request()->routeIs('asset-groups*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Bundel Meja & Walas</span>
                    </a>
                    <a href="{{ route('assets.create') }}" class="app-dropdown-item {{ request()->routeIs('assets.create*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Tambah Aset Baru</span>
                    </a>
                    <div class="app-dropdown-divider"></div>
                    <a href="{{ route('scan.camera') }}" class="app-dropdown-item {{ request()->routeIs('scan*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Scan QR Langsung</span>
                    </a>
                    <a href="{{ route('public.assets.index') }}" target="_blank" class="app-dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        <span>Katalog Publik ↗</span>
                    </a>
                </div>
            </li>

            <!-- 3. LAYANAN & TIKET DROPDOWN -->
            <li class="app-nav-item app-dropdown">
                <button type="button" class="app-nav-link {{ (request()->routeIs('reports*') || request()->routeIs('borrowings*') || request()->routeIs('maintenance-schedules*') || request()->routeIs('audits*') || request()->routeIs('cctv*')) ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                    <span>Layanan & Tiket</span>
                    @if(isset($pendingReportsCount) && $pendingReportsCount > 0)
                        <span class="app-nav-badge">{{ $pendingReportsCount }}</span>
                    @endif
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="app-dropdown-menu">
                    <a href="{{ route('reports.index') }}" class="app-dropdown-item {{ request()->routeIs('reports*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        <span>Laporan Maintenance</span>
                        @if(isset($pendingReportsCount) && $pendingReportsCount > 0)
                            <span class="app-nav-badge">{{ $pendingReportsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('borrowings.index') }}" class="app-dropdown-item {{ request()->routeIs('borrowings*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Peminjaman Aset</span>
                    </a>
                    <a href="{{ route('maintenance-schedules.index') }}" class="app-dropdown-item {{ request()->routeIs('maintenance-schedules*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>Preventive Maintenance</span>
                    </a>
                    <div class="app-dropdown-divider"></div>
                    <a href="{{ route('audits.index') }}" class="app-dropdown-item {{ request()->routeIs('audits*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Audit Akhir Bulan</span>
                    </a>
                    <a href="{{ route('cctv.index') }}" class="app-dropdown-item {{ request()->routeIs('cctv*') ? 'active' : '' }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                        <span>Diagnostik CCTV</span>
                    </a>
                </div>
            </li>

            <!-- 4. KELOLA PENGGUNA -->
            @if(auth()->check() && in_array(auth()->user()->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_ADMIN], true))
            <li class="app-nav-item">
                <a href="{{ route('users.index') }}" class="app-nav-link {{ request()->routeIs('users*') ? 'active' : '' }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Kelola Pengguna</span>
                </a>
            </li>
            @endif
        </ul>
    </div>

    <!-- RIGHT SIDE USER & ACTION -->
    <div class="app-nav-right">
        @if(auth()->check() && auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
        <button type="button" onclick="openRecoveryModal()" class="app-btn-quick-add" style="background: {{ \App\Models\SystemSetting::isRecoveryMode() ? 'linear-gradient(135deg, #f59e0b, #d97706)' : 'rgba(255,255,255,0.08)' }}; border: 1px solid {{ \App\Models\SystemSetting::isRecoveryMode() ? '#f59e0b' : 'rgba(255,255,255,0.15)' }};" title="Pengaturan Mode Pemulihan IT">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            <span>{{ \App\Models\SystemSetting::isRecoveryMode() ? 'Pemulihan (AKTIF)' : 'Mode Pemulihan' }}</span>
        </button>
        @endif

        <a href="{{ route('scan.camera') }}" class="app-btn-quick-add" title="Buka Scanner QR">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Scan QR</span>
        </a>

        @if(auth()->check())
        <div class="app-user-pill">
            <div class="app-user-avatar">{{ auth()->user()->initials() }}</div>
            <div>
                <div class="app-user-name" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</div>
                <div class="app-user-role">{{ str_replace('_', ' ', auth()->user()->role) }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="app-btn-logout" title="Keluar dari akun">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Keluar</span>
            </button>
        </form>
        @endif

        <button type="button" class="app-nav-hamburger" onclick="openMobileDrawer()" title="Buka Menu Lengkap">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </div>
</nav>

<!-- ANDROID / MOBILE BOTTOM NAVIGATION BAR -->
<div class="mobile-bottom-nav">
    <a href="{{ route('dashboard') }}" class="mobile-nav-btn {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('assets.index') }}" class="mobile-nav-btn {{ request()->routeIs('assets*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
        <span>Inventaris</span>
    </a>

    <!-- FLOATING CENTER SCAN BUTTON -->
    <a href="{{ route('scan.camera') }}" class="mobile-nav-scan" title="Scan QR Code">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    </a>

    <a href="{{ route('reports.index') }}" class="mobile-nav-btn {{ request()->routeIs('reports*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
        <span>Layanan</span>
        @if(isset($pendingReportsCount) && $pendingReportsCount > 0)
            <span class="app-nav-badge" style="position: absolute; top: 4px; right: 20%;">{{ $pendingReportsCount }}</span>
        @endif
    </a>

    <button type="button" class="mobile-nav-btn" onclick="openMobileDrawer()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        <span>Menu</span>
    </button>
</div>

<!-- OFFCANVAS MOBILE DRAWER -->
<div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop" onclick="closeMobileDrawer()"></div>
<div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-header">
        <div style="display: flex; align-items: center; gap: 8px;">
            <div class="app-nav-logo" style="width: 30px; height: 30px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            </div>
            <strong style="color: #fff; font-size: 14px;">Menu Aplikasi</strong>
        </div>
        <button type="button" class="mobile-drawer-close" onclick="closeMobileDrawer()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    @if(auth()->check())
    <div class="mobile-user-card">
        <div class="app-user-avatar" style="width: 36px; height: 36px; font-size: 14px;">{{ auth()->user()->initials() }}</div>
        <div style="min-width: 0; flex: 1;">
            <div style="font-size: 13px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</div>
            <div style="font-size: 11px; color: #7dd3fc; text-transform: capitalize;">{{ str_replace('_', ' ', auth()->user()->role) }}</div>
        </div>
    </div>
    @endif

    <div class="mobile-drawer-menu">
        <div class="mobile-menu-section">
            <div class="mobile-menu-heading">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="mobile-menu-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Dashboard Ringkasan</span>
                </span>
            </a>
            <a href="{{ route('assets.index') }}" class="mobile-menu-link {{ request()->routeIs('assets.index') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    <span>Daftar Semua Aset</span>
                </span>
            </a>
            <a href="{{ route('asset-groups.index') }}" class="mobile-menu-link {{ request()->routeIs('asset-groups*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Bundel Meja & Walas</span>
                </span>
            </a>
            <a href="{{ route('assets.create') }}" class="mobile-menu-link {{ request()->routeIs('assets.create*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah Data Baru</span>
                </span>
            </a>
            <a href="{{ route('scan.camera') }}" class="mobile-menu-link {{ request()->routeIs('scan*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Scan QR Langsung</span>
                </span>
            </a>
        </div>

        <div class="mobile-menu-section">
            <div class="mobile-menu-heading">Layanan & Pemeliharaan</div>
            <a href="{{ route('reports.index') }}" class="mobile-menu-link {{ request()->routeIs('reports*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                    <span>Laporan Maintenance</span>
                </span>
                @if(isset($pendingReportsCount) && $pendingReportsCount > 0)
                    <span class="app-nav-badge">{{ $pendingReportsCount }}</span>
                @endif
            </a>
            <a href="{{ route('borrowings.index') }}" class="mobile-menu-link {{ request()->routeIs('borrowings*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    <span>Peminjaman Aset</span>
                </span>
            </a>
            <a href="{{ route('maintenance-schedules.index') }}" class="mobile-menu-link {{ request()->routeIs('maintenance-schedules*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Preventive Maintenance</span>
                </span>
            </a>
            <a href="{{ route('audits.index') }}" class="mobile-menu-link {{ request()->routeIs('audits*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    <span>Audit Akhir Bulan</span>
                </span>
            </a>
            <a href="{{ route('cctv.index') }}" class="mobile-menu-link {{ request()->routeIs('cctv*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                    <span>Diagnostik CCTV</span>
                </span>
            </a>
        </div>

        @if(auth()->check() && in_array(auth()->user()->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_ADMIN], true))
        <div class="mobile-menu-section">
            <div class="mobile-menu-heading">Administrasi</div>
            <a href="{{ route('users.index') }}" class="mobile-menu-link {{ request()->routeIs('users*') ? 'active' : '' }}">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path></svg>
                    <span>Kelola Pengguna</span>
                </span>
            </a>
            <a href="{{ route('public.assets.index') }}" target="_blank" class="mobile-menu-link">
                <span class="mobile-menu-link-left">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline></svg>
                    <span>Katalog Publik ↗</span>
                </span>
            </a>
        </div>
        @endif
    </div>

    @if(auth()->check())
    <div class="mobile-drawer-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="app-btn-logout" style="width: 100%; justify-content: center; padding: 10px; font-size: 13px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Keluar dari Akun</span>
            </button>
        </form>
    </div>
    @endif
</div>

<script>
    function openMobileDrawer() {
        document.getElementById('mobileDrawer').classList.add('active');
        document.getElementById('mobileDrawerBackdrop').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileDrawer() {
        document.getElementById('mobileDrawer').classList.remove('active');
        document.getElementById('mobileDrawerBackdrop').classList.remove('active');
        document.body.style.overflow = '';
    }

    function openRecoveryModal() {
        const modal = document.getElementById('recoveryModalBackdrop');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeRecoveryModal() {
        const modal = document.getElementById('recoveryModalBackdrop');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
</script>

<!-- SUPER ADMIN RECOVERY SETTINGS MODAL -->
@if(auth()->check() && auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
<div class="recovery-modal-backdrop" id="recoveryModalBackdrop" style="display:none; position:fixed; inset:0; background:rgba(8,19,34,0.8); backdrop-filter:blur(6px); z-index:3000; align-items:center; justify-content:center; padding:18px;">
    <div style="background:#0c1a2e; border:1.5px solid rgba(56,189,248,0.3); border-radius:22px; max-width:500px; width:100%; padding:26px 28px; box-shadow:0 25px 70px rgba(0,0,0,0.65); color:#fff; font-family:'Plus Jakarta Sans',sans-serif;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:12px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(217,119,6,0.4);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                </div>
                <div>
                    <h3 style="font-size:15px; font-weight:800; color:#fff; margin:0;">Mode Pemulihan Sistem IT</h3>
                    <span style="font-size:11px; color:#7dd3fc;">Khusus Pengaturan Super Admin IRGT</span>
                </div>
            </div>
            <button type="button" onclick="closeRecoveryModal()" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:32px; height:32px; border-radius:8px; cursor:pointer; font-size:15px; display:flex; align-items:center; justify-content:center;">✕</button>
        </div>

        <form action="{{ route('system-recovery.toggle') }}" method="POST">
            @csrf
            @php $rec = \App\Models\SystemSetting::getRecoveryDetails(); @endphp
            
            <div style="background:rgba(255,255,255,0.05); border:1.5px solid {{ $rec['is_active'] ? '#f59e0b' : 'rgba(255,255,255,0.1)' }}; border-radius:14px; padding:14px; margin-bottom:16px;">
                <label style="display:flex; align-items:center; justify-content:space-between; cursor:pointer;">
                    <div style="padding-right:12px;">
                        <div style="font-size:13px; font-weight:800; color:{{ $rec['is_active'] ? '#fbbf24' : '#fff' }};">
                            Status: {{ $rec['is_active'] ? 'AKTIF (Dalam Pemulihan)' : 'NONAKTIF (Online)' }}
                        </div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                            Saat aktif, publik & pengguna biasa dialihkan ke layar pemulihan IT beranimasi.
                        </div>
                    </div>
                    <select name="enabled" style="background:#0369a1; color:#fff; border:1px solid #38bdf8; padding:7px 12px; border-radius:8px; font-weight:800; font-size:12.5px; cursor:pointer; outline:none;">
                        <option value="0" {{ !$rec['is_active'] ? 'selected' : '' }}>🟢 NONAKTIF (Online)</option>
                        <option value="1" {{ $rec['is_active'] ? 'selected' : '' }}>🟡 AKTIFKAN (Pemulihan)</option>
                    </select>
                </label>
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:11.5px; font-weight:700; color:#bae6fd; margin-bottom:5px;">Judul Halaman Pemulihan</label>
                <input type="text" name="title" value="{{ $rec['title'] }}" style="width:100%; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:9px 12px; color:#fff; font-size:13px; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:11.5px; font-weight:700; color:#bae6fd; margin-bottom:5px;">Pesan / Keterangan untuk Pengunjung</label>
                <textarea name="message" rows="3" style="width:100%; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:9px 12px; color:#fff; font-size:12px; box-sizing:border-box; resize:vertical;">{{ $rec['message'] }}</textarea>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:11.5px; font-weight:700; color:#bae6fd; margin-bottom:5px;">Estimasi Selesai (Opsional)</label>
                <input type="text" name="estimated_end" value="{{ $rec['estimated_end'] }}" placeholder="Contoh: 30 Menit / Pukul 15:00 WIB" style="width:100%; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:9px 12px; color:#fff; font-size:12.5px; box-sizing:border-box;">
            </div>

            <div style="display:flex; gap:10px;">
                <a href="{{ route('system-recovery.preview') }}" target="_blank" style="flex:1; text-align:center; padding:10px; background:rgba(255,255,255,0.08); color:#7dd3fc; border:1px solid rgba(255,255,255,0.15); border-radius:10px; font-size:12.5px; font-weight:700; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span>Pratinjau</span>
                </a>
                <button type="submit" style="flex:1.4; padding:10px; background:linear-gradient(135deg,#0ea5e9,#0369a1); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:800; cursor:pointer; box-shadow:0 4px 14px rgba(3,105,161,0.35);">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endif
