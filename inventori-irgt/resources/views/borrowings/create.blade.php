@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Page Header -->
    <div class="page-head-card">
        <div class="page-head-info">
            <h1>
                <a href="{{ route('borrowings.index') }}" class="btn btn-outline" style="padding: 6px 10px; margin-right: 4px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                </a>
                <span>Catat Peminjaman Aset Baru</span>
            </h1>
            <p>Pastikan kondisi unit diperiksa secara fisik sebelum diserahkan kepada peminjam.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="content-card" style="padding: 28px;">
        <form method="POST" action="{{ route('borrowings.store') }}">
            @csrf

            <!-- Pilih Aset -->
            <div class="form-group">
                <label class="form-label">
                    Pilih Aset yang Dipinjam <span style="color: #dc2626;">*</span>
                </label>
                <select name="asset_id" class="form-select" required>
                    <option value="">-- Pilih Aset Aktif yang Siap Dipinjam --</option>
                    @foreach($availableAssets as $asset)
                        <option value="{{ $asset->id }}" {{ (old('asset_id', $selectedAsset?->id) == $asset->id) ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->asset_code }}) {{ $asset->brand ? ' - ' . $asset->brand : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Nama Peminjam -->
                <div class="form-group">
                    <label class="form-label">
                        Nama Peminjam <span style="color: #dc2626;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="borrower_name" 
                        value="{{ old('borrower_name') }}" 
                        placeholder="Contoh: Budi Santoso / Siswa XI RPL" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- NIP / NIS / No HP -->
                <div class="form-group">
                    <label class="form-label">
                        NIP / NIS / Kontak HP
                    </label>
                    <input 
                        type="text" 
                        name="borrower_identifier" 
                        value="{{ old('borrower_identifier') }}" 
                        placeholder="Contoh: 08123456789 / 198203..." 
                        class="form-input"
                    >
                </div>
            </div>

            <!-- Departemen / Unit / Kelas -->
            <div class="form-group">
                <label class="form-label">
                    Departemen / Unit Kerja / Kelas
                </label>
                <input 
                    type="text" 
                    name="department_class" 
                    value="{{ old('department_class') }}" 
                    placeholder="Contoh: Guru Matematika / Kelas 8 Al-Khawarizmi / Tim OSIS" 
                    class="form-input"
                >
            </div>

            <!-- Keperluan / Tujuan Peminjaman -->
            <div class="form-group">
                <label class="form-label">
                    Keperluan / Tujuan Peminjaman <span style="color: #dc2626;">*</span>
                </label>
                <textarea 
                    name="purpose" 
                    rows="2" 
                    placeholder="Contoh: Digunakan untuk presentasi ujian praktik di Aula Lantai 2" 
                    class="form-textarea"
                    required
                >{{ old('purpose') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <!-- Waktu Pinjam -->
                <div class="form-group">
                    <label class="form-label">
                        Waktu Peminjaman <span style="color: #dc2626;">*</span>
                    </label>
                    <input 
                        type="datetime-local" 
                        name="borrowed_at" 
                        value="{{ old('borrowed_at', date('Y-m-d\TH:i')) }}" 
                        class="form-input"
                        required
                    >
                </div>

                <!-- Tenggat Pengembalian -->
                <div class="form-group">
                    <label class="form-label">
                        Rencana Pengembalian <span style="color: #dc2626;">*</span>
                    </label>
                    <input 
                        type="datetime-local" 
                        name="expected_return_at" 
                        value="{{ old('expected_return_at', date('Y-m-d\TH:i', strtotime('+1 day'))) }}" 
                        class="form-input"
                        required
                    >
                </div>
            </div>

            <!-- Catatan Kelengkapan -->
            <div class="form-group">
                <label class="form-label">
                    Catatan Kelengkapan Unit (Opsional)
                </label>
                <textarea 
                    name="notes" 
                    rows="2" 
                    placeholder="Contoh: Unit diserahkan bersama adaptor original, kabel power, dan tas laptop." 
                    class="form-textarea"
                >{{ old('notes') }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('borrowings.index') }}" class="btn btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Simpan & Serahkan Unit</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
