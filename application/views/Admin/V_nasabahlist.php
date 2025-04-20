<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-2">Data Nasabah</h4>
        <p class="card-description">Daftar semua Nasabah dari bank sampah</p>
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <?php $this->load->view ( 'components/alert_messages' ); ?>
              <?php if ( validation_errors () ) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oops!</strong> Ada beberapa kesalahan dalam pengisian form:
                <ul>
                  <?= validation_errors ( '<li>', '</li>' ); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif; ?>

              <table id="nasabah_list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="10%">Avatar</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Nama Lengkap</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Jumlah Tabungan</th>
                    <th class="text-center">Terdaftar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ( $data_nasabah as $index => $dn ) : ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td class="text-center">
                      <img src="<?= base_url ( 'assets/profile/avatars/' . ( $dn->avatar ?? 'default.png' ) ); ?>"
                           alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
                    </td>
                    <td><?= htmlspecialchars ( $dn->username ?? '' ) ?></td>
                    <td><?= htmlspecialchars ( $dn->email ?? '' ) ?></td>
                    <td><?= htmlspecialchars ( $dn->nama ?? '' ) ?></td>
                    <td class="text-center">
                      <?= htmlspecialchars ( $dn->rt_rw ?? '' ) ?>
                      <p><?= $dn->alamat ?? '' ?></p>
                    </td>
                    <td class="text-center">Rp.
                      <?= htmlspecialchars ( number_format ( (float) $dn->jumlah_tabungan ?? 0 ) ) ?>
                    </td>
                    <td>
                      <div class="text-muted  ">
                        <i class="mdi mdi-calendar align-middle me-2"></i>
                        <?= date ( 'd F Y', strtotime ( $dn->nasabah_created_at ?? '' ) ) ?>
                      </div>
                      <div class="text-muted  ">
                        <i class="mdi mdi-clock align-middle me-2"></i>
                        <?= date ( 'H:i', strtotime ( $dn->nasabah_created_at ?? '' ) ) ?>
                      </div>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function() {
    // Initialize DataTable with advanced features
    const userTable = $('#nasabah_list').DataTable({
      layout: {
        top: {
          buttons: [
            'copy', 'excel', 'pdf', 'print', 'colvis'
          ],
        },
        topStart: ['pageLength'],
        topEnd: {
          search: {
            placeholder: 'Cari:'
          },
        },
        bottomStart: 'info',
        bottomEnd: 'paging'
      },

      language: {
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data yang ditampilkan",
        infoFiltered: "(difilter dari _MAX_ total data)",
        zeroRecords: "Tidak ada data yang cocok",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Selanjutnya",
          previous: "Sebelumnya"
        }
      }
    });


  });
  </script>