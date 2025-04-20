<!-- End custom js for this page-->

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row mb-3 d-flex">
			<div class="col-6">
				<div class="card h-100">
					<div class="card-body">
						<h4 class="card-title">Form Transaksi</h4>
						<div class="row">
							<div class="col-12">
								<?php $this->load->view('components/alert_messages'); ?>
								<?php if (validation_errors()) : ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<strong>Oops!</strong> Ada beberapa kesalahan dalam pengisian form:
										<ul>
											<?= validation_errors('<li>', '</li>'); ?>
										</ul>
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								<?php endif; ?>

								<div id="alert-container"></div>
								<form class="pt-3" method="POST" id="form_transaksi">

									<div class="row justify-content-center w-auto mx-auto">
										<div class="col-12 col-sm-12 col-md-10 col-lg-6">
											<div class="form-group">
												<label class="form-label">Kode Transaksi</label>
												<input type="text" class="form-control   <?= form_error('kode_transaksi	') ? 'is-invalid' : ''; ?>" id="kode_transaksi" name="kode_transaksi	" value="<?= $kode_transaksi ?>" placeholder="Kode Transaksi" readonly>
												<div class="invalid-feedback">
													<?= form_error('kode_transaksi	'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="form-label" for="id_nasabah">Pilih Nasabah</label>
												<select class="form-control" id="id_nasabah_sel" name="id_nasabah" style="width:100%" required>
												</select>
											</div>
											<div class="form-group">
												<label class="form-label">Status Transaksi</label>
												<select class="form-control" id="status" name="status" style="width:100%" readonly>
													<option value="diterima" selected>Diterima BSAL</option>
													<option value="diproses" disabled>Diproses BSAL</option>
													<option value="dibawa" disabled>Dijual BSAL</option>
												</select>
												<div class="invalid-feedback">
													<?= form_error('password'); ?>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-12 col-md-10 col-lg-6">
											<div class="form-group">
												<label class="form-label">Tanggal Transaksi</label>
												<input type="text" class="form-control   <?= form_error('tanggal_transaksi	') ? 'is-invalid' : ''; ?>" id="tanggal_transaksi	" name="tanggal_transaksi	" value="<?= date('d F Y') ?>" placeholder="Tanggal Transaksi" readonly>
												<div class="invalid-feedback">
													<?= form_error('tanggal_transaksi	'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="form-label" for="id_sampah">Pilih Sampah</label>
												<select class="form-control js-example-basic-single" id="id_sampah_sel" name="id_sampah" style="width:100%" required>
												</select>
											</div>
											<script>
												$(document).ready(function() {
													$('#id_sampah_sel').select2({
														width: 'resolve',
														ajax: {
															url: '<?= base_url('Search-Sampah') ?>',
															dataType: 'json',
															delay: 250,
															data: function(params) {
																return {
																	search: params.term || ''
																};
															},
															processResults: function(data) {
																return {
																	results: data
																};
															},
															cache: true
														},
														placeholder: 'Pilih Sampah',
														language: {
															noResults: function(params) {
																return "Sampah tidak ditemukan";
															}
														},
														allowClear: true,
														// minimumInputLength: 1
													});

													$('#id_nasabah_sel').select2({
														width: 'resolve',
														ajax: {
															url: '<?= base_url('Search-Nasabah') ?>',
															dataType: 'json',
															delay: 250,
															data: function(params) {

																return {
																	search: params.term || ''
																};
															},
															processResults: function(data) {
																return {
																	results: data
																};
															},
															cache: true
														},
														placeholder: 'Pilih Nasabah',
														language: {
															noResults: function(params) {
																return "Nasabah tidak ditemukan";
															}
														},
														allowClear: true,
														// minimumInputLength: 1
													});

												});
											</script>


											<div class="form-group">
												<label class="form-label">Berat Sampah <small>(/gram)</small> </label>
												<input type="number" class="form-control   <?= form_error('berat') ? 'is-invalid' : ''; ?>" id="berat" name="berat" value="<?= set_value('berat') ?>" placeholder="Berat Sampah" required>
												<div class="invalid-feedback">
													<?= form_error('berat'); ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="form-label">Catatan Transaksi<small>(Optional)</small> </label>
											<textarea class="form-control   <?= form_error('catatan_transaksi') ? 'is-invalid' : ''; ?>" name="catatan_transaksi" id="catatan_transaksi" rows="3" placeholder="Catatan Transaksi"><?= set_value('catatan_transaksi') ?></textarea>
											<div class="invalid-feedback">
												<?= form_error('catatan_transaksi'); ?>
											</div>
										</div>
										<div class="mt-3 d-flex justify-content-end">
											<button type="submit" class="btn btn-success btn-lg fw-bolder fs-6 my-2 ">Diterima <i class="icon-check m-0 p-1 fw-bolder fs-6"></i></button>
										</div>
									</div>

								</form>
								<script>
									$('#form_transaksi').on('submit', function(e) {
										e.preventDefault();
										const formData = $(this).serialize();
										const kodeTransaksi = $('#kode_transaksi').val();

										$.ajax({
											type: "POST",
											url: '<?= base_url('Add-Transaksi') ?>',
											data: formData,
											dataType: "json",
											success: function(response) {
												Swal.fire({
													title: "Success!",
													text: "Transaksi " + kodeTransaksi + " berhasil diterima",
													icon: "success"
												}).then(() => {
													location.reload();
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

												// Append the alert to a specific container (e.g., a div with id="alert-container")
												$('#alert-container').html(alertHtml);
											}
										});
									});
								</script>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="col-6">
				<div class="card h-100">
					<div class="card-body">
						<h4 class="card-title">History Transaksi</h4>
						<div class="row">
							<div class="col-12">
								<div class="table-responsive">
									<table id="history_terakhir" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th colspan="4" class="text-center">Diterima Terakhir</th>
											</tr>
											<tr>
												<th class="text-center">Kode</th>
												<th class="text-center">Nasabah</th>
												<th class="text-center">Sampah</th>
												<th class="text-center">Tanggal</th>
											</tr>
										</thead>
										<tbody>
											<?php if (is_array($history_transaksi_terakhir) || is_object($history_transaksi_terakhir)) : ?>
												<?php foreach ($history_transaksi_terakhir as $index => $htt) : ?>
													<tr>
														<td class="text-center"><?= htmlspecialchars($htt->kode_transaksi) ?></td>
														<td><?= htmlspecialchars($htt->nama) ?></td>
														<td>
															<?= htmlspecialchars($htt->nama_sampah) . ' ' . number_format($htt->berat / 1000, 2, ',', '.') . '/kg' ?>
														</td>
														<td>
															<div class="text-muted  ">
																<i class="mdi mdi-calendar align-middle me-2"></i>
																<?= date('d F Y', strtotime($htt->tanggal_transaksi)) ?>
															</div>
															<div class="text-muted  ">
																<i class="mdi mdi-clock align-middle me-2"></i>
																<?= date('H:i', strtotime($htt->tanggal_transaksi)) ?>
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


		<div class="card  mb-3">
			<div class="card-body">
				<h4 class="card-title text-center">Data Transaksi</h4>
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table id="history_transaksi" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">Kode</th>
										<th class="text-center">Nasabah</th>
										<th class="text-center">Sampah</th>
										<th class="text-center">Berat</th>
										<th class="text-center">Status</th>
										<th class="text-center">Tanggal</th>
									</tr>
								</thead>
								<tbody>
									<?php if (is_array($history_transaksi) || is_object($history_transaksi)) : ?>
										<?php foreach ($history_transaksi as $index => $ht) : ?>
											<tr>
												<td class="text-center"><?= htmlspecialchars($ht->kode_transaksi) ?></td>
												<td><?= htmlspecialchars($ht->nama) . ' [ RW ' . $ht->rt . ' / RT ' . $ht->rw . ' ]' ?></td>
												<td>
													<?= htmlspecialchars($ht->nama_sampah) ?>
												</td>
												<td>
													<?= number_format($ht->berat / 1000, 2, ',', '.') . '/kg' ?>
												</td>
												<td class="text-center">
													<?php
													$badgeClass     = '';
													$icon           = '';
													$status_text    = '';
													$status_tooltip = '';
													$button_status  = '';

													switch (htmlspecialchars($ht->status)) {
														case 'diterima':
															$badgeClass = 'badge badge-primary';
															$icon = '<i class="fas fa-check-circle"></i>';
															$status_text = 'Diterima';
															$status_tooltip = 'Menunggu disetorkan kepada Pelapak';
															$button_status = '<a href="' . base_url('Checkout-Transaksi/' . $ht->kode_transaksi) . '" class="btn btn-primary btn-sm fw-bold mt-2">Checkout?</a>';
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
													<label class="<?= $badgeClass ?> fw-bold" data-toggle="tooltip" title="<?= htmlspecialchars($status_tooltip) ?>">
														<?= $icon ?> <?= $status_text ?>
													</label><br>
													<?= $button_status ?>
												</td>
												<td>
													<div class="text-muted  ">
														<i class="mdi mdi-calendar align-middle me-2"></i>
														<?= date('d F Y', strtotime($ht->tanggal_transaksi)) ?>
													</div>
													<div class="text-muted  ">
														<i class="mdi mdi-clock align-middle me-2"></i>
														<?= date('H:i', strtotime($ht->tanggal_transaksi)) ?>
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

			$('#history_terakhir').DataTable({
				lengthChange: false,
				searching: false,
				paginate: false,
				info: false,
				order: false,
			});

			$('#history_transaksi').DataTable({
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
