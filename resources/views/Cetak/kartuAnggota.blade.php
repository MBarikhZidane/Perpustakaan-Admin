<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota Perpustakaan - SMK Krian 1 Sidoarjo</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .card-container {
            width: 8.56cm;
            height: 5.39cm;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 12px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .front-header {
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1.5px solid #005a9e;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .front-header img {
            height: 50px;
            flex-shrink: 0;
        }

        .front-header .title-group {
            width: 400px;
            height: 50px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            line-height: 1;
            text-align: center;
        }

        .front-header .main-title {
            font-weight: 600;
            font-size: 9.5pt;
            color: #003366;
            margin: 0;
            margin-top: 9px;
        }

        .front-header .sub-title {
            font-weight: 800;
            font-size: 12pt;
            color: #005a9e;
            margin: 0;
        }

        .front-header .address {
            font-family: 'Roboto', sans-serif;
            font-size: 6pt;
            color: #555;
            margin-top: 2px;
        }

        .front-content {
            display: flex;
            gap: 12px;
            flex-grow: 1;
            align-items: center;
        }

        .photo-placeholder {
            width: 65px;
            height: 85px;
            background-color: #eef5fc;
            border: 1.5px dashed #a0c8ed;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #005a9e;
            font-size: 7.5pt;
            text-align: center;
            flex-shrink: 0;
        }

        .data-table {
            font-family: 'Roboto', sans-serif;
            font-size: 8pt;
            flex-grow: 1;
        }

        .data-table td {
            padding: 2.8px 0;
            vertical-align: top;
        }

        .data-table td:first-child {
            width: 55px;
            font-weight: 500;
            color: #333;
        }

        .back-header {
            text-align: center;
            font-size: 10pt;
            font-weight: 700;
            color: #003366;
            padding-bottom: 4px;
            border-bottom: 1.5px solid #005a9e;
            margin-bottom: 8px;
        }

        .rules-list {
            font-family: 'Roboto', sans-serif;
            font-size: 7pt;
            padding-left: 20px;
            margin: 0;
            color: #333;
            line-height: 1.45;
        }

        .rules-list li {
            padding-bottom: 1.5px;
        }

        .back-footer {
            font-family: 'Roboto', sans-serif;
            font-size: 6.5pt;
            text-align: center;
            color: #005a9e;
            font-weight: 500;
            margin-top: auto;
            padding-top: 5px;
        }

        .card-bg {
            position: absolute;
            bottom: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background-color: #005a9e;
            opacity: 0.05;
            border-radius: 50%;
            z-index: 0;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 1cm;
                gap: 20px;
            }
            .card-container {
                box-shadow: none;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body >
    <div class="card-container">
        <div class="card-bg"></div>
        <div class="front-header">
                        <img src="{{ public_path('assets/img/Skarisa.png') }}" alt="Logo SMK Krian 1">

            <div class="title-group">
                <p class="main-title">KARTU ANGGOTA PERPUSTAKAAN</p>
                <p class="sub-title">SMK KRIAN 1 SIDOARJO</p>
                <p class="address">Jl. Kyai Mojo Katrungan-Krian, Bakalan, Katrungan, Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61262</p>
            </div>
        </div>
        <div class="front-content">
            <div class="photo-placeholder">Foto Siswa 3x4</div>
            <table class="data-table">
                <tr>
                    <td>ID Anggota</td>
                    <td>: {{ $anggota->member_id }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $anggota->nama }}</td>
                </tr>
                <tr>
                    <td>Tipe</td>
                    <td>: {{ $anggota->tipeAnggota->nama_tipe ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td>: {{ $anggota->telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $anggota->alamat ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card-container">
        <div class="card-bg"></div>
        <div class="back-header">
            TATA TERTIB PERPUSTAKAAN
        </div>
        <ol class="rules-list">
            <li>Kartu anggota wajib dibawa setiap kali berkunjung atau meminjam buku.</li>
            <li>Jaga ketenangan, ketertiban, dan kebersihan di dalam ruang perpustakaan.</li>
            <li>Dilarang membawa tas, makanan, dan minuman ke dalam ruang baca.</li>
            <li>Maksimal peminjaman 2 (dua) buku selama 7 (tujuh) hari.</li>
            <li>Keterlambatan pengembalian akan dikenakan sanksi sesuai kebijakan.</li>
        </ol>
        <div class="back-footer">
            Berlaku selama menjadi siswa SMK Krian 1 Sidoarjo
        </div>

    </div>
</body>
</html>





