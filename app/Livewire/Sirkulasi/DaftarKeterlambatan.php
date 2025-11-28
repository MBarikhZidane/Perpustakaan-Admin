<?php

namespace App\Livewire\Sirkulasi;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Peminjaman;
use Livewire\WithPagination;
use App\Models\TransaksiPemesanan;
use Illuminate\Support\Facades\DB;

class DaftarKeterlambatan extends Component
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
    $peminjamans = Peminjaman::with('item', 'item.bibliografi')
        ->when($this->search, fn($q) =>
            $q->whereHas('bibliografi', fn($q2) =>
                $q2->where('judul', 'like', '%' . $this->search . '%')
            )
        )
        ->when($this->start_date && $this->end_date, fn($q) =>
            $q->whereBetween('loan_date', [
                Carbon::parse($this->start_date)->startOfDay(),
                Carbon::parse($this->end_date)->endOfDay()
            ])
        )
        ->select('*', DB::raw('GREATEST(DATEDIFF(CURDATE(), duedate), 0) as terlambat_hari'))
        ->latest()
        ->paginate(10);

    return view('livewire.sirkulasi.daftar-keterlambatan', compact('peminjamans'));
    }

}
