<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Pemesanan</h4>
                <div class="d-flex gap-4">
                    <div class="date-picker-container">
                        <label for="StartDate" class="form-label">Periode</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" class="form-control" id="StartDate" placeholder="Pilih tanggal"
                                wire:model.live.debounce.10ms="start_date">
                        </div>
                    </div>
                    <div class="date-picker-container">
                        <label for="EndDate" class="form-label">S / D</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" class="form-control" id="EndDate" placeholder="Pilih tanggal"
                                wire:model.live.debounce.10ms="end_date">
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
                                <th>Judul</th>
                                <th>ISBN/ISSN</th>
                                <th>Nama Peminjam</th>
                                <th>Tanggal Pesan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemesanans as $index => $pemesanan)
                                <tr>
                                    <td>{{ $pemesanans->firstItem() + $index }}</td>
                                    <td>{{ $pemesanan->bibliografi->judul ?? 'N/A' }}</td>
                                    <td>{{ $pemesanan->bibliografi->isbn_issn ?? 'N/A' }}</td>
                                    <td>{{ $pemesanan->anggota->nama ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pemesanan->reserve_date)->format('d-m-Y') }}</td>
                                    <td>{{ $pemesanan->is_mendapatkan == 1 ? 'Sudah Dapat' : 'Belum Dapat' }}</td>
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
                    {{ $pemesanans->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
