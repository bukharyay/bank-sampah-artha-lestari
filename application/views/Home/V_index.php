<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Hero Section -->
<section class="pt-0 pb-8" id="beranda">
	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/dot.png);background-position:left;background-size:auto;margin-top:-105px;">
	</div>

	<div class="container position-relative">
		<div class="row align-items-center min-vh-75">
			<div class="col-md-5 col-lg-6 order-md-1 pt-8">
				<img class="img-fluid" src="<?= base_url() ?>assets/landing/img/illustrations/save-earth.png" alt="Bank Sampah Artha Lestari">
			</div>
			<div class="col-md-7 col-lg-6 text-center text-md-start pt-5 pt-md-9">
				<h1 class="mb-4 display-3 fw-bold">Bank Sampah <span class="text-primary">Artha Lestari</span></h1>
				<p class="mt-3 mb-4 fs-1">
					Transformasi sampah menjadi berkah untuk lingkungan RW 02 Padangsari yang lebih bersih dan sejahtera
				</p>
				<div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
					<a class="btn btn-lg btn-primary rounded-pill hover-top" href="#daftar" role="button">
						<i class="icon icon-md mdi mdi-account-plus me-2"></i>Daftar Sekarang
					</a>
					<a class="btn btn-lg btn-outline-primary rounded-pill hover-top" href="#layanan" role="button">
						<i class="icon icon-md mdi mdi-information-outline me-2"></i>Pelajari Lebih Lanjut
					</a>
				</div>

				<div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-4 mt-5">
					<div class="d-flex align-items-center">
						<div class="bg-soft-primary rounded-circle p-2 me-3">
							<i class="mdi mdi-recycle text-primary icon icon-md"></i>
						</div>
						<div>
							<h5 class="mb-0 fw-bold">27+</h5>
							<p class="mb-0 small">Jenis Sampah Diterima</p>
						</div>
					</div>
					<div class="d-flex align-items-center">
						<div class="bg-soft-primary rounded-circle p-2 me-3">
							<i class="mdi mdi-account-group text-primary icon icon-md"></i>
						</div>
						<div>
							<h5 class="mb-0 fw-bold">500+</h5>
							<p class="mb-0 small">Nasabah Aktif</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Services Section -->
<section class="py-6" id="layanan">
	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/services-bg.png);background-position:center left;background-size:auto;">
	</div>
	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/dot-2.png);background-position:center right;background-size:auto;margin-left:-180px;margin-top:20px;">
	</div>

	<div class="container-lg">
		<div class="row justify-content-center mb-6">
			<div class="col-12 col-md-8 text-center">
				<h2 class="display-5 fw-bold mb-3">Layanan Kami</h2>
				<p class="lead ">Kami memberikan solusi pengelolaan sampah terpadu untuk warga RW 02 Padangsari</p>
			</div>
		</div>

		<div class="row g-4">
			<div class="col-md-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0 hover-top">
					<div class="card-body p-4 text-center">
						<div class="bg-soft-primary rounded-circle p-3 d-inline-block mb-4">
							<i class="mdi mdi-trash-can-outline text-primary icon icon-lg"></i>
						</div>
						<h4 class="fw-bold mb-3">Penjemputan Sampah</h4>
						<p class="">Layanan penjemputan sampah terpilah langsung dari rumah warga sesuai jadwal</p>
						<a href="#" class="btn btn-link text-primary text-decoration-none mt-3">
							Pelajari lebih lanjut <i class="mdi mdi-arrow-right icon icon-sm"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0 hover-top">
					<div class="card-body p-4 text-center">
						<div class="bg-soft-primary rounded-circle p-3 d-inline-block mb-4">
							<i class="mdi mdi-cash-multiple text-primary icon icon-lg"></i>
						</div>
						<h4 class="fw-bold mb-3">Tabungan Sampah</h4>
						<p class="">Sistem tabungan yang mengkonversi sampah menjadi nilai ekonomis untuk nasabah</p>
						<a href="#" class="btn btn-link text-primary text-decoration-none mt-3">
							Pelajari lebih lanjut <i class="mdi mdi-arrow-right icon icon-sm"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0 hover-top">
					<div class="card-body p-4 text-center">
						<div class="bg-soft-primary rounded-circle p-3 d-inline-block mb-4">
							<i class="mdi mdi-school text-primary icon icon-lg"></i>
						</div>
						<h4 class="fw-bold mb-3">Edukasi Lingkungan</h4>
						<p class="">Program edukasi pengelolaan sampah untuk warga dan sekolah di wilayah RW 02</p>
						<a href="#" class="btn btn-link text-primary text-decoration-none mt-3">
							Pelajari lebih lanjut <i class="mdi mdi-arrow-right icon icon-sm"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0 hover-top">
					<div class="card-body p-4 text-center">
						<div class="bg-soft-primary rounded-circle p-3 d-inline-block mb-4">
							<i class="mdi mdi-package-variant text-primary icon icon-lg"></i>
						</div>
						<h4 class="fw-bold mb-3">Daur Ulang Kreatif</h4>
						<p class="">Kreasi produk bernilai dari sampah anorganik oleh kelompok PKK RW 02</p>
						<a href="#" class="btn btn-link text-primary text-decoration-none mt-3">
							Pelajari lebih lanjut <i class="mdi mdi-arrow-right icon icon-sm"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0 hover-top">
					<div class="card-body p-4 text-center">
						<div class="bg-soft-primary rounded-circle p-3 d-inline-block mb-4">
							<i class="mdi mdi-leaf text-primary icon icon-lg"></i>
						</div>
						<h4 class="fw-bold mb-3">Kompos Organik</h4>
						<p class="">Pengolahan sampah organik menjadi kompos untuk pertanian perkotaan</p>
						<a href="#" class="btn btn-link text-primary text-decoration-none mt-3">
							Pelajari lebih lanjut <i class="mdi mdi-arrow-right icon icon-sm"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0 hover-top">
					<div class="card-body p-4 text-center">
						<div class="bg-soft-primary rounded-circle p-3 d-inline-block mb-4">
							<i class="mdi mdi-trophy-outline text-primary icon icon-lg"></i>
						</div>
						<h4 class="fw-bold mb-3">Program Insentif</h4>
						<p class="">Reward untuk nasabah aktif dan RT dengan kinerja pengelolaan sampah terbaik</p>
						<a href="#" class="btn btn-link text-primary text-decoration-none mt-3">
							Pelajari lebih lanjut <i class="mdi mdi-arrow-right icon icon-sm"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Work Area Section -->
