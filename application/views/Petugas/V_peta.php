<link href="<?= base_url() ?>assets/css/map.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/ol@v9.2.4/dist/ol.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.2.4/ol.css">

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row mb-3">
			<div class="col-8">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Lokasi Bank Sampah</h4>

						<div id="map" class="map"></div>
						<!-- Popup hover -->
						<div id="popup" class="ol-popup">
							<a id="popup-closer" class="ol-popup-closer"></a>
							<div id="popup-content"></div>
						</div>

						<!-- Popup click -->
						<div id="popupClick" class="ol-popup">
							<a id="popup-closer" class="ol-popup-closer"></a>
							<div id="popup-content-click"></div>
						</div>

						<button class="w-100 btn btn-dark mt-3" onclick="clearMarkers()">
							<i class="mdi mdi-delete align-middle"></i> Clear Marker
						</button>


					</div>
				</div>
			</div>

			<div class="col-4">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Tambah Lokasi Baru</h4>
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
								<form class="pt-3" method="POST" id="locationForm">
									<div class="row justify-content-center w-auto mx-auto">
										<div class="col-12 col-sm-12 col-md-10 col-lg-12">
											<div class="form-group">
												<label for="nama_lokasi">Nama Lokasi:</label>
												<input type="text" class="form-control  <?= form_error('nama_lokasi	') ? 'is-invalid' : ''; ?>" name="nama_lokasi" required>
												<div class="invalid-feedback">
													<?= form_error('nama_lokasi'); ?>
												</div>
											</div>
											<div class="form-group">
												<label for="latitude">Latitude:</label>
												<input type="text" class="form-control <?= form_error('latitude	') ? 'is-invalid' : ''; ?>" name="latitude" id="latitude" readonly>
												<div class="invalid-feedback">
													<?= form_error('latitude'); ?>
												</div>
											</div>
											<div class="form-group">
												<label for="longitude">Longitude:</label>
												<input type="text" class="form-control <?= form_error('longitude	') ? 'is-invalid' : ''; ?>" name="longitude" id="longitude" readonly>
												<div class="invalid-feedback">
													<?= form_error('longitude'); ?>
												</div>
											</div>
											<div class="form-group">
												<label for="alamat">Alamat:</label>
												<textarea class="form-control <?= form_error('alamat	') ? 'is-invalid' : ''; ?>" style="height: 6em;" name="alamat" required></textarea>
												<div class="invalid-feedback">
													<?= form_error('alamat'); ?>
												</div>
											</div>
											<div class="mt-3 d-flex justify-content-end">
												<button type="submit" class="btn btn-success fw-bolder fs-6 my-2 ">Tambah <i class="icon-pencil m-0 p-1 fw-bolder fs-6 align-middle"></i></button>
											</div>
										</div>
									</div>
								</form>
								<script>
									$(document).ready(function() {
										$('#locationForm').on('submit', function(e) {
											e.preventDefault();

											// Reset previous error states
											$('.form-control').removeClass('is-invalid');
											$('.invalid-feedback').empty();

											const formData = $(this).serialize();

											$.ajax({
												type: "POST",
												url: '<?= base_url('Add-Peta') ?>',
												data: formData,
												dataType: "json",
												success: function(response) {
													if (response.status === 'success') {
														Swal.fire({
															title: "Success!",
															text: "Lokasi berhasil disimpan!",
															icon: "success"
														}).then(() => {
															location.reload();
														});
													} else {
														// Handle other success cases if needed
													}
												},
												error: function(xhr) {
													if (xhr.status === 422) {
														// Handle validation errors
														const response = xhr.responseJSON;

														if (response.errors) {
															$.each(response.errors, function(field, error) {
																const input = $('[name="' + field + '"]');
																const feedback = input.next('.invalid-feedback');

																input.addClass('is-invalid');
																feedback.html(error);
															});

															// Show first error in SweetAlert if needed
															const firstError = Object.values(response.errors)[0];
															Swal.fire({
																title: "Validation Error",
																html: "<small class='text-danger'>" + firstError + "</small>",
																icon: "error"
															});
														}
													} else {
														// Handle other errors
														let errorMessage = "Terjadi kesalahan saat menyimpan data";
														if (xhr.responseJSON && xhr.responseJSON.message) {
															errorMessage = xhr.responseJSON.message;
														}

														Swal.fire({
															title: "Error",
															text: errorMessage,
															icon: "error"
														});

														// Also show in alert container if needed
														$('#alert-container').html(`
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            ${errorMessage}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    `);
													}
												}
											});
										});
									});
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-4">
			<div class="card-body p-4">
				<h4 class="card-title text-center mb-4">Daftar Lokasi</h4>
				<div class="table-responsive">
					<table id="daftar_lokasi" class="table table-striped table-hover table-bordered nowrap" style="width:100%">
						<thead class="table-light">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama Lokasi</th>
								<th class="text-center">Alamat</th>
								<th class="text-center">Koordinat</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($locations as $index => $loc) : ?>
								<tr>
									<td class="text-center align-middle"><?= $index + 1 ?></td> <!-- Added align-middle -->
									<td class="text-center align-middle"><?= htmlspecialchars($loc['Desc']) ?></td>
									<td class="text-start align-middle"><?= $loc['alamat'] ?></td>
									<td class="text-center align-middle">
										<span class="badge bg-info text-dark">
											<?= $loc['Lat'] ?>, <?= $loc['Lon'] ?>
										</span>
									</td>
									<td class="text-start align-middle">
										<div class="d-flex flex-column">
											<span class="text-muted">
												<i class="mdi mdi-calendar align-middle me-2"></i>
												<?= date('d F Y', strtotime($loc['tanggal_dibuat'])) ?>
											</span>
											<span class="text-muted">
												<i class="mdi mdi-clock align-middle me-2"></i>
												<?= date('H:i', strtotime($loc['tanggal_dibuat'])) ?>
											</span>
										</div>
									</td>
									<td class="text-center align-middle">
										<div class="btn-group " role="group">
											<button type="button" class="btn btn-sm btn-outline-warning  btn-update-lokasi" data-toggle="tooltip" title="Edit" data-id-lokasi="<?= $loc['id_lokasi'] ?>" data-nama-lokasi="<?= htmlspecialchars($loc['Desc']) ?>" data-alamat="<?= htmlspecialchars($loc['alamat']) ?>" data-latitude="<?= htmlspecialchars($loc['Lat']) ?>" data-longitude="<?= htmlspecialchars($loc['Lon']) ?>" data-action="<?= base_url('Edit-Peta/' . $loc['id_lokasi']) ?>">
												<i class="mdi mdi-pencil align-middle"></i>
											</button>
											<button type="button" class="btn btn-sm btn-outline-danger btn-delete-lokasi" data-toggle="tooltip" title="Hapus" data-id-lokasi="<?= $loc['id_lokasi'] ?>" data-nama-lokasi="<?= htmlspecialchars($loc['Desc']) ?>" data-alamat="<?= htmlspecialchars($loc['alamat']) ?>" data-latitude="<?= htmlspecialchars($loc['Lat']) ?>" data-longitude="<?= htmlspecialchars($loc['Lon']) ?>" data-action="<?= base_url('Delete-Peta/' . $loc['id_lokasi']) ?>">
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

	<!-- Modal for Editing Lokasi -->
	<div class="modal fade" id="lokasiEditModal" tabindex="-1" aria-labelledby="lokasiEditModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-warning" id="lokasiEditModalLabel">Edit Lokasi <i class="mdi mdi-pencil text-warning align-middle"></i></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="formEditLokasi" method="POST">
						<input type="hidden" name="id_lokasi" id="id_lokasi_edit" value="">

						<div class="form-group">
							<label for="nama_lokasi">Nama Lokasi:</label>
							<input type="text" class="form-control  <?= form_error('nama_lokasi	') ? 'is-invalid' : ''; ?>" name="nama_lokasi" id="nama_lokasi_edit" required>
							<div class="invalid-feedback">
								<?= form_error('nama_lokasi'); ?>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="form-group">
								<label for="latitude">Latitude:</label>
								<input type="text" class="form-control <?= form_error('latitude	') ? 'is-invalid' : ''; ?>" name="latitude" id="latitude_edit">
								<div class="invalid-feedback">
									<?= form_error('latitude'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="longitude">Longitude:</label>
								<input type="text" class="form-control <?= form_error('longitude	') ? 'is-invalid' : ''; ?>" name="longitude" id="longitude_edit">
								<div class="invalid-feedback">
									<?= form_error('longitude'); ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat">Alamat:</label>
							<textarea class="form-control <?= form_error('alamat	') ? 'is-invalid' : ''; ?>" style="height: 6em;" name="alamat" id="alamat_edit" required></textarea>
							<div class="invalid-feedback">
								<?= form_error('alamat'); ?>
							</div>
						</div>

				</div>
				<div class="modal-footer justify-content-around">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-warning"><i class="mdi mdi-pencil align-middle text-white"></i>
						Edit</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#formEditLokasi').on('submit', function(e) {
				e.preventDefault();

				// Reset previous error states
				$('.form-control').removeClass('is-invalid');
				$('.invalid-feedback').empty();

				const formData = $(this).serialize();

				$.ajax({
					type: "POST",
					url: '<?= base_url('Edit-Peta/') ?>' + $('#id_lokasi_edit').val(),
					data: formData,
					dataType: "json",
					success: function(response) {
						if (response.status === 'success') {
							Swal.fire({
								title: "Success!",
								text: "Lokasi berhasil disimpan!",
								icon: "success"
							}).then(() => {
								location.reload();
							});
						} else {}
					},
					error: function(xhr) {
						if (xhr.status === 422) {
							// Handle validation errors
							const response = xhr.responseJSON;

							if (response.errors) {
								$.each(response.errors, function(field, error) {
									const input = $('[name="' + field + '"]');
									const feedback = input.next('.invalid-feedback');

									input.addClass('is-invalid');
									feedback.html(error);
								});

								// Show first error in SweetAlert if needed
								const firstError = Object.values(response.errors)[0];
								Swal.fire({
									title: "Validation Error",
									html: "<small class='text-danger'>" + firstError + "</small>",
									icon: "error"
								});
							}
						} else {
							// Handle other errors
							let errorMessage = "Terjadi kesalahan saat menyimpan data";
							if (xhr.responseJSON && xhr.responseJSON.message) {
								errorMessage = xhr.responseJSON.message;
							}

							Swal.fire({
								title: "Error",
								text: errorMessage,
								icon: "error"
							});

							// Also show in alert container if needed
							$('#alert-container').html(`
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            ${errorMessage}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    `);
						}
					}
				});
			});
		});
	</script>


	<!-- Single Modal for Deleting Lokasi -->
	<div class="modal fade" id="lokasiHapusModal" tabindex="-1" aria-labelledby="lokasiHapusModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-danger" id="lokasiHapusModalLabel">Hapus lokasi <i class="mdi mdi-delete align-middle text-danger"></i></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<h6 class="mb-3">Anda yakin ingin menghapus lokasi ini?</h6>
					<h5 class="text-primary" id="nama_lokasi_hapus"></h5>
					<h6 class="text-primary" id="alamat_hapus"></h6>

					<form id="formHapusLokasi" method="POST">
						<input type="hidden" name="id_lokasi" id="id_lokasi_hapus" value="">
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

	<script src="<?= base_url() ?>assets/js/Map/ol.map.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			// Initialize tooltips
			$('[data-toggle="tooltip"]').tooltip({
				boundary: 'window'
			});
			// Initialize DataTable
			initializeDataTable();

			// Set up event handlers
			setupEventHandlers();
		});

		function initializeDataTable() {
			$('#daftar_lokasi').DataTable({
				order: false,
				layout: {
					top: {
						buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
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
				},
				columnDefs: [{
						// No
						responsivePriority: 1,
						targets: 0
					},
					{
						// Action
						responsivePriority: 2,
						targets: -1
					},
					{
						// Nama Lokasi
						responsivePriority: 3,
						targets: 1
					},
					{
						// Alamat
						responsivePriority: 4,
						targets: 2
					},
					{
						// Disable sorting for No, Image, Actions
						orderable: false,
						targets: [0, -1]
					}
				]
			});
		}

		function setupEventHandlers() {
			// Edit location button handler
			jQuery(document).on('click', '.btn-update-lokasi', function() {
				const $button = $(this);
				showEditModal(
					$button.data('id-lokasi'),
					$button.data('nama-lokasi'),
					$button.data('longitude'),
					$button.data('latitude'),
					$button.data('alamat'),
					$button.data('action')
				);
			});

			// Delete location button handler
			jQuery(document).on('click', '.btn-delete-lokasi', function() {
				const $button = $(this);
				showDeleteModal(
					$button.data('id-lokasi'),
					$button.data('nama-lokasi'),
					$button.data('alamat'),
					$button.data('action')
				);
			});
		}

		function showEditModal(id, name, longitude, latitude, address, actionUrl) {
			// Set form action
			$('#formEditLokasi').attr('action', actionUrl);

			// Populate form fields
			$('#id_lokasi_edit').val(id);
			$('#nama_lokasi_edit').val(name);
			$('#longitude_edit').val(longitude);
			$('#latitude_edit').val(latitude);
			$('#alamat_edit').val(address);

			// Show modal
			jQuery('#lokasiEditModal').modal('show');
		}

		function showDeleteModal(id, name, address, actionUrl) {
			// Set form action
			$('#formHapusLokasi').attr('action', actionUrl);

			// Populate modal content
			$('#id_lokasi_hapus').val(id);
			$('#nama_lokasi_hapus').text(name);
			$('#alamat_hapus').text(address);

			// Show modal
			$('#lokasiHapusModal').modal('show');
		}




		// Popup content
		function ToolTip(item) {
			var html = '';
			html += '<div class="ol-tooltip">' +
				'<img src="<?= base_url() ?>assets/icon-svg/icon-bank.svg">' +
				'<div class="info">' +
				'<div class="ol-tooltip-bank "> <a href="https://www.google.com/maps/place/' + item.Lat + ',' + item.Lon +
				'" target="_blank" class="text-wrap"> ' + item.Desc +
				' </a> </div>' +
				'<div class="ol-tooltip-alamat text-wrap">' + item.alamat + '</div>' +
				'<div class="ol-tooltip-tanggal text-wrap">' + item.tanggal_dibuat + '</div>' +
				'</div>' +
				'</div>';
			return html;
		}


		function ToolTip2(latitude, longitude) {
			var html = '';
			html += '<div class="ol-tooltip">' +
				'<img src="<?= base_url() ?>assets/icon-svg/icon-pencil.svg">' +
				'<div class="info">' +
				'<div class="ol-tooltip-bank "> <a href="#" class="text-wrap"> Tambah Lokasi Baru? </a> </div>' +
				'<div class="ol-tooltip-alamat text-wrap">Latitude : ' + latitude + '</div>' +
				'<div class="ol-tooltip-alamat text-wrap">Longitude ' + longitude + '</div>' +
				'</div>' +
				'</div>';
			return html;
		}

		var data =
			<?php echo json_encode($locations); ?>;

		function addPointGeom(data) {
			data.forEach(function(item) {

				var longitude = item.Lon,
					latitude = item.Lat,
					desc = item.Desc,
					alamat = item.alamat,
					tanggal_dibuat = item.tanggal_dibuat;

				var MarkerIcon = new ol.style.Icon({
					anchor: [0.5, 80],
					anchorXUnits: 'fraction',
					anchorYUnits: 'pixels',
					src: '<?= base_url() ?>assets/icon-svg/icon-location-pin.svg',
					scale: 0.5
				});

				var iconFeature = new ol.Feature({
						geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')),
						type: 'Point',
						desc: ToolTip(item),
						lon: longitude,
						lat: latitude
					}),
					iconStyle = new ol.style.Style({
						image: MarkerIcon
					});
				iconFeature.setStyle(iconStyle);
				straitSource.addFeature(iconFeature);
			});
		}

		addPointGeom(data);
		lastMarker = '';
		map.on('dblclick', function(evt) {
			var coordinatePretty = ol.coordinate.toStringHDMS(ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326'),
				2);
			var coordinate = ol.proj.toLonLat(evt.coordinate);
			$('#latitude').val(coordinate[1]);
			$('#longitude').val(coordinate[0]);

			var latitude = coordinate[1],
				longitude = coordinate[0];
			if (lastMarker) {
				straitSource.removeFeature(lastMarker);
			}

			var iconFeature = new ol.Feature({
					geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')),
					// geometry: new ol.geom.Point(evt.coordinate),
					type: 'Point',
					name: 'Point Baru',
					desc: ToolTip2(latitude, longitude),
					lon: longitude,
					lat: latitude
				}),
				iconStyle = new ol.style.Style({
					image: new ol.style.Icon({
						anchor: [0.5, 80],
						anchorXUnits: 'fraction',
						anchorYUnits: 'pixels',
						opacity: 0.75,
						src: '<?= base_url() ?>assets/icon-svg/icon-location-pin.svg',
						scale: 0.5
					})
				});
			iconFeature.setStyle(iconStyle);

			// Add to source
			straitSource.addFeature(iconFeature);
			// MapSource.addFeature(f);
			lastMarker = iconFeature;
			// Animate marker position
			AnimatePoint(iconFeature);


		});
	</script>
