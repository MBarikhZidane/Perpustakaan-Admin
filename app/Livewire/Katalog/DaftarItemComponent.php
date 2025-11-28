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
use App\Exports\ItemsExport;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DaftarItemComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $judul, $kode_item, $call_number, $kode_inventori, $lokasi_id, $rak_id, $tipe_koleksi_id, $status_id, $nmr_order, $tgl_order, $tgl_penerimaan, $invoice, $supplier_id, $source, $tgl_invoice, $harga, $harga_currency, $is_fotocopy, $bibliografi_id;
    public $tipe_koleksi;
    public $tipe_rak;
    public $selected_id;
    public $tipe_lokasi;
    public $tipe_status;
    public $tipe_supplier;
    public $bibliografi;

     #[Url(as: 'q')]
    public $search = '';
    public $activeTab = 'pills-summary';

    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }

    public function mount()
    {
        $this->tipe_koleksi = TipeKoleksi::all();
        $this->tipe_rak = Rak::all();
        $this->tipe_lokasi = Lokasi::all();
        $this->tipe_status = StatusItem::all();
        $this->tipe_supplier = Supplier::all();
        $this->bibliografi = Bibliografi::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setActiveTab($tab)
    {
    $this->activeTab = $tab;
    }

    protected function rules()
    {
        return [
            'bibliografi_id'      => 'required',
            'kode_item'      => 'required',
            'call_number'      => 'required',
            'kode_inventori'      => 'required',
            'lokasi_id'      => 'required',
            'rak_id'      => 'required',
            'tipe_koleksi_id'      => 'required',
            'status_id'      => 'required',
            'nmr_order'      => 'required',
            'tgl_order'      => 'required',
            'tgl_penerimaan'      => 'required',
            'supplier_id'      => 'required',
            'source'      => 'required',
            'tgl_invoice'      => 'required',
            'harga'      => 'required',
            'harga_currency'      => 'required',
        ];
    }

     private function resetInput()
    {
        $this->bibliografi_id  = '';
        $this->kode_item    = '';
        $this->call_number = '';
        $this->kode_inventori      = '';
        $this->rak_id    = '';
        $this->lokasi_id    = '';
        $this->tipe_koleksi_id  = '';
        $this->status_id   = '';
        $this->nmr_order   = '';
        $this->tgl_order   = '';
        $this->tgl_penerimaan   = '';
        $this->invoice   = '';
        $this->supplier_id   = '';
        $this->source   = '';
        $this->tgl_invoice   = '';
        $this->harga   = '';
        $this->harga_currency   = '';
        $this->is_fotocopy   = '';
    }

    public function editId($kode_item)
    {
    $items = Item::findOrFail($kode_item);
    $this->selected_id = $kode_item;
    $this->kode_item   = $items->kode_item;
    $this->bibliografi_id    = $items->bibliografi_id;
    $this->call_number = $items->call_number;
    $this->kode_inventori = $items->kode_inventori;
    $this->rak_id      = $items->rak_id;
    $this->lokasi_id   = $items->lokasi_id;
    $this->tipe_koleksi_id = $items->tipe_koleksi_id;
    $this->status_id   = $items->status_id;
    $this->nmr_order   = $items->nmr_order;
    $this->tgl_order   = $items->tgl_order;
    $this->tgl_penerimaan = $items->tgl_penerimaan;
    $this->invoice     = $items->invoice;
    $this->supplier_id = $items->supplier_id;
    $this->source      = $items->source;
    $this->tgl_invoice = $items->tgl_invoice;
    $this->harga       = $items->harga;
    $this->harga_currency = $items->harga_currency;
    $this->is_fotocopy = $items->is_fotocopy;
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            Item::create([
                'kode_item'    => $this->kode_item,
                'call_number'          => $this->call_number,
                'kode_inventori'      => $this->kode_inventori,
                'bibliografi_id'      => $this->bibliografi_id,
                'rak_id'    => $this->rak_id,
                'status_id'    => $this->status_id,
                'lokasi_id'    => $this->lokasi_id,
                'tipe_koleksi_id'    => $this->tipe_koleksi_id,
                'nmr_order'    => $this->nmr_order,
                'tgl_order'    => $this->tgl_order,
                'tgl_penerimaan'    => $this->tgl_penerimaan,
                'invoice'    => $this->invoice,
                'supplier_id'    => $this->supplier_id,
                'source'    => $this->source,
                'tgl_invoice'    => $this->tgl_invoice,
                'harga'    => $this->harga,
                'harga_currency'    => $this->harga_currency,
                'is_fotocopy'    => $this->is_fotocopy,
            ]);

            $this->resetInput();
            session()->flash('success', 'Aturan Pemimjaman berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $items = Item::findOrFail($this->selected_id);
            $items->update([
                'kode_item'    => $this->kode_item,
                'call_number'          => $this->call_number,
                'kode_inventori'      => $this->kode_inventori,
                'status_id'      => $this->status_id,
                'rak_id'    => $this->rak_id,
                'bibliografi_id'      => $this->bibliografi_id,
                'lokasi_id'    => $this->lokasi_id,
                'tipe_koleksi_id'    => $this->tipe_koleksi_id,
                'nmr_order'    => $this->nmr_order,
                'tgl_order'    => $this->tgl_order,
                'tgl_penerimaan'    => $this->tgl_penerimaan,
                'invoice'    => $this->invoice,
                'supplier_id'    => $this->supplier_id,
                'source'    => $this->source,
                'tgl_invoice'    => $this->tgl_invoice,
                'harga'    => $this->harga,
                'harga_currency'    => $this->harga_currency,
                'is_fotocopy'    => $this->is_fotocopy,
            ]);

            $this->resetInput();
            session()->flash('success', 'Data Item berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function deleteId($kode_item)
    {
        $this->selected_id = $kode_item;
    }

    public function destroy()
    {
        try {
            Item::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Data Item berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $items = Item::with('bibliografi.penulis', 'bibliografi.penerbit', 'rak', 'tipeKoleksi', 'status', 'supplier', 'peminjaman', 'transaksiPemesanan')
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
        return view('livewire.katalog.daftar-item-component', compact('items'));
    }
}
