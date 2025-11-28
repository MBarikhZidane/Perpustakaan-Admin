<?php

namespace App\Livewire\Keanggotaan;

use Livewire\Component;
use App\Models\Anggota;
use App\Models\TipeAnggota;
use Exception;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class DaftarAnggotaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $member_id, $nama, $tipe_anggota_id, $kelas, $alamat, $telepon, $is_pending;
    public $selected_id;
    public $tipe_anggotas;

    #[Url(as: 'q')]
    public $search = '';

    protected function rules()
    {
        return [
            'member_id'       => 'required|string|max:50|unique:anggotas,member_id,' . $this->selected_id,
            'nama'            => 'required|string|max:100',
            'tipe_anggota_id' => 'required|exists:tipe_anggotas,id',
            'kelas'           => [
                'required',
                'regex:/^(X|XI|XII)\s[A-Z]{2,}\s[1-9]$/'
            ],
            'alamat'          => 'nullable|string',
            'telepon'         => 'nullable|string|max:20',
            'is_pending'      => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'kelas.regex' => 'Format kelas harus seperti: X TPM 1 atau XI RPL 2.',
        ];
    }


    public function mount()
    {
        $this->tipe_anggotas = TipeAnggota::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetInput()
    {
        $this->member_id       = '';
        $this->nama            = '';
        $this->tipe_anggota_id = '';
        $this->kelas           = '';
        $this->alamat          = '';
        $this->telepon         = '';
        $this->is_pending      = false;
        $this->selected_id     = null;
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate();
        try {
            Anggota::create([
                'member_id'       => $this->member_id,
                'nama'            => $this->nama,
                'tipe_anggota_id' => $this->tipe_anggota_id,
                'kelas'           => $this->kelas ?? null,
                'alamat'          => $this->alamat,
                'telepon'         => $this->telepon,
                'is_pending'      => $this->is_pending ? 1 : 0,
            ]);


            $this->resetInput();
            session()->flash('success', 'Data anggota berhasil ditambahkan.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function editId($id)
    {
        $anggota               = Anggota::findOrFail($id);
        $this->selected_id     = $anggota->id;
        $this->member_id       = $anggota->member_id;
        $this->nama            = $anggota->nama;
        $this->tipe_anggota_id = $anggota->tipe_anggota_id;
        $this->kelas = $anggota->kelas;
        $this->alamat          = $anggota->alamat;
        $this->telepon         = $anggota->telepon;
        $this->is_pending      = $anggota->is_pending;
    }

    public function update()
    {
        $this->validate();
        try {
            $anggota = Anggota::findOrFail($this->selected_id);
            $anggota->update([
                'member_id'       => $this->member_id,
                'nama'            => $this->nama,
                'tipe_anggota_id' => $this->tipe_anggota_id,
                'kelas'           => $this->kelas ?? null,
                'alamat'          => $this->alamat,
                'telepon'         => $this->telepon,
                'is_pending'      => $this->is_pending ? 1 : 0,
            ]);

            $this->resetInput();
            session()->flash('success', 'Data anggota berhasil diperbarui.');
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
            Anggota::findOrFail($this->selected_id)->delete();
            $this->resetInput();
            session()->flash('success', 'Data anggota berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $anggotas = Anggota::with('tipeAnggota')
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('member_id', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
        return view('livewire.keanggotaan.daftar-anggota-component', compact('anggotas'));
    }
}
