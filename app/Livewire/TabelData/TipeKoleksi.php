<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\TipeKoleksi as TipeModel;
use Exception;

class TipeKoleksi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_tipe_koleksi, $kd_group_konter, $prefix, $urutan, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama_tipe_koleksi' => 'required|string|max:100',
            'kd_group_konter'   => 'required|string|max:20',
            'prefix'            => 'nullable|string|max:20',
            'urutan'            => 'nullable|numeric',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->nama_tipe_koleksi = '';
        $this->kd_group_konter   = '';
        $this->prefix            = '';
        $this->urutan            = 0;
        $this->selected_id       = null;
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            TipeModel::create([
                'nama_tipe_koleksi' => $this->nama_tipe_koleksi,
                'kd_group_konter'   => $this->kd_group_konter,
                'prefix'            => $this->prefix,
                'urutan'            => $this->urutan,
            ]);
            $this->resetInput();
            session()->flash('success', 'Tipe koleksi berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function editId($id)
    {
        $data = TipeModel::findOrFail($id);
        $this->selected_id       = $data->id;
        $this->nama_tipe_koleksi = $data->nama_tipe_koleksi;
        $this->kd_group_konter   = $data->kd_group_konter;
        $this->prefix            = $data->prefix;
        $this->urutan            = $data->urutan;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = TipeModel::findOrFail($this->selected_id);
            $data->update([
                'nama_tipe_koleksi' => $this->nama_tipe_koleksi,
                'kd_group_konter'   => $this->kd_group_konter,
                'prefix'            => $this->prefix,
                'urutan'            => $this->urutan,
            ]);
            $this->resetInput();
            session()->flash('success', 'Tipe koleksi berhasil diperbarui.');
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
            TipeModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Tipe koleksi berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tipe_koleksis = TipeModel::where('nama_tipe_koleksi', 'like', '%' . $this->search . '%')
            ->orWhere('kd_group_konter', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.tipe-koleksi', compact('tipe_koleksis'));
    }
}
