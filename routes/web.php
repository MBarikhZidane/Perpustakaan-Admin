<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\SirkulasiController;

Route::get('/login', [AuthController::class, 'viewLogin'])->name('login.index')->middleware('guest');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login');

Route::middleware("auth")->group(function () {
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');

    Route::get('/', [BerandaController::class, 'viewHome'])->name('home.index');
    Route::get('/konfigurasi', [BerandaController::class, 'viewKonfigurasi'])->name('konfigurasi.index');
    Route::get('/poke', [BerandaController::class, 'poke'])->name('poke');

    Route::prefix('keanggotaan')->group(function () {
        Route::get('/daftar-anggota', [BerandaController::class, 'viewDaftarAnggota'])->name('keanggotaan.daftar');
        Route::get('/tipe-anggota', [BerandaController::class, 'viewTipeAnggota'])->name('keanggotaan.tipe');
        Route::get('/surat-bebas-perpus', [BerandaController::class, 'viewSuratBebasPerpustakaan'])->name('keanggotaan.surat_bebas');
    });

    Route::prefix('tabel-data')->group(function () {
        Route::get('/hari-libur', [BerandaController::class, 'viewHariLibur'])->name('tabel.hari_libur');
        Route::get('/jenis-item', [BerandaController::class, 'viewJenisItem'])->name('tabel.jenis_item');
        Route::get('/penerbit', [BerandaController::class, 'viewPenerbit'])->name('tabel.penerbit');
        Route::get('/penulis', [BerandaController::class, 'viewPenulis'])->name('tabel.penulis');
        Route::get('/supplier', [BerandaController::class, 'viewSupplier'])->name('tabel.supplier');
        Route::get('/topik', [BerandaController::class, 'viewTopik'])->name('tabel.topik');
        Route::get('/lokasi', [BerandaController::class, 'viewLokasi'])->name('tabel.lokasi');
        Route::get('/rak', [BerandaController::class, 'viewRak'])->name('tabel.rak');
        Route::get('/tempat-penerbit', [BerandaController::class, 'viewTempatPenerbit'])->name('tabel.tempat_penerbit');
        Route::get('/status-item', [BerandaController::class, 'viewStatusItem'])->name('tabel.status_item');
        Route::get('/tipe-koleksi', [BerandaController::class, 'viewTipeKoleksi'])->name('tabel.tipe_koleksi');
        Route::get('/frekuensi', [BerandaController::class, 'viewFrekuensi'])->name('tabel.frekuensi');
        Route::get('/bahasa', [BerandaController::class, 'viewBahasa'])->name('tabel.bahasa');
        Route::get('/tujuan-bebas-perpus', [BerandaController::class, 'viewTujuanBebasPerpus'])->name('tabel.tujuan_bebas');
    });

    Route::get('/anggota', [CetakController::class, 'cetakListAnggota'])->name('cetak.list.anggota');
    Route::get('/anggota/{anggota}/cetak', [CetakController::class, 'cetakKartuAnggota'])->name('cetak.kartu.anggota');
});

Route::prefix('sirkulasi')->group(function () {
    Route::get('/aturan-peminjaman', [SirkulasiController::class, 'viewAturanPeminjaman'])->name('sirkulasi.aturan_peminjaman');
    Route::get('/daftar-keterlambatan', [SirkulasiController::class, 'viewDaftarKeterlambatan'])->name('sirkulasi.daftar_keterlambatan');
    Route::get('/pemesanan', [SirkulasiController::class, 'viewPemesanan'])->name('sirkulasi.pemesanan');
    Route::get('/pengembalian', [SirkulasiController::class, 'viewPengembalian'])->name('sirkulasi.pengembalian');
    Route::get('/riwayat-peminjaman', [SirkulasiController::class, 'viewRiwayatPeminjaman'])->name('sirkulasi.riwayat_peminjaman');
    Route::get('/stock-opname', [SirkulasiController::class, 'viewStockOpname'])->name('sirkulasi.stock_opname');
    Route::get('/transaksi', [SirkulasiController::class, 'viewTransaksi'])->name('sirkulasi.transaksi');
});

Route::prefix('katalog')->group(function () {
    Route::get('/bibliografi', [KatalogController::class, 'viewBibliografi'])->name('katalog.bibliografi');
    Route::get('/cetak-barcode-item', [KatalogController::class, 'viewCetakBarcodeItem'])->name('katalog.cetak_barcode_item');
    Route::get('/cetak-catalog', [KatalogController::class, 'viewCetakCatalog'])->name('katalog.cetak_catalog');
    Route::get('/cetak-label', [KatalogController::class, 'viewCetakLabel'])->name('katalog.cetak_label');
    Route::get('/daftar-item', [KatalogController::class, 'viewDaftarItem'])->name('katalog.daftar_item');
    Route::get('/item-keluar', [KatalogController::class, 'viewItemKeluar'])->name('katalog.item_keluar');
    Route::get('/serial-control', [KatalogController::class, 'viewSerialControl'])->name('katalog.serial_control');
});


Route::prefix('pelaporan')->group(function () {
    Route::get('/pelaporan/statistik-koleksi', [PelaporanController::class, 'statistikKoleksi'])
        ->name('pelaporan.statistik-koleksi');

    Route::get('/pelaporan/statistik-koleksi/pdf', [PelaporanController::class, 'statistikKoleksiPdf'])
        ->name('pelaporan.statistik-koleksi.pdf');

    Route::get('/laporan-peminjaman', [PelaporanController::class, 'laporanPeminjaman'])
        ->name('pelaporan.laporan-peminjaman');

    Route::get('/laporan-peminjaman/pdf', [PelaporanController::class, 'laporanPeminjamanPdf'])
        ->name('pelaporan.laporan-peminjaman.pdf');

    Route::get('/laporan-keanggotaan', [PelaporanController::class, 'laporanKeanggotaan'])
        ->name('pelaporan.laporan-keanggotaan');

    Route::get('/laporan-keanggotaan/pdf', [PelaporanController::class, 'laporanKeanggotaanPdf'])
        ->name('pelaporan.laporan-keanggotaan.pdf');

    Route::get('/rekapitulasi', [PelaporanController::class, 'rekapitulasi'])
        ->name('pelaporan.rekapitulasi');

    Route::get('/rekapitulasi/pdf', [PelaporanController::class, 'rekapitulasiPdf'])
        ->name('pelaporan.rekapitulasi.pdf');


    Route::get('/rekapitulasi-berkala', [PelaporanController::class, 'rekapitulasiBerkala'])
        ->name('pelaporan.rekapitulasi-berkala');

    Route::get('/rekapitulasi-berkala/pdf', [PelaporanController::class, 'rekapitulasiBerkalaPdf'])
        ->name('pelaporan.rekapitulasi-berkala.pdf');

    Route::get('/rekapitulasi-buku', [PelaporanController::class, 'rekapitulasiBuku'])
        ->name('pelaporan.rekapitulasi-buku');

    Route::get('/rekapitulasi-buku/pdf', [PelaporanController::class, 'rekapitulasiBukuPdf'])
        ->name('pelaporan.rekapitulasi-buku.pdf');
});
