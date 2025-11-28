<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Supplier</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addModal">
                        <i class="fa fa-plus"></i> Tambah Supplier
                    </button>
                    <a href="#" class="btn btn-outline-dark btn-sm" target="_blank"><i class="fa fa-print"></i>
                        Print</a>
                </div>
            </div>

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Cari nama/alamat supplier..."
                        wire:model.live.debounce.300ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $index => $supplier)
                                <tr>
                                    <td>{{ $suppliers->firstItem() + $index }}</td>
                                    <td>{{ $supplier->nama_supplier }}</td>
                                    <td>{{ $supplier->alamat ?? '-' }}</td>
                                    <td>{{ $supplier->telepon ?? '-' }}</td>
                                    <td>{{ $supplier->email ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $supplier->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $supplier->id }})" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data supplier.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $suppliers->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Tambah Supplier</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror"
                                wire:model.defer="nama_supplier">
                            @error('nama_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" wire:model.defer="alamat"></textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Kode Pos</label><input type="text"
                                class="form-control" wire:model.defer="kodepos"></div>
                        <div class="mb-3"><label class="form-label">Telepon</label><input type="text"
                                class="form-control" wire:model.defer="telepon"></div>
                        <div class="mb-3"><label class="form-label">Kontak</label><input type="text"
                                class="form-control" wire:model.defer="kontak"></div>
                        <div class="mb-3"><label class="form-label">Fax</label><input type="text"
                                class="form-control" wire:model.defer="fax"></div>
                        <div class="mb-3"><label class="form-label">Account</label><input type="text"
                                class="form-control" wire:model.defer="account"></div>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email"
                                class="form-control" wire:model.defer="email"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="createForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editForm">
                        <div class="mb-3"><label class="form-label">Nama Supplier</label><input type="text"
                                class="form-control" wire:model.defer="nama_supplier"></div>
                        <div class="mb-3"><label class="form-label">Alamat</label>
                            <textarea class="form-control" wire:model.defer="alamat"></textarea>
                        </div>
                        <div class="mb-3"><label class="form-label">Kode Pos</label><input type="text"
                                class="form-control" wire:model.defer="kodepos"></div>
                        <div class="mb-3"><label class="form-label">Telepon</label><input type="text"
                                class="form-control" wire:model.defer="telepon"></div>
                        <div class="mb-3"><label class="form-label">Kontak</label><input type="text"
                                class="form-control" wire:model.defer="kontak"></div>
                        <div class="mb-3"><label class="form-label">Fax</label><input type="text"
                                class="form-control" wire:model.defer="fax"></div>
                        <div class="mb-3"><label class="form-label">Account</label><input type="text"
                                class="form-control" wire:model.defer="account"></div>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email"
                                class="form-control" wire:model.defer="email"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header border-0" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size:3rem;"></i>
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" wire:click="destroy()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
