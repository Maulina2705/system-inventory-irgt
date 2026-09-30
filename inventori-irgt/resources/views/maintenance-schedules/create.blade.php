@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Page Header -->
    <div class="page-head-card">
        <div class="page-head-info">
            <h1>
                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-outline" style="padding: 6px 10px; margin-right: 4px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                </a>
                <span>Buat Jadwal Preventive Maintenance</span>
            </h1>
            <p>Atur siklus pemeliharaan berkala untuk menjaga keandalan dan masa pakai perangkat.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card" style="padding: 28px;">
        <form method="POST" action="{{ route('maintenance-schedules.store') }}">
            @csrf

            <!-- Pilih Aset -->
            <div class="form-group">
                <label class="form-label">
                    Pilih Aset Sasaran <span style="color: #dc2626;">*</span>
                </label>
                <select name="asset_id" class="form-select" required>
                    <option value="">-- Pilih Aset --</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ (old('asset_id', $selectedAsset?->id) == $asset->id) ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->asset_code }}) {{ $asset->brand ? ' - ' . $asset->brand : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Agenda -->
            <div class="form-group">
                <label class="form-label">
                    Nama / Judul Agenda <span style="color: #dc2626;">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    value="{{ old('title') }}" 
                    placeholder="Contoh: Pembersihan Debu Rutin PC Lab / Penggantian Pasta Thermal" 
                    class="form-input"
                    required
                >
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Jenis Pemeliharaan -->
                <div class="form-group">
                    <label class="form-label">
                        Jenis Tindakan <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="maintenance_type" class="form-select" required>
                        <option value="Cleaning Dust & Fan Check">Pembersihan Debu & Cek Kipas (PC / Server)</option>
                        <option value="Thermal Paste Replacement">Penggantian Pasta Thermal CPU/GPU</option>
                        <option value="Lens & Filter Cleaning">Pembersihan Lensa & Filter Proyektor</option>
                        <option value="Camera Check & Lens Cleaning">Pengecekan Kamera & Rekaman CCTV</option>
                        <option value="Firmware Check & Config Backup">Pemeriksaan Firmware & Backup Switch/Router</option>
                        <option value="Battery Health & Diagnostic">Pemeriksaan Baterai & Diagnostik Laptop</option>
                        <option value="Kabel & Kelistrikan Check">Pemeriksaan Kerapian Kabel & Arus Listrik</option>
                        <option value="General Inspection">Inspeksi Fisik Umum</option>
                    </select>
                </div>

                <!-- Interval Siklus -->
                <div class="form-group">
                    <label class="form-label">
                        Siklus Interval Berkala <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="interval_months" class="form-select" required>
                        <option value="1" {{ old('interval_months') == 1 ? 'selected' : '' }}>Setiap 1 Bulan</option>
                        <option value="3" {{ old('interval_months', 3) == 3 ? 'selected' : '' }}>Setiap 3 Bulan (Disarankan untuk Lab PC)</option>
                        <option value="6" {{ old('interval_months') == 6 ? 'selected' : '' }}>Setiap 6 Bulan (Disarankan untuk Jaringan & CCTV)</option>
                        <option value="12" {{ old('interval_months') == 12 ? 'selected' : '' }}>Setiap 12 Bulan / 1 Tahun</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Terakhir Kali Dilakukan -->
                <div class="form-group">
                    <label class="form-label">
                        Terakhir Kali Dilakukan (Opsional)
                    </label>
                    <input 
                        type="date" 
                        name="last_maintenance_at" 
                        value="{{ old('last_maintenance_at') }}" 
                        class="form-input"
                    >
                </div>

                <!-- Tanggal Jadwal Berikutnya -->
                <div class="form-group">
                    <label class="form-label">
                        Tanggal Jadwal Berikutnya <span style="color: #dc2626;">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="next_maintenance_at" 
                        value="{{ old('next_maintenance_at', date('Y-m-d', strtotime('+3 months'))) }}" 
                        class="form-input"
                        required
                    >
                </div>
            </div>

            <!-- Teknisi Penanggung Jawab -->
            <div class="form-group">
                <label class="form-label">
                    Teknisi / Petugas Bertanggung Jawab
                </label>
                <select name="assigned_to_user_id" class="form-select">
                    <option value="">-- Semua Tim IT / Teknisi --</option>
                    @foreach($technicians as $tech)
                        <option value="{{ $tech->id }}" {{ old('assigned_to_user_id') == $tech->id ? 'selected' : '' }}>
                            {{ $tech->name }} ({{ ucfirst(str_replace('_', ' ', $tech->role)) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Instruksi & Catatan Checklist -->
            <div class="form-group">
                <label class="form-label">
                    Catatan Panduan / SOP Tindakan
                </label>
                <textarea 
                    name="notes" 
                    rows="3" 
                    placeholder="Contoh: Gunakan blower tekanan sedang. Periksa suhu prosesor di HWMonitor setelah selesai." 
                    class="form-textarea"
                >{{ old('notes') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Simpan Jadwal Maintenance</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
