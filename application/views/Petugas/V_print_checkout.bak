<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url () ?>assets/css/style.css">


    <title><?= $title; ?></title>
    <style>
      @media print {
        body {
          /* width: 21cm;
        height: 29.7cm;
        margin: 30mm 45mm 30mm 45mm; */
          -webkit-print-color-adjust: exact;
          /* Preserve colors */
        }
      }


      .total {
        font-weight: bold;
        font-size: 1.25rem;
      }
    </style>
  </head>

  <body>

    <div class="container-fluid">
      <div class="content-wrapper">
        <div class="row mb-3">
          <div class="col-12">
            <div class="card px-2">
              <div class="card-body">
                <div class=" d-flex flex-nowrap  align-items-center">
                  <div class="text-start">
                    <img class="img-fluid w-50" src="<?= base_url ( 'assets/images/logo.webp' ); ?>" alt="Logo">
                  </div>
                  <div class="text-end ms-auto w-100">
                    <h3 class="mb-2 mt-3"><b>Invoice</b></h3>
                    <table class="ms-auto ">
                      <tr>
                        <td><b>Invoice No</b></td>
                        <td><b> : </b></td>
                        <td class="text-end"><b>#<?= $kode_transaksi; ?></b></td>
                      </tr>
                      <tr>
                        <td>Invoice Date</td>
                        <td> : </td>
                        <td class="text-end"><?= date ( 'd-m-Y', strtotime ( $tanggal_transaksi ) ); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <hr>
                <div class="invoice-details d-flex justify-content-between">
                  <div class="text-start">
                    <p class="mt-3 mb-2"><b>Bank Sampah Artha Lestari</b></p>
                    <p>Jl. Meranti Tim. Dalam IV No.4,<br> Padangsari, Kec. Banyumanik,<br> Kota Semarang, Jawa Tengah
                      50263.</p>
                  </div>
                  <div class="text-end">
                    <!-- Optional: Add recipient details here -->
                  </div>
                </div>
                <div class="table-responsive mt-3">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Sampah</th>
                        <th class="text-end">Berat</th>
                        <th class="text-end">Harga <small>(/kg)</small></th>
                        <th class="text-end">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-left"><?= $nama_sampah; ?></td>
                        <td class="text-end"><?= number_format ( $berat / 1000, 2, ',', '.' ) . '/kg'; ?></td>
                        <td class="text-end">Rp. <?= number_format ( $harga_per_kg, 0, ',', '.' ); ?></td>
                        <td class="text-end">Rp. <?= $total ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="text-start mt-5">
                  <hr>
                  <table class="w-50">
                    <tr>
                      <td>Sub Total</td>
                      <td>:</td>
                      <td>1 x Rp. <?= $total ?></td>
                    </tr>
                    <tr>
                      <td>
                        <h4 class="total">Total</h4>
                      </td>
                      <td>
                        <h4 class="total">:</h4>
                      </td>
                      <td>
                        <h4 class="total">Rp. <?= $total ?></h4>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      window.print();
    </script>
  </body>

</html>