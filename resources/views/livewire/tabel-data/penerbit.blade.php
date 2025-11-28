<div class="container-fluid">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Data Penerbit</h4>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-dark btn-sm" wire:click="create" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus"></i> Tambah Penerbit
          </button>
          <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
            <i class="fa fa-print"></i> Print
          </a>
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
          <input type="text" class="form-control" placeholder="Cari penerbit..."
                 wire:model.live.debounce.300ms="search">
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Penerbit</th>
                <th>Tempat</th>
                <th>Kelola</th>
              </tr>
            </thead>
            <tbody>
              @forelse($penerbits as $index => $penerbit)
                <tr>
                  <td>{{ $penerbits->firstItem() + $index }}</td>
                  <td>{{ $penerbit->nama_penerbit }}</td>
                  <td>{{ $penerbit->tempat?->nama_tempat ?? '-' }}</td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn btn-outline-dark btn-sm"
                              wire:click="editId({{ $penerbit->id }})"
                              data-bs-toggle="modal"
                              data-bs-target="#editModal">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-outline-danger btn-sm"
                              wire:click="deleteId({{ $penerbit->id }})"
                              data-bs-toggle="modal"
                              data-bs-target="#deleteModal">
                        <i class="fa fa-trash"></i>
                      </button>
                      <a href="#" class="btn btn-outline-dark btn-sm" target="_blank">
                        <i class="fa fa-print"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center">Tidak ada data penerbit.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-3">{{ $penerbits->links() }}</div>
      </div>
    </div>
  </div>

  <!-- Modal Create -->
  <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-3">
        <div class="modal-header" style="background:#141927; color:#fff;">
          <h5 class="modal-title">Tambah Penerbit</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="store" id="createForm">
            <div class="mb-3">
              <label class="form-label">Nama Penerbit</label>
              <input type="text" class="form-control @error('nama_penerbit') is-invalid @enderror"
                     wire:model.defer="nama_penerbit">
              @error('nama_penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Tempat Penerbit</label>
              <select class="form-select @error('tempat_id') is-invalid @enderror" wire:model.defer="tempat_id">
                <option value="">Pilih Tempat</option>
                @foreach($tempat_penerbits as $tempat)
                  <option value="{{ $tempat->id }}">{{ $tempat->nama_tempat }}</option>
                @endforeach
              </select>
              @error('tempat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
          <h5 class="modal-title">Edit Penerbit</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="update" id="editForm">
            <div class="mb-3">
              <label class="form-label">Nama Penerbit</label>
              <input type="text" class="form-control" wire:model.defer="nama_penerbit">
            </div>
            <div class="mb-3">
              <label class="form-label">Tempat Penerbit</label>
              <select class="form-select" wire:model.defer="tempat_id">
                <option value="">Pilih Tempat</option>
                @foreach($tempat_penerbits as $tempat)
                  <option value="{{ $tempat->id }}">{{ $tempat->nama_tempat }}</option>
                @endforeach
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
