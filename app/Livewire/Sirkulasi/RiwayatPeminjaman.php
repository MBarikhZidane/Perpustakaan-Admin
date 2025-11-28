<?php

namespace App\Livewire\Sirkulasi;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Peminjaman;
use Livewire\WithPagination;

class RiwayatPeminjaman extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

     #[Url(as: 'q')]
    public $search = '';
    public $start_date;
    public $end_date;
    public $is_return = 'all';


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $peminjamans = Peminjaman::with('anggota', 'item')
            ->when($this->search, fn($q) =>
                $q->whereHas('anggota', fn($q2) =>
                    $q2->where('nama', 'like', '%' . $this->search . '%')
                )
            )
            ->when($this->is_return !== 'all', fn($q) =>
                $q->where('is_return', $this->is_return)
            )
            ->when($this->start_date && $this->end_date, fn($q) =>
                $q->whereBetween('loan_date', [
                    Carbon::parse($this->start_date)->startOfDay(),
                    Carbon::parse($this->end_date)->endOfDay()
                ])
            )
            ->latest()
            ->paginate(10);

        return view('livewire.sirkulasi.riwayat-peminjaman', compact('peminjamans'));
    }
}
