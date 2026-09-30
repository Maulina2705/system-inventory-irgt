<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryCodeSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // PENEMPATAN
        // =========================

        DB::table('placements')->insert([
            [
                'code' => 'IT',
                'name' => 'Milik IT',
            ],
            [
                'code' => 'PE',
                'name' => 'Milik Perpustakaan',
            ],
            [
                'code' => 'AU',
                'name' => 'Milik Aula',
            ],
            [
                'code' => 'LO',
                'name' => 'Milik Lobby',
            ],
            [
                'code' => 'SM',
                'name' => 'Milik Kantor SMP',
            ],
            [
                'code' => 'SD',
                'name' => 'Milik Kantor SD',
            ],
            [
                'code' => 'WL',
                'name' => 'Wali Kelas',
            ],
        ]);

        // =========================
        // LOKASI
        // =========================

        DB::table('locations')->insert([
            [
                'code' => 'L1',
                'name' => 'Lantai 1',
            ],
            [
                'code' => 'L2',
                'name' => 'Lantai 2',
            ],
            [
                'code' => 'L3',
                'name' => 'Lantai 3',
            ],
        ]);

        // =========================
        // JENIS BARANG
        // =========================

        DB::table('asset_types')->insert([
            [
                'code' => 'AD',
                'name' => 'Administrasi',
            ],
            [
                'code' => 'NE',
                'name' => 'Networking',
            ],
            [
                'code' => 'ME',
                'name' => 'Media',
            ],
            [
                'code' => 'BJ',
                'name' => 'Pembelajaran',
            ],
        ]);

        // =========================
        // KODE BARANG
        // =========================

        DB::table('asset_items')->insert([
            [
                'code' => 'PC',
                'name' => 'Komputer',
            ],
            [
                'code' => 'KY',
                'name' => 'Keyboard',
            ],
            [
                'code' => 'MO',
                'name' => 'Mouse',
            ],
            [
                'code' => 'PR',
                'name' => 'Printer',
            ],
            [
                'code' => 'PY',
                'name' => 'Proyektor',
            ],
            [
                'code' => 'CC',
                'name' => 'CCTV',
            ],
            [
                'code' => 'MN',
                'name' => 'Monitor',
            ],
            [
                'code' => 'UP',
                'name' => 'UPS',
            ],
            [
                'code' => 'SP',
                'name' => 'Speaker',
            ],
            [
                'code' => 'MI',
                'name' => 'MIC',
            ],
            [
                'code' => 'MX',
                'name' => 'Mixer',
            ],
            [
                'code' => 'AC',
                'name' => 'Accessories',
            ],
            [
                'code' => 'OT',
                'name' => 'Other',
            ],
        ]);
    }
}