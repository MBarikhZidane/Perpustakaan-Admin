<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\KonfigurasiPenomoran as KonfigurasiModel;
use Exception;

class KonfigurasiComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_group, $nama_group, $konter, $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'kode_group' => 'required|string|max:20|unique:konfigurasi_penomorans,kode_group,' . $this->selected_id . ',id',
            'nama_group' => 'required|string|max:100',
            'konter'     => 'required|integer|min:0',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->kode_group = '';
        $this->nama_group = '';
        $this->konter = 0;
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
            KonfigurasiModel::create([
                'kode_group' => $this->kode_group,
                'nama_group' => $this->nama_group,
                'konter'     => $this->konter,
                'idz'        => uniqid('KONF-'),
            ]);
            $this->resetInput();
            session()->flash('success', 'Data berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function editId($id)
    {
        $data = KonfigurasiModel::findOrFail($id);
        $this->selected_id = $data->id;
        $this->kode_group = $data->kode_group;
        $this->nama_group = $data->nama_group;
        $this->konter = $data->konter;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = KonfigurasiModel::findOrFail($this->selected_id);
            $data->update([
                'kode_group' => $this->kode_group,
                'nama_group' => $this->nama_group,
                'konter'     => $this->konter,
            ]);
            $this->resetInput();
            session()->flash('success', 'Data berhasil diperbarui.');
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
            KonfigurasiModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Data berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $penomorans = KonfigurasiModel::where('kode_group', 'like', '%' . $this->search . '%')
            ->orWhere('nama_group', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.konfigurasi-component', compact('penomorans'));
    }
}
