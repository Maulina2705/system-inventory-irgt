<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetGroupController;
use App\Http\Controllers\MaintenanceReportController;
use App\Http\Controllers\PublicAssetController;
use App\Http\Controllers\PublicAssetDetailController;
use App\Http\Controllers\PublicReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AssetAuditController;
use App\Http\Controllers\CctvCheckController;
use App\Models\User;

Route::redirect('/', '/login')->name('home');

Route::get('/public-assets', [PublicAssetController::class, 'index'])
    ->name('public.assets.index');

// QR Code Scan & Pengaduan Publik — Dilindungi Rate Limiting (Maks 15 req/menit)
Route::get('/asset/scan/{token}', [PublicAssetDetailController::class, 'scan'])
    ->name('asset.scan');

Route::middleware(['throttle:15,1'])->group(function () {
    Route::get('/asset/scan/{token}/report', [PublicReportController::class, 'create'])
        ->name('public.reports.create');

    Route::get('/asset/scan/{token}/borrow', [\App\Http\Controllers\BorrowingController::class, 'publicCreate'])
        ->name('public.borrowings.create');

    Route::post('/asset/scan/{token}/borrow', [\App\Http\Controllers\BorrowingController::class, 'publicStore'])
        ->name('public.borrowings.store');

    // Lacak Progress Pengaduan Publik dengan Nomor Tiket
    Route::get('/tracking', [PublicReportController::class, 'track'])
        ->name('public.reports.track');
});

// ==========================================
// DASHBOARD EKSEKUTIF ADMIN
// ==========================================
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// ==========================================
// PENGELOLAAN ASET (ADMIN & SUPER ADMIN)
// ==========================================
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->group(function () {
    // Manajemen Pengelompokan / Bundel Meja & Ruangan (Walas, Proyektor, Lab)
    Route::get('/asset-groups', [AssetGroupController::class, 'index'])->name('asset-groups.index');
    Route::post('/asset-groups', [AssetGroupController::class, 'store'])->name('asset-groups.store');
    Route::put('/asset-groups/{group_code}', [AssetGroupController::class, 'update'])->name('asset-groups.update');
    Route::post('/asset-groups/detach', [AssetGroupController::class, 'detach'])->name('asset-groups.detach');
    Route::delete('/asset-groups/{group_code}', [AssetGroupController::class, 'destroy'])->name('asset-groups.destroy');

    // Export Data & Cetak Rekap (Ditempatkan sebelum parameter dynamic)
    Route::get('/assets/export/csv', [AssetController::class, 'exportCsv'])->name('assets.export.csv');
    Route::get('/assets/print-recap', [AssetController::class, 'printRecap'])->name('assets.print-recap');
    Route::get('/assets/bulk-print', [AssetController::class, 'bulkPrintLabels'])->name('assets.bulk-print');
    Route::get('/assets/group-print/{group_code}', [AssetController::class, 'printGroupLabel'])->name('assets.group-print');

    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::post('/assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');

    // QR Code & Cetak Label Satuan
    Route::get('/assets/{asset}/qr', [AssetController::class, 'qr'])->name('assets.qr');
    Route::get('/assets/{asset}/print-label', [AssetController::class, 'printLabel'])->name('assets.print-label');

    // Histori Aset
    Route::get('/assets/{asset}/history', [AssetController::class, 'history'])->name('assets.history');
});

// ==========================================
// LAPORAN MAINTENANCE & PENGAJUAN SERVIS
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Export Laporan & Cetak Rekap (Wajib SEBELUM route /reports/{report} agar tidak tertimpa parameter ID)
    Route::get('/reports/export/csv', [MaintenanceReportController::class, 'exportCsv'])->name('reports.export.csv');
    Route::get('/reports/print-recap', [MaintenanceReportController::class, 'printRecap'])->name('reports.print-recap');

    // User & Admin: Melihat daftar laporan, form buat laporan, detail laporan
    Route::get('/reports', [MaintenanceReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [MaintenanceReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [MaintenanceReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [MaintenanceReportController::class, 'show'])->name('reports.show');

    // Khusus Admin & Super Admin: Update status pengerjaan laporan & hapus tiket
    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::patch('/reports/{report}/status', [MaintenanceReportController::class, 'updateStatus'])->name('reports.update-status');
        Route::delete('/reports/{report}', [MaintenanceReportController::class, 'destroy'])->name('reports.destroy');
    });
});

