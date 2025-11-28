<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Surat</h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addSuratModal">
                        <i class="fa fa-plus"></i> Tambah Surat
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
                    <input type="text" class="form-control w-100" placeholder="Cari nomor surat atau nama siswa..."
                        wire:model.live.debounce.300ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nomor Surat</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Tujuan</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surats as $index => $surat)
                                <tr>
                                    <td>{{ $surats->firstItem() + $index }}</td>
                                    <td>{{ $surat->tanggal }}</td>
                                    <td>{{ $surat->nomor_surat }}</td>
                                    <td>{{ $surat->anggota->member_id ?? '-' }}</td>
                                    <td>{{ $surat->anggota->nama ?? '-' }}</td>
                                    <td>{{ $surat->tujuan?->nama_tujuan ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $surat->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editSuratModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $surat->id }})" data-bs-toggle="modal"
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
                                    <td colspan="7" class="text-center">Tidak ada data surat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $surats->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div wire:ignore.self class="modal fade" id="addSuratModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Surat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createSuratForm">
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                                wire:model.defer="nomor_surat" placeholder="Contoh: 001/SKL/2025">
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                wire:model.defer="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select class="form-select @error('member_id') is-invalid @enderror"
                                wire:model.defer="member_id">
                                <option value="">Pilih Siswa</option>
                                @foreach ($anggotas as $a)
                                    <option value="{{ $a->member_id }}">{{ $a->member_id }} - {{ $a->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tujuan</label>
                            <select class="form-select @error('tujuan_id') is-invalid @enderror"
                                wire:model.defer="tujuan_id">
                                <option value="">Pilih Tujuan</option>
                                @foreach ($tujuans as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                                @endforeach
                            </select>
                            @error('tujuan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="createSuratForm" class="btn btn-dark">Simpan</button>
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div wire:ignore.self class="modal fade" id="editSuratModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Surat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editSuratForm">
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" wire:model.defer="nomor_surat">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" wire:model.defer="tanggal">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select class="form-select" wire:model.defer="member_id">
                                <option value="">Pilih Siswa</option>
                                @foreach ($anggotas as $a)
                                    <option value="{{ $a->member_id }}">{{ $a->member_id }} - {{ $a->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tujuan</label>
                            <select class="form-select" wire:model.defer="tujuan_id">
                                <option value="">Pilih Tujuan</option>
                                @foreach ($tujuans as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama_tujuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editSuratForm" class="btn btn-dark">Simpan Perubahan</button>
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
