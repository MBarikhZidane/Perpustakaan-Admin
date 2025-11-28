<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Stock Opname</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addMemberModal">
                        <i class="fa fa-plus"></i> Tambah
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
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Aktif</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $index => $stock)
                                <tr>
                                    <td>{{ $stocks->firstItem() + $index }}</td>
                                    <td>
                                        {{ $stock->start_date ? \Carbon\Carbon::parse($stock->start_date)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $stock->stock_take_name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($stock->is_active == 1)
                                            <i class="fas fa-check" style="color: green;"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $stock->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="selectDelete({{ $stock->id }})" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmModal">
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
                    {{ $stocks->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- ==================== MODALS ==================== -->
    <!-- Modal Create Member -->
    <div wire:ignore.self class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Stock Opname</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createMemberForm">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control @error('stock_take_name') is-invalid @enderror" wire:model.defer="stock_take_name"
                                rows="3"></textarea>
                            @error('stock_take_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tgl Mulai</label>
                            <input type="text" wire:model.defer="start_date" readonly>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="createMemberForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Member -->
    <div wire:ignore.self class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Aturan Peminjaman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="number" class="form-control @error('stock_take_name') is-invalid @enderror"
                            wire:model.defer="stock_take_name">
                        @error('stock_take_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <ul class="nav nav-pills m-5" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'pills-summary' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('pills-summary')" id="pills-summary-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab"
                                aria-controls="pills-summary" aria-selected="false">
                                Summary
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab === 'pills-proses' ? 'active' : '' }}"
                                wire:click.prevent="setActiveTab('pills-proses')" summaryid="pills-proses-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-proses" type="button" role="tab"
                                aria-controls="pills-proses" aria-selected="true">
                                Proses
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-penyelesaian-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-penyelesaian" type="button" role="tab"
                                aria-controls="pills-penyelesaian" aria-selected="false">
                                Penyelesaian
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-hilang-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-hilang" type="button" role="tab"
                                aria-controls="pills-hilang" aria-selected="false">
                                Daftar Hilang
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-sync-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-sync" type="button" role="tab"
                                aria-controls="pills-sync" aria-selected="false">
                                Sinkronisasi
                            </button>

                        </li>
                    </ul>

                    <!-- Konten Tab -->
                    <div class="tab-content" id="pills-tabContent">

                        <!-- Tab Sistem -->
                        <div class="tab-pane fade {{ $activeTab === 'pills-summary' ? 'show active' : '' }}"
                            id="pills-summary" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <form id="editMemberForm">
                                        <div class="mb-3 row">
                                            <label class="form-label">Tanggal Mulai</label>
                                            <input type="date"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                                wire:model.defer="start_date" readonly>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Tanggal Selesai</label>
                                            <input type="date"
                                                class="form-control @error('end_date') is-invalid @enderror"
                                                wire:model.defer="end_date" readonly>
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Penanggung Jawab</label>
                                            <input type="text"
                                                class="form-control @error('init_user') is-invalid @enderror"
                                                wire:model.defer="init_user" readonly>
                                            @error('init_user')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Total Item Diperiksa</label>
                                            <input type="number"
                                                class="form-control @error('total_item_stocktaked') is-invalid @enderror"
                                                wire:model.defer="total_item_stocktaked" readonly>
                                            @error('total_item_stocktaked')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Total Item Hilang</label>
                                            <input type="number"
                                                class="form-control @error('total_item_lost') is-invalid @enderror"
                                                wire:model.defer="total_item_lost" readonly>
                                            @error('total_item_lost')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Total Item Tersedia</label>
                                            <input type="number"
                                                class="form-control @error('total_item_exists') is-invalid @enderror"
                                                wire:model.defer="total_item_exists" readonly>
                                            @error('total_item_exists')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-label">Total Item Dipinjam</label>
                                            <input type="text"
                                                class="form-control @error('total_item_loan') is-invalid @enderror"
                                                wire:model.defer="total_item_loan" readonly>
                                            @error('total_item_loan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="form-check"><input type="checkbox" class="form-check-input"
                                                    wire:model.defer="is_active" disabled> <label>Is Active</label>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Tab Proses -->
                        <div class="tab-pane fade {{ $activeTab === 'pills-proses' ? 'show active' : '' }}"
                            id="pills-proses" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="col-md-12 mt-5">
                                        <div class="">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div class="mb-3">
                                                    <label for="">Item Code</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Input / Barcode Scanner..."
                                                        wire:model.live.debounce.300ms="searchitem_code">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="">Cari</label>
                                                    <input type="text" class="form-control" placeholder="Cari..."
                                                        wire:model.live.debounce.300ms="searchjudul">
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Kode Item</th>
                                                                    <th>Judul</th>
                                                                    <th>Call Number</th>
                                                                    <th>Tipe Koleksi</th>
                                                                    <th>Klasifikasi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($items as $index => $item)
                                                                    <tr>
                                                                        <td>{{ $items->firstItem() + $index }}</td>
                                                                        <td>
                                                                            {{ $item->kode_item }}
                                                                        </td>
                                                                        <td>{{ $item->bibliografi->judul ?? 'N/A' }}</td>
                                                                        <td>
                                                                            {{ $item->call_number ?? 'N/A' }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item->tipeKoleksi->nama_tipe_koleksi ?? 'N/A' }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item->bibliografi->klasifikasi ?? 'N/A' }}
                                                                        </td>
                                                                          <td>
                                                                            <div class="d-flex gap-1">
                                                                                {{-- untuk hapus Item --}}
                                                                                <button
                                                                                    class="btn btn-outline-danger btn-sm"
                                                                                    wire:click="deletemodal('{{ $item->kode_item }}')"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#deleteConfirm">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">Tidak
                                                                            ada data Item.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-penyelesaian" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <h3>Proses Stock Opname Dinyatakan Selesai</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
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
                    <button type="button" class="btn btn-danger" wire:click="destroy">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="deleteConfirm" tabindex="-1" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" wire:click="destroymodal()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
