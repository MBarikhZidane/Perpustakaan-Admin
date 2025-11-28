<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Tipe Anggota</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addTipeModal">
                        <i class="fa fa-plus"></i> Tambah Tipe
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
                        <i class="fa fa-print"></i> Print
                    </a>
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
                    <input type="text" class="form-control w-100" placeholder="Cari nama tipe..."
                        wire:model.live.debounce.10ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tipe</th>
                                <th>Siswa</th>
                                <th>Guru</th>
                                <th>Karyawan</th>
                                <th>External</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tipes as $index => $tipe)
                                <tr>
                                    <td>{{ $tipes->firstItem() + $index }}</td>
                                    <td>{{ $tipe->nama_tipe }}</td>
                                    <td>{!! $tipe->is_siswa ? '✓' : '' !!}</td>
                                    <td>{!! $tipe->is_guru ? '✓' : '' !!}</td>
                                    <td>{!! $tipe->is_karyawan ? '✓' : '' !!}</td>
                                    <td>{!! $tipe->is_external ? '✓' : '' !!}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $tipe->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editTipeModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $tipe->id }})" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmModal">
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
                                    <td colspan="7" class="text-center">Tidak ada data tipe anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $tipes->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div wire:ignore.self class="modal fade" id="addTipeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Tipe</h5> <button type="button"
                        class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createTipeForm">
                        <div class="mb-3"> <label class="form-label">Nama Tipe</label> <input type="text"
                                class="form-control @error('nama_tipe') is-invalid @enderror"
                                wire:model.defer="nama_tipe" placeholder="Contoh: Tipe Siswa"> @error('nama_tipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3"> <label class="form-label">Masuk Sebagai</label>
                            <div class="d-flex gap-4">
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_siswa"> <label>Siswa</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_guru"> <label>Guru</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_karyawan"> <label>Karyawan</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_external"> <label>External</label></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"> <button type="submit" form="createTipeForm"
                        class="btn btn-dark">Simpan</button> <button type="button" class="btn btn-outline-dark"
                        data-bs-dismiss="modal">Batal</button> </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div wire:ignore.self class="modal fade" id="editTipeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Tipe</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editTipeForm">
                        <div class="mb-3">
                            <label class="form-label">Nama Tipe</label>
                            <input type="text" class="form-control @error('nama_tipe') is-invalid @enderror"
                                wire:model.defer="nama_tipe">
                            @error('nama_tipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Masuk Sebagai</label>
                            <div class="d-flex gap-4">
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_siswa"> <label>Siswa</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_guru"> <label>Guru</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_karyawan"> <label>Karyawan</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input"
                                        wire:model.defer="is_external"> <label>External</label></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editTipeForm" class="btn btn-dark">Simpan Perubahan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation -->
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
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" wire:click="destroy()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
