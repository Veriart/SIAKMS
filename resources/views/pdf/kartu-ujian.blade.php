<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/LogoMetschoo.png') }}">
    <title>Kartu Ujian - {{ $student->user->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: clamp(12px, 4vw, 24px);
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            width: 100%;
            max-width: 480px;
        }

        /* ── Card ── */
        .card {
            background: #ffffff;
            border-radius: clamp(10px, 3vw, 16px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.28);
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        /* ── Header ── */
        .card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            padding: clamp(16px, 5vw, 24px) clamp(16px, 5vw, 28px) clamp(14px, 4vw, 20px);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: 60px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            pointer-events: none;
        }

        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .header-text {
            flex: 1;
            min-width: 0;
        }

        .header-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #bfdbfe;
            font-size: clamp(9px, 2.2vw, 10px);
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 100px;
            margin-bottom: 8px;
        }

        .card-header h1 {
            font-size: clamp(20px, 5.5vw, 26px);
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-sub {
            color: #bfdbfe;
            margin-top: 2px;
        }

        .header-sub.lg {
            font-size: clamp(12px, 3.2vw, 14px);
        }

        .header-sub.sm {
            font-size: clamp(10px, 2.8vw, 12px);
        }

        .header-logo {
            width: clamp(60px, 18vw, 90px);
            height: auto;
            flex-shrink: 0;
        }

        /* ── Status bar ── */
        .status-bar {
            padding: 10px clamp(16px, 5vw, 28px);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: clamp(10px, 2.8vw, 12px);
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-bar.allowed {
            background: #dcfce7;
            color: #15803d;
            border-bottom: 1px solid #bbf7d0;
        }

        .status-bar.blocked {
            background: #fee2e2;
            color: #b91c1c;
            border-bottom: 1px solid #fecaca;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            min-width: 8px;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        .allowed .status-dot {
            background: #16a34a;
        }

        .blocked .status-dot {
            background: #dc2626;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(0.85);
            }
        }

        /* ── Card body ── */
        .card-body {
            padding: clamp(14px, 4vw, 20px) clamp(16px, 5vw, 28px);
        }

        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: clamp(8px, 2.5vw, 10px) clamp(10px, 3vw, 14px);
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: background 0.2s, border-color 0.2s;
        }

        .info-row:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .info-icon {
            width: clamp(28px, 7vw, 32px);
            height: clamp(28px, 7vw, 32px);
            min-width: clamp(28px, 7vw, 32px);
            border-radius: 8px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon svg {
            width: clamp(13px, 3.5vw, 16px);
            height: clamp(13px, 3.5vw, 16px);
            fill: none;
            stroke: white;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .info-content {
            flex: 1;
            min-width: 0;
        }

        .info-label {
            font-size: clamp(9px, 2.2vw, 10px);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: clamp(13px, 3.2vw, 14px);
            font-weight: 600;
            color: #0f172a;
            word-break: break-word;
        }

        /* ── QR section ── */
        .qr-section {
            padding: clamp(14px, 4vw, 20px) clamp(16px, 5vw, 28px);
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: clamp(12px, 4vw, 20px);
            flex-wrap: wrap;
        }

        .qr-wrapper {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            /* Scale the QR on very small screens */
            max-width: clamp(90px, 28vw, 116px);
        }

        .qr-wrapper svg,
        .qr-wrapper img {
            width: 100% !important;
            height: auto !important;
            display: block;
        }

        .qr-info {
            flex: 1;
            min-width: 120px;
        }

        .qr-title {
            font-size: clamp(11px, 3vw, 12px);
            font-weight: 700;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .qr-desc {
            font-size: clamp(10px, 2.6vw, 11px);
            color: #64748b;
            line-height: 1.5;
        }

        .qr-url {
            font-size: clamp(9px, 2.4vw, 10px);
            color: #2563eb;
            font-weight: 500;
            margin-top: 6px;
            word-break: break-all;
        }

        /* ── Footer ── */
        .card-footer {
            padding: 10px clamp(16px, 5vw, 28px);
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
        }

        .footer-left,
        .footer-right {
            font-size: clamp(9px, 2.2vw, 10px);
            color: #94a3b8;
        }

        /* ── Print button ── */
        .btn-print {
            display: block;
            width: 100%;
            padding: clamp(12px, 3.5vw, 14px);
            background: linear-gradient(135deg, #ffffff, #f0f9ff);
            color: #1e3a8a;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            cursor: pointer;
            font-size: clamp(13px, 3.5vw, 15px);
            font-weight: 700;
            font-family: 'Inter', Arial, sans-serif;
            letter-spacing: 0.5px;
            text-align: center;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-print:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-print:active {
            transform: translateY(0);
        }

        /* ── Print media ── */
        @media print {
            body {
                background: none;
                min-height: unset;
                padding: 0;
            }

            .wrapper {
                max-width: 100%;
            }

            .card {
                box-shadow: none;
                border-radius: 0;
                width: 100%;
            }

            .btn-print {
                display: none;
            }

            .info-row:hover {
                background: #f8fafc;
                border-color: #e2e8f0;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">

            {{-- Header --}}
            <div class="card-header">
                <div class="header-row">
                    <div class="header-text">
                        <div class="header-badge">Sistem Informasi Akademik</div>
                        <h1>Kartu Ujian</h1>
                        <p class="header-sub lg">Asesmen Sumatif Akhir Semester</p>
                        <p class="header-sub sm">Tahun Akademik: 2025-2026</p>
                    </div>
                    <img
                        src="{{ asset('/img/LogoMetschoo.png') }}"
                        alt="Logo Metschoo"
                        class="header-logo">
                </div>
            </div>

            {{-- Status akses ujian --}}
            <div class="status-bar {{ $student->exam_access ? 'allowed' : 'blocked' }}">
                <span class="status-dot"></span>
                Akses Ujian: {{ $student->exam_access ? 'DIIZINKAN' : 'BELUM DIIZINKAN' }}
            </div>

            {{-- Data siswa --}}
            <div class="card-body">
                <div class="info-grid">

                    {{-- No. Induk --}}
                    <div class="info-row">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="16" rx="2" />
                                <path d="M7 8h10M7 12h6" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">No. Induk Siswa</div>
                            <div class="info-value">{{ $student->identification_number ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div class="info-row">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nama Siswa</div>
                            <div class="info-value">{{ optional($student->user)->name ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Kelas --}}
                    <div class="info-row">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Kelas</div>
                            <div class="info-value">{{ optional($student->classroom)->name ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Keahlian --}}
                    <div class="info-row">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Kompetensi Keahlian</div>
                            <div class="info-value">{{ optional($student->expertise)->name ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="info-row">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 3h4v4M21 3l-7 7M9 21a6 6 0 100-12 6 6 0 000 12z" />
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Jenis Kelamin</div>
                            <div class="info-value">{{ $student->gender ?? '-' }}</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- QR Code section --}}
            <div class="qr-section">
                <div class="qr-wrapper">
                    {!! QrCode::size(100)->generate(route('kartu.ujian', $student->slug)) !!}
                </div>
                <div class="qr-info">
                    <div class="qr-title">&#128272; Verifikasi Kartu</div>
                    <div class="qr-desc">Scan QR Code ini untuk mengakses kartu ujian secara digital melalui perangkat apapun.</div>
                    <div class="qr-url">{{ url('/kartu-ujian/' . $student->slug) }}</div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="card-footer">
                <span class="footer-left">Dicetak: {{ date('d/m/Y H:i') }}</span>
                <span class="footer-right">SIAK — Sistem Informasi Akademik</span>
            </div>
        </div>

        {{-- Print button (hidden on print) --}}
        <button class="btn-print" onclick="window.print()">
            &#128424; Cetak Kartu Ujian
        </button>
    </div>
</body>

</html>