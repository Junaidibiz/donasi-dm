<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Donasi</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            text-align: left;
            padding: 6px 8px;
        }

        th {
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
                    {{-- Menggunakan public_path() untuk mendapatkan path absolut ke gambar --}}
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

    <h1>Laporan Data Donasi</h1>
    {{-- BLOK UNTUK MENAMPILKAN PERIODE TANGGAL --}}
    @if (isset($date_from) && isset($date_to) && $date_from && $date_to)
        <h3 class="sub-header">
            Periode: {{ \Carbon\Carbon::parse($date_from)->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($date_to)->format('d F Y') }}
        </h3>
    @endif


    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Donatur</th>
                <th>Campaign</th>
                <th class="text-right">Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donations as $donation)
                <tr>
                    <td>{{ $donation->invoice }}</td>
                    <td>{{ $donation->donatur->name }}</td>
                    <td>{{ $donation->campaign->title }}</td>
                    <td class="text-right">{{ moneyFormat($donation->amount) }}</td>
                    <td>{{ $donation->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data yang cocok dengan kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if (isset($total) && $total > 0)
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right font-bold">TOTAL</td>
                    <td colspan="2" class="font-bold text-right">{{ moneyFormat($total) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>

</html>
