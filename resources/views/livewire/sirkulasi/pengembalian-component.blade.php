<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Pengembalian</h4>
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

                <div class="mb-3 position-relative" style="width: 300px;">
                    <label for="StartDate" class="form-label">Kode Item</label>
                    <input type="text" wire:model.live="cariitem" placeholder="Masukkan kode item..."
                        class="form-control">
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

                @if ($selectedItem)
                <form wire:submit.prevent="update" id="editMemberForm">
                <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                wire:model.defer="judul">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Anggota</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                wire:model.defer="nama">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tgl Pinjam</label>
                            <input type="text" class="form-control" wire:model.defer="loan_date" readonly>
                            @error('loan_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jatuh Tempo</label>
                            <input type="text" class="form-control" wire:model.defer="duedate" readonly>
                            @error('duedate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterlambatan</label>
                            <input type="text" class="form-control" wire:model.defer="keterlambatan" readonly>
                            @error('keterlambatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Denda</label>
                            <input type="text" class="form-control" wire:model.defer="denda" readonly>
                            @error('denda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                wire:model.defer="status">
                                <option value="">Pilih Status</option>
                                <option value="Paid">Lunas</option>
                                <option value="Unpaid">Belum Bayar</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="editMemberForm" class="btn btn-dark">Simpan Perubahan</button>
                    <button type="button" wire:click="batal()" class="btn btn-outline-dark" data-bs-dismiss="modal">Batal</button>
                </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
