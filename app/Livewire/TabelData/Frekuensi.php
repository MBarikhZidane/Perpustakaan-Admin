<?php

namespace App\Livewire\TabelData;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Frekuensi as FrekuensiModel;
use App\Models\Bahasa;
use Exception;

class Frekuensi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $frekuensi, $language_prefix, $time_increment, $time_unit, $selected_id;
    public $bahasas = [];

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'frekuensi' => 'nullable|string|max:50',
            'language_prefix' => 'nullable|exists:bahasas,kode_bahasa',
            'time_increment' => 'required|integer|min:0',
            'time_unit' => 'nullable|string|max:20',
        ];
    }

    public function mount()
    {
        $this->bahasas = Bahasa::all();
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->frekuensi = '';
        $this->language_prefix = '';
        $this->time_increment = 0;
        $this->time_unit = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            FrekuensiModel::create([
                'frekuensi' => $this->frekuensi,
                'language_prefix' => $this->language_prefix,
                'time_increment' => $this->time_increment,
                'time_unit' => $this->time_unit,
            ]);
            $this->resetInput();
            session()->flash('success','Data frekuensi berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $f = FrekuensiModel::findOrFail($id);
        $this->selected_id = $f->id;
        $this->frekuensi = $f->frekuensi;
        $this->language_prefix = $f->language_prefix;
        $this->time_increment = $f->time_increment;
        $this->time_unit = $f->time_unit;
    }

    public function update()
    {
        $this->validate();
        try {
            $f = FrekuensiModel::findOrFail($this->selected_id);
            $f->update([
                'frekuensi' => $this->frekuensi,
                'language_prefix' => $this->language_prefix,
                'time_increment' => $this->time_increment,
                'time_unit' => $this->time_unit,
            ]);
            $this->resetInput();
            session()->flash('success','Data frekuensi berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            FrekuensiModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Data frekuensi berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $frekuensis = FrekuensiModel::with('bahasa')
            ->where('frekuensi','like','%'.$this->search.'%')
            ->orWhere('time_unit','like','%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.tabel-data.frekuensi', compact('frekuensis'));
    }
}
