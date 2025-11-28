<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Anggota</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addMemberModal">
                        <i class="fa fa-plus"></i> Tambah Anggota
                    </button>
                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#printPreviewModal" data-url="{{ route('cetak.list.anggota') }}"
                        onclick="loadPdfInModal(this)">
                        <i class="fa fa-print"></i> Print Semua
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
                    <input type="text" class="form-control w-100" placeholder="Cari ID atau nama anggota..."
                        wire:model.live.debounce.10ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Tipe</th>
                                <th>Kelas</th>
                                <th>Telepon</th>
                                <th>Pending</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggotas as $index => $anggota)
                                <tr>
                                    <td>{{ $anggotas->firstItem() + $index }}</td>
                                    <td>{{ $anggota->member_id }}</td>
                                    <td>{{ $anggota->nama }}</td>
                                    <td>{{ $anggota->tipeAnggota->nama_tipe ?? 'N/A' }}</td>
                                    <td>{{ $anggota->kelas ?? 'User Ini Bukan Siswa' }}</td>
                                    <td>{{ $anggota->telepon }}</td>
                                    <td>
                                        @if ($anggota->is_pending)
                                            <span class="badge bg-warning text-dark">Ya</span>
                                        @else
                                            <span class="badge bg-success">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $anggota->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editMemberModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $anggota->id }})" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmModal">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-dark btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#printPreviewModal"
                                                data-url="{{ route('cetak.kartu.anggota', $anggota->id) }}"
                                                onclick="loadPdfInModal(this)">
                                                <i class="fa fa-print"></i>
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
                    {{ $anggotas->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- ==================== MODALS (YANG SUDAH ADA) ==================== -->
    <!-- Modal Create Member -->
    <div wire:ignore.self class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Anggota</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createMemberForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ID Anggota</label>
                                <input type="text" class="form-control @error('member_id') is-invalid @enderror"
                                    wire:model.defer="member_id" placeholder="Contoh: A005">
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Anggota</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    wire:model.defer="nama" placeholder="Nama Lengkap">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Anggota</label>
                            <select class="form-select @error('tipe_anggota_id') is-invalid @enderror"
                                wire:model.defer="tipe_anggota_id">
                                <option value="">Pilih Tipe</option>
                                @foreach ($tipe_anggotas as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('tipe_anggota_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                wire:model.defer="kelas" placeholder="Contoh X TPM 1">
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model.defer="alamat" rows="3"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="tel" class="form-control @error('telepon') is-invalid @enderror"
                                wire:model.defer="telepon">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="statusPending"
                                wire:model.defer="is_pending">
                            <label class="form-check-label" for="statusPending">Status Pending</label>
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
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit Anggota</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editMemberForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ID Anggota</label>
                                <input type="text" class="form-control @error('member_id') is-invalid @enderror"
                                    wire:model.defer="member_id" readonly>
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Anggota</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    wire:model.defer="nama" placeholder="Nama Lengkap">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Anggota</label>
                            <select class="form-select @error('tipe_anggota_id') is-invalid @enderror"
                                wire:model.defer="tipe_anggota_id">
                                <option value="">Pilih Tipe</option>
                                @foreach ($tipe_anggotas as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_tipe }}</option>
                                @endforeach
                            </select>
                            @error('tipe_anggota_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                wire:model.defer="kelas" placeholder="Contoh Penulisan X TPM 1">
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model.defer="alamat" rows="3"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="tel" class="form-control @error('telepon') is-invalid @enderror"
                                wire:model.defer="telepon">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="editPending"
                                wire:model.defer="is_pending">
                            <label class="form-check-label" for="editPending">Status Pending</label>
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

    <!-- ==================== MODAL BARU UNTUK PREVIEW CETAK ==================== -->
    <div wire:ignore.self class="modal fade" id="printPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Kartu Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="previewIframe" src="about:blank"
                        style="width: 100%; height: 75vh; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

</div>
