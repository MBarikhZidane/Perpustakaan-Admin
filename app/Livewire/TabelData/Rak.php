<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Rak as RakModel;
use App\Models\Lokasi;
use Exception;

class Rak extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $idz, $kode_rak, $nama_rak, $lokasi_id, $selected_id;
    public $lokasis = [];

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_rak' => 'required|string|max:20|unique:raks,kode_rak,' . $this->selected_id,
            'nama_rak' => 'required|string|max:50',
            'lokasi_id' => 'required|exists:lokasis,kode_lokasi',
        ];
    }

    public function mount()
    {
        $this->lokasis = Lokasi::all();
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->idz = '';
        $this->kode_rak = '';
        $this->nama_rak = '';
        $this->lokasi_id = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            RakModel::create([
                'idz' => uniqid('RAK-'),
                'kode_rak' => $this->kode_rak,
                'nama_rak' => $this->nama_rak,
                'lokasi_id' => $this->lokasi_id,
            ]);
            $this->resetInput();
            session()->flash('success', 'Rak berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $rak = RakModel::findOrFail($id);
        $this->selected_id = $rak->id;
        $this->idz = $rak->idz;
        $this->kode_rak = $rak->kode_rak;
        $this->nama_rak = $rak->nama_rak;
        $this->lokasi_id = $rak->lokasi_id;
    }

    public function update()
    {
        $this->validate();
        try {
            $rak = RakModel::findOrFail($this->selected_id);
            $rak->update([
                'kode_rak' => $this->kode_rak,
                'nama_rak' => $this->nama_rak,
                'lokasi_id' => $this->lokasi_id,
            ]);
            $this->resetInput();
            session()->flash('success', 'Rak berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            RakModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Rak berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function render()
    {
        $raks = RakModel::with('lokasi')
            ->where('nama_rak','like','%'.$this->search.'%')
            ->orWhere('kode_rak','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.rak', compact('raks'));
    }
}
