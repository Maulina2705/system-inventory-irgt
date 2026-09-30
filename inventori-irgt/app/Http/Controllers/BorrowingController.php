<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display a listing of asset borrowings.
     */
    public function index(Request $request): View
    {
        $query = Borrowing::with(['asset.placement', 'asset.location', 'asset.assetItem', 'approver']);

        // Search filter
        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('borrowing_code', 'like', "%{$search}%")
                  ->orWhere('borrower_name', 'like', "%{$search}%")
                  ->orWhere('borrower_identifier', 'like', "%{$search}%")
                  ->orWhere('department_class', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhereHas('asset', function ($assetQ) use ($search) {
                      $assetQ->where('asset_code', 'like', "%{$search}%")
                             ->orWhere('name', 'like', "%{$search}%")
                             ->orWhere('serial_number', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'OVERDUE') {
                $query->where('status', Borrowing::STATUS_BORROWED)
                      ->where('expected_return_at', '<', now());
            } else {
                $query->where('status', $status);
            }
        }

        $borrowings = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        // KPI Counts
        $totalBorrowed = Borrowing::where('status', Borrowing::STATUS_BORROWED)->count();
        $totalOverdue = Borrowing::where('status', Borrowing::STATUS_BORROWED)
            ->where('expected_return_at', '<', now())
            ->count();
        $totalReturned = Borrowing::where('status', Borrowing::STATUS_RETURNED)->count();
        $totalAll = Borrowing::count();

        return view('borrowings.index', compact(
            'borrowings',
            'totalBorrowed',
            'totalOverdue',
            'totalReturned',
            'totalAll'
        ));
    }

    /**
     * Show the form for creating a new borrowing.
     */
    public function create(Request $request): View
    {
        $selectedAsset = null;
        if ($request->filled('asset_id')) {
            $selectedAsset = Asset::with(['placement', 'location', 'assetType', 'assetItem'])->find($request->get('asset_id'));
        }

        // Only allow ACTIVE assets to be borrowed
        $availableAssets = Asset::where('status', 'ACTIVE')
            ->orderBy('name')
            ->get(['id', 'asset_code', 'name', 'brand', 'model', 'serial_number']);

        return view('borrowings.create', compact('selectedAsset', 'availableAssets'));
    }

    /**
     * Store a newly created borrowing.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'borrower_name' => ['required', 'string', 'max:255'],
            'borrower_identifier' => ['nullable', 'string', 'max:100'],
            'department_class' => ['nullable', 'string', 'max:100'],
            'purpose' => ['required', 'string', 'max:500'],
            'borrowed_at' => ['required', 'date'],
            'expected_return_at' => ['required', 'date', 'after_or_equal:borrowed_at'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'asset_id.required' => 'Pilih aset yang ingin dipinjam.',
            'borrower_name.required' => 'Nama peminjam wajib diisi.',
            'purpose.required' => 'Keperluan / tujuan peminjaman wajib diisi.',
            'borrowed_at.required' => 'Tanggal pinjam wajib diisi.',
            'expected_return_at.required' => 'Rencana tanggal pengembalian wajib diisi.',
            'expected_return_at.after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',
        ]);

        $asset = Asset::findOrFail($validated['asset_id']);

        // Check if asset is already borrowed or not active
        if ($asset->status === 'BORROWED') {
            return back()->withInput()->with('error', "Aset {$asset->name} ({$asset->asset_code}) saat ini sedang dipinjam oleh pihak lain.");
        }

        if ($asset->status !== 'ACTIVE') {
            return back()->withInput()->with('error', "Aset {$asset->name} ({$asset->asset_code}) tidak dapat dipinjam karena berstatus {$asset->status}.");
        }

        // Generate borrowing code (e.g. BOR-20260929-0001)
        $todayStr = date('Ymd');
        $countToday = Borrowing::whereDate('created_at', today())->count();
        $sequence = $countToday + 1;
        $code = 'BOR-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);

        while (Borrowing::where('borrowing_code', $code)->exists()) {
            $sequence++;
            $code = 'BOR-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
        }

        $user = auth()->user();

        $borrowing = Borrowing::create([
            'borrowing_code' => $code,
            'asset_id' => $asset->id,
            'borrower_name' => $validated['borrower_name'],
            'borrower_identifier' => $validated['borrower_identifier'] ?? null,
            'department' => $validated['department_class'] ?? null,
            'purpose' => $validated['purpose'],
            'borrowed_at' => Carbon::parse($validated['borrowed_at']),
            'expected_return_at' => Carbon::parse($validated['expected_return_at']),
            'status' => Borrowing::STATUS_BORROWED,
            'approved_by' => $user ? $user->id : null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update asset status to BORROWED
        $oldStatus = $asset->status;
        $asset->update([
            'status' => 'BORROWED',
            'last_updated_by_user_id' => $user ? $user->id : null,
        ]);

        // Record history
        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => $user ? $user->id : null,
            'action' => 'STATUS_CHANGED',
            'old_status' => $oldStatus,
            'new_status' => 'BORROWED',
            'notes' => "Aset dipinjam oleh {$validated['borrower_name']} ({$validated['department_class']}) - Tiket #{$code}. Keperluan: {$validated['purpose']}",
        ]);

        return redirect()->route('borrowings.index')->with('success', "Peminjaman aset {$asset->name} (#{$code}) berhasil dicatat!");
    }

    /**
     * Process return of an asset.
     */
    public function returnAsset(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:RETURNED,DAMAGED,LOST'],
            'condition_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = auth()->user();
        $asset = $borrowing->asset;

        $returnStatus = $validated['status'];
        $notes = trim($validated['condition_note'] ?? '');

        $borrowing->update([
            'status' => $returnStatus,
            'returned_at' => now(),
            'notes' => $borrowing->notes . ($notes ? ("\nCatatan Pengembalian: " . $notes) : ''),
        ]);

        if ($asset) {
            $oldStatus = $asset->status;
            $newAssetStatus = match ($returnStatus) {
                'RETURNED' => 'ACTIVE',
                'DAMAGED' => 'DAMAGED',
                'LOST' => 'LOST',
                default => 'ACTIVE',
            };

            $newCondition = match ($returnStatus) {
                'RETURNED' => 'GOOD',
                'DAMAGED' => 'DAMAGED',
                'LOST' => $asset->condition,
                default => 'GOOD',
            };

            $asset->update([
                'status' => $newAssetStatus,
                'condition' => $newCondition,
                'last_updated_by_user_id' => $user ? $user->id : null,
            ]);

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $user ? $user->id : null,
                'action' => 'STATUS_CHANGED',
                'old_status' => $oldStatus,
                'new_status' => $newAssetStatus,
                'notes' => "Peminjaman #{$borrowing->borrowing_code} selesai. Status pengembalian: {$returnStatus}. Catatan: {$notes}",
            ]);
        }

        return redirect()->route('borrowings.index')->with('success', "Aset #{$borrowing->borrowing_code} berhasil diproses pengembaliannya!");
    }

    /**
     * Show form for public/guest borrowing request via QR code.
     */
    public function publicCreate(string $token): View
    {
        $asset = Asset::where('qr_token', $token)
            ->with(['placement', 'location', 'assetType', 'assetItem'])
            ->firstOrFail();

        return view('borrowings.public-create', compact('asset'));
    }

    /**
     * Store public/guest borrowing request via QR code.
     */
    public function publicStore(Request $request, string $token)
    {
        $asset = Asset::where('qr_token', $token)->firstOrFail();

        if ($asset->status === 'BORROWED') {
            return back()->withInput()->with('error', "Aset {$asset->name} saat ini sedang dipinjam.");
        }

        $validated = $request->validate([
            'borrower_name' => ['required', 'string', 'max:255'],
            'borrower_identifier' => ['nullable', 'string', 'max:100'],
            'department_class' => ['nullable', 'string', 'max:100'],
            'purpose' => ['required', 'string', 'max:500'],
            'borrowed_at' => ['required', 'date'],
            'expected_return_at' => ['required', 'date', 'after_or_equal:borrowed_at'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $todayStr = date('Ymd');
        $countToday = Borrowing::whereDate('created_at', today())->count();
        $sequence = $countToday + 1;
        $code = 'BOR-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);

        while (Borrowing::where('borrowing_code', $code)->exists()) {
            $sequence++;
            $code = 'BOR-' . $todayStr . '-' . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
        }

        $user = auth()->user();
        $initialStatus = ($user && in_array($user->role, ['super_admin', 'admin'], true)) 
            ? Borrowing::STATUS_BORROWED 
            : Borrowing::STATUS_PENDING_APPROVAL;

        $borrowing = Borrowing::create([
            'borrowing_code' => $code,
            'asset_id' => $asset->id,
            'borrower_name' => $validated['borrower_name'],
            'borrower_identifier' => $validated['borrower_identifier'] ?? null,
            'department' => $validated['department_class'] ?? null,
            'purpose' => $validated['purpose'],
            'borrowed_at' => Carbon::parse($validated['borrowed_at']),
            'expected_return_at' => Carbon::parse($validated['expected_return_at']),
            'status' => $initialStatus,
            'approved_by' => ($initialStatus === Borrowing::STATUS_BORROWED && $user) ? $user->id : null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($initialStatus === Borrowing::STATUS_BORROWED) {
            $asset->update(['status' => 'BORROWED']);
        }

        return redirect()->route('asset.scan', $asset->qr_token)
            ->with('success', "Pengajuan peminjaman #{$code} berhasil dikirim! Silakan hubungi Tim IT untuk konfirmasi dan serah terima unit.");
    }

    /**
     * Approve a pending borrowing request (ACC oleh Admin IT).
     */
    public function approve(Borrowing $borrowing)
    {
        $user = auth()->user();
        $asset = $borrowing->asset;

        if ($asset && $asset->status === 'BORROWED') {
            return back()->with('error', "Aset ini sudah berstatus dipinjam.");
        }

        $borrowing->update([
            'status' => Borrowing::STATUS_BORROWED,
            'approved_by' => $user->id,
        ]);

        if ($asset) {
            $oldStatus = $asset->status;
            $asset->update([
                'status' => 'BORROWED',
                'last_updated_by_user_id' => $user->id,
            ]);

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => $user->id,
                'action' => 'STATUS_CHANGED',
                'old_status' => $oldStatus,
                'new_status' => 'BORROWED',
                'notes' => "Pengajuan peminjaman #{$borrowing->borrowing_code} disetujui (ACC) oleh {$user->name}. Unit resmi diserahkan kepada {$borrowing->borrower_name}.",
            ]);
        }

        return back()->with('success', "Peminjaman #{$borrowing->borrowing_code} berhasil disetujui (ACC)!");
    }

    /**
     * Reject a pending borrowing request.
     */
    public function reject(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => Borrowing::STATUS_REJECTED,
        ]);

        return back()->with('success', "Pengajuan peminjaman #{$borrowing->borrowing_code} telah ditolak.");
    }

    /**
     * Remove borrowing log.
     */
    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status === Borrowing::STATUS_BORROWED && $borrowing->asset) {
            $borrowing->asset->update(['status' => 'ACTIVE']);
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
