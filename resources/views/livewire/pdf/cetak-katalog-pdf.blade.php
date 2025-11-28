<!DOCTYPE html>
<html>

<head>
    <title>Cetak Katalog</title>
</head>
<body style="background-color: white;">
    <div
        style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #333; max-width: 370px; height: 470px; margin: 0 auto; background-color: white;">
<img src="{{ public_path('assets/img/header.jpg') }}" alt="Header Image" style="width: 100%; max-width: 500px;">
        <div style="height: 257px;">
            <h5 style="margin-top: 20px 0; color: #2c3e50; font-family: Arial, sans-serif; text-align: center;">Katalog
                Perpustakaan Skarisa</h5>
            <div style="margin-left: 40px; margin-top: 50px;">
                <h6 style="margin-block: 10px 0; color: #34495e; font-family: Arial, sans-serif;">Call Number:
                    {{ $item->call_number }}</h6>
                <h6 style="margin-block: 10px 0; color: #34495e; font-family: Arial, sans-serif;">Judul:
                    {{ $item->bibliografi->judul }}</h6>
                <h6 style="margin-block: 10px 0; color: #34495e; font-family: Arial, sans-serif;">Penerbit:
                    {{ $item->bibliografi->penerbit->nama_penerbit }}</h6>
                <h6 style="margin-block: 10px 0; color: #34495e; font-family: Arial, sans-serif;">ISBN:
                    {{ $item->bibliografi->isbn_issn }}</h6>
            </div>
        </div>
        <img src="{{ public_path('assets/img/footer.jpg') }}" alt="" style="width: 120px;">
    </div>
</body>

</html>
