<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\MaintenanceReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicAssetController extends Controller
{
    public function index(Request $request)
    {
        // 1. Matriks Utama
        $totalAssets = Asset::count();
        $activeAssets = Asset::whereRaw('LOWER(status) = ?', ['active'])->count();
        $maintenanceAssets = Asset::whereRaw('LOWER(status) = ?', ['maintenance'])->count();
        $damagedAssets = Asset::whereIn(DB::raw('LOWER(status)'), ['damaged', 'lost', 'rusak', 'hilang'])->count();

        // 2. Matriks Tiket Maintenance
        $totalTickets = MaintenanceReport::count();
        $resolvedTickets = MaintenanceReport::where('status', 'resolved')->count();
        $inProgressTickets = MaintenanceReport::where('status', 'in_progress')->count();
        $pendingTickets = MaintenanceReport::where('status', 'pending')->count();
        $resolutionRate = $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100) : 100;

        // 3. Distribusi Tipe / Kategori Perangkat
        $categoriesData = DB::table('assets')
            ->leftJoin('asset_types', 'assets.asset_type_id', '=', 'asset_types.id')
            ->select(DB::raw('COALESCE(asset_types.name, "Perangkat Umum") as type_name'), DB::raw('count(*) as total'))
            ->groupBy('type_name')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $categoryLabels = $categoriesData->pluck('type_name')->toArray();
        $categoryCounts = $categoriesData->pluck('total')->toArray();
        if (empty($categoryLabels)) {
            $categoryLabels = ['Perangkat Umum'];
            $categoryCounts = [$totalAssets ?: 1];
        }

        // 4. Distribusi Kondisi Fisik
        $conditionGood = Asset::whereIn(DB::raw('LOWER(`condition`)'), ['good', 'baik'])->count();
        $conditionFair = Asset::whereIn(DB::raw('LOWER(`condition`)'), ['fair', 'cukup'])->count();
        $conditionPoor = Asset::whereIn(DB::raw('LOWER(`condition`)'), ['damaged', 'poor', 'rusak'])->count();

        // 5. Tren Bulanan (12 Bulan Terakhir)
        $monthsLabels = [];
        $ticketsCreatedMonthly = [];
        $ticketsResolvedMonthly = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthsLabels[] = $date->format('M Y');

            $createdCount = MaintenanceReport::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $resolvedCount = MaintenanceReport::whereYear('resolved_at', $date->year)
                ->whereMonth('resolved_at', $date->month)
                ->where('status', 'resolved')
                ->count();

            $ticketsCreatedMonthly[] = $createdCount;
            $ticketsResolvedMonthly[] = $resolvedCount;
        }

        // 6. Tren Harian (30 Hari Terakhir)
        $daysLabels = [];
        $ticketsCreatedDaily = [];
        $ticketsResolvedDaily = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayStr = $date->format('Y-m-d');
            $daysLabels[] = $date->format('d M');

            $createdCount = MaintenanceReport::whereDate('created_at', $dayStr)->count();
            $resolvedCount = MaintenanceReport::whereDate('resolved_at', $dayStr)->where('status', 'resolved')->count();

            $ticketsCreatedDaily[] = $createdCount;
            $ticketsResolvedDaily[] = $resolvedCount;
        }

        // 7. Tabel Daftar Aset Publik (dengan pencarian & filter)
        $query = Asset::with(['placement', 'location', 'assetType']);

        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhereHas('placement', function($p) use ($search) {
                      $p->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('location', function($l) use ($search) {
                      $l->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('assetType', function($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type_id')) {
            $query->where('asset_type_id', $request->type_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assets = $query->orderBy('id', 'desc')->paginate(12)->withQueryString();
        $allTypes = AssetType::orderBy('name')->get();

        return view('public-assets.index', compact(
            'totalAssets',
            'activeAssets',
            'maintenanceAssets',
            'damagedAssets',
            'totalTickets',
            'resolvedTickets',
            'inProgressTickets',
            'pendingTickets',
            'resolutionRate',
            'categoryLabels',
            'categoryCounts',
            'conditionGood',
            'conditionFair',
            'conditionPoor',
            'monthsLabels',
            'ticketsCreatedMonthly',
            'ticketsResolvedMonthly',
            'daysLabels',
            'ticketsCreatedDaily',
            'ticketsResolvedDaily',
            'assets',
            'allTypes'
        ));
    }
}