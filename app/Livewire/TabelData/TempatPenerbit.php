<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\TempatPenerbit as TempatModel;
use Exception;

class TempatPenerbit extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_tempat, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama_tempat' => 'required|string|max:100',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->nama_tempat = '';
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
            TempatModel::create(['nama_tempat' => $this->nama_tempat]);
            $this->resetInput();
            session()->flash('success', 'Tempat berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function editId($id)
    {
        $data = TempatModel::findOrFail($id);
        $this->selected_id = $data->id;
        $this->nama_tempat = $data->nama_tempat;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = TempatModel::findOrFail($this->selected_id);
            $data->update(['nama_tempat' => $this->nama_tempat]);
            $this->resetInput();
            session()->flash('success', 'Tempat berhasil diperbarui.');
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
            TempatModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Tempat berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tempat_penerbits = TempatModel::where('nama_tempat', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.tempat-penerbit', compact('tempat_penerbits'));
    }
}
