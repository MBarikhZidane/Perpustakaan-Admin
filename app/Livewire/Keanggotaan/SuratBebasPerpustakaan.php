<?php

namespace App\Livewire\Keanggotaan;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\SuratBebasPerpustakaan as SBP;
use App\Models\Anggota;
use App\Models\TujuanBebasPerpustakaan;
use Exception;

class SuratBebasPerpustakaan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nomor_surat, $tanggal, $member_id, $tujuan_id;
    public $selected_id;

    public $anggotas = [];
    public $tujuans = [];

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nomor_surat' => 'required|string|max:50|unique:surat_bebas_perpustakaans,nomor_surat,' . $this->selected_id,
            'tanggal'     => 'required|date',
            'member_id'   => 'required|exists:anggotas,member_id',
            'tujuan_id'   => 'nullable|exists:tujuan_bebas_perpustakaans,id',
        ];
    }

    public function mount()
    {
        $this->anggotas = Anggota::all();
        $this->tujuans  = TujuanBebasPerpustakaan::all();
    }

    public function updatingSearch() { $this->resetPage(); }

    private function resetInput()
    {
        $this->nomor_surat = '';
        $this->tanggal     = '';
        $this->member_id   = '';
        $this->tujuan_id   = '';
        $this->selected_id = null;
    }

    public function create() { $this->resetInput(); }

    public function store()
    {
        $this->validate();
        try {
            SBP::create([
                'nomor_surat' => $this->nomor_surat,
                'tanggal'     => $this->tanggal,
                'member_id'   => $this->member_id,
                'tujuan_id'   => $this->tujuan_id,
            ]);
            $this->resetInput();
            session()->flash('success','Surat berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function editId($id)
    {
        $s = SBP::findOrFail($id);
        $this->selected_id = $s->id;
        $this->nomor_surat = $s->nomor_surat;
        $this->tanggal     = $s->tanggal;
        $this->member_id   = $s->member_id;
        $this->tujuan_id   = $s->tujuan_id;
    }

    public function update()
    {
        $this->validate();
        try {
            $s = SBP::findOrFail($this->selected_id);
            $s->update([
                'nomor_surat' => $this->nomor_surat,
                'tanggal'     => $this->tanggal,
                'member_id'   => $this->member_id,
                'tujuan_id'   => $this->tujuan_id,
            ]);
            $this->resetInput();
            session()->flash('success','Surat berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function deleteId($id) { $this->selected_id = $id; }

    public function destroy()
    {
        try {
            SBP::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success','Surat berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error','Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        $surats = SBP::with(['anggota','tujuan'])
            ->where(function($q){
                $q->where('nomor_surat','like','%'.$this->search.'%')
                  ->orWhereHas('anggota', function($sub){
                      $sub->where('nama','like','%'.$this->search.'%');
                  });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.keanggotaan.surat-bebas-perpustakaan', compact('surats'));
    }
}
