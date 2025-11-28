<?php

namespace App\Livewire\Sirkulasi;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Anggota;
use Livewire\Component;
use App\Models\Peminjaman;
use App\Models\Bibliografi;
use App\Models\TransaksiDenda;
use App\Models\AturanPeminjaman;
use App\Models\TransaksiPemesanan;
use Illuminate\Support\Facades\DB;

class TransaksiComponent extends Component
{
    public $tanggal, $keterangan, $debet, $kredit, $member_id, $loan_date;
    public $carimember;
    public $selected_member;
    public $caririwayat;
    public $cariitem;
    public $resultsmember = [];
    public $resultsitem = [];
    public $itempeminjaman = [];
    public $item;
    public $selectedItem;
    public $daftarbibliografis;
    public $selecteddenda_id;
    public $selectedkembali_id;
    public $selectedpemesanan;
    public $selectedperpanjangan_id;
    public $bibliografi_id;
    public $member_idselected;
    public $activeTab = 'pills-penomoran';

    // Initialize component
    public function mount()
    {
        $this->daftarbibliografis = Bibliografi::all();
    }

    // Handle member search
    public function updatedCarimember()
    {
        if ($this->carimember === "") {
            $this->resultsmember = [];
        } else {
            $this->resultsmember = Anggota::when($this->carimember, function ($q) {
                $q->where('nama', 'like', '%' . $this->carimember . '%')
                  ->orWhere('member_id', 'like', '%' . $this->carimember . '%');
            })->get();
        }
    }

    // Placeholder for creating denda
    public function createDenda()
    {
    }

