<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Frekuensi</h4>
                <div class="d-flex gap-2">
                    <!-- Tombol Tambah -->
                    <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal"
                        data-bs-target="#addModal">
                        <i class="fa fa-plus"></i> Tambah Frekuensi
                    </button>
                    <!-- Tombol Print -->
                    <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }} <button
                            type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                    </div>
                @endif

                <div class="mb-3 d-flex justify-content-between">
                    <input type="text" class="form-control w-100" placeholder="Cari frekuensi..."
                        wire:model.live.debounce.300ms="search">
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Frekuensi</th>
                                <th>Bahasa</th>
                                <th>Time Increment</th>
                                <th>Time Unit</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($frekuensis as $index => $frq)
                                <tr>
                                    <td>{{ $frekuensis->firstItem() + $index }}</td>
                                    <td>{{ $frq->frekuensi }}</td>
                                    <td>{{ $frq->bahasa?->nama_bahasa ?? '-' }}</td>
                                    <td>{{ $frq->time_increment }}</td>
                                    <td>{{ $frq->time_unit }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <!-- Edit -->
                                            <button class="btn btn-outline-dark btn-sm"
                                                wire:click="editId({{ $frq->id }})" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <!-- Delete -->
                                            <button class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteId({{ $frq->id }})" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <!-- Print -->
                                            <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data frekuensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $frekuensis->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header" style="background:#141927; color:#fff;">
                    <h5 class="modal-title">Tambah Frekuensi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" id="createForm">
                        <div class="mb-3">
                            <label class="form-label">Frekuensi</label>
                            <input type="text" class="form-control @error('frekuensi') is-invalid @enderror"
                                wire:model.defer="frekuensi">
                            @error('frekuensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bahasa</label>
                            <select class="form-select @error('language_prefix') is-invalid @enderror"
                                wire:model.defer="language_prefix">
                                <option value="">Pilih Bahasa</option>
                                @foreach ($bahasas as $b)
                                    <option value="{{ $b->kode_bahasa }}">{{ $b->nama_bahasa }}</option>
                                @endforeach
                            </select>
                            @error('language_prefix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time Increment</label>
                            <input type="number" class="form-control @error('time_increment') is-invalid @enderror"
                                wire:model.defer="time_increment">
                            @error('time_increment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time Unit</label>
                            <select class="form-select @error('time_unit') is-invalid @enderror"
                                wire:model.defer="time_unit">
                                <option value="">Pilih Unit</option>
                                <option value="Hari">Hari</option>
                                <option value="Minggu">Minggu</option>
                                <option value="Bulan">Bulan</option>
                                <option value="Tahun">Tahun</option>
                            </select>
                            @error('time_unit')
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
                    <h5 class="modal-title">Edit Frekuensi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" id="editForm">
                        <div class="mb-3">
                            <label class="form-label">Frekuensi</label>
                            <input type="text" class="form-control" wire:model.defer="frekuensi">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bahasa</label>
                            <select class="form-select" wire:model.defer="language_prefix">
                                <option value="">Pilih Bahasa</option>
                                @foreach ($bahasas as $b)
                                    <option value="{{ $b->kode_bahasa }}">{{ $b->nama_bahasa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time Increment</label>
                            <input type="number" class="form-control" wire:model.defer="time_increment">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time Unit</label>
                            <select class="form-select" wire:model.defer="time_unit">
                                <option value="">Pilih Unit</option>
                                <option value="Hari">Hari</option>
                                <option value="Minggu">Minggu</option>
                                <option value="Bulan">Bulan</option>
                                <option value="Tahun">Tahun</option>
                            </select>
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
