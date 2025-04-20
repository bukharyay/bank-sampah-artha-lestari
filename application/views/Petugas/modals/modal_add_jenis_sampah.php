<!-- Modal for Adding Sampah -->
<div class="modal fade" id="sampahjenisAdd" tabindex="-1" aria-labelledby="sampahjenisAddLabel" style="display: none;"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="sampahjenisAddLabel"> Tambah Kategori Sampah <i
             class="mdi mdi-plus-circle text-primary align-middle"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="addjenisSampah" action="<?= base_url ( 'Add-Jenis-Sampah' ) ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <div class="form-group <?= form_error ( 'jenis_sampah' ) ? 'has-danger' : '' ?>">
            <label for="jenis_sampah">Kategori Sampah</label>
            <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah"
                   value="<?= set_value ( 'jenis_sampah' ); ?>" placeholder="Kategori Sampah" required>
            <?= form_error ( 'jenis_sampah', '<label class="error mt-2 text-danger">', '</label>' ); ?>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary"> <i class="mdi mdi-plus-circle align-middle"></i> Tambah
              Kategori
              Sampah </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>