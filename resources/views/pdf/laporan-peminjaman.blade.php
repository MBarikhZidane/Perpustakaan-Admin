<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: "Times New Roman", Times, serif; background-color: #ffffff; margin: 0; padding: 0; display: flex; justify-content: center; }
    .page-container { position: relative; width: 21cm; min-height: 29.7cm; background-color: white; }
    .header { position: absolute; top: 0; left: 0; width: 100%; }
    .header img { width: 100%; display: block; }
    .content { padding: 4.5cm 2.5cm 5cm 2.5cm; font-size: 11pt; }
    .footer { position: absolute; bottom: 0; left: 0; width: 50%; max-width: 450px; }
    .footer img { width: 100%; display: block; }
    ul { margin: 0; padding-left: 20px; }
  </style>
</head>
<body>
  <div class="page-container">
    <div class="header">
      <img src="{{ public_path('assets/img/header.jpg') }}" alt="Header" />
    </div>
    <div class="content">
      <h3 style="text-align:center; margin-bottom:15px;">LAPORAN PEMINJAMAN</h3>
      <p>Total Peminjaman : {{ number_format($totalPeminjaman) }}</p>
      <p>Total Item Menurut Jenis Koleksi :</p>
      <ul>
        @foreach($peminjamanTipe as $nama => $jumlah)
        <li>{{ $nama }} : {{ number_format($jumlah) }}</li>
        @endforeach
      </ul>
      <p>Total Transaksi Peminjaman : {{ number_format($totalTransaksi) }}</p>
      <p>Rata-rata Transaksi Per Hari : {{ number_format($rataPerHari) }}</p>
      <p>Transaksi Tertinggi Dalam Sehari : {{ number_format($transaksiTertinggi) }}</p>
      <p>Anggota Yang Meminjam : {{ number_format($anggotaYangMeminjam) }}</p>
      <p>Anggota Yang Belum Pernah Meminjam : {{ number_format($anggotaBelumPinjam) }}</p>
      <p>Total Peminjaman Terlambat : {{ number_format($totalTerlambat) }}</p>
    </div>
    <div class="footer">
      <img src="{{ public_path('assets/img/footer.jpg') }}" alt="Footer" />
    </div>
  </div>
</body>
</html>
