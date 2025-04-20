<!-- Modal for Deleting Sampah -->
<?php foreach ( $data_jenis_sampah as $js ) : ?>
<div class="modal fade" id="sampahjenisHapus<?= $js->id_jenis_sampah ?>" tabindex="-1"
     aria-labelledby="sampahjenisHapus<?= $js->id_jenis_sampah ?>Label" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="sampahjenisHapus<?= $js->id_jenis_sampah ?>Label">Hapus Kategori Sampah
          <i class="mdi mdi-delete align-middle text-danger"></i>
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h6 class="mb-3">Anda yakin ingin menghapus kategori sampah ini?</h6>
        <h5 class="text-primary"><?= $js->jenis_sampah ?></h5>
        <p>Semua data sampah yang masuk kedalam kategori ini akan ikut terhapus</p>

        <form class="forms-sample" id="sampahjenisHapus<?= $js->id_jenis_sampah ?>"
              action="<?= base_url ( 'Delete-Jenis-Sampah/' ) . $js->id_jenis_sampah ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <input type="hidden" name="id_jenis_sampah" value="<?= $js->id_jenis_sampah ?>">
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