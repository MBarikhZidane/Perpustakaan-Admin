<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Supplier as SupplierModel;
use Exception;

class Supplier extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_supplier, $alamat, $kodepos, $telepon, $kontak, $fax, $account, $email;
    public $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama_supplier' => 'required|string|max:150',
            'alamat' => 'nullable|string',
            'kodepos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'kontak' => 'nullable|string|max:100',
            'fax' => 'nullable|string|max:20',
            'account' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->nama_supplier = $this->alamat = $this->kodepos = $this->telepon = $this->kontak = $this->fax = $this->account = $this->email = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            SupplierModel::create([
                'nama_supplier' => $this->nama_supplier,
                'alamat' => $this->alamat,
                'kodepos' => $this->kodepos,
                'telepon' => $this->telepon,
                'kontak' => $this->kontak,
                'fax' => $this->fax,
                'account' => $this->account,
                'email' => $this->email,
            ]);
            $this->resetInput();
            session()->flash('success', 'Supplier berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $this->selected_id = $supplier->id;
        $this->nama_supplier = $supplier->nama_supplier;
        $this->alamat = $supplier->alamat;
        $this->kodepos = $supplier->kodepos;
        $this->telepon = $supplier->telepon;
        $this->kontak = $supplier->kontak;
        $this->fax = $supplier->fax;
        $this->account = $supplier->account;
        $this->email = $supplier->email;
    }

    public function update()
    {
        $this->validate();
        try {
            $supplier = SupplierModel::findOrFail($this->selected_id);
            $supplier->update([
                'nama_supplier' => $this->nama_supplier,
                'alamat' => $this->alamat,
                'kodepos' => $this->kodepos,
                'telepon' => $this->telepon,
                'kontak' => $this->kontak,
                'fax' => $this->fax,
                'account' => $this->account,
                'email' => $this->email,
            ]);
            $this->resetInput();
            session()->flash('success','Supplier berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            SupplierModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Supplier berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function render()
    {
        $suppliers = SupplierModel::where('nama_supplier','like','%'.$this->search.'%')
            ->orWhere('alamat','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.supplier', compact('suppliers'));
    }
}
