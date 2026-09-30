<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceScheduleController extends Controller
{
    /**
     * Display a listing of preventive maintenance schedules.
     */
    public function index(Request $request): View
    {
        $query = MaintenanceSchedule::with(['asset.placement', 'asset.location', 'asset.assetItem', 'assignee']);

        // Search filter
        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('maintenance_type', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('asset', function ($assetQ) use ($search) {
                      $assetQ->where('asset_code', 'like', "%{$search}%")
                             ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            $today = Carbon::today();

            if ($status === 'OVERDUE') {
                $query->where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
                      ->where('next_maintenance', '<', $today);
            } elseif ($status === 'DUE') {
                $query->where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
                      ->whereBetween('next_maintenance', [$today, $today->copy()->addDays(7)]);
            } elseif ($status === 'UPCOMING') {
                $query->where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
                      ->where('next_maintenance', '>', $today->copy()->addDays(7));
            } elseif ($status === 'COMPLETED') {
                $query->where('status', MaintenanceSchedule::STATUS_COMPLETED);
            }
        }

        $schedules = $query->orderBy('next_maintenance', 'asc')->paginate(15)->withQueryString();

        // Calculate KPI Counts
        $today = Carbon::today();
        $totalOverdue = MaintenanceSchedule::where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
            ->where('next_maintenance', '<', $today)
            ->count();
        $totalDue = MaintenanceSchedule::where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
            ->whereBetween('next_maintenance', [$today, $today->copy()->addDays(7)])
            ->count();
        $totalUpcoming = MaintenanceSchedule::where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
            ->where('next_maintenance', '>', $today->copy()->addDays(7))
            ->count();
        $totalCompleted = MaintenanceSchedule::where('status', MaintenanceSchedule::STATUS_COMPLETED)->count();
        $totalAll = MaintenanceSchedule::count();

        return view('maintenance-schedules.index', compact(
            'schedules',
            'totalOverdue',
            'totalDue',
            'totalUpcoming',
            'totalCompleted',
            'totalAll'
        ));
    }

    /**
     * Show the form for creating a new preventive maintenance schedule.
     */
    public function create(Request $request): View
    {
        $selectedAsset = null;
        if ($request->filled('asset_id')) {
            $selectedAsset = Asset::with(['placement', 'location', 'assetType', 'assetItem'])->find($request->get('asset_id'));
        }

        $assets = Asset::orderBy('name')->get(['id', 'asset_code', 'name', 'brand', 'model']);
        $technicians = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])->orderBy('name')->get();

        return view('maintenance-schedules.create', compact('selectedAsset', 'assets', 'technicians'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'maintenance_type' => ['required', 'string', 'max:255'],
            'interval_months' => ['required', 'integer', 'min:1', 'max:36'],
            'last_maintenance_at' => ['nullable', 'date'],
            'next_maintenance_at' => ['required', 'date'],
            'assigned_to_user_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'asset_id.required' => 'Pilih aset yang akan dijadwalkan.',
            'maintenance_type.required' => 'Jenis tindakan pemeliharaan wajib diisi.',
            'next_maintenance_at.required' => 'Tanggal jadwal berikutnya wajib diisi.',
        ]);

        $maintenanceType = $validated['maintenance_type'];
        if (!empty($validated['title']) && $validated['title'] !== $maintenanceType) {
            $maintenanceType = $validated['title'] . ' (' . $maintenanceType . ')';
        }

        MaintenanceSchedule::create([
            'asset_id' => $validated['asset_id'],
            'maintenance_type' => $maintenanceType,
            'interval_months' => $validated['interval_months'],
            'last_maintenance' => $validated['last_maintenance_at'] ?? null,
            'next_maintenance' => $validated['next_maintenance_at'],
            'assigned_to' => $validated['assigned_to_user_id'] ?? null,
            'status' => MaintenanceSchedule::STATUS_UPCOMING,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('maintenance-schedules.index')
            ->with('success', 'Jadwal preventive maintenance berhasil ditambahkan!');
    }

    /**
     * Complete a scheduled maintenance task and optionally plan the next cycle.
     */
    public function complete(Request $request, MaintenanceSchedule $schedule)
    {
        $validated = $request->validate([
            'completion_notes' => ['nullable', 'string', 'max:1000'],
            'auto_renew' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $notes = trim($validated['completion_notes'] ?? '');
        $autoRenew = $request->boolean('auto_renew', true);

        $schedule->update([
            'status' => MaintenanceSchedule::STATUS_COMPLETED,
            'last_maintenance' => now(),
            'notes' => $schedule->notes . ($notes ? ("\nCatatan Selesai (" . now()->format('d/m/Y') . "): " . $notes) : ''),
        ]);

        // Record history
        if ($schedule->asset) {
            AssetHistory::create([
                'asset_id' => $schedule->asset_id,
                'user_id' => $user ? $user->id : null,
                'action' => 'UPDATED',
                'notes' => "Preventive Maintenance Selesai: \"{$schedule->maintenance_type}\". " . ($notes ? "Hasil: {$notes}" : ""),
            ]);
        }

        // Auto renew next maintenance schedule if requested
        if ($autoRenew) {
            $nextDate = Carbon::today()->addMonths($schedule->interval_months);
            MaintenanceSchedule::create([
                'asset_id' => $schedule->asset_id,
                'maintenance_type' => $schedule->maintenance_type,
                'interval_months' => $schedule->interval_months,
                'last_maintenance' => now(),
                'next_maintenance' => $nextDate,
                'assigned_to' => $schedule->assigned_to,
                'status' => MaintenanceSchedule::STATUS_UPCOMING,
                'notes' => "Jadwal siklus berkala berikutnya setelah perawatan tanggal " . now()->format('d/m/Y'),
            ]);
        }

        return redirect()->route('maintenance-schedules.index')
            ->with('success', "Preventive maintenance \"{$schedule->maintenance_type}\" berhasil ditandai selesai!" . ($autoRenew ? " Jadwal siklus berikutnya telah dibuat otomatis." : ""));
    }

    /**
     * Delete a schedule.
     */
    public function destroy(MaintenanceSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('maintenance-schedules.index')
            ->with('success', 'Jadwal maintenance berhasil dihapus.');
    }
}
