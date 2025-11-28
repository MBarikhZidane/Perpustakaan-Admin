<x-app>
    <div class="container-fluid">
        <div class="col-md-12">
            <h2>Rekapitulasi Buku</h2>
            <hr>
            <div class="card">
                <div class="card-header">
                    <form method="get" action="{{ route('pelaporan.rekapitulasi-buku') }}"
                        class="d-flex gap-4 flex-wrap align-items-end">
                        <div class="date-picker-container">
                            <label for="StartDate" class="form-label">Periode Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control" name="start_date" id="StartDate"
                                    value="{{ $startDate }}">
                            </div>
                        </div>
                        <div class="date-picker-container">
                            <label for="EndDate" class="form-label">Sampai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control" name="end_date" id="EndDate"
                                    value="{{ $endDate }}">
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
