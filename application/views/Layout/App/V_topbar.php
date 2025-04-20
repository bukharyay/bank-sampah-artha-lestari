<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 px-3 px-md-0 px-lg-0  fixed-top d-flex align-items-end align-items-lg-start flex-row justify-content-center">
	<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start ">
		<div class="me-3">
			<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
				<span class="icon-menu"></span>
			</button>
		</div>
		<div>
			<a class="navbar-brand brand-logo" href="<?= base_url(); ?>">
				<img src="<?= base_url() ?>assets/images/logo.webp" class="img-fluid p-3" style="height: auto !important;" alt="logo" />
			</a><br>
			<a class="navbar-brand brand-logo-mini" href="<?= base_url(); ?>">
				<img src="<?= base_url() ?>assets/images/logo-mini.png" alt="logo" />
			</a>
		</div>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-center ">
		<ul class="navbar-nav">
			<li class="nav-item font-weight-semibold d-none d-sm-block d-lg-block ms-0">
				<h1 class="welcome-text"><?= $greeting ?? 'Selamat Datang' ?>, <span class="text-black fw-bold"><?= $this->session->userdata('name') ?></span></h1>
				<h3 class="welcome-sub-text"> Bank Sampah Artha Lestari
				</h3>
			</li>
		</ul>

		<ul class="navbar-nav ms-auto">
			<!-- Notifikasi Dropdown -->
			<li class="nav-item dropdown">
				<a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
					<i class="icon-bell icon-lg"></i>
					<span class="count bg-danger" id="notificationCount">0</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
					<a class="dropdown-item py-3 border-bottom">
						<p class="mb-0 font-weight-medium float-left">Notifikasi Terbaru</p>
						<span class="badge badge-pill badge-primary float-right" id="markAllAsRead">Tandai semua dibaca</span>
					</a>
					<div id="notificationList">
						<!-- Notifikasi akan dimuat di sini via AJAX -->
						<div class="text-center py-3">
							<div class="spinner-border text-primary" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>
					<div class="dropdown-divider"></div>
					<a href="<?= site_url('Notifikasi') ?>" class="dropdown-item py-3 text-center">
						Lihat Semua Notifikasi
					</a>
				</div>
			</li>
			<li class="nav-item dropdown d-none d-sm-block d-lg-block user-dropdown">
				<a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
					<img class="img-xs rounded-circle" src="<?= base_url() ?>assets/profile/avatars/<?= $this->user_session->avatar ?? 'default.png' ?>" alt="Profile image"> </a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
					<div class="dropdown-header text-center">
						<img class="img-sm rounded-circle" src="<?= base_url() ?>assets/profile/avatars/<?= $this->user_session->avatar ?? 'default.png' ?>" alt="Profile image">
						<p class="mb-1 mt-3 font-weight-semibold"><?= $this->user_session->nama ?? $this->user_session->username ?>
						</p>
						<p class="fw-light text-muted mb-0"><?= $this->user_session->email ?? '' ?></p>
					</div>
					<?php if ($this->user_session->role == 'nasabah') : ?>
						<a href="<?= base_url('Profile-Nasabah') ?>" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My
							Profile </a>
					<?php endif; ?>
					<a class="dropdown-item" href="<?= base_url('Auth-Logout') ?>"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Log Out</a>
				</div>
			</li>
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
			<span class="mdi mdi-menu"></span>
		</button>
	</div>
</nav>
<!-- partial -->

<div class="container-fluid page-body-wrapper">

	<!-- partial:partials/_settings-panel.html -->
	<div class="theme-setting-wrapper">
		<div id="settings-trigger"><i class="ti-settings"></i></div>
		<div id="theme-settings" class="settings-panel">
			<i class="settings-close ti-close"></i>
			<p class="settings-heading">SIDEBAR SKINS</p>
			<div class="sidebar-bg-options selected" id="sidebar-light-theme">
				<div class="img-ss rounded-circle bg-light border me-3"></div>Light
			</div>
			<div class="sidebar-bg-options" id="sidebar-dark-theme">
				<div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
			</div>
			<p class="settings-heading mt-2">HEADER SKINS</p>
			<div class="color-tiles mx-0 px-4">
				<div class="tiles success"></div>
				<div class="tiles warning"></div>
				<div class="tiles danger"></div>
				<div class="tiles info"></div>
				<div class="tiles dark"></div>
				<div class="tiles default"></div>
			</div>
		</div>
	</div>
	<!-- partial -->
