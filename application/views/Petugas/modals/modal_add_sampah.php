<!-- Modal for Adding Sampah -->
<div class="modal fade" id="sampahAdd" tabindex="-1" aria-labelledby="sampahAddLabel" style="display: none;"
     aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="sampahAddLabel"> Tambah Sampah <i
             class="mdi mdi-plus-circle text-primary align-middle"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="addSampah" action="<?= base_url ( 'Add-Sampah' ) ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <div class="form-group <?= form_error ( 'id_jenis_sampah' ) ? 'has-danger' : '' ?>">
            <label for="id_jenis_sampah">Jenis Sampah</label>
            <select class="form-control form-select" id="id_jenis_sampah" name="id_jenis_sampah">
              <option value="">- Pilih - </option>
              <?php foreach ( $data_jenis_sampah as $djs ) : ?>
              <option value="<?= $djs->id_jenis_sampah ?>"
                      <?= ! empty ( set_value ( 'id_jenis_sampah' ) ) ? 'selected' : '' ?>>
                <?= $djs->jenis_sampah ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group <?= form_error ( 'nama_sampah' ) ? 'has-danger' : '' ?>">
            <label for="nama_sampah">Sampah</label>
            <input type="text" class="form-control" id="nama_sampah" name="nama_sampah"
                   value="<?= set_value ( 'nama_sampah' ); ?>" placeholder="Sampah">
            <?= form_error ( 'nama_sampah', '<label class="error mt-2 text-danger">', '</label>' ); ?>
          </div>
      </div>
      <div class="modal-footer justify-content-around">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"> <i class="mdi mdi-plus-circle align-middle"></i> Tambah
          Sampah </button>
      </div>
      </form>
    </div>
  </div>
</div>