<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
        }

        .first-line {
            text-indent: 1.2cm;
            text-align: justify;
        }

        .justify {
            text-align: justify;
            text-justify: inter-word;
        }

        h5 {
            text-align: center !important;
            font-size: 14pt !important;
            font-weight: bold !important;
        }

        .text-end {
            text-align: right;
        }

        @page {
            size: A4;
            margin: 2.5cm;
        }

        @media print {
            body {
                font-family: "Times New Roman", Times, serif;
                margin: 0 !important;
            }

            .card {
                border: none;
            }

            .card-header {
                display: none;
            }

            .not-printable {
                display: none;
            }

            .print-p0 {
                padding: 0 !important;
            }

            .container {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
            }

            .row {
                margin: 0 !important;
            }

            .col-lg-8,
            .pc-12 {
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <div class="letter">
        <h5 class="text-center">INTERNAL MEMO</h5>
        <table>
            <tr>
                <td>Nomor</td>
                <td style="width: 3rem;"></td>
                <td>:</td>
                <td class="letter_number">
                    {{ $memo->letter_number }}
                </td>
            </tr>
            <tr>
                <td>Kepada</td>
                <td style="width: 3rem;"></td>
                <td>:</td>
                <td class="letter_recipient">Seluruh Guru Mata Pelajaran</td>
            </tr>
            <tr>
                <td class="align-top">CC</td>
                <td class="align-top" style="width: 3rem;"></td>
                <td class="align-top">:</td>
                <td class="letter_cc justify">Dr. Darmawan Sunarja, Drs., MM.Par., Suharti, SE., Ony Dina Maharani,
                    M.Pd.</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td style="width: 3rem;"></td>
                <td>:</td>
                <td class="letter_subject">{{ $memo->reason }}</td>
            </tr>
        </table>
        <hr class="border border-1 opacity-100 border-dark">
        <p class="letter_content">
            Dengan hormat,
        </p>
        <p class="text-justify first-line">
            Sehubungan dengan Internal Memo nomor
            {{ $memo->ref }}
            perihal Izin dispensasi kegiatan <b class="subject">{{ $memo->reason }}</b> maka dengan ini kami
            informasikan dispensasi siswa
            pada:
        </p>
        <table>
            <tr>
                <td>Hari/Tanggal</td>
                <td style="width: 1rem;"></td>
                <td>:</td>
                <td class="date">{{ \Carbon\Carbon::parse($memo->date)->locale('id')->translatedFormat('l, d F Y') }}
                </td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td style="width: 1rem;"></td>
                <td>:</td>
                <td class="time">{{ $memo->time }} - Selesai</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td style="width: 1rem;"></td>
                <td>:</td>
                <td class="place">{{ $memo->place }}</td>
            </tr>
        </table>
        <p class="text-justify first-line">
            Demikian internal memo ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
        </p>
        <div class="text-end">
            <p class="text-end" style="margin-bottom: 0 !important;">
                Bogor, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                <br>
                Ketua Bidang Akademik
            </p>
            @php
                $ttdPath = public_path('img/ttd.jpeg');
                $ttdBase64 = base64_encode(file_get_contents($ttdPath));
            @endphp
            <img src="data:image/jpeg;base64, {{ $ttdBase64 }}" style="width:150px;">
            <p class="fw-bold text-end"><u>Asri Maharani, S.Pd</u></p>
        </div>
    </div>
</body>

</html>