<section class="py-6 bg-light" id="wilayah">
	<div class="container">
		<div class="row justify-content-center mb-6">
			<div class="col-12 text-center">
				<h2 class="display-5 fw-bold mb-3">Wilayah Layanan</h2>
				<p class="lead  w-lg-50 mx-auto">Kami melayani seluruh warga RW 02 Kelurahan Padangsari, Kecamatan
					Banyumanik, Kota Semarang</p>
			</div>
		</div>

		<div class="row g-4">
			<div class="col-lg-6">
				<div class="card h-100 border-0 shadow-sm">
					<div class="card-body p-0">
						<div id="map" class="map" style="height: 400px;"></div>
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
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="card h-100 border-0 shadow-sm">
					<div class="card-body p-4">
						<h4 class="fw-bold mb-4">RT yang Kami Layani</h4>
						<div class="row">
							<?php
							$rt_list = ['RT 01', 'RT 02', 'RT 03', 'RT 04', 'RT 05', 'RT 06', 'RT 07', 'RT 08', 'RT 09'];
							foreach (array_chunk($rt_list, 3) as $chunk) : ?>
								<div class="col-md-4">
									<ul class="list-unstyled">
										<?php foreach ($chunk as $rt) : ?>
											<li class="mb-3 d-flex align-items-center">
												<i class="icon icon-sm mdi mdi-check-circle-outline text-primary me-2"></i>
												<span><?= $rt ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="mt-5">
							<h5 class="fw-bold mb-3">Jadwal Pengumpulan</h5>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead class="bg-primary text-white">
										<tr>
											<th>Hari</th>
											<th>RT</th>
											<th>Waktu</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Senin</td>
											<td>RT 01, 02, 03</td>
											<td>08.00-12.00</td>
										</tr>
										<tr>
											<td>Rabu</td>
											<td>RT 04, 05, 06</td>
											<td>08.00-12.00</td>
										</tr>
										<tr>
											<td>Jumat</td>
											<td>RT 07, 08, 09</td>
											<td>08.00-12.00</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<a href="<?= base_url('Wilayah-Kerja') ?>" class="btn btn-primary rounded-pill mt-4">
							<i class="mdi mdi-map-marker-outline icon icon-md "></i> Lihat Detail Wilayah
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- About Section -->
<section class="py-6" id="tentang">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 mb-5 mb-lg-0">
				<div class="pe-lg-5">
					<h2 class="fw-bold mb-4">Mengapa Memilih Bank Sampah Artha Lestari?</h2>
					<p class=" mb-4">Sebagai bank sampah terbaik di Kota Semarang, kami menawarkan sistem pengelolaan
						sampah yang terintegrasi dan menguntungkan bagi warga.</p>

					<div class="d-flex mb-4">
						<div class="p-3 bg-soft-primary rounded-circle me-3 align-self-stretch align-content-center">
							<i class="mdi mdi-shield-check text-primary icon icon-lg"></i>
						</div>
						<div>
							<h5 class="fw-bold mb-2">Terpercaya</h5>
							<p class=" mb-0">Juara 1 Lomba Bank Sampah Tingkat Kota Semarang dengan sistem pencatatan
								transparan</p>
						</div>
					</div>

					<div class="d-flex mb-4">
						<div class="p-3 bg-soft-primary rounded-circle me-3 align-self-stretch align-content-center">
							<i class="mdi mdi-cash-refund text-primary icon icon-lg"></i>
						</div>
						<div>
							<h5 class="fw-bold mb-2">Nilai Ekonomis</h5>
							<p class=" mb-0">100% hasil penjualan sampah dikembalikan ke nasabah setiap 6 bulan</p>
						</div>
					</div>

					<div class="d-flex">
						<div class="p-3 bg-soft-primary rounded-circle me-3 align-self-stretch align-content-center">
							<i class="mdi mdi-recycle text-primary icon icon-lg"></i>
						</div>
						<div>
							<h5 class="fw-bold mb-2">Ramah Lingkungan</h5>
							<p class=" mb-0">Menerima 27+ jenis sampah melalui kemitraan dengan Lingkar Hijau (mitra DLH
								Semarang)</p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="card border-0 shadow-sm overflow-hidden">
					<div class="card-body p-0">
						<img src="<?= base_url() ?>assets/landing/img/illustrations/family-recycling-together.svg" alt="Proses Pengolahan Sampah" class="img-fluid w-100">
						<div class="p-4">
							<div class="d-flex align-items-center mb-3">
								<div class="bg-primary text-white rounded-circle p-2 me-3">
									<i class="mdi mdi-trophy-variant icon icon-md"></i>
								</div>
								<h5 class="fw-bold mb-0">Prestasi Kami</h5>
							</div>
							<p class="">Bank Sampah Artha Lestari telah berkontribusi mengurangi 15 ton sampah per bulan di
								RW 02 Padangsari dan menjadi percontohan pengelolaan sampah berkelanjutan di Kota Semarang.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Testimonial Section -->
