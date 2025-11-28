<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SirkulasiController extends Controller
{
    public function viewAturanPeminjaman()
    {
        return view('sirkulasi.aturanpeminjaman');
    }
    public function viewDaftarKeterlambatan()
    {
        return view('sirkulasi.daftarketerlambatan');
    }
    public function viewPemesanan()
    {
        return view('sirkulasi.pemesanan');
    }
    public function viewPengembalian()
    {
        return view('sirkulasi.pengembalian');
    }
    public function viewRiwayatPeminjaman()
    {
        return view('sirkulasi.riwayatpeminjaman');
    }
    public function viewStockOpname()
    {
        return view('sirkulasi.stockopname');
    }
    public function viewTransaksi()
    {
        return view('sirkulasi.transaksi');
    }
}
