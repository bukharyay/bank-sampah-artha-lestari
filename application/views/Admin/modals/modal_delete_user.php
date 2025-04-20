<?php foreach ( $data_users as $us ) : ?>
<?php if ( $us->role !== 'admin' ) : ?>
<div class="modal fade" id="userHapus<?= $us->id_user ?>" tabindex="-1"
     aria-labelledby="userHapus<?= $us->id_user ?>Label" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="userHapus<?= $us->id_user ?>Label">Hapus Pengguna <i
             class="ti-trash text-danger"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <!-- Profile Picture -->
        <div class="mb-3">
          <img src="<?= base_url ( 'assets/profile/avatars/' . ( $us->avatar ?? 'default.png' ) ) ?>"
               alt="Avatar" class="rounded-circle" style="width: 100px; height: 100px;">
        </div>
        <h6 class="mb-3">Anda yakin ingin menghapus pengguna ini?</h6>
        <h5 class="text-primary"><?= $us->nama, ' (@' . $us->username . ')' ?>
        </h5>
        <p class="text-muted"><?= $us->email ?></p>

        <form class="forms-sample" id="userHapus<?= $us->id_user ?>"
              action="<?= base_url ( 'Delete-Users/' ) . $us->id_user ?>" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                 value="<?= $this->security->get_csrf_hash (); ?>" />
          <input type="hidden" name="id_user" value="<?= $us->id_user ?>">
          <!-- <div class="form-group">
                    <label for="reason">Alasan Penghapusan <small>(optional)</small></label>
                    <textarea class="form-control" rows="3" name="reason" id="reason" placeholder="Masukkan alasan jika ada..."></textarea>
                  </div> -->
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger"><i class="ti-trash text-white"></i> Hapus</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>
<?php endforeach; ?>