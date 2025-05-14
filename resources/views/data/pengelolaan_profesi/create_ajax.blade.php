<div class="modal fade" id="modalCreateKategori" tabindex="-1">
    <div class="modal-dialog">
        <form id="formCreateKategori" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalCreateProfesi" tabindex="-1">
    <div class="modal-dialog">
        <form id="formCreateProfesi" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Profesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Profesi</label>
                        <input type="text" name="nama_profesi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            <!-- Daftar kategori akan dimuat di sini -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
