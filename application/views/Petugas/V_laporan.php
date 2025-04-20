<!-- End custom js for this page-->

<div class="main-panel">
  <div class="content-wrapper">

    <div class="row">
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title">Filter Laporan</h4>
          <form id="filterForm" method="get" action="<?= site_url ( 'Laporan-Transaksi' ) ?>">
            <div class="row">
              <!-- Status Filter -->
              <div class="col-md-2">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                    <option value="">Semua Status</option>
                    <option value="diterima"
                            <?= ( $current_filters[ 'status' ] ?? '' ) == 'diterima' ? 'selected' : '' ?>>
                      Diterima
                    </option>
                    <option value="dicatat"
                            <?= ( $current_filters[ 'status' ] ?? '' ) == 'dicatat' ? 'selected' : '' ?>>
                      Dicatat
                    </option>
                    <option value="dibawa" <?= ( $current_filters[ 'status' ] ?? '' ) == 'dibawa' ? 'selected' : '' ?>>
                      Dibawa
                    </option>
                  </select>
                </div>
              </div>

              <!-- Date Range -->
              <div class="col-md-2">
                <div class="form-group">
                  <label>Tanggal Awal</label>
                  <input type="date" class="form-control" name="start_date"
                         value="<?= $current_filters[ 'start_date' ] ?? '' ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" class="form-control" name="end_date"
                         value="<?= $current_filters[ 'end_date' ] ?? '' ?>">
                </div>
              </div>

              <!-- RT RW Filter -->
              <div class="col-md-2">
                <div class="form-group">
                  <label>RT / RW</label>
                  <select class="form-control" name="id_rt">
                    <option value="">Semua RT RW</option>
                    <?php foreach ( $rt_list as $rt ) : ?>
                    <option value="<?= $rt->id_rt ?>"
                            <?= ( $current_filters[ 'id_rt' ] ?? '' ) == $rt->id_rt ? 'selected' : '' ?>>
                      RT <?= $rt->rt ?> / RW <?= $rt->rw ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>


              <!-- Search -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>Cari (Nama/Kode/Sampah)</label>
                  <input type="text" class="form-control" name="search"
                         value="<?= $current_filters[ 'search' ] ?? '' ?>" placeholder="Cari...">
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="col-md-12 d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="fas fa-filter"></i> Filter
                </button>
                <a href="<?= site_url ( 'Laporan-Transaksi' ) ?>" class="btn btn-secondary">
                  <i class="fas fa-sync-alt"></i> Reset
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
    $(document).ready(function() {
      // Date validation
      $('#filterForm').submit(function(e) {
        var startDate = $('input[name="start_date"]').val();
        var endDate = $('input[name="end_date"]').val();

        if (startDate && endDate && startDate > endDate) {
          e.preventDefault();
          Swal.fire({
            title: 'Peringatan',
            text: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir',
            icon: 'warning'
          });
        }
      });

    });
    </script>

    <div class="row mb-3">
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title  ">Riwayat Transaksi</h4>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="history_penarikan_rt" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th class="text-center">Kode</th>
                      <th class="text-center">RT / RW</th>
                      <th class="text-center">Nasabah</th>
                      <th class="text-center">Sampah</th>
                      <th class="text-center">Berat</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ( is_array ( $history_transaksi ) || is_object ( $history_transaksi ) ) : ?>
                    <?php $total_berat   = 0;
                      $total_nominal = 0;
                      ?>
                    <?php foreach ( $history_transaksi as $index => $ht ) : ?>

                    <tr>
                      <td><?= htmlspecialchars ( $ht->kode_transaksi ) ?></td>
                      <td class="text-center">
                        <?= htmlspecialchars ( '[ RT-' . ( $ht->rt ?? 0 ) . ' / RW-' . ( $ht->rw ?? 0 ) . ' ]' ) ?>
                      </td>
                      <td><?= htmlspecialchars ( $ht->nama ) ?></td>
                      <td>
                        <?= htmlspecialchars ( $ht->nama_sampah ) ?>
                      </td>
                      <td>
                        <?= number_format ( $ht->berat / 1000, 2, ',', '.' ) . '/kg' ?>
                      </td>
                      <td>
                        <?= 'Rp. ' . number_format ( (float) $ht->total_harga, 2, ',', '.' ) ?>
                      </td>
                      <td class="text-center">
                        <?php
                            $badgeClass     = '';
                            $icon           = '';
                            $status_text    = '';
                            $status_tooltip = '';

                            switch (htmlspecialchars ( $ht->status ))
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
                          <?= $icon ?> <?= $status_text ?>
                        </label><br>
                      </td>
                      <td>
                        <div class="text-muted ">
                          <i class="mdi mdi-calendar align-middle me-2"></i>
                          <?= date ( 'd F Y', strtotime ( $ht->tanggal_transaksi ) ) ?>
                        </div>
                        <div class="text-muted ">
                          <i class="mdi mdi-clock align-middle me-2"></i>
                          <?= date ( 'H:i', strtotime ( $ht->tanggal_transaksi ) ) ?>
                        </div>
                      </td>
                    </tr>
                    <?php $total_berat += ( $ht->berat / 1000 );
                        $total_nominal += $ht->total_harga;
                        ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4" style=" text-align:right">Total Berat : </th>
                      <th colspan="2"><?= number_format ( $total_berat ?? 0, 2, ',', '.' ) ?> /kg </th>
                      <th></th>
                      <th></th>
                    </tr>
                    <tr>
                      <th colspan="4" style=" text-align:right">Total Harga :</th>
                      <th colspan="2">Rp. <?= number_format ( $total_nominal ?? 0, 2, ',', '.' ) ?></th>
                      <th></th>
                      <th></th>
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

    $('#data_tabungan_nasabah').DataTable({
      lengthChange: false,
      searching: false,
      paginate: false,
      info: false,
      order: false,
    });
    $('#riwayat_tabungan_nasabah').DataTable({
      lengthChange: false,
      searching: false,
      paginate: false,
      info: false,
      order: false,
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