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
            font-size: 10pt;
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
            font-size: 9pt;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px 4px;
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
            <h3 style="text-align:center; margin-bottom:10px;">REKAPITULASI DATA STATISTIK PENAMBAHAN KOLEKSI BERKALA
                PERPUSTAKAAN SEKOLAH TAHUN {{ $tahun }}</h3>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2" style="width:30px;">No</th>
                        <th rowspan="2">Jenis Koleksi</th>
                        <th colspan="2">Sebelum {{ $tahun }}</th>
                        <th colspan="2">Tahun {{ $tahun }}</th>
                        <th colspan="2">Jumlah Koleksi</th>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                        <th>Judul</th>
                        <th>Eksp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td style="text-align:left;">{{ $d['jenis'] }}</td>
                            <td>{{ number_format($d['judulBefore']) }}</td>
                            <td>{{ number_format($d['ekspBefore']) }}</td>
                            <td>{{ number_format($d['judulYear']) }}</td>
                            <td>{{ number_format($d['ekspYear']) }}</td>
                            <td>{{ number_format($d['judulTotal']) }}</td>
                            <td>{{ number_format($d['ekspTotal']) }}</td>
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
