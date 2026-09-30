<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code Aset — IRGT School Inventory</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f9ff;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .scanner-header {
            background: #0c1a2e;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .scanner-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
        }

        .scanner-container {
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .scanner-card {
            background: #ffffff;
            border: 1.5px solid #e0f2fe;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(3, 105, 161, 0.08);
            margin-bottom: 20px;
        }

        .scanner-title {
            text-align: center;
            margin-bottom: 16px;
        }

        .scanner-title h2 {
            font-size: 17px;
            font-weight: 800;
            color: #0c1a2e;
        }

        .scanner-title p {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 2px;
        }

        .viewport-box {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #0c1a2e;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #38bdf8;
        }

        #reader {
            width: 100%;
            height: 100%;
        }

        #scanner-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            text-align: center;
            color: #bae6fd;
        }

        .manual-card {
            background: #ffffff;
            border: 1.5px solid #e0f2fe;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        }

        .manual-card h3 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #0369a1;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }

        .manual-form {
            display: flex;
            gap: 8px;
        }

        .form-input {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            background: #f8fafc;
            color: #0c1a2e;
            outline: none;
            transition: all 0.15s;
        }

        .form-input:focus {
            border-color: #0369a1;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(3, 105, 161, 0.12);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            font-family: inherit;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(3, 105, 161, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #e0f2fe;
            color: #0369a1;
            border: 1.5px solid #bae6fd;
            padding: 8px 14px;
            font-size: 12px;
        }

        .scanner-footer {
            padding: 16px;
            text-align: center;
            font-size: 11.5px;
            color: #64748b;
            border-top: 1px solid #e0f2fe;
            background: #ffffff;
        }
    </style>
</head>
<body>
    
    <!-- Top Header -->
    <header class="scanner-header">
        <a href="{{ route('dashboard') }}" class="scanner-brand">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            <span>Scan QR Aset</span>
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="padding: 5px 12px; color: #fff; background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.2);">
            Dashboard
        </a>
    </header>

    <!-- Main Scanner -->
    <main class="scanner-container">
        @if(session('error'))
            <div style="background: #fee2e2; border: 1.5px solid #fca5a5; color: #b91c1c; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="scanner-card">
            <div class="scanner-title">
                <h2>Arahkan Kamera ke QR Code</h2>
                <p>Posisikan stiker barcode / QR unit atau kartu meja tepat di kotak scanner.</p>
            </div>

            <div class="viewport-box">
                <div id="reader"></div>
                <div id="scanner-placeholder">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(56, 189, 248, 0.15); display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    </div>
                    <strong style="font-size: 14px; color: #ffffff;">Menyiapkan Kamera...</strong>
                    <span style="font-size: 11.5px; margin-top: 4px; color: #7dd3fc;">Izinkan akses browser ke kamera perangkat Anda.</span>
                </div>
            </div>

            <div style="margin-top: 14px; text-align: center;">
                <button id="btn-switch-camera" type="button" class="btn btn-secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Ganti Kamera Depan / Belakang</span>
                </button>
            </div>
        </div>

        <!-- Manual Lookup Card -->
        <div class="manual-card">
            <h3>Input Manual Kode Aset</h3>
            <form action="{{ route('scan.lookup') }}" method="POST" class="manual-form">
                @csrf
                <input 
                    type="text" 
                    name="code" 
                    placeholder="Contoh: IRGT-LAB1-PC-0001" 
                    class="form-input"
                    required
                >
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Cari</span>
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="scanner-footer">
        &copy; {{ date('Y') }} IRGT School Inventory & Infrastructure Management
    </footer>

    <!-- HTML5-QRCode Scanner Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const html5QrCode = new Html5Qrcode("reader");
            const placeholder = document.getElementById('scanner-placeholder');
            let currentFacingMode = "environment";

            function onScanSuccess(decodedText, decodedResult) {
                html5QrCode.stop().then(() => {
                    if (decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
                        window.location.href = decodedText;
                    } else {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('scan.lookup') }}";

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = "{{ csrf_token() }}";
                        form.appendChild(csrf);

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'code';
                        input.value = decodedText;
                        form.appendChild(input);

                        document.body.appendChild(form);
                        form.submit();
                    }
                }).catch(err => {
                    console.error("Failed to stop scanner", err);
                    window.location.href = decodedText;
                });
            }

            function startScanner(facingMode) {
                const config = { 
                    fps: 15, 
                    qrbox: { width: 240, height: 240 },
                    aspectRatio: 1.0 
                };

                html5QrCode.start(
                    { facingMode: facingMode }, 
                    config, 
                    onScanSuccess, 
                    (errorMessage) => {}
                ).then(() => {
                    if (placeholder) placeholder.style.display = 'none';
                }).catch((err) => {
                    console.error("Camera error:", err);
                    if (placeholder) {
                        placeholder.innerHTML = `
                            <strong style="font-size: 13px; color: #f87171;">Akses Kamera Gagal</strong>
                            <span style="font-size: 11px; margin-top: 4px; color: #bae6fd;">Gunakan form input manual kode aset di bawah jika kamera tidak diizinkan.</span>
                        `;
                    }
                });
            }

            startScanner(currentFacingMode);

            document.getElementById('btn-switch-camera')?.addEventListener('click', function () {
                html5QrCode.stop().then(() => {
                    currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                    startScanner(currentFacingMode);
                }).catch(err => {
                    console.error("Failed to switch camera", err);
                });
            });
        });
    </script>
</body>
</html>
