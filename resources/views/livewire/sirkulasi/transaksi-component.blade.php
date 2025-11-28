<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Transaksi</h4>
                <div class="d-flex gap-4">
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
                <div class="mb-3" style="position: relative; width:100%;">
                    <input type="text" wire:model.live="carimember" placeholder="Masukkan nama atau ID member..."
                        class="form-control" @if ($selected_member) readonly @endif>

                    <ul class="list-group position-absolute w-100 shadow-sm"
                        style="top:100%; left:0; z-index:1000; max-height:200px; overflow-y:auto;">
                        @foreach ($resultsmember as $member)
                            <li class="list-group-item list-group-item-action"
                                wire:click="selectMember('{{ $member->member_id }}')">
                                {{ $member->member_id }} - {{ $member->nama }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if ($selected_member)
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($activeTab == 'pills-penomoran') active @endif" id="pills-penomoran-tab" data-bs-toggle="pill"
                            wire:click="$set('activeTab', 'pills-penomoran')"
                                data-bs-target="#pills-penomoran" type="button" role="tab"
                                aria-controls="pills-penomoran" aria-selected="false">
                                Peminjaman
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($activeTab == 'pills-kartu') active @endif" id="pills-kartu-tab" data-bs-toggle="pill"
                            wire:click="$set('activeTab', 'pills-kartu')"
                                data-bs-target="#pills-kartu" type="button" role="tab" aria-controls="pills-kartu"
                                aria-selected="false">
                                Pemesanan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($activeTab == 'pills-header') active @endif" id="pills-header-tab" data-bs-toggle="pill"
                            wire:click="$set('activeTab', 'pills-header')"
                                data-bs-target="#pills-header" type="button" role="tab"
                                aria-controls="pills-header" aria-selected="false">
                                Denda
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($activeTab == 'pills-riwayat') active @endif" id="pills-riwayat-tab" data-bs-toggle="pill"
                            wire:click="$set('activeTab', 'pills-riwayat')"
                                data-bs-target="#pills-riwayat" type="button" role="tab"
                                aria-controls="pills-riwayat" aria-selected="false">
                                Riwayat
                            </button>
                        </li>
                    </ul>

                    <!-- Konten Tab -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="d-flex gap-5 align-items-center">
                            <div class="mb-3">
                                <label class="form-label">Nama Member</label>
                                <input type="text" class="form-control @error('reborrow_limit') is-invalid @enderror"
                                    wire:model.defer="reborrow_limit" readonly>
                                @error('reborrow_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ID Member</label>
                                <input type="text" class="form-control @error('reborrow_limit') is-invalid @enderror"
                                    wire:model.defer="reborrow_limit" readonly>
                                @error('reborrow_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3" style="margin-top: 25px">
                                <button type="button" class="btn btn-dark btn-sm" wire:click="create"
                                    data-bs-toggle="modal" data-bs-target="#addDendaModal">
                                    </i> Finish
                                </button>
                            </div>
                        </div>
                        <!-- Tab Penomoran -->
                        <div class="tab-pane fade @if($activeTab == 'pills-penomoran') show active @endif" id="pills-penomoran" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Pinjaman</h4>
                                            <div
                                                class="d-flex gap-4 d-flex justify-content-between align-items-center">
                                                <form wire:submit.prevent="storePeminjaman()" class="d-flex gap-4">
                                                    <div class="mb-3 position-relative" style="width: 300px;">
                                                        <label for="StartDate" class="form-label">Kode Item</label>
                                                        <input type="text" wire:model.live="cariitem"
                                                            placeholder="Masukkan kode item..." class="form-control">
                                                        <ul class="list-group position-absolute w-100 shadow-sm"
                                                            style="top:100%; left:0; z-index:1000; max-height:200px; overflow-y:auto;">
                                                            @foreach ($resultsitem as $item)
                                                                <li class="list-group-item list-group-item-action"
                                                                    wire:click="selectItem('{{ $item->kode_item }}')">
                                                                    {{ $item->kode_item }} -
                                                                    {{ $item->bibliografi->judul }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="date-picker-container">
                                                        <label for="StartDate" class="form-label">Tanggal</label>
                                                        <div class="input-group">
                                                            <input type="date"
                                                                class="form-control @error('loan_date') is-invalid @enderror"
                                                                wire:model.defer="loan_date">
                                                            @error('loan_date')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <button type="submit" class="btn btn-dark btn-sm mt-2">
                                                            </i> Pinjam
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body">

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
                                                        <th>Tanggal Peminjaman</th>
                                                        <th>Kelola</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($pinjamans as $index => $pinjaman)
                                                        <tr>
                                                            <td>{{ $pinjamans->firstItem() + $index }}</td>
                                                            <td>
                                                                @if ($pinjaman->item->bibliografi->gambar)
                                                                    <img src="{{ asset('storage/' . $pinjaman->item->bibliografi->gambar) }}"
                                                                        alt="Gambar Item"
                                                                        class="w-16 h-16 object-cover rounded">
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $pinjaman->kode_item ?? 'N/A' }}
                                                                <br> {{ $pinjaman->item->bibliografi->judul ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($pinjaman->loan_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <button class="btn btn-outline-dark btn-sm"
                                                                        wire:click="kembali({{ $pinjaman->id }})"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#kembaliConfirmModal">
                                                                        Kembali
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        wire:click="perpanjangan({{ $pinjaman->id }})"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#perpanjanganConfirmModal">
                                                                        Perpanjangan
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">Tidak ada data.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            {{ $pinjamans->links() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Tab Kartu -->
                        <div class="tab-pane fade @if($activeTab == 'pills-kartu') show active @endif" id="pills-kartu" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Pemesanan</h4>
                                            <div
                                                class="d-flex gap-4 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <button type="button" class="btn btn-dark btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#addPemesananModal">
                                                        <i class="fa fa-plus"></i> Tambah
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body">

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
                                                        <th>Tanggal</th>
                                                        <th>Status</th>
                                                        <th>Kelola</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($pemesanans as $index => $pemesanan)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                @if ($pemesanan->bibliografi->gambar)
                                                                    <img src="{{ asset('storage/' . $pemesanan->bibliografi->gambar) }}"
                                                                        alt="Gambar Item"
                                                                        class="w-16 h-16 object-cover rounded">
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $pemesanan->item->kode_item ?? 'N/A' }}
                                                                <br> {{ $pemesanan->bibliografi->judul ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ now()->format('d-m-Y') }}
                                                            </td>
                                                            <td>
                                                                @if ($pemesanan->is_mendapatkan === 0)
                                                                    <span class="badge bg-success">Aktif</span>
                                                                @else
                                                                    <span class="badge bg-danger">Nonaktif</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    wire:click="deletePemesanan('{{ $pemesanan->id }}')"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deletePemesananModal">
                                                                    Delete
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">Tidak ada data.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            {{ $pemesanans->links() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Tab Header -->
                        <div class="tab-pane fade @if($activeTab == 'pills-header') show active @endif" id="pills-header" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Denda</h4>
                                            <div
                                                class="d-flex gap-4 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <button type="button" class="btn btn-dark btn-sm"
                                                        wire:click="createDenda" data-bs-toggle="modal"
                                                        data-bs-target="#addDendaModal">
                                                        <i class="fa fa-plus"></i> Tambah
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body">

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
                                                        <th>Debet</th>
                                                        <th>Kredit</th>
                                                        <th>Status</th>
                                                        <th>Kelola</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($dendas as $index => $denda)
                                                        <tr>
                                                            <td>{{ $dendas->firstItem() + $index }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($denda->tanggal)->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $denda->keterangan ?? 'N/A' }}</td>
                                                            <td>{{ $denda->debet ?? 'N/A' }}</td>
                                                            <td>{{ $denda->kredit ?? 'N/A' }}</td>
                                                            <td>{{ $denda->status == 'Paid' ? 'Lunas' : 'Belum Lunas' }}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <button class="btn btn-outline-dark btn-sm"
                                                                        wire:click="editdendaId({{ $denda->id }})"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editDendaModal">
                                                                        <i class="fa fa-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm"
                                                                        wire:click="deletedendaId({{ $denda->id }})"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteDendaModal">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">Tidak ada data.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            {{ $dendas->links() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Tab Header -->
                        <div class="tab-pane fade @if($activeTab == 'pills-riwayat') show active @endif" id="pills-riwayat" role="tabpanel" tabindex="0">
                            <div class="card border shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title mb-0">Riwayat</h4>
                                            <div
                                                class="d-flex gap-4 d-flex justify-content-between align-items-center">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">

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

                                        <div class="mb-3 d-flex justify-content-between">
                                            <input type="text" class="form-control w-100" placeholder="Cari..."
                                                wire:model.live.debounce.10ms="caririwayat">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Item</th>
                                                        <th>Judul</th>
                                                        <th>Tanggal Pinjam</th>
                                                        <th>Tanggal Kembali</th>
                                                        <th>Denda</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($riwayats as $index => $riwayat)
                                                        <tr>
                                                            <td>{{ $riwayats->firstItem() + $index }}</td>
                                                            <td>{{ $riwayat->item->kode_item ?? 'N/A' }}</td>
                                                            <td>{{ $riwayat->item->bibliografi->judul ?? 'N/A' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($riwayat->loan_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($riwayat->return_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>{{ $riwayat->is_return == 1 ? 'Sudah Kembali' : 'Belum Kembali' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">Tidak ada data.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3">
                                            {{ $riwayats->links() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Pemesanan -->
    <div wire:ignore.self class="modal fade" id="addPemesananModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Pemesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storePemesanan" id="createPemesanan">
                        <div class="mb-3">
                            <label class="form-label">Pilih Bibliografi</label>
                            <select class="form-select @error('bibliografi_id') is-invalid @enderror"
                                wire:model.defer="bibliografi_id">
                                <option value="">Pilih Bibliografi</option>
                                @foreach ($daftarbibliografis as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->judul }}</option>
                                @endforeach
                            </select>
                            @error('bibliografi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="createPemesanan" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Denda -->
    <div wire:ignore.self class="modal fade" id="addDendaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Denda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storecreate" id="createdendaForm">
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                wire:model.defer="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                wire:model.defer="keterangan">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Debet</label>
                            <input type="text" class="form-control @error('debet') is-invalid @enderror"
                                wire:model.defer="debet">
                            @error('debet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kredit</label>
                            <input type="text" class="form-control @error('kredit') is-invalid @enderror"
                                wire:model.defer="kredit">
                            @error('kredit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="createdendaForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Kembali -->
    <div wire:ignore.self class="modal fade" id="kembaliConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 text-center">
                <div class="modal-header border-0" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Konfirmasi</h5>
                </div>
                <div class="modal-body">
                    <p>Item ini akan dikembalikan?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn" style="background:#141927; color:#fff;"
                        wire:click="addKembali()">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Perpanjangan -->
    <div wire:ignore.self class="modal fade" id="perpanjanganConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 text-center">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Konfirmasi</h5>
                </div>
                <div class="modal-body">
                    <p>Item ini akan diperpanjang (Pinjam Ulang)?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn" style="background:#141927; color:#fff;"
                        wire:click="addPerpanjangan()">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cetak Struk -->
    <div wire:ignore.self class="modal fade" id="addStrukModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 text-center">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Konfirmasi</h5>
                </div>
                <div class="modal-body">
                    <p>Cetak Struk?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn" style="background:#141927; color:#fff;"
                        wire:click="destroy()">Ya</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Denda -->
    <div wire:ignore.self class="modal fade" id="editDendaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Denda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateDenda" id="editdendaForm">
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                wire:model.defer="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                wire:model.defer="keterangan">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Debet</label>
                            <input type="text" class="form-control @error('debet') is-invalid @enderror"
                                wire:model.defer="debet">
                            @error('debet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kredit</label>
                            <input type="text" class="form-control @error('kredit') is-invalid @enderror"
                                wire:model.defer="kredit">
                            @error('kredit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editdendaForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete Denda -->
    <div wire:ignore.self class="modal fade" id="deleteDendaModal" tabindex="-1" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" wire:click="destroydenda()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete Pemesanan -->
    <div wire:ignore.self class="modal fade" id="deletePemesananModal" tabindex="-1" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" wire:click="destroyPemesanan()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
