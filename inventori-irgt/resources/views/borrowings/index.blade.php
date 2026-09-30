@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-head-card">
        <div class="page-head-info">
            <h1>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                <span>Peminjaman Aset (Check-in / Check-out)</span>
            </h1>
            <p>Kelola peminjaman unit bergerak seperti Laptop, Proyektor Portable, Microphone, Kabel, dan alat event.</p>
        </div>
        <div>
            <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Catat Peminjaman Baru</span>
            </a>
        </div>
    </div>

    <!-- Summary KPI 4-Column Grid -->
    <div class="kpi-row-4">
        <div class="kpi-stat-card">
            <div>
                <p class="kpi-stat-label">Sedang Dipinjam</p>
                <p class="kpi-stat-val" style="color: #b45309;">{{ number_format($totalBorrowed) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #fef3c7; color: #b45309;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
        </div>

        <div class="kpi-stat-card">
            <div>
                <p class="kpi-stat-label">Terlambat (Overdue)</p>
                <p class="kpi-stat-val" style="color: #dc2626;">{{ number_format($totalOverdue) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #fee2e2; color: #dc2626;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
        </div>

        <div class="kpi-stat-card">
            <div>
                <p class="kpi-stat-label">Sudah Kembali</p>
                <p class="kpi-stat-val" style="color: #15803d;">{{ number_format($totalReturned) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #dcfce7; color: #15803d;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
        </div>

        <div class="kpi-stat-card">
            <div>
                <p class="kpi-stat-label">Total Riwayat</p>
                <p class="kpi-stat-val" style="color: #0369a1;">{{ number_format($totalAll) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #e0f2fe; color: #0369a1;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div style="background: #ffffff; border: 1.5px solid #e0f2fe; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <form method="GET" action="{{ route('borrowings.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 240px;">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari kode tiket, nama peminjam, kelas, atau nama aset..." 
                    class="form-input"
                    style="padding: 8px 12px; font-size: 13px;"
                >
            </div>

            <div style="min-width: 180px;">
                <select name="status" class="form-select" style="padding: 8px 12px; font-size: 13px;">
                    <option value="">Semua Status</option>
                    <option value="PENDING_APPROVAL" {{ request('status') === 'PENDING_APPROVAL' ? 'selected' : '' }}>Menunggu Persetujuan (ACC)</option>
                    <option value="BORROWED" {{ request('status') === 'BORROWED' ? 'selected' : '' }}>Sedang Dipinjam</option>
                    <option value="OVERDUE" {{ request('status') === 'OVERDUE' ? 'selected' : '' }}>Terlambat Kembali</option>
                    <option value="RETURNED" {{ request('status') === 'RETURNED' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                    <option value="DAMAGED" {{ request('status') === 'DAMAGED' ? 'selected' : '' }}>Rusak Saat Dipinjam</option>
                    <option value="LOST" {{ request('status') === 'LOST' ? 'selected' : '' }}>Hilang</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('borrowings.index') }}" class="btn btn-outline" style="padding: 8px 12px;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Borrowings Table Card -->
    <div class="content-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Kode Peminjaman</th>
                        <th>Aset Dipinjam</th>
                        <th>Peminjam</th>
                        <th>Waktu Pinjam</th>
                        <th>Tenggat Kembali</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $b)
                        <tr>
                            <td>
                                <strong style="font-family: 'JetBrains Mono', monospace; color: #0369a1; font-size: 13px;">
                                    {{ $b->borrowing_code }}
                                </strong>
                            </td>
                            <td>
                                @if($b->asset)
                                    <div style="font-weight: 700; color: #0c1a2e;">{{ $b->asset->name }}</div>
                                    <div style="font-size: 11px; font-family: 'JetBrains Mono', monospace; color: #64748b;">{{ $b->asset->asset_code }}</div>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">Aset Telah Dihapus</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0c1a2e;">{{ $b->borrower_name }}</div>
                                <div style="font-size: 11.5px; color: #64748b;">
                                    {{ $b->department_class ?? '-' }} {{ $b->borrower_identifier ? '(' . $b->borrower_identifier . ')' : '' }}
                                </div>
                            </td>
                            <td style="font-size: 12px; color: #475569;">
                                {{ $b->borrowed_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="font-size: 12px;">
                                <div style="{{ $b->is_overdue && $b->status === 'BORROWED' ? 'color: #dc2626; font-weight: 700;' : 'color: #475569;' }}">
                                    {{ $b->expected_return_at->format('d/m/Y H:i') }}
                                </div>
                                @if($b->is_overdue && $b->status === 'BORROWED')
                                    <div style="font-size: 10px; color: #dc2626; font-weight: 700;">Lewat {{ $b->expected_return_at->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td>
                                <x-badge-status :status="$b->effective_status" />
                            </td>
                            <td style="text-align: right;">
                                @if($b->status === \App\Models\Borrowing::STATUS_PENDING_APPROVAL)
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <form method="POST" action="{{ route('borrowings.approve', $b->id) }}" onsubmit="return confirm('Setujui (ACC) peminjaman aset ini untuk {{ $b->borrower_name }}?')" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" style="padding: 5px 10px; font-size: 11.5px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>ACC / Setujui</span>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('borrowings.reject', $b->id) }}" onsubmit="return confirm('Tolak pengajuan peminjaman ini?')" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 11.5px;">
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    </div>
                                @elseif($b->status === \App\Models\Borrowing::STATUS_BORROWED)
                                    <button 
                                        type="button" 
                                        x-data=""
                                        x-on:click="$dispatch('open-modal', 'return-modal-{{ $b->id }}')" 
                                        class="btn btn-success"
                                        style="padding: 5px 10px; font-size: 11.5px;"
                                    >
                                        Proses Kembali
                                    </button>

                                    <!-- Modal Pengembalian -->
                                    <x-modal name="return-modal-{{ $b->id }}" maxWidth="md">
                                        <form method="POST" action="{{ route('borrowings.return', $b->id) }}" style="padding: 20px; text-align: left;">
                                            @csrf
                                            <h3 style="font-size: 17px; font-weight: 800; color: #0c1a2e; margin-bottom: 6px;">Proses Pengembalian Aset</h3>
                                            <p style="font-size: 12px; color: #64748b; margin-bottom: 16px;">
                                                Aset: <strong style="color: #0c1a2e;">{{ $b->asset ? $b->asset->name : '-' }}</strong> • Peminjam: <strong style="color: #0c1a2e;">{{ $b->borrower_name }}</strong>
                                            </p>

                                            <div class="form-group">
                                                <label class="form-label">Status Kondisi Aset</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="RETURNED">Sudah Dikembalikan (Normal / Baik)</option>
                                                    <option value="DAMAGED">Dikembalikan dalam Keadaan Rusak</option>
                                                    <option value="LOST">Aset Dinyatakan Hilang</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Catatan Pemeriksaan Fisik (Opsional)</label>
                                                <textarea name="condition_note" rows="3" placeholder="Contoh: Unit diperiksa lengkap, charger, kabel, dan tas dalam keadaan baik..." class="form-textarea"></textarea>
                                            </div>

                                            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 8px;">
                                                <button type="button" x-on:click="$dispatch('close-modal', 'return-modal-{{ $b->id }}')" class="btn btn-outline" style="padding: 7px 14px; font-size: 12px;">Batal</button>
                                                <button type="submit" class="btn btn-success" style="padding: 7px 14px; font-size: 12px;">Simpan Pengembalian</button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @elseif($b->status === \App\Models\Borrowing::STATUS_REJECTED)
                                    <span style="font-size: 11.5px; color: #dc2626; font-weight: 600;">Ditolak</span>
                                @else
                                    <span style="font-size: 11.5px; color: #64748b;">
                                        Selesai ({{ $b->returned_at ? $b->returned_at->format('d/m/Y') : '-' }})
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 36px 16px; text-align: center; color: #64748b; font-style: italic;">
                                Belum ada data transaksi peminjaman aset.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
                {{ $borrowings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
