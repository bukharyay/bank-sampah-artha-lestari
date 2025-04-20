<!-- Modal for Editing Sampah -->
<?php foreach ( $data_sampah as $ds ) : ?>
<div class="modal fade" id="sampahEdit<?= $ds->id_sampah ?>" tabindex="-1"
     aria-labelledby="sampahEdit<?= $ds->id_sampah ?>Label" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-warning" id="sampahEdit<?= $ds->id_sampah ?>Label">Edit Sampah <i
             class="mdi mdi-pencil text-warning align-middle"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="sampahEdit<?= $ds->id_sampah ?>"
              action="<?= base_url ( 'Edit-Sampah/' ) . $ds->id_sampah ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <input type="text" name="id_sampah" value="<?= $ds->id_sampah ?>" hidden>

          <div class="form-group  <?= form_error ( 'id_jenis_sampah' ) ? 'has-danger' : '' ?>">
            <label for="id_jenis_sampah">Jenis Sampah</label>
            <select class="form-control form-select" id="id_jenis_sampah" name="id_jenis_sampah" required>
              <option value="">- Pilih - </option>
              <?php foreach ( $data_jenis_sampah as $djs ) : ?>
              <option value="<?= $djs->id_jenis_sampah ?>"
                      <?= $ds->id_jenis_sampah == $djs->id_jenis_sampah ? 'selected' : '' ?>><?= $djs->jenis_sampah ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group <?= form_error ( 'nama_sampah' ) ? 'has-danger' : '' ?>">
            <label for="nama_sampah">Sampah</label>
            <input type="text" class="form-control" id="nama_sampah" name="nama_sampah" value="<?= $ds->nama_sampah ?>"
                   placeholder="Sampah" required>
            <?= form_error ( 'nama_sampah', '<label class="error mt-2 text-danger">', '</label>' ); ?>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning"><i class="mdi mdi-pencil align-middle text-white"></i>
              Edit </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>