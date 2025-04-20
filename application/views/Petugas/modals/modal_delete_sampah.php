<!-- Modal for Deleting Sampah -->
<?php foreach ( $data_sampah as $ds ) : ?>
<div class="modal fade" id="sampahHapus<?= $ds->id_sampah ?>" tabindex="-1"
     aria-labelledby="sampahHapus<?= $ds->id_sampah ?>Label" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="sampahHapus<?= $ds->id_sampah ?>Label">Hapus Sampah <i
             class="mdi mdi-delete align-middle text-danger"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h6 class="mb-3">Anda yakin ingin menghapus sampah ini?</h6>
        <h5 class="text-primary"><?= $ds->nama_sampah ?></h5>

        <form class="forms-sample" id="userHapus<?= $ds->id_sampah ?>"
              action="<?= base_url ( 'Delete-Sampah/' ) . $ds->id_sampah ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <input type="hidden" name="id_sampah" value="<?= $ds->id_sampah ?>">
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete align-middle text-white"></i>
          Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>