<div class="main-panel">
	<div class="content-wrapper">
		<!-- Alert Messages -->
		<div class="row mb-3">
			<div class="col-12">
				<?php $this->load->view ( 'components/alert_messages' ); ?>
			</div>
		</div>

		<div class="row">
			<!-- RW Section -->
			<div class="col-lg-5 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-4">
							<h4 class="card-title">Data RW</h4>
							<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddRw">
								<i class="mdi mdi-plus-circle align-middle"></i> Tambah RW
							</button>
						</div>

						<div class="table-responsive">
							<table id="rwTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">RW</th>
										<th class="text-center">Jumlah RT</th>
										<th class="text-center">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $rw_list as $index => $rw ) : ?>
										<tr>
											<td class="text-center"><?= $index + 1 ?></td>
											<td class="text-center">RW <?= $rw->rw ?></td>
											<td class="text-center"><?= $this->M_Area->count_rt_in_rw ( $rw->id_rw ) ?></td>
											<td class="text-center">
												<div class="btn-group" role="group">
													<button type="button" data-toggle="tooltip" title="Edit"
																	class="btn btn-outline-warning btn-sm btn-edit-rw" data-id-rw="<?= $rw->id_rw ?>"
																	data-rw="<?= $rw->rw ?>" data-action="<?= site_url ( 'Edit-RW/' . $rw->id_rw ) ?>">
														<i class="mdi mdi-pencil align-middle"></i>
													</button>
													<button type="button" class="btn btn-outline-danger btn-sm btn-delete-rw" data-toggle="tooltip"
																	title="Hapus" data-id-rw="<?= $rw->id_rw ?>" data-rw="<?= $rw->rw ?>"
																	data-action="<?= site_url ( 'Delete-RW/' . $rw->id_rw ) ?>">
														<i class="mdi mdi-delete align-middle"></i>
													</button>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!-- RT Section -->
			<div class="col-lg-7 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-4">
							<h4 class="card-title">Data RT</h4>
							<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddRt">
								<i class="mdi mdi-plus-circle align-middle"></i> Tambah RT
							</button>
						</div>

						<div class="table-responsive">
							<table id="rtTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">RW</th>
										<th class="text-center">RT</th>
										<th class="text-center">Jumlah Nasabah</th>
										<th class="text-center">Ketua PKK</th>
										<th class="text-center">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $rt_list as $index => $rt ) : ?>
										<tr>
											<td class="text-center"><?= $index + 1 ?></td>
											<td class="text-center">RW <?= $rt->rw ?></td>
											<td class="text-center">RT <?= $rt->rt ?></td>
											<td class="text-center"><?= $this->M_Area->count_nasabah_in_rt ( $rt->id_rt ) ?></td>
											<td class="text-center">
												<p><?= $rt->nama_ketua_pkk ?: '<span class="text-muted">Belum ada</span>' ?></p>
												<?php if ( $rt->nama_ketua_pkk ) : ?>
													<button type="button" class="btn btn-outline-danger btn-sm btn-remove-ketua"
																	data-id-rt="<?= $rt->id_rt ?>" data-toggle="tooltip" title="Copot"
																	data-rt="<?= $rt->rt ?>"
																	data-action="<?= site_url ( 'Remove-Ketua-PKK/' . $rt->id_rt ) ?>">
														<i class="mdi mdi-account-remove align-middle"></i>
													</button>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<div class="btn-group" role="group">
													<a href="<?= site_url ( 'Ketua-PKK/' . $rt->id_rt ) ?>"
														 class="btn btn-outline-info btn-sm btn-set-ketua" data-toggle="tooltip" title="Set Ketua"
														 data-id-rt="<?= $rt->id_rt ?>">
														<i class="mdi mdi-account-check align-middle"></i>
													</a>
													<button type="button" class="btn btn-outline-warning btn-sm btn-edit-rt" data-toggle="tooltip"
																	title="Edit" data-id-rt="<?= $rt->id_rt ?>" data-id-rw="<?= $rt->id_rw ?>"
																	data-rt="<?= $rt->rt ?>" data-action="<?= site_url ( 'Edit-RT/' . $rt->id_rt ) ?>">
														<i class="mdi mdi-pencil align-middle"></i>
													</button>
													<button type="button" class="btn btn-outline-danger btn-sm btn-delete-rt" data-toggle="tooltip"
																	title="Hapus" data-id-rt="<?= $rt->id_rt ?>" data-rt="<?= $rt->rt ?>"
																	data-action="<?= site_url ( 'Delete-RT/' . $rt->id_rt ) ?>">
														<i class="mdi mdi-delete align-middle"></i>
													</button>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODALS -->
	<!-- Add RW Modal -->
	<div class="modal fade" id="modalAddRw" tabindex="-1" aria-labelledby="modalAddRwLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header ">
					<h5 class="modal-title" id="modalAddRwLabel">Tambah RW</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formAddRw" action="<?= site_url ( 'Add-RW' ) ?>" method="POST">
					<div class="modal-body">
						<div class="form-group mb-3">
							<label class="form-label">Nomor RW</label>
							<input type="number" class="form-control" name="rw" min="1" required>
							<div class="form-text">Masukkan angka positif (contoh: 1, 2, 3...)</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">
							<i class="mdi mdi-content-save align-middle"></i> Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit RW Modal -->
	<div class="modal fade" id="modalEditRw" tabindex="-1" aria-labelledby="modalEditRwLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header ">
					<h5 class="modal-title text-warning" id="modalEditRwLabel">
						<i class="mdi mdi-pencil align-middle"></i> Edit RW
					</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formEditRw" method="POST">
					<div class="modal-body">
						<input type="hidden" name="id_rw" id="id_rw_edit">
						<div class="form-group mb-3">
							<label class="form-label">Nomor RW</label>
							<input type="number" class="form-control" id="rw_edit" name="rw" min="1" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-warning text-white">
							<i class="mdi mdi-content-save align-middle"></i> Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add RT Modal -->
	<div class="modal fade" id="modalAddRt" tabindex="-1" aria-labelledby="modalAddRtLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header ">
					<h5 class="modal-title" id="modalAddRtLabel">Tambah RT</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formAddRt" action="<?= site_url ( 'Add-RT' ) ?>" method="POST">
					<div class="modal-body">
						<div class="form-group mb-3">
							<label class="form-label">RW</label>
							<select class="form-select" name="id_rw" required>
								<option value="">Pilih RW</option>
								<?php foreach ( $rw_list as $rw ) : ?>
									<option value="<?= $rw->id_rw ?>">RW <?= $rw->rw ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group mb-3">
							<label class="form-label">Nomor RT</label>
							<input type="number" class="form-control" name="rt" min="1" required>
							<div class="form-text">Masukkan angka positif (contoh: 1, 2, 3...)</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">
							<i class="mdi mdi-content-save align-middle"></i> Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit RT Modal -->
	<div class="modal fade" id="modalEditRt" tabindex="-1" aria-labelledby="modalEditRtLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header ">
					<h5 class="modal-title text-warning" id="modalEditRtLabel">
						<i class="mdi mdi-pencil align-middle"></i> Edit RT
					</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formEditRt" method="POST">
					<div class="modal-body">
						<input type="hidden" name="id_rt" id="id_rt_edit">
						<div class="form-group mb-3">
							<label class="form-label">RW</label>
							<select class="form-select" id="id_rw_edit" name="id_rw" required>
								<option value="">Pilih RW</option>
								<?php foreach ( $rw_list as $rw ) : ?>
									<option value="<?= $rw->id_rw ?>">RW <?= $rw->rw ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group mb-3">
							<label class="form-label">Nomor RT</label>
							<input type="number" class="form-control" id="rt_edit" name="rt" min="1" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-warning text-white">
							<i class="mdi mdi-content-save align-middle"></i> Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			// Enhanced DataTables Configuration
			const dataTableConfig = {
				lengthChange: false,
				searching: true,
				responsive: true,
				language: {
					lengthMenu: "Tampilkan _MENU_ data",
					info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
					infoEmpty: "Tidak ada data yang ditampilkan",
					infoFiltered: "(difilter dari _MAX_ total data)",
					zeroRecords: "Tidak ada data yang cocok",
					search: "Cari:",
					paginate: {
						first: "Pertama",
						last: "Terakhir",
						next: "Selanjutnya",
						previous: "Sebelumnya"
					}
				},
				initComplete: function () {
					$('.dataTables_filter input').attr('placeholder', 'Cari...');
				}
			};

			// Initialize DataTables with improved responsive settings
			$('#rwTable, #rtTable').DataTable(dataTableConfig).on('draw.dt', function () {
				$('[data-toggle="tooltip"]').tooltip();
			});

			// Enhanced Utility Functions
			const handleAjaxError = (xhr) => {
				let errorMsg = 'Terjadi kesalahan saat memproses permintaan';
				if (xhr.status === 0) {
					errorMsg = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
				} else if (xhr.status >= 500) {
					errorMsg = 'Terjadi kesalahan server. Silakan coba lagi nanti.';
				} else if (xhr.responseJSON?.status === 'error') {
					const messages = Array.isArray(xhr.responseJSON.message) ?
						xhr.responseJSON.message : [xhr.responseJSON.message || Object.values(xhr.responseJSON?.errors || {})];
					errorMsg = messages.join('<br>');
				}

				return Swal.fire({
					title: 'Error!',
					html: errorMsg,
					icon: 'error',
					showClass: {
						popup: 'animate__animated animate__shakeX'
					}
				});
			};

			const showConfirmation = (options) => {
				return Swal.fire({
					title: options.title,
					text: options.text,
					html: options.html,
					icon: options.icon || 'question',
					showCancelButton: true,
					confirmButtonColor: options.confirmButtonColor || '#3085d6',
					cancelButtonColor: options.cancelButtonColor || '#d33',
					confirmButtonText: options.confirmButtonText || 'Ya',
					cancelButtonText: options.cancelButtonText || 'Batal',
					showClass: {
						popup: 'animate__animated animate__fadeInDown'
					},
					hideClass: {
						popup: 'animate__animated animate__fadeOutUp'
					}
				});
			};

			const handleResponse = (response, successCallback = () => location.reload()) => {
				return Swal.fire({
					title: response.status === 'success' ? 'Berhasil!' : 'Gagal!',
					text: response.message,
					icon: response.status === 'success' ? 'success' : 'error',
					showConfirmButton: true,
					timer: response.status === 'success' ? 2000 : null
				}).then(() => {
					if (response.status === 'success') {
						successCallback();
					}
				});
			};

			const handleAjaxSubmit = (url, data, options = {}) => {
				const loadingSwal = Swal.fire({
					title: 'Memproses',
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading();
					}
				});
				return $.ajax({
					url: url,
					type: 'POST',
					data: data,
					dataType: 'json'
				}).always(() => {
					loadingSwal.close();
				}).then(
					(response) => handleResponse(response, options.successCallback),
					handleAjaxError
				);
			};

			// Enhanced Form Validation
			const validateInput = (input) => {
				const value = input.value.trim();
				const inputType = input.type;
				const inputName = input.name;

				if (input.hasAttribute('required') && !value) {
					return 'Field ini harus diisi';
				}

				if (input.minLength && value.length < input.minLength) {
					return `Minimal ${input.minLength} karakter`;
				}

				if (inputType === 'number') {
					const numValue = parseFloat(value);
					if (isNaN(numValue)) return 'Harus berupa angka';

					if (input.hasAttribute('min') && numValue < parseFloat(input.min)) {
						return `Nilai minimal adalah ${input.min}`;
					}

					if (input.hasAttribute('max') && numValue > parseFloat(input.max)) {
						return `Nilai maksimal adalah ${input.max}`;
					}
				}

				if (input.pattern) {
					try {
						const regex = new RegExp(input.pattern);
						if (value && !regex.test(value)) {
							return 'Format tidak valid';
						}
					} catch (e) {
						return 'Format validasi tidak valid';
					}
				}

				return '';
			};

			const validateForm = (form) => {
				let isValid = true;
				$(form).find('input, select').each(function () {
					const error = validateInput(this);
					const feedback = $(this).next('.invalid-feedback');
					$(this).toggleClass('is-invalid', !!error);
					$(this).toggleClass('is-valid', !error);
					if (error) {
						isValid = false;
						if (feedback.length) {
							feedback.text(error);
						} else {
							$(`<div class="invalid-feedback">${error}</div>`).insertAfter(this);
						}
					} else {
						feedback.remove();
					}
				});

				return isValid;
			};

			// Event Handlers
			$('form').on('input change', function () {
				validateForm(this);
			});

			// Enhanced Form Submission
			$('form').on('submit', function (e) {

				e.preventDefault();
				const form = $(this);

				if (!validateForm(this)) {
					return false;
				}

				const confirmOptions = {
					title: 'Konfirmasi',
					text: 'Anda yakin ingin melanjutkan?',
					icon: 'question'
				};

				showConfirmation(confirmOptions).then((result) => {
					if (result.isConfirmed) {
						handleAjaxSubmit(form.attr('action'), form.serialize());
					}
				});
			});

			// Modal Handlers
			const showModal = (trigger, modalId, dataMap) => {
				const modal = $(modalId);
				Object.entries(dataMap).forEach(([selector, dataAttr]) => {
					modal.find(selector).val(trigger.data(dataAttr.toLowerCase()));
				});
				modal.find('form').attr('action', trigger.data('action'));
				modal.modal('show');
			};

			$(document).on('click', '.btn-edit-rw', function () {
				showModal($(this), '#modalEditRw', {
					'#id_rw_edit': 'id-rw',
					'#rw_edit': 'rw'
				});
			});

			$(document).on('click', '.btn-edit-rt', function () {
				showModal($(this), '#modalEditRt', {
					'#id_rt_edit': 'id-rt',
					'#id_rw_edit': 'id-rw',
					'#rt_edit': 'rt'
				});
			});

			// Special Actions
			$(document).on('click', '.btn-remove-ketua', function () {
				const button = $(this);
				const rtNumber = button.data('rt');

				showConfirmation({
					title: 'Copot Ketua PKK?',
					html: `Anda yakin ingin mencopot ketua PKK untuk <strong>RT ${rtNumber}</strong>?`,
					icon: 'warning',
					confirmButtonText: 'Ya, Copot!'
				}).then((result) => {
					if (result.isConfirmed) {
						handleAjaxSubmit(button.data('action'), {
							id_rt: button.data('idRt')
						});
					}
				});
			});

			$(document).on('click', '.btn-delete-rw, .btn-delete-rt', function () {
				const isRw = $(this).hasClass('btn-delete-rw');
				const number = $(this).data(isRw ? 'rw' : 'rt');

				showConfirmation({
					title: `Hapus ${isRw ? 'RW' : 'RT'}?`,
					html: `Anda yakin ingin menghapus ${isRw ? 'RW' : 'RT'} <strong>${number}</strong>?<br>
										<small>${isRw ? 'Semua data RT yang terkait' : 'Semua data nasabah yang terkait'} juga akan terpengaruh</small>`,
					icon: 'warning',
				}).then((result) => {
					if (result.isConfirmed) {
						handleAjaxSubmit($(this).data('action'));
					}
				});
			});

			// Modal Cleanup
			$('.modal').on('hidden.bs.modal', function () {
				$(this).find('form').trigger('reset');
				$(this).find('.is-invalid').removeClass('is-invalid');
				$(this).find('.is-valid').removeClass('is-valid');
				$(this).find('.invalid-feedback').remove();
			});

			// Initialize tooltips with better configuration
			$('[data-toggle="tooltip"]').tooltip({
				boundary: 'window',
				trigger: 'hover',
				delay: {
					show: 300,
					hide: 100
				}
			});
		});
	</script>