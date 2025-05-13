<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('profesi.store') }}" method="POST" id="formCreate">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Profesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Nama Profesi</label>
                        <input type="text" name="nama_profesi" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
