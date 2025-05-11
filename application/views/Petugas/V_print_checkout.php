<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $title; ?></title>
		<style>
			@media print {
				body {
					font-family: Arial, sans-serif;
					font-size: 12px;
					width: 80mm;
					margin: 0;
					padding: 5px;
					-webkit-print-color-adjust: exact;
				}

				.no-print {
					display: none !important;
				}

				table {
					width: 100%;
					border-collapse: collapse;
				}

				.text-center {
					text-align: center;
				}

				.text-right {
					text-align: right;
				}

				hr {
					border-top: 1px dashed #000;
					margin: 5px 0;
				}

				.bordered {
					border: 1px solid #000;
					padding: 3px;
				}
			}

			@page {
				size: auto;
				margin: 0;
			}
		</style>
	</head>

	<body>
		<div class="text-center">
			<div class="d-flex">
				<div>
					<img width="30px" src="<?= base_url ( 'assets/images/logo.webp' ); ?>" alt="">
				</div>
				<div>
					<h3 style="margin: 0; font-size: 14px;">BANK SAMPAH ARTHA LESTARI</h3>
					<p style="margin: 0; font-size: 10px;">Jl. Meranti Tim. Dalam IV No.4, Padangsari, Banyumanik</p>
					<p style="margin: 0; font-size: 10px;">Semarang, Jawa Tengah 50263</p>
				</div>
			</div>

			<hr>

			<table>
				<tr>
					<td style="width: 40%;">No. Transaksi</td>
					<td>: <?= $kode_transaksi; ?></td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>: <?= date ( 'd-m-Y H:i', strtotime ( $tanggal_transaksi ) ); ?></td>
				</tr>
			</table>

			<hr>

			<table>
				<thead>
					<tr>
						<th class="bordered" style="width: 50%;">Item</th>
						<th class="bordered text-right">Berat</th>
						<th class="bordered text-right">Harga</th>
						<th class="bordered text-right">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="bordered"><?= $nama_sampah; ?></td>
						<td class="bordered text-right"><?= number_format ( (float) $berat / 1000, 2, ',', '.' ); ?> kg</td>
						<td class="bordered text-right">Rp <?= number_format ( (float) $harga_per_kg, 0, ',', '.' ); ?></td>
						<td class="bordered text-right">Rp <?= number_format ( (float) $total, 0, ',', '.' ); ?></td>
					</tr>
				</tbody>
			</table>

			<hr>

			<table style="margin-top: 10px;">
				<tr>
					<td style="width: 60%;">SUB TOTAL</td>
					<td class="text-right">Rp <?= number_format ( (float) $total, 0, ',', '.' ); ?></td>
				</tr>
				<tr>
					<td><strong>TOTAL</strong></td>
					<td class="text-right"><strong>Rp <?= number_format ( (float) $total, 0, ',', '.' ); ?></strong></td>
				</tr>
			</table>

			<hr>

			<p style="font-size: 10px; margin-top: 15px;" class="text-center">
				Terima kasih telah bertransaksi<br>
				di Bank Sampah Artha Lestari
			</p>

			<p style="font-size: 8px; margin-top: 10px;" class="text-center">
				* Simpan struk ini sebagai bukti transaksi *
			</p>
		</div>

		<script>
			window.print();
			window.onafterprint = function () {
				window.close();
			};
		</script>
	</body>

</html>