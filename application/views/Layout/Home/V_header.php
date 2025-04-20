<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>BSAL | Bank Sampah Artha Lestari</title>

	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/images/bsal.ico">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/images/bsal.ico">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/bsal.ico">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/images/bsal.ico">
	<link rel="manifest" href="<?= base_url() ?>assets/images/bsal.ico">
	<meta name="msapplication-TileImage" content="<?= base_url() ?>assets/images/bsal.ico">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="<?= base_url() ?>assets/vendors/mdi/css/materialdesignicons.min.css">

	<link href="<?= base_url() ?>assets/landing/css/theme.css" rel="stylesheet" />
	<link href="<?= base_url() ?>assets/css/map.css" rel="stylesheet" />

	<script src="https://cdn.jsdelivr.net/npm/ol@v9.2.4/dist/ol.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.2.4/ol.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>


<body>
	<style>
		.small {
			font-size: 80% !important;
		}

		.icon {
			text-align: center;
			vertical-align: middle;
			line-height: 1;
			border-radius: 3px;
			display: inline-block;
			-webkit-transition: all .2s;
			transition: all .2s;
		}

		.icon-sm {
			width: 20px;
			height: 20px;
			font-size: 15px;
			line-height: 20px;
		}

		.icon-md {
			width: 30px;
			height: 30px;
			font-size: 24px;
			line-height: 30px;
		}

		.icon-lg {
			width: 50px;
			height: 50px;
			font-size: 32px;
			line-height: 50px;
		}
	</style>

	<main class="main" id="top">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" data-navbar-on-scroll="data-navbar-on-scroll" style="background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
			<div class="container">
				<!-- Logo with responsive sizing -->
				<a class="navbar-brand d-flex align-items-center" href="#">
					<img src="<?= base_url() ?>assets/images/logo.webp" alt="Bank Sampah Artha Lestari" style="height: 50px; width: auto; max-width: 120px;" class="d-inline-block align-top">
				</a>

				<!-- Mobile toggle button -->
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<?php $CI          = &get_instance();
				$active_link = $CI->uri->segment(1);
				?>

				<!-- Navbar content -->
				<div class="collapse navbar-collapse" id="navbarContent">
					<ul class="ms-auto navbar-nav ml-auto mt-2 mt-lg-0 align-items-center">
						<li class="nav-item ">
							<a class="nav-link  <?= $active_link == 'Home' || $active_link == null ? 'font-weight-bold active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link <?= $active_link == 'artikel' ? 'font-weight-bold active' : '' ?>" href="<?= base_url('artikel/semua') ?>">Hasil Karya</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link <?= $active_link == 'Struktur-Organisasi' ? 'font-weight-bold active' : '' ?>" href="<?= base_url('Struktur-Organisasi') ?>">Struktur Organisasi</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link <?= $active_link == 'Wilayah-Kerja' ? 'font-weight-bold active' : '' ?>" href="<?= base_url('Wilayah-Kerja') ?>">Wilayah</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link <?= $active_link == 'Tentang-Kami' ? 'font-weight-bold active' : '' ?>" href="<?= base_url('Tentang-Kami') ?>">Tentang kami</a>
						</li>
						<li class="nav-item ml-lg-2 mt-2 mt-lg-0">
							<a class="<?= $login != 'Auth-Login' ? 'btn btn-outline-primary btn-sm' : 'nav-link' ?>" href="<?= site_url($login) ?>">
								<?= $login != 'Auth-Login' ? 'Dashboard' : 'Masuk' ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
