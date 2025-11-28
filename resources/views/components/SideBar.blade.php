@php
    $isBerandaActive = request()->routeIs('home.index') || request()->routeIs('konfigurasi.index');
    $isKeanggotaanActive = request()->routeIs('keanggotaan.*');
    $isTabelActive = request()->routeIs('tabel.*');
    $isSirkulasiActive = request()->routeIs('sirkulasi.*');
    $isKatalogActive = request()->routeIs('katalog.*');
    $isPelaporanActive = request()->routeIs('pelaporan.*');
@endphp

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark2">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark2">
            <a href="{{ route('home.index') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/Skarisa.png') }}" alt="Logo Skarisa" height="34" class="me-2">
                <span style="color: white; font-weight: bold; font-size: 20px;">Smk Krian 1</span>
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    <!-- Wrapper pakai flex column -->
    <div class="sidebar-wrapper scrollbar scrollbar-inner d-flex flex-column">
        <!-- Konten Atas -->
        <div class="sidebar-content flex-grow-1">
            <!-- User Profile -->
            <div class="text-center pe-3 py-3 profile-info">
                <div class="mb-2">
                    <img src="{{ asset('assets/img/avatar.png') }}" alt="Profile" class="avatar-img rounded-circle"
                        style="width:120px; height:120px; border:3px solid #fff;">
                </div>
                <div class="text-white fw-bold">{{ Auth::user()->nama_pengguna }}</div>
                <div class="mt-3">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm px-5"
                            style="background:none; border:1px solid yellow; color:yellow; font-weight:bold;">
                            Logout
                        </button>
                    </form>


                </div>
            </div>
            <!-- End User Profile -->

            <!-- Menu Navigasi -->
            <ul class="nav nav-secondary">
                <!-- BERANDA -->
                <li class="nav-item my-3 py-2 {{ $isBerandaActive || $isKeanggotaanActive || $isTabelActive ? 'active submenu' : '' }}"
                    style="background-color: rgba(255,255,255,0.05);">
                    <a data-bs-toggle="collapse" href="#menuBeranda"
                        aria-expanded="{{ $isBerandaActive || $isKeanggotaanActive || $isTabelActive ? 'true' : 'false' }}">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isBerandaActive || $isKeanggotaanActive || $isTabelActive ? 'show' : '' }}"
                        id="menuBeranda">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('home.index') ? 'active' : '' }}">
                                <a href="{{ route('home.index') }}"><span class="sub-item">Home</span></a>
                            </li>
                            <li class="{{ request()->routeIs('konfigurasi.index') ? 'active' : '' }}">
                                <a href="{{ route('konfigurasi.index') }}"><span
                                        class="sub-item">Konfigurasi</span></a>
                            </li>
                            <li class="{{ $isKeanggotaanActive ? 'active submenu' : '' }}">
                                <a data-bs-toggle="collapse" href="#submenuKeanggotaan"
                                    aria-expanded="{{ $isKeanggotaanActive ? 'true' : 'false' }}">
                                    <span class="sub-item">Keanggotaan</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ $isKeanggotaanActive ? 'show' : '' }}" id="submenuKeanggotaan">
                                    <ul class="nav nav-collapse ms-4">
                                        <li class="{{ request()->routeIs('keanggotaan.daftar') ? 'active' : '' }}">
                                            <a href="{{ route('keanggotaan.daftar') }}"><span class="sub-item">Daftar
                                                    Anggota</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('keanggotaan.tipe') ? 'active' : '' }}">
                                            <a href="{{ route('keanggotaan.tipe') }}"><span class="sub-item">Tipe
                                                    Anggota</span></a>
                                        </li>
                                        <li
                                            class="{{ request()->routeIs('keanggotaan.surat_bebas') ? 'active' : '' }}">
                                            <a href="{{ route('keanggotaan.surat_bebas') }}"><span
                                                    class="sub-item">Surat Bebas Perpustakaan</span></a>
                                        </li>
                                    </ul>

                                </div>
                            </li>


                            @if ($isTabelActive)
                                <hr>
                            @endif

                            <li class="{{ $isTabelActive ? 'active submenu' : '' }}">
                                <a data-bs-toggle="collapse" href="#submenuTabel"
                                    aria-expanded="{{ $isTabelActive ? 'true' : 'false' }}">
                                    <span class="sub-item">Tabel Data</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ $isTabelActive ? 'show' : '' }}" id="submenuTabel">
                                    <ul class="nav nav-collapse ms-4">
                                        <li class="{{ request()->routeIs('tabel.hari_libur') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.hari_libur') }}"><span class="sub-item">Hari
                                                    Libur</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.jenis_item') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.jenis_item') }}"><span class="sub-item">Jenis Item
                                                    (GMD)</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.penerbit') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.penerbit') }}"><span
                                                    class="sub-item">Penerbit</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.penulis') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.penulis') }}"><span
                                                    class="sub-item">Penulis</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.supplier') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.supplier') }}"><span
                                                    class="sub-item">Supplier</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.topik') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.topik') }}"><span
                                                    class="sub-item">Topik</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.lokasi') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.lokasi') }}"><span
                                                    class="sub-item">Lokasi</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.rak') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.rak') }}"><span class="sub-item">Rak</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.tempat_penerbit') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.tempat_penerbit') }}"><span
                                                    class="sub-item">Tempat Penerbit</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.status_item') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.status_item') }}"><span class="sub-item">Status
                                                    Item</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.tipe_koleksi') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.tipe_koleksi') }}"><span class="sub-item">Tipe
                                                    Koleksi</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.frekuensi') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.frekuensi') }}"><span
                                                    class="sub-item">Frekuensi</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.bahasa') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.bahasa') }}"><span
                                                    class="sub-item">Bahasa</span></a>
                                        </li>
                                        <li class="{{ request()->routeIs('tabel.tujuan_bebas') ? 'active' : '' }}">
                                            <a href="{{ route('tabel.tujuan_bebas') }}"><span class="sub-item">Tujuan
                                                    Bebas Perpus</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>


                <!-- SIRKULASI -->
                <li class="nav-item my-3 py-2 {{ $isSirkulasiActive ? 'active submenu' : '' }}"
                    style="background-color: rgba(255,255,255,0.05);">
                    <a data-bs-toggle="collapse" href="#menuSirkulasi"
                        aria-expanded="{{ $isSirkulasiActive ? 'true' : 'false' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <p>Sirkulasi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isSirkulasiActive ? 'show' : '' }}" id="menuSirkulasi">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('sirkulasi.transaksi') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.transaksi') }}"><span
                                        class="sub-item">Transaksi</span></a>
                            </li>
                            <li class="{{ request()->routeIs('sirkulasi.pengembalian') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.pengembalian') }}"><span
                                        class="sub-item">Pengembalian</span></a>
                            </li>
                            <li class="{{ request()->routeIs('sirkulasi.pemesanan') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.pemesanan') }}"><span
                                        class="sub-item">Pemesanan</span></a>
                            </li>
                            <li class="{{ request()->routeIs('sirkulasi.aturan_peminjaman') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.aturan_peminjaman') }}"><span class="sub-item">Aturan
                                        Peminjaman</span></a>
                            </li>
                            <li class="{{ request()->routeIs('sirkulasi.riwayat_peminjaman') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.riwayat_peminjaman') }}"><span class="sub-item">Riwayat
                                        Peminjaman</span></a>
                            </li>
                            <li class="{{ request()->routeIs('sirkulasi.daftar_keterlambatan') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.daftar_keterlambatan') }}"><span class="sub-item">Daftar
                                        Keterlambatan</span></a>
                            </li>
                            <li class="{{ request()->routeIs('sirkulasi.stock_opname') ? 'active' : '' }}">
                                <a href="{{ route('sirkulasi.stock_opname') }}"><span class="sub-item">Stock
                                        Opname</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- KATALOG -->
                <li class="nav-item my-3 py-2 {{ $isKatalogActive ? 'active submenu' : '' }}"
                    style="background-color: rgba(255,255,255,0.05);">
                    <a data-bs-toggle="collapse" href="#menuKatalog"
                        aria-expanded="{{ $isKatalogActive ? 'true' : 'false' }}">
                        <i class="fas fa-book"></i>
                        <p>Katalog</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isKatalogActive ? 'show' : '' }}" id="menuKatalog">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('katalog.bibliografi') ? 'active' : '' }}">
                                <a href="{{ route('katalog.bibliografi') }}"><span
                                        class="sub-item">Bibliografi</span></a>
                            </li>
                            <li class="{{ request()->routeIs('katalog.daftar_item') ? 'active' : '' }}">
                                <a href="{{ route('katalog.daftar_item') }}"><span class="sub-item">Daftar
                                        Item</span></a>
                            </li>
                            <li class="{{ request()->routeIs('katalog.item_keluar') ? 'active' : '' }}">
                                <a href="{{ route('katalog.item_keluar') }}"><span class="sub-item">Item
                                        Keluar</span></a>
                            </li>
                            <li class="{{ request()->routeIs('katalog.serial_control') ? 'active' : '' }}">
                                <a href="{{ route('katalog.serial_control') }}"><span class="sub-item">Serial
                                        Control</span></a>
                            </li>
                            <li class="{{ request()->routeIs('katalog.cetak_label') ? 'active' : '' }}">
                                <a href="{{ route('katalog.cetak_label') }}"><span class="sub-item">Cetak
                                        Label</span></a>
                            </li>
                            <li class="{{ request()->routeIs('katalog.cetak_barcode_item') ? 'active' : '' }}">
                                <a href="{{ route('katalog.cetak_barcode_item') }}"><span class="sub-item">Cetak
                                        Barcode Item</span></a>
                            </li>
                            <li class="{{ request()->routeIs('katalog.cetak_catalog') ? 'active' : '' }}">
                                <a href="{{ route('katalog.cetak_catalog') }}"><span class="sub-item">Cetak
                                        Katalog</span></a>
                            </li>
                        </ul>
                    </div>
                </li>


                <!-- PELAPORAN -->
                <li class="nav-item my-3 py-2 {{ $isPelaporanActive ? 'active submenu' : '' }}"
                    style="background-color: rgba(255,255,255,0.05);">
                    <a data-bs-toggle="collapse" href="#menuPelaporan"
                        aria-expanded="{{ $isPelaporanActive ? 'true' : 'false' }}">
                        <i class="fas fa-chart-pie"></i>
                        <p>Pelaporan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isPelaporanActive ? 'show' : '' }}" id="menuPelaporan">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('pelaporan.statistik-koleksi') ? 'active' : '' }}">
                                <a href="{{ route('pelaporan.statistik-koleksi') }}"><span class="sub-item">Statistik
                                        Koleksi</span></a>
                            </li>
                            <li class="{{ request()->routeIs('pelaporan.laporan-peminjaman') ? 'active' : '' }}">
                                <a href="{{ route('pelaporan.laporan-peminjaman') }}"><span class="sub-item">Laporan
                                        Peminjaman</span></a>
                            </li>
                            <li class="{{ request()->routeIs('pelaporan.laporan-keanggotaan') ? 'active' : '' }}">
                                <a href="{{ route('pelaporan.laporan-keanggotaan') }}"><span class="sub-item">Laporan
                                        Keanggotaan</span></a>
                            </li>
                            <li class="{{ request()->routeIs('pelaporan.rekapitulasi') ? 'active' : '' }}">
                                <a href="{{ route('pelaporan.rekapitulasi') }}"><span
                                        class="sub-item">Rekapitulasi</span></a>
                            </li>
                            <li class="{{ request()->routeIs('pelaporan.rekapitulasi-berkala') ? 'active' : '' }}">
                                <a href="{{ route('pelaporan.rekapitulasi-berkala') }}"><span
                                        class="sub-item">Rekapitulasi Berkala</span></a>
                            </li>
                            <li class="{{ request()->routeIs('pelaporan.rekapitulasi-buku') ? 'active' : '' }}">
                                <a href="{{ route('pelaporan.rekapitulasi-buku') }}"><span
                                        class="sub-item">Rekapitulasi Buku</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
