<?php

namespace App\Livewire\Katalog;

use Carbon\Carbon;
use App\Models\Rak;
use App\Models\Item;
use App\Models\Lokasi;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\StatusItem;
use App\Models\Bibliografi;
use App\Models\TipeKoleksi;
use Livewire\WithPagination;

class SerialControlComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url(as: 'q')]
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = Item::with('bibliografi.penulis', 'bibliografi.frekuensi', 'bibliografi.penerbit', 'rak', 'tipeKoleksi', 'status', 'supplier', 'peminjaman', 'transaksiPemesanan')
        ->when($this->search, function($q) {
            $q->where(function ($q) {
                $q->where('kode_item', 'like', '%' . $this->search . '%')
                  ->orWhereHas('bibliografi', function ($q2) {
                      $q2->where('judul', 'like', '%' . $this->search . '%')
                         ->orWhereHas('penulis', function ($q3) {
                             $q3->where('nama', 'like', '%' . $this->search . '%');
                         })
                         ->orWhereHas('penerbit', function ($q3) {
                             $q3->where('nama_penerbit', 'like', '%' . $this->search . '%');
                         });
                  });
            });
        })
        ->latest()
        ->paginate(10);
        return view('livewire.katalog.serial-control-component', compact('items'));
    }
}
