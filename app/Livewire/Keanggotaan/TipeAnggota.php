<?php

namespace App\Livewire\Keanggotaan;

use App\Livewire\Forms\TipeAnggotaForm;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipeAnggota as TipeAnggotaModel;
use Exception;
use Livewire\Attributes\Url;

class TipeAnggota extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_tipe, $is_siswa, $is_guru, $is_karyawan, $is_external;
    public $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'nama_tipe'   => 'required|string|max:50|unique:tipe_anggotas,nama_tipe,' . $this->selected_id,
            'is_siswa'    => 'nullable|boolean',
            'is_guru'     => 'nullable|boolean',
            'is_karyawan' => 'nullable|boolean',
            'is_external' => 'nullable|boolean',
        ];
    }

    private function resetInput()
    {
        $this->nama_tipe   = '';
        $this->is_siswa    = false;
        $this->is_guru     = false;
        $this->is_karyawan = false;
        $this->is_external = false;
        $this->selected_id = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            TipeAnggotaModel::create([
                'nama_tipe'   => $this->nama_tipe,
                'is_siswa'    => $this->is_siswa ? 1 : 0,
                'is_guru'     => $this->is_guru ? 1 : 0,
                'is_karyawan' => $this->is_karyawan ? 1 : 0,
                'is_external' => $this->is_external ? 1 : 0,
                'limit_peminjaman' => 0,
                'periode_peminjaman' => 0,
                'is_boleh_pesan' => 0,
                'limit_pemesanan' => 0,
                'periode_member' => 0,
                'limit_pinjam_ulang' => 0,
                'denda_per_hari' => 0,
                'masa_tenggang' => 0,
            ]);
            $this->resetInput();
            session()->flash('success', 'Tipe anggota berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function editId($id)
    {
        $tipe = TipeAnggotaModel::findOrFail($id);
        $this->selected_id = $tipe->id;
        $this->nama_tipe   = $tipe->nama_tipe;
        $this->is_siswa    = $tipe->is_siswa;
        $this->is_guru     = $tipe->is_guru;
        $this->is_karyawan = $tipe->is_karyawan;
        $this->is_external = $tipe->is_external;
    }

    public function update()
    {
        $this->validate();
        try {
            $tipe = TipeAnggotaModel::findOrFail($this->selected_id);
            $tipe->update([
                'nama_tipe'   => $this->nama_tipe,
                'is_siswa'    => $this->is_siswa ? 1 : 0,
                'is_guru'     => $this->is_guru ? 1 : 0,
                'is_karyawan' => $this->is_karyawan ? 1 : 0,
                'is_external' => $this->is_external ? 1 : 0,
            ]);
            $this->resetInput();
            session()->flash('success', 'Tipe anggota berhasil diperbarui.');
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
            TipeAnggotaModel::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Tipe anggota berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tipes = TipeAnggotaModel::where('nama_tipe', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.keanggotaan.tipe-anggota', compact('tipes'));
    }
}
