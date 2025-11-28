<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Item Keluar</h4>
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
                            </tr>
                            </thead>
                        <tbody>
                            @forelse($peminjamans as $index => $peminjaman)
                                <tr>
                                    <td>{{ $peminjamans->firstItem() + $index }}</td>
                                    <td>{{ $peminjaman->anggota->nama ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->kode_item ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->item->bibliografi->judul ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->loan_date }}</td>
                                    <td>{{ $peminjaman->duedate }}</td>
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
