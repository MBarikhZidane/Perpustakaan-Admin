<!DOCTYPE html>
<html>

<head>
    <title>Cetak Barcode</title>
</head>
<body style="background-color: white;">
    <div
        style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #333; max-width: 370px; height: 470px; margin: 0 auto; background-color: white;">
<img src="{{ public_path('assets/img/header.jpg') }}" alt="Header Image" style="width: 100%; max-width: 500px;">
        <div style="height: 257px;">
            <h5 style="margin-top: 20px 0; color: #2c3e50; font-family: Arial, sans-serif; text-align: center;">Katalog
                Perpustakaan Skarisa</h5>
            <div style="margin-top: 20px; text-align: center;">
                <div style="display: inline-block;">
                    {!! DNS1D::getBarcodeHTML($item->kode_item, 'C128') !!}
                    <div style="margin-top: 5px; font-size: 10px; font-family: Arial, sans-serif; color: black;">
                        {{ $item->kode_item }}
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ public_path('assets/img/footer.jpg') }}" alt="" style="width: 120px;">
    </div>
</body>

</html>
