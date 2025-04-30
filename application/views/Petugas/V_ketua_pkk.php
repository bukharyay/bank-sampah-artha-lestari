<div class="main-panel">
	<div class="content-wrapper">


		<?php if ( $this->session->flashdata ( 'success' ) ) : ?>
			<div class="alert alert-success"><?= $this->session->flashdata ( 'success' ) ?></div>
		<?php endif; ?>
		<?php if ( $this->session->flashdata ( 'error' ) ) : ?>
			<div class="alert alert-danger"><?= $this->session->flashdata ( 'error' ) ?></div>
		<?php endif; ?>

		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Set Ketua PKK RT <?= $rt->rt . ' / RW ' . $rt->rw ?> </h4>
				<?php if ( $current_ketua ) : ?>
					<div class="alert alert-info text-dark" ">
							Ketua PKK saat ini: <strong><?= $current_ketua->nama ?></strong>
						</div>
				<?php else : ?>
						<div class=" alert alert-warning">Belum ada ketua PKK untuk RT ini</div>
				<?php endif; ?>

				<form id="formSetKetua" class="was-validated" method="post"
							action="<?= site_url ( 'Set-Ketua-PKK/' . $rt->id_rt ) ?>">
					<div class="form-group">
						<label>Pilih Nasabah sebagai Ketua PKK</label>
						<select name="id_nasabah" class="form-control" required>
							<option value="">-- Pilih Nasabah --</option>
							<?php foreach ( $nasabah_list as $nasabah ) : ?>
								<option value="<?= $nasabah->id_nasabah ?>" <?= ( $current_ketua && $current_ketua->id_nasabah == $nasabah->id_nasabah ) ? 'selected' : '' ?>>
									<?= $nasabah->nama ?> - <?= $nasabah->alamat ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<a href="<?= site_url ( 'Manage-Area' ) ?>" class="btn btn-dark"> <i class="mdi mdi-arrow-left align-middle"></i>
						Kembali</a>
					<button type="submit" class="btn btn-primary btn-submit">
						<i class="mdi mdi-content-save align-middle"></i> Simpan
					</button>
				</form>
			</div>
		</div>
	</div>

	<script>
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

		// Form Handlers
		const handleFormSubmit = (e, confirmOptions) => {
			e.preventDefault();
			const form = $(e.target);

			showConfirmation(confirmOptions).then((result) => {
				if (result.isConfirmed) {
					handleAjaxSubmit(form.attr('action'), form.serialize());
				}
			});
		};

		const validateInput = (input) => {
			const value = input.value.trim();
			const inputType = input.type;
			const inputName = input.name;

			if (input.hasAttribute('required') && !value) {
				return 'Field ini harus diisi';
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

		$('form').on('input change', function () {
			let isValid = true;
			$(this).find('input, select').each(function () {
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
		});

		$('#formSetKetua').on('submit', (e) => handleFormSubmit(e, {
			title: 'Konfirmasi',
			text: 'Anda yakin ingin melanjutkan?'
		}));
	</script>