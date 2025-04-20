<div class="main-panel">
	<div class="content-wrapper">
		<div class="card mb-4">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-4">
					<div>
						<h4 class="card-title mb-2">Management Hasil Karya</h4>
						<p class="card-description">Daftar karya kreatif dari bank sampah</p>
					</div>
					<a href="<?= base_url('Hasil-Karya/add') ?>" class="btn btn-primary btn-icon-text">
						<i class="mdi mdi-plus-circle-outline align-middle"></i> Tambah Karya
					</a>
				</div>

				<?php $this->load->view('components/alert_messages'); ?>

				<div class="table-responsive">
					<table id="karyaTable" class="table table-hover table-bordered">
						<thead class="thead-light">
							<tr>
								<th width="5%">No</th>
								<th width="20%">Judul</th>
								<th width="15%">Gambar</th>
								<th width="20%">Konten</th>
								<th width="15%">Penulis</th>
								<th width="15%">Tanggal</th>
								<th width="10%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($karya as $index => $item) : ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td>
										<div class="font-weight-bold"><?= htmlspecialchars($item->judul) ?></div>
									</td>
									<td class="text-center">
										<div class="img-thumbnail-container">
											<img src="<?= base_url('./assets/uploads/karya/' . $item->gambar) ?>" alt="<?= $item->judul ?>" class="img-thumbnail img-fluid" data-toggle="modal" data-target="#imageModal-<?= $item->id_hasil_karya ?>">
										</div>

										<!-- Image Preview Modal -->
										<div class="modal fade" id="imageModal-<?= $item->id_hasil_karya ?>" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content bg-transparent border-0">
													<div class="modal-body text-center p-1">
														<img src="<?= base_url('./assets/uploads/karya/' . $item->gambar) ?>" class="img-fluid img-thumbnail w-50 h-auto">
													</div>
												</div>
											</div>
										</div>
									</td>
									<td>
										<div class="text-truncate" style="max-width: 250px;" data-toggle="tooltip" title="<?= htmlspecialchars(strip_tags($item->konten)) ?>">
											<?= htmlspecialchars(substr(strip_tags($item->konten), 0, 50)) ?>...
										</div>
									</td>
									<td class="text-center">
										<div class="d-flex align-items-center justify-content-center">
											<div class="badge badge-primary badge-pill me-2">
												<i class="mdi mdi-account align-middle"></i>
											</div>
											<span class="ms-2">
												<?= htmlspecialchars($item->author) ?>
											</span>
										</div>
									</td>
									<td>
										<div class="text-muted">
											<i class="mdi mdi-calendar align-middle me-2"></i>
											<?= date('d F Y', strtotime($item->tanggal_dibuat)) ?>
										</div>
										<div class="text-muted">
											<i class="mdi mdi-clock align-middle me-2"></i>
											<?= date('H:i', strtotime($item->tanggal_dibuat)) ?>
										</div>
									</td>
									<td class="text-center">
										<div class="btn-group" role="group">
											<a href="<?= base_url('Hasil-Karya/edit/' . $item->id_hasil_karya) ?>" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" title="Edit">
												<i class="mdi mdi-pencil align-middle"></i>
											</a>
											<button type="button" class="btn btn-sm btn-outline-danger btn-delete-karya" data-id="<?= $item->id_hasil_karya ?>" data-judul="<?= htmlspecialchars($item->judul) ?>" data-action="<?= base_url('Hasil-Karya/delete/' . $item->id_hasil_karya) ?>" data-toggle="tooltip" title="Hapus">
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

		<script>
			$(document).ready(function() {
				// Initialize DataTable with enhanced options
				$('#karyaTable').DataTable({
					responsive: true,
					layout: {
						topEnd: {
							search: {
								placeholder: 'Cari judul, penulis...'
							},
						},
					},
					language: {
						lengthMenu: "Tampilkan _MENU_ data per halaman",
						info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ karya",
						infoEmpty: "Tidak ada data yang ditampilkan",
						infoFiltered: "(difilter dari _MAX_ total karya)",
						search: "Cari:",
						zeroRecords: "Tidak ada karya yang cocok",
						paginate: {
							first: "<i class='mdi mdi-chevron-double-left'></i>",
							last: "<i class='mdi mdi-chevron-double-right'></i>",
							next: "<i class='mdi mdi-chevron-right'></i>",
							previous: "<i class='mdi mdi-chevron-left'></i>"
						}
					},
					columnDefs: [{
							responsivePriority: 1,
							targets: 1
						},
						{
							responsivePriority: 2,
							targets: -1
						},
						{
							orderable: false,
							targets: [0, 2, -1]
						}
					],
				});

				// Initialize tooltips
				$('[data-toggle="tooltip"]').tooltip({
					boundary: 'window'
				});

				// Utility Functions
				const handleAjaxError = (xhr) => {
					let errorMsg = 'Terjadi kesalahan saat memproses permintaan';
					if (xhr.responseJSON?.status === 'error') {
						const messages = Array.isArray(xhr.responseJSON.message) ?
							xhr.responseJSON.message : [xhr.responseJSON.message || Object.values(xhr.responseJSON?.errors || {})];
						errorMsg = messages.join('<br>');
					}

					Swal.fire({
						title: 'Error!',
						html: errorMsg,
						icon: 'error'
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
						cancelButtonText: options.cancelButtonText || 'Batal'
					});
				};

				const handleResponse = (response, successCallback = () => location.reload()) => {
					Swal.fire({
						title: response.status === 'success' ? 'Berhasil!' : 'Gagal!',
						text: response.message,
						icon: response.status === 'success' ? 'success' : 'error'
					}).then(() => {
						if (response.status === 'success') {
							successCallback();
						}
					});
				};

				const handleAjaxSubmit = (url, data, options = {}) => {
					$.ajax({
						url: url,
						type: 'POST',
						data: data,
						dataType: 'json',
						beforeSend: function() {
							Swal.fire({
								title: 'Memproses',
								allowOutsideClick: false,
								didOpen: () => {
									Swal.showLoading()
								}
							});
						},
						success: (response) => handleResponse(response, options.successCallback),
						error: handleAjaxError
					});
				};

				// Delete confirmation
				$(document).on('click', '.btn-delete-karya', function() {
					const button = $(this);
					const id = button.data('id');
					const judul = button.data('judul');
					const action = button.data('action');

					showConfirmation({
						title: `Hapus Karya?`,
						html: `Anda yakin ingin menghapus karya <strong>${judul}</strong>?<br>
            <small>Data yang dihapus tidak dapat dikembalikan</small>`,
						icon: 'warning',
						confirmButtonText: 'Ya, Hapus!'
					}).then((result) => {
						if (result.isConfirmed) {
							handleAjaxSubmit(action, {
								id: id
							});
						}
					});
				});
			});
		</script>

		<style>
			.img-thumbnail-container {
				cursor: pointer;
				transition: transform 0.2s;
			}

			.img-thumbnail-container:hover {
				transform: scale(1.05);
			}

			.img-thumbnail {
				object-fit: cover;
				width: 100%;
				height: 100%;
			}

			.badge-pill {
				width: 24px;
				height: 24px;
				display: flex;
				align-items: center;
				justify-content: center;
			}
		</style>
	</div>
