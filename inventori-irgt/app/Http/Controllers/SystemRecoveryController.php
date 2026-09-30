<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SystemRecoveryController extends Controller
{
    /**
     * Toggle or update System Recovery / Maintenance Mode.
     * Exclusively accessible by Super Admin.
     */
    public function toggle(Request $request): RedirectResponse
    {
        // Enforce Super Admin role
        if (!auth()->check() || auth()->user()->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Hanya Super Admin yang memiliki hak akses untuk mengaktifkan Mode Pemulihan Sistem.');
        }

        $validated = $request->validate([
            'enabled' => 'required|in:0,1',
            'title' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
            'estimated_end' => 'nullable|string|max:100',
        ]);

        $isEnabled = $validated['enabled'] === '1';

        SystemSetting::set('recovery_mode_enabled', $isEnabled ? '1' : '0');

        if ($isEnabled) {
            if (!empty($validated['title'])) {
                SystemSetting::set('recovery_mode_title', $validated['title']);
            }
            if (!empty($validated['message'])) {
                SystemSetting::set('recovery_mode_message', $validated['message']);
            }
            if (!empty($validated['estimated_end'])) {
                SystemSetting::set('recovery_mode_estimated_end', $validated['estimated_end']);
            }
            SystemSetting::set('recovery_mode_activated_by', auth()->user()->name);

            Log::info('Mode Pemulihan Sistem DIAKTIFKAN oleh Super Admin: ' . auth()->user()->name);

            return back()->with('success', 'Mode Pemulihan Sistem berhasil DIAKTIFKAN. Pengunjung publik saat ini akan melihat laman pemulihan.');
        } else {
            SystemSetting::set('recovery_mode_activated_by', null);

            Log::info('Mode Pemulihan Sistem DINONAKTIFKAN oleh Super Admin: ' . auth()->user()->name);

            return back()->with('success', 'Mode Pemulihan Sistem berhasil DINONAKTIFKAN. Seluruh layanan inventaris telah kembali online.');
        }
    }
}
