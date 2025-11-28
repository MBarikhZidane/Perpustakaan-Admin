<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Riwayat Peminjaman</h4>
                <div class="d-flex gap-4">
                    <div class="dropdown-container">
                        <label for="filterDropdown" class="form-label">Filter Kategori</label>
                        <div class="dropdown border">
                            <button class="btn dropdown-toggle w-100" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pilih Kategori
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item" href="#" wire:click.prevent="$set('is_return', 'all')" data-value="all">Semua</a></li>
                                <li><a class="dropdown-item" href="#"  wire:click.prevent="$set('is_return', 0)" data-value="0">Masih Dipinjam</a></li>
                                <li><a class="dropdown-item" href="#" wire:click.prevent="$set('is_return', 1)" data-value="1">Sudah Dikembalikan</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="date-picker-container">
                        <label for="StartDate" class="form-label">Periode</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" class="form-control" id="StartDate" placeholder="Pilih tanggal" wire:model.live.debounce.10ms="start_date">
                        </div>
                    </div>
                    <div class="date-picker-container">
                        <label for="EndDate" class="form-label">S / D</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" class="form-control" id="EndDate" placeholder="Pilih tanggal" wire:model.live.debounce.10ms="end_date">
                        </div>
                    </div>

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
                                <th>Nama Peminjam</th>
                                <th>Kode Item</th>
                                <th>Judul</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                        <tbody>
                            @forelse($peminjamans as $index => $peminjaman)
                                <tr>
                                    <td>{{ $peminjamans->firstItem() + $index }}</td>
                                    <td>{{ $peminjaman->anggota->nama ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->kode_item ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->item->judul ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->loan_date }}</td>
                                    <td>{{ $peminjaman->duedate }}</td>
                                    <td>{{ $peminjaman->is_return == 1 ? 'Sudah Dikembalikan' : 'Masih Dipinjam' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $peminjamans->links() }}
                </div>
                </div>

            </div>
        </div>
    </div>
