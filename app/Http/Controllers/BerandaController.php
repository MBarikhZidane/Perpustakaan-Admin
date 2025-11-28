<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Bibliografi;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    // ===================== BERANDA =====================
    public function viewHome()
    {
        $jumlahBuku = Bibliografi::count();
        $jumlahAnggota = Anggota::count();
        $jumlahSirkulasiAktif = Peminjaman::where('is_return', false)->count();
        $jumlahItem = Item::count();

        return view('Beranda.home', compact(
            'jumlahBuku',
            'jumlahAnggota',
            'jumlahSirkulasiAktif',
            'jumlahItem'
        ));
    }

    public function viewKonfigurasi()
    {
        return view('Beranda.konfigurasi');
    }

    // ===================== KEANGGOTAAN =====================
    public function viewDaftarAnggota()
    {
        return view('Beranda.Keanggotaan.daftarAnggota');
    }

    public function viewTipeAnggota()
    {
        return view('Beranda.Keanggotaan.tipeAnggota');
    }


    public function viewSuratBebasPerpustakaan()
    {
        return view('Beranda.Keanggotaan.suratBebasPerpus');
    }

    // ===================== TABEL DATA =====================
    public function viewHariLibur()
    {
        return view('Beranda.Tabel Data.hariLibur');
    }

    public function viewJenisItem()
    {
        return view('Beranda.Tabel Data.jenisItem');
    }

    public function viewPenerbit()
    {
        return view('Beranda.Tabel Data.penerbit');
    }

    public function viewPenulis()
    {
        return view('Beranda.Tabel Data.penulis');
    }

    public function viewSupplier()
    {
        return view('Beranda.Tabel Data.supplier');
    }

    public function viewTopik()
    {
        return view('Beranda.Tabel Data.topik');
    }

    public function viewLokasi()
    {
        return view('Beranda.Tabel Data.lokasi');
    }

    public function viewRak()
    {
        return view('Beranda.Tabel Data.rak');
    }

    public function viewTempatPenerbit()
    {
        return view('Beranda.Tabel Data.tempatPenerbit');
    }

    public function viewStatusItem()
    {
        return view('Beranda.Tabel Data.statusItem');
    }

    public function viewTipeKoleksi()
    {
        return view('Beranda.Tabel Data.tipeKoleksi');
    }

    public function viewFrekuensi()
    {
        return view('Beranda.Tabel Data.frekuensi');
    }

    public function viewBahasa()
    {
        return view('Beranda.Tabel Data.bahasa');
    }

    public function viewTujuanBebasPerpus()
    {
        return view('Beranda.Tabel Data.tujuanBebasPerpus');
    }
    public function poke()
    {
        return view('livewire.pdf.cetak-katalog-pdf');
    }
}
