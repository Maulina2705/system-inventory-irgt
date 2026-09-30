@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-head-card">
        <div class="page-head-info">
            <h1>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Jadwal Preventive Maintenance</span>
            </h1>
            <p>Pemeliharaan berkala terstruktur untuk mencegah kerusakan hardware (Cleaning dust, Thermal paste, Filter proyektor, CCTV, dll).</p>
        </div>
        <div>
            <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Buat Jadwal Baru</span>
            </a>
        </div>
    </div>

    <!-- Summary KPI 4-Column Grid -->
    <div class="kpi-row-4">
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
                <p class="kpi-stat-label">Jatuh Tempo (Segera)</p>
                <p class="kpi-stat-val" style="color: #b45309;">{{ number_format($totalDue) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #fef3c7; color: #b45309;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
        </div>

        <div class="kpi-stat-card">
            <div>
                <p class="kpi-stat-label">Akan Datang</p>
                <p class="kpi-stat-val" style="color: #0369a1;">{{ number_format($totalUpcoming) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #e0f2fe; color: #0369a1;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </div>
        </div>

        <div class="kpi-stat-card">
            <div>
                <p class="kpi-stat-label">Selesai Dikerjakan</p>
                <p class="kpi-stat-val" style="color: #15803d;">{{ number_format($totalCompleted) }}</p>
            </div>
            <div class="kpi-stat-icon" style="background: #dcfce7; color: #15803d;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div style="background: #ffffff; border: 1.5px solid #e0f2fe; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <form method="GET" action="{{ route('maintenance-schedules.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <div style="flex: 1; min-width: 240px;">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari agenda, jenis pemeliharaan, kode aset..." 
                    class="form-input"
                    style="padding: 8px 12px; font-size: 13px;"
                >
            </div>

            <div style="min-width: 180px;">
                <select name="status" class="form-select" style="padding: 8px 12px; font-size: 13px;">
                    <option value="">Semua Status</option>
                    <option value="OVERDUE" {{ request('status') === 'OVERDUE' ? 'selected' : '' }}>Terlambat (Overdue)</option>
                    <option value="DUE" {{ request('status') === 'DUE' ? 'selected' : '' }}>Jatuh Tempo (7 Hari ke Depan)</option>
                    <option value="UPCOMING" {{ request('status') === 'UPCOMING' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="COMPLETED" {{ request('status') === 'COMPLETED' ? 'selected' : '' }}>Selesai Dilakukan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-outline" style="padding: 8px 12px;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="content-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama Agenda / Tindakan</th>
                        <th>Aset Sasaran</th>
                        <th>Siklus Berkala</th>
                        <th>Jadwal Perawatan</th>
                        <th>Teknisi Bertugas</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $s)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0c1a2e; font-size: 13.5px;">{{ $s->title }}</div>
                                <div style="font-size: 11.5px; color: #0284c7; font-weight: 600;">{{ $s->maintenance_type }}</div>
                            </td>
                            <td>
                                @if($s->asset)
                                    <div style="font-weight: 700; color: #0c1a2e;">{{ $s->asset->name }}</div>
                                    <div style="font-size: 11px; font-family: 'JetBrains Mono', monospace; color: #64748b;">{{ $s->asset->asset_code }}</div>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">Aset Telah Dihapus</span>
                                @endif
                            </td>
                            <td style="font-size: 12px; color: #475569;">
                                Setiap <strong style="color: #0c1a2e;">{{ $s->interval_months }} Bulan</strong>
                            </td>
                            <td style="font-size: 12px;">
                                <div style="{{ $s->effective_status === 'OVERDUE' ? 'color: #dc2626; font-weight: 700;' : ($s->effective_status === 'DUE' ? 'color: #b45309; font-weight: 700;' : 'color: #475569;') }}">
                                    {{ $s->next_maintenance_at->format('d/m/Y') }}
                                </div>
                                <div style="font-size: 10.5px; color: #64748b;">
                                    Terakhir: {{ $s->last_maintenance_at ? $s->last_maintenance_at->format('d/m/Y') : 'Belum pernah' }}
                                </div>
                            </td>
                            <td style="font-size: 12px; color: #475569;">
                                {{ $s->assignee ? $s->assignee->name : 'Semua Teknisi' }}
                            </td>
                            <td>
                                <x-badge-status :status="$s->effective_status" />
                            </td>
                            <td style="text-align: right;">
                                @if($s->status !== \App\Models\MaintenanceSchedule::STATUS_COMPLETED)
                                    <button 
                                        type="button" 
                                        x-data=""
                                        x-on:click="$dispatch('open-modal', 'complete-modal-{{ $s->id }}')" 
                                        class="btn btn-success"
                                        style="padding: 5px 10px; font-size: 11.5px;"
                                    >
                                        Tandai Selesai
                                    </button>

                                    <!-- Modal Selesai PM -->
                                    <x-modal name="complete-modal-{{ $s->id }}" maxWidth="md">
                                        <form method="POST" action="{{ route('maintenance-schedules.complete', $s->id) }}" style="padding: 20px; text-align: left;">
                                            @csrf
                                            <h3 style="font-size: 17px; font-weight: 800; color: #0c1a2e; margin-bottom: 6px;">Konfirmasi Selesai Perawatan</h3>
                                            <p style="font-size: 12px; color: #64748b; margin-bottom: 16px;">
                                                Agenda: <strong style="color: #0c1a2e;">{{ $s->title }}</strong> ({{ $s->asset ? $s->asset->name : '-' }})
                                            </p>

                                            <div class="form-group">
                                                <label class="form-label">Catatan Hasil Tindakan / Pemeriksaan</label>
                                                <textarea name="completion_notes" rows="3" placeholder="Contoh: Debu dibersihkan, pasta thermal diganti baru, kipas dites berputar lancar..." class="form-textarea"></textarea>
                                            </div>

                                            <div style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                                                <input type="checkbox" name="auto_renew" value="1" id="renew_{{ $s->id }}" checked style="width: 16px; height: 16px; accent-color: #0284c7;">
                                                <label for="renew_{{ $s->id }}" style="font-size: 12.5px; color: #334155; font-weight: 600; cursor: pointer;">
                                                    Jadwalkan siklus berikutnya otomatis (+{{ $s->interval_months }} bulan)
                                                </label>
                                            </div>

                                            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 8px;">
                                                <button type="button" x-on:click="$dispatch('close-modal', 'complete-modal-{{ $s->id }}')" class="btn btn-outline" style="padding: 7px 14px; font-size: 12px;">Batal</button>
                                                <button type="submit" class="btn btn-success" style="padding: 7px 14px; font-size: 12px;">Simpan & Tutup Jadwal</button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @else
                                    <span style="font-size: 11.5px; color: #64748b;">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 36px 16px; text-align: center; color: #64748b; font-style: italic;">
                                Belum ada jadwal preventive maintenance.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
