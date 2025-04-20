<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); ?>

<section class="py-0" id="struktur">
  <div class="bg-holder"
       style="background-image:url(<?= base_url () ?>assets/landing/img/illustrations/dot.png);background-position:left;background-size:auto;margin-top:-105px;">
  </div>

  <div class="container position-relative py-5">
    <div class="row justify-content-center">
      <div class="col-12 text-center pt-8">
        <h1 class="display-5 fw-bold mb-3">Struktur Organisasi</h1>
        <p class="lead ">Tim profesional yang mengelola Bank Sampah Artha Lestari RW 02 Padangsari, Semarang
        </p>
      </div>
    </div>
  </div>
</section>

<section class="pb-8 pt-4">
  <div class="container">
    <!-- Organizational Chart -->
    <div class="row justify-content-center mb-6">
      <div class="col-12 text-center mb-5">
        <h2 class="fw-bold mb-3">Diagram Struktur Organisasi</h2>
        <p class=" w-lg-50 mx-auto">Struktur kepengurusan yang jelas untuk pengelolaan bank sampah yang
          efektif dan transparan</p>
      </div>
      <div class="col-lg-10 text-center">
        <div class="card shadow-sm border-0 overflow-hidden">
          <div class="card-body p-4">
            <img src="<?= base_url () ?>assets/landing/img/illustrations/organization-chart.webp"
                 alt="Struktur Organisasi Bank Sampah Artha Lestari" class="img-fluid rounded">
          </div>
        </div>
      </div>
    </div>

    <!-- Leadership Team -->
    <div class="row justify-content-center mb-6">
      <div class="col-12 text-center mb-5">
        <h2 class="fw-bold mb-3">Dewan Pengurus</h2>
        <p class=" w-lg-50 mx-auto">Tim inti yang bertanggung jawab atas pengelolaan bank sampah</p>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0 text-center hover-top">
          <div class="card-body p-4">
            <div class="avatar avatar-xl position-relative mb-3">
              <img src="<?= base_url () ?>assets/landing/img/gallery/cornelia-eka-susana.png"
                   class="rounded-circle border border-3 border-primary shadow" alt="Ketua UMKM">
              <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2">
                <i class="icon icon-md mdi mdi-crown"></i>
              </span>
            </div>
            <h5 class="fw-bold mb-1">Cornelia Eka Susana</h5>
            <p class="fw-bold text-primary mb-2">Ketua UMKM</p>
            <p class=" small">Memimpin seluruh kegiatan bank sampah dan koordinasi dengan pihak terkait</p>
            <div class="mt-3">
              <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Kontak</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0 text-center hover-top">
          <div class="card-body p-4">
            <div class="avatar avatar-xl position-relative mb-3">
              <img src="<?= base_url () ?>assets/landing/img/gallery/nb-siswatyartha.png"
                   class="rounded-circle border border-3 border-primary shadow" alt="Pengelola">
              <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2">
                <i class="icon icon-md mdi mdi-cogs"></i>
              </span>
            </div>
            <h5 class="fw-bold mb-1">NB Siswatyartha</h5>
            <p class="fw-bold text-primary mb-2">Pengelola Utama</p>
            <p class=" small">Mengelola operasional harian bank sampah dan koordinasi dengan mitra</p>
            <div class="mt-3">
              <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Kontak</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0 text-center hover-top">
          <div class="card-body p-4">
            <div class="avatar avatar-xl position-relative mb-3">
              <img src="<?= base_url () ?>assets/landing/img/gallery/default.png"
                   class="rounded-circle border border-3 border-primary shadow" alt="Bendahara">
              <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2">
                <i class="icon icon-md mdi mdi-cash-multiple"></i>
              </span>
            </div>
            <h5 class="fw-bold mb-1">Robert Johnson</h5>
            <p class="fw-bold text-primary mb-2">Bendahara</p>
            <p class=" small">Mengelola keuangan, pencatatan transaksi, dan laporan keuangan</p>
            <div class="mt-3">
              <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Kontak</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PKK Team -->
    <div class="row justify-content-center">
      <div class="col-12 text-center mb-5">
        <h2 class="fw-bold mb-3">Koordinator PKK RT</h2>
        <p class=" w-lg-50 mx-auto">Ketua PKK masing-masing RT yang bertanggung jawab atas pengelolaan di
          wilayahnya</p>
      </div>

      <?php
      $pkk_team = [ 
        [ 'name' => 'Dewi Sartika', 'rt' => '01' ],
        [ 'name' => 'Siti Aminah', 'rt' => '02' ],
        [ 'name' => 'Rina Wijaya', 'rt' => '03' ],
        [ 'name' => 'Linda Permata', 'rt' => '04' ],
        [ 'name' => 'Ani Setiawan', 'rt' => '05' ],
        [ 'name' => 'Budi Santoso', 'rt' => '06' ],
        [ 'name' => 'Eka Pratiwi', 'rt' => '07' ],
        [ 'name' => 'Fajar Nugroho', 'rt' => '08' ],
        [ 'name' => 'Gita Wulandari', 'rt' => '09' ],
      ];

      foreach ( $pkk_team as $member ) : ?>
      <div class="col-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body p-3">
            <div class="avatar avatar-lg mb-3">
              <img src="<?= base_url () ?>assets/landing/img/gallery/default.png"
                   class="rounded-circle border border-2 border-primary" alt="<?= $member[ 'name' ] ?>">
            </div>
            <h6 class="fw-bold mb-1"><?= $member[ 'name' ] ?></h6>
            <p class="small text-primary mb-1">Ketua PKK RT <?= $member[ 'rt' ] ?></p>
            <p class="small ">Koordinator wilayah RT <?= $member[ 'rt' ] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<style>
.hover-top {
  transition: all 0.2s ease;
}

.hover-top:hover {
  transform: translateY(-5px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
}

.avatar {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.avatar img {
  width: 100%;
  height: auto;
}

.avatar-xl {
  width: 120px;
  height: 120px;
}

.avatar-lg {
  width: 80px;
  height: 80px;
}
</style>