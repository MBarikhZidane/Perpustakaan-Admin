<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Topik as TopikModel;
use Exception;

class Topik extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_topik, $tipe_topik, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama_topik' => 'required|string|max:255',
            'tipe_topik' => 'required|in:Topic,Geographic,Name,Temporal,Genre,Occupation',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->nama_topik = '';
        $this->tipe_topik = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            TopikModel::create([
                'nama_topik' => $this->nama_topik,
                'tipe_topik' => $this->tipe_topik,
            ]);
            $this->resetInput();
            session()->flash('success','Topik berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $data = TopikModel::findOrFail($id);
        $this->selected_id = $data->id;
        $this->nama_topik  = $data->nama_topik;
        $this->tipe_topik  = $data->tipe_topik;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = TopikModel::findOrFail($this->selected_id);
            $data->update([
                'nama_topik' => $this->nama_topik,
                'tipe_topik' => $this->tipe_topik,
            ]);
            $this->resetInput();
            session()->flash('success','Topik berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            TopikModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Topik berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function render()
    {
        $topiks = TopikModel::where('nama_topik','like','%'.$this->search.'%')
            ->orWhere('tipe_topik','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.topik', compact('topiks'));
    }
}
