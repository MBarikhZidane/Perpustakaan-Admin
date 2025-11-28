<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Penulis as PenulisModel;
use Exception;

class Penulis extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama, $tahun, $tipe, $selected_id;
    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:100',
            'tahun' => 'nullable|integer|min:0',
            'tipe' => 'nullable|in:Personal Name,Organization Body,Conference',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->nama = '';
        $this->tahun = null;
        $this->tipe = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            PenulisModel::create([
                'nama' => $this->nama,
                'tahun' => $this->tahun,
                'tipe' => $this->tipe,
            ]);
            $this->resetInput();
            session()->flash('success', 'Penulis berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $data = PenulisModel::findOrFail($id);
        $this->selected_id = $data->id;
        $this->nama = $data->nama;
        $this->tahun = $data->tahun;
        $this->tipe = $data->tipe;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = PenulisModel::findOrFail($this->selected_id);
            $data->update([
                'nama' => $this->nama,
                'tahun' => $this->tahun,
                'tipe' => $this->tipe,
            ]);
            $this->resetInput();
            session()->flash('success', 'Penulis berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            PenulisModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Penulis berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $penulis = PenulisModel::where('nama','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.penulis', compact('penulis'));
    }
}
