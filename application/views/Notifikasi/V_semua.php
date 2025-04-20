<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Semua Notifikasi</h4>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="10%">Icon</th>
                    <th width="20%">Judul</th>
                    <th>Pesan</th>
                    <th width="15%">Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ( ! empty ( $notifikasi ) ) : ?>
                  <?php foreach ( $notifikasi as $notif ) : ?>
                  <?php
                      $iconClass = '';
                      $textClass = '';

                      switch ($notif->tipe)
                        {
                        case 'warning':
                          $iconClass = 'mdi mdi-alert';
                          $textClass = 'text-warning';
                          break;
                        case 'success':
                          $iconClass = 'mdi mdi-check-circle';
                          $textClass = 'text-success';
                          break;
                        case 'danger':
                          $iconClass = 'mdi mdi-alert-circle';
                          $textClass = 'text-danger';
                          break;
                        default:
                          $iconClass = 'mdi mdi-information';
                          $textClass = 'text-primary';
                        }
                      ?>
                  <tr>
                    <td><i class="<?= $iconClass ?> <?= $textClass ?> icon-lg"></i></td>
                    <td><?= htmlspecialchars ( $notif->judul ) ?></td>
                    <td><?= htmlspecialchars ( $notif->pesan ) ?></td>
                    <td><?= date ( 'd M Y H:i', strtotime ( $notif->created_at ) ) ?></td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else : ?>
                  <tr>
                    <td colspan="4" class="text-center">Tidak ada notifikasi</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>