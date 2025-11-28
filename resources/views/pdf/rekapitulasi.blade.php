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
            font-size: 11pt;
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
            font-size: 10pt;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <div class="header">
            <img src="{{ public_path('assets/img/header.jpg') }}" alt="Header" />
        </div>
        <div class="content">
            <h3 style="text-align:center; margin-bottom:15px;">REKAPITULASI BERDASARKAN {{ strtoupper($kategori) }}</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:30px;">No.</th>
                        <th>Kategori</th>
                        <th style="width:80px;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ number_format($row->jumlah) }}</td>
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
