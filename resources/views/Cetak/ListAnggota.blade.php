<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftar Anggota</title>
  <style>
    body {
      font-family: "Times New Roman", Times, serif;
      background-color: #f0f0f0;
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
      margin: 20px;
      padding: 0;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      box-sizing: border-box;
      overflow: hidden;
    }

    .header {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1;
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
      z-index: 1;
    }

    .footer img {
      width: 100%;
      display: block;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 10pt;
      table-layout: fixed;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #000;
      padding: 4px 6px;
      text-align: left;
      word-wrap: break-word;
    }
    th {
      background-color: #f2f2f2;
      font-size: 10pt;
    }

    td:nth-child(1) { width: 30px; }
    td:nth-child(2) { width: 80px; }
    td:nth-child(3) { width: 120px; }
    td:nth-child(4) { width: 100px; }
    td:nth-child(5) { width: 90px; }
    td:nth-child(6) { width: auto; }

    tr { page-break-inside: avoid; }

    @media print {
      body {
        background-color: white;
        margin: 0;
        padding: 0;
      }
      .page-container {
        margin: 0;
        padding: 0;
        width: 100%;
        min-height: 100%;
        box-shadow: none;
        position: relative;
        overflow: visible;
      }
      .header, .footer, .content {
        position: absolute;
      }
      .content {
        width: 100%;
        box-sizing: border-box;
      }
    }
  </style>
</head>
<body>
  <div class="page-container">
    <div class="header">
      <img src="{{ public_path('assets/img/header.jpg') }}" alt="Header Surat" />
    </div>

    <div class="content">
      <h3 style="text-align:center; margin-bottom:15px;">Daftar Anggota Perpustakaan</h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>ID Anggota</th>
            <th>Nama</th>
            <th>Tipe Anggota</th>
            <th>Telepon</th>
            <th>Alamat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($anggotas as $i => $a)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $a->member_id }}</td>
            <td>{{ $a->nama }}</td>
            <td>{{ $a->tipeAnggota->nama_tipe ?? '-' }}</td>
            <td>{{ $a->kelas ?? 'User Ini Bukan Siswa' }}</td>
            <td>{{ $a->telepon ?? '-' }}</td>
            <td>{{ $a->alamat ?? '-' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="footer">
      <img src="{{ public_path('assets/img/footer.jpg') }}" alt="Footer Surat" />
    </div>
  </div>
</body>
</html>
