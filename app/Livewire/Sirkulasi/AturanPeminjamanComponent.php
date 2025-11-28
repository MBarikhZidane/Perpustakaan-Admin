<?php

namespace App\Livewire\Sirkulasi;

use Exception;
use App\Models\Gmd;
use App\Models\Anggota;
use Livewire\Component;
use App\Models\TipeAnggota;
use App\Models\TipeKoleksi;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\AturanPeminjaman;

class AturanPeminjamanComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $member_type_id, $coll_type_id, $gmd_id, $loan_limit, $loan_periode, $reborrow_limit, $fine_each_day, $grace_periode;
    public $selected_id;
    public $tipe_members;
    public $tipe_colls;
    public $tipe_gmd;


     #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'member_type_id' => 'required|exists:tipe_anggotas,id',
            'coll_type_id' => 'required|exists:tipe_koleksis,id',
            'gmd_id' => 'required|exists:gmds,id',
            'loan_limit'      => 'required|numeric',
            'loan_periode'      => 'required|numeric',
            'reborrow_limit'      => 'required|numeric',
            'fine_each_day'      => 'required|numeric',
            'grace_periode'      => 'required|numeric',
        ];
    }

    public function mount()
    {
        $this->tipe_members = TipeAnggota::all();
        $this->tipe_colls = TipeKoleksi::all();
        $this->tipe_gmd = Gmd::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->member_type_id  = '';
        $this->coll_type_id    = '';
        $this->gmd_id = '';
        $this->loan_limit      = '';
        $this->loan_periode    = '';
        $this->reborrow_limit  = '';
        $this->fine_each_day   = '';
        $this->grace_periode   = '';
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            AturanPeminjaman::create([
                'member_type_id'  => $this->member_type_id,
                'coll_type_id'    => $this->coll_type_id,
                'gmd_id'          => $this->gmd_id,
                'loan_limit'      => $this->loan_limit,
                'loan_periode'    => $this->loan_periode,
                'reborrow_limit'    => $this->reborrow_limit,
                'fine_each_day'    => $this->fine_each_day,
                'grace_periode'    => $this->grace_periode,
            ]);

            $this->resetInput();
            session()->flash('success', 'Aturan Pemimjaman berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editId($id)
    {
        $aturans               = AturanPeminjaman::findOrFail($id);
        $this->selected_id     = $aturans->id;
        $this->member_type_id       = $aturans->member_type_id;
        $this->coll_type_id            = $aturans->coll_type_id;
        $this->gmd_id = $aturans->gmd_id;
        $this->loan_limit          = $aturans->loan_limit;
        $this->loan_periode         = $aturans->loan_periode;
        $this->reborrow_limit      = $aturans->reborrow_limit;
        $this->fine_each_day      = $aturans->fine_each_day;
        $this->grace_periode      = $aturans->grace_periode;
    }

    public function update()
    {
        $this->validate();
        try {
            $aturans = AturanPeminjaman::findOrFail($this->selected_id);
            $aturans->update([
                'member_type_id'  => $this->member_type_id,
                'coll_type_id'    => $this->coll_type_id,
                'gmd_id'          => $this->gmd_id,
                'loan_limit'      => $this->loan_limit,
                'loan_periode'    => $this->loan_periode,
                'reborrow_limit'    => $this->reborrow_limit,
                'fine_each_day'    => $this->fine_each_day,
                'grace_periode'    => $this->grace_periode,
            ]);

            $this->resetInput();
            session()->flash('success', 'Data Aturan Peminjaman berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteId($id)
    {
        $this->selected_id = $id;
    }

    public function destroy()
    {
        try {
            AturanPeminjaman::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Data Aturan Peminjaman berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $aturans = AturanPeminjaman::with('memberType', 'collType', 'gmd')
            ->where(function ($query) {
                $query->orWhereHas('memberType', function ($q) {
                      $q->where('nama_tipe', 'like', '%' . $this->search . '%');
                  })->orWhereHas('gmd', function ($q) {
                      $q->where('nama_gmd', 'like', '%' . $this->search . '%');
                  })->orWhereHas('collType', function ($q) {
                      $q->where('nama_tipe_koleksi', 'like', '%' . $this->search . '%');
                  });
            })
            ->latest()
            ->paginate(10);
        return view('livewire.sirkulasi.aturan-peminjaman-component', compact('aturans'));
    }
}
