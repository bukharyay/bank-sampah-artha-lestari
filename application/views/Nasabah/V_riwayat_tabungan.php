<!-- End custom js for this page-->

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row mb-3">
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title text-center ">Riwayat Transaksi <br>
            <span class="text-primary">
              <?= $this->user_session->nama ?>
            </span>
          </h4>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="history_transaksi_nasabah" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">Kode</th>
                      <th class="text-center">Sampah</th>
                      <th class="text-center">Berat</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ( is_array ( $history_transaksi_nasabah ) || is_object ( $history_transaksi_nasabah ) ) : ?>
                    <?php foreach ( $history_transaksi_nasabah as $index => $htn ) : ?>
                    <tr>
                      <td><?= htmlspecialchars ( $htn->kode_transaksi ) ?></td>
                      <td>
                        <?= htmlspecialchars ( $htn->nama_sampah ) ?>
                      </td>
                      <td>
                        <?= number_format ( $htn->berat / 1000, 2, ',', '.' ) . '/kg' ?>
                      </td>
                      <td class="text-center">
                        <?php
                            $badgeClass     = '';
                            $icon           = '';
                            $status_text    = '';
                            $status_tooltip = '';

                            switch (htmlspecialchars ( $htn->status ))
                              {
                              case 'diterima':
                                $badgeClass = 'badge badge-primary';
                                $icon = '<i class="fas fa-check-circle"></i>';
                                $status_text = 'Diterima';
                                $status_tooltip = 'Menunggu disetorkan kepada Pelapak';
                                break;
                              case 'dicatat':
                                $badgeClass = 'badge badge-warning';
                                $icon = '<i class="fas fa-spinner fa-spin"></i>';
                                $status_text = 'Diproses';
                                $status_tooltip = 'Menunggu dicairkan oleh Nasabah';
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
                          <?= $icon ?> <?= $status_text ?>
                        </label><br>
                      </td>
                      <td><?= number_format ( ( $htn->total_harga ?? 0 ), 2, ',', '.' ) ?></td>
                      <td>
                        <div class="text-muted ">
                          <i class="mdi mdi-calendar align-middle me-2"></i>
                          <?= date ( 'd F Y', strtotime ( $htn->tanggal_transaksi ?? '' ) ) ?>
                        </div>
                        <div class="text-muted ">
                          <i class="mdi mdi-clock align-middle me-2"></i>
                          <?= date ( 'H:i', strtotime ( $htn->tanggal_transaksi ?? '' ) ) ?>
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
    <div class="row mb-3">
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title text-center ">Riwayat Penarikan Dana <br>
            <span class="text-primary">
              <?= $this->user_session->nama ?>
            </span>
          </h4>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="history_penarikan_rt" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Nasabah</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Tanggal</th>
                      <th class="text-center">Nominal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ( is_array ( $riwayat_dana ) || is_object ( $riwayat_dana ) ) : ?>
                    <?php $total_penarikan = 0; ?>
                    <?php foreach ( $riwayat_dana as $index => $rd ) : ?>
                    <tr>
                      <td><?= htmlspecialchars ( ++$index ?? '' ) ?></td>
                      <td>
                        <?= htmlspecialchars ( $rd->nama ?? '' ) . ' [ RT ' . ( $rd->rt ?? '' ) . ' / RW ' . ( $rd->rw ?? '' ) . ' ]' ?>
                      </td>
                      <td class="text-center">
                        <?= ( $rd->status ?? '' ) == 'berhasil' ? "<label class='badge badge-success fw-bold'><i class='fas fa-truck'></i> {$rd->status} </label>" : "<label class='badge badge-danger fw-bold'><i class='fas fa-truck'></i> {$rd->status} </label>" ?>
                      </td>
                      <td>
                        <div class="text-muted ">
                          <i class="mdi mdi-calendar align-middle me-2"></i>
                          <?= date ( 'd F Y', strtotime ( $rd->tanggal_penarikan ?? '' ) ) ?>
                        </div>
                        <div class="text-muted ">
                          <i class="mdi mdi-clock align-middle me-2"></i>
                          <?= date ( 'H:i', strtotime ( $rd->tanggal_penarikan ?? '' ) ) ?>
                        </div>
                      </td>
                      <td>
                        Rp. <?= number_format ( $rd->jumlah_penarikan ?? 0, 2, ',', '.' ) ?>
                      </td>
                    </tr>
                    <?php $total_penarikan += $rd->jumlah_penarikan ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4" style=" text-align:right">Total:</th>
                      <th>Rp. <?= number_format ( $total_penarikan ?? 0, 2, ',', '.' ) ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>

  <script type="text/javascript">
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $('#history_transaksi_nasabah').DataTable({
      lengthChange: true,
      searching: true,
      paginate: true,
      info: true,
      order: true,
      language: {
        lengthMenu: "Tampilkan _MENU_ Riwayat Transaksi",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ Riwayat Transaksi",
        infoEmpty: "Tidak ada Riwayat Transaksi yang ditampilkan",
        infoFiltered: "(difilter dari _MAX_ total Riwayat Transaksi)",
        zeroRecords: "Tidak ada Riwayat Transaksi yang cocok",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Selanjutnya",
          previous: "Sebelumnya"
        }
      },

    });


    $('#history_penarikan_rt').DataTable({
      order: false,
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
        lengthMenu: "Tampilkan _MENU_ Riwayat Penarikan Dana",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ Riwayat Penarikan Dana",
        infoEmpty: "Tidak ada Penarikan Dana yang ditampilkan",
        infoFiltered: "(difilter dari _MAX_ total Riwayat Penarikan Dana)",
        zeroRecords: "Tidak ada Riwayat Penarikan Dana yang cocok",
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