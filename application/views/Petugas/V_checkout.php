<!-- End custom js for this page-->

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row mb-3">
      <div class="col-12 col-lg-10 col-xl-8  ">
        <div class="card px-2">
          <div class="card-body">
            <div class="container-fluid d-flex flex-column  flex-md-row align-items-center justify-content-md-between">
              <div class="col-6 col-md-3  col-lg-3 ">
                <img class="img-fluid " src="<?= base_url ( 'assets/images/logo.webp' ) ?>" alt="">
              </div>
              <div class="col-6 col-md-9 col-lg-9">
                <h1 class="mb-2 mt-3 text-end"><b>Invoice</b></h1>
                <table class="ms-auto">
                  <tr>
                    <td><b>Invoice no</b></td>
                    <td><b> : </b></td>
                    <td class="text-end"><b>#<?= $kode_transaksi ?></b></td>
                  </tr>
                  <tr>
                    <td>Invoice Date</td>
                    <td> : </td>
                    <td class="text-end"><?= date ( 'd-m-Y', strtotime ( $tanggal_transaksi ) ) ?></td>
                  </tr>
                </table>
              </div>
              <hr>
            </div>
            <div class="container-fluid d-flex justify-content-between">
              <div class="col-6 ps-0">
                <p class="mt-3 mb-2"><b>Bank Sampah Artha Lestari</b></p>
                <p>Jl. Meranti Tim. Dlm IV No.4, <br> Padangsari, Kec. Banyumanik, <br> Kota Semarang, Jawa Tengah
                  50263.</p>
              </div>
              <div class="col-6 pr-0">
                <!-- <p class="mt-3 mb-2 text-end"><b>Invoice to</b></p>
								<p class="text-end">Pelapak</p> -->
              </div>
            </div>
            <div class="container-fluid mt-3 d-flex justify-content-center w-100">
              <div class="table-responsive w-100">
                <table class="table">
                  <thead>
                    <tr class="bg-dark text-white">
                      <th>#</th>
                      <th>Sampah</th>
                      <th class="text-right">Berat</th>
                      <th class="text-right">Harga <small>(/kg)</small> </th>
                      <th class="text-right">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="text-right">
                      <td class="text-left">1</td>
                      <td class="text-left"><?= $nama_sampah ?></td>
                      <td>
                        <?= number_format ( $berat / 1000, 2, ',', '.' ) . '/kg' ?>
                      </td>
                      <td>Rp. <?= $harga_per_kg ?></td>
                      <td>Rp. <?= $total ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="container-fluid mt-5 w-100">
              <!-- <p class="text-right mb-2">Sub - Total amount: $12,348</p> -->
              <!-- <p class="text-right">vat (10%) : $138</p> -->
              <p class="text-right">Sub Total : 1 x Rp. <?= $total ?></p>
              <p class="text-right">Pajak : 0% </p>
              <h4 class="text-right mb-5">Total : Rp. <?= $total ?></h4>
              <hr>
            </div>
            <div class="container-fluid w-100">
              <form method="post" id="form_checkout">
                <a href="<?= base_url ( 'Manage-Transaksi' ) ?>" class="btn btn-secondary fw-bolder fs-6 my-2"><i
                    class=" icon-action-undo m-0 p-1 fw-bolder fs-6"></i>Back</a>
                <a href="<?= base_url ( 'Checkout-Print/' ) . $kode_transaksi ?>" target="_blank"
                  class="btn btn-dark fw-bolder fs-6 my-2"><i class="icon-printer m-0 p-1 fw-bolder fs-6"></i>Print</a>
                <input type="hidden" id="kode_transaksi" name="kode_transaksi" value="<?= $kode_transaksi ?>">
                <button type="submit" class="btn btn-success fw-bolder fs-6 my-2"><i
                    class="icon-basket-loaded m-0 p-1 fw-bolder fs-6"></i>Checkout</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function() {
    $('#form_checkout').on('submit', function(e) {
      e.preventDefault();
      const formData = $(this).serialize();
      const kodeTransaksi = $('#kode_transaksi').val();
      Swal.fire({
        title: 'Konfirmasi',
        html: "<br><small>Apakah yakin ingin melakukan checkout untuk transaksi ini? <br> Status transaksi akan diproses!</small>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#34B1AA',
        cancelButtonColor: '#1E283D',
        confirmButtonText: 'Ya, Checkout!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: '<?= base_url ( 'Checkout-Process' ) ?>',
            data: formData,
            dataType: "json",
            success: function(response) {
              Swal.fire({
                title: "Success!",
                text: "Transaksi " + kodeTransaksi + " berhasil dicheckout!",
                icon: "success"
              }).then(() => {
                location.href = "<?= base_url ( 'Manage-Transaksi' ) ?>";
              });
            },
            error: function(data) {
              let responseData = data.responseJSON;
              Swal.fire("Error", "<small class='text-danger'>" + responseData.errors + "</small>",
                "error");
              let alertHtml = `
									<div class="alert alert-danger alert-dismissible show fade" role="alert">
											<strong>Oops!</strong> Ada beberapa kesalahan dalam pengisian form:
											<ul>
													<li>${responseData.errors}</li>
											</ul>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
							`;

              $('#alert-container').html(alertHtml);
            }
          });
        }
      })

    });
  });
  </script>