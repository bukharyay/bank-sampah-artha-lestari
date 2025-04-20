<?php foreach ( $data_users as $us ) : ?>
<?php if ( $us->role !== 'admin' ) : ?>
<div class="modal fade" id="userDetail<?= $us->id_user ?>" tabindex="-1"
     aria-labelledby="userDetail<?= $us->id_user ?>Label" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="userDetail<?= $us->id_user ?>Label">Detail Pengguna <i
             class="ti-eye text-primary"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <!-- Profile Picture -->
        <div class="mb-3">
          <img src="<?= base_url ( 'assets/profile/avatars/' . ( $us->avatar ?? 'default.png' ) ) ?>" alt="Avatar"
               class="rounded-circle" style="width: 100px; height: 100px;">
        </div>
        <h5 class="text-primary"><?= $us->nama ?? $us->nama, ' (@' . $us->username . ')' ?></h5>
        <p class="text-<?= $us->role === 'petugas' ? 'info' : 'success' ?>"> <?= ucfirst ( $us->role ) ?></p>
        <p class="text-muted"><?= $us->email ?></p>
        <p class="text-muted">No Telepon: <?= $us->no_telfon ?? $us->no_telfon ?></p>
        <p class="text-muted">Alamat: <?= $us->alamat ?? $us->alamat ?></p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<?php endforeach; ?>