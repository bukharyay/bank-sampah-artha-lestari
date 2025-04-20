<section class="py-0">
	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/dot.png);background-position:left;background-size:auto;margin-top:-105px;">
	</div>
	<!--/.bg-holder-->

	<!-- Article Header -->
	<div class="container py-5 position-relative">
		<div class="row align-items-center">
			<div class="col-12 col-md-5 col-lg-8 pt-8">
				<!-- Breadcrumb -->
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
						<li class="breadcrumb-item"><a href="<?= base_url('artikel/semua') ?>">Artikel</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($karya->judul) ?></li>
					</ol>
				</nav>

				<!-- Article Title -->
				<h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($karya->judul) ?></h1>

				<!-- Article Meta -->
				<div class="d-flex flex-wrap align-items-center text-muted mb-4">
					<div class="me-3">
						<i class="mdi mdi-account-circle-outline me-1 align-middle"></i>
						<?= htmlspecialchars($karya->author) ?>
					</div>
					<div class="me-3">
						<i class="mdi mdi-calendar me-1 align-middle"></i>
						<?= date('d F Y', strtotime($karya->tanggal_dibuat)) ?>
					</div>
					<div>
						<i class="mdi mdi-eye me-1 align-middle"></i>
						<?= number_format($karya->read_count) ?> Dilihat
					</div>
				</div>

				<!-- Category Badge -->
				<div class="mb-4">
					<span class="badge bg-primary">
						<?= htmlspecialchars($karya->kategori_nama) ?>
						<?= $karya->subkategori_nama ? ' / ' . htmlspecialchars($karya->subkategori_nama) : '' ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="py-0">

	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/services-bg.png);background-position:center left;background-size:auto;">
	</div>
	<!--/.bg-holder-->

	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/dot-2.png);background-position:center right;background-size:auto;margin-left:-180px;margin-top:20px;">
	</div>
	<!-- Featured Image -->
	<div class="container-lg px-0 ">
		<div class="row justify-content-center">
			<div class="col-12 col-md-5 col-lg-8 text-center">
				<img src="<?= base_url('assets/uploads/karya/') . htmlspecialchars($karya->gambar) ?>" alt="<?= htmlspecialchars($karya->gambar_alt ?? $karya->judul) ?>" class="img-fluid w-50" style="max-height: 500px; object-fit: cover;">
			</div>
		</div>
	</div>



</section>

<section class="py-0">
	<!-- Article Content -->
	<div class="container py-4">

		<div class="row g-xl-0 align-items-center">
			<!-- <div class="row justify-content-center"></div> -->
			<div class="col-lg-8">
				<article class="article-content">
					<?= $karya->konten ?>
				</article>

				<!-- Share Buttons -->
				<div class="mt-5 pt-4 border-top">
					<h6 class="mb-3">Bagikan Artikel:</h6>
					<div class="d-flex gap-2">
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" class="btn btn-sm btn-outline-primary rounded-pill" target="_blank">
							<i class="mdi mdi-facebook me-1"></i> Facebook
						</a>
						<a href="https://twitter.com/intent/tweet?text=<?= urlencode($karya->judul) ?>&url=<?= current_url() ?>" class="btn btn-sm btn-outline-info rounded-pill" target="_blank">
							<i class="mdi mdi-twitter me-1"></i> Twitter
						</a>
						<a href="https://wa.me/?text=<?= urlencode("Baca artikel ini: " . $karya->judul . " " . current_url()) ?>" class="btn btn-sm btn-outline-success rounded-pill" target="_blank">
							<i class="mdi mdi-whatsapp me-1"></i> WhatsApp
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<style>
	/* Add to your stylesheet */
	.hover-effect {
		transition: transform 0.2s, box-shadow 0.2s;
	}

	.hover-effect:hover {
		transform: translateY(-2px);
		box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
	}

	.object-fit-cover {
		object-fit: cover;
	}
</style>
<!-- Related Articles -->

<section>
	<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/article-bg.png);background-position:right center;background-size:auto;">
	</div>
	<!--/.bg-holder-->

	<div class="container">
		<div class="bg-holder" style="background-image:url(<?= base_url() ?>assets/landing/img/illustrations/dot-2.png);background-position:left top;background-size:initial;margin-top:120px;margin-left:-35px;">
		</div>
		<!--/.bg-holder-->

		<div class="row flex-start px-2">
			<div class="col-auto text-start">
				<h2 class="fw-bold">Artikel Lainnya</h2>
				<hr class="me-auto text-dark" style="height:2px;width:50px" />
			</div>
		</div>


		<div class="row h-100 justify-content-start pt-6 px-2">
			<?php $CI = &get_instance(); ?>
			<?php if (is_array($related_articles) || is_object($related_articles)) : ?>
				<?php foreach ($related_articles as $related) : ?>
					<?php if ($related->id_hasil_karya != $karya->id_hasil_karya) : ?>
						<div class="col-12 col-sm-9 col-md-4 mb-4">
							<div class="shadow-sm rounded-3 hover-effect">
								<div class="card h-100 rounded shadow-sm border-0 overflow-hidden ">
									<!-- Card Image -->
									<div class="position-relative overflow-hidden" style="height: 300px; ">
										<img class="card-img-top w-100 h-100 object-fit-cover" src="<?= base_url('assets/uploads/karya/') . htmlspecialchars($related->gambar) ?>" alt="<?= htmlspecialchars($related->gambar_alt ?? $related->judul) ?>" loading="lazy">
										<div class="position-absolute top-0 end-0 m-2">
											<span class="badge bg-light text-dark opacity-90">
												<?= htmlspecialchars($related->kategori_nama) ?>
												<?= $related->subkategori_nama ? ' / ' . htmlspecialchars($related->subkategori_nama) : '' ?>
											</span>
										</div>
									</div>

									<!-- Card Body -->
									<div class="card-body d-flex flex-column pt-3">
										<!-- Title -->
										<h3 class="h5 card-title fw-bold mb-2 text-dark"><?= htmlspecialchars($related->judul) ?></h3>

										<!-- Excerpt -->
										<p class="card-text text-secondary mb-3 flex-grow-1">
											<?= character_limiter(strip_tags($related->excerpt ?? ''), 100) ?>
										</p>

										<!-- Metadata -->
										<div class="d-flex flex-wrap justify-content-between align-items-center  small mb-3">
											<div class="me-2 mb-1">
												<i class="mdi mdi-account-outline me-1 align-middle"></i>
												upload oleh <?= htmlspecialchars($related->author) ?>
											</div>
											<div class="mb-1">
												<i class="mdi mdi-calendar me-1 align-middle"></i>
												<?= $CI->_format_waktu(date('d M Y', strtotime($related->tanggal_dibuat)), 'hari, bulan tahun') ?>
											</div>
										</div>

										<!-- Footer -->
										<div class="d-flex justify-content-between align-items-center border-top pt-3">
											<a href="<?= base_url('artikel/') . url_title($related->slug ?? '') ?>" class="btn btn-link text-primary text-decoration-none p-0 ">
												Baca Selengkapnya
												<i class="mdi mdi-arrow-right ms-1 align-middle"></i>
											</a>
											<div class=" small">
												<i class="mdi mdi-eye me-1 align-middle"></i><?= number_format($related->read_count) ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="text-center pt-4 z-index-2">
				<a href="<?= base_url('artikel/semua') ?>" class="btn btn-lg btn-outline-primary rounded-pill z-index-2 hover-top" type="submit">Lihat Semua</a>
			</div>

		</div>
	</div>
</section>
