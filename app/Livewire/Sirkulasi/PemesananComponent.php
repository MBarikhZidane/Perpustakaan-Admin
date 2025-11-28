<?php

namespace App\Livewire\Sirkulasi;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Peminjaman;
use Livewire\WithPagination;
use App\Models\TransaksiPemesanan;

class PemesananComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

     #[Url(as: 'q')]
    public $search = '';
    public $start_date;
    public $end_date;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
$pemesanans = TransaksiPemesanan::with('anggota', 'bibliografi')
    ->when($this->search, function ($q) {
        $q->whereHas('anggota', fn($q2) =>
            $q2->where('nama', 'like', '%' . $this->search . '%')
        )->orWhereHas('bibliografi', fn($q2) =>
            $q2->where('judul', 'like', '%' . $this->search . '%')
        );
    })
    ->when($this->start_date && $this->end_date, fn($q) =>
        $q->whereBetween('reserve_date', [
            Carbon::parse($this->start_date)->startOfDay(),
            Carbon::parse($this->end_date)->endOfDay()
        ])
    )
    ->latest()
    ->paginate(10);

        return view('livewire.sirkulasi.pemesanan-component', compact('pemesanans'));
    }
}
