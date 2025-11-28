<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Bahasa as BahasaModel;
use Exception;

class Bahasa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_bahasa, $nama_bahasa, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_bahasa' => 'required|string|max:10|unique:bahasas,kode_bahasa,' . $this->selected_id,
            'nama_bahasa' => 'required|string|max:50',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->kode_bahasa = '';
        $this->nama_bahasa = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            BahasaModel::create([
                'kode_bahasa' => $this->kode_bahasa,
                'nama_bahasa' => $this->nama_bahasa,
            ]);
            $this->resetInput();
            session()->flash('success','Data bahasa berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $b = BahasaModel::findOrFail($id);
        $this->selected_id = $b->id;
        $this->kode_bahasa = $b->kode_bahasa;
        $this->nama_bahasa = $b->nama_bahasa;
    }

    public function update()
    {
        $this->validate();
        try {
            $b = BahasaModel::findOrFail($this->selected_id);
            $b->update([
                'kode_bahasa' => $this->kode_bahasa,
                'nama_bahasa' => $this->nama_bahasa,
            ]);
            $this->resetInput();
            session()->flash('success','Data bahasa berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            BahasaModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Data bahasa berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $bahasas = BahasaModel::where('kode_bahasa','like','%'.$this->search.'%')
            ->orWhere('nama_bahasa','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.bahasa', compact('bahasas'));
    }
}
