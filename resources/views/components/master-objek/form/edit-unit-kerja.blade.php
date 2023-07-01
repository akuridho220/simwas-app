<div class="modal fade" id="modal-edit-unitkerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-unitkerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-unitkerja-label">Form Edit Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-danger">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-idobjek">
                <div class="form-group">
                    <label class="form-label" for="kode_wilayah">Kode Wilayah</label>
                    <div class="">
                        <input type="text" id="edit-kode-wilayah" class="form-control" name="kode_wilayah" required>
                        <small id="error-edit-kode_wilayah" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="kode_unitkerja">Kode Unit Kerja</label>
                    <div class="">
                        <input type="text" id="edit-kode-unitkerja" class="form-control" name="kode_unitkerja"
                            required>
                        <small id="error-edit-kode_unitkerja" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="nama">Nama</label>
                    <div class="">
                        <input type="text" id="edit-nama" class="form-control" name="nama" required>
                        <small id="error-edit-nama" class="text-danger"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" id="btn-edit-submit" class="btn btn-icon icon-left btn-primary">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
