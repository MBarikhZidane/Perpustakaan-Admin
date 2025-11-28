<x-app>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Laporan Keanggotaan</h2>
            <hr>
            <div class="card">
                <div class="card-header">
                    <form method="get" action="{{ route('pelaporan.laporan-keanggotaan') }}"
                        class="d-flex gap-4 flex-wrap align-items-end">
                        <div class="date-picker-container">
                            <label for="Tanggal" class="form-label">Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control" name="tanggal" id="Tanggal"
                                    value="{{ $tanggal }}">
                            </div>
                        </div>
                        <div class="d-flex align-items-end">
                            <button type="submit" class="btn btn-dark">Reload</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <iframe src="{{ $pdfUrl }}" frameborder="0" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app>
