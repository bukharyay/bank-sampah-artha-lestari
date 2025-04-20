<!-- Modal for Editing Sampah -->
<?php foreach ( $data_jenis_sampah as $js ) : ?>
<div class="modal fade" id="sampahjenisEdit<?= $js->id_jenis_sampah ?>" tabindex="-1"
     aria-labelledby="sampahjenisEdit<?= $js->id_jenis_sampah ?>Label" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-warning" id="sampahjenisEdit<?= $js->id_jenis_sampah ?>Label">Edit Kategori Sampah
          <i class="mdi mdi-pencil text-warning align-middle"></i>
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="sampahjenisEdit<?= $js->id_jenis_sampah ?>"
              action="<?= base_url ( 'Edit-Jenis-Sampah/' ) . $js->id_jenis_sampah ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <input type="text" name="id_jenis_sampah" value="<?= $js->id_jenis_sampah ?>" hidden>

          <div class="form-group <?= form_error ( 'jenis_sampah' ) ? 'has-danger' : '' ?>">
            <label for="jenis_sampah">Kategori Sampah</label>
            <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah"
                   value="<?= $js->jenis_sampah ?>" placeholder="Kategori Sampah" required>
            <?= form_error ( 'jenis_sampah', '<label class="error mt-2 text-danger">', '</label>' ); ?>
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