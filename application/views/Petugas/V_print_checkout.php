<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<title><?= $title; ?></title>
		<style>
			/* Tampilan di Browser */
			@media screen {
				body {
					font-family: Arial, sans-serif;
					font-size: 14px;
					width: 80mm;
					margin: 20px auto;
					padding: 10px;
					border: 1px dashed #ccc;
					box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
					background: white;
				}
			}

			/* Tampilan Cetak */
			@media print {
				body {
					font-family: Arial, sans-serif;
					font-size: 12px;
					width: 120mm;
					margin: 0;
					padding: 5px;
					-webkit-print-color-adjust: exact;
					print-color-adjust: exact;
				}

				@page {
					size: 80mm auto;
					margin: 0;
				}

				.header {
					text-align: center;
					margin-bottom: 10px;
					margin-top: 10px;
					vertical-align: middle;
				}

				.header img {
					width: 60px;
				}

				.header-text {
					display: inline-block;
					text-align: center;
					margin-left: 5px;
				}

				.header-text h3 {
					margin: 2px 0;
					/* font-size: 14px; */
					font-size: 24px;
					font-weight: bold;
				}

				.header-text p {
					margin: 2px 0;
					/* font-size: 10px; */
					font-size: 14px;
					line-height: 1.2;
				}

				table {
					width: 100%;
					border-collapse: collapse;
					font-size: 14px;
					margin: 5px 0;
				}

				.text-center {
					text-align: center;
				}

				.text-right {
					text-align: right;
				}

				.text-left {
					text-align: left;
				}

				hr {
					border-top: 1px dashed #000;
					margin: 5px 0;
				}

				.divider {
					border-top: 1px dashed #000;
					margin: 5px 0;
				}

				.footer {
					font-size: 14px;
					text-align: center;
					margin-top: 10px;
				}

				.bordered {
					border: 1px solid #000;
					padding: 2px;
				}
			}
		</style>
	</head>

	<body>
		<div class="header">
			<img src="<?= base_url ( 'assets/images/logo.webp' ); ?>" alt="Logo">
			<div class="header-text">
				<h3 class="text-left">BANK SAMPAH ARTHA LESTARI</h3>
				<p class="text-left">Jl. Meranti Tim. Dalam IV No.4, Padangsari, Banyumanik</p>
				<p class="text-left">Semarang, Jawa Tengah 50263</p>
			</div>
		</div>

		<div class="divider"></div>

		<table>
			<tr>
				<td class="text-left">No. Transaksi</td>
				<td>:</td>
				<td class="text-right"> <?= $kode_transaksi; ?></td>
			</tr>
			<tr>
				<td class="text-left">Tanggal</td>
				<td>:</td>
				<td class="text-right"> <?= date ( 'd-m-Y H:i', strtotime ( $tanggal_transaksi ) ); ?></td>
			</tr>
		</table>

		<div class="divider"></div>

		<table>
			<thead>
				<tr>
					<th class="text-left">Item</th>
					<th class="text-right">Berat</th>
					<th class="text-right">Harga<small>/kg</small> </th>
					<th class="text-right">Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left"><?= $nama_sampah; ?></td>
					<td class="text-right"><?= $berat; ?> kg</td>
					<td class="text-right">Rp. <?= $harga_per_kg; ?></td>
					<td class="text-right">Rp. <?= $total; ?></td>
				</tr>
			</tbody>
		</table>

		<div class="divider"></div>

		<table>
			<tr>
				<td class="text-left">SUB TOTAL</td>
				<td>:</td>
				<td class="text-right"> 1 x Rp. <?= $total; ?></td>
			</tr>
			<tr>
				<td class="text-left"><strong>TOTAL</strong></td>
				<td>:</td>
				<td class="text-right"><strong> Rp. <?= $total; ?></strong></td>
			</tr>
		</table>

		<div class="divider"></div>

		<div class="footer">
			<p>Terima kasih telah bertransaksi<br>
				di Bank Sampah Artha Lestari</p>
			<p>* Simpan struk ini sebagai bukti transaksi *</p>
		</div>

		<script>
			window.print();
			window.onafterprint = function () {
				setTimeout(function () {
					window.close();
				}, 500);
			};
		</script>
	</body>

</html>