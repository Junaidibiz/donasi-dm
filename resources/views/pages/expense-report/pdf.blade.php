<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Pengeluaran Dana Donasi</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            margin: 30px;
            color: #333;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border: 0;
        }

        .header-table td {
            border: 0;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .header .text {
            text-align: left;
            padding-left: 15px;
        }

        .header .text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header .text p {
            margin: 3px 0;
            font-size: 11px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            text-decoration: underline;
        }

        .sub-header {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ccc;
            text-align: left;
            padding: 6px 8px;
        }

        .main-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        tfoot {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 90px;">
                    <img src="{{ public_path('images/logo_damu.png') }}" alt="Logo Daarul Multazam">
                </td>
                <td class="text">
                    <h2>YAYASAN DAARUL MULTAZAM MANDIRI</h2>
                    <p>Jl. Carang Pulang, RT.05/RW.01, Cikarawang, Kec. Dramaga,</p>
                    <p>Kabupaten Bogor, Jawa Barat 16880</p>
                </td>
            </tr>
        </table>
    </div>

    <h1>Laporan Pengeluaran Dana Donasi</h1>

    @if (isset($date_from) && isset($date_to) && $date_from && $date_to)
        <h3 class="sub-header">
            Periode: {{ \Carbon\Carbon::parse($date_from)->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($date_to)->format('d F Y') }}
        </h3>
    @endif

    <table class="main-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tgl. Pengeluaran</th>
                <th>Campaign</th>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenseReports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->expense_date)->format('d-m-Y') }}</td>
                    <td>{{ $report->campaign->title }}</td>
                    <td>{{ strip_tags($report->description) }}</td>
                    <td class="text-right">{{ moneyFormat($report->amount) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data yang cocok dengan kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold">TOTAL</td>
                <td class="font-bold text-right">{{ moneyFormat($expenseReports->sum('amount')) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
