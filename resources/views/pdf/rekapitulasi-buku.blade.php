<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .page-container {
            position: relative;
            width: 21cm;
            min-height: 29.7cm;
            background-color: white;
        }

        .header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .header img {
            width: 100%;
            display: block;
        }

        .content {
            padding: 4.5cm 2.5cm 5cm 2.5cm;
            font-size: 9pt;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50%;
            max-width: 450px;
        }

        .footer img {
            width: 100%;
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <div class="header">
            <img src="{{ public_path('assets/img/header.jpg') }}" alt="Header" />
        </div>
        <div class="content">
            <h3 style="text-align:center; margin-bottom:10px; margin-top:30px;">REKAPITULASI DATA STATISTIK BUKU PERPUSTAKAAN PERIODE
                {{ $startDate }} s/d {{ $endDate }}</h3>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Nomor Klasifikasi</th>
                        <th colspan="4">Koleksi Sebelum {{ $startDate }}</th>
                        <th colspan="4">Penambahan Koleksi {{ $startDate }} s/d {{ $endDate }}</th>
                        <th colspan="4">Jumlah Koleksi</th>
                    </tr>
                    <tr>
                        <th colspan="2">Bahasa Indonesia</th>
                        <th colspan="2">Bahasa Asing</th>
                        <th colspan="2">Bahasa Indonesia</th>
                        <th colspan="2">Bahasa Asing</th>
                        <th colspan="2">Bahasa Indonesia</th>
                        <th colspan="2">Bahasa Asing</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td style="text-align:left;">{{ $row['klasifikasi'] }}</td>
                            <td>{{ number_format($row['judulSebelumId']) }}</td>
                            <td>{{ number_format($row['ekspSebelumId']) }}</td>
                            <td>{{ number_format($row['judulSebelumAs']) }}</td>
                            <td>{{ number_format($row['ekspSebelumAs']) }}</td>
                            <td>{{ number_format($row['judulTambahId']) }}</td>
                            <td>{{ number_format($row['ekspTambahId']) }}</td>
                            <td>{{ number_format($row['judulTambahAs']) }}</td>
                            <td>{{ number_format($row['ekspTambahAs']) }}</td>
                            <td>{{ number_format($row['judulTotalId']) }}</td>
                            <td>{{ number_format($row['ekspTotalId']) }}</td>
                            <td>{{ number_format($row['judulTotalAs']) }}</td>
                            <td>{{ number_format($row['ekspTotalAs']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <img src="{{ public_path('assets/img/footer.jpg') }}" alt="Footer" />
        </div>
    </div>
</body>

</html>
