<!-- Modal for Editing Sampah -->
<?php foreach ( $data_harga_sampah as $dhs ) : ?>
  <div class="modal fade" id="hargaUpdate<?= $dhs->id_harga ?>" tabindex="-1"
       aria-labelledby="hargaUpdate<?= $dhs->id_harga ?>Label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-info" id="hargaUpdate<?= $dhs->id_harga ?>Label">Harga Sampah <i
               class="mdi mdi-pencil text-info align-middle"></i></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <h6 class="mb-3">Harga Transaksi Sampah <b class="text-primary"><?= $dhs->nama_sampah ?></b> periode saat ini
          </h6>


          <form class="forms-sample" id="hargaUpdate<?= $dhs->id_harga ?>"
                action="<?= base_url ( 'Edit-Harga-Sampah/' ) . $dhs->id_sampah ?>" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name (); ?>"
                   value="<?= $this->security->get_csrf_hash (); ?>" />
            <input type="text" name="id_sampah" value="<?= $dhs->id_sampah ?>" hidden>
            <h6>Apakah ada pembaruan harga?</h6>
            <p>Silahkan diupdate disini</p>

            <div class="form-group <?= form_error ( 'harga_per_kg' ) ? 'has-danger' : '' ?>">
              <label for="harga_per_kg">Harga Sampah <?= $dhs->nama_sampah ?></label>
              <input type="number" class="form-control" id="harga_per_kg" name="harga_per_kg"
                     value="<?= $dhs->harga_per_kg ?>" placeholder="Harga Sampah" required>
              <small class="text-small">*Harga per Kg</small>
              <?= form_error ( 'harga_per_kg', '<label class="error mt-2 text-danger">', '</label>' ); ?>
            </div>


            <div
                 class="form-group <?= form_error ( 'periode' ) ? 'has-danger' : '', form_error ( 'id_sampah' ) ? 'has-danger' : '' ?>">
              <label for="periode">Periode terakhir update</label>
              <input type="date" class="form-control" id="periode" name="periode" value="<?= $dhs->periode ?>"
                     placeholder="Periode" required min="<?= date ( 'Y-m-d', strtotime ( '-1 week' ) ) ?>"
                     max="<?= date ( 'Y-m-d' ) ?>">
              <?= form_error ( 'periode', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              <?= form_error ( 'id_sampah', '<label class="error mt-2 text-danger">', '</label>' ); ?>
            </div>

            <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger " onclick="confirmRollback(<?= $dhs->id_sampah ?>)">
                <i class=" mdi mdi-minus-circle align-middle"></i> Rollback
              </button>
              <button type="submit" class="btn btn-success"><i class="mdi mdi-plus-circle align-middle text-white"></i>
                Update </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



<?php endforeach; ?>

<script type="text/javascript">
  function confirmRollback(id_sampah) {
    $.ajax({
      type: "GET",
      url: '<?= base_url ( 'Get-Last-Harga-Sampah/' ) ?>' + id_sampah,
      success: function (data) {
        // Cek apakah data adalah objek JSON
        const response = JSON.parse(data);
        if (response.error) {
          Swal.fire("Error", response.error + "<br>Mungkin sudah lebih dari 1 minggu", "error");
        } else {
          // Jika data ditemukan, lanjutkan dengan proses
          const lastData = response;
          const message = `
          <div style="font-family: Arial, sans-serif; line-height: 1.5;">
            <strong>Data terakhir yang akan dirollback:</strong><br>
            <span style="font-weight: bold;">Sampah:</span> <span style="color: #d33;">${lastData.nama_sampah}</span><br>
            <span style="font-weight: bold;">Harga per Kg:</span> <span style="color: #d33;">${lastData.harga_per_kg}</span><br>
            <span style="font-weight: bold;">Periode:</span> <span style="color: #d33;">${lastData.periode}</span>
          </div>
        `;

          Swal.fire({
            title: 'Konfirmasi',
            html: message +
              "<br><small>Apakah yakin ingin melakukan rollback untuk sampah ini? <br> Semua transaksi yang menggunakan harga saat ini akan ikut terhapus!</small>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, rollback!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: "POST",
                url: '<?= base_url ( 'Rollback-Harga-Sampah/' ) ?>' + id_sampah,
                data: {
                  'id_sampah': id_sampah,
                },
                success: function (data) {
                  Swal.fire({
                    title: "Deleted!",
                    text: "Data berhasil dirollback.",
                    icon: "success"
                  });
                  window.location.href = '<?= base_url ( 'Manage-Sampah' ) ?>';
                },
                error: function (data) {
                  Swal.fire("Cancelled", "Data gagal dirollback.", "error");
                }
              });
            }
          });
        }
      },
      error: function () {
        Swal.fire("Error", "Gagal mengambil data terakhir.", "error");
      }
    });
  }
</script>