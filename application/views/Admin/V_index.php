<style>
	.chart-container {
		position: relative;
		height: 300px;
		width: 100%;
		overflow: visible;
	}
</style>
<div class="main-panel w-100 mx-auto">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-sm-12">
				<div class="home-tab">
					<div class="d-sm-flex align-items-center justify-content-between border-bottom">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#ringkasan" role="tab" aria-controls="ringkasan" aria-selected="true">Ringkasan</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#transactions" role="tab" aria-selected="false">Transaksi</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#savings" role="tab" aria-selected="false">Tabungan</a>
							</li>
						</ul>
					</div>

					<div class="tab-content tab-content-basic">
						<!-- Ringkasan Tab -->
						<div class="tab-pane fade show active" id="ringkasan" role="tabpanel" aria-labelledby="ringkasan">
							<!-- Card Ringkasan   -->

							<div class="row">
								<div class="col-sm-12">
									<div class="statistics-details d-flex align-items-start justify-content-between mb-2">

										<div>
											<p class="statistics-title">Nasabah Terdaftar</p>
											<h3 class="rate-percentage"> <?= $total_nasabah ?> <i class="mdi mdi-account-multiple text-primary icon-md align-middle"></i></h3>
											<p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>2 baru bulan ini</span></p>
											<p class="text-primary ">
												<a href="<?= base_url('Manage-Nasabah') ?>" class="text-decoration-none  d-flex">
													<i class="mdi mdi-chevron-right align-middle"></i><span>Lihat Semua</span>
												</a>
											</p>
										</div>

										<div>
											<p class="statistics-title">Total Transaksi</p>
											<h3 class="rate-percentage"><?= $total_transaksi ?> <i class="mdi mdi-cash-multiple text-info icon-md align-middle"></i></h3>
											<p class="text-success d-flex mb-0"><i class="mdi mdi-menu-up"></i><span>3 lebih banyak vs
													kemarin</span></p>
											<p class="text-primary ">
												<a href="<?= base_url('Manage-Transaksi') ?>" class="text-decoration-none  d-flex">
													<i class="mdi mdi-chevron-right align-middle"></i><span>Lihat Semua</span>
												</a>
											</p>
										</div>

										<div>
											<p class="statistics-title">Total Tabungan Nasabah saat ini</p>
											<h3 class="rate-percentage">Rp. <?= number_format((float) $total_tabungan, 0, ',', '.') ?> <i class="mdi mdi-wallet text-success icon-md align-middle"></i> </h3>
											<p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>Rp12.500 (28%) bulan
													ini</span></p>
										</div>

										<div class="d-none d-md-block">
											<p class="statistics-title">Karya dibuat</p>
											<h3 class="rate-percentage"><?= $total_karya ?> <i class="mdi mdi-palette text-warning icon-md align-middle"></i>
											</h3>
											<p class="text-danger d-flex mb-0"><i class="mdi mdi-menu-up"></i><span> Perlu penambahan
													karya</span>
											</p>
											<p class="text-primary ">
												<a href="<?= base_url('Hasil-Karya') ?>" class="text-decoration-none  d-flex">
													<i class="mdi mdi-chevron-right align-middle"></i><span>Lihat Semua</span>
												</a>
											</p>
										</div>

										<div class="d-none d-md-block">
											<p class="statistics-title">Jangkauan Wilayah</p>
											<h3 class="rate-percentage"><?= (int) $total_rt ?? 0 ?> RT</h3>
											<small class="text-muted">dari</small>
											<h3 class="rate-percentage"><?= (int) $total_rw ?? 0 ?> RW</h3>
											<p class="text-primary ">
												<a href="<?= base_url('Manage-Area') ?>" class="text-decoration-none  d-flex">
													<i class="mdi mdi-chevron-right align-middle"></i><span>Lihat Semua</span>
												</a>
											</p>
										</div>

									</div>
								</div>
							</div>

							<!-- Chart Overview -->
							<div class="row">
								<div class="col-lg-12 d-flex flex-column">
									<div class="row flex-grow">
										<div class="col-12 col-lg-12 grid-margin stretch-card">
											<div class="card card-rounded">
												<div class="card-body">
													<div class="d-sm-flex justify-content-between align-items-start">
														<div>
															<h4 class="card-title card-title-dash">Riwayat Transaksi bulan</h4>
															<p class="card-subtitle card-subtitle-dash">Ringkasan Transaksi Sampah bulanan</p>
														</div>
													</div>
													<div class="chart-container">
														<canvas id="data_grafik_history_transaksi_bulan" width="300" height="300">
														</canvas>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>


							<!-- Baru ditambahkan -->
							<div class="row">
								<!-- Transaksi Terakhir -->
								<div class="col-lg-6 d-flex flex-column">
									<div class="row flex-grow">
										<div class="col-12 grid-margin stretch-card">
											<div class="card card-rounded">
												<div class="card-body">
													<div class="d-flex justify-content-between align-items-center mb-3">
														<h4 class="card-title card-title-dash">Transaksi Terakhir</h4>
														<a href="<?= base_url('Manage-Transaksi') ?>" class="btn btn-sm btn-primary text-white">Lihat Semua</a>
													</div>
													<div class="table-responsive">
														<table class="table table-hover">
															<thea>
																<tr>
																	<th>Kode</th>
																	<th>Nasabah</th>
																	<th>Jenis Sampah</th>
																	<th>Kondisi</th>
																	<th>Waktu</th>
																</tr>
																</thead>
																<tbody>
																	<?php if (is_array($transaksi_terakhir) || is_object($transaksi_terakhir)) : ?>
																		<?php foreach ($transaksi_terakhir as $tt) : ?>
																			<tr>
																				<td>
																					<?= htmlspecialchars($tt->kode_transaksi) ?>
																				</td>
																				<td>
																					<?= htmlspecialchars($tt->nama) ?>
																				</td>
																				<td class="text-center">
																					<?= htmlspecialchars($tt->nama_sampah) ?>
																				</td>
																				<td>
																					<?php if ($tt->status == 'diterima') : ?>
																						<label class="badge badge-dark fw-bold p-2" data-toggle="tooltip" title="Menunggu disetorkan kepada Pelapak">
																							<i class="align-middle mdi mdi-check"></i>
																							Diterima
																						</label>
																					<?php elseif ($tt->status == 'dicatat') : ?>
																						<label class="badge badge-primary fw-bold p-2" data-toggle="tooltip" title="Menunggu dicairkan oleh Ketua PKK">
																							<i class="align-middle mdi mdi-check-all"></i>
																							Diproses
																						</label>
																					<?php else : ?>
																						<label class="badge badge-success fw-bold p-2" data-toggle="tooltip" title="Dana sudah diberikan kepada nasabah">
																							<i class="align-middle mdi mdi-check-all"></i>
																							Selesai
																						</label>
																					<?php endif; ?>
																				</td>
																				<td>
																					<div class="text-muted  ">
																						<i class="mdi mdi-calendar align-middle me-2"></i>
																						<?= date('d F Y', strtotime($tt->tanggal_transaksi)) ?>
																					</div>
																					<div class="text-muted  ">
																						<i class="mdi mdi-clock align-middle me-2"></i>
																						<?= date('H:i', strtotime($tt->tanggal_transaksi)) ?>
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

								<!-- Artikel Hasil Karya Terakhir -->
								<div class="col-lg-6 d-flex flex-column">
									<div class="row flex-grow">
										<div class="col-12 grid-margin stretch-card">
											<div class="card card-rounded">
												<div class="card-body">
													<div class="d-flex justify-content-between align-items-center mb-3">
														<h4 class="card-title card-title-dash">Hasil Karya Terakhir</h4>
														<a href="<?= base_url('Hasil-Karya') ?>" class="btn btn-sm btn-primary text-white">Lihat
															Semua</a>
													</div>
													<div class="row">
														<?php if (is_array($hasil_karya_terakhir) || is_object($hasil_karya_terakhir)) : ?>
															<?php foreach ($hasil_karya_terakhir as $hkt) : ?>
																<div class="col-md-6 mb-3">
																	<div class="card karya-card">
																		<img src="<?= base_url('assets/uploads/karya/' . $hkt->gambar) ?>" class="card-img-top" alt="<?= htmlspecialchars($hkt->judul) ?>">
																		<div class="card-body">
																			<h5 class="card-title">
																				<?= htmlspecialchars($hkt->judul) ?>
																			</h5>
																			<p class="card-text text-muted small">By <?= htmlspecialchars($hkt->author) ?>
																			</p>
																		</div>
																	</div>
																</div>
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

						<!-- Transactions Tab -->
						<div class="tab-pane fade" id="transactions" role="tabpanel" aria-labelledby="transactions">
							<div class="row">
								<div class="col-12 grid-margin stretch-card">
									<div class="card card-rounded">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center mb-4">
												<h4 class="card-title card-title-dash">Ringkasan Transaksi</h4>
											</div>

											<div class="row mb-4">
												<div class="col-md-4">
													<div class="stat-card">
														<p class="statistics-title">Total Transaksi</p>
														<h3 class="rate-percentage">
															<?= number_format(($ringkasan_transaksi_bulanan[0]->total ?? 0)) ?>
														</h3>
														<p class="text-muted">Bulan ini</p>
													</div>
												</div>
												<div class="col-md-4">
													<div class="stat-card">
														<p class="statistics-title">Total Berat (kg)</p>
														<h3 class="rate-percentage">
															<?= number_format((($ringkasan_transaksi_bulanan[0]->berat / 1000) ?? 0), 2) ?>
															Kg
														</h3>
														<p class="text-muted">Bulan ini</p>
													</div>
												</div>
												<div class="col-md-4">
													<div class="stat-card">
														<p class="statistics-title">Total Tabungan</p>
														<h3 class="rate-percentage">Rp
															<?= number_format(($ringkasan_transaksi_bulanan[0]->nilai ?? 0), 0, ',', '.') ?>
														</h3>
														<p class="text-muted">Bulan ini</p>
													</div>
												</div>
											</div>

											<!-- Chart Overview -->
											<div class="row">
												<div class="col-lg-12 d-flex flex-column">
													<div class="row flex-grow">
														<div class="col-12 col-lg-12 ">

															<div class="d-sm-flex justify-content-between align-items-start">
																<div>
																	<h4 class="card-title card-title-dash">Riwayat Transaksi (30 Hari)</h4>
																	<p class="card-subtitle card-subtitle-dash">Ringkasan Transaksi Sampah baru saja
																	</p>
																</div>
															</div>

															<div class="chart-container">
																<canvas id="data_grafik_history_transaksi" width="300" height="300"></canvas>
															</div>

														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>

								<div class="col-12 grid-margin stretch-card">
									<div class="card card-rounded">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center mb-3">
												<h4 class="card-title card-title-dash">Transaksi Terakhir</h4>
												<a href="<?= base_url('Manage-Transaksi') ?>" class="btn btn-sm btn-primary text-white">Lihat
													Semua</a>
											</div>

											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th>Kode</th>
															<th>Nasabah</th>
															<th>Jenis Sampah</th>
															<th>Berat (kg)</th>
															<th>Tabungan</th>
															<th>Status</th>
															<th>Waktu</th>

														</tr>
													</thead>
													<tbody>
														<?php if (is_array($transaksi_terakhir) || is_object($transaksi_terakhir)) : ?>
															<?php foreach ($transaksi_terakhir as $tt) : ?>
																<tr>
																	<td>
																		<?= $tt->kode_transaksi ?>
																	</td>
																	<td>
																		<?= htmlspecialchars($tt->nama) ?>
																	</td>
																	<td>
																		<?= htmlspecialchars($tt->nama_sampah) ?>
																	</td>
																	<td>
																		<?= number_format(($tt->berat / 1000), 2, ',', '.') ?>
																	</td>
																	<td>
																		<span class="fw-bold <?=
																													$tt->status == 'dicatat' ? 'text-success' : ($tt->status == 'dibawa' ? 'text-danger' : '')
																													?>">
																			<?=
																			$tt->status == 'dicatat' ? '+ Rp ' . number_format(($tt->total_harga ?? 0), 0, ',', '.') : ($tt->status == 'dibawa' ? '- Rp ' . number_format(($tt->total_harga ?? 0), 0, ',', '.') : 'Rp 0')
																			?>
																		</span>
																	</td>
																	<td>
																		<?php if ($tt->status == 'diterima') : ?>
																			<label class="badge badge-dark fw-bold p-2" data-toggle="tooltip" title="Menunggu disetorkan kepada Pelapak">
																				<i class="align-middle mdi mdi-check"></i>
																				Diterima
																			</label>
																		<?php elseif ($tt->status == 'dicatat') : ?>
																			<label class="badge badge-primary fw-bold p-2" data-toggle="tooltip" title="Menunggu dicairkan oleh Ketua PKK">
																				<i class="align-middle mdi mdi-check-all"></i>
																				Diproses
																			</label>
																		<?php else : ?>
																			<label class="badge badge-success fw-bold p-2" data-toggle="tooltip" title="Dana sudah diberikan kepada nasabah">
																				<i class="align-middle mdi mdi-check-all"></i>
																				Selesai
																			</label>
																		<?php endif; ?>
																	</td>
																	<td>
																		<div class="text-muted  ">
																			<i class="mdi mdi-calendar align-middle me-2"></i>
																			<?= date('d F Y', strtotime($tt->tanggal_transaksi)) ?>
																		</div>
																		<div class="text-muted  ">
																			<i class="mdi mdi-clock align-middle me-2"></i>
																			<?= date('H:i', strtotime($tt->tanggal_transaksi)) ?>
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

						<!-- Savings Tab -->
						<div class="tab-pane fade" id="savings" role="tabpanel" aria-labelledby="savings">
							<div class="row">
								<div class="col-12 grid-margin stretch-card">
									<div class="card card-rounded">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center mb-4">
												<h4 class="card-title card-title-dash">Ringkasan Tabungan</h4>
												<div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
														<?= ($filter_rt && $filter_rw) ? 'RT ' . $filter_rt . ' / RW ' . $filter_rw : 'Filter by RT/RW' ?>
													</button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
														<li><a class="dropdown-item" href="<?= base_url('C_Admin') ?>?tab=savings">All RT/RW</a>
														</li>
														<?php foreach ($rt_rw_list as $rt) : ?>
															<li>
																<a class="dropdown-item" href="<?= base_url('C_Admin') ?>?tab=savings&rt=<?= $rt->rt ?>&rw=<?= $rt->rw ?>">
																	RT <?= $rt->rt ?> / RW <?= $rt->rw ?>
																</a>
															</li>
														<?php endforeach; ?>
													</ul>
												</div>
											</div>

											<div class="row mb-4">
												<div class="col-md-4">
													<div class="stat-card">
														<p class="statistics-title">Total Tabungan</p>
														<h3 class="rate-percentage">Rp
															<?= number_format(($filter_rt ? $this->M_Nasabah->get_total_tabungan_by_rt($filter_rt) : $total_tabungan), 0, ',', '.') ?>
														</h3>
														<p class="text-muted">
															<?= ($filter_rt && $filter_rw) ? 'RT ' . $filter_rt . ' / RW ' . $filter_rw : 'Semua Nasabah' ?>
														</p>
													</div>
												</div>
												<div class="col-md-4">
													<div class="stat-card">
														<p class="statistics-title">Rata-rata Tabungan</p>
														<h3 class="rate-percentage">Rp
															<?= number_format(($filter_rt ? $this->M_Nasabah->get_avg_tabungan_by_rt($filter_rt) : $avg_tabungan), 0, ',', '.') ?>
														</h3>
														<p class="text-muted">Per Nasabah</p>
													</div>
												</div>
												<div class="col-md-4">
													<div class="stat-card">
														<p class="statistics-title">Top Nasabah</p>
														<h3 class="rate-percentage">Rp
															<?= number_format(($filter_rt ? $this->M_Nasabah->get_top_nasabah_by_rt($filter_rt)->jumlah_tabungan : $top_nasabah->jumlah_tabungan), 0, ',', '.') ?>
														</h3>
														<p class="text-muted">
															<?= ($filter_rt ? $this->M_Nasabah->get_top_nasabah_by_rt($filter_rt)->nama : $top_nasabah->nama) ?>
														</p>
													</div>
												</div>
											</div>

											<div class="chart-container">
												<canvas id="tabunganDistributionChart"></canvas>
											</div>

										</div>
									</div>
								</div>

								<div class="col-12 grid-margin stretch-card">
									<div class="card card-rounded">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center mb-3">
												<h4 class="card-title card-title-dash">Penarikan Terakhir</h4>
												<a href="<?= base_url('Laporan-Transaksi?status=dibawa') ?>" class="btn btn-primary text-white">Lihat
													Semua</a>
											</div>

											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th>Tanggal</th>
															<th>Nasabah</th>
															<th>RT/RW</th>
															<th>Jumlah</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
														<?php if (is_array($tarik_tabungan_terakhir) || is_object($tarik_tabungan_terakhir)) : ?>
															<?php foreach ($tarik_tabungan_terakhir as $ttt) : ?>
																<tr>
																	<td>
																		<div class="text-muted  ">
																			<i class="mdi mdi-calendar align-middle me-2"></i>
																			<?= date('d F Y', strtotime($ttt->tanggal_penarikan)) ?>
																		</div>
																		<div class="text-muted  ">
																			<i class="mdi mdi-clock align-middle me-2"></i>
																			<?= date('H:i', strtotime($ttt->tanggal_penarikan)) ?>
																		</div>
																	</td>
																	<td><?= htmlspecialchars($ttt->nama) ?></td>
																	<td>RT <?= $ttt->rt ?> / RW <?= $ttt->rw ?></td>
																	<td>Rp <?= number_format($ttt->jumlah_penarikan, 0, ',', '.') ?></td>
																	<td>
																		<?php if ($ttt->status == 'berhasil') : ?>
																			<label class="badge badge-success fw-bold p-2" data-toggle="tooltip" title="Penarikan Berhasil">
																				<i class="align-middle mdi mdi-check-all"></i>
																				Berhasil
																			</label>
																		<?php else : ?>
																			<label class="badge badge-danger fw-bold p-2" data-toggle="tooltip" title="Penarikan Gagal">
																				<i class="align-middle mdi mdi-close"></i>
																				Gagal</label>
																		<?php endif; ?>
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
				</div>
			</div>
		</div>



		<script>
			// Fungsi pembuatan chart yang bisa dipakai ulang
			function createTransactionChart(chartId, legendId, labels, datasets) {
				var ctx = document.getElementById(chartId).getContext('2d');

				// Gradients
				var gradientBg1 = ctx.createLinearGradient(5, 0, 5, 100);
				gradientBg1.addColorStop(0, 'rgba(26, 115, 232, 0.18)');
				gradientBg1.addColorStop(1, 'rgba(26, 115, 232, 0.05)');

				var gradientBg2 = ctx.createLinearGradient(100, 0, 50, 150);
				gradientBg2.addColorStop(0, 'rgba(0, 208, 255, 0.19)');
				gradientBg2.addColorStop(1, 'rgba(0, 208, 255, 0.07)');

				var gradientBg3 = ctx.createLinearGradient(100, 0, 50, 150);
				gradientBg3.addColorStop(0, 'rgba(75, 192, 192, 0.19)');
				gradientBg3.addColorStop(1, 'rgba(75, 192, 192, 0.07)');

				// Default dataset templates
				var datasetTemplates = {
					count: {
						label: 'Jumlah Transaksi',
						backgroundColor: gradientBg1,
						borderColor: '#1F3BB3',
						pointBackgroundColor: '#1F3BB3',
						yAxisID: 'y-axis-count',
						type: 'line'
					},
					value: {
						label: 'Total Nilai',
						backgroundColor: gradientBg2,
						borderColor: '#52CDFF',
						pointBackgroundColor: '#52CDFF',
						yAxisID: 'y-axis-value',
						type: 'line'
					},
					weight: {
						label: 'Total Berat (kg)',
						backgroundColor: gradientBg3,
						borderColor: '#4BC0C0',
						pointBackgroundColor: '#4BC0C0',
						yAxisID: 'y-axis-weight',
						type: 'line'
					}
				};

				// Apply data to selected datasets
				var chartDatasets = [];
				datasets.forEach(function(ds) {
					var template = datasetTemplates[ds.type];
					if (template) {
						chartDatasets.push({
							...template,
							data: ds.data,
							fill: ds.fill !== undefined ? ds.fill : true,
							borderWidth: 1.5,
							pointBorderWidth: 1,
							pointRadius: 5,
							pointHoverRadius: 7,
							pointBorderColor: '#fff'
						});
					}
				});

				var chartData = {
					labels: labels,
					datasets: chartDatasets
				};

				// Determine which y-axes to show based on dataset types
				var yAxes = [];
				if (datasets.some(ds => ds.type === 'count')) {
					yAxes.push({
						id: 'y-axis-count',
						position: 'left',
						scaleLabel: {
							display: true,
							labelString: 'Jumlah Transaksi',
							fontSize: 12,
							fontColor: '#6B778C'
						},
						gridLines: {
							display: false,
							drawBorder: false,
							color: "#F0F0F0"
						},
						ticks: {
							beginAtZero: true,
							autoSkip: true,
							maxTicksLimit: 7,
							precision: 0,
							fontSize: 12,
							color: "#6B778C"
						}
					});
				}

				if (datasets.some(ds => ds.type === 'value')) {
					yAxes.push({
						id: 'y-axis-value',
						position: 'right',
						scaleLabel: {
							display: true,
							labelString: 'Total Nilai',
							fontSize: 12,
							fontColor: '#6B778C'
						},
						gridLines: {
							display: false,
							drawBorder: false,
						},
						ticks: {
							beginAtZero: true,
							autoSkip: true,
							maxTicksLimit: 7,
							precision: 0,
							fontSize: 12,
							color: "#6B778C",
							callback: function(value) {
								return value.toLocaleString('id-ID', {
									style: 'currency',
									currency: 'IDR',
									minimumFractionDigits: 0
								});
							}
						}
					});
				}

				if (datasets.some(ds => ds.type === 'weight')) {
					yAxes.push({
						id: 'y-axis-weight',
						position: 'right',
						scaleLabel: {
							display: true,
							labelString: 'Berat (kg)',
							fontSize: 12,
							fontColor: '#6B778C'
						},
						gridLines: {
							display: false,
							drawBorder: false,
						},
						ticks: {
							beginAtZero: true,
							autoSkip: true,
							maxTicksLimit: 7,
							precision: 2,
							fontSize: 12,
							color: "#6B778C",
							callback: function(value) {
								return value.toFixed(2) + ' kg';
							}
						}
					});
				}

				var options = {
					responsive: true,
					maintainAspectRatio: false,
					scales: {
						yAxes: yAxes,
						xAxes: [{
							scaleLabel: {
								display: true,
								labelString: '',
								fontSize: 12,
								fontColor: '#6B778C'
							},
							gridLines: {
								display: false,
								drawBorder: false
							},
							ticks: {
								fontSize: 12,
								color: "#6B778C"
							}
						}]
					},
					tooltips: {
						mode: 'index',
						intersect: false,
						callbacks: {
							label: function(tooltipItem, data) {
								var label = data.datasets[tooltipItem.datasetIndex].label || '';
								if (label) label += ': ';

								if (data.datasets[tooltipItem.datasetIndex].yAxisID === 'y-axis-value') {
									label += tooltipItem.yLabel.toLocaleString('id-ID', {
										style: 'currency',
										currency: 'IDR',
										minimumFractionDigits: 0
									});
								} else if (data.datasets[tooltipItem.datasetIndex].yAxisID === 'y-axis-weight') {
									label += tooltipItem.yLabel.toFixed(2) + ' kg';
								} else {
									label += tooltipItem.datasetIndex === 2 ?
										tooltipItem.yLabel.toFixed(2) :
										tooltipItem.yLabel;
								}
								return label;
							}
						}
					}
				};

				var chart = new Chart(ctx, {
					type: 'line',
					data: chartData,
					options: options
				});

				return chart;
			}

			$(document).ready(function() {

				const urlParams = new URLSearchParams(window.location.search);
				const activeTab = urlParams.get('tab');

				if (activeTab) {
					$('.nav-tabs a[href="#' + activeTab + '"]').tab('show');
				}

				// Chart 1 (30 hari)
				if ($("#data_grafik_history_transaksi").length) {
					var beratDalamGram = <?= json_encode($data_berat_transaksi) ?>;
					var beratDalamKg = beratDalamGram.map(function(gram) {
						return gram / 1000;
					});
					createTransactionChart(
						'data_grafik_history_transaksi',
						'data_grafik_history_transaksi',
						<?= json_encode($label_transaksi) ?>,
						[{
								type: 'count',
								data: <?= json_encode($data_jumlah_transaksi) ?>
							},
							{
								type: 'value',
								data: <?= json_encode($data_nilai_transaksi) ?>
							}, {
								type: 'weight',
								data: beratDalamKg
							}
						]
					);
				}

				// Chart 2 (Bulanan)
				if ($("#data_grafik_history_transaksi_bulan").length) {
					var beratDalamGram = <?= json_encode($data_berat_transaksi_bulanan) ?>;
					var beratDalamKg = beratDalamGram.map(function(gram) {
						return gram / 1000;
					});

					createTransactionChart(
						'data_grafik_history_transaksi_bulan',
						'data_grafik_history_transaksi_bulan',
						<?= json_encode($label_transaksi_bulanan) ?>,
						[{
								type: 'count',
								data: <?= json_encode($data_jumlah_transaksi_bulanan) ?>
							},
							{
								type: 'value',
								data: <?= json_encode($data_nilai_transaksi_bulanan) ?>
							},
							{
								type: 'weight',
								data: beratDalamKg
							}
						]
					);
				}

				// Chart Distribusi Tabungan
				if ($("#tabunganDistributionChart").length) {
					var ctx = document.getElementById('tabunganDistributionChart').getContext('2d');

					// Data dari PHP
					var distribusiData =
						<?= json_encode($this->M_Nasabah->get_distribusi_tabungan_per_rt_filtered($filter_rt, $filter_rw)) ?>;

					var labels = [];
					var data = [];
					var backgroundColors = [];

					// Warna untuk chart
					var colorPalette = [
						'#4BC0C0', '#36A2EB', '#FFCE56', '#FF6384',
						'#9966FF', '#FF9F40', '#8AC24A', '#607D8B'
					];

					// Format data untuk chart
					distribusiData.forEach(function(item, index) {
						labels.push(item.rt_rw);
						data.push(parseFloat(item.total));
						backgroundColors.push(colorPalette[index % colorPalette.length]);
					});

					var chart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: labels,
							datasets: [{
								label: 'Total Tabungan per RT',
								data: data,
								backgroundColor: backgroundColors,
								borderColor: backgroundColors.map(c => c.replace('0.6', '1')),
								fill: true,
								borderWidth: 1.5,
								pointBorderWidth: 1,
								pointRadius: 5,
								pointHoverRadius: 7,
								yAxisID: 'y-axis-tabungan',
							}]
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									id: 'y-axis-tabungan',
									position: 'left',
									scaleLabel: {
										display: true,
										labelString: 'Total Tabungan',
										fontSize: 12,
										fontColor: '#6B778C'
									},
									gridLines: {
										display: false,
										drawBorder: false,
										color: "#F0F0F0"
									},
									ticks: {
										beginAtZero: false,
										autoSkip: true,
										maxTicksLimit: 7,
										precision: 0,
										fontSize: 12,
										color: "#6B778C",
										callback: function(value) {
											return value.toLocaleString('id-ID', {
												style: 'currency',
												currency: 'IDR'
											});
										}
									}
								}],
							},
							tooltips: {
								mode: 'index',
								intersect: false,
								callbacks: {
									label: function(tooltipItem, data) {
										var label = data.datasets[tooltipItem.datasetIndex].label || '';
										if (label) {
											label += ' : ';
										}
										if (tooltipItem.datasetIndex === 0) {
											label += tooltipItem.yLabel.toLocaleString('id-ID', {
												style: 'currency',
												currency: 'IDR'
											});
										} else {
											label += tooltipItem.yLabel;
										}
										return label;
									}
								},
							}
						}
					});
				}
			});
		</script>