    // Store new denda transaction
    public function storecreate()
    {
        $statusValue = $this->debet - $this->kredit;
        $status = $statusValue >= 0 ? "Unpaid" : "Paid";

        try {
            TransaksiDenda::create([
                'tanggal' => $this->tanggal,
                'keterangan' => $this->keterangan,
                'debet' => $this->debet,
                'kredit' => $this->kredit,
                'member_id' => $this->member_idselected,
                'status' => $status,
            ]);

            session()->flash('success', "Transaksi Denda dengan status {$status} berhasil ditambahkan.");
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Handle item search
    public function updatedCariitem()
    {
        if ($this->cariitem === "") {
            $this->resultsitem = [];
        } else {
            $this->resultsitem = Item::with('bibliografi')
                ->where('kode_item', 'like', '%' . $this->cariitem . '%')
                ->whereDoesntHave('peminjaman', function ($q) {
                    $q->where('is_return', 0);
                })
                ->get();
        }
    }
    public function selectItem($kode_item)
{
    $this->selectedItem = Item::where('kode_item', $kode_item)->first();
    $this->cariitem = $kode_item;
    $this->resultsitem = [];
}

public function storePeminjaman()
{
    $itemData = Item::with('bibliografi')
        ->where('kode_item', $this->selectedItem->kode_item)
        ->first();

    if (!$itemData || !$itemData->bibliografi) {
        session()->flash('error', 'Item tidak ditemukan atau bibliografi kosong.');
        return;
    }

    $typemember = Anggota::with('tipeAnggota', 'tipeAnggota.aturanPeminjaman')
        ->findOrFail($this->selected_member);

    $aturan = AturanPeminjaman::where('member_type_id', $typemember->tipe_anggota_id)
        ->where('gmd_id', $itemData->bibliografi->gmd_id)
        ->first();

    if (!$aturan) {
        // session()->flash('error', 'Aturan peminjaman tidak ditemukan untuk tipe member atau GMD item ini.');
        // return;
        $periode = 7;
    } else {
        $periode = $aturan->loan_periode;
    }

    $loanDate = Carbon::parse($this->loan_date);
    $dueDate = $loanDate->copy()->addDays($periode);

    if (!$this->selectedItem) {
        session()->flash('error', 'Silakan pilih item terlebih dahulu.');
        return;
    }

    Peminjaman::create([
        'kode_item' => $this->selectedItem->kode_item,
        'member_id' => $typemember->member_id,
        'loan_date' => $this->loan_date,
        'duedate' => $dueDate,
        'is_return' => 0,
    ]);

    session()->flash('success', 'Peminjaman berhasil!');

    // Reset input
    $this->cariitem = '';
    $this->selectedItem = null;
}

    // Edit denda
    public function editdendaId($id)
    {
        $denda = TransaksiDenda::findOrFail($id);
        $this->selecteddenda_id = $denda->id;
        $this->tanggal = $denda->tanggal;
        $this->debet = $denda->debet;
        $this->kredit = $denda->kredit;
        $this->keterangan = $denda->keterangan;
    }

    // Update denda
    public function updateDenda()
    {
        $statusValue = $this->debet - $this->kredit;
        $status = $statusValue >= 0 ? "Unpaid" : "Paid";

        try {
            $denda = TransaksiDenda::findOrFail($this->selecteddenda_id);
            $denda->update([
                'tanggal' => $this->tanggal,
                'debet' => $this->debet,
                'kredit' => $this->kredit,
                'keterangan' => $this->keterangan,
                'status' => $status,
            ]);

            session()->flash('success', 'Data Aturan Peminjaman berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Delete pemesanan
    public function deletePemesanan($id)
    {
        $this->selectedpemesanan = $id;
    }

    // Destroy pemesanan
    public function destroyPemesanan()
    {
        try {
            TransaksiPemesanan::findOrFail($this->selectedpemesanan)->delete();
            session()->flash('success', 'Data Aturan Peminjaman berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Store pemesanan
    public function storePemesanan()
    {
        $anggota = Anggota::with('tipeAnggota')->findOrFail($this->selected_member);
        $buku = $this->bibliografi_id;
        $totalItem = Item::where('bibliografi_id', $this->bibliografi_id)->count();
        $dipinjam = Peminjaman::whereHas('item', function ($q) use ($buku) {
            $q->where('bibliografi_id', $this->bibliografi_id);
        })->where('is_return', 0)->count();
        $stokTersedia = $totalItem - $dipinjam;

        $typemember = Anggota::with('tipeAnggota', 'tipeAnggota.aturanPeminjaman')
        ->findOrFail($this->selected_member);
        $bibliografi = Bibliografi::findOrFail($this->bibliografi_id);

        if ($stokTersedia > 0) {
            $availableItem = Item::where('bibliografi_id', $this->bibliografi_id)
                ->whereDoesntHave('peminjaman', function ($q) {
                    $q->where('is_return', 0);
                })
                ->first();

        $aturan = AturanPeminjaman::where('member_type_id', $typemember->tipe_anggota_id)->where('gmd_id', $bibliografi->gmd_id)->first();
    if (!$aturan) {
        // session()->flash('error', 'Aturan peminjaman tidak ditemukan untuk tipe member atau GMD item ini.');
        // return;
        $periode = 7;
    } else {
        $periode = $aturan->loan_periode;
    }

        $loanDate = Carbon::now();
        $dueDate = $loanDate->copy()->addDays($periode);

            if ($availableItem) {
                $pemesanan = TransaksiPemesanan::create([
                    'member_id' => $typemember->member_id,
                    'bibliografi_id' => $this->bibliografi_id,
                    'kode_item' => $availableItem->kode_item,
                    'reserve_date' => now(),
                    'is_mendapatkan' => 1,
                    'tipe_member_id' => $anggota->tipe_anggota_id,
                ]);

                Peminjaman::create([
                    'member_id' => $typemember->member_id,
                    'kode_item' => $availableItem->kode_item,
                    'loan_date' => now(),
                    'duedate' => $dueDate,
                    'is_return' => 0,
                ]);
            }
        } else {
            TransaksiPemesanan::create([
                'member_id' => $typemember->member_id,
                'bibliografi_id' => $this->bibliografi_id,
                'kode_item' => null,
                'reserve_date' => now(),
                'is_mendapatkan' => 0,
                'tipe_member_id' => $anggota->tipe_anggota_id,
                'tipe_member_id' => $anggota->tipe_anggota_id,
            ]);
        }
        $this->dispatch('close-modal');
    }

    // Mark item as returned
    public function kembali($id)
    {
        $this->selectedkembali_id = $id;
    }

    public function addKembali()
    {
        try {
            $peminjaman = Peminjaman::findOrFail($this->selectedkembali_id);
            $peminjaman->update([
                'return_date' => Carbon::now(),
                'is_return' => 1,
            ]);

            session()->flash('success', 'Data Aturan Peminjaman berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Extend borrowing period
    public function perpanjangan($id)
    {
        $this->selectedperpanjangan_id = $id;
    }

    public function addPerpanjangan()
    {
        $typemember = Anggota::with('tipeAnggota', 'tipeAnggota.aturanPeminjaman')
            ->findOrFail($this->selected_member);

        if (!$this->selected_member) {
            session()->flash('error', 'Member belum dipilih.');
            return;
        }

        if (!$typemember) {
            session()->flash('error', 'Member tidak ditemukan.');
            return;
        }
        $peminjaman = Peminjaman::with('item', 'item.bibliografi')->findOrFail($this->selectedperpanjangan_id);

        $aturan = AturanPeminjaman::where('member_type_id', $typemember->tipe_anggota_id)->where('gmd_id', $peminjaman->item->bibliografi->gmd_id)->first();


    if (!$aturan) {
        $periode = 7;
    } else {
        $periode = $aturan->loan_periode;
    }
        $oldDueDate = Carbon::parse($peminjaman->duedate);
        $dueDate = $oldDueDate->copy()->addDays($periode);

        try {
            $peminjaman->update([
                'duedate' => $dueDate,
            ]);

            session()->flash('success', 'Data Aturan Peminjaman berhasil diperbarui.');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Delete denda
    public function deletedendaId($id)
    {
        $this->selecteddenda_id = $id;
    }

    public function destroydenda()
    {
        try {
            TransaksiDenda::findOrFail($this->selecteddenda_id)->delete();
            session()->flash('success', 'Data Aturan Peminjaman berhasil dihapus.');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Select member
    public function selectMember($member)
    {
        $anggota = Anggota::where('member_id', $member)->first();
        if ($anggota) {
            $this->carimember = $anggota->nama;
            $this->selected_member = $anggota->id;
            $this->member_idselected = $anggota->member_id;
        }
        $this->resultsmember = [];
    }

    // Render view with data
    public function render()
    {
        $pinjamans = Peminjaman::with('item', 'item.bibliografi')
            ->where('member_id', $this->member_idselected)
            ->where('is_return', 0)
            ->latest()
            ->paginate(10);

        $dendas = TransaksiDenda::where('member_id', $this->member_idselected)
            ->latest()
            ->paginate(10);

        $peminjamans = Peminjaman::with('item', 'item.bibliografi')
            ->where(function ($q) {
                $q->where('member_id', $this->member_idselected)
                  ->orWhere('is_return', 0);
            })
            ->when($this->caririwayat, function ($q) {
                $q->where('kode_item', 'like', '%' . $this->caririwayat . '%')
                  ->orWhereHas('item.bibliografi', function ($sub) {
                      $sub->where('judul', 'like', '%' . $this->caririwayat . '%');
                  });
            })
            ->paginate(10);

            $riwayats = Peminjaman::with('item', 'item.bibliografi')
    ->where('member_id', $this->member_idselected) // selalu filter by member dulu
    ->when($this->caririwayat, function ($q) {
        $q->where(function ($subQuery) {
            $subQuery->where('kode_item', 'like', '%' . $this->caririwayat . '%')
                     ->orWhereHas('item.bibliografi', function ($sub) {
                         $sub->where('judul', 'like', '%' . $this->caririwayat . '%');
                     });
        });
    })
    ->paginate(10);

        $pemesanans = TransaksiPemesanan::with('item', 'bibliografi')
            ->where('member_id', $this->member_idselected)
            ->when($this->caririwayat, function ($q) {
                $q->where('kode_item', 'like', '%' . $this->caririwayat . '%')
                  ->orWhereHas('bibliografi', function ($sub) {
                      $sub->where('judul', 'like', '%' . $this->caririwayat . '%');
                  });
            })
            ->paginate(10);

        return view('livewire.sirkulasi.transaksi-component', compact([
            'pinjamans',
            'pemesanans',
            'dendas',
            'peminjamans',
            'riwayats'
        ]));
    }
}
?>
