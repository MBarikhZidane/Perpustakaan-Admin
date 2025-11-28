<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;

class CetakController extends Controller
{
    public function cetakListAnggota()
    {
        $anggotas = Anggota::with('tipeAnggota')->get();

        $html = View::make('Cetak.listAnggota', compact('anggotas'))->render();
        $path = storage_path('app/list-anggota.pdf');

        Browsershot::html($html)
            ->format('A4')
            ->margins(20, 20, 20, 20)   // margin biar enak dibaca
            ->showBackground()
            ->noSandbox()
            ->emulateMedia('screen')
            ->setOption('args', [
                '--print-backgrounds',
                '--disable-web-security',
                '--disable-dev-shm-usage',
                '--disable-gpu'
            ])
            ->save($path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="list-anggota.pdf"'
        ]);
    }

    public function cetakKartuAnggota(Anggota $anggota)
    {
        $html = View::make('Cetak.kartuAnggota', compact('anggota'))->render();
        $path = storage_path('app/kartu-anggota-' . $anggota->member_id . '.pdf');

        Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->showBackground()
            ->noSandbox()
            ->emulateMedia('screen')
            ->setOption('args', [
                '--print-backgrounds',
                '--disable-web-security',
                '--disable-dev-shm-usage',
                '--disable-gpu'
            ])
            ->save($path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="kartu-anggota-' . $anggota->member_id . '.pdf"'
        ]);
    }
}
