<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Lokasi as LokasiModel;
use Exception;

class Lokasi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_lokasi, $nama_lokasi, $is_sgd = false, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_lokasi' => 'required|string|max:20|unique:lokasis,kode_lokasi,' . $this->selected_id,
            'nama_lokasi' => 'required|string|max:50',
            'is_sgd' => 'boolean',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->kode_lokasi = '';
        $this->nama_lokasi = '';
        $this->is_sgd = false;
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            LokasiModel::create([
                'kode_lokasi' => $this->kode_lokasi,
                'nama_lokasi' => $this->nama_lokasi,
                'is_sgd' => $this->is_sgd ? 1 : 0,
            ]);
            $this->resetInput();
            session()->flash('success','Data lokasi berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $lokasi = LokasiModel::findOrFail($id);
        $this->selected_id = $lokasi->id;
        $this->kode_lokasi = $lokasi->kode_lokasi;
        $this->nama_lokasi = $lokasi->nama_lokasi;
        $this->is_sgd = $lokasi->is_sgd;
    }

    public function update()
    {
        $this->validate();
        try {
            $lokasi = LokasiModel::findOrFail($this->selected_id);
            $lokasi->update([
                'kode_lokasi' => $this->kode_lokasi,
                'nama_lokasi' => $this->nama_lokasi,
                'is_sgd' => $this->is_sgd ? 1 : 0,
            ]);
            $this->resetInput();
            session()->flash('success','Data lokasi berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            LokasiModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Data lokasi berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $lokasis = LokasiModel::where('kode_lokasi','like','%'.$this->search.'%')
            ->orWhere('nama_lokasi','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.lokasi', compact('lokasis'));
    }
}
