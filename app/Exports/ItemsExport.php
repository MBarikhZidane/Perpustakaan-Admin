<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Eager load relasi supaya lebih efisien
        return Item::with('bibliografi', 'bibliografi.gmd', 'bibliografi.penulis', 'bibliografi.topik', 'bibliografi.penerbit', 'bibliografi.frekuensi', 'lokasi', 'rak', 'tipeKoleksi')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Item',
            'Judul',
            'Penulis',
            'Penerbit',
            'Tahun Terbit',
            'Subyek',
            'Klasifikasi',
            'ISBN/ISSN',
            'Jenis',
            'Lokasi',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->kode_item,
            $item->bibliografi->judul,
            $item->bibliografi->penulis->nama ?? '-',
            $item->bibliografi->penerbit->nama_penerbit ?? '-',
            $item->bibliografi->tahun_terbit ?? '-',
            $item->bibliografi->topik->name_topik ?? '-',
            $item->bibliografi->klasifikasi ?? '-',
            $item->bibliografi->isbn_issn ?? '-',
            $item->bibliografi->gmd->nama_gmd ?? '-',
            $item->lokasi->nama_lokasi ?? '-',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Header (baris 1) bold
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        // Kolom B (Kode Item) bold
        $sheet->getStyle('B2:B'.$sheet->getHighestRow())->getFont()->setBold(true);
    }
}
