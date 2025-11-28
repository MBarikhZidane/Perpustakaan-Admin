<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Status</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addModal">
                        <i class="fa fa-plus"></i> Tambah Status
                    </button>
                    <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
                        <i class="fa fa-print"></i> Print
                    </a>
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
                    <input type="text" class="form-control" placeholder="Cari status..."
                        wire:model.live.debounce.300ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Status</th>
                                <th>Aturan</th>
                                <th>Tidak Dipinjamkan</th>
                                <th>Skip Opname</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statuses as $index => $status)
                                <tr>
                                    <td>{{ $statuses->firstItem() + $index }}</td>
                                    <td>{{ $status->kode_status }}</td>
                                    <td>{{ $status->nama_status }}</td>
                                    <td>{{ $status->aturan ?? '-' }}</td>
                                    <td>
                                        @if ($status->is_not_dipinjamkan)
                                            <span class="badge bg-warning text-dark">Ya</span>
                                        @else
                                            <span class="badge bg-success">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($status->is_skip_stockopname)
                                            <span class="badge bg-warning text-dark">Ya</span>
                                        @else
                                            <span class="badge bg-success">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $status->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $status->id }})" data-bs-toggle="modal"
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
                                    <td colspan="7" class="text-center">Tidak ada data status.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $statuses->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Tambah Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createForm">
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control @error('kode_status') is-invalid @enderror"
                                wire:model.defer="kode_status">
                            @error('kode_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Status</label>
                            <input type="text" class="form-control @error('nama_status') is-invalid @enderror"
                                wire:model.defer="nama_status">
                            @error('nama_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Aturan</label>
                            <textarea class="form-control @error('aturan') is-invalid @enderror" wire:model.defer="aturan"></textarea>
                            @error('aturan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="tdp"
                                wire:model.defer="is_not_dipinjamkan">
                            <label class="form-check-label" for="tdp">Tidak Dipinjamkan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="so"
                                wire:model.defer="is_skip_stockopname">
                            <label class="form-check-label" for="so">Skip Opname</label>
                        </div>
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
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Edit Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editForm">
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" wire:model.defer="kode_status">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Status</label>
                            <input type="text" class="form-control" wire:model.defer="nama_status">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Aturan</label>
                            <textarea class="form-control" wire:model.defer="aturan"></textarea>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="editTdp"
                                wire:model.defer="is_not_dipinjamkan">
                            <label class="form-check-label" for="editTdp">Tidak Dipinjamkan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="editSo"
                                wire:model.defer="is_skip_stockopname">
                            <label class="form-check-label" for="editSo">Skip Opname</label>
                        </div>
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
            <div class="modal-content text-center rounded-3">
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
