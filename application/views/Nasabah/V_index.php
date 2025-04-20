<div class="main-panel w-100 mx-auto">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<div class="home-tab">
					<div class="tab-content tab-content-basic">
						<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
							<div class="row">
								<p class="text-muted">
									Periode :
									<?= date('d-M-Y', strtotime($periode_transaksi->tanggal_awal ?? date('Y-m-d'))) . ' - ' . date('d-M-Y', strtotime($periode_transaksi->tanggal_akhir ?? date('Y-m-d'))) ?>
								</p>
								<div class="col-12">
									<div class="row">
										<div class="col-12 col-sm-6 col-md-6 col-xl-3 grid-margin stretch-card">
											<div class="card">
												<div class="card-body d-flex flex-column justify-content-center align-items-center">
													<h3 class="card-title text-center">Tabungan</h3>
													<div class="d-flex flex-row justify-content-center">
														<i class="icon-wallet icon-md" aria-label="Wallet Icon"></i>
													</div>
													<div class="text-center">
														<h2 class="my-3 fw-bold">Rp.
															<?= number_format((float) ($total_tabungan ?? 0), 0, ',', '.') ?>
														</h2>
														<p>Saldo</p>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-md-6 col-xl-3 grid-margin stretch-card">
											<div class="card">
												<div class="card-body d-flex flex-column justify-content-center align-items-center">
													<h3 class="card-title text-center fw-bold">Sampah</h3>
													<div class="d-flex flex-row justify-content-center">
														<i class="icon-speedometer icon-md" aria-label="Speedometer Icon"></i>
													</div>
													<div class="text-center">
														<h2 class="my-3 fw-bold">
															<?= number_format((float) ($total_berat / 1000 ?? 0), 0, ',', '.') ?> Kg
														</h2>
														<p>Total Berat</p>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-md-6 col-xl-3 grid-margin stretch-card">
											<div class="card">
												<div class="card-body d-flex flex-column">
													<div class="d-flex flex-column">
														<h3 class="card-title text-center fw-bold">Kategori Sampah</h3>
														<div class="d-flex flex-row justify-content-center">
															<i class="icon-puzzle icon-md" aria-label="Puzzle Icon"></i>
														</div>
														<div class="text-center">
															<h2 class="my-3 fw-bold">
																<?= $setor_sampah->sampah_disetor ?? 0 ?>
															</h2>
															<p>Jenis Sampah Disetorkan</p>
														</div>
													</div>
													<div class="progress progress-md w-100 my-2">
														<div class="progress-bar bg-success" style="width: <?= (($setor_sampah->total_sampah ?? 0) > 0) ? round(($setor_sampah->sampah_disetor / $setor_sampah->total_sampah) * 100) : 0 ?>%" role="progressbar" aria-valuenow="<?= $setor_sampah->sampah_disetor ?? 0 ?>" aria-valuemin="0" aria-valuemax="<?= $setor_sampah->total_sampah ?? 0 ?>">
														</div>
													</div>
													<div class="d-flex flex-row justify-content-between">
														<p class="text-muted my-1"><?= $setor_sampah->sampah_disetor ?? 0 ?> jenis</p>
														<p class="text-muted my-1">dari <?= $setor_sampah->total_sampah ?? 0 ?> jenis</p>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-md-6 col-xl-3 grid-margin stretch-card">
											<div class="card">
												<div class="card-body d-flex flex-column">
													<div class="d-flex flex-column">
														<h3 class="card-title text-center fw-bold">Wilayah</h3>
														<div class="d-flex flex-row justify-content-center">
															<i class="icon-home icon-md" aria-label="Puzzle Icon"></i>
														</div>
														<div class="text-center">
															<h5 class="mt-2 fw-bold">Ketua PKK</h5>
															<div class="badge badge-pill badge-success"><i class="icon-star"></i>
																<?= $wilayah->nama_ketua_pkk ?? ' - ' ?></div>
														</div>
														<div class="text-center">
															<h2 class="my-3 fw-bold">
																RT <?= $wilayah->rt ?? '' ?> / RW <?= $wilayah->rw ?? '' ?>
															</h2>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">

								<div class="col-12 col-lg-7 d-flex flex-column">
									<div class="row flex-grow">
										<div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
											<div class="card ">
												<div class="card-body">
													<div class="d-sm-flex justify-content-between align-items-start">
														<div>
															<h4 class="card-title card-title-dash">Riwayat Setoran Sampah</h4>
															<p class="card-subtitle card-subtitle-dash">Grafik riwayat transaksi setoran sampah
																<?= $this->user_session->username ?> di Bank Artha Lestari
															</p>
														</div>
														<div id="grafik_history_transaksi"></div>
													</div>
													<div class="chartjs-wrapper mt-5">
														<canvas id="data_grafik_history_transaksi"></canvas>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<script>
									if ($("#data_grafik_history_transaksi").length) {
										var graphGradient = document.getElementById("data_grafik_history_transaksi").getContext('2d');
										var saleGradientBg = graphGradient.createLinearGradient(5, 0, 5, 100);
										saleGradientBg.addColorStop(0, 'rgba(26, 115, 232, 0.18)');
										saleGradientBg.addColorStop(1, 'rgba(26, 115, 232, 0.02)');

										var salesTopData = {
											labels: <?= json_encode($label_transaksi) ?>,
											datasets: [{
												label: 'Total Berat Sampah',
												data: <?= json_encode($data_history_transaksi) ?>,
												backgroundColor: saleGradientBg,
												borderColor: [
													'#1F3BB3',
												],
												borderWidth: 1.5,
												fill: true,
												pointBorderWidth: 1,
												pointRadius: 4,
												pointHoverRadius: 6,
												pointBackgroundColor: '#1F3BB3',
												pointBorderColor: '#fff',
											}]
										};

										var salesTopOptions = {
											responsive: true,
											maintainAspectRatio: false,
											scales: {
												yAxes: [{
													scaleLabel: {
														display: true,
														labelString: 'Total Berat (gram)',
														fontSize: 12,
														fontColor: '#6B778C'
													},
													gridLines: {
														display: false,
														drawBorder: false,
														color: "#F0F0F0",
														zeroLineColor: '#F0F0F0',
													},
													ticks: {
														beginAtZero: true,
														autoSkip: true,
														maxTicksLimit: 4,
														fontSize: 10,
														color: "#6B778C",
														callback: function(value) {
															return value + ' g';
														}
													}
												}],
												xAxes: [{
													scaleLabel: {
														display: true,
														labelString: 'Periode',
														fontSize: 12,
														fontColor: '#6B778C'
													},
													gridLines: {
														display: false,
														drawBorder: false,
													},
													ticks: {
														beginAtZero: false,
														autoSkip: true,
														maxTicksLimit: 7,
														fontSize: 10,
														color: "#6B778C"
													}
												}],
											},
											legend: false,
											legendCallback: function(chart) {
												var text = [];
												text.push('<div class="chartjs-legend"><ul>');
												for (var i = 0; i < chart.data.datasets.length; i++) {

													text.push('<li>');
													text.push('<span style="background-color:' + chart.data.datasets[i].borderColor + '">' +
														'</span>');
													text.push(chart.data.datasets[i].label + ' (gram)');
													text.push('</li>');
												}
												text.push('</ul></div>');
												return text.join("");
											},
											elements: {
												line: {
													tension: 0.4,
												}
											},
											tooltips: {
												backgroundColor: 'rgba(31, 59, 179, 1)',
												callbacks: {
													label: function(tooltipItem, data) {
														return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel + ' g';
													}
												}
											}
										};

										var salesTop = new Chart(graphGradient, {
											type: 'line',
											data: salesTopData,
											options: salesTopOptions
										});
										document.getElementById('grafik_history_transaksi').innerHTML = salesTop.generateLegend();
									}
								</script>

								<?php
								function count_titik($locations)
								{
									if (is_array($locations) || is_object($locations)) {
										$count = 0;
										foreach ($locations as $index => $lc) {
											$count++;
										}
									}
									return $count;
								}

								?>

								<div class="col-12 col-lg-5 d-flex flex-column">
									<div class="row flex-grow">
										<div class="col-12 col-md-6 col-lg-12 grid-margin stretch-card">
											<div class="card card-rounded">
												<div class="card-body">
													<div class="d-flex align-items-center justify-content-between mb-3">
														<h4 class="card-title card-title-dash">Lokasi Pengumpulan</h4>
														<p class="mb-0"><?= count_titik($locations); ?> titik aktif</p>
													</div>
													<ul class="bullet-line-list">
														<?php if (is_array($locations) || is_object($locations)) : ?>
															<?php $count = 0; ?>
															<?php foreach ($locations as $index => $lc) : ?>
																<li>
																	<div class="d-flex justify-content-between">
																		<div><span class="text-light-green"><?= $lc['Desc'] ?></span> - <?= $lc['alamat'] ?>
																		</div>
																		<p><a href="https://www.google.com/maps/place/<?= $lc['Lat'] . ',' . $lc['Lon'] ?>" target="_blank" rel="noopener noreferrer">Check Maps</a></p>
																	</div>
																</li>
															<?php endforeach; ?>
														<?php endif; ?>
												</div>
											</div>
										</div>


									</div>
								</div>



							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- content-wrapper ends -->
