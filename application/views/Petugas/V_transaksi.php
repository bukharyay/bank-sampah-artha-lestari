<div class="main-panel">
  <div class="content-wrapper">
    <div class="row mb-3 d-flex">
      <!-- Form Transaksi Column -->
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Form Transaksi</h4>
            <div class="row">
              <div class="col-12">
                <?php $this->load->view ( 'components/alert_messages' ); ?>
                <div id="alert-container"></div>
                <form class="pt-3" method="POST" id="form_transaksi">
                  <div class="row justify-content-center w-auto mx-auto">
                    <!-- Left Column -->
                    <div class="col-12 col-sm-12 col-md-10 col-lg-6">
                      <div class="form-group">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi"
                               value="<?= $kode_transaksi ?>" placeholder="Kode Transaksi" readonly>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Pilih Nasabah</label>
                        <select class="form-control js-example-basic-single select2-custom" id="id_nasabah_sel"
                                name="id_nasabah" required>
                        </select>
                        <div class="invalid-feedback">Nasabah harus dipilih</div>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Catatan Transaksi <small>(Optional)</small></label>
                        <textarea class="form-control" name="catatan_transaksi" id="catatan_transaksi" rows="3"
                                  placeholder="Catatan Transaksi" style="height: 44px;"></textarea>
                      </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-12 col-sm-12 col-md-10 col-lg-6">
                      <div class="form-group">
                        <label class="form-label">Tanggal Transaksi</label>
                        <input type="text" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi"
                               value="<?= date ( 'd F Y' ) ?>" placeholder="Tanggal Transaksi" readonly>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Pilih Sampah</label>
                        <select class="form-control js-example-basic-single select2-custom" id="id_sampah_sel"
                                name="id_sampah" required>
                        </select>
                        <div class="invalid-feedback">Sampah harus dipilih</div>
                      </div>

                      <div class="form-group">
                        <label class="form-label">Berat Sampah <small>(/gram)</small></label>
                        <input type="number" class="form-control" id="berat" name="berat"
                               placeholder="Masukkan Berat Sampah" min="1" required>
                        <div class="invalid-feedback">Berat harus diisi</div>
                      </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-3 d-flex justify-content-end">
                      <button type="submit" class="btn btn-success btn-lg fw-bolder fs-6 my-2 btn-submit w-100">
                        Diterima <i class="icon-check m-0 p-1 fw-bolder fs-6"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- History Transaksi Column -->
      <div class="col-6">
        <div class="card h-100">
          <div class="card-body">
            <h4 class="card-title">History Transaksi</h4>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table id="history_terakhir" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th colspan="4" class="text-center">Diterima Terakhir</th>
                      </tr>
                      <tr>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nasabah</th>
                        <th class="text-center">Sampah</th>
                        <th class="text-center">Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ( is_array ( $history_transaksi_terakhir ) || is_object ( $history_transaksi_terakhir ) ) : ?>
                        <?php foreach ( $history_transaksi_terakhir as $htt ) : ?>
                          <tr>
                            <td class="text-center"><?= htmlspecialchars ( $htt->kode_transaksi ) ?></td>
                            <td><?= htmlspecialchars ( $htt->nama ) ?></td>
                            <td>
                              <?= htmlspecialchars ( $htt->nama_sampah ) . ' ' . number_format ( $htt->berat / 1000, 2, ',', '.' ) . '/kg' ?>
                            </td>
                            <td>
                              <div class="text-muted">
                                <i class="mdi mdi-calendar align-middle me-2"></i>
                                <?= date ( 'd F Y', strtotime ( $htt->tanggal_transaksi ) ) ?>
                              </div>
                              <div class="text-muted">
                                <i class="mdi mdi-clock align-middle me-2"></i>
                                <?= date ( 'H:i', strtotime ( $htt->tanggal_transaksi ) ) ?>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Transaksi Table -->
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="card-title text-center">Data Transaksi</h4>
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table id="history_transaksi" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Nasabah</th>
                    <th class="text-center">Sampah</th>
                    <th class="text-center">Berat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ( is_array ( $history_transaksi ) || is_object ( $history_transaksi ) ) : ?>
                    <?php foreach ( $history_transaksi as $ht ) : ?>
                      <tr>
                        <td class="text-center"><?= htmlspecialchars ( $ht->kode_transaksi ) ?></td>
                        <td><?= htmlspecialchars ( $ht->nama ) . ' [ RW ' . $ht->rt . ' / RT ' . $ht->rw . ' ]' ?></td>
                        <td><?= htmlspecialchars ( $ht->nama_sampah ) ?></td>
                        <td><?= number_format ( $ht->berat / 1000, 2, ',', '.' ) . '/kg' ?></td>
                        <td class="text-center">
                          <?php
                          $badgeClass     = '';
                          $icon           = '';
                          $status_text    = '';
                          $status_tooltip = '';
                          $button_status  = '';

                          switch (htmlspecialchars ( $ht->status ))
                            {
                            case 'diterima':
                              $badgeClass = 'badge badge-primary';
                              $icon = '<i class="fas fa-check-circle"></i>';
                              $status_text = 'Diterima';
                              $status_tooltip = 'Menunggu disetorkan kepada Pelapak';
                              $button_status = '<a href="' . base_url ( 'Checkout-Transaksi/' . $ht->kode_transaksi ) . '" class="btn btn-primary btn-sm fw-bold mt-2">Checkout?</a>';
                              break;
                            case 'dicatat':
                              $badgeClass = 'badge badge-warning';
                              $icon = '<i class="fas fa-spinner fa-spin"></i>';
                              $status_text = 'Diproses';
                              $status_tooltip = 'Menunggu dicairkan oleh Ketua PKK';
                              break;
                            case 'dibawa':
                              $badgeClass = 'badge badge-success';
                              $icon = '<i class="fas fa-truck"></i>';
                              $status_text = 'Selesai';
                              $status_tooltip = 'Dana sudah diberikan kepada nasabah';
                              break;
                            default:
                              $badgeClass = 'badge badge-secondary';
                              $icon = '<i class="fas fa-question-circle"></i>';
                              break;
                            }
                          ?>
                          <label class="<?= $badgeClass ?> fw-bold" data-toggle="tooltip"
                                 title="<?= htmlspecialchars ( $status_tooltip ) ?>">
                            <?= $icon ?>     <?= $status_text ?>
                          </label><br>
                          <?= $button_status ?>
                        </td>
                        <td>
                          <div class="text-muted">
                            <i class="mdi mdi-calendar align-middle me-2"></i>
                            <?= date ( 'd F Y', strtotime ( $ht->tanggal_transaksi ) ) ?>
                          </div>
                          <div class="text-muted">
                            <i class="mdi mdi-clock align-middle me-2"></i>
                            <?= date ( 'H:i', strtotime ( $ht->tanggal_transaksi ) ) ?>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    /* Error state */
    .is-invalid~.select2-container .select2-selection {
      border-color: #dc3545 !important;
    }

    .is-valid~.select2-container--default .select2-selection--single .select2-selection__arrow {
      display: none;
    }

    .is-invalid~.select2-container--default .select2-selection--single .select2-selection__clear {
      display: none;
    }

    .is-valid~.select2-container .select2-selection {
      border-color: #198754 !important;
      padding-right: calc(1.5em + 0.75rem);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(1.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .is-invalid~.select2-container .select2-selection {
      border-color: #dc3545;
      padding-right: calc(1.5em + 0.75rem);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'  fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(1.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Focus state */
    .select2-custom+.select2-container.select2-container--focus .select2-selection {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
  </style>

  <script>
    $(document).ready(function () {
      // Initialize Select2
      function initSelect2(element, url, placeholder) {
        return $(element).select2({
          width: '100%',
          ajax: {
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                search: params.term || ''
              };
            },
            processResults: function (data) {
              return {
                results: data
              };
            },
            cache: true
          },
          placeholder: placeholder,
          language: {
            noResults: function () {
              return "Data tidak ditemukan";
            },
            searching: function () {
              return "Mencari...";
            }
          },
          allowClear: true
        }).on('select2:open', function () {
          setTimeout(function () {
            document.querySelector('.select2-search__field').focus();
          }, 0);
        }).on('change', function () {
          if ($(this).val()) {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
          }
          if (!$(this).val()) {
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
          }
        });
      }
      // Initialize both select2 elements
      initSelect2('#id_nasabah_sel', '<?= base_url ( 'Search-Nasabah' ) ?>', 'Pilih Nasabah');
      initSelect2('#id_sampah_sel', '<?= base_url ( 'Search-Sampah' ) ?>', 'Pilih Sampah');

      $('form input, form textarea').on('input change', function () {
        // const error = validateInput(this);
        const $form = $(this);
        const $feedback = $(this).next('.invalid-feedback');

        $form.find('[required]').each(function () {
          if (!$(this).val()) {
            $(this).addClass('is-invalid');
            $(`<div class="invalid-feedback">${error}</div>`).insertAfter(this);
          }
        });

        const value = this?.value?.trim() || '';
        if (this?.name == 'catatan_transaksi') {
          if (value.length < 1) {
            $(this).removeClass('is-valid');
          } else {
            $(this).addClass('is-valid');
          }
        } else {
          if (value.length < 1) {
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
          } else {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
          }
        }
      });

      // Form submission handler
      $('#form_transaksi').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $submitBtn = $('.btn-submit');
        let isValid = true;

        // Validate required fields
        $form.find('[required]').each(function () {
          if (!$(this).val()) {
            $(this).addClass('is-invalid');
            isValid = false;
          }
        });

        if (!isValid) {
          Swal.fire({
            title: 'Form Tidak Valid',
            text: 'Harap isi semua field yang wajib diisi',
            icon: 'error'
          });
          return;
        }

        // Disable button and show loading
        $submitBtn.prop('disabled', true)
          .html('<i class="mdi mdi-loading mdi-spin align-middle"></i> Menyimpan...');

        // Submit form via AJAX
        $.ajax({
          type: "POST",
          url: '<?= base_url ( 'Add-Transaksi' ) ?>',
          data: $form.serialize(),
          dataType: "json"
        })
          .done(function (response) {
            if (response.status === 'success') {
              Swal.fire({
                title: "Berhasil!",
                text: response.message || "Transaksi berhasil diterima",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                window.location.href = response.redirect || window.location.href;
              });
            } else {
              showFormErrors(response.errors);
            }
          })
          .fail(function (xhr) {
            let errorMsg = 'Terjadi kesalahan saat memproses permintaan';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
              showFormErrors(xhr.responseJSON.errors);
            } else {
              Swal.fire("Error", errorMsg, "error");
            }
          })
          .always(function () {
            $submitBtn.prop('disabled', false)
              .html('Diterima <i class="icon-check m-0 p-1 fw-bolder fs-6"></i>');
          });
      });

      // Function to display form errors
      function showFormErrors(errors) {
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Show new errors
        if (typeof errors === 'object') {
          $.each(errors, function (field, message) {
            const $field = $(`[name="${field}"]`);
            $field.addClass('is-invalid');
            $(`<div class="invalid-feedback">${message}</div>`).insertAfter($field);
          });
        } else {
          // Handle string errors
          $('#alert-container').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ${errors}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
        }

        // Scroll to first error
        $('html, body').animate({
          scrollTop: $('.is-invalid').first().offset().top - 100
        }, 500);
      }

      // Initialize DataTables
      $('[data-toggle="tooltip"]').tooltip();

      $('#history_terakhir').DataTable({
        lengthChange: false,
        searching: false,
        paginate: false,
        info: false,
        order: false,
      });

      $('#history_transaksi').DataTable({
        order: false,
        layout: {
          top: {
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
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