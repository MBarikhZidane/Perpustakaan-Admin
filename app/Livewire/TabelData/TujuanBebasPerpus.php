<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\TujuanBebasPerpustakaan as TujuanModel;
use Exception;

class TujuanBebasPerpus extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_tujuan, $nama_tujuan, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_tujuan' => 'required|string|max:20|unique:tujuan_bebas_perpustakaans,kode_tujuan,' . $this->selected_id,
            'nama_tujuan' => 'required|string|max:100',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->kode_tujuan = '';
        $this->nama_tujuan = '';
        $this->selected_id = null;
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            TujuanModel::create([
                'kode_tujuan' => $this->kode_tujuan,
                'nama_tujuan' => $this->nama_tujuan,
                'idz' => uniqid('TJN-'),
            ]);
            $this->resetInput();
            session()->flash('success', 'Tujuan berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function editId($id)
    {
        $data = TujuanModel::findOrFail($id);
        $this->selected_id = $data->id;
        $this->kode_tujuan = $data->kode_tujuan;
        $this->nama_tujuan = $data->nama_tujuan;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = TujuanModel::findOrFail($this->selected_id);
            $data->update([
                'kode_tujuan' => $this->kode_tujuan,
                'nama_tujuan' => $this->nama_tujuan,
            ]);
            $this->resetInput();
            session()->flash('success', 'Tujuan berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteId($id)
    {
        $this->selected_id = $id;
    }

    public function destroy()
    {
        try {
            TujuanModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Tujuan berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tujuans = TujuanModel::where('kode_tujuan', 'like', '%' . $this->search . '%')
            ->orWhere('nama_tujuan', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.tujuan-bebas-perpus', compact('tujuans'));
    }
}
