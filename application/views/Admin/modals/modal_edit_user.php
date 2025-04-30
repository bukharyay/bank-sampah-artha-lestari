<?php foreach ( $data_users as $us ) : ?>
	<?php if ( $us->role !== 'admin' ) : ?>
		<div class="modal fade" id="userEdit<?= $us->id_user ?>" tabindex="-1"
				 aria-labelledby="userEdit<?= $us->id_user ?>Label" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-warning" id="userEdit<?= $us->id_user ?>Label">Edit Pengguna <i
								 class="ti-pencil text-warning"></i></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="forms-sample" id="userEdit<?= $us->id_user ?>"
									action="<?= base_url ( 'Edit-Users/' ) . $us->id_user ?>" method="POST" enctype="multipart/form-data">
							<input type="text" name="id_user" value="<?= $us->id_user ?>" hidden>

							<div class="row justify-content-center align-items-center w-auto mx-auto ">
								<div class="col-12 col-sm-12 col-md-10 col-lg-6">
									<script type="text/javascript">
										function displaySelectedImage(event, elementId) {
											const selectedImage = document.getElementById(elementId);
											const fileInput = event.target;

											if (fileInput.files && fileInput.files[0]) {
												const reader = new FileReader();

												reader.onload = function (e) {
													selectedImage.src = e.target.result;
												};

												reader.readAsDataURL(fileInput.files[0]);
											}
										}
									</script>

									<div class="text-center mb-3">
										<div class="d-flex justify-content-center ">
											<img id="selectedAvatar<?= $us->id_user ?>"
													 src="<?= base_url ( 'assets/profile/avatars/' . ( $us->avatar ?? 'default.png' ) ) ?>"
													 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;"
													 alt="example placeholder" />
										</div>
										<?php if ( $us->role == 'nasabah' ) : ?>
											<div class="d-flex justify-content-center mt-4">
												<div class="btn btn-sm btn-primary btn-rounded">
													<label class="form-label text-white m-1" for="avatar<?= $us->id_user ?>">Ganti Foto</label>
													<input type="file" class="form-control d-none" id="avatar<?= $us->id_user ?>" name="avatar"
																 onchange="displaySelectedImage(event, 'selectedAvatar<?= $us->id_user ?>')" />
												</div>
											</div>
											<small class="text-small">Max 2mb</small>
										<?php endif; ?>
									</div>
								</div>
								<?php $CI = &get_instance (); ?>

								<div class="col-12 col-sm-12 col-md-10 col-lg-6">
									<div class="form-group">
										<label for=" dibuat"><?= ! empty ( $us->role ) ? ucfirst ( $us->role ) : '' ?> terdaftar sejak </label>
										<input type="text" class="form-control" id="dibuat<?= $us->id_user ?>"
													 value="<?= $us->role == 'nasabah' ? $CI->format_waktu ( $us->nasabah_created_at ?? '' ) : $CI->format_waktu ( $us->user_created_at ?? '' ) ?>"
													 placeholder="" readonly>
									</div>
									<div class="form-group">
										<label for=" dibuat"><?= ! empty ( $us->role ) ? ucfirst ( $us->role ) : '' ?> update terakhir </label>
										<input type="text" class="form-control" id="diupdate<?= $us->id_user ?>"
													 value="<?= $us->role == 'nasabah' ? $CI->format_waktu ( $us->nasabah_updated_at ?? '' ) : $CI->format_waktu ( $us->user_updated_at ?? '' ) ?>"
													 placeholder="" readonly>
									</div>
									<div class="form-group <?= form_error ( 'role' ) ? 'has-danger' : '' ?>">
										<label for="role">Role</label>
										<select class="form-control form-select" id="role<?= $us->id_user ?>" name="role" readonly>
											<option value="petugas" <?= $us->role == 'petugas' ? 'selected' : 'disabled' ?>>Petugas</option>
											<option value="nasabah" <?= $us->role == 'nasabah' ? 'selected' : 'disabled' ?>>Nasabah</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row justify-content-center w-auto mx-auto">

								<div class="col-12 col-sm-12 col-md-10 col-lg-6">
									<div class="form-group <?= form_error ( 'username' ) ? 'has-danger' : '' ?>	">
										<label for="username">Username</label>
										<input type="text" class="form-control" id="username<?= $us->id_user ?>" name="username"
													 value="<?= $us->username ?>" placeholder="Username" required>
										<?= form_error ( 'username', '<label class="error mt-2 text-danger">', '</label>' ); ?>
									</div>

									<div class="form-group <?= form_error ( 'email' ) ? 'has-danger' : '' ?>">
										<label for="email">Email address</label>
										<input type="email" class="form-control" id="email<?= $us->id_user ?>" name="email"
													 value="<?= $us->email ?>" placeholder="Email" required>
										<?= form_error ( 'email', '<label class="error mt-2 text-danger">', '</label>' ); ?>

									</div>

									<?php if ( $us->role == 'nasabah' ) : ?>
										<div class="form-group <?= form_error ( 'password' ) ? 'has-danger' : '' ?>">
											<label for="password">Password</label>
											<input type="password" class="form-control" id="password<?= $us->id_user ?>" name="password" value=""
														 placeholder="Password" autocomplete="on">
											<?= form_error ( 'password', '<label class="error mt-2 text-danger">', '</label>' ); ?>

										</div>

										<div class="form-group <?= form_error ( 'password_confirmation' ) ? 'has-danger' : '' ?>">
											<label for="password_confirmation">Confirm Password</label>
											<input type="password" class="form-control " id="password_confirmation<?= $us->id_user ?>"
														 name="password_confirmation" value="" placeholder="Confirm Password" autocomplete="on">
											<?= form_error ( 'password_confirmation', '<label class="error mt-2 text-danger">', '</label>' ); ?>
										</div>

									<?php endif; ?>

								</div>
								<div class="col-12 col-sm-12 col-md-10 col-lg-6">
									<?php if ( $us->role == 'nasabah' ) : ?>

										<div class="form-group <?= form_error ( 'id_rt' ) ? 'has-danger' : '' ?>">
											<label for="id_rt">RW / RT</label>
											<select class="form-control form-select" id="id_rt<?= $us->id_user ?>" name="id_rt">
												<option value="">Pilih RT/RW</option>
												<?php foreach ( $rt_list as $rt ) : ?>
													<option value="<?= $rt->id_rt ?>" <?= $rt->id_rt == $us->id_rt ? 'selected' : '' ?>>
														<?= "RW {$rt->rw} / RT {$rt->rt}" ?>
													</option>
												<?php endforeach; ?>
											</select>
											<?= form_error ( 'id_rt', '<label class="error mt-2 text-danger">', '</label>' ); ?>
										</div>

										<div class="form-group <?= form_error ( 'nama' ) ? 'has-danger' : '' ?>">
											<label for="nama">Nama Lengkap : </label>
											<input type="text" class="form-control" id="nama<?= $us->id_user ?>" name="nama"
														 value="<?= $us->nama ?? $us->nama ?>" placeholder="Nama Lengkap" required>
											<?= form_error ( 'nama', '<label class="error mt-2 text-danger">', '</label>' ); ?>
										</div>

										<div class="form-group <?= form_error ( 'no_telfon' ) ? 'has-danger' : '' ?>">
											<label for="no_telfon">No Telfon <small>(optional)</small></label>
											<input type="number" class="form-control" id="no_telfon<?= $us->id_user ?>" name="no_telfon"
														 value="<?= $us->no_telfon ?? $us->no_telfon ?>" placeholder="No Telfon">
											<?= form_error ( 'no_telfon', '<label class="error mt-2 text-danger">', '</label>' ); ?>
										</div>

										<div class="form-group">
											<label for="alamat">Alamat <small>(optional)</small></label>
											<textarea class="form-control h-50" rows="5" name="alamat"
																id="alamat<?= $us->id_user ?>"><?= $us->alamat ?? $us->alamat ?></textarea>
										</div>
									<?php else : ?>
										<div class="form-group <?= form_error ( 'password' ) ? 'has-danger' : '' ?>">
											<label for="password">Password</label>
											<input type="password" class="form-control" id="password<?= $us->id_user ?>" name="password" value=""
														 placeholder="Password" autocomplete="on">
											<?= form_error ( 'password', '<label class="error mt-2 text-danger">', '</label>' ); ?>

										</div>

										<div class="form-group <?= form_error ( 'password_confirmation' ) ? 'has-danger' : '' ?>">
											<label for="password_confirmation">Confirm Password</label>
											<input type="password" class="form-control " id="password_confirmation<?= $us->id_user ?>"
														 name="password_confirmation" value="" placeholder="Confirm Password" autocomplete="on">
											<?= form_error ( 'password_confirmation', '<label class="error mt-2 text-danger">', '</label>' ); ?>
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
	<?php endif; ?>
<?php endforeach; ?>