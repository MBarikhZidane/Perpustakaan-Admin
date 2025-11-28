<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function viewBibliografi()
    {
        return view('katalog.bibliografi');
    }
    public function viewCetakBarcodeItem()
    {
        return view('katalog.cetakbarcodeitem');
    }
    public function viewCetakCatalog()
    {
        return view('katalog.cetakcatalog');
    }
    public function viewCetakLabel()
    {
        return view('katalog.cetaklabel');
    }
    public function viewDaftarItem()
    {
        return view('katalog.daftaritem');
    }
    public function viewItemKeluar()
    {
        return view('katalog.itemkeluar');
    }
    public function viewSerialControl()
    {
        return view('katalog.serialcontrol');
    }
}

