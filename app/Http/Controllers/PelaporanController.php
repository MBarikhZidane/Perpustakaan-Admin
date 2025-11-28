<?php

// ============================================================================
// PelaporanController.php
//
// Controller ini menangani seluruh fungsi pelaporan perpustakaan. Setiap
// metode akan mengumpulkan data dari basis data, membuat PDF menggunakan
// Browsershot dan menampilkan pratinjau PDF pada halaman berisi form
// filter. Seluruh query menggunakan Query Builder Laravel agar mudah
// disesuaikan dengan struktur database yang ada.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;

class PelaporanController extends Controller
{
    public function statistikKoleksi(Request $request)
    {
        $startDate = $request->input('start_date') ?? Carbon::now()->startOfYear()->toDateString();
        $endDate   = $request->input('end_date') ?? Carbon::now()->endOfYear()->toDateString();

        return view('Pelaporan.statistikKoleksi', [
            'pdfUrl'    => route('pelaporan.statistik-koleksi.pdf', [
                'start_date' => $startDate,
                'end_date'   => $endDate,
            ]),
            'startDate' => $startDate,
            'endDate'   => $endDate,
        ]);
    }

    public function statistikKoleksiPdf(Request $request)
    {
        $startDate = $request->input('start_date') ?? Carbon::now()->startOfYear()->toDateString();
        $endDate   = $request->input('end_date') ?? Carbon::now()->endOfYear()->toDateString();

        $totalJudul = DB::table('bibliografis')->count();
        $judulDenganItem = DB::table('bibliografis')
            ->join('items', 'bibliografis.id', '=', 'items.bibliografi_id')
            ->distinct('bibliografis.id')
            ->count('bibliografis.id');
        $totalItem = DB::table('items')->count();
        $itemKeluar = DB::table('peminjamen')
            ->where('is_return', 0)
            ->count();
        $itemTersedia = $totalItem - $itemKeluar;
        $judulPerGmd = DB::table('bibliografis')
            ->leftJoin('gmds', 'bibliografis.gmd_id', '=', 'gmds.id')
            ->select('gmds.nama_gmd', DB::raw('COUNT(bibliografis.id) as jumlah'))
            ->groupBy('gmds.nama_gmd')
            ->pluck('jumlah', 'nama_gmd')
            ->toArray();
        $judulPerTipe = DB::table('bibliografis')
            ->leftJoin('tipe_koleksis', 'bibliografis.tipe_koleksi_id', '=', 'tipe_koleksis.id')
            ->select('tipe_koleksis.nama_tipe_koleksi', DB::raw('COUNT(bibliografis.id) as jumlah'))
            ->groupBy('tipe_koleksis.nama_tipe_koleksi')
            ->pluck('jumlah', 'nama_tipe_koleksi')
            ->toArray();
        $topJudul = DB::table('peminjamen')
            ->join('items', 'peminjamen.kode_item', '=', 'items.kode_item')
            ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
            ->select('bibliografis.judul', DB::raw('COUNT(peminjamen.id) as total'))
            ->groupBy('bibliografis.id', 'bibliografis.judul')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('judul')
            ->toArray();

        $dataPdf = [
            'startDate'       => $startDate,
            'endDate'         => $endDate,
            'totalJudul'      => $totalJudul,
            'judulDenganItem' => $judulDenganItem,
            'totalItem'       => $totalItem,
            'itemKeluar'      => $itemKeluar,
            'itemTersedia'    => $itemTersedia,
            'judulPerGmd'     => $judulPerGmd,
            'judulPerTipe'    => $judulPerTipe,
            'topJudul'        => $topJudul,
        ];

        $html = view('pdf.statistik-koleksi', $dataPdf)->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf');
    }

    public function laporanPeminjaman(Request $request)
    {
        $tanggal = $request->input('tanggal');
        if ($tanggal) {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate   = Carbon::parse($tanggal)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate   = Carbon::now();
        }

        return view('Pelaporan.laporanPeminjaman', [
            'pdfUrl'   => route('pelaporan.laporan-peminjaman.pdf', [
                'tanggal' => $tanggal,
            ]),
            'tanggal'  => $tanggal,
        ]);
    }

