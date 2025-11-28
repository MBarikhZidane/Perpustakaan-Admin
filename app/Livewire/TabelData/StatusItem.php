<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\StatusItem as StatusItemModel;
use Exception;

class StatusItem extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_status, $nama_status, $aturan, $is_not_dipinjamkan = false, $is_skip_stockopname = false;
    public $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_status' => 'required|string|max:20|unique:status_items,kode_status,' . $this->selected_id,
            'nama_status' => 'required|string|max:50',
            'aturan' => 'nullable|string',
            'is_not_dipinjamkan' => 'boolean',
            'is_skip_stockopname' => 'boolean',
        ];
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->kode_status = '';
        $this->nama_status = '';
        $this->aturan = '';
        $this->is_not_dipinjamkan = false;
        $this->is_skip_stockopname = false;
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            StatusItemModel::create([
                'kode_status' => $this->kode_status,
                'nama_status' => $this->nama_status,
                'aturan' => $this->aturan,
                'is_not_dipinjamkan' => $this->is_not_dipinjamkan ? 1 : 0,
                'is_skip_stockopname' => $this->is_skip_stockopname ? 1 : 0,
            ]);
            $this->resetInput();
            session()->flash('success', 'Status berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $status = StatusItemModel::findOrFail($id);
        $this->selected_id = $status->id;
        $this->kode_status = $status->kode_status;
        $this->nama_status = $status->nama_status;
        $this->aturan = $status->aturan;
        $this->is_not_dipinjamkan = $status->is_not_dipinjamkan;
        $this->is_skip_stockopname = $status->is_skip_stockopname;
    }

    public function update()
    {
        $this->validate();
        try {
            $status = StatusItemModel::findOrFail($this->selected_id);
            $status->update([
                'kode_status' => $this->kode_status,
                'nama_status' => $this->nama_status,
                'aturan' => $this->aturan,
                'is_not_dipinjamkan' => $this->is_not_dipinjamkan ? 1 : 0,
                'is_skip_stockopname' => $this->is_skip_stockopname ? 1 : 0,
            ]);
            $this->resetInput();
            session()->flash('success', 'Status berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            StatusItemModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Status berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Error: '.$e->getMessage());
        }
    }

    public function render()
    {
        $statuses = StatusItemModel::where('nama_status','like','%'.$this->search.'%')
            ->orWhere('kode_status','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.status-item', compact('statuses'));
    }
}
