<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Penerbit as PenerbitModel;
use App\Models\TempatPenerbit;
use Exception;

class Penerbit extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_penerbit, $tempat_id, $selected_id;
    public $tempat_penerbits = [];

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama_penerbit' => 'required|string|max:100',
            'tempat_id'     => 'nullable|exists:tempat_penerbits,id',
        ];
    }

    public function mount()
    {
        $this->tempat_penerbits = TempatPenerbit::all();
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->nama_penerbit = '';
        $this->tempat_id = null;
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            PenerbitModel::create([
                'nama_penerbit' => $this->nama_penerbit,
                'tempat_id'     => $this->tempat_id,
            ]);
            $this->resetInput();
            session()->flash('success','Data penerbit berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $penerbit = PenerbitModel::findOrFail($id);
        $this->selected_id = $penerbit->id;
        $this->nama_penerbit = $penerbit->nama_penerbit;
        $this->tempat_id = $penerbit->tempat_id;
    }

    public function update()
    {
        $this->validate();
        try {
            $penerbit = PenerbitModel::findOrFail($this->selected_id);
            $penerbit->update([
                'nama_penerbit' => $this->nama_penerbit,
                'tempat_id'     => $this->tempat_id,
            ]);
            $this->resetInput();
            session()->flash('success','Data penerbit berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            PenerbitModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Data penerbit berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $penerbits = PenerbitModel::with('tempat')
            ->where('nama_penerbit','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.penerbit', compact('penerbits'));
    }
}
