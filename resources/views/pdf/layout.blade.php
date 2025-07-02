<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dokumen PDF' }} - MYKOST</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 3px solid #f97316;
            padding-bottom: 15px;
        }

        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .company-info {
            color: #666;
            line-height: 1.6;
        }

        .document-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .document-meta {
            color: #666;
            font-size: 11px;
        }

        .content {
            margin: 20px 0;
            min-height: 600px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            border-top: 1px solid #ddd;
            padding: 10px 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            background: white;
        }

        .page-number {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #1e40af;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Card Styles */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            background: #f8f9fa;
        }

        .card-header {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-large {
            font-size: 14px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .grid-2 {
            display: table;
            width: 100%;
        }

        .grid-2 .col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }

        .grid-2 .col:first-child {
            padding-left: 0;
        }

        .grid-2 .col:last-child {
            padding-right: 0;
        }

        /* Currency Formatting */
        .currency {
            font-weight: bold;
            color: #f97316;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
        }

        @media print {
            .footer {
                position: fixed;
                bottom: 0;
            }
            
            .page-number {
                position: fixed;
                bottom: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <div class="logo">MYKOST</div>
            <div class="company-info">
                {{ $company['address'] ?? 'Jl. Kost Indah No. 123, Kota Indah' }}<br>
                Telp: {{ $company['phone'] ?? '0812-3456-7890' }}<br>
                Email: {{ $company['email'] ?? 'info@mykost.com' }}
            </div>
        </div>
        <div class="header-right">
            <div class="document-title">{{ $title ?? 'Dokumen PDF' }}</div>
            <div class="document-meta">
                @if(isset($period))
                    Periode: {{ $period }}<br>
                @endif
                Dicetak: {{ $generated_at->format('d/m/Y H:i') }}<br>
                @if(isset($document_number))
                    No. Dokumen: {{ $document_number }}
                @endif
            </div>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        <div>
            Dokumen ini dicetak secara otomatis oleh sistem MYKOST pada {{ $generated_at->format('d F Y \p\u\k\u\l H:i') }} WIB
        </div>
    </div>

    <div class="page-number">
        Halaman <span class="pageNumber"></span> dari <span class="totalPages"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial", "normal");
                $pdf->text(520, 820, "Halaman " . $PAGE_NUM . " dari " . $PAGE_COUNT, $font, 8);
            ');
        }
    </script>
</body>
</html> 