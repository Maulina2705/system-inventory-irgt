<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAudit;
use App\Models\AssetType;
use App\Models\Borrowing;
use App\Models\CctvCheck;
use App\Models\MaintenanceReport;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Ringkasan Eksekutif untuk Admin dan Super Admin.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // User biasa diarahkan ke laporan mereka
        if ($user->role === User::ROLE_USER) {
            return redirect()->route('reports.index');
        }

        // 1. Matriks Utama Inventaris
        $totalAssets = Asset::count();
        $activeAssets = Asset::where('status', 'ACTIVE')->count();
        $maintenanceAssets = Asset::where('status', 'MAINTENANCE')->count();
        $damagedAssets = Asset::whereIn('status', ['DAMAGED', 'LOST', 'RETIRED'])->count();
        $borrowedAssets = Asset::where('status', 'BORROWED')->count();

        // Kondisi Fisik
        $conditionGood = Asset::where('condition', 'GOOD')->count();
        $conditionFair = Asset::where('condition', 'FAIR')->count();
        $conditionPoor = Asset::whereIn('condition', ['POOR', 'DAMAGED'])->count();

        // 2. Matriks Laporan Maintenance & Biaya
        $totalTickets = MaintenanceReport::count();
        $pendingTickets = MaintenanceReport::where('status', MaintenanceReport::STATUS_PENDING)->count();
        $inProgressTickets = MaintenanceReport::where('status', MaintenanceReport::STATUS_IN_PROGRESS)->count();
        $resolvedTickets = MaintenanceReport::where('status', MaintenanceReport::STATUS_RESOLVED)->count();
        $rejectedTickets = MaintenanceReport::where('status', MaintenanceReport::STATUS_REJECTED)->count();
        $emergencyTickets = MaintenanceReport::whereIn('priority', ['HIGH', 'EMERGENCY'])
            ->whereIn('status', [MaintenanceReport::STATUS_PENDING, MaintenanceReport::STATUS_IN_PROGRESS])
            ->count();

        $resolutionRate = $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100) : 100;

        // Maintenance Cost Tracker KPI
        $monthlyCost = (float) MaintenanceReport::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_cost');

        $yearlyCost = (float) MaintenanceReport::whereYear('created_at', now()->year)
            ->sum('total_cost');

        $formattedMonthlyCost = 'Rp ' . number_format($monthlyCost, 0, ',', '.');
        $formattedYearlyCost = 'Rp ' . number_format($yearlyCost, 0, ',', '.');

        // Top maintenance with highest cost
        $topCostReports = MaintenanceReport::with(['asset.location', 'handler'])
            ->where('total_cost', '>', 0)
            ->orderBy('total_cost', 'desc')
            ->limit(4)
            ->get();

        // 3. Matriks Peminjaman Aset (Borrowings)
        $totalBorrowingsActive = Borrowing::where('status', Borrowing::STATUS_BORROWED)->count();
        $overdueBorrowingsCount = Borrowing::where('status', Borrowing::STATUS_BORROWED)
            ->where('expected_return_at', '<', now())
            ->count();

        // 4. Preventive Maintenance KPI
        $today = Carbon::today();
        $overdueSchedulesCount = MaintenanceSchedule::where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
            ->where('next_maintenance', '<', $today)
            ->count();

        $dueSoonSchedulesCount = MaintenanceSchedule::where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
            ->whereBetween('next_maintenance', [$today, $today->copy()->addDays(7)])
            ->count();

        $upcomingSchedulesCount = MaintenanceSchedule::where('status', '!=', MaintenanceSchedule::STATUS_COMPLETED)
            ->where('next_maintenance', '>', $today->copy()->addDays(7))
            ->count();

        // 5. Status Audit Akhir Bulan Lab & Pengingat Otomatis
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        $currentMonthName = Carbon::now()->translatedFormat('F Y');
        $currentDay = (int) date('j');

        $currentMonthAudit = AssetAudit::with(['inspector', 'location', 'placement'])
            ->where('audit_year', $currentYear)
            ->where('audit_month', $currentMonth)
            ->latest()
            ->first();

        $lastAudit = AssetAudit::with(['inspector', 'location', 'placement'])
            ->orderBy('audit_year', 'desc')
            ->orderBy('audit_month', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $totalAuditsCount = AssetAudit::count();
        
        // Pengingat jika tanggal 25 s/d akhir bulan dan belum ada audit bulan ini
        $isAuditDueReminder = ($currentDay >= 25) && !$currentMonthAudit;

        // 6. Status Pemantauan & Diagnostik CCTV
        $cctvAssets = Asset::where(function ($q) {
            $q->whereHas('assetItem', function ($sq) {
                $sq->where('code', 'CC');
            })->orWhere('name', 'like', '%CCTV%');
        })->with(['location', 'placement', 'cctvChecks'])->get();

        $totalCctv = $cctvAssets->count();
        $cctvOnlineCount = $cctvAssets->filter(fn($a) => $a->cctvChecks->first()?->network_status === 'ONLINE')->count();
        $cctvNeedMaintenanceCount = $cctvAssets->filter(fn($a) => in_array($a->cctvChecks->first()?->overall_verdict, ['NEED_MAINTENANCE', 'REPLACE_DEVICE']) || $a->cctvChecks->first()?->network_status === 'OFFLINE')->count();
        $cctvOfflineCount = $cctvAssets->filter(fn($a) => $a->cctvChecks->first()?->network_status === 'OFFLINE')->count();

        $recentCctvChecks = CctvCheck::with(['asset.location', 'inspector'])
            ->orderBy('check_date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        // 7. Peringatan Masa Garansi
        $sixtyDaysLater = Carbon::today()->addDays(60);

        $expiringAssets = Asset::with(['placement', 'location', 'assetType'])
            ->whereNotNull('warranty_expiry')
            ->whereBetween('warranty_expiry', [$today->copy()->subDays(14), $sixtyDaysLater])
            ->orderBy('warranty_expiry', 'asc')
            ->limit(5)
            ->get();

        $expiringCount = Asset::whereNotNull('warranty_expiry')
            ->whereBetween('warranty_expiry', [$today, $sixtyDaysLater])
            ->count();

        // 8. Distribusi Kategori Perangkat
        $categoriesData = DB::table('assets')
            ->leftJoin('asset_types', 'assets.asset_type_id', '=', 'asset_types.id')
            ->select(DB::raw('COALESCE(asset_types.name, "Perangkat Umum") as type_name'), DB::raw('count(*) as total'))
            ->groupBy('type_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 9. Tren 6 Bulan Terakhir
        $monthLabels = [];
        $createdMonthly = [];
        $resolvedMonthly = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M Y');

            $created = MaintenanceReport::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $resolved = MaintenanceReport::whereYear('resolved_at', $date->year)
                ->whereMonth('resolved_at', $date->month)
                ->where('status', MaintenanceReport::STATUS_RESOLVED)
                ->count();

            $createdMonthly[] = $created;
            $resolvedMonthly[] = $resolved;
        }

        // 10. Tiket Perlu Tindakan Segera
        $urgentTickets = MaintenanceReport::with(['asset.placement', 'asset.location', 'user', 'handler'])
            ->whereIn('status', [MaintenanceReport::STATUS_PENDING, MaintenanceReport::STATUS_IN_PROGRESS])
            ->orderByRaw("CASE WHEN priority = 'EMERGENCY' THEN 1 WHEN priority = 'HIGH' THEN 2 WHEN priority = 'MEDIUM' THEN 3 ELSE 4 END")
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        // 11. Aset Terbaru Ditambahkan
        $recentAssets = Asset::with(['placement', 'location', 'assetType'])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // 12. Distribusi Lokasi
        $locationStats = DB::table('assets')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->select(DB::raw('COALESCE(locations.name, "Tanpa Lokasi") as loc_name'), DB::raw('count(*) as total'))
            ->groupBy('loc_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $totalUsers = User::count();

        return view('dashboard', compact(
            'totalAssets',
            'activeAssets',
            'maintenanceAssets',
            'damagedAssets',
            'borrowedAssets',
            'conditionGood',
            'conditionFair',
            'conditionPoor',
            'totalTickets',
            'pendingTickets',
            'inProgressTickets',
            'resolvedTickets',
            'rejectedTickets',
            'emergencyTickets',
            'resolutionRate',
            'monthlyCost',
            'yearlyCost',
            'formattedMonthlyCost',
            'formattedYearlyCost',
            'topCostReports',
            'totalBorrowingsActive',
            'overdueBorrowingsCount',
            'overdueSchedulesCount',
            'dueSoonSchedulesCount',
            'upcomingSchedulesCount',
            'currentMonthAudit',
            'lastAudit',
            'currentMonthName',
            'isAuditDueReminder',
            'totalAuditsCount',
            'totalCctv',
            'cctvOnlineCount',
            'cctvNeedMaintenanceCount',
            'cctvOfflineCount',
            'recentCctvChecks',
            'expiringAssets',
            'expiringCount',
            'categoriesData',
            'locationStats',
            'monthLabels',
            'createdMonthly',
            'resolvedMonthly',
            'urgentTickets',
            'recentAssets',
            'totalUsers'
        ));
    }
}