    public function laporanPeminjamanPdf(Request $request)
    {
        $tanggal = $request->input('tanggal');
        if ($tanggal) {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate   = Carbon::parse($tanggal)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate   = Carbon::now();
        }

        $totalPeminjaman = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->count();

        $peminjamanTipe = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->join('items', 'peminjamen.kode_item', '=', 'items.kode_item')
            ->join('tipe_koleksis', 'items.tipe_koleksi_id', '=', 'tipe_koleksis.id')
            ->select('tipe_koleksis.nama_tipe_koleksi', DB::raw('COUNT(peminjamen.id) as total'))
            ->groupBy('tipe_koleksis.nama_tipe_koleksi')
            ->pluck('total', 'nama_tipe_koleksi')
            ->toArray();

        $totalTransaksi = $totalPeminjaman;
        $jumlahHari      = $startDate->diffInDays($endDate) + 1;
        $rataPerHari     = $jumlahHari > 0 ? ceil($totalPeminjaman / $jumlahHari) : $totalPeminjaman;

        $transaksiTertinggi = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->select(DB::raw('COUNT(id) as total'))
            ->groupBy('loan_date')
            ->orderByDesc('total')
            ->value('total') ?? 0;

        $anggotaYangMeminjam = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->distinct('member_id')
            ->count('member_id');

        $totalAnggota = DB::table('anggotas')->count();
        $anggotaBelumPinjam = $totalAnggota - $anggotaYangMeminjam;

        $totalTerlambat = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereNotNull('return_date')
            ->whereColumn('return_date', '>', 'duedate')
            ->count();

        $dataPdf = [
            'tanggal'              => $tanggal,
            'totalPeminjaman'      => $totalPeminjaman,
            'peminjamanTipe'       => $peminjamanTipe,
            'totalTransaksi'       => $totalTransaksi,
            'rataPerHari'          => $rataPerHari,
            'transaksiTertinggi'   => $transaksiTertinggi,
            'anggotaYangMeminjam'  => $anggotaYangMeminjam,
            'anggotaBelumPinjam'   => $anggotaBelumPinjam,
            'totalTerlambat'       => $totalTerlambat,
        ];

        $html = view('pdf.laporan-peminjaman', $dataPdf)->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }


    public function laporanKeanggotaan(Request $request)
    {
        $tanggal = $request->input('tanggal');
        if ($tanggal) {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate   = Carbon::parse($tanggal)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate   = Carbon::now();
        }

        return view('Pelaporan.laporanKeanggotaan', [
            'pdfUrl'  => route('pelaporan.laporan-keanggotaan.pdf', [
                'tanggal' => $tanggal,
            ]),
            'tanggal' => $tanggal,
        ]);
    }