<section class="py-8 bg-light-gradient" id="testimonial">
	<div class="container">
		<div class="row justify-content-center mb-7">
			<div class="col-12 col-md-10 col-lg-8 text-center">
				<span class="badge bg-primary-soft mb-3">
					<span class="h6 text-uppercase">Testimonial</span>
				</span>
				<h2 class="display-5 fw-bold mb-3">Apa Kata Nasabah Kami</h2>
				<p class="lead text-muted">Pengalaman nyata warga RW 02 dengan Bank Sampah Artha Lestari</p>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-12 col-lg-10">
				<div class="carousel slide carousel-fade" id="testimonialCarousel" data-bs-ride="carousel">
					<div class="carousel-inner">
						<!-- Testimonial 1 -->
						<div class="carousel-item active">
							<div class="card border-0 shadow-lg overflow-hidden">
								<div class="card-body p-5">
									<div class="row align-items-center">
										<div class="col-md-4 text-center mb-4 mb-md-0">
											<div class="position-relative">
												<img src="<?= base_url() ?>assets/landing/img/gallery/default.png" class="rounded-circle border border-4 border-primary shadow-lg" width="160" alt="Nasabah">
												<div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 shadow-sm">
													<i class="mdi mdi-format-quote-close text-white icon icon-md"></i>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="mb-3 text-primary">
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
											</div>
											<blockquote class="fs-3 fw-light mb-4">"Sejak bergabung dengan Bank Sampah Artha Lestari,
												lingkungan rumah menjadi lebih bersih dan saya bisa mendapatkan tambahan penghasilan dari sampah
												yang dikumpulkan."</blockquote>
											<div class="d-flex align-items-center">
												<div class="ps-3 border-start border-3 border-primary">
													<h5 class="fw-bold mb-1 text-primary">Ibu Siti - RT 03</h5>
													<p class="small  mb-0">Nasabah sejak 2018</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Testimonial 2 -->
						<div class="carousel-item">
							<div class="card border-0 bg-primary text-white overflow-hidden">
								<div class="card-body p-5">
									<div class="row align-items-center">
										<div class="col-md-4 text-center mb-4 mb-md-0">
											<div class="position-relative">
												<img src="<?= base_url() ?>assets/landing/img/gallery/default.png" class="rounded-circle border border-4 border-warning shadow-lg" width="160" alt="Nasabah">
												<div class="position-absolute bottom-0 end-0 bg-warning rounded-circle p-2 shadow-sm">
													<i class="mdi mdi-format-quote-close text-primary icon icon-md  "></i>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="mb-3 text-warning">
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
												<i class="mdi mdi-star icon icon-md"></i>
											</div>
											<blockquote class="fs-3 fw-light mb-4">"Sistem pencatatan yang transparan dan pembayaran tepat
												waktu membuat saya percaya menyimpan sampah di Bank Sampah Artha Lestari."</blockquote>
											<div class="d-flex align-items-center">
												<div class="ps-3 border-start border-3 border-warning">
													<h5 class="fw-bold mb-1 text-warning">Bapak Budi - RT 05</h5>
													<p class="small text-white mb-0">Nasabah sejak 2019</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Controls -->
					<div class="row mt-5">
						<div class="col-12 text-center">
							<button class="btn btn-icon btn-primary rounded-circle p-2 me-3" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
								<i class="mdi mdi-chevron-left icon icon-md"></i>
							</button>

							<div class="d-inline-block mx-2">
								<ol class="carousel-indicators position-static mx-auto">
									<li class="active bg-primary" data-bs-target="#testimonialCarousel" data-bs-slide-to="0"></li>
									<li class="bg-primary" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></li>
								</ol>
							</div>

							<button class="btn btn-icon btn-primary rounded-circle p-2 ms-3" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
								<i class="mdi mdi-chevron-right icon icon-md"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Registration Section -->
