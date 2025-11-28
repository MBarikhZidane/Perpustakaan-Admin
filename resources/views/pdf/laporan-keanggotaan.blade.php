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
            <h3 style="text-align:center; margin-bottom:15px;">LAPORAN KEANGGOTAAN</h3>
            <p>Total Anggota : {{ number_format($totalAnggota) }}</p>
            <p>Total Anggota Yang Aktif : {{ number_format($anggotaAktif) }}</p>
            <p>10 Anggota Yang Paling Aktif :</p>
            <ul>
                @foreach ($topMembers as $m)
                    <li>{{ $m['nama'] }} ({{ number_format($m['total']) }} pinjaman)</li>
                @endforeach
            </ul>
        </div>
        <div class="footer">
            <img src="{{ public_path('assets/img/footer.jpg') }}" alt="Footer" />
        </div>
    </div>
</body>

</html>
