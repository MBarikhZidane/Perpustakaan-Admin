<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Gmd;
use Exception;

class JenisItem extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_gmd, $nama_gmd, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_gmd' => 'required|string|max:20|unique:gmds,kode_gmd,' . $this->selected_id,
            'nama_gmd' => 'required|string|max:50',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->kode_gmd = '';
        $this->nama_gmd = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            Gmd::create([
                'kode_gmd' => $this->kode_gmd,
                'nama_gmd' => $this->nama_gmd,
            ]);
            $this->resetInput();
            session()->flash('success','Data GMD berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $g = Gmd::findOrFail($id);
        $this->selected_id = $g->id;
        $this->kode_gmd = $g->kode_gmd;
        $this->nama_gmd = $g->nama_gmd;
    }

    public function update()
    {
        $this->validate();
        try {
            $g = Gmd::findOrFail($this->selected_id);
            $g->update([
                'kode_gmd' => $this->kode_gmd,
                'nama_gmd' => $this->nama_gmd,
            ]);
            $this->resetInput();
            session()->flash('success','Data GMD berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            Gmd::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Data GMD berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $gmds = Gmd::where('kode_gmd','like','%'.$this->search.'%')
            ->orWhere('nama_gmd','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.jenis-item', compact('gmds'));
    }
}
