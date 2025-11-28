<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Bibliografi</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addMemberModal">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                    <button type="button" class="btn btn-warning" wire:click="resetAddModal">
    Reset Input
</button>

                </div>
            </div>

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="mb-3 d-flex justify-content-between">
                    <input type="text" class="form-control w-100" placeholder="Cari..."
                        wire:model.live.debounce.10ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Deskripsi</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $items->firstItem() + $index }}</td>
                                    <td>
                                        @if ($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Item"
                                                class="w-16 h-16 object-cover rounded" style="width: 100px">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>Judul : {{ $item->judul }}
                                        <br>
                                        Penulis : {{ $item->penulis->first()?->nama }}
                                        <br>
                                        Penerbit : {{ $item->penerbit->nama_penerbit }}
                                        <br>
                                        ISBN / ISSN : {{ $item->isbn_issn }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                              <button class="btn btn-outline-dark btn-sm"
                                               wire:click="editBibliografi({{ $item->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteBibliografi({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Create Bibliografi -->
    <div wire:ignore.self class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <form wire:submit.prevent="SimpanBibliografi" enctype="multipart/form-data">
                    <div class="modal-header" style="background:#141927; color:#fff;">
                        <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Bibliografi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                wire:model.defer="judul">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex gap-5">
                            <div>
                                <label class="form-label">Gmd</label>
                                <select class="form-select @error('gmd_id') is-invalid @enderror"
                                    wire:model.defer="gmd_id">
                                    <option value="">Pilih GMD</option>
                                    @foreach ($tipe_gmd as $tipe)
                                        <option value="{{ $tipe->id }}">{{ $tipe->nama_gmd }}</option>
                                    @endforeach
                                </select>
                                @error('gmd_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Tipe Koleksi</label>
                                <select class="form-select @error('tipe_koleksi_id') is-invalid @enderror"
                                    wire:model.defer="tipe_koleksi_id">
                                    <option value="">Pilih Tipe Koleksi</option>
                                    @foreach ($tipe_koleksi as $tipe)
                                        <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe_koleksi }}</option>
                                    @endforeach
                                </select>
                                @error('tipe_koleksi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Seri</label>
                            <input type="text" class="form-control @error('judul_seri') is-invalid @enderror"
                                wire:model.defer="judul_seri">
                            @error('judul_seri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penerbit</label>
                            <select class="form-select @error('penerbit_id') is-invalid @enderror"
                                wire:model="penerbit_id">
                                  <option value="">Pilih Penerbit</option>
                                @foreach ($penerbit as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_penerbit }}</option>
                                @endforeach
                            </select>
                            @error('penerbit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="pills-penomoran" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-header">
                                    <h4 class="card-title mb-3">Tambah Penerbit Baru</h4>

                                    <div class="row g-2 align-items-center mb-3">
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('nama_penerbit') is-invalid @enderror"
                                                placeholder="Nama Penerbit" wire:model="nama_penerbit">
                                            @error('nama_penerbit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <select class="form-select @error('tempat_id') is-invalid @enderror"
                                                wire:model="tempat_id">
                                                <option value="">Pilih Tempat Penerbit</option>
                                                @foreach ($tempat as $t)
                                                    <option wire:key="tempat-{{ $t->id }}"
                                                        value="{{ $t->id }}">{{ $t->nama_tempat }}</option>
                                                @endforeach
                                            </select>
                                            @error('tempat_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="TambahPenerbitLangsung">
                                            <i class="fa fa-plus"></i> Tambah Penerbit
                                        </button>
                                    </div>
                                </div>

                                <div class="card-header mt-4">
                                    <h4 class="card-title mb-3">Tambah Tempat Baru</h4>

                                    <div class="row g-2 align-items-center mb-3">
                                        <div class="col-md-12">
                                            <input type="text"
                                                class="form-control @error('nama_tempat') is-invalid @enderror"
                                                placeholder="Nama Tempat Penerbit" wire:model="nama_tempat">
                                            @error('nama_tempat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="TambahTempatLangsung">
                                            <i class="fa fa-plus"></i> Tambah Tempat Baru
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if (session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex gap-5">
                            <div>
                                <label class="form-label">Tahun terbit</label>
                                <input type="text" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                    wire:model.defer="tahun_terbit">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-sistem') active @endif"
                                    wire:click="setTab('pills-sistem')" id="pills-sistem-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-sistem" type="button" role="tab"
                                    aria-controls="pills-sistem" aria-selected="true">Detail</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-penomoran') active @endif"
                                    wire:click="setTab('pills-penomoran')" id="pills-penomoran-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-penomoran" type="button"
                                    role="tab" aria-controls="pills-penomoran"
                                    aria-selected="false">Pengarang</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-kartu') active @endif"
                                    wire:click="setTab('pills-kartu')" id="pills-kartu-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-kartu" type="button" role="tab"
                                    aria-controls="pills-kartu" aria-selected="false">Subyek</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-riwayat') active @endif"
                                    wire:click="setTab('pills-riwayat')" id="pills-riwayat-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-riwayat" type="button" role="tab"
                                    aria-controls="pills-riwayat" aria-selected="false">Lampiran</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-item') active @endif"
                                    wire:click="setTab('pills-item')" id="pills-item-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-item" type="button" role="tab"
                                    aria-controls="pills-item" aria-selected="false">Item</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-catatan') active @endif"
                                    wire:click="setTab('pills-catatan')" id="pills-catatan-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-catatan" type="button" role="tab"
                                    aria-controls="pills-catatan" aria-selected="false">Catatan</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <!-- Tab Detail -->
                            <div class="tab-pane fade  @if ($activeTab == 'pills-sistem') show active @endif"
                                id="pills-sistem" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Detail</h4>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label">Edisi</label>
                                            <input type="text"
                                                class="form-control @error('edisi') is-invalid @enderror"
                                                wire:model.defer="edisi">
                                            @error('edisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Frekuensi</label>
                                            <select class="form-select @error('frekuensi_id') is-invalid @enderror"
                                                wire:model.defer="frekuensi_id">
                                                <option value="">Pilih Frekuensi</option>
                                                @foreach ($frekuensi as $tipe)
                                                    <option value="{{ $tipe->id }}">{{ $tipe->frekuensi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('frekuensi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Volume</label>
                                            <input type="text"
                                                class="form-control @error('volume') is-invalid @enderror"
                                                wire:model.defer="volume">
                                            @error('volume')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ISBN/ISSN</label>
                                            <input type="text"
                                                class="form-control @error('isbn_issn') is-invalid @enderror"
                                                wire:model.defer="isbn_issn">
                                            @error('isbn_issn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bahasa</label>
                                            <select class="form-select @error('bahasa_id') is-invalid @enderror"
                                                wire:model.defer="bahasa_id">
                                                <option value="">Pilih Bahasa</option>
                                                @foreach ($bahasa as $tipe)
                                                    <option value="{{ $tipe->kode_bahasa }}">{{ $tipe->nama_bahasa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bahasa_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Klasifikasi</label>
                                            <input type="text"
                                                class="form-control @error('klasifikasi') is-invalid @enderror"
                                                wire:model.defer="klasifikasi">
                                            @error('klasifikasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Call Number</label>
                                            <input type="text"
                                                class="form-control @error('call_number') is-invalid @enderror"
                                                wire:model.defer="call_number">
                                            @error('call_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Collation</label>
                                            <input type="text"
                                                class="form-control @error('collation') is-invalid @enderror"
                                                wire:model.defer="collation">
                                            @error('collation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.defer="is_etalase_hide">
                                                <label>Hide in OPAC</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.defer="is_promosi">
                                                <label>Is Promoted</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gambar</label>
                                            <input type="file"
                                                class="form-control @error('gambarFile') is-invalid @enderror"
                                                wire:model="gambarFile">
                                            @error('gambarFile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Pengarang -->
                            <div class="tab-pane fade @if ($activeTab == 'pills-penomoran') show active @endif"
                                id="pills-penomoran" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <div class="">
                                            <h4 class="card-title mb-2">Pengarang</h4>
                                            <div>
                                                <div class="mb-3 d-flex justify-content-between">
                                                    <input type="text"
                                                        class="form-control w-75 @error('pengarang.nama') is-invalid @enderror"
                                                        wire:model.defer="pengarang.nama">
                                                    @error('pengarang.nama')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <select
                                                        class="form-control w-75 @error('pengarang.kategori') is-invalid @enderror"
                                                        wire:model.defer="pengarang.kategori">
                                                        <option value="">-- Pilih Peran --</option>
                                                        <option value="Primary Author">Primary Author</option>
                                                        <option value="Additional Author">Additional Author</option>
                                                        <option value="Editor">Editor</option>
                                                        <option value="Translator">Translator</option>
                                                        <option value="Director">Director</option>
                                                        <option value="Producer">Producer</option>
                                                        <option value="Composer">Composer</option>
                                                        <option value="Illustrator">Illustrator</option>
                                                        <option value="Creator">Creator</option>
                                                        <option value="Contributor">Contributor</option>
                                                    </select>

                                                    <button type="button" class="btn btn-dark btn-sm"
                                                        wire:click="TambahPengarang">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 p-3 border rounded">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Nama</label>
                                                <select class="form-select @error('penulis_id') is-invalid @enderror"
                                                    wire:model="penulis_id">
                                                    <option value="">Pilih Penulis</option>
                                                    @foreach ($penulis as $tipe)
                                                        <option value="{{ $tipe->id }}">{{ $tipe->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('penulis_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- TABLE PENGARANG -->
                                        <div class="card mt-3">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Daftar Pengarang</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Pengarang</th>
                                                                <th>Kategori</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listPengarang as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['nama'] }}</td>
                                                                    <td>{{ $data['kategori'] }}</td>
                                                                    <td>
                                                                                   <button class="btn btn-danger btn-sm"
                wire:click="HapusPengarang({{ $index }})">
                Hapus
            </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB SUBYEK -->

                            <div class="tab-pane fade @if ($activeTab == 'pills-kartu') show active @endif"
                                id="pills-kartu" role="tabpanel" tabindex="0">

                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <div class="">
                                            <h4 class="card-title mb-2">Subyek</h4>
                                            <div>
                                                <div class="mb-3 d-flex justify-content-between">
                                                    <input type="text"
                                                        class="form-control w-75 @error('subyek.nama_topik') is-invalid @enderror"
                                                        wire:model="subyek.nama_topik">

                                                    <select
                                                        class="form-control w-75 @error('subyek.kategori_topik') is-invalid @enderror"
                                                        wire:model="subyek.kategori_topik">
                                                        <option value="">-- Pilih Topik --</option>
                                                        <option value="Primary">Primary</option>
                                                        <option value="Additional">Additional</option>
                                                    </select>

                                                    <button type="button" wire:click="Tambahsubyek"
                                                        class="btn btn-dark btn-sm">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 p-3 border rounded">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Subyek</label>
                                                <select class="form-select @error('subyek_id') is-invalid @enderror"
                                                    wire:model.defer="subyek_id">
                                                    <option value="">Pilih Subyek / Topik</option>
                                                    @foreach ($topik as $tipe)
                                                        <option value="{{ $tipe->id }}">{{ $tipe->nama_topik }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- TABLE SUBYEK -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Daftar Subyek</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Subyek</th>
                                                                <th>Kategori</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listsubyek as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['nama_topik'] }}</td>
                                                                    <td>{{ $data['kategori_topik'] }}</td>
                                                                    <td>
                                                                        <button
                                                                            wire:click="removesubyek({{ $index }})"
                                                                            class="btn btn-outline-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB LAMPIRAN -->

                            <div class="tab-pane fade @if ($activeTab == 'pills-riwayat') show active @endif"
                                id="pills-riwayat" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <div class="d-flex gap-5">
                                            <h4 class="card-title mb-0">Lampiran</h4>
                                        </div>


                                        <div class="mt-3 p-3 border rounded">
                                            <div class="mb-3">
                                                <label class="form-label">Judul</label>
                                                <input type="text"
                                                    class="form-control @error('lampiran.judul') is-invalid @enderror"
                                                    wire:model.defer="lampiran.judul">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama file</label>
                                                <input type="file"
                                                    class="form-control @error('lampiranFile') is-invalid @enderror"
                                                    wire:model="lampiranFile">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" style="height: 200px" wire:model.defer="lampiran.deskripsi"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tipe Akses</label>
                                                <select class="form-select" wire:model.defer="lampiran.tipe_akses">
                                                    <option value="">Pilih Tipe Akses</option>
                                                    <option value="private">Private</option>
                                                    <option value="public">Public</option>
                                                </select>
                                            </div>

                                            <button type="button" wire:click="TambahLampiran"
                                                class="btn btn-dark btn-sm">
                                                <i class="fa fa-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <!-- TABLE LAMPIRAN -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Daftar Lampiran</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Judul File</th>
                                                                <th>Tipe File</th>
                                                                <th>Tipe Akses</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listLampiran as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>

                                                                    {{-- Judul File --}}
                                                                    <td>{{ $data['judul'] }}</td>

                                                                    {{-- Tipe File --}}
                                                                    <td>
                                                                        @php
                                                                            // Ambil ekstensi file: pdf, docx, png, dll
                                                                            $tipe = $data['nama_file']
                                                                                ? pathinfo(
                                                                                    $data['nama_file'],
                                                                                    PATHINFO_EXTENSION,
                                                                                )
                                                                                : '-';
                                                                        @endphp

                                                                        {{ $tipe }}
                                                                    </td>

                                                                    {{-- Tipe Akses --}}
                                                                    <td>{{ ucfirst($data['tipe_akses']) }}</td>

                                                                    {{-- Tombol Kelola --}}
                                                                    <td>
                                                                        {{-- Tombol lihat file jika ada --}}
                                                                        @if (!empty($data['nama_file']))
                                                                            <a href="{{ Storage::url($data['nama_file']) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-primary btn-sm">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>
                                                                        @endif

                                                                        {{-- Tombol hapus --}}
                                                                        <button
                                                                            wire:click="removeLampiran({{ $index }})"
                                                                            class="btn btn-outline-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>



                                                    </table>
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB ITEM -->

                            <div class="tab-pane fade @if ($activeTab == 'pills-item') show active @endif"
                                id="pills-item" role="tabpanel" tabindex="0">

                                <div class="card border shadow-sm rounded-3">

                                    <div class="modal-body">

                                        <ul class="nav nav-pills my-2" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link {{ $tabActive === 'pills-summary' ? 'active' : '' }}"
                                                    wire:click.prevent="setActiveTab('pills-summary')">
                                                    Detail
                                                </button>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link {{ $tabActive === 'pills-proses' ? 'active' : '' }}"
                                                    wire:click.prevent="setActiveTab('pills-proses')">
                                                    Info
                                                </button>
                                            </li>
                                        </ul>

                                        {{-- Beri tabel dengan kolom kode item , lokasi , tipe koleksi , kelola --}}

                                        <!-- TABLE ITEMS -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Daftar Item</h5>
                                            </div>

                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kode Item</th>
                                                                <th>Lokasi</th>
                                                                <th>Tipe Koleksi</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listItem as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['kode_item'] }}</td>
                                                                    <td>{{ $data['lokasi_id'] }}</td>
                                                                    <td>{{ $data['tipe_koleksi_id'] }}</td>
                                                                    <td>
                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            wire:click="hapusItem({{ $index }})">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- TAB DETAIL FORM -->
                                        <div class="tab-content" id="pills-tabContent">

                                            <div class="tab-pane fade {{ $tabActive === 'pills-summary' ? 'show active' : '' }}"
                                                id="pills-summary" role="tabpanel">

                                                <div class="card border shadow-sm rounded-3">
                                                    <div class="card-body p-4">

                                                        <div class="mb-3">
                                                            <label class="form-label">Kode Item</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.kode_item">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Call Number</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.call_number">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Kode Inventori</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.kode_inventori">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Lokasi</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.lokasi_id">
                                                                <option value="">Pilih Lokasi</option>
                                                                @foreach ($tipe_lokasi as $tipe)
                                                                    <option value="{{ $tipe->kode_lokasi }}">
                                                                        {{ $tipe->nama_lokasi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Rak</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.rak_id">
                                                                <option value="">Pilih Rak</option>
                                                                @foreach ($tipe_rak as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_rak }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tipe Koleksi</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.tipe_koleksi_id">
                                                                <option value="">Pilih Tipe Koleksi</option>
                                                                @foreach ($tipe_koleksi as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_tipe_koleksi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Status Item</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.status_id">
                                                                <option value="">Pilih Status Item</option>
                                                                @foreach ($tipe_status as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TAB INFO -->
                                            <div class="tab-pane fade {{ $tabActive === 'pills-proses' ? 'show active' : '' }}"
                                                id="pills-proses" role="tabpanel">

                                                <div class="card border shadow-sm rounded-3">
                                                    <div class="card-body p-4">

                                                        <div class="mb-3">
                                                            <label class="form-label">Nomor Order</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.nmr_order">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Order</label>
                                                            <input type="date" class="form-control"
                                                                wire:model.defer="item.tgl_order">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Penerimaan</label>
                                                            <input type="date" class="form-control"
                                                                wire:model.defer="item.tgl_penerimaan">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Invoice</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.invoice">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Supplier</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.supplier_id">
                                                                <option value="">Pilih Supplier</option>
                                                                @foreach ($tipe_supplier as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_supplier }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Sumber</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.source">
                                                                <option value="">Pilih Sumber</option>
                                                                <option value="beli">Beli</option>
                                                                <option value="priz_grant">Prize/Grant</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Invoice</label>
                                                            <input type="date" class="form-control"
                                                                wire:model.defer="item.tgl_invoice">
                                                        </div>

                                                        <div class="mb-3 d-flex gap-5">
                                                            <div>
                                                                <label class="form-label">Harga</label>
                                                                <input type="number" class="form-control"
                                                                    wire:model.defer="item.harga">
                                                            </div>

                                                            <div>
                                                                <label class="form-label">Mata Uang</label>
                                                                <select class="form-select"
                                                                    wire:model.defer="item.harga_currency">
                                                                    <option value="">Pilih Mata Uang</option>
                                                                    <option value="rupiah">Rupiah</option>
                                                                    <option value="us_dollar">US Dollar</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    wire:model.defer="item.is_fotocopy">
                                                                <label class="form-check-label">Fotocopy</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" wire:click="TambahItem"
                                                class="btn btn-dark btn-sm mt-3">
                                                <i class="fa fa-plus"></i> Tambah
                                            </button>

                                        </div>
                                    </div>

                                </div>

                                <div class="card-body p-4">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if (session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Tab Catatan -->
                            <div class="tab-pane fade  @if ($activeTab == 'pills-catatan') show active @endif"
                                id="pills-catatan" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Catatan</h4>
                                    </div>
                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        <label for="" class="mb-2">Spesifik Info :</label>
                                        <div class="form-floating @error('spec_detail_info') is-invalid @enderror">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"
                                                wire:model.defer="spec_detail_info"></textarea>
                                        </div>
                                        @error('spec_detail_info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <label for="" class="mb-2">Abstrak/Catatan :</label>
                                        <div class="form-floating @error('catatan') is-invalid @enderror">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"
                                                wire:model.defer="catatan"></textarea>
                                        </div>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Simpan</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Bibliografi -->
    <div wire:ignore.self class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <form wire:submit.prevent="UpdateBibliografi" enctype="multipart/form-data">
                    <div class="modal-header" style="background:#141927; color:#fff;">
                        <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Bibliografi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                wire:model.defer="judul">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex gap-5">
                            <div>
                                <label class="form-label">Gmd</label>
                                <select class="form-select @error('gmd_id') is-invalid @enderror"
                                    wire:model.defer="gmd_id">
                                    <option value="">Pilih GMD</option>
                                    @foreach ($tipe_gmd as $tipe)
                                        <option value="{{ $tipe->id }}">{{ $tipe->nama_gmd }}</option>
                                    @endforeach
                                </select>
                                @error('gmd_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Tipe Koleksi</label>
                                <select class="form-select @error('tipe_koleksi_id') is-invalid @enderror"
                                    wire:model.defer="tipe_koleksi_id">
                                    <option value="">Pilih Tipe Koleksi</option>
                                    @foreach ($tipe_koleksi as $tipe)
                                        <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe_koleksi }}</option>
                                    @endforeach
                                </select>
                                @error('tipe_koleksi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Seri</label>
                            <input type="text" class="form-control @error('judul_seri') is-invalid @enderror"
                                wire:model.defer="judul_seri">
                            @error('judul_seri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penerbit</label>
                            <select class="form-select @error('penerbit_id') is-invalid @enderror"
                                wire:model="penerbit_id">
                                  <option value="">Pilih Penerbit</option>
                                @foreach ($penerbit as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_penerbit }}</option>
                                @endforeach
                            </select>
                            @error('penerbit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="pills-penomoran" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-header">
                                    <h4 class="card-title mb-3">Tambah Penerbit Baru</h4>

                                    <div class="row g-2 align-items-center mb-3">
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('nama_penerbit') is-invalid @enderror"
                                                placeholder="Nama Penerbit" wire:model="nama_penerbit">
                                            @error('nama_penerbit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <select class="form-select @error('tempat_id') is-invalid @enderror"
                                                wire:model="tempat_id">
                                                <option value="">Pilih Tempat Penerbit</option>
                                                @foreach ($tempat as $t)
                                                    <option wire:key="tempat-{{ $t->id }}"
                                                        value="{{ $t->id }}">{{ $t->nama_tempat }}</option>
                                                @endforeach
                                            </select>
                                            @error('tempat_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="TambahPenerbitLangsung">
                                            <i class="fa fa-plus"></i> Tambah Penerbit
                                        </button>
                                    </div>
                                </div>

                                <div class="card-header mt-4">
                                    <h4 class="card-title mb-3">Tambah Tempat Baru</h4>

                                    <div class="row g-2 align-items-center mb-3">
                                        <div class="col-md-12">
                                            <input type="text"
                                                class="form-control @error('nama_tempat') is-invalid @enderror"
                                                placeholder="Nama Tempat Penerbit" wire:model="nama_tempat">
                                            @error('nama_tempat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="button" class="btn btn-dark"
                                            wire:click="TambahTempatLangsung">
                                            <i class="fa fa-plus"></i> Tambah Tempat Baru
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if (session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex gap-5">
                            <div>
                                <label class="form-label">Tahun terbit</label>
                                <input type="text" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                    wire:model.defer="tahun_terbit">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-sistem') active @endif"
                                    wire:click="setTab('pills-sistem')" id="pills-sistem-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-sistem" type="button" role="tab"
                                    aria-controls="pills-sistem" aria-selected="true">Detail</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-penomoran') active @endif"
                                    wire:click="setTab('pills-penomoran')" id="pills-penomoran-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-penomoran" type="button"
                                    role="tab" aria-controls="pills-penomoran"
                                    aria-selected="false">Pengarang</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-kartu') active @endif"
                                    wire:click="setTab('pills-kartu')" id="pills-kartu-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-kartu" type="button" role="tab"
                                    aria-controls="pills-kartu" aria-selected="false">Subyek</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-riwayat') active @endif"
                                    wire:click="setTab('pills-riwayat')" id="pills-riwayat-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-riwayat" type="button" role="tab"
                                    aria-controls="pills-riwayat" aria-selected="false">Lampiran</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-item') active @endif"
                                    wire:click="setTab('pills-item')" id="pills-item-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-item" type="button" role="tab"
                                    aria-controls="pills-item" aria-selected="false">Item</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($activeTab == 'pills-catatan') active @endif"
                                    wire:click="setTab('pills-catatan')" id="pills-catatan-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-catatan" type="button" role="tab"
                                    aria-controls="pills-catatan" aria-selected="false">Catatan</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <!-- Tab Detail -->
                            <div class="tab-pane fade  @if ($activeTab == 'pills-sistem') show active @endif"
                                id="pills-sistem" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Detail</h4>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label">Edisi</label>
                                            <input type="text"
                                                class="form-control @error('edisi') is-invalid @enderror"
                                                wire:model.defer="edisi">
                                            @error('edisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Frekuensi</label>
                                            <select class="form-select @error('frekuensi_id') is-invalid @enderror"
                                                wire:model.defer="frekuensi_id">
                                                <option value="">Pilih Frekuensi</option>
                                                @foreach ($frekuensi as $tipe)
                                                    <option value="{{ $tipe->id }}">{{ $tipe->frekuensi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('frekuensi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Volume</label>
                                            <input type="text"
                                                class="form-control @error('volume') is-invalid @enderror"
                                                wire:model.defer="volume">
                                            @error('volume')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ISBN/ISSN</label>
                                            <input type="text"
                                                class="form-control @error('isbn_issn') is-invalid @enderror"
                                                wire:model.defer="isbn_issn">
                                            @error('isbn_issn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bahasa</label>
                                            <select class="form-select @error('bahasa_id') is-invalid @enderror"
                                                wire:model.defer="bahasa_id">
                                                <option value="">Pilih Bahasa</option>
                                                @foreach ($bahasa as $tipe)
                                                    <option value="{{ $tipe->kode_bahasa }}">{{ $tipe->nama_bahasa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bahasa_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Klasifikasi</label>
                                            <input type="text"
                                                class="form-control @error('klasifikasi') is-invalid @enderror"
                                                wire:model.defer="klasifikasi">
                                            @error('klasifikasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Call Number</label>
                                            <input type="text"
                                                class="form-control @error('call_number') is-invalid @enderror"
                                                wire:model.defer="call_number">
                                            @error('call_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Collation</label>
                                            <input type="text"
                                                class="form-control @error('collation') is-invalid @enderror"
                                                wire:model.defer="collation">
                                            @error('collation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.defer="is_etalase_hide">
                                                <label>Hide in OPAC</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.defer="is_promosi">
                                                <label>Is Promoted</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gambar</label>
                                            <input type="file"
                                                class="form-control @error('gambarFile') is-invalid @enderror"
                                                wire:model="gambarFile">
                                            @error('gambarFile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Pengarang -->
                            <div class="tab-pane fade @if ($activeTab == 'pills-penomoran') show active @endif"
                                id="pills-penomoran" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <div class="">
                                            <h4 class="card-title mb-2">Pengarang</h4>
                                            <div>
                                                <div class="mb-3 d-flex justify-content-between">
                                                    <input type="text"
                                                        class="form-control w-75 @error('pengarang.nama') is-invalid @enderror"
                                                        wire:model.defer="pengarang.nama">
                                                    @error('pengarang.nama')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    <select
                                                        class="form-control w-75 @error('pengarang.kategori') is-invalid @enderror"
                                                        wire:model.defer="pengarang.kategori">
                                                        <option value="">-- Pilih Peran --</option>
                                                        <option value="Primary Author">Primary Author</option>
                                                        <option value="Additional Author">Additional Author</option>
                                                        <option value="Editor">Editor</option>
                                                        <option value="Translator">Translator</option>
                                                        <option value="Director">Director</option>
                                                        <option value="Producer">Producer</option>
                                                        <option value="Composer">Composer</option>
                                                        <option value="Illustrator">Illustrator</option>
                                                        <option value="Creator">Creator</option>
                                                        <option value="Contributor">Contributor</option>
                                                    </select>

                                                    <button type="button" class="btn btn-dark btn-sm"
                                                        wire:click="TambahPengarang">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 p-3 border rounded">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Nama</label>
                                                <select class="form-select @error('penulis_id') is-invalid @enderror"
                                                    wire:model="penulis_id">
                                                    <option value="">Pilih Penulis</option>
                                                    @foreach ($penulis as $tipe)
                                                        <option value="{{ $tipe->id }}">{{ $tipe->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('penulis_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- TABLE PENGARANG -->
                                        <div class="card mt-3">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Daftar Pengarang</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Pengarang</th>
                                                                <th>Kategori</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listPengarang as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['nama'] }}</td>
                                                                    <td>{{ $data['kategori'] }}</td>
                                                                    <td>
                                                                        <button
                                                                            wire:click="removePengarang({{ $index }})"
                                                                            class="btn btn-outline-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB SUBYEK -->

                            <div class="tab-pane fade @if ($activeTab == 'pills-kartu') show active @endif"
                                id="pills-kartu" role="tabpanel" tabindex="0">

                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <div class="">
                                            <h4 class="card-title mb-2">Subyek</h4>
                                            <div>
                                                <div class="mb-3 d-flex justify-content-between">
                                                    <input type="text"
                                                        class="form-control w-75 @error('subyek.nama_topik') is-invalid @enderror"
                                                        wire:model="subyek.nama_topik">

                                                    <select
                                                        class="form-control w-75 @error('subyek.kategori_topik') is-invalid @enderror"
                                                        wire:model="subyek.kategori_topik">
                                                        <option value="">-- Pilih Topik --</option>
                                                        <option value="Primary">Primary</option>
                                                        <option value="Additional">Additional</option>
                                                    </select>

                                                    <button type="button" wire:click="Tambahsubyek"
                                                        class="btn btn-dark btn-sm">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 p-3 border rounded">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Subyek</label>
                                                <select class="form-select @error('subyek_id') is-invalid @enderror"
                                                    wire:model.defer="subyek_id">
                                                    <option value="">Pilih Subyek / Topik</option>
                                                    @foreach ($topik as $tipe)
                                                        <option value="{{ $tipe->id }}">{{ $tipe->nama_topik }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- TABLE SUBYEK -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Daftar Subyek</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Subyek</th>
                                                                <th>Kategori</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listsubyek as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['nama_topik'] }}</td>
                                                                    <td>{{ $data['kategori_topik'] }}</td>
                                                                    <td>
                                                                        <button
                                                                            wire:click="removesubyek({{ $index }})"
                                                                            class="btn btn-outline-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB LAMPIRAN -->

                            <div class="tab-pane fade @if ($activeTab == 'pills-riwayat') show active @endif"
                                id="pills-riwayat" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <div class="d-flex gap-5">
                                            <h4 class="card-title mb-0">Lampiran</h4>
                                        </div>


                                        <div class="mt-3 p-3 border rounded">
                                            <div class="mb-3">
                                                <label class="form-label">Judul</label>
                                                <input type="text"
                                                    class="form-control @error('lampiran.judul') is-invalid @enderror"
                                                    wire:model.defer="lampiran.judul">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama file</label>
                                                <input type="file"
                                                    class="form-control @error('lampiranFile') is-invalid @enderror"
                                                    wire:model="lampiranFile">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" style="height: 200px" wire:model.defer="lampiran.deskripsi"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tipe Akses</label>
                                                <select class="form-select" wire:model.defer="lampiran.tipe_akses">
                                                    <option value="">Pilih Tipe Akses</option>
                                                    <option value="private">Private</option>
                                                    <option value="public">Public</option>
                                                </select>
                                            </div>

                                            <button type="button" wire:click="TambahLampiran"
                                                class="btn btn-dark btn-sm">
                                                <i class="fa fa-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <!-- TABLE LAMPIRAN -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Daftar Lampiran</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Judul File</th>
                                                                <th>Tipe File</th>
                                                                <th>Tipe Akses</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listLampiran as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>

                                                                    {{-- Judul File --}}
                                                                    <td>{{ $data['judul'] }}</td>

                                                                    {{-- Tipe File --}}
                                                                    <td>
                                                                        @php
                                                                            // Ambil ekstensi file: pdf, docx, png, dll
                                                                            $tipe = $data['nama_file']
                                                                                ? pathinfo(
                                                                                    $data['nama_file'],
                                                                                    PATHINFO_EXTENSION,
                                                                                )
                                                                                : '-';
                                                                        @endphp

                                                                        {{ $tipe }}
                                                                    </td>

                                                                    {{-- Tipe Akses --}}
                                                                    <td>{{ ucfirst($data['tipe_akses']) }}</td>

                                                                    {{-- Tombol Kelola --}}
                                                                    <td>
                                                                        {{-- Tombol lihat file jika ada --}}
                                                                        @if (!empty($data['nama_file']))
                                                                            <a href="{{ Storage::url($data['nama_file']) }}"
                                                                                target="_blank"
                                                                                class="btn btn-outline-primary btn-sm">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>
                                                                        @endif

                                                                        {{-- Tombol hapus --}}
                                                                        <button
                                                                            wire:click="removeLampiran({{ $index }})"
                                                                            class="btn btn-outline-danger btn-sm">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>



                                                    </table>
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB ITEM -->

                            <div class="tab-pane fade @if ($activeTab == 'pills-item') show active @endif"
                                id="pills-item" role="tabpanel" tabindex="0">

                                <div class="card border shadow-sm rounded-3">

                                    <div class="modal-body">

                                        <ul class="nav nav-pills my-2" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link {{ $tabActive === 'pills-summary' ? 'active' : '' }}"
                                                    wire:click.prevent="setActiveTab('pills-summary')">
                                                    Detail
                                                </button>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link {{ $tabActive === 'pills-proses' ? 'active' : '' }}"
                                                    wire:click.prevent="setActiveTab('pills-proses')">
                                                    Info
                                                </button>
                                            </li>
                                        </ul>

                                        {{-- Beri tabel dengan kolom kode item , lokasi , tipe koleksi , kelola --}}

                                        <!-- TABLE ITEMS -->
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">Daftar Item</h5>
                                            </div>

                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kode Item</th>
                                                                <th>Lokasi</th>
                                                                <th>Tipe Koleksi</th>
                                                                <th>Kelola</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($listItem as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['kode_item'] }}</td>
                                                                    <td>{{ $data['lokasi_id'] }}</td>
                                                                    <td>{{ $data['tipe_koleksi_id'] }}</td>
                                                                    <td>
                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            wire:click="hapusItem({{ $index }})">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- TAB DETAIL FORM -->
                                        <div class="tab-content" id="pills-tabContent">

                                            <div class="tab-pane fade {{ $tabActive === 'pills-summary' ? 'show active' : '' }}"
                                                id="pills-summary" role="tabpanel">

                                                <div class="card border shadow-sm rounded-3">
                                                    <div class="card-body p-4">

                                                        <div class="mb-3">
                                                            <label class="form-label">Kode Item</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.kode_item">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Call Number</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.call_number">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Kode Inventori</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.kode_inventori">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Lokasi</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.lokasi_id">
                                                                <option value="">Pilih Lokasi</option>
                                                                @foreach ($tipe_lokasi as $tipe)
                                                                    <option value="{{ $tipe->kode_lokasi }}">
                                                                        {{ $tipe->nama_lokasi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Rak</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.rak_id">
                                                                <option value="">Pilih Rak</option>
                                                                @foreach ($tipe_rak as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_rak }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tipe Koleksi</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.tipe_koleksi_id">
                                                                <option value="">Pilih Tipe Koleksi</option>
                                                                @foreach ($tipe_koleksi as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_tipe_koleksi }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Status Item</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.status_id">
                                                                <option value="">Pilih Status Item</option>
                                                                @foreach ($tipe_status as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_status }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- TAB INFO -->
                                            <div class="tab-pane fade {{ $tabActive === 'pills-proses' ? 'show active' : '' }}"
                                                id="pills-proses" role="tabpanel">

                                                <div class="card border shadow-sm rounded-3">
                                                    <div class="card-body p-4">

                                                        <div class="mb-3">
                                                            <label class="form-label">Nomor Order</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.nmr_order">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Order</label>
                                                            <input type="date" class="form-control"
                                                                wire:model.defer="item.tgl_order">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Penerimaan</label>
                                                            <input type="date" class="form-control"
                                                                wire:model.defer="item.tgl_penerimaan">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Invoice</label>
                                                            <input type="text" class="form-control"
                                                                wire:model.defer="item.invoice">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Supplier</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.supplier_id">
                                                                <option value="">Pilih Supplier</option>
                                                                @foreach ($tipe_supplier as $tipe)
                                                                    <option value="{{ $tipe->id }}">
                                                                        {{ $tipe->nama_supplier }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Sumber</label>
                                                            <select class="form-select"
                                                                wire:model.defer="item.source">
                                                                <option value="">Pilih Sumber</option>
                                                                <option value="beli">Beli</option>
                                                                <option value="priz_grant">Prize/Grant</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Invoice</label>
                                                            <input type="date" class="form-control"
                                                                wire:model.defer="item.tgl_invoice">
                                                        </div>

                                                        <div class="mb-3 d-flex gap-5">
                                                            <div>
                                                                <label class="form-label">Harga</label>
                                                                <input type="number" class="form-control"
                                                                    wire:model.defer="item.harga">
                                                            </div>

                                                            <div>
                                                                <label class="form-label">Mata Uang</label>
                                                                <select class="form-select"
                                                                    wire:model.defer="item.harga_currency">
                                                                    <option value="">Pilih Mata Uang</option>
                                                                    <option value="rupiah">Rupiah</option>
                                                                    <option value="us_dollar">US Dollar</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    wire:model.defer="item.is_fotocopy">
                                                                <label class="form-check-label">Fotocopy</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" wire:click="TambahItem"
                                                class="btn btn-dark btn-sm mt-3">
                                                <i class="fa fa-plus"></i> Tambah
                                            </button>

                                        </div>
                                    </div>

                                </div>

                                <div class="card-body p-4">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if (session()->has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Tab Catatan -->
                            <div class="tab-pane fade  @if ($activeTab == 'pills-catatan') show active @endif"
                                id="pills-catatan" role="tabpanel" tabindex="0">
                                <div class="card border shadow-sm rounded-3">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Catatan</h4>
                                    </div>
                                    <div class="card-body p-4">
                                        @if (session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        @if (session()->has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show"
                                                role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif
                                        <label for="" class="mb-2">Spesifik Info :</label>
                                        <div class="form-floating @error('spec_detail_info') is-invalid @enderror">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"
                                                wire:model.defer="spec_detail_info"></textarea>
                                        </div>
                                        @error('spec_detail_info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <label for="" class="mb-2">Abstrak/Catatan :</label>
                                        <div class="form-floating @error('catatan') is-invalid @enderror">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"
                                                wire:model.defer="catatan"></textarea>
                                        </div>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Update</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 text-center">
                <div class="modal-header border-0" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size:3rem;"></i>
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="destroy()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    // Saat modal ADD dibuka → reset
    var modalAdd = document.getElementById('addMemberModal');
    modalAdd.addEventListener('show.bs.modal', function () {
        Livewire.dispatch('resetAddModal');
    });

    // Saat modal EDIT dibuka → reset dulu juga
    var modalEdit = document.getElementById('editMemberModal');
    modalEdit.addEventListener('show.bs.modal', function () {
        Livewire.dispatch('resetAddModal');
    });
});
</script> --}}


</div>