    public function laporanKeanggotaanPdf(Request $request)
    {
        $tanggal = $request->input('tanggal');
        if ($tanggal) {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate   = Carbon::parse($tanggal)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate   = Carbon::now();
        }

        $totalAnggota = DB::table('anggotas')->count();

        $anggotaAktif = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->distinct('member_id')
            ->count('member_id');

        $topMembersRaw = DB::table('peminjamen')
            ->whereBetween('loan_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('member_id')
            ->select('member_id', DB::raw('COUNT(*) as total'))
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topMembers = [];
        foreach ($topMembersRaw as $row) {
            $anggota = DB::table('anggotas')->where('member_id', $row->member_id)->first();
            $topMembers[] = [
                'nama'  => $anggota ? $anggota->nama : $row->member_id,
                'total' => $row->total,
            ];
        }

        $dataPdf = [
            'tanggal'      => $tanggal,
            'totalAnggota' => $totalAnggota,
            'anggotaAktif' => $anggotaAktif,
            'topMembers'   => $topMembers,
        ];

        $html = view('pdf.laporan-keanggotaan', $dataPdf)->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }


    public function rekapitulasi(Request $request)
    {
        $tanggal  = $request->input('tanggal');
        $kategori = $request->input('kategori', 'judul');

        if ($tanggal) {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate   = Carbon::parse($tanggal)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate   = Carbon::now();
        }

        return view('Pelaporan.rekapitulasi', [
            'pdfUrl'   => route('pelaporan.rekapitulasi.pdf', [
                'tanggal'  => $tanggal,
                'kategori' => $kategori,
            ]),
            'tanggal'  => $tanggal,
            'kategori' => $kategori,
        ]);
    }

    public function rekapitulasiPdf(Request $request)
    {
        $tanggal  = $request->input('tanggal');
        $kategori = $request->input('kategori', 'judul');

        if ($tanggal) {
            $startDate = Carbon::parse($tanggal)->startOfDay();
            $endDate   = Carbon::parse($tanggal)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfYear();
            $endDate   = Carbon::now();
        }

        $result = [];
        if ($kategori === 'judul') {
            $result = DB::table('bibliografis')
                ->leftJoin('items', 'bibliografis.id', '=', 'items.bibliografi_id')
                ->select('bibliografis.judul as nama', DB::raw('COUNT(items.kode_item) as jumlah'))
                ->groupBy('bibliografis.id', 'bibliografis.judul')
                ->orderBy('bibliografis.judul')
                ->get();
        } elseif ($kategori === 'subyek') {
            $result = DB::table('bibliografi_topiks')
                ->join('topiks', 'bibliografi_topiks.topik_id', '=', 'topiks.id')
                ->select('topiks.nama_topik as nama', DB::raw('COUNT(DISTINCT bibliografi_topiks.bibliografi_id) as jumlah'))
                ->groupBy('topiks.id', 'topiks.nama_topik')
                ->orderBy('topiks.nama_topik')
                ->get();
        } elseif ($kategori === 'gmd') {
            $result = DB::table('bibliografis')
                ->join('gmds', 'bibliografis.gmd_id', '=', 'gmds.id')
                ->select('gmds.nama_gmd as nama', DB::raw('COUNT(DISTINCT bibliografis.id) as jumlah'))
                ->groupBy('gmds.id', 'gmds.nama_gmd')
                ->orderBy('gmds.nama_gmd')
                ->get();
        } elseif ($kategori === 'tipe') {
            $result = DB::table('bibliografis')
                ->join('tipe_koleksis', 'bibliografis.tipe_koleksi_id', '=', 'tipe_koleksis.id')
                ->select('tipe_koleksis.nama_tipe_koleksi as nama', DB::raw('COUNT(DISTINCT bibliografis.id) as jumlah'))
                ->groupBy('tipe_koleksis.id', 'tipe_koleksis.nama_tipe_koleksi')
                ->orderBy('tipe_koleksis.nama_tipe_koleksi')
                ->get();
        } elseif ($kategori === 'bahasa') {
            $result = DB::table('bibliografis')
                ->leftJoin('bahasas', 'bibliografis.bahasa_id', '=', 'bahasas.kode_bahasa')
                ->select('bahasas.nama_bahasa as nama', DB::raw('COUNT(DISTINCT bibliografis.id) as jumlah'))
                ->groupBy('bahasas.kode_bahasa', 'bahasas.nama_bahasa')
                ->orderBy('bahasas.nama_bahasa')
                ->get();
        }

        $dataPdf = [
            'tanggal'  => $tanggal,
            'kategori' => $kategori,
            'result'   => $result,
        ];

        $html = view('pdf.rekapitulasi', $dataPdf)->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }


    public function rekapitulasiBerkala(Request $request)
    {
        $tahun = $request->input('tahun') ?? Carbon::now()->year;

        return view('Pelaporan.rekapitulasiBerkala', [
            'pdfUrl' => route('pelaporan.rekapitulasi-berkala.pdf', [
                'tahun' => $tahun,
            ]),
            'tahun'  => $tahun,
        ]);
    }

    public function rekapitulasiBerkalaPdf(Request $request)
    {
        $tahun = $request->input('tahun') ?? Carbon::now()->year;

        $types  = DB::table('tipe_koleksis')->orderBy('nama_tipe_koleksi')->get();
        $hasil  = [];

        foreach ($types as $type) {
            $judulBefore = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('items.tipe_koleksi_id', $type->id)
                ->whereYear('items.created_at', '<', $tahun)
                ->distinct('bibliografis.id')
                ->count('bibliografis.id');

            $ekspBefore = DB::table('items')
                ->where('tipe_koleksi_id', $type->id)
                ->whereYear('created_at', '<', $tahun)
                ->count();

            $judulYear = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('items.tipe_koleksi_id', $type->id)
                ->whereYear('items.created_at', '=', $tahun)
                ->distinct('bibliografis.id')
                ->count('bibliografis.id');

            $ekspYear = DB::table('items')
                ->where('tipe_koleksi_id', $type->id)
                ->whereYear('created_at', '=', $tahun)
                ->count();

            $judulTotal = $judulBefore + $judulYear;
            $ekspTotal  = $ekspBefore + $ekspYear;

            $hasil[] = [
                'jenis'       => $type->nama_tipe_koleksi,
                'judulBefore' => $judulBefore,
                'ekspBefore'  => $ekspBefore,
                'judulYear'   => $judulYear,
                'ekspYear'    => $ekspYear,
                'judulTotal'  => $judulTotal,
                'ekspTotal'   => $ekspTotal,
            ];
        }

        $dataPdf = [
            'tahun' => $tahun,
            'data'  => $hasil,
        ];

        $html = view('pdf.rekapitulasi-berkala', $dataPdf)->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }


    public function rekapitulasiBuku(Request $request)
    {
        $startDate = $request->input('start_date') ?? Carbon::now()->startOfYear()->toDateString();
        $endDate   = $request->input('end_date') ?? Carbon::now()->toDateString();

        return view('Pelaporan.rekapitulasiBuku', [
            'pdfUrl'    => route('pelaporan.rekapitulasi-buku.pdf', [
                'start_date' => $startDate,
                'end_date'   => $endDate,
            ]),
            'startDate' => $startDate,
            'endDate'   => $endDate,
        ]);
    }

    public function rekapitulasiBukuPdf(Request $request)
    {
        $startDate = $request->input('start_date') ?? Carbon::now()->startOfYear()->toDateString();
        $endDate   = $request->input('end_date') ?? Carbon::now()->toDateString();

        $indonesiaId = DB::table('bahasas')
            ->where('nama_bahasa', 'LIKE', '%Indonesia%')
            ->pluck('kode_bahasa')
            ->toArray();

        $kelas = DB::table('bibliografis')
            ->select('klasifikasi')
            ->groupBy('klasifikasi')
            ->orderBy('klasifikasi')
            ->get();

        $rekapData = [];
        foreach ($kelas as $k) {
            $judulSebelumId = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereDate('items.created_at', '<', $startDate)
                ->whereIn('bibliografis.bahasa_id', $indonesiaId)
                ->distinct('bibliografis.id')
                ->count('bibliografis.id');

            $ekspSebelumId = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereDate('items.created_at', '<', $startDate)
                ->whereIn('bibliografis.bahasa_id', $indonesiaId)
                ->count();

            $judulSebelumAs = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereDate('items.created_at', '<', $startDate)
                ->whereNotIn('bibliografis.bahasa_id', $indonesiaId)
                ->distinct('bibliografis.id')
                ->count('bibliografis.id');

            $ekspSebelumAs = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereDate('items.created_at', '<', $startDate)
                ->whereNotIn('bibliografis.bahasa_id', $indonesiaId)
                ->count();

            $judulTambahId = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereBetween('items.created_at', [$startDate, $endDate])
                ->whereIn('bibliografis.bahasa_id', $indonesiaId)
                ->distinct('bibliografis.id')
                ->count('bibliografis.id');

            $ekspTambahId = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereBetween('items.created_at', [$startDate, $endDate])
                ->whereIn('bibliografis.bahasa_id', $indonesiaId)
                ->count();

            $judulTambahAs = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereBetween('items.created_at', [$startDate, $endDate])
                ->whereNotIn('bibliografis.bahasa_id', $indonesiaId)
                ->distinct('bibliografis.id')
                ->count('bibliografis.id');

            $ekspTambahAs = DB::table('items')
                ->join('bibliografis', 'items.bibliografi_id', '=', 'bibliografis.id')
                ->where('bibliografis.klasifikasi', $k->klasifikasi)
                ->whereBetween('items.created_at', [$startDate, $endDate])
                ->whereNotIn('bibliografis.bahasa_id', $indonesiaId)
                ->count();

            $judulTotalId  = $judulSebelumId + $judulTambahId;
            $ekspTotalId   = $ekspSebelumId + $ekspTambahId;
            $judulTotalAs  = $judulSebelumAs + $judulTambahAs;
            $ekspTotalAs   = $ekspSebelumAs + $ekspTambahAs;

            $rekapData[] = [
                'klasifikasi'    => $k->klasifikasi,
                'judulSebelumId' => $judulSebelumId,
                'ekspSebelumId'  => $ekspSebelumId,
                'judulSebelumAs' => $judulSebelumAs,
                'ekspSebelumAs'  => $ekspSebelumAs,
                'judulTambahId'  => $judulTambahId,
                'ekspTambahId'   => $ekspTambahId,
                'judulTambahAs'  => $judulTambahAs,
                'ekspTambahAs'   => $ekspTambahAs,
                'judulTotalId'   => $judulTotalId,
                'ekspTotalId'    => $ekspTotalId,
                'judulTotalAs'   => $judulTotalAs,
                'ekspTotalAs'    => $ekspTotalAs,
            ];
        }

        $dataPdf = [
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'data'      => $rekapData,
        ];

        $html = view('pdf.rekapitulasi-buku', $dataPdf)->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(0, 0, 0, 0)
            ->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }

    public function daftarPengunjung()
    {
        //
    }

    public function laporanDenda()
    {
        //
    }
}
