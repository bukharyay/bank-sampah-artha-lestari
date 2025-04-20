<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); ?>

<section class="py-0">
  <div class="bg-holder"
       style="background-image:url(<?= base_url () ?>assets/landing/img/illustrations/dot.png);background-position:left;background-size:auto;margin-top:-105px;">
  </div>
  <!--/.bg-holder-->

  <div class="container position-relative py-5">
    <div class="row justify-content-center">
      <div class="col-12 text-center pt-8">
        <h1 class="display-5 fw-bold mb-3">
          <?= isset ( $active_category_name ) ? 'Artikel ' . $active_category_name : 'Semua Artikel' ?>
          <?= isset ( $active_subcategory_name ) ? '/ ' . $active_subcategory_name : '' ?>
        </h1>
        <p class="lead">Temukan berbagai artikel menarik tentang pengelolaan sampah dan lingkungan</p>
      </div>
    </div>
  </div>
</section>

<section class="py-0">
  <div class="bg-holder"
       style="background-image:url(<?= base_url () ?>assets/landing/img/illustrations/services-bg.png);background-position:center left;background-size:auto;">
  </div>
  <!--/.bg-holder-->

  <div class="bg-holder"
       style="background-image:url(<?= base_url () ?>assets/landing/img/illustrations/dot-2.png);background-position:center right;background-size:auto;margin-left:-180px;margin-top:20px;">
  </div>
  <!--/.bg-holder-->

  <div class="container-lg py-5">
    <div class="row">
      <!-- Filter Section -->
      <div class="col-md-4 col-lg-3 mb-4">
        <div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 100px;">
          <div class="card-body">
            <h5 class="card-title fw-bold mb-4">Filter Artikel</h5>

            <!-- Category Filter -->
            <div class="mb-4">
              <h6 class="fw-bold mb-3">Kategori Sampah</h6>
              <div class="list-group list-group-flush">
                <a href="<?= base_url ( 'artikel/semua' ) ?>"
                   class="list-group-item list-group-item-action border-0 rounded px-2 py-2 <?= ! isset ( $active_category ) ? 'active' : '' ?>">
                  Semua Kategori
                  <span class="badge bg-primary float-end"><?= $total_articles ?></span>
                </a>
                <?php foreach ( $categories as $category ) : ?>
                <?php
                  // Encode nama kategori untuk URL
                  $category_url = str_replace ( '/', '--', $category->jenis_sampah );
                  ?>
                <a href="<?= base_url ( 'artikel/kategori/' ) . $category_url ?>"
                   class="list-group-item list-group-item-action border-0 rounded px-2 py-2 <?= isset ( $active_category ) && $active_category == $category->id_jenis_sampah ? 'active' : '' ?>">
                  <?= htmlspecialchars ( $category->jenis_sampah ) ?>
                  <span class="badge bg-primary float-end"><?= $category->article_count ?></span>
                </a>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Subcategory Filter (if category is selected) -->
            <?php if ( isset ( $active_category ) && ! empty ( $subcategories ) ) : ?>
            <div class="mb-4">
              <h6 class="fw-bold mb-3">Jenis Sampah</h6>
              <div class="list-group list-group-flush">
                <a href="<?= base_url ( 'artikel/kategori/' ) . url_title ( $active_category_name ) ?>"
                   class="list-group-item list-group-item-action border-0 rounded px-2 py-2 <?= ! isset ( $active_subcategory ) ? 'active' : '' ?>">
                  Semua Jenis
                </a>
                <?php foreach ( $subcategories as $sub ) : ?>
                <?php
                    // Encode nama subkategori untuk URL
                    $subcategory_url = url_title ( str_replace ( '/', '--', $sub->nama_sampah ), '-', TRUE );
                    $category_url    = url_title ( str_replace ( '/', '--', $active_category_name ), '-', TRUE );
                    ?>
                <a href="<?= base_url ( 'artikel/kategori/' ) . $category_url . '/' . $subcategory_url ?>"
                   class="list-group-item list-group-item-action border-0 rounded px-2 py-2 <?= isset ( $active_subcategory ) && $active_subcategory == $sub->id_sampah ? 'active' : '' ?>">
                  <?= htmlspecialchars ( $sub->nama_sampah ) ?>
                  <span class="badge bg-primary float-end"><?= $sub->article_count ?></span>

                </a>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Articles List -->
      <div class="col-md-8 col-lg-9">
        <div class="row g-4">
          <?php if ( ! empty ( $karya ) ) : ?>
          <?php foreach ( $karya as $a ) : ?>
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 rounded shadow-sm border-0 overflow-hidden hover-effect">
              <!-- Card Image -->
              <div class="position-relative" style="height: 200px; overflow: hidden;">
                <img class="w-100 h-100 object-fit-cover"
                     src="<?= base_url ( 'assets/uploads/karya/' ) . htmlspecialchars ( $a->gambar ) ?>"
                     alt="<?= htmlspecialchars ( $a->gambar_alt ?? $a->judul ) ?>" loading="lazy">
                <div class="position-absolute top-0 end-0 m-2">
                  <span class="badge bg-light text-dark opacity-90">
                    <?= htmlspecialchars ( $a->kategori_nama ) ?>
                    <?= $a->subkategori_nama ? '/' . htmlspecialchars ( $a->subkategori_nama ) : '' ?>
                  </span>
                </div>
              </div>

              <!-- Card Body -->
              <div class="card-body d-flex flex-column">
                <!-- Title -->
                <h3 class="h5 card-title fw-bold mb-2">
                  <a href="<?= base_url ( 'artikel/' ) . url_title ( $a->slug ?? '' ) ?>"
                     class="text-dark text-decoration-none stretched-link">
                    <?= htmlspecialchars ( $a->judul ) ?>
                  </a>
                </h3>

                <!-- Excerpt -->
                <p class="card-text text-secondary mb-3 flex-grow-1">
                  <?= character_limiter ( strip_tags ( $a->excerpt ?? '' ), 100 ) ?>
                </p>

                <!-- Metadata -->
                <div class="d-flex justify-content-between align-items-center text-muted small">
                  <div>
                    <i class="mdi mdi-calendar me-1"></i>
                    <?= date ( 'd M Y', strtotime ( $a->tanggal_dibuat ) ) ?>
                  </div>
                  <div>
                    <i class="mdi mdi-eye me-1"></i>
                    <?= number_format ( $a->read_count ) ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php else : ?>
          <div class="col-12">
            <div class="alert alert-info text-center py-5">
              <i class="mdi mdi-information-outline fs-7"></i>
              <h4 class="mt-3">Tidak ada artikel ditemukan</h4>
              <p class="mb-0">Silakan coba dengan filter yang berbeda</p>
            </div>
          </div>
          <?php endif; ?>
        </div>


        <!-- Pagination -->
        <?php if ( isset ( $pagination ) ) : ?>
        <div class="row mt-5">
          <div class="col-12">
            <?= $pagination ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<style>
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

.sticky-top {
  position: -webkit-sticky;
  position: sticky;
}

.list-group-item.active {
  background-color: #f8f9fa;
  color: #0d6efd;
  border-left: 3px solid #0d6efd;
}
</style>