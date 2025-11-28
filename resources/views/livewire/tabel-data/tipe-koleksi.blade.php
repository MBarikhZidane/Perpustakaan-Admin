<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Tipe Koleksi</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addModal">
                        <i class="fa fa-plus"></i> Tambah Tipe Koleksi
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
                    <input type="text" class="form-control" placeholder="Cari tipe koleksi..."
                        wire:model.live.debounce.300ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tipe Koleksi</th>
                                <th>Group Konter</th>
                                <th>Prefix</th>
                                <th>Urutan</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tipe_koleksis as $index => $tipe)
                                <tr>
                                    <td>{{ $tipe_koleksis->firstItem() + $index }}</td>
                                    <td>{{ $tipe->nama_tipe_koleksi }}</td>
                                    <td>{{ $tipe->kd_group_konter }}</td>
                                    <td>{{ $tipe->prefix }}</td>
                                    <td>{{ $tipe->urutan }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $tipe->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $tipe->id }})" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <a href="#" class="btn btn-outline-dark btn-sm" target="_blank"><i
                                                    class="fa fa-print"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $tipe_koleksis->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Tambah Tipe Koleksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Tipe Koleksi</label>
                            <input type="text" class="form-control @error('nama_tipe_koleksi') is-invalid @enderror"
                                wire:model.defer="nama_tipe_koleksi">
                            @error('nama_tipe_koleksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Group Konter</label>
                            <input type="text" class="form-control @error('kd_group_konter') is-invalid @enderror"
                                wire:model.defer="kd_group_konter">
                            @error('kd_group_konter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prefix</label>
                            <input type="text" class="form-control" wire:model.defer="prefix">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                wire:model.defer="urutan">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                    <h5 class="modal-title">Edit Tipe Koleksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Tipe Koleksi</label>
                            <input type="text" class="form-control" wire:model.defer="nama_tipe_koleksi">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Group Konter</label>
                            <input type="text" class="form-control" wire:model.defer="kd_group_konter">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prefix</label>
                            <input type="text" class="form-control" wire:model.defer="prefix">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" class="form-control" wire:model.defer="urutan">
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
