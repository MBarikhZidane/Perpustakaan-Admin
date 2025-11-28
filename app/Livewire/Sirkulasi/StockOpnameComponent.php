<?php

namespace App\Livewire\Sirkulasi;

use App\Models\Item;
use Livewire\Component;
use App\Models\Peminjaman;
use App\Models\StockOpname;
use Livewire\WithPagination;

class StockOpnameComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $stock_take_name, $start_date;
    // public $tipe_members;
    // public $tipe_colls;
    // public $tipe_gmd;

     #[Url(as: 'q')]
    public $search = '';
    public $searchitem_code = '';
    public $searchjudul = '';
    public $activeTab = 'pills-summary';
    public $selected_id;
    public $selected_model;

    public function setActiveTab($tab)
    {
    $this->activeTab = $tab;
    }


    public function mount()
    {
    // isi default sesuai tanggal hari ini
    $this->start_date = now()->format('Y-m-d');
    }

    protected function rules()
    {
        return [
            'stock_take_name' => 'required',
            'start_date' => 'required',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->stock_take_name  = '';
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            StockOpname::create([
                'stock_take_name'  => $this->stock_take_name,
                'start_date'    => $this->start_date,
            ]);

            $this->resetInput();
            session()->flash('success', 'Aturan Pemimjaman berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editId($id){

    }

    public function deletemodal($kode_item)
    {
        $this->selected_model = $kode_item;
    }

    public function destroymodal()
    {
        try {
            Item::findOrFail($this->selected_model)->delete();
            $this->resetInput();
            session()->flash('success', 'Data Item berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function selectDelete($id)
    {
       $this->selected_id = $id;
    }

    public function destroy()
    {
    try {
            StockOpname::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Data Item berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function render()
    {
        $items = Item::with(['bibliografi', 'lokasi', 'rak', 'tipeKoleksi', 'status'])
        ->where(function ($query) {
        $query->whereHas('bibliografi', function ($q) {
            $q->where('judul', 'like', '%' . $this->searchjudul . '%');
        })
        ->orWhere('kode_item', 'like', '%' . $this->searchitem_code . '%');
        })
        ->latest()
        ->paginate(10);

        $stocks = StockOpname::where(function ($query) {
                $query->where('stock_take_name', 'like', '%' . $this->search . '%');
            })->latest()
            ->paginate(10);

        return view('livewire.sirkulasi.stock-opname-component', compact('stocks', 'items'));
    }

}