// ==========================================
// AUDIT ASET AKHIR BULAN & PENGESAHAN KOORDINATOR LAB
// ==========================================
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->group(function () {
    Route::get('/audits/export/csv', [AssetAuditController::class, 'exportCsv'])->name('audits.export.csv');
    Route::get('/audits/print-recap', [AssetAuditController::class, 'printRecap'])->name('audits.print-recap');
    Route::get('/audits', [AssetAuditController::class, 'index'])->name('audits.index');
    Route::get('/audits/create', [AssetAuditController::class, 'create'])->name('audits.create');
    Route::post('/audits', [AssetAuditController::class, 'store'])->name('audits.store');
    Route::get('/audits/{audit}', [AssetAuditController::class, 'show'])->name('audits.show');
    Route::get('/audits/{audit}/print', [AssetAuditController::class, 'print'])->name('audits.print');
    Route::delete('/audits/{audit}', [AssetAuditController::class, 'destroy'])->name('audits.destroy');

    // ==========================================
    // PEMERIKSAAN & DIAGNOSTIK CCTV
    // ==========================================
    Route::get('/cctv', [CctvCheckController::class, 'index'])->name('cctv.index');
    Route::get('/cctv/create', [CctvCheckController::class, 'create'])->name('cctv.create');
    Route::post('/cctv', [CctvCheckController::class, 'store'])->name('cctv.store');
    Route::delete('/cctv/{cctv}', [CctvCheckController::class, 'destroy'])->name('cctv.destroy');

    // ==========================================
    // MODUL PEMINJAMAN ASET (CHECK-IN / CHECK-OUT)
    // ==========================================
    Route::get('/borrowings', [\App\Http\Controllers\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/create', [\App\Http\Controllers\BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrowings', [\App\Http\Controllers\BorrowingController::class, 'store'])->name('borrowings.store');
    Route::post('/borrowings/{borrowing}/approve', [\App\Http\Controllers\BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [\App\Http\Controllers\BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::post('/borrowings/{borrowing}/return', [\App\Http\Controllers\BorrowingController::class, 'returnAsset'])->name('borrowings.return');
    Route::delete('/borrowings/{borrowing}', [\App\Http\Controllers\BorrowingController::class, 'destroy'])->name('borrowings.destroy');

    // ==========================================
    // PREVENTIVE MAINTENANCE
    // ==========================================
    Route::get('/maintenance-schedules', [\App\Http\Controllers\MaintenanceScheduleController::class, 'index'])->name('maintenance-schedules.index');
    Route::get('/maintenance-schedules/create', [\App\Http\Controllers\MaintenanceScheduleController::class, 'create'])->name('maintenance-schedules.create');
    Route::post('/maintenance-schedules', [\App\Http\Controllers\MaintenanceScheduleController::class, 'store'])->name('maintenance-schedules.store');
    Route::post('/maintenance-schedules/{schedule}/complete', [\App\Http\Controllers\MaintenanceScheduleController::class, 'complete'])->name('maintenance-schedules.complete');
    Route::delete('/maintenance-schedules/{schedule}', [\App\Http\Controllers\MaintenanceScheduleController::class, 'destroy'])->name('maintenance-schedules.destroy');
});

// ==========================================
// QR CODE SCANNER LANGSUNG (BROWSER CAMERA)
// ==========================================
Route::get('/scan', [\App\Http\Controllers\ScanController::class, 'camera'])->name('scan.camera');
Route::post('/scan/lookup', [\App\Http\Controllers\ScanController::class, 'lookup'])->name('scan.lookup');

// ==========================================
// MANAJEMEN PENGGUNA & BACKUP (KHUSUS SUPER ADMIN)
// ==========================================
Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::patch('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Backup Database 1-Klik
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');

    // Mode Pemulihan / Maintenance IT Khusus Super Admin
    Route::post('/system-recovery/toggle', [\App\Http\Controllers\SystemRecoveryController::class, 'toggle'])->name('system-recovery.toggle');
    Route::get('/system-recovery/preview', function () {
        return response()->view('maintenance', \App\Models\SystemSetting::getRecoveryDetails());
    })->name('system-recovery.preview');
});

require __DIR__.'/settings.php';