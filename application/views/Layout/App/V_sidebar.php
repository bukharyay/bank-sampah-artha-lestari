<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item nav-category">Halaman Utama</li>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url(''); ?>">
				<i class="mdi mdi-home menu-icon"></i>
				<span class="menu-title">Landing Page</span>
			</a>
		</li>
		<?php if ($this->session->userdata('role') === 'admin') : ?>
			<li class="nav-item nav-category">Admin</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Dashboard-Admin'); ?>">
					<i class="mdi mdi-view-dashboard menu-icon"></i>
					<span class="menu-title">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Manage-Users'); ?>">
					<i class="mdi mdi-account-group menu-icon"></i>
					<span class="menu-title">Data Semua Pengguna</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Manage-Area'); ?>">
					<i class="mdi mdi-home-group menu-icon"></i>
					<span class="menu-title">Area RW/RT</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'petugas') : ?>
			<li class="nav-item nav-category">Petugas</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Manage-Transaksi'); ?>">
					<i class="mdi mdi-cash-register menu-icon"></i>
					<span class="menu-title">Transaksi</span>
					<?php $count = count_transaksi_diterima(); ?>
					<?php if ($count > 0) : ?>
						<span class="badge badge-pill badge-primary"><?= $count ?></span>
					<?php endif; ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Manage-Nasabah'); ?>">
					<i class="mdi mdi-account-details menu-icon"></i>
					<span class="menu-title">Data Nasabah</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Manage-Jenis-Sampah'); ?>">
					<i class="mdi mdi-recycle menu-icon"></i>
					<span class="menu-title">Jenis Sampah</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Manage-Sampah'); ?>">
					<i class="mdi mdi-trash-can menu-icon"></i>
					<span class="menu-title">Kelola Sampah</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Laporan-Transaksi'); ?>">
					<i class="mdi mdi-file-chart menu-icon"></i>
					<span class="menu-title">Laporan</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Hasil-Karya'); ?>">
					<i class="mdi mdi-palette menu-icon"></i>
					<span class="menu-title">Hasil Karya</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Peta-Wilayah'); ?>">
					<i class="mdi mdi-map-marker-radius menu-icon"></i>
					<span class="menu-title">Peta & Wilayah Kerja</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($this->session->userdata('role') == 'nasabah') : ?>
			<li class="nav-item nav-category">Nasabah</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Dashboard-Nasabah'); ?>">
					<i class="mdi mdi-view-dashboard menu-icon"></i>
					<span class="menu-title">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Profile-Nasabah'); ?>">
					<i class="mdi mdi-account-circle menu-icon"></i>
					<span class="menu-title">Profile Nasabah</span>
				</a>
			</li>
			<?php if ($this->user_session->ketua_pkk == 1) : ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('Tarik-Tabungan-Nasabah'); ?>">
						<i class="mdi mdi-credit-card-multiple menu-icon"></i>
						<span class="menu-title">Tarik Tabungan</span>
					</a>
				</li>
			<?php endif; ?>
			<li class="nav-item">
				<a class="nav-link" href="<?= base_url('Riwayat-Transaksi-Nasabah'); ?>">
					<i class="mdi mdi-history menu-icon"></i>
					<span class="menu-title">Riwayat Transaksi</span>
				</a>
			</li>
		<?php endif; ?>

		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('Auth-Logout'); ?>">
				<i class="mdi mdi-power menu-icon"></i>
				<span class="menu-title">Log Out</span>
			</a>
		</li>
	</ul>
</nav>
<!-- partial -->
