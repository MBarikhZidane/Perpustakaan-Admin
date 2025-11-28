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
            line-height: 1.4;
            font-size: 11pt;
            position: relative;
            z-index: 2;
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

        ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <div class="header">
            <img src="{{ public_path('assets/img/header.jpg') }}" alt="Header" />
        </div>
        <div class="content">
            <h3 style="text-align:center; margin-bottom:15px;">STATISTIK KOLEKSI</h3>
            <p>Jumlah Judul : {{ number_format($totalJudul) }}</p>
            <p>Jumlah Judul Dengan Item : {{ number_format($judulDenganItem) }}</p>
            <p>Jumlah Item : {{ number_format($totalItem) }}</p>
            <p>Jumlah Item Keluar : {{ number_format($itemKeluar) }}</p>
            <p>Jumlah Item Tersedia : {{ number_format($itemTersedia) }}</p>
            <p>Jumlah Judul Berdasar GMD :</p>
            <ul>
                @foreach ($judulPerGmd as $gmd => $jumlah)
                    <li>{{ $gmd ?? '-' }} : {{ number_format($jumlah) }}</li>
                @endforeach
            </ul>
            <p>Jumlah Judul Berdasar Tipe Koleksi :</p>
            <ul>
                @foreach ($judulPerTipe as $tipe => $jumlah)
                    <li>{{ $tipe ?? '-' }} : {{ number_format($jumlah) }}</li>
                @endforeach
            </ul>
            <p>10 Judul Terpopuler :</p>
            <ul>
                @foreach ($topJudul as $judul)
                    <li>{{ $judul }}</li>
                @endforeach
            </ul>
        </div>
        <div class="footer">
            <img src="{{ public_path('assets/img/footer.jpg') }}" alt="Footer" />
        </div>
    </div>
</body>

</html>
