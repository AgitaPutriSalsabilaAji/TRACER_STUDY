<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('profesi.update', $profesi->id) }}" method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="{{ $profesi->kategori }}">
                    </div>
                    <div class="mb-3">
                        <label>Nama Profesi</label>
                        <input type="text" name="nama_profesi" class="form-control" value="{{ $profesi->nama_profesi }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
