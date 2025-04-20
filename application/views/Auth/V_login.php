<div class="container-scroller">
	<div class="container-fluid page-body-wrapper full-page-wrapper">
		<div class="content-wrapper d-flex align-items-center auth px-0">
			<div class="row w-100 mx-0">
				<div class="col-12 col-sm-12 col-md-10 col-lg-6 mx-auto">
					<div class="card text-left p-5 border-rounded">

						<div class="brand-logo">
							<!-- <img src="../../../../images/logo.svg" alt="logo"> -->
						</div>
						<h3 class=" text-center">Selamat datang di Portal</h3>
						<h2 class="fw-bold text-center">BANK SAMPAH ARTHA LESTARI!</h2>

						<form class="pt-3" method="POST" action="<?= base_url('Auth-Login'); ?>">

							<div class="form-group">
								<label for="username">Username</label>
								<div class="input-group">
									<div class="input-group-prepend bg-transparent">
										<span class="input-group-text bg-transparent border-right-0">
											<i class="ti-user text-dark"></i>
										</span>
									</div>
									<input type="text" class="form-control form-control-lg border-left-0 <?= form_error('username') ? 'is-invalid' : ''; ?>" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>" required>
									<div class="invalid-feedback">
										<?= form_error('username'); ?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<div class="input-group">
									<div class="input-group-prepend bg-transparent">
										<span class="input-group-text bg-transparent border-right-0">
											<i class="ti-lock text-dark"></i>
										</span>
									</div>
									<input type="password" class="form-control form-control-lg border-left-0 <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password">
									<div class="invalid-feedback">
										<?= form_error('password'); ?>
									</div>
								</div>
							</div>
							<div class="my-2 d-flex justify-content-center">
							</div>
							<div class="mb-2 d-flex flex-wrap justify-content-center">
								<button type="button" onclick="location.href='<?= base_url(''); ?>'" value="Kembali" class="btn  btn-secondary  fw-bolder fs-6 mx-auto my-2 order-3 order-md-1 ">
									<i class=" mdi mdi-arrow-left align-middle align-middle m-0 p-1 fw-bolder fs-6"></i>
									Kembali
								</button>
								<button type="button" onclick="location.href='<?= base_url('Auth-Register'); ?>'" value="Go to Register" class="btn btn-dark auth-form-btn fw-bolder fs-6 mx-auto my-2 order-2 order-md-2">
									Daftar
									<i class=" icon-logout align-middle m-0 p-1 fw-bolder fs-6"></i>
								</button>
								<button type="submit" class="btn btn-primary auth-form-btn fw-bolder fs-6 mx-auto my-2 order-1 order-md-3">
									Login
									<i class="icon-login align-middle m-0 p-1 fw-bolder fs-6"></i>
								</button>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
		<!-- content-wrapper ends -->
	</div>
	<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
