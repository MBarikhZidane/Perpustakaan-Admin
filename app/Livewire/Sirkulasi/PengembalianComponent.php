<?php

namespace App\Livewire\Sirkulasi;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Anggota;
use Livewire\Component;
use App\Models\Peminjaman;
use Livewire\WithPagination;
use App\Models\TransaksiDenda;
use App\Models\AturanPeminjaman;
use App\Models\TransaksiPemesanan;
use Illuminate\Support\Facades\DB;

class PengembalianComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $judul, $nama, $loan_date, $duedate, $denda, $is_return, $keterlambatan;
    public $selected_id;
    public $search;
    public $debet;
    public $cariitem;
    public $status;
    public $selectedItem;
    public $resultsitem = [];

    public function updatedCariitem()
    {
        if ($this->cariitem === "") {
            $this->resultsitem = [];
        } else {
            $this->resultsitem = Item::with('bibliografi', 'peminjaman')
    ->where('kode_item', 'like', '%' . $this->cariitem . '%')
    ->whereHas('peminjaman', function($q) {
        $q->where('is_return', 0);
    })
    ->get();

        }
    }
    public function selectItem($kode_item)
    {
    $this->selectedItem = Item::with('bibliografi')->where('kode_item', $kode_item)->first();
    $this->cariitem = $kode_item;
    $this->resultsitem = [];

    $peminjaman = Peminjaman::with('item', 'item.bibliografi', 'anggota')
    ->whereHas('item', function ($q) {
        $q->where('kode_item', $this->cariitem);
    })->first();

    if (!$peminjaman) {
    session()->flash('error', 'Peminjaman tidak ditemukan.');
    return;
 }

    $typemember = Anggota::with('tipeAnggota', 'tipeAnggota.aturanPeminjaman')
        ->where('member_id', $peminjaman->member_id)->first();

        if (!$typemember) {
    session()->flash('error', 'Member tidak ditemukan.');
    return;
}
    $aturan = AturanPeminjaman::where('member_type_id', $typemember->tipe_anggota_id)
        ->where('gmd_id', $this->selectedItem->bibliografi->gmd_id)
        ->first();
    $denda = 0;

    if (!$aturan) {
        $denda = 1000;
    } else {
        $denda = $aturan->fine_each_day;
    }

$dueDate  = Carbon::parse($peminjaman->duedate);
$now = Carbon::now();
$terlambat_hari = $dueDate->startOfDay()->diffInDays($now->startOfDay());

        $this->judul        = $peminjaman->item->bibliografi->judul;
        $this->nama            = $peminjaman->anggota->nama;
        $this->loan_date = $peminjaman->loan_date;
        $this->duedate          = $peminjaman->duedate;
        $this->denda         = $aturan ? $aturan->fine_each_day * $terlambat_hari : 1000 * $terlambat_hari;
        $this->keterlambatan         = $terlambat_hari;
    }

    public function update()
    {
        try {
            $peminjamans = Peminjaman::where('kode_item', $this->cariitem)->first();
            $peminjamans->update([
                'is_return'  =>  1,
                'return_date'  =>  now(),
            ]);

            if ($this->status === "Paid") {
                $kredit = $this->denda;
            } else {
                $kredit = 0;
            }

            TransaksiDenda::create([
                'member_id'=> $peminjamans->member_id,
                'debet' => $this->denda,
                'kredit' => $kredit,
                'tanggal' => now(),
                'status' => $this->status
            ]);
            $this->selectedItem = null;
            $this->cariitem = '';
            session()->flash('success', 'Data Aturan Peminjaman berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function batal()
    {
                    $this->selectedItem = null;
            $this->cariitem = '';
    }

    public function render()
    {

    return view('livewire.sirkulasi.pengembalian-component');
    }
}
