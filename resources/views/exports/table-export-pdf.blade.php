<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Export Data' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #1e3a8a;
        }
        .header h1 {
            font-size: 18px;
            color: #1e3a8a;
            margin: 0 0 4px;
        }
        .header p {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead th {
            background: #1e3a8a;
            color: #ffffff;
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        tbody tr:hover {
            background: #eff6ff;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title ?? 'Export Data' }}</h1>
        <p>SIAK Metschoo — Dicetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total: {{ count($rows) }} data &mdash; SIAK Sistem Informasi Akademik
    </div>
</body>
</html>
