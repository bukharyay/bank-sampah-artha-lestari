<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Data Pengguna</h4>
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
              <div class="d-flex justify-content-start mb-3">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userAdd">
                  <i class="mdi mdi-account-plus align-middle"></i> Tambah Pengguna
                </button>
              </div>

              <table id="user_list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="10%">Avatar</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ( $data_users as $index => $us ) : ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td class="text-center">
                      <img src="<?= base_url ( 'assets/profile/avatars/' . ( $us->avatar ?? 'default.png' ) ); ?>"
                           alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
                    </td>
                    <td><?= htmlspecialchars ( $us->username ) ?></td>
                    <td><?= htmlspecialchars ( $us->email ) ?></td>
                    <td><?= htmlspecialchars ( $us->nama ?? ucfirst ( $us->role ) ) ?></td>
                    <td><?= htmlspecialchars ( $us->role ) ?></td>
                    <td class="text-center">
                      <?php if ( $us->role !== 'admin' ) : ?>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-warning " data-toggle="tooltip" title="Edit"
                                data-bs-toggle="modal" data-bs-target="#userEdit<?= $us->id_user ?>">
                          <i class="mdi mdi-account-edit  align-middle"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info " data-toggle="tooltip" title="Detail"
                                data-bs-toggle="modal" data-bs-target="#userDetail<?= $us->id_user ?>">
                          <i class="mdi mdi-account-question align-middle"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger " data-toggle="tooltip" title="Hapus"
                                data-bs-toggle="modal" data-bs-target="#userHapus<?= $us->id_user ?>">
                          <i class="mdi mdi-account-remove  align-middle"></i>
                        </button>
                      </div>
                      <?php else : ?>
                      <button type="button" class="btn btn-light btn-sm">
                        <i class="mdi mdi-key text-warning align-middle"></i> Admin
                      </button>
                      <?php endif; ?>
                    </td>
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

  <?php
  // Load modals
  $this->load->view ( 'Admin/modals/modal_add_user' );
  $this->load->view ( 'Admin/modals/modal_edit_user' );
  $this->load->view ( 'Admin/modals/modal_detail_user' );
  $this->load->view ( 'Admin/modals/modal_delete_user' );
  ?>

  <script type="text/javascript">
  $(document).ready(function() {
    // Initialize DataTable with advanced features
    const userTable = $('#user_list').DataTable({
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

    // Form validation
    $('.forms-sample').on('submit', function(e) {
      const form = $(this);
      const requiredInputs = form.find('[required]');
      let isValid = true;

      requiredInputs.each(function() {
        if (!$(this).val().trim()) {
          isValid = false;
          return false;
        }
      });

      if (!isValid) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Validasi Error',
          text: 'Semua field yang wajib harus diisi!'
        });
        return false;
      }

      // Confirm deletion
      if (form.data('confirm') === 'delete') {
        e.preventDefault();
        Swal.fire({
          title: 'Konfirmasi Hapus',
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.off('submit').submit();
          }
        });
      }
    });
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip({
      boundary: 'window'
    });


    // Auto-hide alerts
    $('.alert').delay(5000).fadeOut(500);

    // Password visibility toggle
    $('.show-password').on('change', function() {
      const target = $(this).data('target');
      const input = $(`#${target}`);
      input.attr('type', this.checked ? 'text' : 'password');
    });
  });
  </script>