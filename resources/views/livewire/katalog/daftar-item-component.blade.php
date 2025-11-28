<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Daftar Item</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="exportExcel" data-bs-toggle="modal"
                        data-bs-target="#export">
                        Export (XLS) Data Induk Buku
                    </button>
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addDaftarModal">
                        Tambah
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
                                <th>Informasi Tambahan</th>
                                <th>Informasi Order</th>
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
                                                class="w-16 h-16 object-cover rounded">
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        Kode Item : {{ $item->kode_item }} <br>
                                        Judul : {{ $item->bibliografi->judul }} <br>
                                        Penulis : {{ $item->bibliografi->penulis->first()?->nama }} <br>
                                        Penerbit : {{ $item->bibliografi->penerbit->nama_penerbit }} <br>
                                        ISBN / ISSN : {{ $item->bibliografi->isbn_issn }}
                                    </td>

                                    <td>
                                        Tipe Koleksi : {{ $item->tipeKoleksi->nama_tipe_koleksi }} <br>
                                        Klasifikasi : {{ $item->bibliografi->klasifikasi }} <br>
                                        Lokasi : {{ $item->lokasi->nama_lokasi }} <br>
                                        Rak : {{ $item->rak->nama_rak }}
                                    </td>

                                    <td>
                                        Tanggal Order :
                                        {{ $item->tgl_order ? $item->tgl_order->format('d-m-Y') : '-' }}
                                        <br>

                                        Tanggal Penerimaan :
                                        {{ $item->tgl_penerimaan ? $item->tgl_penerimaan->format('d-m-Y') : '-' }}
                                        <br>

                                        Source :
                                        {{ $item->source ?? '-' }}
                                        <br>

                                        Harga :
                                        Rp {{ number_format($item->harga, 2, ',', '.') }}
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId('{{ $item->kode_item }}')" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId('{{ $item->kode_item }}')" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmModal">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data item.</td>
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


    <!-- ==================== MODALS ==================== -->
    <!-- Modal Create Daftar Item -->
    <div wire:ignore.self class="modal fade" id="addDaftarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Tambah Daftar Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills my-2" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'pills-summary' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('pills-summary')" id="pills-summary-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab"
                                aria-controls="pills-summary" aria-selected="false">
                                Detail
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'pills-proses' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('pills-proses')" summaryid="pills-proses-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-proses" type="button" role="tab"
                                aria-controls="pills-proses" aria-selected="true">
                                Info
                            </button>
                        </li>
                    </ul>

                    <!-- Konten Tab -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Tab Detail -->
                        <div class="tab-pane fade {{ $activeTab === 'pills-summary' ? 'show active' : '' }}"
                            id="pills-summary" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <form wire:submit.prevent="store" id="additemForm">
                                        <div class="mb-3">
                                            <label class="form-label">Judul</label>
                                            <select class="form-select @error('bibliografi_id') is-invalid @enderror"
                                                wire:model.defer="bibliografi_id">
                                                <option value="">Pilih Judul</option>
                                                @foreach ($bibliografi as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->judul }}</option>
                                                @endforeach
                                            </select>
                                            @error('bibliografi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Kode Item</label>
                                            <input type="text"
                                                class="form-control @error('kode_item') is-invalid @enderror"
                                                wire:model.defer="kode_item">
                                            @error('kode_item')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Call Number</label>
                                            <input type="text"
                                                class="form-control @error('call_number') is-invalid @enderror"
                                                wire:model.defer="call_number">
                                            @error('call_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Kode Inventori</label>
                                            <input type="text"
                                                class="form-control @error('kode_inventori') is-invalid @enderror"
                                                wire:model.defer="kode_inventori">
                                            @error('kode_inventori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <select class="form-select @error('lokasi_id') is-invalid @enderror"
                                                wire:model.defer="lokasi_id">
                                                <option value="">Pilih Lokasi</option>
                                                @foreach ($tipe_lokasi as $tipe)
                                                    <option value="{{ $tipe->kode_lokasi }}">
                                                        {{ $tipe->nama_lokasi }}</option>
                                                @endforeach
                                            </select>
                                            @error('lokasi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rak</label>
                                            <select class="form-select @error('rak_id') is-invalid @enderror"
                                                wire:model.defer="rak_id">
                                                <option value="">Pilih Rak</option>
                                                @foreach ($tipe_rak as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->nama_rak }}</option>
                                                @endforeach
                                            </select>
                                            @error('rak_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tipe Koleksi</label>
                                            <select class="form-select @error('tipe_koleksi_id') is-invalid @enderror"
                                                wire:model.defer="tipe_koleksi_id">
                                                <option value="">Pilih Tipe Koleksi</option>
                                                @foreach ($tipe_koleksi as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->nama_tipe_koleksi }}</option>
                                                @endforeach
                                            </select>
                                            @error('tipe_koleksi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status Item</label>
                                            <select class="form-select @error('status_id') is-invalid @enderror"
                                                wire:model.defer="status_id">
                                                <option value="">Pilih Status Item</option>
                                                @foreach ($tipe_status as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->nama_status }}</option>
                                                @endforeach
                                            </select>
                                            @error('status_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Info -->
                        <div class="tab-pane fade {{ $activeTab === 'pills-proses' ? 'show active' : '' }}"
                            id="pills-proses" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="mb-3 row">
                                        <label class="form-label">Nomor Order</label>
                                        <input type="text"
                                            class="form-control @error('nmr_order') is-invalid @enderror"
                                            wire:model.defer="nmr_order">
                                        @error('nmr_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Tanggal Order</label>
                                        <input type="date"
                                            class="form-control @error('tgl_order') is-invalid @enderror"
                                            wire:model.defer="tgl_order">
                                        @error('tgl_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Tanggal Penerimaan</label>
                                        <input type="date"
                                            class="form-control @error('tgl_penerimaan') is-invalid @enderror"
                                            wire:model.defer="tgl_penerimaan">
                                        @error('tgl_penerimaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Invoice</label>
                                        <input type="text"
                                            class="form-control @error('invoice') is-invalid @enderror"
                                            wire:model.defer="invoice">
                                        @error('invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select class="form-select @error('supplier_id') is-invalid @enderror"
                                            wire:model.defer="supplier_id">
                                            <option value="">Pilih Supplier</option>
                                            @foreach ($tipe_supplier as $tipe)
                                                <option value="{{ $tipe->id }}">
                                                    {{ $tipe->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sumber</label>
                                        <select class="form-select @error('source') is-invalid @enderror"
                                            wire:model.defer="source">
                                            <option value="">Pilih Sumber</option>
                                            <option value="beli">
                                                Beli
                                            </option>
                                            <option value="priz_grant">
                                                Prize/Grant
                                            </option>
                                        </select>
                                        @error('source')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Tanggal Invoice</label>
                                        <input type="date"
                                            class="form-control @error('tgl_invoice') is-invalid @enderror"
                                            wire:model.defer="tgl_invoice">
                                        @error('tgl_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 d-flex gap-5">
                                        <div>
                                            <label class="form-label">Harga</label>
                                            <input type="number"
                                                class="form-control @error('harga') is-invalid @enderror"
                                                wire:model.defer="harga">
                                            @error('harga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="form-label">Mata Uang</label>
                                            <select class="form-select @error('harga_currency') is-invalid @enderror"
                                                wire:model.defer="harga_currency">
                                                <option value="">Pilih Mata Uang</option>
                                                <option value="rupiah">
                                                    Rupiah
                                                </option>
                                                <option value="us_dollar">
                                                    US Dollar
                                                </option>
                                            </select>
                                            @error('harga_currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="form-check"><input type="checkbox" class="form-check-input"
                                                wire:model.defer="is_fotocopy"> <label>Fotocopy</label>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="additemForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ==================== MODALS ==================== -->
    <!-- Modal Edit Daftar Item -->
    <div wire:ignore.self class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Aturan Peminjaman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills my-2" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'pills-summary' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('pills-summary')" id="pills-summary-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab"
                                aria-controls="pills-summary" aria-selected="false">
                                Detail
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'pills-proses' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('pills-proses')" summaryid="pills-proses-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-proses" type="button" role="tab"
                                aria-controls="pills-proses" aria-selected="true">
                                Info
                            </button>
                        </li>
                    </ul>

                    <!-- Konten Tab -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Tab Detail -->
                        <div class="tab-pane fade {{ $activeTab === 'pills-summary' ? 'show active' : '' }}"
                            id="pills-summary" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <form wire:submit.prevent="update" id="editMemberForm">
                                        <div class="mb-3">
                                            <label class="form-label">Judul</label>
                                            <select class="form-select @error('bibliografi_id') is-invalid @enderror"
                                                wire:model.defer="bibliografi_id">
                                                <option value="">Pilih Judul</option>
                                                @foreach ($bibliografi as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->judul }}</option>
                                                @endforeach
                                            </select>
                                            @error('bibliografi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Kode Item</label>
                                            <input type="text"
                                                class="form-control @error('kode_item') is-invalid @enderror"
                                                wire:model.defer="kode_item">
                                            @error('kode_item')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Call Number</label>
                                            <input type="text"
                                                class="form-control @error('call_number') is-invalid @enderror"
                                                wire:model.defer="call_number">
                                            @error('call_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Kode Inventori</label>
                                            <input type="text"
                                                class="form-control @error('kode_inventori') is-invalid @enderror"
                                                wire:model.defer="kode_inventori">
                                            @error('kode_inventori')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <select class="form-select @error('lokasi_id') is-invalid @enderror"
                                                wire:model.defer="lokasi_id">
                                                <option value="">Pilih Lokasi</option>
                                                @foreach ($tipe_lokasi as $tipe)
                                                    <option value="{{ $tipe->kode_lokasi }}">
                                                        {{ $tipe->nama_lokasi }}</option>
                                                @endforeach
                                            </select>
                                            @error('lokasi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rak</label>
                                            <select class="form-select @error('rak_id') is-invalid @enderror"
                                                wire:model.defer="rak_id">
                                                <option value="">Pilih Rak</option>
                                                @foreach ($tipe_rak as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->nama_rak }}</option>
                                                @endforeach
                                            </select>
                                            @error('rak_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tipe Koleksi</label>
                                            <select class="form-select @error('tipe_koleksi_id') is-invalid @enderror"
                                                wire:model.defer="tipe_koleksi_id">
                                                <option value="">Pilih Tipe Koleksi</option>
                                                @foreach ($tipe_koleksi as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->nama_tipe_koleksi }}</option>
                                                @endforeach
                                            </select>
                                            @error('tipe_koleksi_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status Item</label>
                                            <select class="form-select @error('status_id') is-invalid @enderror"
                                                wire:model.defer="status_id">
                                                <option value="">Pilih Status Item</option>
                                                @foreach ($tipe_status as $tipe)
                                                    <option value="{{ $tipe->id }}">
                                                        {{ $tipe->nama_status }}</option>
                                                @endforeach
                                            </select>
                                            @error('status_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Info -->
                        <div class="tab-pane fade {{ $activeTab === 'pills-proses' ? 'show active' : '' }}"
                            id="pills-proses" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="mb-3 row">
                                        <label class="form-label">Nomor Order</label>
                                        <input type="text"
                                            class="form-control @error('nmr_order') is-invalid @enderror"
                                            wire:model.defer="nmr_order">
                                        @error('nmr_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Tanggal Order</label>
                                        <input type="date"
                                            class="form-control @error('tgl_order') is-invalid @enderror"
                                            wire:model.defer="tgl_order">
                                        @error('tgl_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Tanggal Penerimaan</label>
                                        <input type="date"
                                            class="form-control @error('tgl_penerimaan') is-invalid @enderror"
                                            wire:model.defer="tgl_penerimaan">
                                        @error('tgl_penerimaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Invoice</label>
                                        <input type="text"
                                            class="form-control @error('invoice') is-invalid @enderror"
                                            wire:model.defer="invoice">
                                        @error('invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <select class="form-select @error('supplier_id') is-invalid @enderror"
                                            wire:model.defer="supplier_id">
                                            <option value="">Pilih Supplier</option>
                                            @foreach ($tipe_supplier as $tipe)
                                                <option value="{{ $tipe->id }}">
                                                    {{ $tipe->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sumber</label>
                                        <select class="form-select @error('source') is-invalid @enderror"
                                            wire:model.defer="source">
                                            <option value="">Pilih Sumber</option>
                                            <option value="beli">
                                                Beli
                                            </option>
                                            <option value="priz_grant">
                                                Prize/Grant
                                            </option>
                                        </select>
                                        @error('source')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Tanggal Invoice</label>
                                        <input type="date"
                                            class="form-control @error('tgl_invoice') is-invalid @enderror"
                                            wire:model.defer="tgl_invoice">
                                        @error('tgl_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 d-flex gap-5">
                                        <div>
                                            <label class="form-label">Harga</label>
                                            <input type="number"
                                                class="form-control @error('harga') is-invalid @enderror"
                                                wire:model.defer="harga">
                                            @error('harga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="form-label">Mata Uang</label>
                                            <select class="form-select @error('harga_currency') is-invalid @enderror"
                                                wire:model.defer="harga_currency">
                                                <option value="">Pilih Mata Uang</option>
                                                <option value="rupiah">
                                                    Rupiah
                                                </option>
                                                <option value="us_dollar">
                                                    US Dollar
                                                </option>
                                            </select>
                                            @error('harga_currency')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="form-check"><input type="checkbox" class="form-check-input"
                                                wire:model.defer="is_fotocopy"> <label>Fotocopy</label>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editMemberForm" class="btn btn-dark">Simpan Perubahan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 text-center">
                <div class="modal-header border-0" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
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
</div>
