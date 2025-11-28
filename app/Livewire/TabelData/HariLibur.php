<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\HariLibur as HariLiburModel;
use Exception;

class HariLibur extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $tanggal, $keterangan, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->tanggal = '';
        $this->keterangan = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            HariLiburModel::create([
                'tanggal' => $this->tanggal,
                'keterangan' => $this->keterangan,
            ]);
            $this->resetInput();
            session()->flash('success','Hari libur berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $hl = HariLiburModel::findOrFail($id);
        $this->selected_id = $hl->id;
        $this->tanggal = $hl->tanggal;
        $this->keterangan = $hl->keterangan;
    }

    public function update()
    {
        $this->validate();
        try {
            $hl = HariLiburModel::findOrFail($this->selected_id);
            $hl->update([
                'tanggal' => $this->tanggal,
                'keterangan' => $this->keterangan,
            ]);
            $this->resetInput();
            session()->flash('success','Hari libur berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            HariLiburModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Hari libur berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $hariLiburs = HariLiburModel::where('tanggal','like','%'.$this->search.'%')
            ->orWhere('keterangan','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.hari-libur', compact('hariLiburs'));
    }
}
