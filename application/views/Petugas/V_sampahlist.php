<!-- End custom js for this page-->

<div class="main-panel">
	<div class="content-wrapper">
		<div class="card mb-3">
			<div class="card-body">
				<h4 class="card-title">Data Harga Sampah</h4>
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
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

							<table id="harga_sampah_list" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="5%">No</th>
										<th width="30%">Kategori</th>
										<th width="40%">Sampah</th>
										<th width="10%">Harga</th>
										<th widht="5%">Periode</th>
										<th width="10%" class="text-center">Update</th>
									</tr>
								</thead>
								<tbody>
									<?php if (is_array($data_harga_sampah) || is_object($data_harga_sampah)) : ?>
										<?php foreach ($data_harga_sampah as $index => $dhs) : ?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td><?= htmlspecialchars($dhs->jenis_sampah) ?></td>
												<td><?= htmlspecialchars($dhs->nama_sampah) ?></td>
												<td>Rp. <?= htmlspecialchars(number_format($dhs->harga_per_kg, 2, ',', '.')) ?>/kg</td>
												<td>
													<div class="text-muted  ">
														<i class="mdi mdi-calendar align-middle me-2"></i>
														<?= date('d F Y', strtotime($dhs->periode)) ?>
													</div>
												</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-info btn-sm btn-update-harga" style="width: 3rem; height: 3rem; border-radius: 3rem;" data-toggle="tooltip" title="Update Harga" data-id-sampah="<?= $dhs->id_sampah ?>" data-nama-sampah="<?= htmlspecialchars($dhs->nama_sampah) ?>" data-harga-per-kg="<?= htmlspecialchars($dhs->harga_per_kg) ?>" data-periode="<?= htmlspecialchars($dhs->periode) ?>" data-action="<?= base_url('Edit-Harga-Sampah/' . $dhs->id_sampah) ?>">
														<i class="mdi  mdi-sync  align-middle"></i>
													</button>
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

		<!-- Single Modal for Editing Sampah -->
		<div class="modal fade" id="hargaUpdateModal" tabindex="-1" aria-labelledby="hargaUpdateModalLabel" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-info" id="hargaUpdateModalLabel">Update Harga Sampah <i class="mdi mdi-pencil text-info align-middle"></i></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formUpdateHarga" method="POST">
							<input type="hidden" name="id_sampah" id="id_sampah" value="">
							<input type="hidden" name="nama_sampah" id="nama_sampah_val" value="">
							<h6>Apakah ada pembaruan harga <span id="nama_sampah"></span> ?</h6>
							<p>Silahkan diupdate disini</p>

							<div class="form-group">
								<label for="harga_per_kg">Harga Sampah</label>
								<input type="number" class="form-control" id="harga_per_kg" name="harga_per_kg" placeholder="Harga Sampah" required>
								<small class="text-small">*Harga per Kg</small>
							</div>

							<div class="form-group">
								<label for="periode">Periode terakhir update</label>
								<input type="date" class="form-control" id="periode" name="periode" min="<?= date('Y-m-d', strtotime('-1 week')) ?>" max="<?= date('Y-m-d') ?>" required>
							</div>

					</div>
					<div class="modal-footer justify-content-around">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-danger " onclick="confirmRollback($('#id_sampah').val())">
							<i class=" mdi mdi-minus-circle align-middle"></i> Rollback
						</button>
						<button type="submit" class="btn btn-success"><i class="mdi mdi-plus-circle align-middle text-white"></i>
							Update </button>
					</div>
					</form>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Data Sampah</h4>
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<div class="d-flex justify-content-start mb-3">
								<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#sampahAdd">
									<i class=" mdi mdi-plus-circle align-middle"></i> Tambah Data Sampah
								</button>
							</div>

							<table id="sampah_list" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="5%">No</th>
										<th width="25%">Jenis Sampah</th>
										<th>Sampah</th>
										<th width="20%">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php if (is_array($data_sampah) || is_object($data_sampah)) : ?>
										<?php foreach ($data_sampah as $index => $ds) : ?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td><?= htmlspecialchars($ds->jenis_sampah) ?></td>
												<td><?= htmlspecialchars($ds->nama_sampah) ?></td>
												<td class="text-center">
													<div class="btn-group" role="group">
														<button type="button" class="btn btn-outline-warning btn-sm btn-update-sampah" data-toggle="tooltip" title="Edit" data-id-sampah="<?= $ds->id_sampah ?>" data-nama-sampah="<?= htmlspecialchars($ds->nama_sampah) ?>" data-id-jenis-sampah="<?= $ds->id_jenis_sampah ?>" data-action=" <?= base_url('Edit-Sampah/' . $ds->id_sampah) ?>">
															<i class="mdi mdi-pencil  align-middle"></i>
														</button>
														<button type="button" class="btn btn-outline-danger btn-sm btn-delete-sampah" data-toggle="tooltip" title="Hapus" data-id-sampah="<?= $ds->id_sampah ?>" data-nama-sampah="<?= htmlspecialchars($ds->nama_sampah) ?>" data-action=" <?= base_url('Delete-Sampah/' . $ds->id_sampah) ?>">
															<i class="mdi mdi-delete  align-middle"></i>
														</button>
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

		<!-- Modal for Editing Sampah -->
		<div class="modal fade" id="sampahEditModal" tabindex="-1" aria-labelledby="sampahEditModalLabel" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-warning" id="sampahEditModalLabel">Edit Sampah <i class="mdi mdi-pencil text-warning align-middle"></i></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formEditSampah" method="POST">
							<input type="hidden" name="id_sampah" id="id_sampah_edit" value="">

							<div class="form-group <?= form_error('id_jenis_sampah') ? 'has-danger' : '' ?>">
								<label for="id_jenis_sampah">Jenis Sampah</label>
								<select class="form-control form-select" id="id_jenis_sampah_edit" name="id_jenis_sampah" required>
									<option value="">- Pilih -</option>
									<?php if (is_array($data_jenis_sampah) || is_object($data_jenis_sampah)) : ?>
										<?php foreach ($data_jenis_sampah as $djs) : ?>
											<option value="<?= $djs->id_jenis_sampah ?>"><?= $djs->jenis_sampah ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</div>

							<div class="form-group <?= form_error('nama_sampah') ? 'has-danger' : '' ?>">
								<label for="nama_sampah">Sampah</label>
								<input type="text" class="form-control" id="nama_sampah_edit" name="nama_sampah" placeholder="Sampah" required>
								<?= form_error('nama_sampah', '<label class="error mt-2 text-danger">', '</label>'); ?>
							</div>
					</div>
					<div class="modal-footer justify-content-around">
						<button type="button" class=" btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-warning"><i class="mdi mdi-pencil align-middle text-white"></i>
							Edit</button>
					</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Single Modal for Deleting Sampah -->
		<div class="modal fade" id="sampahHapusModal" tabindex="-1" aria-labelledby="sampahHapusModalLabel" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-danger" id="sampahHapusModalLabel">Hapus Sampah <i class="mdi mdi-delete align-middle text-danger"></i></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body text-center">
						<h6 class="mb-3">Anda yakin ingin menghapus sampah ini?</h6>
						<h5 class="text-primary" id="nama_sampah_hapus"></h5>

						<form id="formHapusSampah" method="POST">
							<input type="hidden" name="id_sampah" id="id_sampah_hapus" value="">
					</div>
					<div class="modal-footer justify-content-around">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger"><i class="mdi mdi-delete align-middle text-white"></i>
							Hapus</button>
					</div>
					</form>
				</div>
			</div>
		</div>

	</div>

	<?php
	// Load modals
	$this->load->view('Petugas/modals/modal_add_sampah');
	?>

	<script type="text/javascript">
		$(document).on('click', '.btn-update-harga', function() {
			const idSampah = $(this).data('id-sampah');
			const namaSampah = $(this).data('nama-sampah');
			const hargaPerKg = $(this).data('harga-per-kg');
			const periode = $(this).data('periode');
			const actionUrl = $(this).data('action');

			// Populate the modal fields
			$('#id_sampah').val(idSampah);
			$('#nama_sampah_val').val(namaSampah);
			$('#harga_per_kg').val(hargaPerKg);
			$('#periode').val(periode);

			$('#nama_sampah').text(namaSampah);

			// Set the form action
			$('#formUpdateHarga').attr('action', actionUrl);

			// Show the modal
			$('#hargaUpdateModal').modal('show');
		});

		$(document).on('click', '.btn-update-sampah', function() {
			const idSampah = $(this).data('id-sampah');
			const namaSampah = $(this).data('nama-sampah');
			const idJenisSampah = $(this).data('id-jenis-sampah');
			const actionUrl = $(this).data('action');

			// Set the form action
			$('#formEditSampah').attr('action', actionUrl);

			// Populate the modal fields with unique IDs
			$('#id_sampah_edit').val(idSampah);
			$('#nama_sampah_edit').val(namaSampah);
			$('#id_jenis_sampah_edit').val(idJenisSampah);


			// Show the modal
			$('#sampahEditModal').modal('show');
		});

		$(document).on('click', '.btn-delete-sampah', function() {
			const idSampah = $(this).data('id-sampah');
			const namaSampah = $(this).data('nama-sampah');
			const actionUrl = $(this).data('action');

			// Set the form action
			$('#formHapusSampah').attr('action', actionUrl);

			// Populate the modal fields
			$('#id_sampah_hapus').val(idSampah);
			$('#nama_sampah_hapus').text(namaSampah); // Set the name of the item to be deleted

			// Show the modal
			$('#sampahHapusModal').modal('show');
		});

		function confirmRollback(id_sampah) {
			$.ajax({
				type: "GET",
				url: '<?= base_url('Get-Last-Harga-Sampah/') ?>' + id_sampah,
				success: function(data) {
					const response = JSON.parse(data);
					if (response.error) {
						Swal.fire("Error", response.error + "<br>Mungkin sudah lebih dari 1 minggu", "error");
					} else {
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
									url: '<?= base_url('Rollback-Harga-Sampah/') ?>' + id_sampah,
									data: {
										'id_sampah': id_sampah,
									},
									dataType: "json",
									success: function(response) {
										if (response.status == 'success') {
											$('#hargaUpdateModal').modal('hide');
											Swal.fire({
												title: "Deleted!",
												text: "Data berhasil dirollback.",
												icon: "success"
											}).then(() => {
												location.reload();
											});
										} else {
											Swal.fire({
												title: "Error",
												text: response.message || "Terjadi kesalahan saat memperbarui harga.",
												icon: "error"
											});
										}
									},
									error: function(xhr) {
										Swal.fire("Cancelled", "Data gagal dirollback.", "error");
									}
								});
							}
						});
					}
				},
				error: function() {
					Swal.fire("Error", "Gagal mengambil data terakhir.", "error");
				}
			});
		}

		$('#formUpdateHarga').on('submit', function(e) {
			e.preventDefault();
			const formData = $(this).serialize();
			const namaSampah = $('#nama_sampah_val').val();

			$.ajax({
				type: "POST",
				url: '<?= base_url('Edit-Harga-Sampah/') ?>' + $('#id_sampah').val(),
				data: formData,
				dataType: "json",
				success: function(response) {
					$('#hargaUpdateModal').modal('hide');
					Swal.fire({
						title: "Success!",
						text: "Harga " + namaSampah + " berhasil diperbarui",
						icon: "success"
					}).then(() => {
						location.reload();
					});
				},
				error: function(data) {
					let responseData = data.responseJSON;
					Swal.fire("Error", "<small>" + responseData.errors + "</small>", "error");
				}
			});
		});

		$(document).ready(function() {
			// Initialize DataTable with Bootstrap 4 styling

			$('#harga_sampah_list').DataTable({
				layout: {
					top2Start: {
						info: {},

					},
					top1Start: {
						buttons: [
							'copy', 'excel', 'pdf', 'print', 'colvis'
						],
					},
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

			const sampahTable = $('#sampah_list').DataTable({
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

			// Form validation
			$('#addSampah').on('submit', function(e) {
				const form = $(this);
				const sampahInput = form.find('[name="nama_sampah"]');
				const jenisInput = form.find('[name="id_jenis_sampah"]');

				if (!sampahInput.val().trim() || !jenisInput.val()) {
					e.preventDefault();
					Swal.fire({
						icon: 'error',
						title: 'Validasi Error',
						text: 'Semua field harus diisi!'
					});
					return false;
				}

				// Confirm submission
				if (form.data('confirm') === 'delete') {
					e.preventDefault();
					Swal.fire({
						title: 'Konfirmasi Hapus',
						text: "Data yang dihapus tidak dapat dikembalikan!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#d33',
						cancelButtonColor: '#3085d6',
						confirmButtonText: 'Ya, Hapus!',
						cancelButtonText: 'Batal'
					}).then((result) => {
						if (result.isConfirmed) {
							form.off('submit').submit();
						}
					});
				}
			});
			// Initialize tooltips
			$('[data-toggle="tooltip"]').tooltip({
				boundary: 'window'
			});

			// Auto-hide alerts
			$('.alert').delay(5000).fadeOut(500);

		});
	</script>
