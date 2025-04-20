<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Data Kategori Sampah</h4>
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
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#sampahjenisAdd">
                  <i class=" mdi mdi-plus-circle align-middle"></i> Tambah Data Kategori Sampah
                </button>
              </div>

              <table id="jenis_sampah_list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Jenis Sampah</th>
                    <th width="20%">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ( $data_jenis_sampah as $index => $djs ) : ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars ( $djs->jenis_sampah ) ?></td>
                    <td class="text-center">
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" title="Edit"
                                data-bs-toggle="modal" data-bs-target="#sampahjenisEdit<?= $djs->id_jenis_sampah ?>">
                          <i class="mdi mdi-pencil align-middle"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Hapus"
                                data-bs-toggle="modal" data-bs-target="#sampahjenisHapus<?= $djs->id_jenis_sampah ?>">
                          <i class="mdi mdi-delete  align-middle"></i>
                        </button>
                      </div>
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
  $this->load->view ( 'Petugas/modals/modal_add_jenis_sampah' );
  $this->load->view ( 'Petugas/modals/modal_edit_jenis_sampah' );
  $this->load->view ( 'Petugas/modals/modal_delete_jenis_sampah' );
  ?>

  <script type="text/javascript">
  $(document).ready(function() {
    // Initialize DataTable with advanced features
    const sampahTable = $('#jenis_sampah_list').DataTable({
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
      const sampahInput = form.find('[name="sampah"]');
      const jenisInput = form.find('[name="id_jenis_sampah"]');

      if (!sampahInput.val().trim() || !jenisInput.val()) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Validasi Error',
          text: 'Semua field harus diisi!'
        });
        return false;
      }

      // Confirm submission
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

    // Auto-hide alerts
    $('.alert').delay(5000).fadeOut(500);

    // Initialize Select2 for better dropdown experience
    $('.select2').select2({
      theme: 'bootstrap4',
      width: '100%',
      placeholder: 'Pilih Jenis Sampah'
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip({
      boundary: 'window'
    });
  });
  </script>