<section class="pt-6 pb-4" id="daftar">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 text-center">
				<h2 class="display-5 fw-bold mb-4">Bergabunglah Dengan Kami</h2>
				<p class="lead  mb-5">Daftarkan diri Anda sebagai nasabah Bank Sampah Artha Lestari dan mulai
					berkontribusi untuk lingkungan yang lebih bersih</p>

				<div class="card shadow-sm border-0 overflow-hidden">
					<div class="card-body p-4 p-sm-5">
						<div class="row g-4">
							<div class="col-md-6">
								<div class="d-flex align-items-start">
									<div class="bg-soft-primary rounded-circle p-2 me-4">
										<i class="mdi mdi-account-check text-primary icon icon-md"></i>
									</div>
									<div>
										<h5 class="fw-bold mb-3 text-start">Syarat Pendaftaran</h5>
										<ul class="list-unstyled text-start">
											<li class="mb-2 d-flex align-items-start ">
												<i class="icon icon-sm mdi mdi-check-circle-outline text-primary me-2 mt-1"></i>
												<span>Warga RW 02 Padangsari</span>
											</li>
											<li class="mb-2 d-flex align-items-start ">
												<i class="icon icon-sm mdi mdi-check-circle-outline text-primary me-2 mt-1"></i>
												<span>Membawa KTP dan KK asli</span>
											</li>
											<li class="d-flex align-items-start ">
												<i class="icon icon-sm mdi mdi-check-circle-outline text-primary me-2 mt-1"></i>
												<span>Bersedia memilah sampah sesuai ketentuan</span>
											</li>
										</ul>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="d-flex align-items-start">
									<div class="bg-soft-primary rounded-circle p-2 me-4">
										<i class="mdi mdi-file-document-outline text-primary icon icon-md"></i>
									</div>
									<div>
										<h5 class="fw-bold mb-3 text-start">Dokumen Dibutuhkan</h5>
										<ul class="list-unstyled text-start">
											<li class="mb-2 d-flex align-items-start">
												<i class="icon icon-sm mdi mdi-file-account text-primary me-2 mt-1"></i>
												<span>Fotokopi KTP</span>
											</li>
											<li class="mb-2 d-flex align-items-start">
												<i class="icon icon-sm mdi mdi-home-account text-primary me-2 mt-1"></i>
												<span>Fotokopi KK</span>
											</li>
											<li class="d-flex align-items-start">
												<i class="icon icon-sm mdi mdi-camera text-primary me-2 mt-1"></i>
												<span>Pas foto 3x4 (2 lembar)</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="text-center mt-5">
							<a href="<?= base_url('Auth-Register') ?>" class="btn btn-primary btn-lg rounded-pill px-5">
								<i class="icon icon-md mdi mdi-account-plus me-2"></i> Daftar Sekarang
							</a>
							<p class="small  mt-3">Pendaftaran juga bisa melalui Ketua PKK RT masing-masing</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Articles Section -->
