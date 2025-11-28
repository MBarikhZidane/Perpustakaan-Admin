<?php

namespace App\Livewire\Katalog;

use Carbon\Carbon;
use App\Models\Item;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class CetakKatalogComponent extends Component
{
    public $id;
     use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // #[Url(as: 'q')]
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportPDF($id)
    {
    $item = Item::with('bibliografi.penulis', 'bibliografi.penerbit', 'bibliografi.gmd')
            ->where('kode_item', $id)
            ->firstOrFail();


    $pdf = Pdf::loadView('livewire.pdf.cetak-katalog-pdf', [
        'item' => $item
    ])->setPaper('a4', 'portrait');;

    return response()->streamDownload(
        fn() => print($pdf->output()),
        'cetakkatalog'.$id.'.pdf'
    );
    }

    public function render()
    {
        $items = Item::with('bibliografi.penulis', 'bibliografi.penerbit', 'bibliografi.gmd')
        ->where(function ($query) {
        $query->where('kode_item', 'like', '%' . $this->search . '%')
              ->orWhereHas('bibliografi', function ($q) {
                  $q->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhereHas('penulis', function ($q2) {
                        $q2->where('nama', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('penerbit', function ($q3) {
                        $q3->where('nama_penerbit', 'like', '%' . $this->search . '%');
                    });
              });
            })
            ->latest()
            ->paginate(10);
        return view('livewire.katalog.cetak-katalog-component', compact('items'));
    }
}
