<div class="main-panel">
	<div class="content-wrapper">

		<div class="row my-3 justify-content-start">
			<div class="col-12 col-md-6 col-lg-6 grid-margin grid-margin-md-0 stretch-card">
				<div class="card">
					<div class="card-body text-center">
						<h4 class="card-title text-start">Profile Nasabah</h4>
						<div class="row ">
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
							</div>
						</div>
						<?php $CI = &get_instance(); ?>
						<div>
							<img src="<?= base_url('assets/profile/avatars/') . $this->user_session->avatar ?>" class="img-lg rounded-circle mb-2" alt="profile image">
							<h4><?= $this->user_session->nama ?></h4>
							<p class="text-muted mb-0"><?= $this->user_session->role ?></p>
						</div>
						<p class="mt-2 card-text">
							<?= $this->user_session->alamat ?>
						</p>
						<button class="btn btn-info btn-sm mt-3 mb-4 btn-edit-nasabah"><i class="mdi mdi-edit align-middle"></i>
							Update Profile?</button>
					</div>
				</div>
			</div>
		</div>

	</div>


	<div class="modal fade" id="nasabahEditModal" tabindex="-1" aria-labelledby="nasabahEditModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-warning" id="nasabahEditModalLabel">Edit Pengguna <i class="ti-pencil text-warning"></i></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="forms-sample" id="formEditNasabah" action="
                <?= base_url('Update-Profile/') . $this->user_session->id_user ?>" method="POST" enctype="multipart/form-data">
						<input type="text" name="id_user" value="<?= $this->user_session->id_user ?>" hidden>

						<div class="row justify-content-center align-items-center w-auto mx-auto ">
							<div class="col-12 col-sm-12 col-md-10 col-lg-6">
								<script type="text/javascript">
									function displaySelectedImage(event, elementId) {
										const selectedImage = document.getElementById(elementId);
										const fileInput = event.target;

										if (fileInput.files && fileInput.files[0]) {
											const reader = new FileReader();

											reader.onload = function(e) {
												selectedImage.src = e.target.result;
											};

											reader.readAsDataURL(fileInput.files[0]);
										}
									}
								</script>

								<div class="text-center mb-3">
									<div class="d-flex justify-content-center ">
										<img id="selectedAvatar<?= $this->user_session->id_user ?>" src="<?= base_url('assets/profile/avatars/' . ($this->user_session->avatar ?? 'default.png')) ?>" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;" alt="example placeholder" />
									</div>
									<?php if ($this->user_session->role == 'nasabah') : ?>
										<div class="d-flex justify-content-center mt-4">
											<div class="btn btn-sm btn-primary btn-rounded">
												<label class="form-label text-white m-1" for="avatar<?= $this->user_session->id_user ?>">Ganti
													Foto</label>
												<input type="file" class="form-control d-none" id="avatar<?= $this->user_session->id_user ?>" name="avatar" onchange="displaySelectedImage(event, 'selectedAvatar<?= $this->user_session->id_user ?>')" />
											</div>
										</div>
										<small class="text-small">Max 2mb</small>
									<?php endif; ?>
								</div>
							</div>
							<?php $CI = &get_instance(); ?>

							<div class="col-12 col-sm-12 col-md-10 col-lg-6">
								<div class="form-group">
									<label for="dibuat"><?= !empty($this->user_session->role) ? ucfirst($this->user_session->role) : '' ?>
										terdaftar sejak
									</label>
									<input type="text" class="form-control" id="dibuat<?= $this->user_session->id_user ?>" value="<?= $this->user_session->role == 'nasabah' ? $CI->format_waktu($this->user_session->nasabah_created_at) : $CI->format_waktu($this->user_session->user_created_at) ?>" placeholder="" readonly>
								</div>
								<div class="form-group">
									<label for="diupdate"><?= !empty($this->user_session->role) ? ucfirst($this->user_session->role) : '' ?>
										update terakhir
									</label>
									<input type="text" class="form-control" id="diupdate<?= $this->user_session->id_user ?>" value="<?= $this->user_session->role == 'nasabah' ? $CI->format_waktu($this->user_session->nasabah_updated_at) : $CI->format_waktu($this->user_session->user_updated_at) ?>" placeholder="" readonly>
								</div>
								<div class="form-group <?= form_error('role') ? 'has-danger' : '' ?>">
									<label for="role">Role</label>
									<select class="form-control form-select" id="role<?= $this->user_session->id_user ?>" name="role" readonly>
										<option value="petugas" <?= $this->user_session->role == 'petugas' ? 'selected' : 'disabled' ?>>
											Petugas
										</option>
										<option value="nasabah" <?= $this->user_session->role == 'nasabah' ? 'selected' : 'disabled' ?>>
											Nasabah
										</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row justify-content-center w-auto mx-auto">

							<div class="col-12 col-sm-12 col-md-10 col-lg-6">
								<div class="form-group <?= form_error('username') ? 'has-danger' : '' ?>  ">
									<label for="username">Username</label>
									<input type="text" class="form-control" id="username<?= $this->user_session->id_user ?>" name="username" value="<?= $this->user_session->username ?>" placeholder="Username" required>
									<?= form_error('username', '<label class="error mt-2 text-danger">', '</label>'); ?>
								</div>

								<div class="form-group <?= form_error('email') ? 'has-danger' : '' ?>">
									<label for="email">Email address</label>
									<input type="email" class="form-control" id="email<?= $this->user_session->id_user ?>" name="email" value="<?= $this->user_session->email ?>" placeholder="Email" required>
									<?= form_error('email', '<label class="error mt-2 text-danger">', '</label>'); ?>

								</div>

								<?php if ($this->user_session->role == 'nasabah') : ?>
									<div class="form-group <?= form_error('password') ? 'has-danger' : '' ?>">
										<label for="password">Password</label>
										<input type="password" class="form-control" id="password<?= $this->user_session->id_user ?>" name="password" value="" placeholder="Password" autocomplete="on">
										<?= form_error('password', '<label class="error mt-2 text-danger">', '</label>'); ?>

									</div>

									<div class="form-group <?= form_error('password_confirmation') ? 'has-danger' : '' ?>">
										<label for="password_confirmation">Confirm Password</label>
										<input type="password" class="form-control " id="password_confirmation<?= $this->user_session->id_user ?>" name="password_confirmation" value="" placeholder="Confirm Password" autocomplete="on">
										<?= form_error('password_confirmation', '<label class="error mt-2 text-danger">', '</label>'); ?>
									</div>

								<?php endif; ?>

							</div>
							<div class="col-12 col-sm-12 col-md-10 col-lg-6">
								<?php if ($this->user_session->role == 'nasabah') : ?>

									<div class="form-group <?= form_error('id_rt') ? 'has-danger' : '' ?>">
										<label for="id_rt">RW / RT</label>
										<select class="form-control form-select" id="id_rt<?= $this->user_session->id_user ?>" name="id_rt" readonly>
											<option value="">Pilih RT/RW</option>
											<?php foreach ($rt_list as $rt) : ?>
												<option value="<?= $rt->id_rt ?>" <?= $rt->id_rt == $this->user_session->id_rt ? 'selected' : 'disabled' ?>>
													<?= "RW {$rt->rw} / RT {$rt->rt}" ?>
												</option>
											<?php endforeach; ?>
										</select>
										<?= form_error('id_rt', '<label class="error mt-2 text-danger">', '</label>'); ?>
									</div>

									<div class="form-group <?= form_error('nama') ? 'has-danger' : '' ?>">
										<label for="nama">Nama Lengkap : </label>
										<input type="text" class="form-control" id="nama<?= $this->user_session->id_user ?>" name="nama" value="<?= $this->user_session->nama ?? $this->user_session->nama ?>" placeholder="Nama Lengkap" required>
										<?= form_error('nama', '<label class="error mt-2 text-danger">', '</label>'); ?>
									</div>

									<div class="form-group <?= form_error('no_telfon') ? 'has-danger' : '' ?>">
										<label for="no_telfon">No Telfon <small>(optional)</small></label>
										<input type="number" class="form-control" id="no_telfon<?= $this->user_session->id_user ?>" name="no_telfon" value="<?= $this->user_session->no_telfon ?? $this->user_session->no_telfon ?>" placeholder="No Telfon">
										<?= form_error('no_telfon', '<label class="error mt-2 text-danger">', '</label>'); ?>
									</div>

									<div class="form-group">
										<label for="alamat">Alamat <small>(optional)</small></label>
										<textarea class="form-control h-50" rows="5" name="alamat" id="alamat<?= $this->user_session->id_user ?>"><?= $this->user_session->alamat ?? $this->user_session->alamat ?></textarea>
									</div>
								<?php else : ?>
									<div class="form-group <?= form_error('password') ? 'has-danger' : '' ?>">
										<label for="password">Password</label>
										<input type="password" class="form-control" id="password<?= $this->user_session->id_user ?>" name="password" value="" placeholder="Password" autocomplete="on">
										<?= form_error('password', '<label class="error mt-2 text-danger">', '</label>'); ?>

									</div>

									<div class="form-group <?= form_error('password_confirmation') ? 'has-danger' : '' ?>">
										<label for="password_confirmation">Confirm Password</label>
										<input type="password" class="form-control " id="password_confirmation<?= $this->user_session->id_user ?>" name="password_confirmation" value="" placeholder="Confirm Password" autocomplete="on">
										<?= form_error('password_confirmation', '<label class="error mt-2 text-danger">', '</label>'); ?>
									</div>
								<?php endif; ?>

							</div>
						</div>
				</div>
				<div class="modal-footer justify-content-center">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-warning"><i class="ti-pencil text-white"></i> Edit </button>
				</div>
				</form>
			</div>
		</div>
	</div>



	<script type="text/javascript">
		$(document).on('click', '.btn-edit-nasabah', function() {
			// Show the modal
			$('#nasabahEditModal').modal('show');
		});
	</script>
