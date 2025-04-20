<!-- End custom js for this page-->

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row mb-3">

			<div class="col-12 col-md-6 col-lg-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Riwayat Tabungan Nasabah
							<?= 'RT ' . $this->user_session->rt . ' / RW ' . $this->user_session->rw ?>
						</h4>
						<div class="row">
							<div class="col-12">
								<div class="table-responsive">
									<table id="riwayat_tabungan_nasabah" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th colspan="3" class="text-center">Penarikan Terakhir</th>
											</tr>
											<tr>
												<th class="text-center">Nasabah</th>
												<th class="text-center">Jumlah Penarikan</th>
												<th class="text-center">Tanggal Penarikan</th>
											</tr>
										</thead>
										<tbody>
											<?php if (is_array($riwayat_all_dana) || is_object($riwayat_all_dana)) : ?>
												<?php foreach ($riwayat_all_dana as $rad) : ?>
													<tr>
														<td><?= htmlspecialchars($rad->nama) ?></td>
														<td>Rp.
															<?= htmlspecialchars(number_format($rad->jumlah_penarikan, 2, ',', '.')) ?>
														</td>
														<td>
															<div class="text-muted ">
																<i class="mdi mdi-calendar align-middle me-2"></i>
																<?= date('d F Y', strtotime($rad->tanggal_penarikan ?? '')) ?>
															</div>
															<div class="text-muted ">
																<i class="mdi mdi-clock align-middle me-2"></i>
																<?= date('H:i', strtotime($rad->tanggal_penarikan ?? '')) ?>
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

			<div class="col-12 col-md-6 col-lg-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Daftar Tabungan Nasabah
							<?= 'RT ' . $this->user_session->rt . ' / RW ' . $this->user_session->rw ?>
						</h4>
						<div class="row">
							<div class="col-12">
								<div class="table-responsive">
									<table id="data_tabungan_nasabah" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th colspan="3" class="text-center">Dicatat Terakhir</th>
											</tr>
											<tr>
												<th class="text-center">Nasabah</th>
												<th class="text-center">Jumlah Tabungan</th>
												<th class="text-center">Tanggal Update</th>
											</tr>
										</thead>
										<tbody>
											<?php if (is_array($tabungan_list) || is_object($tabungan_list)) : ?>
												<?php foreach ($tabungan_list as $index => $tl) : ?>
													<tr>
														<td><?= htmlspecialchars($tl->nama) ?></td>
														<td>Rp.
															<?= htmlspecialchars(number_format($tl->jumlah_tabungan, 2, ',', '.')) ?>
														</td>
														<td>
															<div class="text-muted ">
																<i class="mdi mdi-calendar align-middle me-2"></i>
																<?= date('d F Y', strtotime($tl->tanggal_update ?? '')) ?>
															</div>
															<div class="text-muted ">
																<i class="mdi mdi-clock align-middle me-2"></i>
																<?= date('H:i', strtotime($tl->tanggal_update ?? '')) ?>
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


		<div class="card mb-3">
			<div class="card-body">
				<h4 class="card-title text-center">Riwayat Penarikan RT
					<?= $this->user_session->rt . ' / RW ' . $this->user_session->rw ?>
				</h4>
				<h3 class="card-title">Penarikan Dana RT <?= $this->user_session->rt . ' / RW ' . $this->user_session->rw ?>
				</h3>
				<form id="formTarikDana">
					<div class="form-group">
						<select class="form-control" name="id_rt" required>
							<?php if (is_array($rt_list) || is_object($rt_list)) : ?>
								<?php foreach ($rt_list as $rt) : ?>
									<?php if ($this->user_session->id_rt == $rt->id_rt) : ?>
										<option value="<?= $rt->id_rt ?>">RT <?= $rt->rt ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Proses Penarikan</button>
				</form>

				<script>
					$(document).ready(function() {
						$('#formTarikDana').submit(function(e) {
							e.preventDefault();

							Swal.fire({
								title: 'Konfirmasi Penarikan',
								text: "Anda akan menarik dana semua nasabah di RT ini?",
								icon: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ya, Proses!',
								cancelButtonText: 'Batal'
							}).then((result) => {
								if (result.isConfirmed) {
									$.ajax({
										url: '<?= site_url('Proses-Tarik-Tabungan') ?>',
										type: 'POST',
										data: $(this).serialize(),
										dataType: 'json',
										beforeSend: function() {
											Swal.fire({
												title: 'Memproses',
												html: 'Sedang melakukan penarikan dana...',
												allowOutsideClick: false,
												didOpen: () => {
													Swal.showLoading()
												}
											});
										},
										success: function(response) {
											if (response.status === 'success') {
												Swal.fire({
													title: `${response.message}`,
													html: `
                                <div style="text-align:left">
                                    <b>Total Penarikan:</b> Rp ${response.data.total.toLocaleString()}
                                    <br><b>Jumlah Nasabah:</b> ${response.data.nasabah} orang
                                </div>
                            `,
													icon: 'success',
													confirmButtonText: 'OK'
												}).then(() => {
													location.reload();
												});
											} else {
												Swal.fire(
													'Gagal!',
													response.message,
													'error'
												).then(() => {
													location.reload();
												});
											}
										},
										error: function(xhr, status, error) {
											Swal.fire(
												'Error!',
												'Terjadi kesalahan saat memproses permintaan',
												'error'
											).then(() => {
												location.reload();
											});
										}
									});
								}
							});
						});
					});
				</script>

				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table id="history_penarikan_rt" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Ketua Nasabah</th>
										<th class="text-center">Total</th>
										<th class="text-center">Status</th>
										<th class="text-center">Tanggal</th>
									</tr>
								</thead>
								<tbody>
									<?php if (is_array($tarik_rt) || is_object($tarik_rt)) : ?>
										<?php foreach ($tarik_rt as $index => $tr) : ?>
											<tr>
												<td class="text-center"><?= htmlspecialchars(++$index ?? '') ?></td>
												<td>
													<?= htmlspecialchars($tr->nama ?? '') . ' [ RT ' . ($tr->rt ?? '') . ' / RW ' . ($tr->rw ?? '') . ' ]' ?>
												</td>
												<td>
													Rp. <?= number_format($tr->total_penarikan ?? 0, 2, ',', '.') ?>
												</td>
												<td class="text-center">
													<?= ($tr->status ?? '') == 'berhasil' ? "<label class='badge badge-success fw-bold'><i class='fas fa-truck'></i> {$tr->status} </label>" : "<label class='badge badge-danger fw-bold'><i class='fas fa-truck'></i> {$rd->status} </label>" ?>
												</td>
												<td>
													<div class="text-muted ">
														<i class="mdi mdi-calendar align-middle me-2"></i>
														<?= date('d F Y', strtotime($tr->tanggal_penarikan ?? '')) ?>
													</div>
													<div class="text-muted ">
														<i class="mdi mdi-clock align-middle me-2"></i>
														<?= date('H:i', strtotime($tr->tanggal_penarikan ?? '')) ?>
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

	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();

			$(
				'#data_tabungan_nasabah, #riwayat_tabungan_nasabah'
			).DataTable({
				lengthChange: true,
				searching: true,
				paginate: true,
				info: true,
				order: true,
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

			$('#history_penarikan_rt').DataTable({
				order: true,
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
