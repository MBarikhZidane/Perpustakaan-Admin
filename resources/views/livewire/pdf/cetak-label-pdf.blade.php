<!DOCTYPE html>
<html>

<head>
    <title>Cetak Label</title>
</head>
<body style="background-color: white;">
    <div
        style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #333; max-width: 370px; height: 470px; margin: 0 auto; background-color: white;">
<img src="{{ public_path('assets/img/header.jpg') }}" alt="Header Image" style="width: 100%; max-width: 500px;">
        <div style="height: 257px;">
            <h5 style="margin-top: 20px 0; color: #2c3e50; font-family: Arial, sans-serif; text-align: center;">Katalog
                Perpustakaan Skarisa</h5>
                <center>
            <div style="margin-top: 10px;">

                <h6 style="margin-block: 10px 0; color: #34495e; font-family: Arial, sans-serif; font-size: 40px">
                    {{ $item->call_number }}</h6>

            </div>
            </center>
        </div>
        <img src="{{ public_path('assets/img/footer.jpg') }}" alt="" style="width: 120px;">
    </div>
</body>

</html>