<section class="py-6 bg-light" id="artikel">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 text-center">
				<h2 class="display-5 fw-bold mb-3">Artikel Terbaru</h2>
				<p class="lead ">Informasi dan tips terbaru tentang pengelolaan sampah dan kegiatan Bank Sampah</p>
			</div>
		</div>

		<div class="row h-100 justify-content-center pt-6">
			<?php $CI = &get_instance(); ?>
			<?php if (is_array($karya) || is_object($karya)) : ?>
				<?php foreach ($karya as $a) : ?>
					<div class="col-12 col-sm-9 col-md-4 mb-4">
						<div class="shadow-sm rounded-3 hover-top h-100">
							<div class="card h-100 rounded shadow-sm border-0 overflow-hidden ">
								<!-- Card Image -->
								<div class="position-relative overflow-hidden" style="height: 300px; ">
									<img class="card-img-top w-100 h-100 object-fit-cover" src="<?= base_url('assets/uploads/karya/') . htmlspecialchars($a->gambar) ?>" alt="<?= htmlspecialchars($a->gambar_alt ?? $a->judul) ?>" loading="lazy">
									<div class="position-absolute top-0 end-0 m-2">
										<span class="badge bg-light text-dark opacity-90">
											<?= htmlspecialchars($a->kategori_nama) ?>
											<?= $a->subkategori_nama ? ' / ' . htmlspecialchars($a->subkategori_nama) : '' ?>
										</span>
									</div>
								</div>

								<!-- Card Body -->
								<div class="card-body d-flex flex-column pt-3">
									<!-- Title -->
									<h3 class="h5 card-title fw-bold mb-2 text-dark"><?= htmlspecialchars($a->judul) ?></h3>

									<!-- Excerpt -->
									<p class="card-text text-secondary mb-3 flex-grow-1">
										<?= character_limiter(strip_tags($a->excerpt ?? ''), 100) ?>
									</p>

									<!-- Metadata -->
									<div class="d-flex flex-wrap justify-content-between align-items-center  small mb-3">
										<div class="me-2 mb-1">
											<i class="mdi mdi-account-outline me-1 icon icon-sm"></i>
											upload oleh <?= htmlspecialchars($a->author) ?>
										</div>
										<div class="mb-1">
											<i class="mdi mdi-calendar me-1 icon icon-sm"></i>
											<?= $CI->_format_waktu(date('d M Y', strtotime($a->tanggal_dibuat)), 'hari, tanggal bulan tahun') ?>
										</div>
									</div>

									<!-- Footer -->
									<div class="d-flex justify-content-between align-items-center border-top pt-3">
										<a href="<?= base_url('artikel/') . url_title($a->slug ?? '') ?>" class="btn btn-link text-primary text-decoration-none p-0 ">
											Baca Selengkapnya
											<i class="mdi mdi-arrow-right ms-1 icon icon-sm"></i>
										</a>
										<div class=" small">
											<i class="mdi mdi-eye me-1 icon icon-sm"></i><?= number_format($a->read_count) ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="text-center mt-5">
				<a href="<?= base_url('artikel/semua') ?>" class="btn btn-outline-primary rounded-pill px-4">
					Lihat Semua Artikel <i class="icon icon-sm mdi mdi-arrow-right ms-2"></i>
				</a>
			</div>

		</div>


	</div>
</section>

<!-- Map Script -->
<script src="<?= base_url() ?>assets/js/Map/ol.map.js?<?= time(); ?>"></script>
<script>
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

	var data = <?= json_encode($locations); ?>;

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
				src: '<?= base_url() ?>assets/icon-svg/icon-location-pin.svg ',
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
</script>

<style>
	.hover-top {
		transition: all 0.3s ease;
	}

	.hover-top:hover {
		transform: translateY(-5px);
		box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
	}

	.object-fit-cover {
		object-fit: cover;
	}

	.bg-primary-dark {
		background-color: rgba(0, 82, 155, 0.9);
	}
</style>
