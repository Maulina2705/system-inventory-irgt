<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScanController extends Controller
{
    /**
     * Tampilkan antarmuka Scanner QR Kamera langsung di browser.
     */
    public function camera(): View
    {
        return view('scan.camera');
    }

    /**
     * Proses pencarian / redirect dari hasil QR Code scan atau input manual.
     */
    public function lookup(Request $request)
    {
        $code = trim($request->get('code', ''));

        if (empty($code)) {
            return back()->with('error', 'Masukkan atau scan kode QR aset terlebih dahulu.');
        }

        // Check if input is a full URL containing token
        if (filter_var($code, FILTER_VALIDATE_URL) && str_contains($code, '/asset/scan/')) {
            $parts = explode('/asset/scan/', $code);
            $token = end($parts);
            $token = explode('?', $token)[0]; // strip query string
            $code = $token;
        }

        // Try lookup by qr_token, asset_code, or serial_number
        $asset = Asset::where('qr_token', $code)
            ->orWhere('asset_code', $code)
            ->orWhere('serial_number', $code)
            ->first();

        if ($asset) {
            return redirect()->route('asset.scan', $asset->qr_token);
        }

        return back()->with('error', "Aset dengan kode atau token \"{$code}\" tidak ditemukan dalam database.")->withInput();
    }
}
