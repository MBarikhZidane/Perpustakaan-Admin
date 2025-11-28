<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Aturan Peminjaman</h4>
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
                                <th>Keanggotaan</th>
                                <th>Tipe Koleksi</th>
                                <th>GMD</th>
                                <th>Limit Peminjaman</th>
                                <th>Periode Peminjaman</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aturans as $index => $aturan)
                                <tr>
                                    <td>{{ $aturans->firstItem() + $index }}</td>
                                    <td>{{ $aturan->memberType->nama_tipe ?? 'N/A' }}</td>
                                    <td>{{ $aturan->collType->nama_tipe_koleksi ?? 'N/A' }}</td>
                                    <td>{{ $aturan->gmd->nama_gmd ?? 'N/A' }}</td>
                                    <td>{{ $aturan->loan_limit }}</td>
                                    <td>{{ $aturan->loan_periode }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $aturan->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $aturan->id }})" data-bs-toggle="modal"
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
                                    <td colspan="7" class="text-center">Tidak ada data anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    {{ $aturans->links() }}
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
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Aturan Peminjaman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createMemberForm">
                        <div class="mb-3">
                            <label class="form-label">Tipe Anggota</label>
                            <select class="form-select @error('member_type_id') is-invalid @enderror"
                                wire:model.defer="member_type_id">
                                <option value="">Pilih Tipe Anggota</option>
                                @foreach ($tipe_members as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('member_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Koleksi</label>
                            <select class="form-select @error('coll_type_id') is-invalid @enderror"
                                wire:model.defer="coll_type_id">
                                <option value="">Pilih Tipe Koleksi</option>
                                @foreach ($tipe_colls as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe_koleksi }}</option>
                                @endforeach
                            </select>
                            @error('coll_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">GMD</label>
                            <select class="form-select @error('gmd_id') is-invalid @enderror"
                                wire:model.defer="gmd_id">
                                <option value="">Pilih GMD</option>
                                @foreach ($tipe_gmd as $gmd)
                                    <option value="{{ $gmd->id }}">{{ $gmd->nama_gmd }}</option>
                                @endforeach
                            </select>
                            @error('gmd_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit Peminjaman</label>
                            <input type="number" class="form-control @error('loan_limit') is-invalid @enderror"
                                wire:model.defer="loan_limit">
                            @error('loan_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Periode Peminjaman</label>
                            <input type="number" class="form-control @error('loan_periode') is-invalid @enderror"
                                wire:model.defer="loan_periode">
                            @error('loan_periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit Pinjam Ulang</label>
                            <input type="number" class="form-control @error('reborrow_limit') is-invalid @enderror"
                                wire:model.defer="reborrow_limit">
                            @error('reborrow_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Denda Per Hari</label>
                            <input type="number" class="form-control @error('fine_each_day') is-invalid @enderror"
                                wire:model.defer="fine_each_day">
                            @error('fine_each_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Masa Tenggang</label>
                            <input type="number" class="form-control @error('grace_periode') is-invalid @enderror"
                                wire:model.defer="grace_periode">
                            @error('grace_periode')
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
                    <form wire:submit.prevent="update" id="editMemberForm">
                        <div class="mb-3">
                            <label class="form-label">Tipe Anggota</label>
                            <select class="form-select @error('member_type_id ') is-invalid @enderror"
                                wire:model.defer="member_type_id ">
                                <option value="">Pilih Tipe Anggota</option>
                                @foreach ($tipe_members as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('member_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Koleksi</label>
                            <select class="form-select @error('coll_type_id') is-invalid @enderror"
                                wire:model.defer="coll_type_id">
                                <option value="">Pilih Tipe Koleksi</option>
                                @foreach ($tipe_colls as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe_koleksi }}</option>
                                @endforeach
                            </select>
                            @error('coll_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">GMD</label>
                            <select class="form-select @error('gmd_id') is-invalid @enderror"
                                wire:model.defer="gmd_id ">
                                <option value="">Pilih GMD</option>
                                @foreach ($tipe_gmd as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_gmd }}</option>
                                @endforeach
                            </select>
                            @error('gmd_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit Peminjaman</label>
                            <input type="number" class="form-control @error('loan_limit') is-invalid @enderror"
                                wire:model.defer="loan_limit">
                            @error('loan_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Periode Peminjaman</label>
                            <input type="number" class="form-control @error('loan_periode') is-invalid @enderror"
                                wire:model.defer="loan_periode">
                            @error('loan_periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit Pinjam Ulang</label>
                            <input type="number" class="form-control @error('reborrow_limit') is-invalid @enderror"
                                wire:model.defer="reborrow_limit">
                            @error('reborrow_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Denda Per Hari</label>
                            <input type="number" class="form-control @error('fine_each_day') is-invalid @enderror"
                                wire:model.defer="fine_each_day">
                            @error('fine_each_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Masa Tenggang</label>
                            <input type="number" class="form-control @error('grace_periode') is-invalid @enderror"
                                wire:model.defer="grace_periode">
                            @error('grace_periode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
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
